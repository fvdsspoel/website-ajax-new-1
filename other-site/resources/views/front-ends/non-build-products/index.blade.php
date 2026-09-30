@extends('front-ends.layouts.master')
@section('page_title', $category->name ?? '')

@section('intro_section')
@endsection

@section('main_content')
    <section class="featured__property section-padding">
        <div class="container">
            <div class="row col-md-12">
                <div class="col-md-3">
                    <div class="search__area service-search-area">
                        <div class="search__area-inner">
                            <div class="product-price text-capitalize">{{strtoupper($category->name ?? '')}}</div>
                            <br>
                            <form action="" method="GET" id="search-form">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 filter-column">
                                        <div class="form-group">
                                            <input type="text" placeholder="Enter Product Name" name="keyword" class="form-control" value="{{ $keyword }}">
                                        </div>
                                    </div>
                                   <div class=" col-lg-12 col-md-12 filter-column">
                                        <div class="form-group">
                                            <select class="form-control" name="product_id" id="product-id">
                                                @foreach($products as $product)
                                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" id="product-val" value="{{ $product_id ?? '' }}">
                                        </div>
                                    </div>
                                    <div class=" col-lg-12 col-md-12 filter-column">
                                        <div class="form-group">
                                            <button class="btn btn-primary btn-block text-capitalize" style="border-radius: 20px;">
                                                <i class="fa fa-search"></i> Search
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="col-md-12 row">
                        @if(count($results) == 0)
                            <div class="product-price text-capitalize mt-5 center" style="font-size: 25px;">
                                No Products Available
                            </div>
                        @else
                            @foreach($results as $result)
                                <div class="col-md-4 mt-20 mb-4">
                                    <div class="item">
                                        <div class="product-item property-item">
                                            <a href="/non-build-products/show/{{$result->name ?? ''}}/{{$result->id}}" class="product-img">
                                                <img src="{{$result->image}}"  onerror="this.onerror=null;this.src='/assets/images/default/no_image.png'"alt="">
                                            </a>
                                            <div class="card__image__body">
                                                <div class="product-price text-capitalize">
                                                    {{ \App\Helpers\CommonHelper::getSubStr($result->name ?? '', 12) }}
                                                </div>
                                                <div class="card__image__body-desc">
                                                    <p class="text-capitalize">
                                                        <i class="fa fa-info-circle"></i>
                                                        {{ \App\Helpers\CommonHelper::getSubStr(Strip_tags($result->description ?? ''), 90, '...') }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="property-see-more">
                                                <a href="/non-build-products/show/{{$result->name ?? ''}}/{{$result->id}}" class="btn btn-primary mt-3 text-capitalize center"> 
                                                    Learn more
                                                    <i class="fa fa-angle-right ml-3 "></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="right mt-5">
                        {!! $results->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('page_css')
@endsection

@section('page_js')
    <script type="text/javascript" src="/js/front-ends/non-build-products/index.js" ></script>
@endsection