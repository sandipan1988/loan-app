@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <a href="{{ route('member') }}">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-single-02 text-warning"></i>
                                    </div>
                                </div>

                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">Members</p>
                                        <p class="card-title">{{ $allmembers }}
                                        <p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                               
                            </div>
                        </div>
                    </div>
                </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <a href="{{ route('loan') }}">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-money-coins text-success"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">Total Loan</p>
                                        <p class="card-title"><i class="fa fa-inr"
                                                aria-hidden="true"></i>{{ Helper::rupee_format($loans) }}
                                        <p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">
                            </div>
                        </div>
                    </div>
                </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <a href="{{ route('due-report') }}">
                    <div class="card card-stats">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-5 col-md-4">
                                    <div class="icon-big text-center icon-warning">
                                        <i class="nc-icon nc-bank text-danger"></i>
                                    </div>
                                </div>
                                <div class="col-7 col-md-8">
                                    <div class="numbers">
                                        <p class="card-category">Total Due</p>
                                        <p class="card-title"><i class="fa fa-inr"
                                                aria-hidden="true"></i>{{ Helper::rupee_format($overdue) }}
                                        <p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer ">
                            <hr>
                            <div class="stats">


                            </div>
                        </div>
                    </div>
                    </a>
                </div>

                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <a href="{{ route('schedule') }}">
                        <div class="card card-stats">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-5 col-md-4">
                                        <div class="icon-big text-center icon-warning">
                                            <i class="nc-icon nc-paper-2 text-primary"></i>

                                        </div>
                                    </div>
                                    <div class="col-7 col-md-8">
                                        <div class="numbers">
                                            <p class="card-category">Due Today</p>
                                            <p class="card-title"><i class="fa fa-inr"
                                                    aria-hidden="true"></i>{{ Helper::rupee_format($duetoday) }}
                                            <p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ">
                                <hr>
                                <div class="stats">

                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                 </div>

        </div>
    </div>
@endsection
