@extends('layouts.globe')

@section('title') Category @endsection

@section('content')
@if(session('status'))
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-warning">
                {{session('status')}}
            </div>
        </div>
    </div>
@endif
<div class="row">
    <div class="col-md-6">
        <form action="{{route('categories.index')}}">
            <div class="input-group">
                <input type="text" name="name" placeholder="Filter by category name" class="form-control">
                <div class="input-group-append">
                    <input type="submit" value="filter" class="btn btn-primary">
                </div>
            </div>    
        </form>        
    </div>
    <div class="col-md-6">
        <ul class="nav nav-pills card-header-pills">
            <li class="nav-item">
                <a href="{{route('categories.index')}}" class="nav-link active">Published</a>
            </li>
            <li class="nav-item">
                <a href="{{route('categories.trash')}}" class="nav-link">Trash</a>
            </li>
        </ul>
    </div>
</div>

<hr class="my-3">
<div class="row" style="margin-bottom: 15px">
    <div class="col-md-12">
        <a href="{{route('categories.create')}}" class="btn btn-primary">Add Category</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        @if ($categories->count() == 0)
            <span>
                <b>Data category tidak ditemukan</b>
            </span>
        @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><b>Name</b></th>
                    <th><b>Slug</b></th>
                    <th><b>Image</b></th>
                    <th><b>Action</b></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $cat)
                    <tr>
                        <td><a href="{{route('categories.show', [$cat->id])}}">{{$cat->name}}</a></td>
                        <td>{{$cat->slug}}</td>
                        <td>
                            @if ($cat->iamge)
                                <img src="{{asset('public/storage/'. $cat->image)}}" alt="" width="48px">
                            @else
                                No image
                            @endif
                        </td>
                        <td>
                            <a href="{{route('categories.edit', [$cat->id])}}" class="btn btn-info btn-sm">Edit</a>
                            <form action="{{route('categories.destroy', [$cat->id])}}" method="POST" onsubmit="return confirm('Move category to trash?')" class="d-inline">
                                @csrf

                                <input type="hidden" value="DELETE" name="_method">
                                <input type="submit" value="trash" class="btn btn-danger btn-sm">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10">
                        {{$categories->appends(Request::all())->links()}}
                    </td>
                </tr>
            </tfoot>
        </table>
        @endif
    </div>
</div>
@endsection