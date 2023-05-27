
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
                                <a class="nav-link menu-link {{strpos(url()->current(),route('client.paginate.get')) !== false ? 'active' : ''}}" href="{{route('client.paginate.get')}}">
                                    <i class="ri-user-2-line"></i> <span data-key="t-widgets">Clients</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),route('project.paginate.get')) !== false ? 'active' : ''}}" href="{{route('project.paginate.get')}}">
                                    <i class="ri-building-line"></i> <span data-key="t-widgets">Projects</span>
                                </a>
                            </li>

                            {{-- <li class="nav-item">
                                <a class="nav-link menu-link {{strpos(url()->current(),'enquiry') !== false ? 'active' : ''}}" href="#sidebarDashboards7" data-bs-toggle="collapse" role="button"
                                    aria-expanded="{{strpos(url()->current(),'enquiry') !== false ? 'true' : 'false'}}" aria-controls="sidebarDashboards7">
                                    <i class="ri-survey-line"></i> <span data-key="t-dashboards">Enquiries</span>
                                </a>
                                <div class="collapse menu-dropdown {{strpos(url()->current(),'enquiry') !== false ? 'show' : ''}}" id="sidebarDashboards7">
                                    <ul class="nav nav-sm flex-column">
                                        @can('list enquiries')
                                            <li class="nav-item">
                                                <a href="{{route('enquiry.contact_form.paginate.get')}}" class="nav-link {{strpos(url()->current(), route('enquiry.contact_form.paginate.get')) !== false ? 'active' : ''}}" data-key="t-analytics"> Contact Form </a>
                                            </li>
                                        @endcan

                                    </ul>
                                </div>
                            </li> --}}

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
            <!-- Vertical Overlay-->
            <div class="vertical-overlay"></div>
