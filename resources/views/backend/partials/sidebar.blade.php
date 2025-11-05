<aside class="main-sidebar sidebar-primary elevation-4">

    <!-- =================== Brand Logo Section =================== -->
    <a href="" class="brand-link">
        <div style="text-align: center; padding: 5px 0; background-color: #f8f9fa;">
            <img src="{{ asset('backend/AdminAssets/backend/dist/img/BrandPicture.png') }}"
                 alt="Logo"
                 style="width: 180px; height: 80px; object-fit: contain; display: block; margin: 0 auto;">
        </div>
    </a>

    <!-- =================== Sidebar Section =================== -->
    <div class="sidebar">

        <!-- =================== Sidebar Menu =================== -->
        <nav class="mt-10" style="margin-top: 50px;">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview" role="menu" data-accordion="false">

                <!-- =================== Dashboard =================== -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-columns"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- =================== CMS Dropdown =================== -->
                @role('admin')
                @php
                    $cmsRoutes = [
                        'contact.index',
                        'contact.show','web-contact-images.index','permissions.index','roles.index','terms.index','privacy.index'
                    ];

                    $cmsOpen = collect($cmsRoutes)->contains(fn($r) => request()->routeIs($r) || request()->is("admin/{$r}/*"));
                @endphp

                <li class="nav-item {{ $cmsOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $cmsOpen ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>
                            CMS
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        @php
                            $subMenu = [
                                ['route' => 'contact.index', 'icon' => 'far fa-circle', 'label' => 'Contact Us'],
                                ['route' => 'web-contact-images.index', 'icon' => 'far fa-circle', 'label' => 'ContactUs Image'],
                                ['route' => 'terms.index', 'icon' => 'far fa-circle', 'label' => 'Terms And Conditions'],
                                ['route' => 'privacy.index', 'icon' => 'far fa-circle', 'label' => 'Privacy And Policy'],
                            ];
                        @endphp

                        @foreach($subMenu as $item)
                            <li class="nav-item">
                                <a href="{{ route($item['route']) }}"
                                   class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                                    <i class="{{ $item['icon'] }} nav-icon"></i>
                                    <p>{{ $item['label'] }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                @endrole

                @role('admin') <!-- Only users with 'admin' role can see this menu -->

                @php
                    $rolePermissionRoutes = [
                        'permissions.index',
                        'roles.index'
                    ];

                    $rolePermissionOpen = collect($rolePermissionRoutes)
                                        ->contains(fn($r) => request()->routeIs($r) || request()->is("admin/{$r}/*"));
                @endphp

                <li class="nav-item {{ $rolePermissionOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $rolePermissionOpen ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>
                            Role Permission
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        @php
                            $subMenuRolePermission = [
                                ['route' => 'permissions.index', 'icon' => 'far fa-circle', 'label' => 'Permission'],
                                ['route' => 'roles.index', 'icon' => 'far fa-circle', 'label' => 'Roles'],
                            ];
                        @endphp

                        @foreach($subMenuRolePermission as $item)
                            <li class="nav-item">
                                <a href="{{ route($item['route']) }}"
                                   class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                                    <i class="{{ $item['icon'] }} nav-icon"></i>
                                    <p>{{ $item['label'] }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                @endrole


                <!-- =================== jobs post =================== -->
                @php
                    // Define the routes for Job Post submenu
                    $jobPostRoutes = [
                        'categories.index',
                        'questions.index',
                        'question-options.index',
                        'job_posts.index',
                    ];

                    // Check if current route matches any Job Post route
                    $jobPostOpen = collect($jobPostRoutes)
                                    ->contains(fn($r) => request()->routeIs($r) || request()->is("admin/{$r}/*"));
                @endphp

                {{-- Only show menu to admin and homeowner --}}
                @hasanyrole('admin|homeowner')
                    <li class="nav-item {{ $jobPostOpen ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ $jobPostOpen ? 'active' : '' }}">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>
                                Job Post
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            @php
                                $subMenuJobPost = [
                                    ['route' => 'categories.index', 'icon' => 'far fa-circle', 'label' => 'Category'],

                                    ['route' => 'questions.index', 'icon' => 'far fa-circle', 'label' => 'Category Questions'],

                                    ['route' => 'question-options.index', 'icon' => 'far fa-circle', 'label' => 'Category Options'],
                                    ['route' => 'job_posts.index', 'icon' => 'far fa-circle', 'label' => 'Post Jobs'],

                                ];
                            @endphp

                            @foreach($subMenuJobPost as $item)
                                <li class="nav-item">
                                    <a href="{{ route($item['route']) }}"
                                       class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                                        <i class="{{ $item['icon'] }} nav-icon"></i>
                                        <p>{{ $item['label'] }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endhasanyrole

                <!-- =================== Job Apply =================== -->
                @php
                    // Define the routes for Job Apply submenu
                    $jobApplyRoutes = [
                        'job-apply.index','job-registration.index'
                    ];

                    // Check if current route matches any Job Apply route
                    $jobApplyOpen = collect($jobApplyRoutes)
                                    ->contains(fn($r) => request()->routeIs($r) || request()->is("admin/{$r}/*"));
                @endphp

                {{-- Only show menu to admin and TradePerson --}}

                @hasanyrole('admin|tradesperson')
                <li class="nav-item {{ $jobApplyOpen ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $jobApplyOpen ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-check"></i>
                        <p>
                            Job Apply
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        @php
                            $subMenuJobApply = [
                                ['route' => 'job-apply.index', 'icon' => 'far fa-circle', 'label' => 'Registrations'],
                                ['route' => 'job-registration.index', 'icon' => 'far fa-circle', 'label' => 'JobApply'],
                            ];
                        @endphp

                        @foreach($subMenuJobApply as $item)
                            <li class="nav-item">
                                <a href="{{ route($item['route']) }}"
                                   class="nav-link {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                                    <i class="{{ $item['icon'] }} nav-icon"></i>
                                    <p>{{ $item['label'] }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                @endhasanyrole



                <!-- =================== Enrollment Register =================== -->
                @role('admin')
                <li class="nav-item">
                    <a href="{{route('admin.job_applications.index')}}"
                       class="nav-link {{ request()->routeIs('admin.job_applications.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p> Applied User</p>
                    </a>
                </li>
                @endrole

                <!-- =================== Notifications =================== -->
                <li class="nav-item">
                    <a href=""
{{--                       {{route('backend.global_sponsors.index')}}--}}
                       class="nav-link {{ request()->routeIs('enrollments.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>Notifications</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->

</aside>

<!-- =================== Sidebar Custom Styles =================== -->
<style>
    /* Sidebar link hover effect */
    .nav-sidebar .nav-item .nav-link:hover {
        background-color: #007bff !important;
        color: #fff !important;
        position: relative;
    }

    /* White dot on hover (right side) */
    .nav-sidebar .nav-item .nav-link:hover::after {
        content: "•";
        color: #1A237E;
        font-size: 18px;
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
    }

    /* Keep white dot for active menu (right side) */
    .nav-sidebar .nav-item .nav-link.active {
        background-color: #007bff !important;
        color: #1A237E !important;
        position: relative;
    }
    .nav-sidebar .nav-item .nav-link.active::after {
        content: "•";
        color: #1A237E;
        font-size: 18px;
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
    }

    /* Default icon color */
    .nav-sidebar .nav-item .nav-link i.nav-icon {
        color: #343a40;
    }

    /* Icon color on hover */
    .nav-sidebar .nav-item .nav-link:hover i.nav-icon {
        color: #fff !important;
    }

    /* Icon color when active */
    .nav-sidebar .nav-item .nav-link.active i.nav-icon {
        color: #fff !important;
    }
</style>
<!-- =================== Mobile Styles =================== -->
<style>
    @media (max-width: 768px) {
        .main-sidebar {
            position: fixed;
            top: 0;
            left: -260px; /* hidden initially */
            width: 260px;
            height: 100%;
            background: #1A237E;
            z-index: 1050;
            overflow-y: auto;
            transition: left 0.3s;
        }
        .main-sidebar.open {
            left: 0;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
        }
        .sidebar-overlay.active {
            display: block;
        }

        /* Menu text bold and black */
        .nav-sidebar .nav-link {
            font-weight: bold;
            color: #000 !important;
        }
        .nav-sidebar .nav-link i.nav-icon {
            color: #343a40;
        }

        /* Submenu collapsed initially */
        .nav-treeview {
            display: none;
            padding-left: 15px;
        }
        .nav-item.menu-open > .nav-treeview {
            display: block;
        }
    }
</style>

<!-- =================== Mobile JS =================== -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.main-sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        // Create overlay
        const overlay = document.createElement('div');
        overlay.classList.add('sidebar-overlay');
        document.body.appendChild(overlay);

        // Toggle sidebar
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        });

        overlay.addEventListener('click', function() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        });

        // Mobile submenu toggle
        document.querySelectorAll('.nav-item.has-treeview > a').forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    const parent = link.parentElement;
                    parent.classList.toggle('menu-open');
                }
            });
        });
    });
</script>


