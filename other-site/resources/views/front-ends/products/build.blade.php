@extends('front-ends.layouts.master')
@section('page_title', 'PRODUCTS')

@section('intro_section')
@endsection

@section('main_content')
    <section class="single__Detail">
        <div class="container mb-4">
            @if($data)
                <input type="hidden" name ="id" id ="id" value="{{$data->id ?? ''}}">
                <input type="hidden" name ="name" id ="name" value="{{$data->name ?? ''}}">
                <input type="hidden" id="feature-num" value="{{count($features) ?? 0}}" />
                <br>
                <!-- price -->
                <input type="hidden" id ="style-price" value="0">
                <input type="hidden" id ="size-price" value="0">
                <input type="hidden" id ="color-price" value="0">
                @foreach($features as $key => $feature)
                    <input type="hidden" id ="feature-price-{{$key}}" value="0">
                @endforeach
                <br>

                <input type="hidden" name ="price" id ="price" value="{{$data->price ?? ''}}">
                <input type="hidden" name ="final_price" id ="final-price">
                <br>

                <div class="col-md-12 row" id="product-order">
                    <div class="col-lg-6">
                        <!-- product info -->
                        <div class="property-top-section">
                            <div class="row mb-3">
                                <div class="col-md-8 col-lg-8">
                                    <div class="single__detail-title ">
                                        <p class="text-primary mb-2" style="font-size: 18px;">
                                            {{ $data->category->name ?? '' }} - 
                                            <span class="text-capitalize">{{$data->name ?? ''}}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4 col-lg-4">
                                    <div class="single__detail-price">
                                        <h3 class="text-capitalize text-gray property-price" id="property-price-val">₱{{number_format($data->price ?? 0, 2)}}</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12" style="padding-bottom: 17px !important;">
                                <img class="lazy" id="build-image-preview" src="{{$data->image ?? ''}}" onerror="this.src='/assets/images/default/no_image.png'" width="100%" max-height="456px;" alt="">
                            </div>
                        </div>

                        <!-- product view -->
                        <div class="row mb-4">
                            <div class="col-lg-12 checkout-page-wrapper">
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5 class="card-title">
                                            Product View
                                        </h5>
                                    </div>
                                    <div class="card-body " style="display: flex;justify-content: center;">
                                        <center></center>
                                        @foreach($product_views as $a => $product_view)
                                            <div class="text-center" style="flex: 0 0 auto;margin: 0 10px;">
                                                <input id="radio-{{$a}}" class="radio-view" name="radio_view" type="radio" value="{{$product_view->id ?? ''}}">
                                                <br><br>
                                                <label for="radio-{{$a}}" class="radio-view-label">{{$product_view->name ?? ''}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6">
                       
                        <!-- product style -->
                        <div class="col-md-12 property-owner-wrapper" id="divrow-style">
                            <div class="owner-title">
                                <h5>Product Style</h5>
                            </div>
                            <div class="owner-body col-md-12">
                                @foreach($data->productStyle as $key => $style)
                                    <div class="mb-4 ml-1 mr-1 row style-div" id="stylediv-{{$key}}" key-count="{{$key}}">
                                        <div class="col-md-5 mt-2 mb-2">
                                            <input type="radio" name="product_style" id="product-style-{{$key}}" value="{{$style->id}}" class="style-radio">
                                            <img src="{{$style->image ?? ''}}" onerror="this.src='/assets/images/default/no_image.png'" class="style-image">
                                        </div>

                                        <div class="col-md-7 mt-2 mb-2">
                                            <h6>{{$style->name ?? ''}}</h6>
                                            <p class="syle-text">
                                                {{ \App\Helpers\CommonHelper::getSubStr($style->description ?? '', 50, '...') }}
                                            </p>
                                            <p class="style-price">
                                                @if($style->price != 0)
                                                    + ₱ {{number_format($style->price ?? 0, 2)}}
                                                @else
                                                    &nbsp;
                                                @endif
                                            </p>
                                            <input type="hidden" id="pricestyle-{{$key}}" value="{{$style->price ?? 0}}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-md-12 text-right mb-3">
                                <button type="button" class="btn btn-outline-dark ml-2 ml-sm-0 btn-sm-on-small" onclick="pageChange('divrow-style','divrow-size')">
                                    &emsp;Next&emsp;
                                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>

                        <!-- product size -->
                        <div class="col-md-12 property-owner-wrapper" id="divrow-size">
                            <div class="owner-title">
                                <h5>Product Size</h5>
                            </div>
                            <div class="owner-body col-md-12">
                                <div class="row col-md-12">
                                    
                                    <div class="col-md-6">
                                        <span style="font-weight:bold;font-size: 18px;">Custom Size</span>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <button type="button" class="btn btn-outline-warning text-right" onclick="viewPriceSize();">View Price Sizes</button>
                                    </div>
                                    <br>

                                    <div class="col-md-6" style="">
                                        <img src="" onerror="this.src='/assets/images/default/no_image.png'" class="size-image" id="size-img">
                                    </div>
                                    <div class="col-md-6" id="div-size">
                                    </div>

                                    <div class="center div-border-line mt-3"></div>
                                    <div class="col-md-12">
                                        <div class="row col-md-12 mb-4">
                                            <div class="col-md-6">
                                                <span style="font-weight:bold;font-size: 18px;">Basic Size</span>
                                            </div>
                                        </div>
                                        @foreach($basic_sizes as $q => $basic_size)
                                            <div class="col-md-12 mb-4 ml-1 mr-1 basic-size-div" id="basicsizediv-{{$q}}">
                                                <label>
                                                    <input type="radio" class="basic-radio" id="basic-radio-{{$q}}" name="basic_radio" value="{{$basic_size->id}}" />
                                                    <span class="basic-span">{{$basic_size->size}}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="col-md-12">
                                        <span style="font-weight:bold;font-size: 18px;">Layout Design</span>
                                            <div class="col-md-12 text-center mt-2 mb-4">
                                                <div class="switch-field">
                                                    <input class="layoutdesignradio" type="radio" id="radio-one" name="layout_design" value="As illustrated" checked/>
                                                    <label for="radio-one">
                                                        <span class="hide-mobile show-pc" style="font-size: 20px;">
                                                            &nbsp;&nbsp;&emsp;&nbsp;&nbsp;As illustrated&emsp;&nbsp;&nbsp;&nbsp;
                                                        </span>
                                                        <span class="show-mobile hide-pc" style="font-size: 15px;">&nbsp;&nbsp;Illustrated&nbsp;&nbsp;</span>
                                                    </label>

                                                    <input class="layoutdesignradio" type="radio" id="radio-two" name="layout_design" value="Mirrored" />
                                                    <label for="radio-two">
                                                        <span class="hide-mobile show-pc" style="font-size: 20px;">
                                                            &nbsp;&nbsp;&emsp;&nbsp;&nbsp;Mirrored&emsp;&nbsp;&nbsp;&nbsp;
                                                        </span>
                                                        <span class="show-mobile hide-pc" style="font-size: 15px;">&nbsp;&nbsp;Mirrored&nbsp;&nbsp;</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <input type="hidden" id="size-type" value="basic_size"/>
                                <input type="hidden" id="custom-width-count" value="0" />

                                <div class="col-md-12 text-right mb-4">
                                    <button type="button" class="btn btn-outline-warning mr-2 ml-sm-0 btn-sm-on-small" onclick="pageChange('divrow-size','divrow-style')">
                                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                        Back&emsp;
                                    </button>
                                    <button type="button" class="btn btn-outline-dark ml-2 ml-sm-0 btn-sm-on-small" onclick="pageChange('divrow-size','divrow-color')">
                                        &emsp;Next&emsp;
                                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- product color -->
                        <div class="col-md-12" id="divrow-color">
                            <div class="property-owner-wrapper">
                                <div class="owner-title">
                                    <h5>Product Color</h5>
                                </div>
                                <div class="owner-body col-md-12">
                                    @foreach($product_colors as $key => $color)
                                        <div class="col-md-10 row color-div mb-5 div-center" id="colordiv-{{$key}}" key-count="{{$key}}">
                                            <div class="col-md-4 mt-3 mb-3">
                                                <input type="radio" name="color_style" id="color-style-{{$key}}" value="{{$color->id}}" class="color-radio">
                                                <img src="{{$color->image ?? ''}}" onerror="this.src='/assets/images/default/no_image.png'" class="color-image" id="colorimage-{{$key}}">
                                            </div>
                                            <div class="col-md-8 center">
                                                <h6 class="mt-3">{{$color->name ?? ''}}</h6>
                                                <p class="color-text">
                                                    {{ \App\Helpers\CommonHelper::getSubStr($color->description ?? '', 300, '...') }}
                                                </p>
                                                @if($color->price != 0)
                                                    <p class="color-price">
                                                        + ₱ {{number_format($color->price ?? 0, 2)}}
                                                    </p>
                                                @endif
                                                <input type="hidden" id="pricecolor-{{$key}}" value="{{$color->price ?? 0}}">
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="col-md-12 text-right mb-4">
                                        <button type="button" class="btn btn-outline-warning mr-2 ml-sm-0 btn-sm-on-small" onclick="pageChange('divrow-color','divrow-size')">
                                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                            Back&emsp;
                                        </button>
                                        @if(count($features) > 0)
                                            <button type="button" class="btn btn-outline-dark ml-2 ml-sm-0 btn-sm-on-small" onclick="pageChange('divrow-color','divrow-feature-0')">
                                                &emsp;Next
                                                <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-outline-success mr-2 ml-sm-0 btn-sm-on-small" onclick="showSummary()">
                                                &emsp;Summary
                                                <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- product feature -->
                        @foreach($features as $key => $feature)
                            <div class="col-md-12 divrowfeature" id="divrow-feature-{{$key}}">
                                <div class="property-owner-wrapper">
                                    <div class="owner-title">
                                        <h5>Product Features</h5>
                                        <input type="hidden" id="feature-id-{{$key}}" value="{{$feature->id ?? ''}}">
                                    </div>
                                    <div class="owner-body col-md-12 mb-4">
                                        <p class="col-md-12 ml-2" style="font-size: 18px;">{{$feature->name ?? ''}}</p>
                                        @foreach($feature->productFeatureDetail as $key2 => $fdetail)
                                            <div class="col-md-10 row feature-div mb-5 div-center featurediv-{{$key}}" id="featurediv{{$key}}-{{$key2}}" key-count="{{$key}}" key2-count="{{$key2}}">
                                                
                                                <div class="col-md-4 mt-3 mb-3">
                                                    <input type="radio" name="feature_style{{$key}}" id="feature-style{{$key}}-{{$key2}}" value="{{$fdetail->id}}" class="feature-radio">
                                                    <img src="{{$fdetail->image ?? ''}}" onerror="this.src='/assets/images/default/no_image.png'" class="feature-image featureimage-{{$key}}" id="featureimage{{$key}}-{{$key2}}">
                                                </div>

                                                <div class="col-md-8 center">
                                                    <h6 class="mt-3">{{$fdetail->name ?? ''}}</h6>
                                                    <p class="feature-text">
                                                        {{ \App\Helpers\CommonHelper::getSubStr($fdetail->description ?? '', 300, '...') }}
                                                    </p>
                                                    @if($fdetail->price != 0)
                                                        <p class="feature-price">
                                                            + ₱ {{number_format($fdetail->price ?? 0, 2)}}
                                                        </p>
                                                    @endif
                                                    <input type="hidden" id="pricefeature{{$key}}-{{$key2}}" value="{{$fdetail->price ?? 0}}">
                                                </div>
                                            </div>
                                        @endforeach
                                        <div class="col-md-12 text-right">
                                            <?php 
                                                $s = $key + 1; 
                                                $h = $key - 1;
                                                if($h < 0){
                                                    $h = 0;
                                                }
                                            ?>
                                            @if($key == 0)
                                                <button type="button" class="btn btn-outline-warning mr-2 ml-sm-0 btn-sm-on-small" onclick="pageChange('divrow-feature-0','divrow-color')">
                                                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                                    Back&emsp;
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-outline-warning mr-2 ml-sm-0 btn-sm-on-small" onclick="pageChange('divrow-feature-{{$key}}','divrow-feature-{{$h}}')">
                                                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                                    Back&emsp;
                                                </button>
                                            @endif

                                            @if($key + 1 == count($features))
                                                <button type="button" class="btn btn-outline-success ml-2 ml-sm-0 btn-sm-on-small" onclick="showSummary()">
                                                    &emsp;Summary
                                                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-outline-dark ml-2 ml-sm-0 btn-sm-on-small" onclick="pageChange('divrow-feature-{{$key}}','divrow-feature-{{$s}}')">
                                                    &emsp;Next
                                                    <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- summary -->
                @include('front-ends.products.summary')
                @include('front-ends.products.sizeprice-modal')
            @else
                <div class="col-md-12 mt-10 mb-10">
                    <div class="product-price text-capitalize" style="font-size: 25px;padding-top: 100px;padding-bottom: 200px;">
                        Property Not Found
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection

@section('page_css')
    <link href="{{ asset('assets/css') }}/build.css" rel="stylesheet">
    <style type="text/css">
        @media (max-width: 576px) {
            .btn-sm-on-small {
                /*font-size: 0.875rem;*/
                font-size: 0.85rem;
                padding: 0.25rem 0.5rem; /* Adjust padding for smaller screens */
            }
            .table-summary{
                margin-left: -15px !important;
            }
        }
    </style>
@endsection

@section('page_js')
    <script type="text/javascript" src="/js/front-ends/products/build.js" ></script>
    <script type="text/javascript" src="/js/front-ends/products/summary.js" ></script>
@endsection