<!-- Topbar Start -->
            <div class="navbar-custom">
                <ul class="list-unstyled topnav-menu float-right m-0">
                    <li>
                        <div class="d-flex flex-column justify-content-around">
                            <div class="pt-2">
                                <span id="user-fio"> {{ Auth::user()->fio }}</span>
                            </div>
                            <div class="text-right">
                                <span id="user-phone">{{ Auth::user()->phone }}</span>
                            </div>
                        </div>
                    </li>
                </ul>

                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <!-- LOGO -->
                        <div class="logo-box">
                            <a href="{{route('client.home')}}" class="logo text-center logo-dark">
                                <span class="logo-lg">
                                    <div class="d-flex align-items-center">
                                        <img src="../images/logo.png" alt="" height="68" class="p-1">
                                    </div>
                                </span>
                                <span class="logo-sm h-100">
                                    <div class="d-flex justify-content-around align-items-center">
                                        <img src="../images/logo-notext.png" alt=""  height="68" class="p-1">
                                    </div>
                                </span>
                            </a>
                        </div>
                    </li>
                    <li>
                        <button class="button-menu-mobile" style=" outline:none;">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </li>
                </ul>
            </div>
            <!-- end Topbar -->
