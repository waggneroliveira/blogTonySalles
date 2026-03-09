<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="theme-color" content="#0d0d0d">
    <meta name="description" content="Pulso Notícias é um portal de notícias com informações atualizadas sobre política, economia, tecnologia, esportes e os principais acontecimentos do Brasil e do mundo.">
    <meta name="keywords" content="Pulso Notícias é um portal de notícias com informações atualizadas sobre política, economia, tecnologia, esportes e os principais acontecimentos do Brasil e do mundo.">
    
    <title>Pulso Notícias</title>
    
    @if(isset($blogInner))
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="article">
        <meta property="og:title" content="{{ $blogInner->title }}">
        <meta property="og:description" content="{{ Str::limit(strip_tags($blogInner->text), 150) }}">
        <meta property="og:image" content="{{ asset('storage/' . $blogInner->path_image_thumbnail) }}">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ url()->current() }}">
        <meta name="twitter:title" content="{{ $blogInner->title }}">
        <meta name="twitter:description" content="{{ Str::limit(strip_tags($blogInner->text), 150) }}">
        <meta name="twitter:image" content="{{ asset('storage/' . $blogInner->path_image_thumbnail) }}">
    @else
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Pulso Notícias">
        <meta property="og:description" content="Pulso Notícias é um portal de notícias com informações atualizadas sobre política, economia, tecnologia, esportes e os principais acontecimentos do Brasil e do mundo.">
        <meta property="og:image" content="{{asset('build/client/images/logo-blog.png')}}">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:url" content="{{ url()->current() }}">
        <meta name="twitter:title" content="Pulso Notícias">
        <meta name="twitter:description" content="Pulso Notícias é um portal de notícias com informações atualizadas sobre política, economia, tecnologia, esportes e os principais acontecimentos do Brasil e do mundo.">
        <meta name="twitter:image" content="{{asset('build/client/images/logo-blog.png')}}">
    @endif

    
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="copyright" content="Direitos reservados WHI">
    <meta name="author" content="WHI">
    <link rel="shortcut icon" href="#assets/images/logo-blog.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>    
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" onload='this.onload=null,this.rel="stylesheet"'>
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap">
    </noscript>

    <link rel="preload" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css"></noscript>
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"></noscript>
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"></noscript>
    <link rel="preload" href="{{ asset('build/admin/js/libs/sweetalert2/sweetalert2.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="{{ asset('build/admin/js/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css"></noscript>
    <link rel="preload" href="{{ asset('build/admin/js/libs/dropzone/min/dropzone.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="{{ asset('build/admin/js/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css"></noscript>
    <link rel="preload" href="{{ asset('build/admin/js/libs/dropify/css/dropify.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="{{ asset('build/admin/js/libs/dropify/css/dropify.min.css') }}" rel="stylesheet" type="text/css"></noscript>
    <link href="{{ asset('build/client/lgpd/style.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('build/client/css/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="preload" href="{{ asset('build/client/css/bootstrap-icons/bootstrap-icons.css') }}" as="style" onload="this.rel='stylesheet'">
    <link href="{{ asset('build/client/css/style.css') }}" rel="stylesheet" type="text/css" />
    
    <script defer src="https://cdn.userway.org/widget.js" data-account="qSpdtrySSt"></script>
    <link rel="preconnect" href="https://vlibras.gov.br" crossorigin>

    <script type=application/ld+json>
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "@id": "#organization",
            "name": "Pulso Notícias",
            "legalName": "Pulso Notícias",
            "url": "https://expressovidanova.com.br",
            "logo": "assets/images/logo-blog.png",
            "image": "assets/images/logo-blog.png",
            "description": "Pulso Notícias é um portal de notícias com informações atualizadas sobre política, economia, tecnologia, esportes e os principais acontecimentos do Brasil e do mundo." 
            "foundingDate": "2023",
            "email": "atendimento@whi.dev.br",
            "telephone": "+55 71 99276-8360",
            "sameAs": [
                "https://www.instagram.com/agenciawhi",
                "https://www.linkedin.com/company/106948313"
            ],
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Rua Ápio Patrocínio, 148 - Boa Vista de São Caetano",
                "addressLocality": "Salvador",
                "addressRegion": "BA",
                "postalCode": "40386-050",
                "addressCountry": "BR"
            },
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+55 71 99276-8360",
                "contactType": "customer service",
                "email": "atendimento@whi.dev.br",
                "areaServed": "BR",
                "availableLanguage": ["Portuguese", "English"]
            },
            "openingHoursSpecification": {
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"],
                "opens": "09:00",
                "closes": "18:00"
            },
            "duns": "39.985.136/0001-33",
            "slogan": "Pulso Notícias",
            "keywords": [
                "portal de notícias",
                "notícias do Brasil",
                "últimas notícias",
                "notícias de hoje",
                "notícias atualizadas",
                "notícias em tempo real",
                "notícias nacionais",
                "notícias internacionais",
                "notícias de política",
                "notícias de economia",
                "notícias de tecnologia",
                "notícias de esportes",
                "notícias do mundo",
                "notícias da Bahia",
                "notícias de Salvador",
                "notícias da região metropolitana",
                "notícias locais",
                "notícias gerais",
                "informação e atualidades",
                "jornal online"
            ]
        }
    </script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6589229301985030"
     crossorigin="anonymous"></script>
</head>
<body>
    <div id="organization" hidden></div>
    <header id="header" class="w-100 d-flex flex-column position p-0">   
        <div class="w-100 py-0">
            <div class="header-top py-2 mb-0 header-color">
                <div class="container d-flex flex-wrap justify-content-center justify-content-lg-between align-items-center">    
                    <div class="logo-img d-block d-lg-none px-0 py-2 rounded-2 d-flex justify-content-start align-items-center w-auto">
                        <a href="{{route('index')}}">
                            <img src="{{asset('build/client/images/logo-blog.png')}}" alt="Expresso Vida Nova" title="Expresso Vida Nova" class="img-fluid" style="width: 100px;">
                        </a>
                    </div>

                    <p class="text-white poppins-regular text-center text-lg-start font-14 mb-0 col-12 col-lg-6">
                        Salvador, BA | {{ \Carbon\Carbon::now()->translatedFormat('l, d \d\e F \d\e Y') }}
                    </p>

                    <div class="col-12 col-lg-6 text-center d-none d-lg-block"> 
                        <div class="d-flex flex-wrap justify-content-center justify-content-lg-end align-items-center">
                            <div class="dark-background p-0">
                                <nav class="site-navigation position-relative redes-sociais">
                                    <ul class="p-0 d-flex justify-content-center gap-3 flex-row mb-0">
                                        @if (isset($contact) && $contact->link_insta)
                                            <li class="li d-flex justify-content-center align-items-center rounded-circle">
                                                <a href="{{$contact->link_insta}}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <img src="{{asset('build/client/images/insta.svg')}}" alt="Instagram">
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($contact) && $contact->link_x)
                                            <li class="li d-flex justify-content-center align-items-center rounded-circle">
                                                <a href="{{$contact->link_x}}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <img src="{{asset('build/client/images/x.svg')}}" alt="X">
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($contact) && $contact->link_youtube)
                                            <li class="li d-flex justify-content-center align-items-center rounded-circle">
                                                <a href="{{$contact->link_youtube}}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <img src="{{asset('build/client/images/youtube.svg')}}" alt="Youtube">
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($contact) && $contact->link_face)
                                            <li class="li d-flex justify-content-center align-items-center rounded-circle">
                                                <a href="{{$contact->link_face}}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <img src="{{asset('build/client/images/face.svg')}}" alt="Facebook">
                                                </a>
                                            </li>
                                        @endif
                                        @if (isset($contact) && $contact->link_tik_tok)
                                            <li class="li d-flex justify-content-center align-items-center rounded-circle">
                                                <a href="{{$contact->link_tik_tok}}" rel="nofollow noopener noreferrer" target="_blank">
                                                    <img src="{{asset('build/client/images/tiktok.svg')}}" alt="Tiktok">
                                                </a>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container m-auto d-none d-lg-flex align-items-center justify-content-between flex-column">
                <div class="d-flex col-12 justify-content-between align-items-center wrap-logo-and-login">
                    <div class="logo-img px-0 py-2 rounded-2 d-flex justify-content-start align-items-center w-auto">
                        <a href="{{route('index')}}">
                            <img src="{{asset('build/client/images/logo-blog.png')}}" alt="Pulso Notícias" title="Pulso Notícias" class="img-fluid">
                        </a>
                    </div>

                    @if ($announcements->count())                        
                        <div class="mb-0 col-8">
                            @include('client.includes.announcement')
                        </div>
                    @endif
                </div>       
            </div>
            <div class="container-fluid header-color mt-0 h-60 d-flex align-items-center py-0">
                <div class="container d-flex justify-content-between align-items-center w-100 h-100">
                    <div class="social-links d-flex justify-content-center align-items-center gap-4 text-center col-12 col-lg-auto">
                        <nav class="none site-navigation ul position-relative text-end width-75 h-60">
                            <ul class="d-flex flex-row justify-content-start align-items-center gap-3 mb-0 list-unstyled h-100">
                                <li class="h-100 d-flex align-items-center px-2"><a href="{{route('index')}}" class="nav-link poppins-bold text-center font-12 text-uppercase">Home</a></li>                                                   

                                <li class="nav-item dropdown h-100 d-flex align-items-center px-2">
                                    <a class="nav-link dropdown-toggle poppins-bold text-center font-12 text-uppercase" 
                                        href="{{ route('blog') }}" 
                                        id="noticiasDropdown" 
                                        role="button" 
                                        data-bs-toggle="dropdown" 
                                        aria-expanded="false">
                                        Notícias <i class="bi bi-chevron-down"></i>
                                    </a>

                                    <ul class="dropdown-menu" aria-labelledby="noticiasDropdown">
                                        @if ($blogCategories->count())
                                            @foreach ($blogCategories as $category)
                                                @php
                                                    // Corrige acentuação manualmente
                                                    $title = match(strtolower($category->title)) {
                                                        'justica' => 'Justiça',
                                                        'saude'   => 'Saúde',
                                                        default   => $category->title,
                                                    };
                                                @endphp
                                                <li>
                                                    <a class="dropdown-item poppins-medium text-start font-15" 
                                                    href="{{ route('blog', ['category' => $category->slug]) }}#news">
                                                        {{ $title }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endif

                                    </ul>
                                </li>
                                <li class="h-100 d-flex align-items-center px-2"><a href="{{route('contact')}}" class="nav-link poppins-bold text-center font-12 text-uppercase {{ request()->routeIs('contact') ? 'active' : '' }}">Contato</a></li>
                            </ul>                      
                        </nav>

                        <div class="d-flex justify-content-between gap-3 flex-wrap align-items-center d-lg-none">
                           <form action="{{route('blog-search')}}#news" class="search col-12 col-lg-10" method="post">
                              @csrf
                              <div class="input-group input-group-lg">
                                 <input type="search" name="search" class="rounded-0 form-control border-end-0 text-color poppins-regular bg-white py-0" placeholder="Pesquise aqui">
                                 <button type="submit" title="search" class="btn-reset input-group-text bg-white border rounded-0">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.99989 0C3.13331 0 0 3.13427 0 6.99979C0 10.8663 3.13351 14.0004 6.99989 14.0004C8.49916 14.0004 9.88877 13.5285 11.0281 12.7252L15.9512 17.6491C16.4199 18.117 17.1798 18.117 17.6485 17.6491C18.1172 17.1804 18.1172 16.4205 17.6485 15.9518L12.7254 11.0288C13.5279 9.88936 13.9998 8.4997 13.9998 6.99983C13.9998 3.13411 10.8655 0 6.99989 0ZM2.39962 6.99979C2.39962 4.45981 4.45907 2.40019 6.99989 2.40019C9.54072 2.40019 11.6002 4.45961 11.6002 6.99979C11.6002 9.54058 9.54072 11.6 6.99989 11.6C4.45907 11.6 2.39962 9.54058 2.39962 6.99979Z" fill="#31404B"/>
                                    </svg>                                    
                                 </button>
                              </div>
                           </form>
                        </div>
                        <!-- Botão menu sandwich -->
                        <button id="menu-toggle" class="d-lg-none btn btn-link p-0 ms-2" aria-label="Abrir menu" type="button">
                            <span class="menu-icon" style="display:inline-block;width:32px;height:32px;">
                                <span class="d-block w-100 rounded-1" style="height:4px;background:#FFF;margin:6px 0;"></span>
                                <span class="d-block w-100 rounded-1" style="height:4px;background:#FFF;margin:6px 0;"></span>
                                <span class="d-block w-100 rounded-1" style="height:4px;background:#FFF;margin:6px 0;"></span>
                            </span>
                        </button>                        
                    </div>

                    <div class="d-none d-lg-flex d-flex justify-content-end align-items-center gap-2 login-desktop col-auto col-lg-8">   
                        <div class="d-flex justify-content-between gap-3 flex-wrap align-items-center col-8 col-sm-5 col-md-6 col-lg-7">
                           <form action="{{route('blog-search')}}#news" class="search col-12" method="post">
                              @csrf
                              <div class="input-group input-group-lg">
                                 <input type="search" name="search" class="rounded-0 form-control border-end-0 text-color poppins-regular bg-white py-0" placeholder="Pesquise aqui">
                                 <button type="submit" title="search" class="btn-reset input-group-text bg-white border rounded-0">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.99989 0C3.13331 0 0 3.13427 0 6.99979C0 10.8663 3.13351 14.0004 6.99989 14.0004C8.49916 14.0004 9.88877 13.5285 11.0281 12.7252L15.9512 17.6491C16.4199 18.117 17.1798 18.117 17.6485 17.6491C18.1172 17.1804 18.1172 16.4205 17.6485 15.9518L12.7254 11.0288C13.5279 9.88936 13.9998 8.4997 13.9998 6.99983C13.9998 3.13411 10.8655 0 6.99989 0ZM2.39962 6.99979C2.39962 4.45981 4.45907 2.40019 6.99989 2.40019C9.54072 2.40019 11.6002 4.45961 11.6002 6.99979C11.6002 9.54058 9.54072 11.6 6.99989 11.6C4.45907 11.6 2.39962 9.54058 2.39962 6.99979Z" fill="#31404B"/>
                                    </svg>                                    
                                 </button>
                              </div>
                           </form>
                        </div>                     
                        @if (!Auth::guard('client')->check())                            
                            <div class="d-flex justify-content-end align-items-center gap-2 col-3 ms-3">
                                <svg width="24" height="28" viewBox="0 0 24 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M23.5294 27.2432C23.5294 27.657 23.2026 28 22.7994 28H0.72999C0.332619 28 0 27.6612 0 27.2432C0 20.5561 5.26724 15.1351 11.7647 15.1351C18.2622 15.1351 23.5294 20.5561 23.5294 27.2432ZM11.7647 13.6216C8.10988 13.6216 5.14706 10.5723 5.14706 6.81081C5.14706 3.0493 8.10988 0 11.7647 0C15.4195 0 18.3824 3.0493 18.3824 6.81081C18.3824 10.5723 15.4195 13.6216 11.7647 13.6216Z" fill="white"/>
                                </svg>

                                <div class="d-flex gap-1 flex-column">
                                    <h2 class="off-login m-0 poppins-medium font-14 text-start" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#loginModal">
                                        Acesse sua conta
                                    </h2>
                                    <h3 class="off-login m-0 poppins-medium font-14 text-start" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#loginModal">
                                        <a href="#" class="text-decoration-none poppins-medium" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">Cadastre-se</a>
                                    </h3>
                                </div>
                            </div>
                        @else
                            @php
                                $user = Auth::guard('client')->user();
                                $defaultImage = $user && $user->path_image ? url($user->path_image) : '';
                            @endphp
                            <div class="image-profile">
                                <picture>
                                    <source srcset="{{ isset($defaultImage) && $defaultImage <> null ?$defaultImage:asset('build/client/images/user.jpg') }}" type="image/svg+xml">
                                    <img src="{{ isset($defaultImage) && $defaultImage <> null ?$defaultImage:asset('build/client/images/user.jpg') }}"
                                        alt="Imagem de Login"
                                        class="img-fluid rounded-circle">
                                </picture>
                            </div>
                            <div class="d-flex flex-column align-items-start gap-1">
                                <div class="d-flex justify-content-start align-items-center gap-2 lh-0">
                                    <h2 class="loginOn m-0 poppins-medium font-10 text-start">Bem vindo,</h2>   
                                    <h3 class="m-0 poppins-medium font-12 text-start">{{$names = collect(explode(' ', Auth::guard('client')->user()->name))->slice(0, 1)->implode(' ')}}!</h3>      
                                    <a class="nav-link waves-effect waves-light" href="#" data-bs-toggle="modal" data-bs-target="#editClientModal-{{Auth::guard('client')->user()->id}}">
                                        <i class="bi bi-gear font-15"></i>
                                    </a>                 
                                </div>  
                                <a href="{{route('client.user.logout')}}" class="d-flex justify-content-start align-items-center gap-2 text-decoration-none lh-0">
                                    <i class="bi bi-box-arrow-right font-15"></i>
                                    <h4 class="poppins-medium font-12 m-0">Sair</h4>
                                </a>                                               
                            </div>
                        @endif
                    </div>   
                </div>
            </div>
        </div>     
        
        @include('client/includes/lgpd/lgpd')
    </header>
    <!-- Modal de Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header background-red text-white">
                    <h5 class="modal-title poppins-medium font-22" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <form action="{{ route('client.user.authenticate') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label poppins-medium title-blue font-15">E-mail</label>
                            <input type="email" class="form-control poppins-regular font-15" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label poppins-medium title-blue font-15">Senha</label>
                            <input type="password" class="form-control poppins-regular font-15" id="password" name="password" required>
                        </div>

                        <div class="d-flex justify-content-center my-3">
                            <button type="submit" class="btn background-red text-white px-5 rounded-3 text-white poppins-medium font-15 background-red">
                                Entrar
                            </button>
                        </div>

                        <div class="text-center mt-3">

                            <p class="poppins-regular font-15 text-muted">
                                Ainda não tem uma conta?
                                <a href="#"
                                    class="text-decoration-underline poppins-bold ms-1 under"
                                    data-bs-dismiss="modal"
                                    data-bs-toggle="modal"
                                    data-bs-target="#registerModal">
                                    Registre-se
                                </a>
                            </p>

                            <p class="poppins-regular font-15 text-muted mb-0">
                                <a href="#"
                                    class="text-decoration-underline poppins-bold under"
                                    data-bs-dismiss="modal"
                                    data-bs-toggle="modal"
                                    data-bs-target="#forgotPasswordModal">
                                    Esqueceu sua senha?
                                </a>
                            </p>

                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>

    
    <!-- Modal de Cadastro -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header background-red text-white">
                    <h5 class="modal-title poppins-medium font-22" id="registerModalLabel">Cadastro</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <form action="{{ route('register-client') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label poppins-medium title-blue font-15">Nome</label>
                            <input type="text" class="form-control poppins-regular font-15" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="emailRegister" class="form-label poppins-medium title-blue font-15">E-mail</label>
                            <input type="email" class="form-control poppins-regular font-15" id="emailRegister" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="passwordRegister" class="form-label poppins-medium title-blue font-15">Senha</label>
                            <input type="password" class="form-control poppins-regular font-15" id="passwordRegister" name="password" required>
                        </div>

                        <div class="d-flex justify-content-center my-3">
                            <button type="submit" class="btn background-red px-4 rounded-3 text-white poppins-medium font-15 background-red">
                                Cadastrar
                            </button>
                        </div>

                        <div class="text-center">
                            <p class="poppins-regular font-15 text-muted">
                                Já tem uma conta?
                                <a href="#" 
                                    class="text-decoration-underline poppins-bold ms-1 under"
                                    data-bs-dismiss="modal"
                                    data-bs-toggle="modal"
                                    data-bs-target="#loginModal">
                                    Fazer login
                                </a>
                            </p>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>


    @if (Auth::guard('client')->check())
        @php
            $user = Auth::guard('client')->user();
            $defaultImage = $user && $user->path_image ? url('storage/'.$user->path_image) : '';
        @endphp
        <!-- Modal de Edição -->
        <div class="modal fade" id="editClientModal-{{ Auth::guard('client')->user()->id }}" tabindex="-1" aria-labelledby="editClientModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Header -->
                    <div class="modal-header background-red text-white">
                        <h5 class="modal-title poppins-medium font-22" id="editClientModalLabel">Editar Informações</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">
                        <form action="{{ route('client.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label title-blue poppins-medium font-15">Nome</label>
                                <input type="text" class="form-control poppins-regular font-15" id="name" name="name" value="{{ Auth::guard('client')->user()->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="emailRegister" class="form-label title-blue poppins-medium font-15">E-mail</label>
                                <input type="email" class="form-control poppins-regular font-15" id="emailRegister" name="email" value="{{ Auth::guard('client')->user()->email }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="passwordRegister" class="form-label title-blue poppins-medium font-15">Senha</label>
                                <input type="password" class="form-control poppins-regular font-15" id="passwordRegister" name="password">
                            </div>

                            <div class="mb-3">
                                <label class="form-label poppins-medium title-blue font-15">Imagem de perfil</label>
                                <input 
                                    type="file" 
                                    name="path_image" 
                                    data-plugins="dropify" 
                                    data-default-file="{{ $defaultImage }}"
                                >
                                <p class="poppins-regular text-muted font-12 mt-2 mb-0">
                                    {{ __('dashboard.text_img_size') }} <b class="text-danger">2 MB</b>.
                                </p>
                            </div>

                            <!-- Footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger poppins-medium font-15" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn background-red text-white px-4 poppins-medium font-15">Salvar alterações</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    @endif

    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header background-red">
                    <h5 class="modal-title poppins-medium font-22 text-white" id="forgotPasswordModalLabel">
                        Recuperar Senha
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('client.password.email') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="recover_email" class="form-label poppins-medium title-blue font-15">Digite seu e-mail</label>
                            <input type="email" class="form-control poppins-regular font-15" id="recover_email" name="email" required>
                        </div>

                        <div class="d-flex justify-content-center mt-3 mb-4">
                            <button type="submit" class="btn px-5 background-red rounded-3 text-white poppins-medium font-15">
                                Enviar link de recuperação
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div id="menu-mobile" class="menu-mobile d-flex flex-column justify-content-start align-items-center">
        <div class="d-flex justify-content-end align-items-start w-100">    
            <button id="menu-close" aria-label="Fechar menu" class="col-2 btn-close-menu p-0 bg-transparent" type="button">&times;</button>
        </div>
        <div class="col-10 logo-img p-0 mb-2 rounded-2 d-flex justify-content-center align-items-center">
            <img src="{{asset('build/client/images/logo-blog.png')}}" alt="Pulso Notícias" title="Pulso Notícias" class="img-fluid" style="width: 100px;">
        </div>
        <div class="row justify-content-center gap-5">
            <nav class="mt-3">
                <ul class="list-unstyled text-center">
                    <li class="poppins-regular font-18 mb-3 font-mob"><a href="{{route('index')}}" class="text-white">Home</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle poppins-regular font-18 font-mob mb-3 text-white" 
                            href="{{ route('blog') }}" 
                            id="noticiasDropdown" 
                            role="button" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false">
                            Notícias <i class="bi bi-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="noticiasDropdown">
                            @if ($blogCategories->count())
                                @foreach ($blogCategories as $category)
                                    <li class="m-0">
                                        <a class="dropdown-item poppins-regular font-15 font-mob" 
                                        href="{{ route('blog', ['category' => $category->slug]) }}#news">
                                            {{ $category->title }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    <li class="poppins-regular font-18 mb-3 font-mob"><a href="{{route('contact')}}" class="text-white">Contato</a></li>
                    <li class="poppins-regular font-18 mb-3 font-mob"><a href="https://policies.google.com/privacy?hl=pt-BR" target="_blank" rel="noopener noreferrer" class="text-white">Política de Privacidade</a></li>
                </ul>
            </nav>
            <div class="d-none justify-content-center align-items-center gap-2 mt-0 login-middle-mobile">                        
                @if (!Auth::guard('client')->check())                            
                    <div class="d-flex justify-content-start align-items-center gap-2">
                        <svg width="20" height="20" viewBox="0 0 96 96" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M46.793 8.62893C44.5547 8.62893 42.7344 6.81253 42.7344 4.57423C42.7344 2.33593 44.5547 0.519531 46.793 0.519531L80.57 0.503906C88.8044 0.503906 95.5 7.20311 95.5 15.4339V80.5789C95.5 88.8055 88.8008 95.5089 80.57 95.5089H46.793C44.5469 95.5089 42.7266 93.6847 42.7266 91.4386C42.7266 89.1886 44.5469 87.3683 46.793 87.3683H80.57C84.3083 87.3683 87.3591 84.3136 87.3591 80.5831V15.4311C87.3591 11.7006 84.3083 8.63031 80.57 8.63031L46.793 8.62893ZM49.6914 68.2459L66.5504 51.0619C67.398 50.3158 67.9332 49.2181 67.9332 47.9994C67.9332 46.7807 67.398 45.683 66.5504 44.9408L49.6914 27.7568C48.1133 26.1591 45.543 26.1357 43.9492 27.71C42.3515 29.2803 42.3281 31.8545 43.9062 33.4522L54.1792 43.9322L4.5742 43.9283C2.3281 43.9283 0.5 45.7525 0.5 47.9986C0.5 50.2486 2.3281 52.0689 4.5742 52.0689H54.1762L43.9032 62.5459C42.3251 64.1436 42.3524 66.7138 43.9462 68.288C45.5439 69.8583 48.1103 69.8389 49.6884 68.2412L49.6914 68.2459Z" fill="white"/>
                        </svg>

                        <h2 class="off-login m-0 poppins-medium font-14 text-start" style="cursor:pointer;" data-bs-toggle="modal" data-bs-target="#loginModal">Login</h2>
                    </div>
                @else
                    @php
                        $user = Auth::guard('client')->user();
                        $defaultImage = $user && $user->path_image ? url($user->path_image) : '';
                    @endphp
                    <div class="image-profile">
                        <picture>
                            <source srcset="{{ isset($defaultImage) && $defaultImage <> null ?$defaultImage:asset('build/client/images/user.jpg') }}" type="image/svg+xml">
                            <img src="{{ isset($defaultImage) && $defaultImage <> null ?$defaultImage:asset('build/client/images/user.jpg') }}"
                                alt="Imagem de Login"
                                class="img-fluid rounded-circle">
                        </picture>
                    </div>
                    <div class="d-flex flex-column align-items-start gap-1">
                        <div class="d-flex justify-content-start align-items-center gap-2 lh-0">
                            <h2 class="loginOn m-0 poppins-medium font-10 text-start">Bem vindo,</h2>   
                            <h3 class="m-0 poppins-medium font-12 text-start">{{$names = collect(explode(' ', Auth::guard('client')->user()->name))->slice(0, 1)->implode(' ')}}!</h3>      
                            <a class="nav-link waves-effect waves-light" href="#" data-bs-toggle="modal" data-bs-target="#editClientModal-{{Auth::guard('client')->user()->id}}">
                                <i class="bi bi-gear font-15"></i>
                            </a>                 
                        </div>  
                        <a href="{{route('client.user.logout')}}" class="d-flex justify-content-start align-items-center gap-2 text-decoration-none lh-0">
                            <i class="bi bi-box-arrow-right font-15"></i>
                            <h4 class="poppins-medium font-12 m-0">Sair</h4>
                        </a>                                               
                    </div>
                @endif
            </div> 
            <nav class="site-navigation position-relative text-end w-auto redes-sociais">
                <ul class="p-0 d-flex justify-content-start gap-4 flex-row mb-0">
                    @if (isset($contact) && $contact->link_insta)
                        <li class="li d-flex justify-content-start align-items-center rounded-circle">
                            <a href="{{$contact->link_insta}}" rel="nofollow noopener noreferrer" target="_blank">
                                <img src="{{asset('build/client/images/insta.svg')}}" alt="Instagram">
                            </a>
                        </li>
                    @endif
                    @if (isset($contact) && $contact->link_x)
                        <li class="li d-flex justify-content-start align-items-center rounded-circle">
                            <a href="{{$contact->link_x}}" rel="nofollow noopener noreferrer" target="_blank">
                                <img src="{{asset('build/client/images/x.svg')}}" alt="X">
                            </a>
                        </li>
                    @endif
                    @if (isset($contact) && $contact->link_youtube)
                        <li class="li d-flex justify-content-start align-items-center rounded-circle">
                            <a href="{{$contact->link_youtube}}" rel="nofollow noopener noreferrer" target="_blank">
                                <img src="{{asset('build/client/images/youtube.svg')}}" alt="Youtube">
                            </a>
                        </li>
                    @endif
                    @if (isset($contact) && $contact->link_face)
                        <li class="li d-flex justify-content-start align-items-center rounded-circle">
                            <a href="{{$contact->link_face}}" rel="nofollow noopener noreferrer" target="_blank">
                                <img src="{{asset('build/client/images/face.svg')}}" alt="Facebook">
                            </a>
                        </li>
                    @endif
                    @if (isset($contact) && $contact->link_tik_tok)
                        <li class="li d-flex justify-content-start align-items-center rounded-circle">
                            <a href="{{$contact->link_tik_tok}}a" rel="nofollow noopener noreferrer" target="_blank">
                                <img src="{{asset('build/client/images/tiktok.svg')}}" alt="Tiktok">
                            </a>
                        </li>
                    @endif
                </ul> 
            </nav>
        </div>
    </div>

    <main>
        <div  class="mt-0">
            @if ($announcements->isEmpty())
                <style>
                    .contact, .blog-inn {
                        margin-top: 35px;
                    }
                </style>
            @endif

        </div>
        @yield('content') 
    </main>

    <footer id="footer" class="footer position-relative dark-background">
        <div class="container pt-4 pb-3">
            <div class="sitemap d-flex flex-column flex-md-row justify-content-start gap-5 align-items-center">
                <div class=logo>
                    <img src="{{asset('build/client/images/logo-footer.png')}}" alt="Pulso Notícias" title="Pulso Notícias" loading="lazy">
                </div>
                <ul class="list-unstyled text-start d-flex flex-column flex-md-row justify-content-center align-items-center gap-4 col-12 col-lg-8 mb-0">
                    <li class="poppins-regular font-18 mb-3 font-mob"><a href="{{route('index')}}">Home</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle poppins-regular font-18 font-mob mb-3" 
                            href="{{ route('blog') }}" 
                            id="noticiasDropdown" 
                            role="button" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false">
                            Notícias <i class="bi bi-chevron-down"></i>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="noticiasDropdown">
                            @if ($blogCategories->count())
                                @foreach ($blogCategories as $category)
                                    <li>
                                        <a class="dropdown-item poppins-regular text-start font-15 font-mob" 
                                        href="{{ route('blog', ['category' => $category->slug]) }}#news">
                                            {{ $category->title }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                    <li class="poppins-regular font-18 mb-3 font-mob"><a href="{{route('contact')}}">Contato</a></li>
                    <li class="poppins-regular font-18 mb-3 font-mob"><a href="https://policies.google.com/privacy?hl=pt-BR" target="_blank" rel="noopener noreferrer">Política de Privacidade</a></li>
                </ul>
            </div>
            <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                <div class="dark-background">
                    <nav class="site-navigation position-relative text-end w-25 redes-sociais">
                        <ul class="p-0 d-flex justify-content-start gap-3 flex-row mb-0">
                            @if (isset($contact) && $contact->link_insta)
                                <li class="li d-flex justify-content-start align-items-center rounded-circle">
                                    <a href="{{$contact->link_insta}}" rel="nofollow noopener noreferrer" target="_blank">
                                        <img src="{{asset('build/client/images/insta.svg')}}" alt="Instagram">
                                    </a>
                                </li>
                            @endif
                            @if (isset($contact) && $contact->link_x)
                                <li class="li d-flex justify-content-start align-items-center rounded-circle">
                                    <a href="{{$contact->link_x}}" rel="nofollow noopener noreferrer" target="_blank">
                                        <img src="{{asset('build/client/images/x.svg')}}" alt="X">
                                    </a>
                                </li>
                            @endif
                            @if (isset($contact) && $contact->link_youtube)
                                <li class="li d-flex justify-content-start align-items-center rounded-circle">
                                    <a href="{{$contact->link_youtube}}" rel="nofollow noopener noreferrer" target="_blank">
                                        <img src="{{asset('build/client/images/youtube.svg')}}" alt="Youtube">
                                    </a>
                                </li>
                            @endif
                            @if (isset($contact) && $contact->link_face)
                                <li class="li d-flex justify-content-start align-items-center rounded-circle">
                                    <a href="{{$contact->link_face}}" rel="nofollow noopener noreferrer" target="_blank">
                                        <img src="{{asset('build/client/images/face.svg')}}" alt="Facebook">
                                    </a>
                                </li>
                            @endif
                            @if (isset($contact) && $contact->link_tik_tok)
                                <li class="li d-flex justify-content-start align-items-center rounded-circle">
                                    <a href="{{$contact->link_tik_tok}}a" rel="nofollow noopener noreferrer" target="_blank">
                                        <img src="{{asset('build/client/images/tiktok.svg')}}" alt="Tiktok">
                                    </a>
                                </li>
                            @endif
                        </ul> 
                    </nav>
                </div>
                <div class="copyright">
                    <p id="footer-text" class="poppins-regular font-16 text-center text-lg-start text-white mb-0"></p>  
                    <script defer>
                        const currentYeaar = (new Date).getFullYear();
                        document.getElementById("footer-text").innerHTML = `Copyright© ${currentYeaar} <span> Pulso Notícias todos os direitos reservados.</span>`
                    </script>
                </div>
                <div class=credits>
                    <a href="#" target=_blank rel="noopener noreferrer">
                        <img src="{{asset('build/client/images/developed.svg')}}"  alt="WHI - Web de Alta Inovação" title="WHI - Web de Alta Inovação" loading=lazy>
                    </a>
                </div>
            </div>
        </div>
        <div class="menu-mobile-down w-100 position-fixed bottom-0 left-0 bg-blue-light">
            <ul class="list-unstyled h-100 d-flex justify-content-center align-items-center gap-3 p-0 position-relative">

                <li class="nav-mob-center position-absolute bg-blue-light">
                    <a href="#" class="icon-text btn_sidebar" title="Abrir menu principal" aria-label="Abrir menu principal" rel="noopener noreferrer">
                        <span class="menu-icon" style="display:inline-block;width:32px;height:32px;">
                            <span class="d-block w-100 rounded-1 background-red" style="height:4px;background:#FFF;margin:6px 0;"></span>
                            <span class="d-block w-100 rounded-1 background-red" style="height:4px;background:#FFF;margin:6px 0;"></span>
                            <span class="d-block w-100 rounded-1 background-red" style="height:4px;background:#FFF;margin:6px 0;"></span>
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </footer>
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    
    <script src="https://cdn.ckeditor.com/4.22.1/basic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="{{ asset('build/admin/js/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('build/admin/js/libs/dropzone/min/dropzone.min.js') }}"></script>
    <script src="{{ asset('build/admin/js/libs/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('build/admin/js/pages/form-fileuploads.init.js') }}"></script>
    <script src="{{ asset('build/client/css/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('build/client/lgpd/script.js') }}"></script>
    <script src="{{ asset('build/client/js/default.js') }}"></script>


    {{-- Modais alert --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let successMessage = @json(session('success'));
            let errorMessage = @json(session('error'));

            if (successMessage) {
                Swal.fire({
                    title: 'Sucesso!',
                    text: successMessage,
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
            }

            if (errorMessage) {
                Swal.fire({
                    title: 'Erro!',
                    text: errorMessage,
                    icon: 'error',
                    timer: 2500,
                    showConfirmButton: false
                });
            }
        });
    </script>

    @if (isset($errors) && $errors->any())
        @foreach ($errors->all() as $error)
            <script>
                Swal.fire({
                    title: 'Erro!',
                    text: @json($error),
                    icon: 'error',
                    timer: 2500,
                    showConfirmButton: false
                });
            </script>
        @endforeach
    @endif

    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", (function() {
            const o = document.createElement("script");
            o.src = "https://vlibras.gov.br/app/vlibras-plugin.js", o.onload = function() {
                window.VLibras && window.VLibras.Widget ? (new window.VLibras.Widget("https://vlibras.gov.br/app")) : console.warn("VLibras não foi carregado corretamente.")
            }, document.body.appendChild(o)
        }))
    </script>
    <script>
        document.addEventListener('click', function(event) {
            // Detecta QUALQUER botão de share que comece com btnShare
            const btn = event.target.closest('[id^="btnShare"]');
            if (!btn) return;

            console.log('Botão clicado:', btn.id);

            let itemId, linksId;

            // Nova verificação: filtro "two"
            if (btn.id.startsWith('btnShare-filter-two-')) {
                itemId = btn.id.replace('btnShare-filter-two-', '');
                linksId = 'socialLinks-filter-two-' + itemId;

            // Filtro comum
            } else if (btn.id.startsWith('btnShare-filter-')) {
                itemId = btn.id.replace('btnShare-filter-', '');
                linksId = 'socialLinks-filter-' + itemId;

            // Padrão normal
            } else if (btn.id.startsWith('btnShare-')) {
                itemId = btn.id.replace('btnShare-', '');
                linksId = 'socialLinks-' + itemId;
            }

            console.log('Procurando links com ID:', linksId);
            const links = document.getElementById(linksId);
            console.log('Links encontrados:', links);

            if (links) {
                links.classList.toggle('opacity-0');
                console.log('Toggle realizado!');
            }
        });

    </script>
</body>
</html>