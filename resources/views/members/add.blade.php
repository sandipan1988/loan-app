@extends('layouts.app', ['activePage' => 'user', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'User Profile', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="section-image">
                <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
                <div class="row">
 
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">Add New Member</div>
        <div class="card-body">
          <form method="POST" action="{{ route('add-member') }}">
            @csrf
            <div class="form-group row">
              <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
              <div class="col-md-6">
                <input type="text" id="name" class="form-control" name="name" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
              <div class="col-md-6">
                <input type="email" id="email" class="form-control" name="email" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label>
              <div class="col-md-6">
                <input type="tel" id="phone" class="form-control" name="phone" required>
              </div>
            </div>
            <div class="form-group row">
              <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
              <div class="col-md-6">
                <textarea id="address" class="form-control" name="address" required></textarea>
              </div>
            </div>
            <div class="form-group row">
    <label for="date-of-birth" class="col-md-4 col-form-label text-md-right">Date of Birth</label>
    <div class="col-md-6">
    <input type="date" class="form-control" id="date-of-birth" name="date-of-birth">
</div>
  </div>
  <div class="form-group row">
    <label for="date-became-member" class="col-md-4 col-form-label text-md-right">Date Became Member</label>
    <div class="col-md-6">
    <input type="date" class="form-control" id="date-became-member" name="date-became-member">
    </div>
  </div>
            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">Add Member</button>
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