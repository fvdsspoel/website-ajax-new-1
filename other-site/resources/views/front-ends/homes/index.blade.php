@extends('front-ends.layouts.master')
@section('page_title', 'AJAX DESIGN INC.')

@section('intro_section')
    <div id="carouselExampleIndicators" class="watermark carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                @handheld
                    <img class="d-block bg-theme-overlay responsive-banner" src="{{$home_mobile_banner ?? 'assets/images/covers/c1.jpg'}}">
                @elsehandheld
                    <img class="d-block bg-theme-overlay responsive-banner" src="{{$home_banner ?? 'assets/images/covers/c1.jpg'}}">
                @endhandheld
            </div>
        </div>
    </div>
@endsection

@section('main_content')

	<!-- featured products -->
	<section class="featured__property section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-6 mx-auto">
                    <div class="title__head">
                        <h2 class="text-center text-capitalize title-head-title">
                            our featured properties
                        </h2>
                        <p class="text-center title-head-subtitle">handpicked exclusive properties by our team.</p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="featured__property-carousel owl-carousel owl-theme">
                        @foreach($featureds as $featured)
                            <div class="item">
                                <div class="card__image card__box">
                                    <div class="card__image-header h-250">
                                        <a href="/products/build/{{$featured->id}}" target="_blank">
                                            <div class="ribbon text-capitalize">featured</div>
                                            <img src="{{$featured->image ?? ''}}" onerror="this.src='/assets/images/default/no_image.png'" alt="" class="img-fluid w100 img-transition">
                                            <div class="info"> {{$featured->category->name ?? ''}}</div>
                                        </a>
                                    </div>
                                    <div class="card__image-body">
                                        <!-- <a href=""> -->
                                            <span class="badge badge-primary text-capitalize mb-2">
                                                {{$featured->subCategory->name ?? ''}}
                                            </span>
                                            <h6 class="text-capitalize prop-card-title" title="ddfdf">
                                                {{ \App\Helpers\CommonHelper::getSubStr($featured->name ?? '', 25, '...') }}
                                            </h6>

                                            <p class="text-capitalize prop-card-location">
                                                <i class="fa fa-info-circle"></i>
                                                {{ \App\Helpers\CommonHelper::getSubStr(Strip_tags($featured->description ?? ''), 45, '...') }}
                                            </p>
                                        <!-- </a> -->
                                    </div>
                                    <div class="card__image-footer">
                                        <ul class="list-inline my-auto">
                                            <li class="list-inline-item">
                                                <h6>₱ {{number_format($featured->price ?? 0, 2)}}</h6>
                                            </li>
                                        </ul>

                                        <ul class="list-inline my-auto ml-auto">
                                            <li class="list-inline-item ">
                                                <a href="/products/build/{{$featured->id}}" target="_blank" class="btn btn-primary mt-3 text-white">
                                                    Build me
                                                    <i class="fa fa-cart-arrow-down ml-3 "></i>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <!-- end -->
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- categories -->
    <section class="featured__property section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-6 mx-auto">
                    <div class="title__head">
                        <h2 class="text-center text-capitalize title-head-title">
                            category
                        </h2>
                        <p class="text-center title-head-subtitle">Browse categories.</p>

                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="featured__property-carousel owl-carousel owl-theme">
                        @foreach($categories as $category)
                            <div class="card__image card__box">
                                <div class="card__image-hover-style-v3">
                                    <div class="card__image-hover-style-v3-thumb h-530">
                                        <img src="{{$category->image ?? '/assets/images/default/no_image.png'}}" onerror="this.src='/assets/images/default/no_image.png'" alt="" class="img-fluid w-100">
                                    </div>

                                    <div class="overlay">
                                        <h6 class="text-capitalize bottom-right text-white">{{$category->name ?? ''}}</h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- our partners -->
    <section class="profile__agents">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 mx-auto">
                    <div class="title__head">
                        <h2 class="text-center text-capitalize title-head-title">
                            Our Partners
                        </h2>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                @foreach($partners as $partner)
                    <div class="col-md-2 col-sm-4 col-4 mpx-5px">
                        <div class="our-client-new">
                            <div class="pic">
                                <img src="{{$partner->image ?? '/assets/images/default/no_image.png'}}" onerror="this.src='/assets/images/default/no_image.png'">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-12">
                <div align="right">
                    <a href="/about-us#our-partners" class="see-all">SEE ALL >>></a>
                </div>
            </div>
            <hr>
        </div>
    </section>

    <!-- client feedbacks -->
   <!--  <section class="explore-feature section-padding pt-0">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-lg-6 mx-auto">
                    <div class="title__head">
                        <h2 class="text-center text-capitalize title-head-title">
                            Clients Feedbacks
                        </h2>
                        <p class="text-center title-head-subtitle">"We value your thoughts and suggestions. Your feedback helps us enhance your experience. We're committed to continuous improvement based on your insights."</p>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="client-carousel  owl-carousel owl-theme">
                @for($i = 0; $i < 10; $i++)
                    <div class="serviceBox blue" style="min-height: 250px;">
                        <div class="service-icon">
                            <img src="/assets/images/icons/user.webp" alt="">
                        </div>
                        <h3 class="title">Client {{$i + 1}}</h3>
                        <p class="description ">
                            {{ \App\Helpers\CommonHelper::getSubStr('In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content.', 150, '...') }}
                        </p>
                    </div>
                @endfor
            </div>
        </div>
    </section> -->
@endsection

@section('page_css')
@endsection

@section('page_js')
    <script type="text/javascript" src="/js/front-ends/homes/index.js" ></script>
@endsection