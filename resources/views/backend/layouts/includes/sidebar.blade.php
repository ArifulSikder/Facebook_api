<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" id="sidebar">

    <a href="{{ url('dashboard') }}" class="brand-link">
        <img src="{{ asset('backend/dist/img/logo/logo2.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light gold">&nbsp;New Salem CME</span>
        </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="mt-5 pb-3 mb-3 d-flex">

        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
                @can('Dashboard')
                    
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <p class="nav-para">
                            Dashboard
                        </p>
                    </a>
                </li>

                @endcan
                @can('Post Offering')

                <li class="nav-item">
                    <a href="{{ route('add-new-post-offering') }}"
                        class="nav-link {{ request()->is('post-offering', "edit-earning*", "add-new-post-offering*") ? 'active' : '' }}">
                        <p class="nav-para">
                            Post Offering
                        </p>
                    </a>
                </li>
                @endcan
                @can('Payment')

                <li class="nav-item">
                    <a href="{{ route('payment-withdrawal') }}"
                        class="nav-link {{ request()->is('payment-withdrawal', 'edit-payment*', 'add-payment-withdrawal') ? 'active' : '' }}">
                        <p class="nav-para">
                            Payment / Withdrawal
                        </p>
                    </a>
                </li>
                @endcan
                @can('Post Payments')

                <li class="nav-item">
                    <a href="{{ route('transfer-funds') }}"
                        class="nav-link {{ request()->is('transfer-funds', 'transfer_funds*', 'edit-transfer-funds*') ? 'active' : '' }}">
                        <p class="nav-para">
                            Transfer Funds
                        </p>
                    </a>
                </li>
                @endcan
                @can('Members')

                <li class="nav-item">
                    <a href="{{ route('members') }}"
                        class="nav-link {{ request()->is('members', 'add-member', 'edit-member*', 'members/payment-log*') ? 'active' : '' }}">
                        <p class="nav-para">
                            Members
                        </p>
                    </a>
                </li>
                @endcan
                @can('Account')

                <li class="nav-item">
                    <a href="{{ route('accounts') }}"
                        class="nav-link {{ request()->is('add-account', 'accounts', 'edit-account*') ? 'active' : '' }}">
                        <p class="nav-para">
                            Account
                        </p>
                    </a>
                </li>
                @endcan
                @can('Report')

                <li class="nav-item">
                    <a href="{{ route('reports') }}" class="nav-link {{ request()->is('reports') ? 'active' : '' }}">
                        <p class="nav-para">
                            Reports
                        </p>
                    </a>
                </li>
                @endcan

                @if (isset(Auth::user()->getRoleNames()[0] ) && Auth::user()->getRoleNames()[0] == 'Admin')
                {{-- settings --}}
                {{--  <li class="nav-header">Settings & Controls</li>  --}}

                <li class="nav-item has-treeview {{ request()->is('permission', 'user-role', 'give-user-role', 'give-user-permission') ? "menu-open" : "" }}">
                    <a href="#" class="nav-link  {{ request()->is('permission', 'user-role', 'give-user-role', 'give-user-permission') ? "active" : "" }}">
                        {{--  <i class="nav-icon fas fa-cog"></i>  --}}
                        <p class="nav-para">
                            Settings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user-role') }}" class="nav-link {{ request()->is('user-role') ? "active" : "" }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    User Role
                                </p>
                            </a>
                        </li>
                        {{--  <li class="nav-item">
                            <a href="{{ route('permission') }}" class="nav-link {{ request()->is('permission') ? "active" : "" }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    User Permission
                                </p>
                            </a>
                        </li>  --}}
                        <li class="nav-item">
                            <a href="{{ route('give-user-role') }}" class="nav-link {{ request()->is('give-user-role') ? "active" : "" }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Give User Role
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('give-user-permission') }}" class="nav-link {{ request()->is('give-user-permission') ? "active" : "" }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    Give User Permission
                                </p>
                            </a>
                        </li>

                        {{--  <li class="nav-item">
                            <a href="{{ route('app-settings') }}" class="nav-link @yield('app-settings')">
                                <i class="far fa-circle nav-icon"></i>
                                <p>
                                    App Settings
                                </p>
                            </a>
                        </li>  --}}
                    </ul>
                </li>
            @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
