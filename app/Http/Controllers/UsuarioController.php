<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    /*=============== USUÁRIOS ===============*/

    // Lista todos os usuários
    public function index()
    {
        $usuarios = User::where('role', 'user')->orderBy('created_at', 'desc')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    // Exibe formulário de edição do usuário
    public function editar($id)
    {
        $usuario = User::findOrFail($id);
        return view('usuarios.editar', compact('usuario'));
    }

    // Processa a edição do usuário
    public function atualizar(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            'role'     => 'required|in:user,admin,master',
        ]);

        $usuario->name  = $request->name;
        $usuario->email = $request->email;
        $usuario->role  = $request->role;

        // Só atualiza a senha se foi preenchida
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('sucesso', 'Usuário atualizado com sucesso!');
    }

    // Deleta usuário
    public function deletar($id)
    {
        // Impede que o master delete a si mesmo
        if ($id == Auth::id()) {
            return redirect()->route('usuarios.index')->with('erro', 'Você não pode deletar sua própria conta!');
        }

        User::findOrFail($id)->delete();

        return redirect()->route('usuarios.index')->with('sucesso', 'Usuário deletado com sucesso!');
    }

    /*=============== MASTERS ===============*/

    // Lista todos os masters
    public function masters()
    {
        $masters = User::where('role', 'master')->orderBy('created_at', 'desc')->get();
        return view('master.masters', compact('masters'));
    }

    // Exibe formulário de edição do master
    public function editarMaster($id)
    {
        $master = User::findOrFail($id);
        return view('master.editar', compact('master'));
    }

    // Processa a edição do master
    public function atualizarMaster(Request $request, $id)
    {
        $master = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
        ]);

        $master->name  = $request->name;
        $master->email = $request->email;

        // Só atualiza a senha se foi preenchida
        if ($request->filled('password')) {
            $master->password = Hash::make($request->password);
        }

        $master->save();

        return redirect()->route('masters.index')->with('sucesso', 'Master atualizado com sucesso!');
    }

    // Deleta master
    public function deletarMaster($id)
    {
        // Impede que o master delete a si mesmo
        if ($id == Auth::id()) {
            return redirect()->route('masters.index')->with('erro', 'Você não pode deletar sua própria conta!');
        }

        User::findOrFail($id)->delete();

        return redirect()->route('masters.index')->with('sucesso', 'Master deletado com sucesso!');
    }
}