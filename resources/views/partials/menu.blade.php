<aside class="main-sidebar sidebar-dark-primary elevation-4" style="min-height: 917px;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light">{{ trans('panel.site_title') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route("admin.home") }}">
                        <i class="fas fa-fw fa-tachometer-alt nav-icon">
                        </i>
                        <p>
                            {{ trans('global.dashboard') }}
                        </p>
                    </a>
                </li>
                @can('user_management_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/permissions*') ? 'menu-open' : '' }} {{ request()->is('admin/roles*') ? 'menu-open' : '' }} {{ request()->is('admin/users*') ? 'menu-open' : '' }} {{ request()->is('admin/audit-logs*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-users">

                            </i>
                            <p>
                                {{ trans('cruds.userManagement.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('permission_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-unlock-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.permission.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('role_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-briefcase">

                                        </i>
                                        <p>
                                            {{ trans('cruds.role.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('user_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-user">

                                        </i>
                                        <p>
                                            {{ trans('cruds.user.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('audit_log_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.audit-logs.index") }}" class="nav-link {{ request()->is('admin/audit-logs') || request()->is('admin/audit-logs/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-file-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.auditLog.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('post_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.posts.index") }}" class="nav-link {{ request()->is('admin/posts') || request()->is('admin/posts/*') ? 'active' : '' }}">
                            <i class="fa-fw nav-icon far fa-newspaper">

                            </i>
                            <p>
                                {{ trans('cruds.post.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('failed_login_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.failed-logins.index") }}" class="nav-link {{ request()->is('admin/failed-logins') || request()->is('admin/failed-logins/*') ? 'active' : '' }}">
                            <i class="fa-fw nav-icon fas fa-ban">

                            </i>
                            <p>
                                {{ trans('cruds.failedLogin.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('shareholder_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.shareholders.index") }}" class="nav-link {{ request()->is('admin/shareholders') || request()->is('admin/shareholders/*') ? 'active' : '' }}">
                            <i class="fa-fw nav-icon fas fa-user">

                            </i>
                            <p>
                                {{ trans('cruds.shareholder.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('loan_request_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.loan-requests.index") }}" class="nav-link {{ request()->is('admin/loan-requests') || request()->is('admin/loan-requests/*') ? 'active' : '' }}">
                            <i class="fa-fw nav-icon fas fa-cart-arrow-down">

                            </i>
                            <p>
                                {{ trans('cruds.loanRequest.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @can('deposit_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/deposit-contracts*') ? 'menu-open' : '' }} {{ request()->is('admin/deposit-schedules*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-hand-holding-usd">

                            </i>
                            <p>
                                {{ trans('cruds.deposit.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('deposit_contract_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.deposit-contracts.index") }}" class="nav-link {{ request()->is('admin/deposit-contracts') || request()->is('admin/deposit-contracts/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-file-signature">

                                        </i>
                                        <p>
                                            {{ trans('cruds.depositContract.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('deposit_schedule_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.deposit-schedules.index") }}" class="nav-link {{ request()->is('admin/deposit-schedules') || request()->is('admin/deposit-schedules/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-calendar-alt">

                                        </i>
                                        <p>
                                            {{ trans('cruds.depositSchedule.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('loan_access')
                    <li class="nav-item has-treeview {{ request()->is('admin/loan-contracts*') ? 'menu-open' : '' }} {{ request()->is('admin/loan-main-schedules*') ? 'menu-open' : '' }} {{ request()->is('admin/loan-memfee-schedules*') ? 'menu-open' : '' }} {{ request()->is('admin/request-fields*') ? 'menu-open' : '' }}">
                        <a class="nav-link nav-dropdown-toggle" href="#">
                            <i class="fa-fw nav-icon fas fa-money-bill-alt">

                            </i>
                            <p>
                                {{ trans('cruds.loan.title') }}
                                <i class="right fa fa-fw fa-angle-left nav-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            @can('loan_contract_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.loan-contracts.index") }}" class="nav-link {{ request()->is('admin/loan-contracts') || request()->is('admin/loan-contracts/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-book">

                                        </i>
                                        <p>
                                            {{ trans('cruds.loanContract.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('loan_main_schedule_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.loan-main-schedules.index") }}" class="nav-link {{ request()->is('admin/loan-main-schedules') || request()->is('admin/loan-main-schedules/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-calendar">

                                        </i>
                                        <p>
                                            {{ trans('cruds.loanMainSchedule.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('loan_memfee_schedule_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.loan-memfee-schedules.index") }}" class="nav-link {{ request()->is('admin/loan-memfee-schedules') || request()->is('admin/loan-memfee-schedules/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-chalkboard">

                                        </i>
                                        <p>
                                            {{ trans('cruds.loanMemfeeSchedule.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                            @can('request_field_access')
                                <li class="nav-item">
                                    <a href="{{ route("admin.request-fields.index") }}" class="nav-link {{ request()->is('admin/request-fields') || request()->is('admin/request-fields/*') ? 'active' : '' }}">
                                        <i class="fa-fw nav-icon fas fa-cogs">

                                        </i>
                                        <p>
                                            {{ trans('cruds.requestField.title') }}
                                        </p>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('place_access')
                    <li class="nav-item">
                        <a href="{{ route("admin.places.index") }}" class="nav-link {{ request()->is('admin/places') || request()->is('admin/places/*') ? 'active' : '' }}">
                            <i class="fa-fw nav-icon fas fa-map-marker-alt">

                            </i>
                            <p>
                                {{ trans('cruds.place.title') }}
                            </p>
                        </a>
                    </li>
                @endcan
                @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                    @can('profile_password_edit')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                                <i class="fa-fw fas fa-key nav-icon">
                                </i>
                                <p>
                                    {{ trans('global.change_password') }}
                                </p>
                            </a>
                        </li>
                    @endcan
                @endif
                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                        <p>
                            <i class="fas fa-fw fa-sign-out-alt nav-icon">

                            </i>
                            <p>{{ trans('global.logout') }}</p>
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>