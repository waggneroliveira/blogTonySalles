@extends('client.core.client')

@section('content')
    @if (isset($abouts) && $abouts <> null)        
        <section id="about" class="position-relative mb-5">
            <div class="container">
                @foreach ($abouts as $about)
                    <div class="about-item">

                        <div class="border-bottom mb-5 pb-3 pt-4 pt-lg-5" data-aos="fade-right" data-aos-delay="100">
                            <h2 class="section-title w-auto m-0 poppins-bold font-22 title-blue">
                                {{$about->title}}
                            </h2>
                        </div>

                        <div id="{{$about->slug}}" class="d-flex justify-content-between align-items-start about flex-wrap w-100">
                            @if ($about->path_image)
                                <div class="col-12 col-lg-4 animate-on-scroll mb-3" data-aos="fade-right" data-aos-delay="100">
                                    <div class="image d-flex justify-content-end align-items-start">
                                        <img src="{{asset('storage/' . $about->path_image)}}" alt="About"
                                            class="w-100 h-100 about-image d-sm-block" loading="lazy">
                                    </div>
                                </div>

                                <div class="col-12 col-lg-7 animate-on-scroll" data-aos="fade-left" data-aos-delay="100">                        
                                    <div class="description mt-0 text-blog-inner poppins-medium font-16">
                                        {!! $about->text !!}
                                    </div>
                                </div>
                            @else
                                <div class="col-12 animate-on-scroll w-100" data-aos="fade-left" data-aos-delay="100">
                                    <div class="border-bottom mb-0">
                                        <h2 class="section-title rounded-top-left d-table px-4 w-auto m-0 poppins-bold font-18 title-blue">
                                            {{$about->title}}
                                        </h2>
                                    </div>
                            
                                    <div class="description mt-0 text-blog-inner poppins-medium font-16">
                                        {!! $about->text !!}
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($loop->first && !empty($directions))
                            <div class="row g-4 m-auto mt-0 justify-content-center col-12 col-lg-11" data-aos="fade-up" data-aos-delay="100">
                                @foreach ($directions as $direction)
                                    <div class="col-md-3 col-sm-12 p-0">
                                        <div class="d-flex justify-content-center flex-column gap-3 align-items-center bg-blue-light p-2 col-12 col-lg-11" style="min-height: 240px;">
                                            @if ($direction->path_image <> null)
                                                <div class="image" style="width: 50px; height:50px;">
                                                    <img src="{{asset('storage/' . $direction->path_image)}}" loading="lazy" class="h-100" alt="{{$direction->title}}">
                                                </div>
                                                <div class="description d-flex flex-column justify-content-center">
                                                    <h5 class="mb-2 poppins-bold text-center font-17 title-blue">{{$direction->title}}</h5>
                                                    <p class="poppins-regular text-center text-black font-14 mb-0">{{$direction->description}}</p>
                                                </div>
                                            @else
                                                <div class="description d-flex flex-column justify-content-center">
                                                    <h5 class="mb-2 poppins-bold text-center font-17 title-blue">{{$direction->title}}</h5>
                                                    <p class="poppins-regular text-center text-black font-14 mb-0">{{$direction->description}}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>       
    @endif

    <div class="container" data-aos="fade" data-aos-delay="100">
        @include('client.includes.complaint');
    </div>

@endsection