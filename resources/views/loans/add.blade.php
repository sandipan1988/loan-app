@extends('layouts.app', [
    'activePage' => 'loan',
    'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim &
UPDIVISION',
    'navName' => 'Loan',
    'activeButton' => 'laravel',
])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="section-image">
                <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
                <div class="row">

                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Add New Loan</div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('submit-loan') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                        <div class="col-md-6">
                                            <input type="text" id="name" class="form-control" name="name"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                                        <div class="col-md-6">
                                            <input type="email" id="email" class="form-control" name="email">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label>
                                        <div class="col-md-6">
                                            <input type="tel" id="phone" class="form-control" name="phone"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                                        <div class="col-md-6">
                                            <textarea id="address" class="form-control" name="address"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">Loan
                                            Type</label>
                                        <div class="col-md-2">
                                            <select class="form-control" aria-label="Large select example" name="loan_type">
                                                <option value="1" selected>Daily</option>
                                                <option value="2">Weekly</option>
                                                <option value="3">Monthly</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right">Interest
                                            Rate</label>
                                        <div class="col-md-2">
                                            <select id="interest-rate" class="form-control" name="interest_rate"
                                                aria-label="Large select example">
                                                <option value="28">28%</option>
                                                <option value="4">4%</option>
                                                <option value="other">Other</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div id="other-interest" class="form-group row d-none">
                                        <label for="other-interest-value"
                                            class="col-md-4 col-form-label text-md-right">Other Interest</label>
                                        <div class="col-md-2">
                                            <input type="text" id="other-interest-value" class="form-control"
                                                name="other_interest_value">
                                        </div>
                                        <div class="col-md-1">%(Percent)</div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="amount" class="col-md-4 col-form-label text-md-right">Loan
                                            Amount</label>
                                        <div class="col-md-3">
                                            <input type="text" id="amount" class="form-control" name="loan_amount"
                                                required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="install-amount"
                                            class="col-md-4 col-form-label text-md-right">Installment Amount</label>
                                        <div class="col-md-3">
                                            <input type="text" id="install-amount" class="form-control"
                                                name="installment_amount" required>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label for="loan-start-date" class="col-md-4 col-form-label text-md-right">Loan
                                            Start Date</label>
                                        <div class="col-md-2">
                                            <input type="date" class="form-control" id="loan-start-date"
                                                name="loan_start_date" required>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-0">
                                        <div class="col-md-6 offset-md-6">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
                    $('#interest-rate').on('change', function(){
                            var selectVal = $("#interest-rate option:selected").val();
                            if (selectVal.trim() == "other") {
                                $("#other-interest").removeClass('d-none');
                                $("#other-interest").attr('required','required');
                            }
                                else {
                                    $("#other-interest").addClass('d-none');
                                    $("#other-interest").removeAttr('required');
                                }
                            });

                    });
    </script>
@endpush