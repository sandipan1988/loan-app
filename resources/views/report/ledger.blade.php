@extends('layouts.app', ['activePage' => 'interest',
'title' => 'Ledger',
'navName' => 'Ledger', 'activeButton' => 'report'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Ledger Book</h3>
                                <p class="text-sm mb-0">
                                    This is ledger book.
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
                                    <th>Member Name</th>
                                    <th>A/C no.</th>
                                    <th>Mobile</th>
                                    <th>Loan Type</th>
                                    <th>Day</th>
                                    <th>Loan Amount</th>
                                    <th>Installment Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Due</th>
                                    <th>Loan Start Date</th>
                                    <th>Loan End Date</th>
                                </tr>
                        </thead>
                                <tbody>
                                    @foreach ($loans as $loan)


                                    <tr>
                                        <td>{{ $loan->members->name }}</td>
                                        <td>{{ $loan->loan_account }}</td>
                                        <td>{{ $loan->members->phone }}</td>
                                        <td>{{ Helper::getLoanType($loan->loan_type) }}</td>
                                        <td>{{ $loan->loan_type== '2' ? Helper::getDay($loan->loan_start_date) : '' }}</td>
                                        <td>{{ Helper::rupee_format($loan->loan_amount) }}</td>
                                        <td>{{ Helper::rupee_format($loan->installment_amount) }}</td>
                                        <td>{{ $paid = Helper::getPaid($loan->loan_id) }}</td>

                                        <td>{{ Helper::getDue($loan->loan_amount, Helper::getPaidForCal($loan->loan_id)) }} </td>
                                        <td>{{ $loan->loan_start_date->format('d/m/Y') }}</td>

                                        <td class="d-flex ">{{ $loan->loan_end_date?->format('d/m/Y') }}
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