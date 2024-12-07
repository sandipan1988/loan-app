@extends('layouts.app', ['activePage' => 'members',
'title' => 'Members',
'navName' => 'Members', 'activeButton' => 'laravel'])

@section('content')
<div class="content">
    <div class="container-fluid">
    <form method="POST" action="{{ route('member') }}">
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
                                <h3 class="mb-0">Members</h3>
                                <p class="text-sm mb-0">
                                    This is member management.
                                </p>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{route('add-member')}}" class="btn btn-sm btn-default">Add Member</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                    </div>

                    <div class="toolbar">
                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                    </div>
                    @if (session('success'))
                    <div class="alert alert-primary">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                    @endif
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Date of Birth</th>
                                    <th>Date Became Member</th>
                                    <th>Photo</th>
                                    <th>Action</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach($members as $member)
                                <tr>
                                    <td>{{$member->name}}</td>
                                    <td>{{$member->email}}</td>
                                    <td>{{$member->phone}}</td>
                                    <td>{{$member->address}}</td>
                                    <td>{{$member->date_of_birth?->format('d/m/Y')}}</td>
                                    <td>{{$member->date_became_member?->format('d/m/Y')}}</td>
                                    @if($member->photo)
                                    <td><img src="{{asset($member->photo)}}" alt="" style="width: 50px; height: 50px"></td>
                                    @else
                                    <td></td>
                                    @endif
                                    <td class="d-flex justify">
                                        <a href="{{route('edit-member', $member->member_id)}}"><i class="fa fa-edit"></i></a>
                                        <a href="{{route('del-member', $member->member_id)}}"><i class="fa fa-trash"></i></a>
                                        <a href="{{route('member-download',$member->member_id)}}"><i class="fa fa-download" aria-hidden="true" title="Download"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if(empty($search))
                        {{$members->links()}}
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection