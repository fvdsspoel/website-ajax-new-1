@extends('front-ends.layouts.master')
@section('page_title', 'CONTACT US')

@section('intro_section')
    <div class="bg-theme-overlay" >
         <iframe src="{{$cms_corporate_map ?? ''}}" width="100%" height="500" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
@endsection

@section('main_content')
    <section class="wrap__contact-form">
        <div class="container">
            <form id="add-corporate-form">
                @csrf
                <div class="row">
                    <div class="col-md-5">
                        <h5>For Further question, Please contact us at:</h5>
                        <div class="wrap__contact-form-office">
                            <ul class="list-unstyled">
                                <li>
                                    <span>
                                        <i class="fa fa-phone"></i>
                                        <a href="tel:{{$cms_contact_no}}">{{$cms_corporate_no}}</a>
                                    </span>

                                </li>
                                <li>
                                    <span>
                                        <i class="fa fa-envelope"></i>
                                        <a href="mailto:{{$cms_email}}">{{$cms_corporate_email}}</a>
                                    </span>

                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h5>contact us</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-name">
                                    <label>Your name <span class="required"></span></label>
                                    <input type="text" class="form-control" name="name" id="name" required>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>Your email <span class="required"></span></label>
                                    <input type="email" class="form-control" name="email" id="email" required>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label>Phone <span class="required"></span></label>
                                    <input type="text" class="form-control" name="phone" id="phone" required>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Subject <span class="required"></span></label>
                                    <input type="text" class="form-control" name="subject" id="subject" required>
                                    <input type="hidden" class="form-control" name="type" id="type" value="Corporate Inquiry">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Products I am interested in</label>
                                    <textarea class="form-control" rows="9" name="message" id="message" required></textarea>
                                </div>
                                <div class="form-group float-right mb-0">
                                    <button class="btn btn-primary btn-contact" value="{{Auth::user()->id ?? ''}}" id="eid">
                                        <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                                        Submit
                                    </button>
                                </div>
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