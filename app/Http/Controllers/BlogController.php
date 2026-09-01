<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Str;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use App\Http\Requests\BlogRequestStore;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BlogRequestUpdate;
use Illuminate\Support\Facades\Response;
use RealRashid\SweetAlert\Facades\Alert;
use App\Repositories\SettingThemeRepository;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class BlogController extends Controller
{
    protected $pathUpload = 'admin/uploads/images/blog/';

    public function index(Request $request)
    {
        $settingTheme = (new SettingThemeRepository())->settingTheme();

        if(
            !Auth::user()->hasRole('Super') && 
            !Auth::user()->can('usuario.tornar usuario master') && 
            !Auth::user()->hasPermissionTo('noticias.visualizar')
        ){
            return view('admin.error.403', compact('settingTheme'));
        }

        $categories = BlogCategory::active()->sorting()->get();

        // Query base
        $blogsQuery = Blog::with([
            'category',
            'comments' => function ($query) {
                $query->orderBy('created_at', 'desc')->with('client');
            }
        ]);

        // 🔎 Aplicar filtros
        if ($request->filled('title')) {
            $blogsQuery->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('date')) {
            $blogsQuery->whereDate('date', $request->date);
        }

        if ($request->filled('blog_category_id')) {
            $blogsQuery->where('blog_category_id', $request->blog_category_id);
        }

        // Paginação
        $blogs = $blogsQuery->orderBy('date', 'desc')->paginate(60)->withQueryString();

        // Contagem de comentários pendentes
        $commentCount = Blog::with(['comments' => function ($query) {
            $query->where('active', 0);
        }])->get();

        // Array simples de categorias [id => title]
        $blogCategory = [];
        foreach ($categories as $category) {
            $blogCategory[$category->id] = $category->title;
        }

        return view('admin.blades.blog.index', compact(
            'blogs', 
            'categories', 
            'blogCategory',
            'settingTheme'
        ));
    }

    public function create(){
        $settingTheme = (new SettingThemeRepository())->settingTheme();
        if(!Auth::user()->hasRole('Super') && 
          !Auth::user()->can('usuario.tornar usuario master') &&  
          !Auth::user()->hasPermissionTo('noticias.visualizar') &&
          !Auth::user()->hasPermissionTo('noticias.criar')){
            return view('admin.error.403', compact('settingTheme'));
        }

        $categories = BlogCategory::active()->sorting()->get();


        $blogCategory = [];

        foreach ($categories as $category) {
            $blogCategory[$category->id] = $category->title;
        }
        return view('admin.blades.blog.create', compact('categories', 'blogCategory'));
    }

    public function edit(Blog $blog){
        $settingTheme = (new SettingThemeRepository())->settingTheme();
        if(!Auth::user()->hasRole('Super') && 
          !Auth::user()->can('usuario.tornar usuario master') && 
          !Auth::user()->hasPermissionTo('noticias.visualizar') && 
          !Auth::user()->hasPermissionTo('noticias.editar')){
            return view('admin.error.403', compact('settingTheme'));
        }

        $categories = BlogCategory::active()->sorting()->get();
        $blogCategory = [];

        foreach ($categories as $category) {
            $blogCategory[$category->id] = $category->title;
        }
        return view('admin.blades.blog.edit', compact('blog', 'categories', 'blogCategory'));
    }

    public function store(BlogRequestStore $request)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;
        $data['super_highlight'] = $request->super_highlight ? 1 : 0;
        $data['highlight'] = $request->highlight ? 1 : 0;
        $data['slug'] = Str::slug($request->title);

        $manager = new ImageManager(new GdDriver());

        // Imagem principal
        if ($request->hasFile('path_image')) {
            $file = $request->file('path_image');
            $mime = $file->getMimeType();
            $filename = Str::uuid() . '.webp';

            if ($mime === 'image/svg+xml') {
                Storage::disk('public')->putFileAs($this->pathUpload, $file, $filename);
            } else {
                $image = $manager->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(quality: 95)
                    ->toString();

                Storage::disk('public')->put($this->pathUpload . $filename, $image);
            }

            $data['path_image'] = $this->pathUpload . $filename; 
        }

        // Imagem de capa (thumbnail)
        if ($request->hasFile('path_image_thumbnail')) {
            $file = $request->file('path_image_thumbnail');
            $mime = $file->getMimeType();
            $filename = Str::uuid() . '_thumbnail.webp';

            if ($mime === 'image/svg+xml') {
                Storage::disk('public')->putFileAs($this->pathUpload, $file, $filename);
            } else {
                $image = $manager->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(quality: 95)
                    ->toString();

                Storage::disk('public')->put($this->pathUpload . $filename, $image);
            }

            $data['path_image_thumbnail'] = $this->pathUpload . $filename; 
        }

        try {
            DB::beginTransaction();
                $blog = Blog::create($data);
            DB::commit();

            session()->flash('success', __('dashboard.response_item_create'));
            session()->put('blogTitle', $blog->title);
            return redirect()->back()->with('reopenModal', 'agenda-alert');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('error', __('dashboard.response_item_error_create'));
            return redirect()->back();
        }
    }
    public function uploadImageCkeditor(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $mime = $file->getMimeType();

            // Nome do arquivo sem extensão + .webp
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';

            // Caminho de armazenamento
            $pathUpload = 'uploads/blog_images/';

            $manager = ImageManager::gd(); // ou ->imagick() se preferir

            if ($mime === 'image/svg+xml') {
                // Apenas copiar o SVG sem conversão
                Storage::disk('public')->putFileAs($pathUpload, $file, $filename);
            } else {
                // Converter em WEBP
                $image = $manager->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(quality: 95)
                    ->toString();

                Storage::disk('public')->put($pathUpload . $filename, $image);
            }

            $url = asset('storage/' . $pathUpload . $filename);

            return response()->json([
                'uploaded' => 1,
                'fileName' => $filename,
                'url' => $url
            ]);
        }

        return response()->json([
            'uploaded' => 0,
            'error' => ['message' => 'Upload falhou.']
        ]);
    }
    public function update(BlogRequestUpdate $request, Blog $blog)
    {
        $data = $request->all();
        $data['active'] = $request->active ? 1 : 0;
        $data['super_highlight'] = $request->super_highlight ? 1 : 0;
        $data['highlight'] = $request->highlight ? 1 : 0;
        $data['slug'] = Str::slug($request->title);

        $manager = new ImageManager(new GdDriver());

        // Imagem principal
        if ($request->hasFile('path_image')) {
            $file = $request->file('path_image');
            $mime = $file->getMimeType();
            $filename = Str::uuid() . '.webp';

            if ($mime === 'image/svg+xml') {
                Storage::disk('public')->putFileAs($this->pathUpload, $file, $filename);
            } else {
                $image = $manager->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(quality: 95)
                    ->toString();

                Storage::disk('public')->put($this->pathUpload . $filename, $image);
            }

            if (!empty($blog->path_image)) {
                Storage::disk('public')->delete($blog->path_image);
            }

            $data['path_image'] = $this->pathUpload . $filename; 
        }

        if ($request->has('delete_path_image')) {
            if (!empty($blog->path_image)) {
                Storage::disk('public')->delete($blog->path_image);
            }
            $data['path_image'] = null;
        }

        // Imagem de capa
        if ($request->hasFile('path_image_thumbnail')) {
            $file = $request->file('path_image_thumbnail');
            $mime = $file->getMimeType();
            $filename = Str::uuid() . '_thumbnail.webp';

            if ($mime === 'image/svg+xml') {
                Storage::disk('public')->putFileAs($this->pathUpload, $file, $filename);
            } else {
                $image = $manager->read($file)
                    ->resize(null, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(quality: 95)
                    ->toString();

                Storage::disk('public')->put($this->pathUpload . $filename, $image);
            }

            if (!empty($blog->path_image_thumbnail)) {
                Storage::disk('public')->delete($blog->path_image_thumbnail);
            }

            $data['path_image_thumbnail'] = $this->pathUpload . $filename; 
        }

        if ($request->has('delete_path_image_thumbnail')) {
            if (!empty($blog->path_image_thumbnail)) {
                Storage::disk('public')->delete($blog->path_image_thumbnail);
            }
            $data['path_image_thumbnail'] = null;
        }

        try {
            DB::beginTransaction();
                $blog->fill($data)->save();
            DB::commit();

            session()->flash('success', __('dashboard.response_item_update'));
            return redirect()->route('admin.dashboard.blog.index');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('error', __('dashboard.response_item_error_update'));
            return redirect()->back();
        }
    }
    public function destroy(Blog $blog)
    {
        Storage::delete(isset($blog->path_image)??$blog->path_image);
        Storage::delete(isset($blog->path_image_thumbnail)??$blog->path_image_thumbnail);
        $blog->delete();
        Session::flash('success',__('dashboard.response_item_delete'));
        return redirect()->back();
    }

    public function destroySelected(Request $request)
    {    
        foreach ($request->deleteAll as $blogId) {
            $blog = Blog::find($blogId);
    
            if ($blog) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($blog)
                    ->event('multiple_deleted')
                    ->withProperties([
                        'attributes' => [
                            'id' => $blogId,
                            'title' => $blog->title,
                            'slug' => $blog->slug,
                            'data' => $blog->date,
                            'path_image' => $blog->path_image,
                            'path_image_thumbnail' => $blog->path_image_thumbnail,
                            'texto' => $blog->text,
                            'sorting' => $blog->sorting,
                            'active' => $blog->active,
                            'event' => 'multiple_deleted',
                        ]
                    ])
                    ->log('multiple_deleted');
            } else {
                \Log::warning("Item com ID $blogId não encontrado.");
            }
        }
    
        $deleted = Blog::whereIn('id', $request->deleteAll)->delete();
    
        if ($deleted) {
            return Response::json(['status' => 'success', 'message' => $deleted . ' '.__('dashboard.response_item_delete')]);
        }
    
        return Response::json(['status' => 'error', 'message' => 'Nenhum item foi deletado.'], 500);
    }

    public function sorting(Request $request)
    {
        foreach($request->arrId as $sorting => $id) {
            $blog = Blog::find($id);
    
            if ($blog) {
                $blog->sorting = $sorting;
                $blog->save();
            } else {
                Log::warning("Item com ID $id não encontrado.");
            }

            if($blog) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn($blog)
                    ->event('order_updated')
                    ->withProperties([
                        'attributes' => [
                            'id' => $id,
                            'title' => $blog->title,
                            'slug' => $blog->slug,
                            'data' => $blog->date,
                            'path_image' => $blog->path_image,
                            'path_image_thumbnail' => $blog->path_image_thumbnail,
                            'texto' => $blog->text,
                            'sorting' => $blog->sorting,
                            'active' => $blog->active,
                            'event' => 'order_updated',
                        ]
                    ])
                    ->log('order_updated');
            } else {
                \Log::warning("Item com ID $id não encontrado.");
            }
        }
    
        return Response::json(['status' => 'success']);
    }
}
