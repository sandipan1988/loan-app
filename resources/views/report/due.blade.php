@extends('layouts.app', ['activePage' => 'due-report', 'title' => 'Daily Collection', 'navName' => 'Daily Collection', 'activeButton' => 'report'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <form method="POST" action="{{ route('due-search') }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Search
                            <div class="row">

                                    @csrf
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-2">
                                            <label for="name" class="col-form-label text-md-right">By Name</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="name" class="form-control" name="name" value="{{ !empty($name)? $name : ''}}">
                                            <input type="hidden" id="phone" class="form-control" name="phone" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1"> - <b>OR</b> - 
                                </div>
                                <div class="col-7">
                                    <div class="row">
                                    <div class="col-1">
                                            <label for="date-of-birth" class="col-form-label text-md-right">Date From</label>
                                        </div>
                                        <div class="col-3">
                                            <input type="date" class="form-control" id="date-from"
                                                name="from_search_date" value="{{ !empty($start_date)? $start_date : ''}}" >
                                        </div>
                                        <div class="col-1">To</div>
                                        <div class="col-3">
                                            <input type="date" class="form-control" id="date-to"
                                                name="to_search_date" value="{{ !empty($end_date)? $end_date : ''}}" >
                                        </div>
                                        <div class="col-1">
                                         <input type="hidden" id="search" class="form-control" name="search" value="1">
                                            <button type="submit" class="btn btn-sm btn-default mt-2">SEARCH</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 mt-2">
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <div class="card data-tables">
                    
                        @if(!empty($message))
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @endif
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Daily Collection</h3>
                                    <p class="text-sm mb-0">
                                    </p>
                                </div>
                                <div class="col-4 text-right">
                                    
                                </div>
                            </div>
                        </div>
                        @if($search!='1')
                        <div class="col-12 mt-2">
                            Today's collection: <span class="badge badge-warning"> <i class="fa fa-inr"
                            aria-hidden="true"></i>{{ Helper::rupee_format($schedules_amount)}}</span>
                            <a href="{{route('daily-export')}}" class="btn btn-sm btn-default">Excel</a>
                        </div>


                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                       
                                        <th>Account No.</th>
                                        <th>Installment Amount (Total = {{ Helper::rupee_format($schedules_amount)}})</th>
                                        <th>Imnstallment Date</th>
                                        <th>Paid Status</th>
                                      
                                    </tr>
                                </thead>

                                
                                <tbody>
                                    @foreach ($schedules as $schedule)
                                        <tr>
                                            <td>{{ Helper::memberNameandPhone($schedule->loan->member_id)[0] }}</td>
                                   
                                            <td>{{ $schedule->loan->loan_account }}</td>
                                            <td>{{ Helper::rupee_format($schedule->installment_amount )}}</td>
                                            <td>{{ $schedule->installment_date->format('d-m-Y') }}</td>
                                            <td>{{ $schedule->is_paid }}</td>
                                       
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$schedules->links()}}

                        <div class="col-12 mt-2">
                            Yesterday's Due: <span class="badge badge-danger"> <i class="fa fa-inr"
                            aria-hidden="true"></i>{{ Helper::rupee_format($schedules_amount_yesterday) }}</span>
                        </div>

                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Account No.</th>
                                        <th>Installment Amount (Total = {{ Helper::rupee_format($schedules_amount_yesterday) }})</th>
                                        <th>Imnstallment Date</th>
                                        <th>Paid Status</th>
                                      
                                    </tr>
                                </thead>

                                
                                <tbody>
                                    @foreach ($schedules_yes as $schedule)
                                        <tr>
                                            <td>{{ Helper::memberNameandPhone($schedule->loan->member_id)[0] }}</td>
                                            <td>{{ $schedule->loan->loan_account }}</td>
                                            <td>{{ Helper::rupee_format($schedule->installment_amount)}}</td>
                                            <td>{{ $schedule->installment_date->format('d-m-Y') }}</td>
                                            <td>{{ $schedule->is_paid }}</td>
                                       
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$schedules_yes->links()}}

                        <div class="col-12 mt-2">
                            All Due upto today: <span class="badge badge-danger"><i class="fa fa-inr"
                            aria-hidden="true"></i>{{ Helper::rupee_format($schedules_amount_all) }}</span>
                        </div>

                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Account No.</th>
                                        <th>Installment Amount (Total = {{ Helper::rupee_format($schedules_amount_all) }})</th>
                                        <th>Imnstallment Date</th>
                                        <th>Paid Status</th>
                                      
                                    </tr>
                                </thead>

                                
                                <tbody>
                                    @foreach ($schedules_all as $schedule)
                                        <tr>
                                            <td>{{ Helper::memberNameandPhone($schedule->loan->member_id)[0] }}</td>
                                            <td>{{ $schedule->loan->loan_account }}</td>
                                            <td>{{ Helper::rupee_format($schedule->installment_amount) }}</td>
                                            <td>{{ $schedule->installment_date->format('d-m-Y') }}</td>
                                            <td>{{ $schedule->is_paid }}</td>
                                       
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{$schedules_all->links()}}
                        @else
                        <div class="col-12 mt-2">
                            Total Due: <span class="badge badge-warning"> <i class="fa fa-inr"
                            aria-hidden="true"></i>{{ Helper::rupee_format($total_due)}}</span>
                        </div>

                        
                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Account No.</th>
                                        <th>Installment Amount</th>
                                        <th>Imnstallment Date</th>
                                        <th>Paid Status</th>

                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($schedules as $schedule)
                                        <tr>
                                            <td>{{ Helper::memberNameandPhone($schedule->loan->member_id)[0] }}</td>
                                            <td>{{ $schedule->loan->loan_account }}</td>
                                            <td>{{ Helper::rupee_format($schedule->installment_amount)}}</td>
                                            <td>{{ $schedule->installment_date->format('d-m-Y') }}</td>
                                            <td>{{ $schedule->is_paid }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>


            </div>

        </div>
    </div>
@endsection
@push('js')
  

@endpush

