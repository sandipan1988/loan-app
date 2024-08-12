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
                                    <div class="col-md-6">
                                        <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $loan->name) }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                                    <div class="col-md-6">
                                        <input type="email" id="email" class="form-control" name="email" value="{{ old('email', $loan->email) }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label>
                                    <div class="col-md-6">
                                        <input type="tel" id="phone" class="form-control" name="phone" value="{{ old('phone', $loan->phone) }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                                    <div class="col-md-6">
                                        <textarea id="address" class="form-control" name="address" required>{{ old('address', $loan->address) }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Loan Type</label>
                                    <div class="col-md-2">

                                            <select class="form-control" name="loan_type" aria-label="Large select example">
                                                <option value="1" {{ old('loan_type', $loan->loan_type) == 1 ? 'selected' : '' }}>Daily</option>
                                                <option value="2" {{ old('loan_type', $loan->loan_type) == 2 ? 'selected' : '' }}>Weekly</option>
                                                <option value="3" {{ old('loan_type', $loan->loan_type) == 3 ? 'selected' : '' }}>Monthly</option>
                                            </select>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Interest
                                        Rate</label>
                                    <div class="col-md-2">
                                        <select id="interest-rate" class="form-control" name="interest_rate">
                                            <option value="10" {{ old('interest_rate', $loan->interest_rate) == '10' ? 'selected' : '' }}>10%</option>
                                            <option value="20" {{ old('interest_rate', $loan->interest_rate) == '20' ? 'selected' : '' }}>20%</option>
                                            <option value="15" {{ old('interest_rate', $loan->interest_rate) == '15' ? 'selected' : '' }}>15%</option>
                                            <option value="other" {{ old('interest_rate', $loan->interest_rate) == 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>

                                </div>
                                <div id="other-interest" class="form-group row d-none">
                                    <label for="other-interest-value"
                                        class="col-md-4 col-form-label text-md-right">Other Interest</label>
                                    <div class="col-md-3">
                                        <input type="text" id="other-interest-value" class="form-control"
                                            name="other-interest-value" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="amount" class="col-md-4 col-form-label text-md-right">Amount</label>
                                    <div class="col-md-3">
                                        <input type="text" id="amount" class="form-control" name="loan_amount" value="{{ old('loan_amount', $loan->loan_amount) }}" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="install-amount"
                                        class="col-md-4 col-form-label text-md-right">Installment Amount</label>
                                    <div class="col-md-3">
                                        <input type="text" id="install-amount" class="form-control"
                                            name="installment_amount"  value="{{ old('installment_amount', $loan->installment_amount) }}" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="loan-start-date" class="col-md-4 col-form-label text-md-right">Loan
                                        Start Date</label>

                                    <div class="col-md-2">
                                        <input type="date" class="form-control" id="loan-start-date"
                                            name="loan_start_date"  value="{{ $loan->loan_start_date ?  $loan->loan_start_date->format('Y-m-d') :''}}">
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


