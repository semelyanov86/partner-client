<div class="left-side-menu non-animation">
    <div id="sidebar-menu" class="non-animation">
        <ul class="metismenu non-animation" id="side-menu">
            <li class="menu-title">Меню</li>
            <li>
                <a href="{{route('client.home')}}">
                    <i class="ti-home"></i>
                    <span> Главная страница </span>
                </a>
            </li>
            <li>
                <br>
            </li>
            <li>
                <a href="{{route('client.creditcalc')}}">
                    <i class=" mdi mdi-calculator"></i>
                    <span> Кредитный калькулятор </span>
                </a>
            </li>

            <li>
                <a href="{{route('client.requests')}}">
                    <i class="ti-pencil-alt"></i>
                    <span> Заявки </span>
                    <span class="badge badge-primary float-right">{{$loan_requests_badge}}</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="mdi mdi-coin-outline"></i>
                    <span> Займы </span>
                    <span class="badge badge-primary float-right">{{$loans_badge}}</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="mdi mdi-piggy-bank"></i>
                    <span> Сбережения </span>
                    <span class="badge badge-primary float-right">{{$deposits_badge}}</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="far fa-envelope"></i>
                    <span> Оставить отзыв </span>
                </a>
            </li>

            <li>
                <br>
            </li>

            <li>
                <a  href="javascript:;" onclick="document.getElementById('logout-form').submit();">
                    <i class="mdi mdi-exit-to-app"></i>
                    <span> Выйти </span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
            </li>
        </ul>

    </div>
    <div class="clearfix"></div>

</div>

