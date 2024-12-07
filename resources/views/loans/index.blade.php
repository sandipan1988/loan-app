@extends('layouts.app', ['activePage' => 'loan',
'title' => 'Loan',
'navName' => 'Loan', 'activeButton' => 'laravel'])

@section('content')
<div class="content">
    <div class="container-fluid">
    <form method="POST" action="{{ route('loan') }}">
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
                                            <input type="text" id="name" class="form-control" name="name" value="{{!empty($name) ? $name : ''}}">
                                            <input type="hidden" id="phone" class="form-control" name="phone" value="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                      
                                        <div class="col-4">
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

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Loans</h3>
                                <p class="text-sm mb-0">
                                    This is loan management.
                                </p>
                                @if (session('success'))
                                <div class="alert alert-primary">
                                    {{ session('success') }}
                                </div>
                                @endif
                                @if (session('alert-error'))
                                <div class="alert alert-success">
                                    {{ session('alert-error') }}
                                </div>
                                @endif
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
                                    <th>Loan Day</th>
                                    <th>Loan End Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loans as $loan)


                                <tr>
                                    <td>{{ $loan->members->name }}</td>
                                    <td>{{ $loan->loan_account }}</td>
                                    <td>{{ $loan->members->phone }}</td>
                                    <td>{{ Helper::getLoanType($loan->loan_type) }}</td>
                                    <td>{{ $loan->interest_rate }} &percnt;</td>
                                    <td>{{ Helper::rupee_format($loan->loan_amount) }}</td>
                                    <td>{{ Helper::rupee_format($loan->installment_amount) }}</td>
                                    <td>
                                        {{ Helper::getDue($loan->loan_amount,Helper::getPaidForCal($loan->loan_id)) }}
                                    </td>

                                    <td>
                                        <a href="{{route('amortization-schedule',$loan->loan_id)}}"><i class="fa fa-inr" title="Amortization schedule" aria-hidden="true"></i></a>
                                        <a href="{{route('amortization-schedule-dowload',$loan->loan_id)}}"><i class="fa fa-download" title="Download schedule" aria-hidden="true"></i></a>
                                    </td>
                                    <td>{{ $loan->loan_start_date->format('d/m/Y') }}</td>
                                    <td>{{ $loan->loan_type== '2' ? Helper::getDay($loan->loan_start_date) : '' }}</td>
                                    <td>{{ $loan->loan_end_date?->format('d/m/Y') }}</td>
                                    <td class="d-flex ">
                                        <a href="{{route('edit-loan',$loan->loan_id)}}"><i class="fa fa-edit" title="Edit Loan"></i></a>
                                        <a href="{{route('del-loan',$loan->loan_id)}}"><i class="fa fa-trash" title="Delete Loan"></i></a>
                                        <a href="{{route('stmnt-download',$loan->loan_id)}}"><i class="fa fa-download" aria-hidden="true" title="Download Statement"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if(empty($search))
            {{$loans->links()}}
            @endif
        </div>

    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#name').autocomplete({
            source: function(request, response) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('find-by-name')}}", // Replace with your server-side script URL
                    dataType: 'json',
                    method: "POST",
                    data: {
                        name: request.term
                    },
                    success: function(data) {
                        var names = [];
                        for (var i = 0; i < data.length; i++) {
                            names[i] = data[i].name + ", " + data[i].phone;

                        }
                        response(names);
                    }
                });
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            minLength: 2, // Minimum number of characters to trigger the auto-suggestion,

            select: function(event, ui) {
                // console.log(ui.item);
                event.preventDefault();
                var name = ui.item.value.split(",")[0];
                var phone = ui.item.value.split(", ")[1];
                $('#name').val(name);
                $('#phone').val(phone);

            },


        });
    });
</script>
@endpush