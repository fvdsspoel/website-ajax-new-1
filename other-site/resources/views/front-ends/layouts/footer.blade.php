<footer>
    <div class="wrapper__footer bg__footer">
        <div class=" container">
            <figure>
                <img src="{{$logo ?? 'assets/images/logos/logo.png'}}" alt="" class="logo-footer">
            </figure>
            <div class="row">
                <div class="col-md-4 mpx-40px" >
                    <div class="widget__footer mb-3">
                        <p style="width: 70%">
                            {{$what_ajax}}
                        </p>
                    </div>
                    <div class="border-line"></div>
                    <div class="widget__footer">
                        <h4 class="footer-title">follow us</h4>
                        <p>
                            <a class="btn btn-social btn-social-o facebook mr-1" href="{{$cms_fb}}" target="_blank">
                                <i class="fa fa-facebook-f"></i>
                            </a>
                            <a class="btn btn-social btn-social-o twitter mr-1" href="{{$cms_twitter}}" target="_blank">
                                <i class="fa fa-twitter"></i>
                            </a>
                            <a class="btn btn-social btn-social-o instagram mr-1" href="{{$cms_intagram}}" target="_blank">
                                <i class="fa fa-instagram"></i>
                            </a>
                            <a class="btn btn-social btn-social-o youtube mr-1" href="{{$cms_yt}}" target="_blank">
                                <i class="fa fa-youtube"></i>
                            </a>
                        </p>

                    </div>

                </div>
                <div class="col-md-3 mpx-30px">
                    <div class="widget__footer mmt-40px">
                        <div class="row">
                            <div class="col-md-2 vl hide-mobile"></div>
                            <div class="col-md-10 col-10">
                                <ul class="list-unstyled  footer-quick-links">
                                    <li class="list-inline-item">
                                        <a href="/homes">Home</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="/about-us#the-team"> The Team</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="/about-us#the-team"> Our Services</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="/about-us#our-portfolio"> Our Portfolio</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="/about-us#our-partners"> Our Partners</a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="/corporate-inquiry"> Corporate Inquiry</a>
                                    </li>
                                    <!-- <li class="list-inline-item">
                                        <a href="#" onclick="chat();"> Chat with Support</a>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mpx-50px" >
                    <div class="border-line"></div>
                        <div class="widget__footer">
                            <div class="row">
                                <div class="col-md-2 vl hide-mobile"></div>
                                <div class="col-md-10 col-12">
                                    <div class="col-md-12 row">
                                        <ul class="list-unstyled  footer-quick-links">
                                            <li class="list-inline-item" style="margin-bottom: 10px;">
                                                <img src="/assets/images/icons/phone.png" style="width: 15px;height: 15px;">
                                                <a href="#">&emsp;{{$cms_contact_no}}</a>
                                            </li>
                                            <li class="list-inline-item" style="margin-bottom: 10px;">
                                                <img src="/assets/images/icons/email.png" style="width: 15px;height: 15px;">
                                                <a href="#">&emsp;{{$cms_email}}</a>
                                            </li>
                                            <li class="list-inline-item" style="margin-bottom: 10px;">
                                                <img src="/assets/images/icons/location.png" style="width: 15px;height: 15px;">
                                                <a href="#">&emsp;{{$cms_address}}</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <center>
                                        <h4 class="footer-title">
                                            AJAX TRADING CORPORATION
                                        </h4>
                                        <p>
                                            Visit our Company Manufacturing.
                                        </p>
                                        <div class="mt-3">
                                            <input type="hidden" id="subscribe-token" value="{{ csrf_token() }}">
                                            <a class="btn btn-primary btn-block text-capitalize input-radius" href="https://ajaxtradingcorp.com" target="_blank">
                                                <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                                Visit Now
                                            </a>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary btn-chat bottom-sticky-msg-box" onclick="chat();" style="float: right !important;" fdprocessedid="2qgm8">
                    <img src="/assets/images/icons/msg-anm.gif" alt="Chat">
                </button>

            </div>
        </div>
    </div>
    <div class="bg__footer-bottom ">
        <div class="container">
            <div class="row flex-column-reverse flex-md-row">
                <div class="col-md-12">
                        <span>
                            © 2024 Sterk Builders Inc. - Developed By
                            <a href="mailto:cjsalamat.duphilco@gmail.com" target="_blank" >MCJRS</a>
                        </span>
                </div>
            </div>
        </div>
    </div>
</footer>