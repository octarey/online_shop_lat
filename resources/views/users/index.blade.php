@extends('layouts.globe')

@section('title') User @endsection
@section('content')
     @if (session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif

    <div class="row">
        <div class="col-md-2">
            <a href="{{route('users.create')}}" class="btn btn-primary">Create user</a>
        </div>
        <div class="col-md-8">
            <form action="{{route('users.index')}}">
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="keyword" value="{{Request::get('keyword')}}" placeholder="cari berdasarkan email" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <input type="radio" name="status" id="active" value="active" {{Request::get('status') == 'ACTIVE' ? 'checked' : ''}}>
                        <label for="active">Active</label>
                        <input type="radio" name="status" id="inactive" value="inactive" {{Request::get('status') == 'INACTIVE' ? 'checked' : ''}}>
                        <label for="inactive">Inactive</label>
                        <input type="submit" value="filter" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th><b>Name</b></th>
                <th><b>Username</b></th>
                <th><b>Email</b></th>
                <th><b>Avatar</b></th>
                <th><b>Status</b></th>
                <th><b>Action</b></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td><a href="{{route('users.show', [$user->id])}}">{{$user->name}}</a></td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        @if ($user->avatar)
                            <img src="{{asset('public/storage/'.$user->avatar)}}" width="30px" height="30px">
                        @else
                            N/A
                        @endif
                    
                    </td>
                    <td>
                        @if ($user->status == "ACTIVE")
                            <span class="badge badge-success">
                                {{$user->status}}
                            </span>
                        @else
                            <span class="badge badge-danger">
                                {{$user->status}}
                            </span>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-info text-white btn-sm" href="{{route('users.edit', [$user->id])}}">Edit</a>
                        <form action="{{route('users.destroy', [$user->id])}}" onsubmit="return confirm('Delete this user permanently?'" class="d-inline" method="POST">
                            @csrf

                            <input type="hidden" name="_method" value="DELETE">
                            <input type="submit" value="delete" class="btn btn-danger btn-sm">
                        </form>
                    </td>                    
                </tr>
            @endforeach
        </tbody>
    </table>

    <div colspan=10>
        {{$users->appends(Request::all())->links()}}
    </div>
    
    
@endsection