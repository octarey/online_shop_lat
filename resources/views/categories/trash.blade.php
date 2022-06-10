@extends('layouts.globe')

@section('title') Category Trash @endsection

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
    <div class="col-md-12">

        @if ($categories->count() == 0)
            <span>
                <b>tidak ada kategori di trash</b> 
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
                            <a href="{{route('categories.restore', [$cat->id])}}" class="btn btn-success btn-sm">Publish</a>
                            <form action="{{route('categories.delete-permanent', [$cat->id])}}" method="POST" onsubmit="return confirm('Delete this category permanently?')" class="d-inline">
                                @csrf

                                <input type="hidden" value="DELETE" name="_method">
                                <input type="submit" value="delete" class="btn btn-danger btn-sm">
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