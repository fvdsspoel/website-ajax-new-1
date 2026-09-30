<nav class="navbar navbar-expand-lg navbar-dark fixed-top nav-bg-black" >
    <a class="navbar-brand" href="{{ route('home') }}">
        <img src="{{ asset('assets/images') }}/logos/logo.png" alt="Ajax" style="max-width: 42%; height: 44.8px;">
    </a>
    <div class="topbar-right-elements">
        <div class="topbar-right-side">
            <ul class="topbar-menu-wrapper" id="topbar-menu-wrapper">
                <li>
                    <a href="javascript:void(0)" class="topbar-user-wrapper" onclick="profileMenuToggle('.topbar-profile-wrapper')">
                        <img src="{{ asset('assets/images') }}/icons/user.webp" alt="" class="user-image">
                        <div class="topbar-user-info">
                            <h5 class="user-name" style="color: white !important;">{{ \App\Helpers\CommonHelper::getSubStr(Auth::user()->first_name ?? '', 10, '')}}</h5>
                            <p class="user-role" style="color: white !important;">{{ \App\Helpers\CommonHelper::getSideNavUserType() }}</p>
                        </div>
                    </a>
                    <div class="topbar-profile-wrapper">
                        <div class="tpw-user">
                            <div class="tpwu-name">
                                <h4>{{Auth::user()->first_name ?? ''}}</h4>
                            </div>
                            <div class="tpwu-type">
                                <p>{{ \App\Helpers\CommonHelper::getSideNavUserType() }}</p>
                            </div>
                            <div class="tpwu-links">
                                <ul>
                                    <li>
                                        <a href="/profiles" title="Profile"><i class="fa fa-user"></i></a>
                                    </li>
                                    <li>
                                        <a href="/logout" title="Sign Out" ><i class="fa fa-power-off"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="collapse navbar-collapse sidenav-wrapper" id="navbarCollapse">
        <div class="sidenav nav-bg-black">
            <div class="nav-top-user-info">
            </div>
            <ul class="navbar-nav mr-auto" id="navAccordion">
                <li class="nav-item {{ (Request::is('home*'))?'active':'' }}">
                    <a class="nav-link" href="/home">
                        <span class="icon">
                            <i class="fa fa-globe"></i>
                        </span>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item {{ (Request::is('categories*'))?'active':'' }}">
                    <a class="nav-link" href="/categories">
                        <span class="icon">
                            <i class="fas fa-th-large"></i>
                        </span>
                        Category & Sub Category
                    </a>
                </li>
                <li class="nav-item {{ (Request::is('size-prices*'))?'active':'' }}">
                    <a class="nav-link" href="/size-prices/index">
                        <span class="icon">
                            <i class='fas fa-ruler-horizontal'></i>
                        </span>
                        Size Price
                    </a>
                </li>
                <li class="nav-item {{ (Request::is('partners*'))?'active':'' }}">
                    <a class="nav-link" href="/partners/index">
                        <span class="icon">
                            <i class="fas fa-handshake"></i>
                        </span>
                        Our Partners
                    </a>
                </li>
                <li class="nav-item {{ (Request::is('teams*'))?'active':'' }}">
                    <a class="nav-link" href="/teams/index">
                        <span class="icon">
                            <i class="fas fa-users"></i>
                        </span>
                        The Team
                    </a>
                </li>
                <li class="nav-item {{ (Request::is('our-services*'))?'active':'' }}">
                    <a class="nav-link" href="/our-services/index">
                        <span class="icon">
                            <i class="fas fa-cogs"></i>
                        </span>
                        Our Services
                    </a>
                </li>
                <li class="nav-item {{ (Request::is('portfolios*'))?'active':'' }}">
                    <a class="nav-link" href="/portfolios/index">
                        <span class="icon">
                            <i class="fas fa-folder-open"></i>
                        </span>
                        Our Portfolio
                    </a>
                </li>
                <li class="nav-item {{ (Request::is('products*'))?'active':'' }}">
                    <a class="nav-link" href="/products/index">
                        <span class="icon">
                            <i class="fas fa-store"></i>
                        </span>
                        Products
                    </a>
                </li>
                <li class="nav-item {{ (Request::is('non-build-products*'))?'active':'' }}">
                    <a class="nav-link" href="/non-build-products/index">
                        <span class="icon">
                            <i class="fas fa-store-alt"></i>
                        </span>
                        Non Build Products
                    </a>
                </li>
                <li class="nav-item {{ (Request::is('appointments*'))?'active':'' }}">
                    <a class="nav-link" href="/appointments/index">
                        <span class="icon">
                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                        </span>
                        Appointments
                    </a>
                </li>
                <li class="nav-item {{ (Request::is('inquries*'))?'active':'' }}">
                    <a class="nav-link" href="/inquries">
                        <span class="icon">
                            <i class="fa fa-phone-square" aria-hidden="true"></i>
                        </span>
                        Inquries
                    </a>
                </li>
                <li class="nav-item {{ (Request::is('chats*'))?'active':'' }}">
                    <a class="nav-link" href="/chats/list">
                        <span class="icon">
                            <i class="fas fa-comment-alt" aria-hidden="true"></i>
                        </span>
                        Chat
                    </a>
                </li>
            </ul>
        </div>
    </div>

</nav>

<main class="content-wrapper main-content">
    <div class="container-fluid">
        @yield('content')
    </div>
</main>

<footer class="footer">
    <div class="container">
        <div class="text-right">
            <span>Developed by <a href="mailto:cjsalamat.duphilco@gmail.com" target="_blank">MCJRS</a>, {{ date('Y') }}</span>
        </div>
    </div>
</footer>


<script type="text/javascript">
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    $('#my-account').popover({
        placement : 'bottom',
        html : true,
        content : `
                <div id="my-account-drop">
                <span class="smaller">Welcome {{Auth::user()->name ?? ''}}!</span>

                    <a href="/logout" class="row pointer">
                        <div class="pt-2 pb-2 col-3">
                            <i class="fa fa-sign-out-alt"></i>
                        </div>
                        <div class="pt-2 pb-2 col-9 ">
                            Logout
                        </div>
                    </a>
                </div>
            `
    });

    $('body').on('click', function (e) {
        $('[data-toggle=popover]').each(function () {
            if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('#my-account-drop').has(e.target).length === 0) {
                $(this).popover('hide');
            }
        });
        if (e.target.id == "topbar-menu-wrapper" || $(e.target).parents("#topbar-menu-wrapper").length) {

        } else if(e.target.class == "mobile-user-profile-pic" || $(e.target).parents(".mobile-user-profile-pic").length) {

        } else {
            if ($('.topbar-profile-wrapper').hasClass('active')) {
                profileMenuToggle('.topbar-profile-wrapper')
            }
        }

    });

    function profileMenuToggle(element) {
        if ($(element).hasClass('active')) {
            $(element).animate({right: '-' + 100 + 'vw'}, 500);
        } else {
            $(element).animate({right: '-' + 0 + 'px'}, 500);
        }
        $(element).toggleClass('active');
    }
</script>

