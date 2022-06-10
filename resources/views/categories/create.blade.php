@extends('layouts.globe')

@section('title') Create Category @endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif
    <form action="{{route('categories.store')}}" method="POST" class="bg-white shadow-sm p-3" enctype="multipart/form-data">
        @csrf

        <label for="">Category Name</label><br>
        <input type="text" name="name" class="form-control {{$errors->first('name') ? 'is-invalid' : ''}}">
        <div class="invalid-feedback">{{$errors->first('name')}}</div>
        <br>
        <label for="">Category Image</label>
        <input type="file" name="image" id="" class="form-control">
        <br>

        <input type="submit" class="btn btn-primary" value="save">
    </form>
@endsection