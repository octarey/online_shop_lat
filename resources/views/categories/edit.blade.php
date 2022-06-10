@extends('layouts.globe')

@section('title') Edit Category @endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif
    <form action="{{route('categories.update', [$category->id])}}" method="POST" class="bg-white shadow-sm p-3" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="_method" value="PUT">
        <label for="">Category Name</label><br>
        <input type="text" name="name" class="form-control {{$errors->first('name') ? 'is-invalid' : ''}}" value="{{old('name') ? old('name') : $category->name}}">
        <div class="invalid-feedback">{{$errors->first('name')}}</div>
        <br>
        <label for="">Category Slug</label><br>
        <input type="text" name="slug" class="form-control" value="{{$category->slug}}">
        <br>
        <label for="">Category Image</label><br>
        @if ($category->image)
            <span>Current Image</span>
            <img src="{{asset('public/storage/'. $category->image)}}" width="120px" alt="">
        @endif
        <input type="file" name="image" id="" class="form-control">
        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
        <br>

        <input type="submit" class="btn btn-primary" value="update">
    </form>
@endsection