@extends('layouts.app', ['activePage' => 'edit', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim &
UPDIVISION', 'navName' => 'Loan', 'activeButton' => 'laravel'])
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="section-image">
            <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
            <div class="row">

                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Edit Loan</div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('update-loan',$loan->loan_id) }}">
                                @csrf
                                @method('PATCH')

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                                    <div class="col-md-3">
                                        <input type="text" id="name" class="form-control" name="names"
                                            value="{{ old('name', $loan->members->name) }}" required>
                                        <input type="hidden" id="phone" class="form-control" name="phone"
                                            value="{{ old('phone', $loan->members->phone) }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Loan Type</label>
                                    <div class="col-md-2">

                                        <select class="form-control" name="loan_type" aria-label="Large select example">
                                            <option value="1"
                                                {{ old('loan_type', $loan->loan_type) == 1 ? 'selected' : '' }}>Daily
                                            </option>
                                            <option value="2"
                                                {{ old('loan_type', $loan->loan_type) == 2 ? 'selected' : '' }}>Weekly
                                            </option>
                                            <option value="3"
                                                {{ old('loan_type', $loan->loan_type) == 3 ? 'selected' : '' }}>Monthly
                                            </option>
                                        </select>

                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Interest
                                        Rate</label>
                                    <div class="col-md-2">
                                        <select id="interest-rate" class="form-control" name="interest_rate">
                                            <option value="28"
                                                {{ old('interest_rate', $loan->interest_rate) == '28' ? 'selected' : '' }}>
                                                28%</option>
                                            <option value="4"
                                                {{ old('interest_rate', $loan->interest_rate) == '4' ? 'selected' : '' }}>
                                                4%</option>
                                            <option value="other"
                                                {{ !in_array(old('interest_rate', $loan->interest_rate) , ['28','4']) ? 'selected' : '' }}>
                                                Other</option>
                                        </select>
                                    </div>

                                </div>
                                @if(!in_array(old('interest_rate', $loan->interest_rate) , ['28','4']))
                                <div id="other-interest" class="form-group row">
                                    <label for="other-interest-value"
                                        class="col-md-4 col-form-label text-md-right">Other Interest</label>
                                    <div class="col-md-3">
                                        <input type="text" id="other-interest-value" class="form-control"
                                            name="other-interest-value"
                                            value="{{old('interest_rate', $loan->interest_rate)}}">
                                    </div>
                                </div>
                                @endif

                                <div class="form-group row">
                                    <label for="amount" class="col-md-4 col-form-label text-md-right">Amount</label>
                                    <div class="col-md-3">
                                        <input type="text" id="amount" class="form-control" name="loan_amount"
                                            value="{{ old('loan_amount', $loan->loan_amount) }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="processing_charge" class="col-md-4 col-form-label text-md-right">Processing charge</label>
                                    <div class="col-md-3">
                                        <input type="text" id="processing_charge" class="form-control" name="processing_charge"
                                            value="{{ old('processing_charge', $loan->processing_charge) }}" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="loan-start-date" class="col-md-4 col-form-label text-md-right">Loan
                                        Start Date</label>

                                    <div class="col-md-2">
                                        <input type="date" class="form-control" id="loan-start-date"
                                            name="loan_start_date"
                                            value="{{ $loan->loan_start_date ? $loan->loan_start_date->format('Y-m-d') :''}}">
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
                @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif


            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
$(document).ready(function() {
    $('#interest-rate').on('change', function() {
        var selectVal = $("#interest-rate option:selected").val();
        if (selectVal.trim() == "other") {
            $("#other-interest").removeClass('d-none');
            $("#other-interest").attr('required', 'required');
        } else {
            $("#other-interest").addClass('d-none');
            $("#other-interest").removeAttr('required');
        }
    });

    $('#loan_type').on('change', function() {
        var selectVal = $("#loan_type option:selected").val();
        if (selectVal.trim() == "2") {
            $("#loan_day").removeClass('d-none');
        } else {
            $("#loan_day").addClass('d-none');
        }
    });

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