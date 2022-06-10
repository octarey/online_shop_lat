@extends('layouts.globe')
@section('title')
    Products Deleted
@endsection
@section('content')

@if(session('status'))
    <div class="alert alert-success">
        {{session('status')}}
    </div>
@endif
<div class="row">
    <div class="col-md-6">
        <form action="{{route('products.index')}}">
            <div class="input-group">
                <input type="text" name="keyword" value="{{Request::get('keyword')}}" class="form-control" placeholder="Filter by title">
                <div class="input-group-append">
                    <input type="submit" value="Filter" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-6">
        <ul class="nav nav-pills card-header-pills">
            <li class="nav-item">
                <a class="nav-link {{Request::get('status') == NULL && Request::path() == 'products' ? 'active' : ''}}" href="{{route('products.index')}}">All</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{Request::get('status') == 'publish' ? 'active' : ''}}" href="{{route('products.index', ['status' =>'publish'])}}" >Publish</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{Request::get('status') == 'draft' ? 'active' : ''}}" href="{{route('products.index', ['status' =>'draft'])}}" >Draft</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{Request::path() == 'products/trash' ? 'active' : ''}}" href="{{route('products.trash')}}" >Trash</a>
            </li>
        </ul>
    </div>
</div>
<hr class="my-3">
<div class="row">
    <div class="col-md-12">
        <a href="{{route('products.create')}}" class="btn btn-primary" style="margin-bottom: 10px">Tambah product</a>
        <br>
        <table class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th><b>Image</b></th>
                    <th><b>Name</b></th>
                    <th><b>Brand</b></th>
                    <th><b>Categories</b></th>
                    <th><b>Origin</b></th>
                    <th><b>Price</b></th>
                    <th><b>Stock</b></th>
                    <th><b>Action</b></th>
                </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                @if($product->image)
                    <img src="{{asset('public/storage/' . $product->image)}}" width="96px"/>
                @endif
                </td>
            <td>{{$product->name}}</td>
            <td>{{$product->merk}}</td>
            <td>
                <ul class="pl-3">
                @foreach($product->categories as $category)
                    <li>{{$category->name}}</li> 
                @endforeach
                </ul>
            </td>
            <td>{{$product->origin}}</td>
            <td>{{$product->stock}}</td>
            <td>{{$product->price}}</td>
            <td>
                <form action="{{route('products.restore',  [$product->id])}}" method="POST" class="inline">
                    @csrf
                    <input type="submit" value="restore" class="btn btn-success">
                </form>
                <form action="{{route('products.delete', [$product->id])}}" method="POST" class="inline">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="submit" value="delete" class="btn btn-success">
                </form>
            </td>
            </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="10">
                        {{$products->appends(Request::all())->links()}}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection