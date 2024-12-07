@extends('layouts.app', ['activePage' => 'schedules',
'title' => 'schedules',
'navName' => 'schedules', 'activeButton' => 'laravel'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-3">
                                <h3 class="mb-0">Amortization</h3>
                                <h4 class="text-sm mb-0">
                                   Amortization Schedule : {{$loans->members->name }}
</h4>
                                <p class="text-sm mb-0">
                                    Loan Type : {!!Helper::getLoanType($loans->loan_type)!!}
                                 </p>
                                 <p class="text-sm mb-0">
                                    Loan Amount : {!!Helper::rupee_format($loans->loan_amount)!!}
                                 </p>
                            </div>
                            <div class="col-6">

                            @if($loans->status=='OPEN')
                            <form method="POST" action="{{ route('close-loan') }}">
                                @csrf
                                
                                    <input type="hidden" id="loan_id" class="form-control" name="loan_id" value="{{$loans->loan_id}}" >
                                  
                               
                                <div class="form-group row">
                                    <label for="amount" class="col-md-4 col-form-label text-md-right" style="color:red">Loss
                                        </label>
                                    <div class="col-md-3">
                                        <input type="text" id="amount" class="form-control" name="loss_amount"
                                            required>
                                            
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Close Account') }}
                                        </button>
                                    </div>
                                </div>
                           
                                       
                                
                                
                            </form>
                            @else
                            <p>Loan Closed</p>
                            <p >Loss Amount : <span style="color:red">{{Helper::rupee_format($loans->loss_amount)}}</span></p>
                            @endif
                            </div>



                            </div>

                        </div>
                    </div>

                    <div class="col-12 mt-2">
                    </div>

                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>

                                    <th>Installment Date</th>
                                    <th>Installment Amount</th>
                                    <th>Paid(YES/NO)</th>
                                    <th>Paid Date</th>

                                </tr>
                            </thead>
                                <tbody>
                                    @foreach ($schedules as $schedule)

                                    <tr>
                                        <td>{{ $schedule->installment_date->format("d/m/Y") }}</td>
                                        <td>{{ Helper::rupee_format($schedule->installment_amount) }}</td>
                                        <td>{{ $schedule->is_paid }}</td>
                                        <td>{{ $schedule->paid_date?->format('d/m/Y') }}</td>

                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>

                    </div>
                    <p></p>
                </div>

            </div>
            {{$schedules->links()}}
        </div>


    </div>
</div>
@endsection
