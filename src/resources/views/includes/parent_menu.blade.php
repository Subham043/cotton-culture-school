
            <!-- ========== App Menu ========== -->
            <div class="app-menu navbar-menu">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <!-- Dark Logo-->
                    <a href="{{route('parent_dashboard')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('admin/images/logo.png')}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('admin/images/logo-main.png') }}" alt="" height="17">
                        </span>
                    </a>
                    <!-- Light Logo-->
                    <a href="{{route('parent_dashboard')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('admin/images/logo.png')}}" alt="" height="30">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('admin/images/logo-main.png') }}" alt="" height="60">
                        </span>
                    </a>
                    <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                        <i class="ri-record-circle-line"></i>
                    </button>
                </div>

                <div id="scrollbar">
                    <div class="container-fluid">

                        <div id="two-column-menu">
                        </div>
                        <ul class="navbar-nav" id="navbar-nav">
                            <li class="menu-title"><span data-key="t-menu">Menu</span></li>

                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('parent_dashboard')) !== false ? 'active' : ''}}" href="{{route('parent_dashboard')}}">
                                    <i class="ri-dashboard-fill"></i> <span data-key="t-widgets">Dashboard</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('address.paginate.get')) !== false ? 'active' : ''}}" href="{{route('address.paginate.get')}}">
                                    <i class="ri-community-line"></i> <span data-key="t-widgets">Address</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
            <!-- Vertical Overlay-->
            <div class="vertical-overlay"></div>
