@extends('client.core.client')
@section('content')
<section id="news" class="blog-content pt-0 my-5">
   <!-- News With Sidebar Start -->
   <div class="container-fluid">
       <div class="max-width m-auto">

         <div class="row">
            
            <div class="col-lg-12 mb-4" data-aos="fade-up" data-aos-delay="750">
               @if ($blogAll->count())                     
                  <div class="mb-5 rounded-top-left">
                     <h2 class="m-0 text-uppercase poppins-bold font-22 title-blue">Notícias</h2>
                  </div>

                  <div class="col-12">
                     <div class="row">
                        <div class="col-12 col-lg-7">
                           @if ($blogCategories->count())                        
                                 <!-- Tags Start -->
                                 <div class="mb-3">
                                    <div class="bg-white border-top-0">
                                          <div class="d-flex flex-wrap m-n1">
                                             <a href="{{ route('blogAll') }}#news"
                                                   class="btn btn-sm btn-outline-secondary text-p poppins-medium font-14 m-1
                                                   {{ (request()->routeIs('blogAll') && request()->route('category') === null) ? 'active background-red' : '' }}">
                                                   Todas
                                             </a>
                                             @foreach ($blogCategories as $blogCategory)
                                                @php
                                                   $title = match(strtolower($blogCategory->title)) {
                                                         'justica' => 'Justiça',
                                                         'saude'   => 'Saúde',
                                                         default   => $blogCategory->title,
                                                   };
                                                @endphp
                                                <a href="{{ route('blog', ['category' => $blogCategory->slug]) }}#news"
                                                   class="btn btn-sm btn-outline-secondary text-p poppins-medium font-14 m-1
                                                   {{ (request()->routeIs('blog') && request()->route('category') === $blogCategory->slug) ? 'active background-red' : '' }}">
                                                   {{ $title }}
                                                </a>
                                             @endforeach

                                          </div>
                                    </div>
                                 </div>
                                 <!-- Tags End -->
                              @endif
                        </div>
                        <div class="col-12 col-lg-5 d-flex justify-content-end gap-3 flex-wrap align-items-start">   
                           <form action="{{route('blog-search')}}#news" class="search col-12 h-1/6" method="post">
                              @csrf
                              <div class="input-group input-group-lg h-100">
                                 <input type="search" name="search" class="form-control border-end-0 text-color poppins-regular bg-white py-0" placeholder="Pesquise aqui">
                                 <button type="submit" title="search" class="btn-reset input-group-text bg-white border">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.99989 0C3.13331 0 0 3.13427 0 6.99979C0 10.8663 3.13351 14.0004 6.99989 14.0004C8.49916 14.0004 9.88877 13.5285 11.0281 12.7252L15.9512 17.6491C16.4199 18.117 17.1798 18.117 17.6485 17.6491C18.1172 17.1804 18.1172 16.4205 17.6485 15.9518L12.7254 11.0288C13.5279 9.88936 13.9998 8.4997 13.9998 6.99983C13.9998 3.13411 10.8655 0 6.99989 0ZM2.39962 6.99979C2.39962 4.45981 4.45907 2.40019 6.99989 2.40019C9.54072 2.40019 11.6002 4.45961 11.6002 6.99979C11.6002 9.54058 9.54072 11.6 6.99989 11.6C4.45907 11.6 2.39962 9.54058 2.39962 6.99979Z" fill="#31404B"/>
                                    </svg>                                    
                                 </button>
                              </div>
                           </form>   
                           @if (Route::currentRouteName() == 'blog-search')
                              <a href="{{ route('blogAll') }}#news" class="btn background-red rounded-0 text-white poppins-medium py-1 font-15">Limpar</a>
                           @endif                     
                        </div>
                     </div>

                     <div class="mt-3">
                        {{$blogAll->links()}}
                     </div>

                     <div class="row mt-5">
                        @foreach($blogAll as $blog)   
                           @php
                              \Carbon\Carbon::setLocale('pt_BR');
                              $dataFormatada = \Carbon\Carbon::parse($blog->date)->translatedFormat('d \d\e F \d\e Y');
                              
                              // Verifica se a imagem é do RSS (URL externa) ou manual (storage)
                              $imagemUrl = null;
                              if ($blog->path_image_thumbnail) {
                                  if ($blog->is_rss && filter_var($blog->path_image_thumbnail, FILTER_VALIDATE_URL)) {
                                      // É do RSS - URL externa direta
                                      $imagemUrl = $blog->path_image_thumbnail;
                                     
                                  } elseif (Str::startsWith($blog->path_image_thumbnail, 'http')) {
                                      // Já é uma URL completa (pode ser de RSS ou manual com URL externa)
                                      $imagemUrl = $blog->path_image_thumbnail;
                                  } else {
                                      // É manual - caminho no storage
                                      $imagemUrl = asset('storage/' . $blog->path_image_thumbnail);
                                  }
                              }
                           @endphp                     

                           <article class="col-lg-4 col-md-6 col-12 mb-4 d-flex">
                                <div class="d-flex flex-column align-items-center bg-white mb-4 overflow-hidden position-relative">

                                    <div class="position-absolute mt-2 start-0">
                                        <span class="badge rounded-0 badge-primary poppins-semiBold font-10 text-uppercase py-2 px-2 mr-2 background-red">
                                            {{ $blog->category->title }}
                                        </span>
                                    </div>

                                    <img loading="lazy" class="img-fluid w-100 rounded-1"
                                    src="{{ $imagemUrl ?: 'https://placehold.co/600x400?text=Sem+imagem&font=poppins' }}"
                                    alt="{{ $blog->title }}"
                                    style="height: 232px;aspect-ratio:1/1;object-fit: cover;">

                                    <div class="col-12 my-3 h-auto px-2 d-flex flex-column justify-content-center position-relative">                        
                                        <a href="{{ route('blog-inner', $blog->slug) }}" class="underline">
                                            <h3 class="h6 m-0 poppins-bold font-14 title-blue">
                                                {{ Str::limit($blog->title, 60) }}
                                            </h3>
                                        </a>

                                        <p class="text-color my-3 poppins-regular font-15">
                                            {!! substr(strip_tags($blog->text), 0, 200) !!}...
                                        </p>

                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <p class="text-color mb-0 poppins-regular font-12 col-8">{{$dataFormatada}}</p>

                                            <div id="socialLinks-filter-{{$blog->id}}" class="social-links home opacity-0">
                                                <div class="d-flex gap-2">
                                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' ' . url()->current()) }}" target="_blank" class="rounded-circle btn btn-sm bg-transparent p-0"><i class="fab fa-whatsapp text-dark"></i></a>    
                                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" target="_blank" class="rounded-circle btn btn-sm bg-transparent p-0"><i class="fab fa-x-twitter text-dark"></i></a>
                                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="rounded-circle btn btn-sm bg-transparent p-0"><i class="fab fa-facebook-f text-dark"></i></a>
                                                </div>
                                            </div>  

                                            <button id="btnShare-filter-{{$blog->id}}" 
                                                    data-target="socialLinks-filter-{{$blog->id}}"
                                                    class="share-button d-flex">
                                                <svg width="18" height="20" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4.28845 8.58841C1.92459 8.58841 0 10.5692 0 13.002C0 15.4348 1.92459 17.4155 4.28845 17.4155C5.68567 17.4155 6.92779 16.7195 7.70969 15.6506L15.6837 20.0897C15.5186 20.5571 15.4231 21.0603 15.4231 21.5864C15.4231 24.0193 17.3477 26 19.7115 26C22.0754 26 24 24.0193 24 21.5864C24 19.1536 22.0754 17.1729 19.7115 17.1729C18.3143 17.1729 17.0722 17.8689 16.2903 18.9378L8.31633 14.4987C8.48136 14.0313 8.57691 13.5281 8.57691 12.9982C8.57691 12.4682 8.47516 11.9356 8.3002 11.4554L16.2033 6.94346C16.9789 8.08134 18.262 8.82714 19.71 8.82714C22.0739 8.82714 23.9985 6.84639 23.9985 4.41357C23.9985 1.98074 22.0739 0 19.71 0C17.3462 0 15.4216 1.98074 15.4216 4.41357C15.4216 4.88736 15.4973 5.34584 15.6313 5.77367L7.67731 10.3151C6.89306 9.26915 5.66339 8.58848 4.28466 8.58848L4.28845 8.58841Z" fill="#282828"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                     </div>

                  </div>
                  <div class="mt-3">
                     {{$blogAll->links()}}
                  </div>
                  @else
                  <div class="alert alert-warning d-flex align-items-center flex-column text-center py-4" role="alert">
                     <i class="bi bi-emoji-frown fs-1 mb-2"></i>
                     <h3 class="alert-heading text-uppercase poppins-bold font-20">Nenhuma notícia encontrada</h3>
                  </div>
               @endif
            </div>
         </div>
       </div>
   </div>
   <!-- News With Sidebar End -->
</section>
@endsection