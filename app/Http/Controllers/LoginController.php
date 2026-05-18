<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
  
    public function index()
    {
        return view('autenticacao.login');
    }

    // Processa o login
    public function login(Request $request)
    {
        $credenciais = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credenciais)) {
    $request->session()->regenerate();
    return redirect('/'); // vai para a página inicial após login
}

        return back()->withErrors([
            'email' => 'E-mail ou senha incorretos.',
        ]);
    }

    // Processa o cadastro
    public function cadastro(Request $request)
    {
        $request->validate([
            'nome'      => 'required|string',
            'sobrenome' => 'required|string',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->nome . ' ' . $request->sobrenome,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('/login')->with('sucesso', 'Conta criada com sucesso!');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Exibe a página de cadastro
public function cadastroView()
{
    return view('autenticacao.cadastro');
}
}