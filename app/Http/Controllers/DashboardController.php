<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostComment;

class DashboardController extends Controller
{
    // Exibe o dashboard do usuário
    public function index()
    {
        $userId = Auth::id();

        $posts = Post::with(['user', 'likes', 'comments'])
                    ->orderBy('created_at', 'desc')
                    ->get();

        // Métricas do usuário
        $totalKm       = Post::where('user_id', $userId)->sum('distancia');
        $totalCorridas = Post::where('user_id', $userId)->count();
        $totalTempo    = Post::where('user_id', $userId)->sum('duracao');
        $paceMedia     = Post::where('user_id', $userId)->whereNotNull('pace')->value('pace') ?? '—';

        // Gráfico — últimas 8 semanas
        $semanas = [];
        $km      = [];

        for ($i = 7; $i >= 0; $i--) {
            $inicio    = now()->subWeeks($i)->startOfWeek();
            $fim       = now()->subWeeks($i)->endOfWeek();
            $semanas[] = 'S' . (8 - $i);
            $km[]      = (float) Post::where('user_id', $userId)
                            ->whereBetween('created_at', [$inicio, $fim])
                            ->sum('distancia');
        }

        $graficoDados = ['semanas' => $semanas, 'km' => $km];

        return view('usuario.dashboard', compact(
            'posts', 'totalKm', 'totalCorridas', 'totalTempo', 'paceMedia', 'graficoDados'
        ));
    }

    // Publica um novo post
    public function publicar(Request $request)
    {
        $request->validate([
            'titulo'    => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'distancia' => 'nullable|numeric',
            'duracao'   => 'nullable|integer',
            'pace'      => 'nullable|string',
        ]);

        Post::create([
            'user_id'   => Auth::id(),
            'titulo'    => $request->titulo,
            'descricao' => $request->descricao,
            'distancia' => $request->distancia,
            'duracao'   => $request->duracao,
            'pace'      => $request->pace,
        ]);

        return redirect()->route('usuario.dashboard')->with('sucesso', 'Publicação criada com sucesso!');
    }

    // Curtir ou descurtir post
    public function like($postId)
    {
        $like = PostLike::where('post_id', $postId)
                        ->where('user_id', Auth::id())
                        ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            PostLike::create([
                'post_id' => $postId,
                'user_id' => Auth::id(),
            ]);
            $liked = true;
        }

        $total = PostLike::where('post_id', $postId)->count();

        return response()->json(['liked' => $liked, 'total' => $total]);
    }

    // Comentar em um post
    public function comentar(Request $request, $postId)
    {
        $request->validate([
            'comentario' => 'required|string|max:500',
        ]);

        $comment = PostComment::create([
            'post_id'    => $postId,
            'user_id'    => Auth::id(),
            'comentario' => $request->comentario,
        ]);

        $comment->load('user');

        return response()->json([
            'comentario' => $comment->comentario,
            'user'       => $comment->user->name,
            'created_at' => $comment->created_at->diffForHumans(),
        ]);
    }
}