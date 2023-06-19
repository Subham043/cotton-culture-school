
            <!-- ========== App Menu ========== -->
            <div class="app-menu navbar-menu">
                <!-- LOGO -->
                <div class="navbar-brand-box">
                    <!-- Dark Logo-->
                    <a href="{{route('dashboard')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('admin/images/logo.png')}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('admin/images/logo-main.png') }}" alt="" height="17">
                        </span>
                    </a>
                    <!-- Light Logo-->
                    <a href="{{route('dashboard')}}" class="logo logo-light">
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
                                <a class="nav-link menu-link {{strpos(url()->current(),route('dashboard')) !== false ? 'active' : ''}}" href="{{route('dashboard')}}">
                                    <i class="ri-dashboard-fill"></i> <span data-key="t-widgets">Dashboard</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('class.paginate.get')) !== false ? 'active' : ''}}" href="{{route('class.paginate.get')}}">
                                    <i class="ri-community-line"></i> <span data-key="t-widgets">Class</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('section.paginate.get')) !== false ? 'active' : ''}}" href="{{route('section.paginate.get')}}">
                                    <i class="ri-keyboard-line"></i> <span data-key="t-widgets">Section</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('school.paginate.get')) !== false ? 'active' : ''}}" href="{{route('school.paginate.get')}}">
                                    <i class="ri-building-line"></i> <span data-key="t-widgets">School</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'product') !== false ? 'active' : ''}}" href="#sidebarDashboards1" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'product') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards1">
                                    <i class="ri-shirt-line"></i> <span data-key="t-dashboards">Products</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'product') !== false ? 'show' : ''}}" id="sidebarDashboards1">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{route('category.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('category.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Category </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('unit.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('unit.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Unit/Metrics </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{route('product.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('product.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Items </a>
                                        </li>

                                    </ul>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
            <!-- Vertical Overlay-->
            <div class="vertical-overlay"></div>
