<div class="sidebar" data-image="{{ asset('light-bootstrap/img/sidebar-5.jpg') }}">
    <!--
Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

Tip 2: you can also add an image using data-image tag
-->
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="http://www.creative-tim.com" class="simple-text">
                {{ __("LOAN APP") }}
            </a>
        </div>
        <ul class="nav">
            <li class="nav-item @if($activePage == 'dashboard') active @endif">
                <a class="nav-link" href="{{route('dashboard')}}">
                    <i class="nc-icon nc-chart-pie-35"></i>
                    <p>{{ __("Dashboard") }}</p>
                </a>
            </li>
            <li class="nav-item @if($activePage == 'members') active @endif">
                <a class="nav-link" href="{{route('member')}}">
                    <i class="nc-icon nc-notes"></i>
                    <p>{{ __("Members") }}</p>
                </a>
            </li>

            <li class="nav-item @if($activePage == 'loan') active @endif">
                <a class="nav-link" href="{{route('loan')}}">
                    <i class="nc-icon nc-notes"></i>
                    <p>{{ __("Loans") }}</p>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#laravelExamples" @if($activeButton =='laravel') aria-expanded="true" @endif>
                    <i>
                        <img src="{{ asset('light-bootstrap/img/laravel.svg') }}" style="width:25px">
                    </i>
                    <p>
                        {{ __('User Management') }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse @if($activeButton =='laravel') show @endif" id="laravelExamples">
                    <ul class="nav">
                        <!--<li class="nav-item @if($activePage == 'user-management') active @endif">
                            <a class="nav-link" href="{{route('user.index')}}">
                                <i class="nc-icon nc-circle-09"></i>
                                <p>{{ __("Users") }}</p>
                            </a>
                        </li>-->
                        <li class="nav-item @if($activePage == 'user') active @endif">
                            <a class="nav-link" href="{{route('profile.edit')}}">
                                <i class="nc-icon nc-single-02"></i>
                                <p>{{ __("User Profile") }}</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <!--<li class="nav-item @if($activePage == 'table') active @endif">
                <a class="nav-link" href="{{route('page.index', 'table')}}">
                    <i class="nc-icon nc-notes"></i>
                    <p>{{ __("Report") }}</p>
                </a>
            </li-->
            <li class="nav-item @if($activePage == 'schedule') active @endif">
                <a class="nav-link" href="{{route('schedule')}}">
                    <i class="nc-icon nc-paper-2"></i>
                    <p>{{ __("Schedule") }}</p>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#report" @if($activeButton =='report') aria-expanded="true" @endif>
                    <i>
                        <img src="{{ asset('light-bootstrap/img/laravel.svg') }}" style="width:25px">
                    </i>
                    <p>
                        {{ __("Reports") }}
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse @if($activeButton =='report') show @endif" id="report">
                    <ul class="nav">
                        <li class="nav-item @if($activePage == 'due-report') active @endif">
                            <a class="nav-link" href="{{Route('due-report')}}">
                                <i class="nc-icon nc-circle-09"></i>
                                <p>{{ __("Daily Collection") }}</p>
                            </a>
                        </li>
                        <li class="nav-item @if($activePage == 'sale-report') active @endif">
                            <a class="nav-link" href="{{Route('sale-report')}}">
                                <i class="nc-icon nc-single-02"></i>
                                <p>{{ __("Sales Report") }}</p>
                            </a>
                        </li>
                        <li class="nav-item @if($activePage == 'interest-report') active @endif">
                            <a class="nav-link" href="{{Route('interest-report')}}">
                                <i class="nc-icon nc-single-02"></i>
                                <p>{{ __("Interest Report") }}</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>

            <!--<li class="nav-item @if($activePage == 'notifications') active @endif">
                <a class="nav-link" href="{{route('page.index', 'notifications')}}">
                    <i class="nc-icon nc-bell-55"></i>
                    <p>{{ __("Notifications") }}</p>
                </a>
            </li> -->

        </ul>
    </div>
</div>
