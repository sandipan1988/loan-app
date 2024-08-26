@extends('layouts.appPDF', ['activePage' => 'schedules', 'title' => 'schedules', 'navName' => 'schedules', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card data-tables">

                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Account Statement</h3>
                                    <p class="text-sm mb-0">
                                        Name : {{ $loans->name }}
                                    </p>
                                    <p class="text-sm mb-0">
                                        Loan Type : {!! Helper::getLoanType($loans->loan_type) !!}
                                    </p>
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

                                        <th>Date</th>
                                        <th>Debit Amount</th>
                                        <th>Credit Amount</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $loans->loan_start_date?->format('d/m/Y') }}</td>
                                        <td>{{ $loans->loan_amount }}</td>
                                        <td>--</td>
                                        <td>{{ $loans->loan_amount }}</td>
                                    </tr>
                                    @foreach ($schedules as $schedule)
                                        <tr>
                                            <td>{{ $schedule->paid_date?->format('d/m/Y') }}</td>
                                            <td></td>
                                            <td>{{ $schedule->installment_amount }}</td>
                                            <td>{{ $loans->loan_amount -= $schedule->installment_amount }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                        <p></p>
                    </div>

                </div>
                <!--{//$schedules->links()!!}-->
            </div>


        </div>
    </div>
@endsection
