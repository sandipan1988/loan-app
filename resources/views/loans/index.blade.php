@extends('layouts.app', ['activePage' => 'loan',
'title' => 'Loan',
'navName' => 'Loan', 'activeButton' => 'laravel'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Loans</h3>
                                <p class="text-sm mb-0">
                                    This is loan management.
                                </p>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{route('add-loan')}}" class="btn btn-sm btn-default">Add Loan</a>
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
                                    <th>Member Name</th>
                                    <th>A/C no.</th>
                                    <th>Mobile</th>
                                    <th>Loan Type</th>
                                    <th>Interest Rate</th>
                                    <th>Loan Amount</th>
                                    <th>Installment Amount</th>
                                    <th>Balance Amount</th>
                                    <th>Amortization</th>
                                    <th>Loan Start Date</th>
                                    <th>Actions</th>
                                </tr>
                        </thead>
                                <tbody>
                                    @foreach ($loans as $loan)


                                    <tr>
                                        <td>{{ $loan->name }}</td>
                                        <td>{{ $loan->loan_account }}</td>
                                        <td>{{ $loan->phone }}</td>
                                        <td>{{ $loan->loan_type }}</td>
                                        <td>{{ $loan->interest_rate }} &percnt;</td>
                                        <td>{{ $loan->loan_amount }}</td>
                                        <td>{{ $loan->installment_amount }}</td>
                                        <td>{{ $loan->installment_amount }}</td>

                                        <td>
                                        <a href="{{route('edit-loan')}}"><i class="fa fa-inr" title="Amortization schedule" aria-hidden="true"></i></a>
                                        <a href="{{route('del-loan')}}"><i class="fa fa-download" title="Download schedule" aria-hidden="true"></i></a>
                                        </td>
                                        <td>{{ $loan->loan_start_date->format('d/m/Y') }}</td>

                                        <td class="d-flex ">
                                               <a href="{{route('edit-loan')}}"><i class="fa fa-edit" title="Edit Loan"></i></a>
                                               <a href="{{route('del-loan')}}"><i class="fa fa-trash" title="Delete Loan"></i></a>
                                               <a href="{{route('del-loan')}}"><i class="fa fa-download" aria-hidden="true" title="Download Statement"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
