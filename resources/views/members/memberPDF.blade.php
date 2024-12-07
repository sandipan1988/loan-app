@extends('layouts.appPDF', ['activePage' => '',
'title' => 'Member',
'navName' => '', 'activeButton' => 'laravel'])

@section('content')
<style>
.page-break {
    page-break-after: always;
}
</style>
<div class="content">
  <div class="container-fluid">
    
    <div class="section-image">
      <!--   you can change the color of the filter page using: data-color="blue | purple | green | orange | red | rose " -->
      <div class="row">

        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Member Details</div>
            <div class="row">
                <div class="row">
                  <p>Name : {{$member->name}} </p>
                  </div>
                
                <div class="row">
                  <p>Email : {{$member->email}}</p>
                  </div>
                </div>
                <div class="row">
                  <p> Phone : {{$member->phone}} </p>
                  </div>
                </div>
                <div class="form-group row">
                  <p>Address :  {{$member->address}} </p>
                  </div>
                </div>
                <div class="form-group row">
                  <p>Date of Birth : {{$member->date_of_birth?->format('Y-m-d')}}</p>
                  </div>
                </div>
                <div class="form-group row">
                  <p>Date Became Member : {{$member->date_became_member?->format('Y-m-d')}} </p>
                  </div>
                </div>
                <div class="form-group row">
                  <p>Photo : </p>
                  <img width="200" height="250" src="{{public_path().'/'.$member->photo}}" alt="" />
                </div>
             
                <div class="form-group row">
                  <p>Govt. ID : </p>
                  <img width="200" height="250" src="{{public_path().'/'.$member->govt_id}}" alt="" />
                   
                  </div>
                </div>
                
          
            </div>
          </div>
        </div>



      </div>
    </div>
  </div>
</div>
@endsection
