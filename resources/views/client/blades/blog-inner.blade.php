@extends('client.core.client')
@section('content')
    <!-- News With Sidebar Start -->
    <div class="container">
        @php
            use Illuminate\Support\Str;

            if ($blogInner->path_image_thumbnail) {

                // Se já for URL completa (RSS)
                if (Str::startsWith($blogInner->path_image_thumbnail, ['http://','https://'])) {

                    $imagemUrl = $blogInner->path_image_thumbnail;

                } else {

                    // Se vier do banco WHI
                    if ($blogsWhi) {
                        $imagemUrl = 'https://www.whi.dev.br/storage/' . $blogInner->path_image_thumbnail;
                    } else {
                        $imagemUrl = asset('storage/' . $blogInner->path_image_thumbnail);
                    }

                }

            } else {

                $imagemUrl = 'https://placehold.co/600x400?text=Sem+imagem&font=poppins';

            }
        @endphp
        
        <img class="border img-fluid w-100 rounded-0 image-inner d-flex justify-content-center align-items-center"
        src="{{ $imagemUrl }}"
        alt="{{ $blogInner->title ? $blogInner->title : 'Sem imagem'}}"
        style="aspect-ratio:1.91/1;object-fit: cover;height: 100%;">
        
    </div>
    <div class="container-fluid mb-5 blog-inn mt-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                    @php
                        \Carbon\Carbon::setLocale('pt_BR');
                        $dataFormatada = \Carbon\Carbon::parse($blogInner->date)->translatedFormat('d \d\e F \d\e Y');
                    @endphp
                    <!-- News Detail Start -->
                    <div class="position-relative mb-3">
                        <article>
                            <h1 class="mb-3 title-blue poppins-bold font-32 text-uppercase">{{$blogInner->title}}</h1>
                            <div class="mb-3 d-flex justify-content-start align-items-center gap-1 flex-wrap">
                                <span class="badge background-red rounded-0 poppins-semiBold font-12 text-uppercase py-2 px-2 me-2">{{$blogInner->category->title}}</span>
                                <p class="text-color mb-0 poppins-regular font-15">{{$dataFormatada}}</p>
                            </div>

                            <div class="py-4">
                                <div class="barra-de-progresso mt-2 d-flex align-items-center gap-2">
                                    <i id="audioIcon" class="fa fa-play d-flex justify-content-center align-items-center rounded-5 font-12 text-black" onclick="togglePlayPause()"></i>
                                    <span id="audioStatus" class="text-muted poppins-semiBold font-12"></span>

                                    <div id="progressContainer" class="progressContainer flex-grow-1">
                                        <div id="progressBar" class="background-red" style="width:0%;"></div>
                                    </div>

                                    <!-- Controlador de velocidade -->
                                    <div class="d-flex gap-1 align-items-center">
                                        <button id="decreaseSpeed" class="btn-voz d-flex justify-content-center align-items-center btn btn-sm btn-outline-secondary">-</button>
                                        <span id="speedLabel" class="text-muted poppins-semiBold font-12 ms-1 me-1">1x</span>
                                        <button id="increaseSpeed" class="btn-voz d-flex justify-content-center align-items-center btn btn-sm btn-outline-secondary">+</button>
                                    </div>

                                    <!-- Controlador de volume simplificado -->
                                    <div class="d-flex align-items-center ms-3 justify-content-center">
                                        <i class="fa fa-volume-up text-muted me-2"></i>
                                        <input id="volumeSlider" type="range" min="0" max="1" step="0.1" value="1" class="form-range w-50">
                                    </div>
                                </div>

                                <div class="text-blog-inner poppins-medium font-16 mt-4 text-audio">
                                    {!! $blogInner->text !!}
                                    <br>
                                    <br>
                                    @if ($blogInner->is_rss)                                        
                                        <small class="text-muted">
                                            <b>Fonte:</b> {{$blogInner->source}}
                                            <br>
                                            <a href="{{ $blogInner->external_link }}" target="_blank" rel="noopener noreferrer" class="text-underline text-primary">
                                                Leia a matéria na integra.
                                            </a> 
                                        </small>
                                        <br>
                                        <br>
                                        <div class="alert alert-warning small" role="alert">
                                            <strong>Aviso:</strong> Este site atua como agregador de notícias.
                                            Os conteúdos de terceiros pertencem integralmente aos seus respectivos
                                            autores e veículos. As publicações externas contêm apenas resumos informativos.
                                        </div>
                                        @elseif($blogsWhi)
                                        <small class="text-muted">
                                            <b>Fonte:</b> Agência WHI
                                            <br>
                                            <a href="{{ 'https://www.whi.dev.br/blog/interna/' . $blogInner->slug }}" target="_blank" rel="noopener noreferrer" class="text-underline text-primary">
                                                Leia a matéria na integra.
                                            </a> 
                                        </small>
                                        <br>
                                        <br>
                                        <div class="alert alert-warning small" role="alert">
                                            <strong>Aviso:</strong> Este site atua como agregador de notícias.
                                            Os conteúdos de terceiros pertencem integralmente aos seus respectivos
                                            autores e veículos. As publicações externas contêm apenas resumos informativos.
                                        </div>
                                    @endif
                                </div>                                
                            </div>                        
                        </article>

                        <div class="d-flex justify-content-between align-items-start">      
                            <a href="{{route('blogAll')}}" class="poppins-semiBold font-16 d-flex justify-content-start align-items-center gap-2 mb-3 text-black col-2">
                                <svg width="15" height="15" viewBox="0 0 17 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.1926 2.20441L2.32113 10.6069C2.05923 10.7927 2.05923 11.2059 2.32113 11.3917L14.1926 19.7941C14.4739 19.9924 14.8716 19.8011 14.8716 19.4017V2.59536C14.8716 2.19742 14.4725 2.00613 14.1926 2.20441ZM1.09904 8.87649L12.9705 0.474006C14.6832 -0.737844 17 0.519764 17 2.59681V19.4032C17 21.4803 14.6831 22.7378 12.9705 21.526L1.09904 13.1221C-0.365655 12.085 -0.367038 9.91502 1.09904 8.87649Z" fill="black"/>
                                </svg>
                                Voltar
                            </a>                     
                            <div class="position-relative d-flex justify-content-center align-items-end flex-column">
                                <button class="poppins-semiBold font-16 d-flex justify-content-around align-items-center btn pt-0 px-0 text-black rounded-0">
                                    Compartilhe aqui
                                </button>
                                <div class="mt-0">
                                    <div class="d-flex gap-1">
                                        <a href="https://api.whatsapp.com/send?text={{ urlencode($blogInner->title . ' ' . url()->current()) }}" target="_blank" class="rounded-circle btn btn-sm"><i class="fab fa-whatsapp text-black font-20"></i></a>    
                                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blogInner->title) }}" target="_blank" class="rounded-circle btn btn-sm"><i class="fab fa-x-twitter text-black font-20"></i></a>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="rounded-circle btn btn-sm"><i class="fab fa-facebook-f text-black font-20"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- News Detail End -->

                    @if (!$blogsWhi)
                        <!-- Comment Form Start -->                        
                        <div class="mb-0 mt-5">
                            <div class="bg-white border border-top-0 p-4">
                                <div class="section-title mb-0 rounded-top-left">
                                    <h4 class="m-0 poppins-bold font-25 title-blue">Deixe um comentário</h4>
                                </div>
                                <form id="commentForm">
                                    @csrf
                                    <input type="hidden" name="blog_id" value="{{ $blogInner->id }}">

                                    <div class="mb-3">
                                        <label for="message">Mensagem *</label>
                                        <textarea id="message" name="comment" required cols="30" rows="5" class="form-control poppins-regular font-15"></textarea>
                                    </div>
                                                                    
                                    <div class="mb-0">
                                        <button type="submit" class="btn background-red rounded-3 poppins-medium text-white font-15">Comentar</button>
                                    </div>
                                </form>
                                <div id="commentMessage" class="mt-3 poppins-regular font-15"></div>
                            </div>
                        </div>
                        <!-- Comment Form End -->

                        <!-- Comment List Start -->
                        @if (isset($blogInner->comments) && $blogInner->comments->count() > 0)                        
                            <div class="mb-3 mt-3 comments">
                                <div class="bg-white border p-4 comment-scroll">
                                    <div class="section-title mb-4 title-blue rounded-top-left">
                                        <h4 class="m-0 poppins-bold font-25 title-blue">{{$blogInner->comments->count()}} Comentário(s)</h4>
                                    </div>
                                    @foreach ($blogInner->comments as $comment)
                                        @php
                                            \Carbon\Carbon::setLocale('pt_BR');
                                            $dataFormatada = \Carbon\Carbon::parse($comment->date)->translatedFormat('d \d\e F \d\e Y');
                                            $client = $comment->client;
                                        @endphp

                                        @if ($client)
                                            <div class="d-flex gap-2 flex-column mb-4 border p-3">
                                                <div class="d-flex mb-0 gap-3">
                                                    <img src="{{ $client->path_image ? url($client->path_image) : asset('build/client/images/user.jpg') }}"
                                                        alt="Imagem do cliente"
                                                        class="img-fluid mr-3 mt-1 rounded-circle"
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                    <div class="d-flex flex-column col-10 comment">
                                                        <h6 class="title-blue poppins-bold font-15 mb-0">{{ $client->name }}</h6>
                                                        <small class="title-blue mb-0 poppins-regular font-12">
                                                            {{ $dataFormatada }}
                                                        </small>
                                                        <div class="w-100 mt-3">
                                                            <div class="comment-text">
                                                                {!! $comment->comment !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <!-- Comment List End -->
                    @endif

                    @if ($announcements->count())                        
                        <div class="mt-4">
                            @include('client.includes.announcement')
                        </div>
                    @endif
                </div>                

                <div class="col-lg-3 col-12 mt-3 mt-lg-0" data-aos="fade-left" data-aos-delay="100">
                    @if ($blogRelacionados->count() > 0)                        
                        <!-- Popular News Start -->
                        <div class="mb-3">
                            <div class="bg-white border p-3 rounded-1">
                                <div class="section-title mb-4 rounded-top-left">
                                    <h4 class="mb-3 poppins-bold font-18 pb-3 border-bottom title-blue news">Relacionados</h4>
                                </div>
                                @foreach($blogRelacionados as $index => $relacionado)
                                    @php
                                        // Verifica se a imagem é do RSS (URL externa) ou manual (storage)
                                        if ($relacionado->path_image_thumbnail) {
                                            if (Str::startsWith($relacionado->path_image_thumbnail, ['http://', 'https://'])) {
                                                // Já é uma URL completa (RSS ou manual com URL externa)
                                                $imagemRelacionadoUrl = $relacionado->path_image_thumbnail;
                                            } else {
                                                // Precisa do asset() para o storage
                                                $imagemRelacionadoUrl = asset('storage/' . $relacionado->path_image_thumbnail);
                                            }
                                        } else {
                                            $imagemRelacionadoUrl = 'https://placehold.co/600x400?text=Sem+imagem&font=poppins';
                                        }
                                    @endphp
                                    
                                    <article class="{{ $index >= 5 ? 'rel-item d-none' : '' }}">
                                        <div class="d-flex align-items-center bg-white mb-3" style="height: 110px;">

                                            <div class="h-100 pe-2 d-flex flex-column justify-content-center" style="flex: 1;">
                                                <a href="{{ route('blog-inner', ['slug' => $relacionado->slug]) }}" class="underline">
                                                    <h3 class="h6 m-0 poppins-semiBold font-15 title-blue">
                                                        {{ substr(strip_tags($relacionado->title), 0, 70) }}...
                                                    </h3>
                                                </a>
                                            </div>

                                            <div class="position-relative" style="width:94px; height:94px; flex-shrink:0;">
                                                <img loading="lazy"
                                                    class="rounded-1 img-fluid w-100 h-100"
                                                    style="object-fit: cover; aspect-ratio: 1/1;"
                                                    src="{{ $imagemRelacionadoUrl }}"
                                                    alt="{{ $relacionado->title ?? 'Sem imagem' }}">
                                            </div>

                                        </div>
                                    </article>
                                @endforeach

                                @if(count($blogRelacionados) > 5)
                                    <div class="text-center mt-2">
                                        <p id="btn-ver-mais" class="poppins-bold font-15" style="cursor: pointer;">Ver mais</p>                                        
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- Popular News End -->
                    @endif

                    <!-- Tags Start -->
                    <div class="mb-3">
                        <div class="bg-white border rounded-1 p-3">
                            <div class="section-title mb-0 rounded-top-left cat-mt">
                                <h4 class="mb-3 poppins-bold font-18 border-bottom title-blue pb-3 news">Categorias</h4>
                            </div>
                            <ul class="ps-0 d-flex flex-wrap m-n1">
                                @foreach ($blogCategories as $category)
                                    @php
                                        $title = match(strtolower($category->title)) {
                                            'justica' => 'Justiça',
                                            'saude'   => 'Saúde',
                                            'economia'=> 'Economia',
                                            default   => $category->title,
                                        };
                                    @endphp
                                    <li class="nav-link">
                                        <a href="{{ route('blog', ['category' => $category->slug]) }}#news"
                                        class="btn btn-sm title-blue rounded-0 poppins-semiBold font-12 m-1 bg-blue-light">
                                            {{ $title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- Tags End -->

                    <!-- Ads Start -->
                    @if ($announcements->count())                        
                        <div class="mb-4">
                            @include('client.includes.announcementVertical')
                        </div>
                    @endif
                    <!-- Ads End -->

                    <!-- Newsletter Start -->
                    <div class="mb-4 bg-white text-center border p-3 rounded-1">
                        <div class="section-title mb-0 rounded-top-left">
                            <h4 class="mb-3 poppins-bold font-18 border-bottom pb-3 title-blue text-start news">Newsletter</h4>
                        </div>
                        @include('client.includes.newsletter')
                    </div>
                    <!-- Newsletter End -->

                    @if (isset($contact) && $contact->link_face || isset($contact) && $contact->link_x || isset($contact) && $contact->link_insta || isset($contact) && $contact->link_youtube)
                        <!-- Rede sociais Start -->
                        <div class="mb-4 bg-white text-center border p-3 rounded-1">
                            <div class="section-title mb-0 rounded-top-left">
                                <h4 class="mb-3 poppins-bold font-18 border-bottom pb-3 title-blue text-start news">Siga-nos nas redes sociais</h4>
                                    <p class="text-color poppins-regular font-12 text-start">
                                        Acompanhe as notícias de toda a cidade através das nossas redes sociais
                                    </p>
                            </div>
                            <div class="p-0 m-auto me-0 mt-4">
                                <nav class="site-navigation position-relative text-end w-100 redes-sociais">
                                    <ul class="p-0 d-flex justify-content-start justify-content-lg-center align-items-center gap-3 flex-row mb-0 w-100">
                                        @if (isset($contact) && $contact->link_face)
                                            <li class="li d-flex justify-content-start align-items-center">
                                                <a href="{{$contact->link_face}}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <svg width="20" height="30" viewBox="0 0 22 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M22 0.310097V7.13221H18.0023C16.5424 7.13221 15.5579 7.44231 15.0486 8.0625C14.5394 8.68269 14.2847 9.61298 14.2847 10.8534V15.7374H21.7454L20.7523 23.3864H14.2847V43H6.49306V23.3864H0V15.7374H6.49306V10.104C6.49306 6.89964 7.37577 4.41456 9.1412 2.64874C10.9066 0.882912 13.2577 0 16.1944 0C18.6898 0 20.625 0.103367 22 0.310097Z" fill="black"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($contact) && $contact->link_x)
                                            <li class="li d-flex justify-content-start align-items-center">
                                                <a href="{{$contact->link_x}}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <svg width="30" height="30" viewBox="0 0 33 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M26.0074 0H31.0372L19.9963 12.6639L33 30H22.8178L14.8439 19.5492L5.64312 30H0.613383L12.513 16.3525L0 0H10.4275L17.6654 9.59016L26.0074 0ZM24.29 26.9262H26.9888L8.95539 2.95082H5.88848L24.29 26.9262Z" fill="black"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($contact) && $contact->link_insta)
                                            <li class="li d-flex justify-content-start align-items-center">
                                                <a href="{{$contact->link_insta}}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <svg width="30" height="30" viewBox="0 0 37 37" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M22.86 22.86C22.86 22.86 23.1611 22.5589 23.7633 21.9567C24.3656 21.3545 24.6667 20.2023 24.6667 18.5C24.6667 16.7977 24.0645 15.3444 22.86 14.14C21.6556 12.9355 20.2023 12.3333 18.5 12.3333C16.7977 12.3333 15.3444 12.9355 14.14 14.14C12.9355 15.3444 12.3333 16.7977 12.3333 18.5C12.3333 20.2023 12.9355 21.6556 14.14 22.86C15.3444 24.0645 16.7977 24.6667 18.5 24.6667C20.2023 24.6667 21.6556 24.0645 22.86 22.86ZM25.2207 11.7793C25.2207 11.7793 25.6824 12.241 26.6058 13.1644C27.5292 14.0878 27.9909 15.8663 27.9909 18.5C27.9909 21.1337 27.0675 23.3739 25.2207 25.2207C23.3739 27.0675 21.1337 27.9909 18.5 27.9909C15.8663 27.9909 13.6261 27.0675 11.7793 25.2207C9.93251 23.3739 9.00911 21.1337 9.00911 18.5C9.00911 15.8663 9.93251 13.6261 11.7793 11.7793C13.6261 9.93251 15.8663 9.00912 18.5 9.00912C21.1337 9.00912 23.3739 9.93251 25.2207 11.7793ZM29.9421 7.05794C29.9421 7.05794 30.0505 7.16634 30.2673 7.38314C30.484 7.59994 30.5924 8.01346 30.5924 8.6237C30.5924 9.23394 30.3757 9.75586 29.9421 10.1895C29.5085 10.623 28.9865 10.8398 28.3763 10.8398C27.7661 10.8398 27.2441 10.623 26.8105 10.1895C26.377 9.75586 26.1602 9.23394 26.1602 8.6237C26.1602 8.01346 26.377 7.49154 26.8105 7.05794C27.2441 6.62435 27.7661 6.40755 28.3763 6.40755C28.9865 6.40755 29.5085 6.62435 29.9421 7.05794ZM20.3428 3.31218C20.3428 3.31218 20.0637 3.31418 19.5057 3.3182C18.9476 3.32221 18.6124 3.32422 18.5 3.32422C18.3876 3.32422 17.7733 3.32021 16.6572 3.31218C15.5411 3.30415 14.694 3.30415 14.1159 3.31218C13.5378 3.32021 12.7629 3.34429 11.7913 3.38444C10.8198 3.42459 9.99273 3.50488 9.31022 3.62533C8.62771 3.74577 8.0536 3.89431 7.58789 4.07096C6.78494 4.39214 6.07834 4.85786 5.4681 5.4681C4.85786 6.07834 4.39214 6.78494 4.07096 7.58789C3.89431 8.0536 3.74577 8.62771 3.62533 9.31022C3.50488 9.99273 3.42459 10.8198 3.38444 11.7913C3.34429 12.7629 3.3202 13.5378 3.31217 14.1159C3.30414 14.694 3.30414 15.5411 3.31217 16.6572C3.3202 17.7733 3.32422 18.3876 3.32422 18.5C3.32422 18.6124 3.3202 19.2267 3.31217 20.3428C3.30414 21.4589 3.30414 22.306 3.31217 22.8841C3.3202 23.4622 3.34429 24.2371 3.38444 25.2087C3.42459 26.1802 3.50488 27.0073 3.62533 27.6898C3.74577 28.3723 3.89431 28.9464 4.07096 29.4121C4.39214 30.2151 4.85786 30.9217 5.4681 31.5319C6.07834 32.1421 6.78494 32.6079 7.58789 32.929C8.0536 33.1057 8.62771 33.2542 9.31022 33.3747C9.99273 33.4951 10.8198 33.5754 11.7913 33.6156C12.7629 33.6557 13.5378 33.6798 14.1159 33.6878C14.694 33.6959 15.5411 33.6959 16.6572 33.6878C17.7733 33.6798 18.3876 33.6758 18.5 33.6758C18.6124 33.6758 19.2267 33.6798 20.3428 33.6878C21.4589 33.6959 22.306 33.6959 22.8841 33.6878C23.4622 33.6798 24.2371 33.6557 25.2087 33.6156C26.1802 33.5754 27.0073 33.4951 27.6898 33.3747C28.3723 33.2542 28.9464 33.1057 29.4121 32.929C30.2151 32.6079 30.9217 32.1421 31.5319 31.5319C32.1421 30.9217 32.6079 30.2151 32.929 29.4121C33.1057 28.9464 33.2542 28.3723 33.3747 27.6898C33.4951 27.0073 33.5754 26.1802 33.6156 25.2087C33.6557 24.2371 33.6798 23.4622 33.6878 22.8841C33.6959 22.306 33.6959 21.4589 33.6878 20.3428C33.6798 19.2267 33.6758 18.6124 33.6758 18.5C33.6758 18.3876 33.6798 17.7733 33.6878 16.6572C33.6959 15.5411 33.6959 14.694 33.6878 14.1159C33.6798 13.5378 33.6557 12.7629 33.6156 11.7913C33.5754 10.8198 33.4951 9.99273 33.3747 9.31022C33.2542 8.62771 33.1057 8.0536 32.929 7.58789C32.6079 6.78494 32.1421 6.07834 31.5319 5.4681C30.9217 4.85786 30.2151 4.39214 29.4121 4.07096C28.9464 3.89431 28.3723 3.74577 27.6898 3.62533C27.0073 3.50488 26.1802 3.42459 25.2087 3.38444C24.2371 3.34429 23.4622 3.32021 22.8841 3.31218C22.306 3.30415 21.4589 3.30415 20.3428 3.31218ZM36.8796 10.8639C36.9599 12.2771 37 14.8225 37 18.5C37 22.1775 36.9599 24.7229 36.8796 26.1361C36.719 29.4763 35.7233 32.0618 33.8926 33.8926C32.0618 35.7233 29.4763 36.719 26.1361 36.8796C24.7229 36.9599 22.1775 37 18.5 37C14.8225 37 12.2771 36.9599 10.8639 36.8796C7.52365 36.719 4.93815 35.7233 3.10742 33.8926C1.27669 32.0618 0.281033 29.4763 0.120443 26.1361C0.0401476 24.7229 0 22.1775 0 18.5C0 14.8225 0.0401476 12.2771 0.120443 10.8639C0.281033 7.52365 1.27669 4.93815 3.10742 3.10742C4.93815 1.2767 7.52365 0.281033 10.8639 0.120445C12.2771 0.0401497 14.8225 0 18.5 0C22.1775 0 24.7229 0.0401497 26.1361 0.120445C29.4763 0.281033 32.0618 1.2767 33.8926 3.10742C35.7233 4.93815 36.719 7.52365 36.8796 10.8639Z" fill="black"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($contact) && $contact->link_youtube)
                                            <li class="li d-flex justify-content-start align-items-center">
                                                <a href="{{$contact->link_youtube}}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <svg width="45" height="30" viewBox="0 0 52 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M20.632 24.6286L34.6759 17.4857L20.632 10.2571V24.6286ZM26 0C29.2498 0 32.3884 0.0428581 35.4158 0.128571C38.4431 0.214287 40.6629 0.30476 42.075 0.400002L44.1932 0.514286C44.2125 0.514286 44.377 0.528572 44.6865 0.557144C44.996 0.585712 45.2184 0.614285 45.3538 0.642857C45.4892 0.671429 45.7165 0.714287 46.0357 0.771427C46.3549 0.828571 46.6305 0.904762 46.8627 1C47.0948 1.09524 47.3656 1.21905 47.6751 1.37143C47.9846 1.52381 48.2845 1.70952 48.5746 1.92857C48.8648 2.14762 49.1453 2.4 49.4161 2.68571C49.5322 2.8 49.6821 2.97619 49.8659 3.21429C50.0496 3.45238 50.3301 4.00952 50.7073 4.88571C51.0845 5.7619 51.3408 6.72381 51.4763 7.77143C51.631 8.99048 51.7519 10.2905 51.839 11.6714C51.926 13.0524 51.9792 14.1333 51.9986 14.9143V16.0571V19.9429C52.0179 22.7048 51.8438 25.4667 51.4763 28.2286C51.3408 29.2762 51.099 30.2238 50.7509 31.0714C50.4027 31.919 50.0932 32.5048 49.8223 32.8286L49.4161 33.3143C49.1453 33.6 48.8648 33.8524 48.5746 34.0714C48.2845 34.2905 47.9846 34.4714 47.6751 34.6143C47.3656 34.7571 47.0948 34.8762 46.8627 34.9714C46.6305 35.0667 46.3549 35.1429 46.0357 35.2C45.7165 35.2571 45.4844 35.3 45.3393 35.3286C45.1942 35.3571 44.9718 35.3857 44.672 35.4143C44.3721 35.4429 44.2125 35.4571 44.1932 35.4571C39.3378 35.819 33.2734 36 26 36C21.9958 35.9619 18.5186 35.9 15.5687 35.8143C12.6187 35.7286 10.6794 35.6571 9.75091 35.6L8.32911 35.4857L7.28453 35.3714C6.58814 35.2762 6.06101 35.181 5.70314 35.0857C5.34527 34.9905 4.852 34.7905 4.22331 34.4857C3.59463 34.181 3.04816 33.7905 2.5839 33.3143C2.46783 33.2 2.31791 33.0238 2.13414 32.7857C1.95037 32.5476 1.66988 31.9905 1.29267 31.1143C0.915462 30.2381 0.659152 29.2762 0.523743 28.2286C0.36899 27.0095 0.248089 25.7095 0.16104 24.3286C0.0739914 22.9476 0.020795 21.8667 0.00145081 21.0857V19.9429V16.0571C-0.0178933 13.2952 0.156204 10.5333 0.523743 7.77143C0.659152 6.72381 0.900954 5.77619 1.24915 4.92857C1.59734 4.08095 1.90685 3.49524 2.17767 3.17143L2.5839 2.68571C2.85471 2.4 3.1352 2.14762 3.42537 1.92857C3.71553 1.70952 4.01536 1.52381 4.32487 1.37143C4.63438 1.21905 4.9052 1.09524 5.13732 1C5.36945 0.904762 5.64511 0.828571 5.96429 0.771427C6.28347 0.714287 6.51076 0.671429 6.64617 0.642857C6.78158 0.614285 7.00404 0.585712 7.31354 0.557144C7.62305 0.528572 7.78747 0.514286 7.80682 0.514286C12.6622 0.171429 18.7266 0 26 0Z" fill="black"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        @endif                                    
                                    </ul> 
                                </nav>
                            </div>
                        </div>
                        <!-- Newsletter End -->
                    @endif
                </div>
            </div>
            <div class="row mt-5">
                @if ($viewMores->count() > 0) 
                    <div class="container border-bottom news mb-0">
                        <div class="d-flex flex-row justify-content-between align-items-center">
                            <h3 class="section-title d-table w-auto m-0 mb-3 poppins-bold font-28 title-blue">
                                Veja também
                            </h3>

                            <!-- Navegação EXTERNA -->
                            <div class="d-flex justify-content-between align-items-center gap-3">
                                <div class="swiper-button-prev-one text-center">
                                    <svg width="17" height="25" viewBox="0 0 17 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.6671 0L0.000387192 12.5L12.6671 25L16.2617 21.4526L7.18705 12.5L16.2617 3.54737L12.6671 0Z" fill="black"/>
                                    </svg>
                                </div>
                                <div class="swiper-button-next-one text-center">
                                    <svg width="17" height="25" viewBox="0 0 17 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.59467 25L16.2613 12.5L3.59467 0L0 3.54737L9.07467 12.5L0 21.4526L3.59467 25Z" fill="black"/>
                                    </svg>             
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="container m-auto me-0 mt-5 pe-0">
                        <div class="swiper myNewsSwiperBlog">            
                            <div class="swiper-wrapper" style="align-items: flex-start;">
                                @foreach($viewMores as $viewMore)
                                    @php
                                        \Carbon\Carbon::setLocale('pt_BR');
                                        $dataFormatada = \Carbon\Carbon::parse($viewMore->date)->translatedFormat('d \d\e F \d\e Y');
                                        
                                        // Verifica se a imagem é do RSS (URL externa) ou manual (storage)
                                        if ($viewMore->path_image_thumbnail) {
                                            if (Str::startsWith($viewMore->path_image_thumbnail, ['http://', 'https://'])) {
                                                // Já é uma URL completa (RSS ou manual com URL externa)
                                                $imagemViewMoreUrl = $viewMore->path_image_thumbnail;
                                            } else {
                                                // Precisa do asset() para o storage
                                                $imagemViewMoreUrl = asset('storage/' . $viewMore->path_image_thumbnail);
                                            }
                                        } else {
                                            $imagemViewMoreUrl = 'https://placehold.co/600x400?text=Sem+imagem&font=poppins';
                                        }
                                    @endphp
                                    
                                    <div class="swiper-slide">
                                        <article class="col-12">
                                            <div class="d-flex flex-column align-items-center bg-white mb-4 overflow-hidden position-relative">

                                                <div class="position-absolute mt-2 start-0">
                                                    <span class="badge rounded-0 badge-primary poppins-semiBold font-10 text-uppercase py-2 px-2 mr-2 background-red">
                                                        {{ $viewMore->category->title }}
                                                    </span>
                                                </div>

                                                <img loading="lazy" class="img-fluid w-100 rounded-1"
                                                src="{{ $imagemViewMoreUrl }}"
                                                alt="{{ $viewMore->title }}"
                                                style="height: 232px;aspect-ratio:1/1;object-fit: cover;">

                                                <div class="col-12 my-3 h-100 px-2 d-flex flex-column justify-content-center position-relative">                        
                                                    <a href="{{ route('blog-inner', $viewMore->slug) }}" class="underline">
                                                        <h3 class="h6 m-0 poppins-bold font-14 title-blue">
                                                            {{ Str::limit($viewMore->title, 60) }}
                                                        </h3>
                                                    </a>

                                                    <p class="text-color my-3 poppins-regular font-15">
                                                        {!! substr(strip_tags($viewMore->text), 0, 200) !!}...
                                                    </p>

                                                    <div class="d-flex justify-content-between align-items-center w-100">
                                                        <p class="text-color mb-0 poppins-regular font-12 col-8">{{$dataFormatada}}</p>

                                                        <div id="socialLinks-filter-{{$viewMore->id}}" class="social-links home opacity-0">
                                                            <div class="d-flex gap-2">
                                                                <a href="https://api.whatsapp.com/send?text={{ urlencode($viewMore->title . ' ' . url()->current()) }}" class="rounded-circle btn btn-sm bg-transparent p-0"><i class="fab fa-whatsapp text-dark"></i></a>    
                                                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($viewMore->title) }}" class="rounded-circle btn btn-sm bg-transparent p-0"><i class="fab fa-x-twitter text-dark"></i></a>
                                                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" class="rounded-circle btn btn-sm bg-transparent p-0"><i class="fab fa-facebook-f text-dark"></i></a>
                                                            </div>
                                                        </div>  

                                                        <button id="btnShare-filter-{{$viewMore->id}}" 
                                                                data-target="socialLinks-filter-{{$viewMore->id}}"
                                                                class="share-button d-flex">
                                                            <svg width="18" height="20" viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M4.28845 8.58841C1.92459 8.58841 0 10.5692 0 13.002C0 15.4348 1.92459 17.4155 4.28845 17.4155C5.68567 17.4155 6.92779 16.7195 7.70969 15.6506L15.6837 20.0897C15.5186 20.5571 15.4231 21.0603 15.4231 21.5864C15.4231 24.0193 17.3477 26 19.7115 26C22.0754 26 24 24.0193 24 21.5864C24 19.1536 22.0754 17.1729 19.7115 17.1729C18.3143 17.1729 17.0722 17.8689 16.2903 18.9378L8.31633 14.4987C8.48136 14.0313 8.57691 13.5281 8.57691 12.9982C8.57691 12.4682 8.47516 11.9356 8.3002 11.4554L16.2033 6.94346C16.9789 8.08134 18.262 8.82714 19.71 8.82714C22.0739 8.82714 23.9985 6.84639 23.9985 4.41357C23.9985 1.98074 22.0739 0 19.71 0C17.3462 0 15.4216 1.98074 15.4216 4.41357C15.4216 4.88736 15.4973 5.34584 15.6313 5.77367L7.67731 10.3151C6.89306 9.26915 5.66339 8.58848 4.28466 8.58848L4.28845 8.58841Z" fill="#282828"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>    
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- News With Sidebar End -->
    <script defer src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script defer>
        function showMessage(message, type) {
             $('#commentMessage').html(
                 `<div class="alert alert-${type}">${message}</div>`
             );
 
             setTimeout(() => {
                 $('#commentMessage').fadeOut('slow', function () {
                     $(this).html('').show();
                 });
             }, 3000);
         }
        //Envio do comentario via ajax
        $('#commentForm').on('submit', function (e) {
            e.preventDefault();

            // Atualiza textarea com conteúdo do CKEditor
            for (let instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            const comment = $('#message').val();

            // Remove tags HTML e espaços para verificar se tem conteúdo real
            const commentText = $('<div>').html(comment).text().trim();

            if (!commentText) {
                showMessage('O campo mensagem é obrigatório e não pode conter apenas espaços.', 'danger');
                return;
            }

            const $btn = $(this).find('button[type="submit"]');
            $btn.prop('disabled', true);

            const formData = $(this).serialize();

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('blog.comment') }}",
                method: "POST",
                data: formData,
                success: function (response) {
                    showMessage(response.message, 'success');
                    $('#commentForm')[0].reset();

                    for (let instance in CKEDITOR.instances) {
                        CKEDITOR.instances[instance].setData('');
                    }
                    $btn.prop('disabled', false);
                },
                error: function (xhr) {
                    $btn.prop('disabled', false);

                    console.log('Erro status:', xhr.status);
                    console.log('Erro response:', xhr.responseText);

                    if (xhr.status === 401) {
                        showMessage(xhr.responseJSON?.message || 'É necessário estar logado para enviar um comentário.', 'warning');

                        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                        loginModal.show();
                    } else if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessages = '';
                        for (let field in errors) {
                            errorMessages += `<div>${errors[field][0]}</div>`;
                        }
                        showMessage(errorMessages, 'danger');
                    } else {
                        showMessage('Erro inesperado. Por favor, tente novamente.', 'danger');
                    }
                }
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Swiper === 'undefined') {
                console.error('Swiper não carregado');
                return;
            }

            const newsSwiper = new Swiper('.myNewsSwiperBlog', {
                slidesPerView: 1,
                spaceBetween: 20,
                navigation: {
                nextEl: ".swiper-button-next-one",
                prevEl: ".swiper-button-prev-one",
                },
                breakpoints: {
                360: { slidesPerView: 1.3 },
                576: { slidesPerView: 2.5 },
                1200: { slidesPerView: 4 }
                }
            });
        });
    </script>

    <style>
        #cke_notifications_area_message {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            z-index: -1 !important;
            height: 0 !important;
            overflow: hidden !important;
        }
        .cke_notifications_area {
            display: none !important;
        }

    </style>
@endsection