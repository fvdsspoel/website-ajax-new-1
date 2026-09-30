@extends('front-ends.layouts.master')
@section('page_title', 'ABOUT US')

@section('intro_section')
    <div id="carouselExampleIndicators" class="watermark carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                @handheld
                    <img class="d-block bg-theme-overlay responsive-banner" src="{{$about_mobile_banner ?? 'assets/images/covers/c1.jpg'}}">
                @elsehandheld
                    <img class="d-block bg-theme-overlay responsive-banner" src="{{$about_banner ?? 'assets/images/covers/c1.jpg'}}">
                @endhandheld
            </div>
        </div>
    </div>
@endsection

@section('main_content')
    <!-- company mission -->
    <section class="home__about">
        <div class="container">
            <!-- about us -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="title__leading center-content">
                        <h5 class="text-capitalize text-primary">Ajax Trading and Their Mission</h5>
                        {!! $about_detail !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about__image">
                        <img src="{{$about_detail_banner}}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- teams -->
    <span  id="the-team"></span>
    <section class="profile__agents" style="padding: 0 !important;">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-6 mx-auto">
                    <div class="title__head">
                        <h2 class="text-center text-capitalize title-head-title">
                            Meet the team
                        </h2>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    @foreach($teams as $team)
                        <div class="col-md-4 col-sm-6 col-6 our-team-new">
                            <div class="pic">
                                <img src="{{$team->image ?? '/assets/images/default/no_image.png'}}" onerror="this.src='/assets/images/default/no_image.png'">
                            </div>
                            <div class="team-content">
                                <h3 class="title">{{$team->name ?? ''}}</h3>
                                <span class="post">{{$team->position ?? ''}}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- our partners -->
    <span  id="our-partners"></span>
    <section class="profile__agents">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-6 mx-auto">
                    <div class="title__head">
                        <h2 class="text-center text-capitalize title-head-title">
                            our Partners
                        </h2>
                        <p class="text-center title-head-subtitle">Our valuable partners.</p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                <div class="client-carousel owl-carousel owl-theme">
                    @foreach($clients as $client)
                        <div class="item our-client-new">
                            <div class="pic">
                                <img src="{{$client->image ?? '/assets/images/default/no_image.png'}}" onerror="this.src='/assets/images/default/no_image.png'" alt="" class="img-fluid">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- our services -->
    <span  id="our-services"></span>
    <section class="popular__city-large section-padding pt-0">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-6 mx-auto">
                    <div class="title__head">
                        <h2 class="text-center text-capitalize title-head-title">
                             Our Services
                        </h2>
                        <p class="text-center title-head-subtitle">We deliver client-focused results across a range of services</p>

                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                @foreach($our_services as $our_service)
                    <div class="col-md-6 col-lg-4 col-6 mpx-10px5px">
                        <!-- CARD IMAGE -->
                        <!-- <a href=""> -->
                            <div class="card__image-hover-style-v3">
                                <div class="card__image-hover-style-v3-thumb h-230">
                                    <img src="{{$our_service->image ?? '/assets/images/default/no_image.png'}}" onerror="this.src='/assets/images/default/no_image.png'" alt="" class="img-fluid w-100">
                                </div>
                                <div class="overlay">
                                    <div class="desc">
                                        <h6 class="text-capitalize">{{$our_service->name ?? ''}}</h6>
                                    </div>
                                </div>
                            </div>
                        <!-- </a> -->
                    </div>
                @endforeach
            </div>
        </div>
    </section>


    <!-- portfolio -->
    <span  id="our-portfolio"></span>
    <section class="cta-v1 py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-6 mx-auto">
                    <div class="title__head">
                        <h2 class="text-center text-capitalize title-head-title text-white">
                            our portfolio
                        </h2>
                        <p class="text-center title-head-subtitle text-white">Some of Our Works</p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                <div class="portfolio-carousel owl-carousel owl-theme">
                    
                    @foreach($portfolios as $portfolio)
                        <div class="custom-col-product mb-4">
                            <div class="item">
                                <div class="product-item ghr-item" style="height: 500px;">
                                    <a href="/properties/list?property_type=Apartment or Condominium" class="product-img">
                                        <img src="{{$portfolio->image ?? '/assets/images/default/no_image.png'}}" onerror="this.src='/assets/images/default/no_image.png'" alt="">
                                    </a>
                                    <div class="product-price text-capitalize" style="margin-top: 20px;">
                                        {{$portfolio->name ?? ''}}
                                    </div>
                                    <p class="ghr-top">
                                        {{ \App\Helpers\CommonHelper::getSubStr($portfolio->description ?? '', 180, '...') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </section>

@endsection

@section('page_css')
@endsection

@section('page_js')
    <script type="text/javascript" src="/js/front-ends/about-us/index.js" ></script>
@endsection