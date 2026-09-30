<div class="topbar d-none d-sm-block gold-gradient">
    <div class="container ">
        <div class="row">
            <div class="col-sm-5 col-md-5">
                <div class="topbar-left">
                    <div class="topbar-text ">
                        {{ date('l, F j, Y') }}
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="list-unstyled topbar-right">
                    <ul class="topbar-link">
                        <li class="nav-item show-pc hide-mobile">
                          @if(Auth::user())
                            <a id="contact-li" class="nav-link dash-a" href="/home"> DASHBOARD</a>
                          @else
                            <a id="contact-li" class="nav-link dash-a" href="/login"> LOGIN</a>
                          @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- mobile -->
<div class="mnavbar hide-pc show-mobile bg-black">
    <div class="mnav-first">
        <div class="mnav-first-item">
            <a class="navbar-brand " href="/">
                <img src="{{$logo ?? 'assets/images/logos/logo.png'}}">
            </a>
        </div>
        <div class="mnav-first-item text-right">
            @if(Auth::user())
              <a href="/home" class="btn btn-primary madd-listing-btn">
                  <i class="fa fa-arrow-right" aria-hidden="true"></i> DASHBOARD
              </a>
            @else
              <a href="/login" class="btn btn-primary madd-listing-btn">
                  <i class="fa fa-arrow-right" aria-hidden="true"></i> Login
              </a>
            @endif
        </div>
    </div>
    <div class="mnav-second">
        <div class="mnav-second-item">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav99">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>
        </div>
        <div class="mnav-second-item">
            <div class="current-date">
                <p class="m-0 neon-gold">
                    {{ date('l, F j, Y') }}
                </p>
            </div>
        </div>
        <div class="mnav-second-item">
            <div class="mcart-section">
            </div>
        </div>
    </div>
</div>

<!-- web -->
<div class="fixed-navbar-height hide-pc show-mobile"></div>
<nav class="navbar navbar-hover navbar-expand-lg navbar-soft nav-text-dark bg-black">
    <div class="container">
        <a class="navbar-brand hide-mobile" href="/">
            <img src="{{$logo ?? 'assets/images/logos/logo.png'}}">
        </a>
        <button class="navbar-toggler hide-mobile" type="button" data-toggle="collapse" data-target="#main_nav99">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="main_nav99">
            <ul class="navbar-nav mx-auto ">
                <li class="nav-item">
                  <a id="home-li" class="nav-link" href="/homes"> HOME</a>
                </li>

                <li class="nav-item">
                  <a id="product-li" class="nav-link" href="/products"> PRODUCTS</a>
                </li>

                <?php 
                    $nonbuilds = DB::table('categories')->where('category_type','Non Buildable')->whereNull('deleted_at')->whereNull('deleted_at')->get();
                ?>

                @foreach($nonbuilds as $nonbuild)
                    <li class="nav-item">
                      <a id="product-li" class="nav-link" href="/non-build-products/{{$nonbuild->id ?? ''}}"> {{strtoupper($nonbuild->name ?? '')}}</a>
                    </li>
                @endforeach

                <li class="nav-item">
                  <a id="about-li" class="nav-link" href="/about-us"> ABOUT US</a>
                </li>

                <li class="nav-item">
                  <a id="contact-li" class="nav-link" href="/contact-us"> CONTACT US</a>
                </li>

                <li class="nav-item">
                  <a id="contact-li" class="nav-link" href="/corporate-inquiry"> CORPORATE INQUIRY</a>
                </li>

                
            </ul>
            <div class="mobile-social-media show-mobile-block hide-pc">
                <div class="sm-title">
                    <h6>Social Media</h6>
                </div>
                <ul class="topbar-sosmed">
                    <li>
                        <a href="{{$cms_fb ?? ''}}"><i class="fa fa-facebook black-color"></i></a>
                    </li>
                    <li>
                        <a href="{{$cms_twitter ?? ''}}"><i class="fa fa-twitter black-color"></i></a>
                    </li>
                    <li>
                        <a href="{{$cms_intagram ?? ''}}"><i class="fa fa-instagram black-color"></i></a>
                    </li>
                    <li>
                        <a href="{{$cms_yt ?? ''}}"><i class="fa fa-youtube black-color"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>