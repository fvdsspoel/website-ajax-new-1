@extends('front-ends.layouts.master')
@section('page_title', 'CONTACT US')

@section('intro_section')
    <div id="carouselExampleIndicators" class="watermark carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                @handheld
                    <img class="d-block bg-theme-overlay responsive-banner" src="{{$contact_mobile_banner ?? 'assets/images/covers/c1.jpg'}}">
                @elsehandheld
                    <img class="d-block bg-theme-overlay responsive-banner" src="{{$contact_banner ?? 'assets/images/covers/c1.jpg'}}">
                @endhandheld
            </div>
        </div>
    </div>
@endsection

@section('main_content')
    <section class="wrap__contact-form">
        <div class="container">
            <form id="add-corporate-form">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <h5>contact us</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-name">
                                    <label>Your name <span class="required"></span></label>
                                    <input type="text" class="form-control" name="name" id="name" required="">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>Your email <span class="required"></span></label>
                                    <input type="email" class="form-control" name="email" id="email" required="">

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>Phone <span class="required"></span></label>
                                    <input type="text" class="form-control" name="phone" id="phone" required="">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Subject <span class="required"></span></label>
                                    <input type="text" class="form-control" name="subject" id="subject" required="">
                                    <input type="hidden" class="form-control" name="type" id="type" value="Contact Us Inquiry">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Your message </label>
                                    <textarea class="form-control" rows="9" name="message" id="message"></textarea>
                                </div>
                                <div class="form-group float-right mb-0">
                                    <button type="submit" class="btn btn-primary btn-contact" onclick="sendInqury('{{ csrf_token() }}')">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h5>Info location</h5>
                        <div class="wrap__contact-form-office">
                            <ul class="list-unstyled">
                                <li>
                                    <span>
                                        <i class="fa fa-home"></i>
                                    </span>
                                    {{$cms_address}}
                                </li>
                                <li>
                                    <span>
                                        <i class="fa fa-phone"></i>
                                        <a href="tel:{{$cms_contact_no}}">{{$cms_contact_no}}</a>
                                    </span>

                                </li>
                                <li>
                                    <span>
                                        <i class="fa fa-envelope"></i>
                                        <a href="mailto:{{$cms_email}}">{{$cms_email}}</a>
                                    </span>

                                </li>
                            </ul>

                            <div class="social__media">
                                <h5>find us</h5>
                                <ul class="list-inline">

                                    <li class="list-inline-item">
                                        <a href="{{$cms_fb}}" class="btn btn-social rounded text-white facebook">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="{{$cms_twitter}}" class="btn btn-social rounded text-white twitter">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="{{$cms_intagram}}" class="btn btn-social rounded text-white instagram">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="{{$cms_yt}}" onclick="sendInqury();" class="btn btn-social rounded text-white youtube">
                                            <i class="fa fa-youtube-play" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('page_css')
@endsection

@section('page_js')
    <script type="text/javascript" src="/js/front-ends/contact-us/corporate.js" ></script>
@endsection