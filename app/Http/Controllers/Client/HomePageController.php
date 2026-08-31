<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Announcement;
use App\Models\BenefitTopic;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogExternoWhi;
use App\Models\Contact;
use App\Models\Event;
use App\Models\Partner;
use App\Models\PopUp;
use App\Models\Report;
use App\Models\Slide;
use App\Models\Stack;
use App\Models\Topic;
use App\Models\Unionized;
use App\Models\Video;
use App\Services\FootballService;
use App\Services\WeatherService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HomePageController extends Controller
{
    public function index(WeatherService $weather, FootballService $service)
    {
        $blogSuperHighlights = Blog::whereHas('category', function($active){
            $active->where('active', 1);
        })->superHighlightOnly()->active()->sorting()->limit(6)->get();

        $blogHighlights = Blog::whereHas('category', function($active){
            $active->where('active', 1);
        })->highlightOnly()->active()->sorting()->limit(2)->get();
        $announcements = Announcement::select(
            'exhibition',
            'link',
            'exhibition',
            'path_image',
            'active',
            'sorting',
        )
        ->where('exhibition', '=', 'mobile')
        ->orWhere('exhibition', '=', 'horizontal')
        ->active()
        ->sorting()
        ->get();
        $about = About::active()->first();
        $videos = Video::active()->sorting()->get();
        $report = Report::active()->first();
        $contact = Contact::first();

        // Obter as 5 categorias mais recentes das últimas notícias
        $recentCategories = BlogCategory::whereHas('blogs', function($query) {
            $query->active()->whereHas('category', function($active) {
                $active->where('active', 1);
            });
        })
        ->withCount(['blogs' => function($query) {
            $query->active();
        }])
        ->where('active', 1)
        ->orderBy('created_at', 'DESC')
        ->take(5)
        ->get();

        // Obter as próximas 9 notícias (excluindo o destaque)
        $latestNews = Blog::whereHas('category', function($active) {
                $active->where('active', 1);
            })
            ->with(['category' => function($query) {
                $query->select('id', 'title', 'slug');
            }])
            ->orderBy('created_at', 'DESC')
            ->active()
            ->limit(12)
            ->get();

        // Pegando os IDs para excluir
        $excludedIds = $recentCategories->pluck('id');
        
        $blogRelacionados = Blog::whereHas('category')
            ->whereNotIn('blog_category_id', $excludedIds)
            ->active()
            ->sorting()
            ->take(10)
            ->get();

        $announcementVerticals = Announcement::select(
            'exhibition',
            'link',
            'exhibition',
            'path_image',
            'active',
            'sorting',
        )
        ->where('exhibition', '=', 'vertical')
        ->active()
        ->sorting()
        ->get();

        $blogCategories = BlogCategory::whereHas('blogs')->active()->sorting()->get();

        $blogNoBairros = Blog::whereHas('category', function($query) {
                $query->where('id', 1)
                ->where('active', 1);
            })
            ->with(['category' => function($query) {
                $query->select('id', 'title', 'slug');
            }])
            ->orderBy('created_at', 'DESC')
            ->active()
            ->limit(10)
            ->get();
            
        $events = Event::active()
        ->whereMonth('date', now()->month)
        ->orderBy('date', 'asc')
        ->get();
        $popUp = PopUp::active()->first();

        $tempo = cache()->remember(
            'weather_salvador',
            now()->addMinutes(30),
            fn () => $weather->current(-12.9777, -38.5016)
        );

        // $standings = $service->standings();

        // // 1. Busca no cache por 15 minutos (900 segundos) ou faz a requisição na API
        // $standings = Cache::remember('tabela_brasileirao', 900, function () {
        //     $apiKey = config('services.football_data.key', env('FOOTBALL_DATA_API_KEY'));

        //     $response = Http::withHeaders([
        //         'X-Auth-Token' => $apiKey,
        //     ])->get('https://api.football-data.org/v4/competitions/BSA/standings');

        //     if ($response->successful()) {
        //         return $response->json()['standings'][0]['table'] ?? [];
        //     }

        //     return [];
        // });

        // Força a leitura da chave do env ou do config
        $apiKey = '4754b23a33e54b2a9403bf1f87df7ca4' ?? config('services.football_data.key');

        $standings = Cache::remember('tabela_brasileirao', 900, function () use ($apiKey) {
            
            // Faz a requisição ignorando verificação SSL caso esteja em ambiente local (Windows/XAMPP)
            $response = Http::withoutVerifying()
                ->withHeaders([
                    'X-Auth-Token' => $apiKey,
                ])
                ->get('https://api.football-data.org/v4/competitions/BSA/standings');

            if ($response->successful()) {
                $data = $response->json();
                return $data['standings'][0]['table'] ?? [];
            }

            // Registra no log do Laravel (storage/logs/laravel.log) para sabermos o motivo exato do erro
            Log::error('Erro ao buscar tabela do Brasileirão', [
                'status' => $response->status(),
                'body'   => $response->body()
            ]);

            return [];
        });

        // Se por algum motivo o cache salvou vazio, apaga a chave do cache para tentar de novo no próximo refresh
        if (empty($standings)) {
            Cache::forget('tabela_brasileirao');
        }

        $blogNoBairo = Blog::with('category')->where('blog_category_id', '=', 1)->orderby('date', 'desc')->limit(15)->get();

        return view('client.blades.index', compact(
            'standings', 
            'latestNews', 
            'recentCategories', 
            'contact',   
            'videos',  
            'about', 
            'blogSuperHighlights', 
            'blogHighlights', 
            'announcements', 
            'blogRelacionados', 
            'announcementVerticals', 
            'blogCategories', 
            'events', 
            'popUp', 
            'tempo', 
            'standings',
            'blogNoBairo',
            'blogNoBairros'
        ));
    }

    public function filterByCategory($categorySlug = null)
    {
        try {
            $query = Blog::whereHas('category', function($active) {
                $active->where('active', 1);
            })
            ->with(['category'])
            ->active()
            ->limit(10);

            // Se uma categoria específica for selecionada
            if ($categorySlug && $categorySlug !== 'todas') {
                $query->whereHas('category', function($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            }

            // Obter TODAS as notícias ordenadas por data
            $allNews = $query->orderBy('created_at', 'DESC')->get();

            // Pegar as próximas notícias (excluindo a primeira)
            $latestNews = $allNews;

            $html = view('client.ajax.filter-blog-homePage', [
                'latestNews' => $latestNews
            ])->render();

            // Força UTF-8 e remove caracteres inválidos
            $html = mb_convert_encoding($html, 'UTF-8', 'UTF-8');

            return response()->json([
                'success' => true,
                'html' => $html,
                'count' => $allNews->count(),
                'latest_count' => $latestNews->count()
            ], 200, [], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao filtrar notícias: ' . $e->getMessage()
            ]);
        }
    }
}
