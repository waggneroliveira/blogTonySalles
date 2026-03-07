<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Announcement;
use App\Models\BenefitTopic;
use App\Models\Blog;
use App\Models\BlogCategory;
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
            ->limit(10)
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

        $standings = $service->standings();
        
        // dd($standings);
        return view('client.blades.index', compact(
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
