@extends('layouts.globe')

@section('title')
    Detail Category
@endsection

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <label for=""><b>Category Name</b></label>
                <br>
                {{$category->name}}
                <br><br>

                <label for=""><b>Category Slug</b></label>
                <br>
                {{$category->slug}}
                <br><br>

                <label for=""><b>Category Image</b></label>
                <br>
                @if ($category->image)
                    <img src="{{asset('public/storage/'. $category->image)}}" width="120px" alt="">
                @else
                    No image
                @endif
            </div>
        </div>
    </div>
@endsection