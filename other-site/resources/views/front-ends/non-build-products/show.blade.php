@extends('front-ends.layouts.master')
@section('page_title', $data->name ?? '')

@section('intro_section')
    <style type="text/css">
        .inquire-label {
            font-weight: 600;
            font-size: 16px;
        }
        .sub-font {
            font-family: "Arial Narrow", Arial, sans-serif !important;
        }
        .required {
            color: red;
        }
        .inquire-control {
            width: 100%;
            border: none;
            border-radius: 0;
            background: transparent;
            font-family: MuseoSans-500;
            color: #000;
            font-size: 15px;
            padding: 10px;
            border-bottom: 1px solid #e8c765 !important;
        }
        .inquire-control {
            padding: 0px !important;
        }
    </style>
@endsection

@section('main_content')
    <section class="featured__property section-padding">
        <div class="container">
            <div class="row col-md-12">
                @if($data)
                    <div class="row" style="padding-top: 50px;padding-bottom: 50px;">
                        <div class="col-lg-6">
                            <div class="property-top-section">
                                <div class="row mb-3">
                                    <div class="col-md-8 col-lg-8">
                                        <div class="single__detail-title ">
                                            <p class="text-primary mb-2" style="font-size: 15px;">{{ strtoupper($data->nonBuildProduct->name ?? '')}} - {{ strtoupper($data->nonBuildProduct->category->name ?? '')}}</p>
                                            <h3 class="text-capitalize">{{$data->name ?? ''}}</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-4"></div>
                                </div>
                                <!-- Image -->
                                <div class="col-md-12" style="padding-bottom: 17px !important;">
                                    <img class="lazy" id="build-image-preview" src="{{$data->image ?? ''}}" onerror="this.src='/assets/images/default/no_image.png'" width="100%" max-height="456px;" alt="">
                                </div>
                            </div>
                            <!-- description -->
                            <div class="row mb-4">
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

                                            <div class="form-group float-right mt-2">
                                                <button class="main-font btn btn-danger btn-contact" value="{{$data->id ?? ''}}" onclick="chatProperty(this.value);">
                                                    <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                                    Live Chat
                                                </button>
                                                <input type="hidden" id="product-convo-id" value="{{$convo_id ?? ''}}">
                                                <input type="hidden" id="product-name" value="{{$data->name ?? ''}}">
                                                <input type="hidden" id="product-type" value="Non Buildable">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="property-top-section">
                                <form id="add-corporate-form">
                                    @csrf
                                    <br>
                                    <h5 class="main-font text-center inquiry-title">Product Inquiry Form</h5>
                                    <br>
                                    <div class="row pl-5 pr-5">
                                        <div class="col-md-12 mb-4">
                                            <div class="fonm-control">
                                                <label class="sub-font inquire-label">Your name <span class="required">*</span></label>
                                                <input type="text" class="inquire-control" name="name" id="name" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12  mb-4">
                                            <div class="form-group ">
                                                <label class="sub-font inquire-label">Your email <span class="required">*</span></label>
                                                <input type="email" class="inquire-control" name="email" id="email" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12  mb-4">
                                            <div class="form-group ">
                                                <label class="sub-font inquire-label">Phone <span class="required">*</span></label>
                                                <input type="text" class="inquire-control" name="phone" id="phone" required>
                                            </div>
                                        </div>

                                        <div class="col-md-12  mb-4">
                                            <div class="form-group">
                                                <label class="sub-font inquire-label">Subject <span class="required">*</span></label>
                                                <input type="text" class="inquire-control" name="subject" id="subject" required>
                                                <input type="hidden" class="inquire-control" name="type" id="type" value="Corporate Inquiry">
                                            </div>
                                        </div>

                                        <div class="col-md-12  mb-4">
                                            <div class="form-group">
                                                <label class="sub-font inquire-label">Products I am interested in</label>
                                                <input type="text" class="inquire-control" name="message" id="message" required value="{{$data->name ?? ''}}">
                                            </div>
                                        </div>
                                        <div class="col-md-12  mb-4">
                                            <div class="form-group float-right ">
                                                <button class="main-font btn btn-primary btn-contact" value="{{Auth::user()->id ?? ''}}" id="eid">
                                                    <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                                                    Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-md-12 mt-10 mb-10">
                        <div class="product-price text-capitalize" style="font-size: 25px;padding-top: 100px;padding-bottom: 200px;">
                            Product Not Found
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection

@section('page_css')
@endsection

@section('page_js')
    <script type="text/javascript" src="/js/front-ends/non-build-products/index.js" ></script>
@endsection