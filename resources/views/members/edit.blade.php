@extends('layouts.app', ['activePage' => 'user', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'User Profile', 'activeButton' => 'laravel'])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="section-image">
      <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
      <div class="row">

        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Edit Member</div>
            <div class="card-body">
              <form method="POST" action="{{route('update-member', $member->member_id)}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                  <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>
                  <div class="col-md-2">
                    <input type="text" id="name" class="form-control" name="name" value="{{old('name',$member->name)}}" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>
                  <div class="col-md-4">
                    <input type="email" id="email" class="form-control" name="email" value="{{old('email',$member->email)}}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label>
                  <div class="col-md-2">
                    <input type="tel" id="phone" class="form-control" name="phone" value="{{old('phone',$member->phone)}}" readonly required>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                  <div class="col-md-6">
                    <textarea id="address" class="form-control" name="address"  required > {{old('address',$member->address)}} </textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label for="date-of-birth" class="col-md-4 col-form-label text-md-right">Date of Birth</label>
                  <div class="col-md-2">
                    <input type="date" class="form-control" id="date-of-birth" name="date_of_birth" value="{{$member->date_of_birth?->format('Y-m-d')}}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="date-became-member" class="col-md-4 col-form-label text-md-right">Date Became Member</label>
                  <div class="col-md-2">
                    <input type="date" class="form-control" id="date-became-member" name="date_became_member" value="{{$member->date_became_member?->format('Y-m-d')}}">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="current-photo" class="col-md-4 col-form-label text-md-right">Current Photo</label>
                  <div class="col-md-4">
                  <img src="{{asset(old('photo',$member->photo))}}" alt="" class="img-fluid">
                   
                  </div>
                </div>
                <div class="form-group row">
                  <label for="photo" class="col-md-4 col-form-label text-md-right">Photo</label>
                  <div class="col-md-4">
                    <input type="file" class="form-control" id="photo" name="photo">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="current-govt_id" class="col-md-4 col-form-label text-md-right">Current Govt. ID</label>
                  <div class="col-md-4">
                  <img src="{{asset(old('govt_id',$member->govt_id))}}" alt="" class="img-fluid">
                   
                  </div>
                </div>
                <div class="form-group row">
                  <label for="govt_id" class="col-md-4 col-form-label text-md-right">Photo</label>
                  <div class="col-md-4">
                    <input type="file" class="form-control" id="govt_id" name="govt_id">
                  </div>
                </div>
                <div class="form-group row mb-0">
                  <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">Update Member</button>
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