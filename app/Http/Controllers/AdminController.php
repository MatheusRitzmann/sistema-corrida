<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Página principal da área admin
    public function index()
    {
        $totalUsuarios = User::where('role', 'user')->count();
        $usuariosMes   = User::where('role', 'user')
                            ->whereMonth('created_at', Carbon::now()->month)
                            ->count();

        // Dados para o gráfico — últimos 6 meses
        $meses  = [];
        $totais = [];

        for ($i = 5; $i >= 0; $i--) {
            $data     = Carbon::now()->subMonths($i);
            $meses[]  = $data->translatedFormat('M/y');
            $totais[] = User::whereMonth('created_at', $data->month)
                            ->whereYear('created_at', $data->year)
                            ->count();
        }

        $graficoDados = [
            'meses'  => $meses,
            'totais' => $totais,
        ];

        return view('admin.index', compact(
            'totalUsuarios', 'usuariosMes', 'graficoDados'
        ));
    }

    // Página principal da área master
    public function master()
    {
        $admins        = User::where('role', 'admin')->get();
        $totalUsuarios = User::where('role', 'user')->count();
        $totalAdmins   = User::where('role', 'admin')->count();
        $usuariosMes   = User::where('role', 'user')
                            ->whereMonth('created_at', Carbon::now()->month)
                            ->count();

        // Dados para o gráfico — últimos 6 meses
        $meses  = [];
        $totais = [];

        for ($i = 5; $i >= 0; $i--) {
            $data     = Carbon::now()->subMonths($i);
            $meses[]  = $data->translatedFormat('M/y');
            $totais[] = User::whereMonth('created_at', $data->month)
                            ->whereYear('created_at', $data->year)
                            ->count();
        }

        $graficoDados = [
            'meses'  => $meses,
            'totais' => $totais,
        ];

        return view('master.index', compact(
            'admins', 'totalUsuarios', 'totalAdmins', 'usuariosMes', 'graficoDados'
        ));
    }

    // Página de criar admin
    public function criarAdminView()
    {
        return view('master.criar-admin');
    }

    // Processa a criação do admin
    public function criarAdmin(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
        ]);

        return redirect()->route('master.index')->with('sucesso', 'Administrador criado com sucesso!');
    }
}