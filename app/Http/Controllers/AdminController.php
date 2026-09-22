<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Corrida;
use App\Models\Inscricao;
use App\Models\Post;
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
        $totalCorridas    = Corrida::count();
        $totalInscricoes  = Inscricao::where('status', 'confirmado')->count();
        $receitaTotal     = Inscricao::where('status', 'confirmado')->sum('valor_pago');

        // Gráfico — últimos 6 meses de usuários
        $meses  = [];
        $totais = [];
        for ($i = 5; $i >= 0; $i--) {
            $data     = Carbon::now()->subMonths($i);
            $meses[]  = $data->translatedFormat('M/y');
            $totais[] = User::where('role', 'user')
                            ->whereMonth('created_at', $data->month)
                            ->whereYear('created_at', $data->year)
                            ->count();
        }

        // Gráfico — inscrições por corrida
        $corridas       = Corrida::withCount(['inscricoes' => function($q) {
                            $q->where('status', 'confirmado');
                        }])->orderBy('inscricoes_count', 'desc')->take(5)->get();
        $corridasNomes  = $corridas->pluck('nome')->toArray();
        $corridasCounts = $corridas->pluck('inscricoes_count')->toArray();

        // Gráfico — receita por mês
        $mesesReceita  = [];
        $valoresReceita = [];
        for ($i = 5; $i >= 0; $i--) {
            $data            = Carbon::now()->subMonths($i);
            $mesesReceita[]  = $data->translatedFormat('M/y');
            $valoresReceita[] = (float) Inscricao::where('status', 'confirmado')
                                ->whereMonth('created_at', $data->month)
                                ->whereYear('created_at', $data->year)
                                ->sum('valor_pago');
        }

        $graficoDados = [
            'meses'          => $meses,
            'totais'         => $totais,
            'corridasNomes'  => $corridasNomes,
            'corridasCounts' => $corridasCounts,
            'mesesReceita'   => $mesesReceita,
            'valoresReceita' => $valoresReceita,
        ];

        return view('admin.index', compact(
            'totalUsuarios', 'usuariosMes', 'totalCorridas',
            'totalInscricoes', 'receitaTotal', 'graficoDados'
        ));
    }

    // Página principal da área master
    public function master()
    {
        $admins        = User::where('role', 'admin')->get();
        $totalUsuarios = User::where('role', 'user')->count();
        $totalAdmins   = User::where('role', 'admin')->count();
        $totalCorridas    = Corrida::count();
        $totalInscricoes  = Inscricao::where('status', 'confirmado')->count();
        $receitaTotal     = Inscricao::where('status', 'confirmado')->sum('valor_pago');
        $usuariosMes   = User::where('role', 'user')
                            ->whereMonth('created_at', Carbon::now()->month)
                            ->count();

        // Gráfico — últimos 6 meses de usuários
        $meses  = [];
        $totais = [];
        for ($i = 5; $i >= 0; $i--) {
            $data     = Carbon::now()->subMonths($i);
            $meses[]  = $data->translatedFormat('M/y');
            $totais[] = User::where('role', 'user')
                            ->whereMonth('created_at', $data->month)
                            ->whereYear('created_at', $data->year)
                            ->count();
        }

        // Gráfico — inscrições por corrida
        $corridas       = Corrida::withCount(['inscricoes' => function($q) {
                            $q->where('status', 'confirmado');
                        }])->orderBy('inscricoes_count', 'desc')->take(5)->get();
        $corridasNomes  = $corridas->pluck('nome')->toArray();
        $corridasCounts = $corridas->pluck('inscricoes_count')->toArray();

        // Gráfico — receita por mês
        $mesesReceita   = [];
        $valoresReceita = [];
        for ($i = 5; $i >= 0; $i--) {
            $data             = Carbon::now()->subMonths($i);
            $mesesReceita[]   = $data->translatedFormat('M/y');
            $valoresReceita[] = (float) Inscricao::where('status', 'confirmado')
                                ->whereMonth('created_at', $data->month)
                                ->whereYear('created_at', $data->year)
                                ->sum('valor_pago');
        }

        $graficoDados = [
            'meses'          => $meses,
            'totais'         => $totais,
            'corridasNomes'  => $corridasNomes,
            'corridasCounts' => $corridasCounts,
            'mesesReceita'   => $mesesReceita,
            'valoresReceita' => $valoresReceita,
        ];

        return view('master.index', compact(
            'admins', 'totalUsuarios', 'totalAdmins', 'usuariosMes',
            'totalCorridas', 'totalInscricoes', 'receitaTotal', 'graficoDados'
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