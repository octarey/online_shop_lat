@extends('layouts.globe')

@section('title')
    Detail user 
@endsection

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if ($user->avatar)
                            <img src="{{asset('public/storage/'. $user->avatar)}}" width="128px" alt="">
                        @else
                            No Avatar
                        @endif
                    </div>

                    <div class="col-md-8">
                        <b>Name :</b> {{$user->name}} <br>
                        <b>Username :</b>{{$user->username}} <br>
                        <b>Email :</b>{{$user->email}}<br>
                        <b>Phone Number :</b>{{$user->phone}}<br>
                        <b>Address :</b>{{$user->address}}<br>
                        <b>Roles :</b>
                        @foreach (json_decode($user->roles) as $role)
                            &middot; {{$role}}               
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection