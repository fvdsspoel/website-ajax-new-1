@extends('front-ends.layouts.master')
@section('page_title', 'PRODUCTS')

@section('intro_section')
@endsection

@section('main_content')
    <section class="single__Detail mt-10 mb-10">
        <div class="container">
            @if($data)
                <div class="row" style="padding-top: 50px;padding-bottom: 50px;">
                    <div class="col-lg-12">
                        <div class="property-top-section">
                            <div class="row mb-3">
                                <div class="col-md-8 col-lg-8">
                                    <div class="single__detail-title ">
                                        <p class="text-primary mb-2" style="font-size: 15px;">{{ $data->category->name ?? '' }}</p>
                                        <h3 class="text-capitalize">{{$data->name ?? ''}}</h3>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="single__detail-price">
                                        <h3 class="text-capitalize text-black property-price">₱ {{number_format($data->price ?? 0, 2)}}</h3>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a href="/products/build/{{$data->id}}" class="badge badge-primary p-2 rounded property-type-badge" style="font-size: 16px !important;">
                                                    <i class="fa fa-th-large" aria-hidden="true"></i>
                                                    Build this {{$data->category->name ?? 'Product'}}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- SLIDER IMAGE DETAIL -->
                            <div class="slider__image__detail-large owl-carousel owl-theme">
                                @foreach($images as $image)
                                    <div class="item">
                                        <div class="slider__image__detail-large-one">
                                            <img src="{{$image ?? ''}}" onerror="this.src='/assets/images/default/no_image.png'" alt="" class="img-fluid w-100 img-transition"  style="height: 450px !important;object-fit:contain;">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-2"></div> -->
                                <div class="slider__image__detail-thumb owl-carousel owl-theme">
                                    @foreach($images as $image)
                                        <div class="item">
                                            <div class="slider__image__detail-thumb-one">
                                                <img src="{{$image ?? ''}}" onerror="this.src='/assets/images/default/no_image.png'" alt="" alt="" class="img-fluid w-80 img-transition">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                               <!--  <div class="col-md-2"></div>
                            </div> -->
                            <!-- END SLIDER IMAGE DETAIL -->
                        </div>

                        <div class="row">
                            <div class="col-lg-12 checkout-page-wrapper">
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            Description
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="description-wrapper">
                                            {!! $data->description ?? '' !!}
                                        </div>
                                    </div>

                                    <div class="col-md-12 text-right mb-4">
                                        <a href="/products/build/{{$data->id}}" class="badge badge-primary p-2 rounded property-type-badge" style="font-size: 16px !important;">
                                            <i class="fa fa-th-large" aria-hidden="true"></i>
                                            Build this {{$data->category->name ?? 'Product'}}
                                        </a>

                                        <button href="#" class="badge btn-success p-2 rounded property-type-badge" style="font-size: 16px !important;" value="{{$data->id ?? ''}}" onclick="chatProperty(this.value);">
                                            <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                            Live Chat
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @else
                <div class="col-md-12 mt-10 mb-10">
                    <div class="product-price text-capitalize" style="font-size: 25px;padding-top: 100px;padding-bottom: 200px;">
                        Property Not Found
                    </div>
                </div>
            @endif
            <input type="hidden" id="product-convo-id" value="{{$convo_id ?? ''}}">
            <input type="hidden" id="product-name" value="{{$data->name ?? ''}}">
            <input type="hidden" id="product-type" value="Buildable">
        </div>
    </section>
@endsection

@section('page_css')
@endsection

@section('page_js')
@endsection