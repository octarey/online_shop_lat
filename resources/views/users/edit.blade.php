@extends('layouts.globe')

@section('title') Edit User @endsection

@section('content')
    <div class="col-md-8">
        @if (session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif

        <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{route('users.update', [$user->id])}}" method="POST">
            @csrf
            <input type="hidden" value="PUT" name="_method">

            <label for="name">Name</label>
            <input type="text" name="name" id="name" placeholder="Full Name" value="{{ old('name') ? old('name') : $user->name}}" class="form-control {{$errors->first('name') ? 'is-invalid' : ''}}">
            <div class="invalid-feedback">
                {{$errors->first('name')}}
            </div>
            <br>

            <label for="username">Username</label>
            <input type="text" name="username" id="username" value="{{$user->username}}" placeholder="username" disabled class="form-control">
            <br>

            <label for="status">Status</label><br>
            <input type="radio" name="status" id="active" value="ACTIVE" {{$user->status == "ACTIVE" ? "checked" : "" }} class="form-control">
            <label for="active">active</label>
            <input type="radio" name="status" id="inactive" value="INACTIVE" {{$user->status == "INACTIVE" ? "checked" : ""}} class="form-control">
            <label for="inactive">inactive</label>
            <br><br>

            <label for="">Roles</label>
            <br>
            <input type="checkbox" {{in_array("ADMIN", json_decode($user->roles)) ? "checked" : ""}} name="roles[]" id="ADMIN" value="ADMIN" class = "form-control {{$errors->first('roles' ? 'is-invalid' : '')}}">
            <label for="ADMIN">Administrator</label>
            <input type="checkbox" {{in_array("STAFF", json_decode($user->roles)) ? "checked" : ""}} name="roles[]" id="STAFF" value="STAFF" class = "form-control {{$errors->first('roles' ? 'is-invalid' : '')}}">
            <label for="STAFF">Staff</label>
            <input type="checkbox" {{in_array("ADMIN", json_decode($user->roles)) ? "checked" : ""}} name="roles[]" id="CUSTOMER" value="CUSTOMER"  class = "form-control {{$errors->first('roles' ? 'is-invalid' : '')}}">
            <label for="CUSTOMER">Customer</label>
            <br><br>
            
            <label for="phone">Phone Number</label>
            <input type="text" name="phone" value="{{old('phone') ? old('phone') : $user->phone}}" class="form-control {{$errors->first('phone') ? 'is-invalid' : ''}}">
            <div class="invalid-feedback">
                {{$errors->first('phone')}}
            </div>
            <br>

            <label for="address">Address</label>
            <textarea name="address" id="address" class="form-control {{$errors->first('address') ? 'is-invalid' : ''}}">{{old('address') ? old('address') : $user->address}}</textarea>
            <div class="invalid-feedback">
                {{$errors->first('address')}}
            </div>
            <br>

            <label for="avatar">Avatar Image</label>
            <br>
            Current Avatar: <br>
            @if ($user->avatar)
                <img src="{{asset('public/storage/'.$user->avatar)}}" alt="" width="120px">
                <br>
            @else
                No Avatar
            @endif
            <br>
            <input type="file" name="avatar" id="avatar" class="form-control">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah avatar</small>

            <hr class="my-3">

            <label for="email">Email</label>
            <input type="text" name="email" id="email" value="{{$user->email}}" disabled class="form-control" placeholder="user@mail.com">
            <br>

            <input type="submit" value="Save" class="btn btn-primary">
        </form>
    </div>
@endsection