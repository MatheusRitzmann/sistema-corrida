@extends('layouts.usuario')

@section('title', 'Dashboard')

@section('content')

    <!-- Mensagem de sucesso -->
    @if (session('sucesso'))
        <div class="alert alert-success rounded-3 mb-3">{{ session('sucesso') }}</div>
    @endif

    <!-- Métricas -->
    <div class="row g-2 mb-3">
        <div class="col-6 col-md-3">
            <div class="vx-mc">
                <div class="vx-mc-bar" style="background:#2C8CE8;"></div>
                <div class="vx-mc-label"><i class="ri-route-line"></i> Total km</div>
                <div class="vx-mc-val">
                    {{ number_format($totalKm, 1) }}<span class="vx-mc-unit">km</span>
                </div>
                <div class="vx-mc-delta up">↑ este mês</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="vx-mc">
                <div class="vx-mc-bar" style="background:#22c78a;"></div>
                <div class="vx-mc-label"><i class="ri-run-line"></i> Corridas</div>
                <div class="vx-mc-val">{{ $totalCorridas }}</div>
                <div class="vx-mc-delta up">↑ este mês</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="vx-mc">
                <div class="vx-mc-bar" style="background:#f59e0b;"></div>
                <div class="vx-mc-label"><i class="ri-time-line"></i> Tempo</div>
                <div class="vx-mc-val">
                    {{ $totalTempo }}<span class="vx-mc-unit">min</span>
                </div>
                <div class="vx-mc-delta up">↑ este mês</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="vx-mc">
                <div class="vx-mc-bar" style="background:#e24b4a;"></div>
                <div class="vx-mc-label"><i class="ri-heart-pulse-line"></i> Pace médio</div>
                <div class="vx-mc-val">
                    {{ $paceMedia }}<span class="vx-mc-unit">/km</span>
                </div>
                <div class="vx-mc-delta">média geral</div>
            </div>
        </div>
    </div>

    <!-- Feed + Gráfico -->
    <div class="row g-3">

        <!-- Feed -->
        <div class="col-12 col-md-7">

            <!-- Botão publicar -->
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="vx-card-title mb-0">
                    <i class="ri-rss-line"></i> Feed
                </div>
                <button class="btn btn-sm" id="pubBtn"
                    style="background:#2C8CE8;color:#fff;border-radius:8px;font-size:12px;font-weight:600;padding:7px 14px;border:none;">
                    <i class="ri-add-line"></i> Publicar
                </button>
            </div>

            <!-- Modal publicar -->
            <div id="pubModal" style="display:none;" class="vx-card mb-3">
                <div class="vx-card-title"><i class="ri-pencil-line"></i> Nova publicação</div>
                <form action="{{ route('usuario.publicar') }}" method="POST">
                    @csrf
                    <input name="titulo" class="vx-cinput w-100 mb-2 d-block"
                           style="border-radius:8px;" placeholder="Título da corrida (ex: Corrida matinal)" required>
                    <textarea name="descricao"
                        style="width:100%;border:1px solid #e8ecf5;border-radius:8px;padding:8px 12px;font-size:13px;font-family:'Inter',sans-serif;background:#f7f9fd;outline:none;resize:none;height:70px;box-sizing:border-box;display:block;"
                        placeholder="Como foi o treino?"></textarea>
                    <div class="row g-2 mt-1">
                        <div class="col-4">
                            <input name="distancia" class="vx-cinput w-100 text-center"
                                   style="border-radius:8px;" placeholder="Distância (km)">
                        </div>
                        <div class="col-4">
                            <input name="duracao" class="vx-cinput w-100 text-center"
                                   style="border-radius:8px;" placeholder="Duração (min)">
                        </div>
                        <div class="col-4">
                            <input name="pace" class="vx-cinput w-100 text-center"
                                   style="border-radius:8px;" placeholder="Pace (5:30)">
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3 justify-content-end">
                        <button type="button" onclick="document.getElementById('pubModal').style.display='none'"
                            style="background:#f4f6fb;border:1px solid #e8ecf5;border-radius:8px;padding:7px 14px;font-size:12px;font-family:'Inter',sans-serif;color:#888;cursor:pointer;">
                            Cancelar
                        </button>
                        <button type="submit"
                            style="background:#2C8CE8;border:none;border-radius:8px;padding:7px 16px;font-size:12px;font-family:'Inter',sans-serif;color:#fff;cursor:pointer;font-weight:600;">
                            Publicar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Posts -->
            <div id="feedPosts">
                @forelse ($posts as $post)
                    <div class="vx-post">
                        <div class="vx-post-head">
                            <div class="vx-post-av" style="background:#2C8CE820;color:#2C8CE8;">
                                {{ strtoupper(substr($post->user->name, 0, 2)) }}
                            </div>
                            <div>
                                <div class="vx-post-name">{{ $post->user->name }}</div>
                                <div class="vx-post-time">{{ $post->created_at->diffForHumans() }}</div>
                            </div>
                            <span class="vx-post-type">
                                <i class="ri-run-line" style="font-size:11px"></i> Corrida
                            </span>
                        </div>

                        <div class="vx-post-title">{{ $post->titulo }}</div>

                        @if($post->descricao)
                            <div class="vx-post-desc">{{ $post->descricao }}</div>
                        @endif

                        @if($post->distancia || $post->duracao || $post->pace)
                            <div class="vx-post-stats">
                                <div class="vx-pstat">
                                    <div class="vx-pstat-val">{{ $post->distancia ?? '—' }} km</div>
                                    <div class="vx-pstat-label">Distância</div>
                                </div>
                                <div class="vx-pstat">
                                    <div class="vx-pstat-val">{{ $post->duracao ?? '—' }} min</div>
                                    <div class="vx-pstat-label">Duração</div>
                                </div>
                                <div class="vx-pstat">
                                    <div class="vx-pstat-val">{{ $post->pace ?? '—' }}/km</div>
                                    <div class="vx-pstat-label">Pace médio</div>
                                </div>
                            </div>
                        @endif

                        <!-- Ações -->
                        <div class="vx-post-actions">
                            <button class="vx-act-btn {{ $post->likedBy(Auth::id()) ? 'liked' : '' }}"
                                    id="like-btn-{{ $post->id }}"
                                    onclick="toggleLike({{ $post->id }})">
                                <i class="ri-heart-{{ $post->likedBy(Auth::id()) ? 'fill' : 'line' }}"></i>
                                <span id="like-count-{{ $post->id }}">{{ $post->likes->count() }}</span> curtidas
                            </button>
                            <button class="vx-act-btn" onclick="focusInput('comment-input-{{ $post->id }}')">
                                <i class="ri-message-circle-line"></i>
                                {{ $post->comments->count() }} comentários
                            </button>
                        </div>

                        <!-- Comentários -->
                        <div class="vx-comments" id="comments-{{ $post->id }}">
                            @foreach($post->comments as $comment)
                                <div class="vx-comment">
                                    <div class="vx-post-av" style="background:#2C8CE820;color:#2C8CE8;width:28px;height:28px;font-size:10px;">
                                        {{ strtoupper(substr($comment->user->name, 0, 2)) }}
                                    </div>
                                    <div class="vx-comment-bubble">
                                        <div class="vx-comment-author">{{ $comment->user->name }}</div>
                                        <div class="vx-comment-text">{{ $comment->comentario }}</div>
                                        <div class="vx-comment-time">{{ $comment->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Input comentário -->
                        <div class="vx-comment-input">
                            <div class="vx-post-av" style="background:#2C8CE820;color:#2C8CE8;width:28px;height:28px;font-size:10px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <input class="vx-cinput" id="comment-input-{{ $post->id }}"
                                   placeholder="Escreva um comentário..."
                                   onkeydown="if(event.key==='Enter') addComment({{ $post->id }})">
                            <button class="vx-send-btn" onclick="addComment({{ $post->id }})">
                                <i class="ri-send-plane-fill"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="vx-card text-center text-muted py-4">
                        Nenhuma publicação ainda. Seja o primeiro a publicar! 
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Sidebar direita -->
        <div class="col-12 col-md-5">

            <!-- Gráfico -->
            <div class="vx-card mb-3">
                <div class="vx-card-title"><i class="ri-bar-chart-line"></i> Evolução semanal</div>
                <div style="height:160px;">
                    <canvas id="evoChart"></canvas>
                </div>
            </div>

            <!-- Atividades recentes -->
            <div class="vx-card">
                <div class="vx-card-title"><i class="ri-history-line"></i> Atividades recentes</div>
                <div style="display:flex;flex-direction:column;gap:7px;">
                    @forelse($posts->take(3) as $post)
                        <div style="display:flex;align-items:center;gap:10px;background:#f7f9fd;border-radius:10px;padding:9px 11px;">
                            <div style="width:32px;height:32px;background:#2C8CE815;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="ri-run-line" style="font-size:17px;color:#2C8CE8;"></i>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div style="font-size:13px;font-weight:600;color:#1a1a1a;">{{ $post->titulo }}</div>
                                <div style="font-size:11px;color:#999;">{{ $post->created_at->format('d/m/Y') }}</div>
                            </div>
                            <div style="text-align:right;">
                                <div style="font-size:15px;font-weight:800;color:#1a1a1a;">{{ $post->distancia ?? '—' }} km</div>
                                <div style="font-size:11px;color:#aaa;">{{ $post->pace ?? '—' }}/km</div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center" style="font-size:13px;">Nenhuma atividade ainda.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
<script>
    // Gráfico de evolução semanal
    const ctx = document.getElementById('evoChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($graficoDados['semanas']),
            datasets: [{
                data: @json($graficoDados['km']),
                backgroundColor: (c) => c.dataIndex === @json(count($graficoDados['semanas']) - 1) ? '#2C8CE8' : '#2C8CE830',
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false }, ticks: { color: '#bbb', font: { size: 11, family: 'Inter' } } },
                y: { grid: { color: '#f0f2f8' }, ticks: { color: '#bbb', font: { size: 11, family: 'Inter' }, callback: v => v + 'km' }, beginAtZero: true }
            }
        }
    });

    // Toggle publicar
    document.getElementById('pubBtn').onclick = () => {
        const m = document.getElementById('pubModal');
        m.style.display = m.style.display === 'none' ? 'block' : 'none';
    };

    // Curtir post
    function toggleLike(postId) {
        fetch(`/dashboard/like/${postId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            const btn = document.getElementById(`like-btn-${postId}`);
            const count = document.getElementById(`like-count-${postId}`);
            count.textContent = data.total;
            btn.classList.toggle('liked', data.liked);
        });
    }

    // Focar input de comentário
    function focusInput(id) {
        document.getElementById(id).focus();
    }

    // Adicionar comentário
    function addComment(postId) {
        const input = document.getElementById(`comment-input-${postId}`);
        const text = input.value.trim();
        if (!text) return;

        fetch(`/dashboard/comentar/${postId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ comentario: text })
        })
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById(`comments-${postId}`);
            const div = document.createElement('div');
            div.className = 'vx-comment';
            div.innerHTML = `
                <div class="vx-post-av" style="background:#2C8CE820;color:#2C8CE8;width:28px;height:28px;font-size:10px;">
                    ${data.user.substring(0, 2).toUpperCase()}
                </div>
                <div class="vx-comment-bubble">
                    <div class="vx-comment-author">${data.user}</div>
                    <div class="vx-comment-text">${data.comentario}</div>
                    <div class="vx-comment-time">${data.created_at}</div>
                </div>`;
            container.appendChild(div);
            input.value = '';
        });
    }
</script>
@endsection