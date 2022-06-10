@extends('layouts.globe')
@section('title')
    Products
@endsection

@section('content')
    @if (session('status'))
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
            <table class="table tavle-bordered table-stripped" >
                <thead style="text-align: center">
                    <tr>
                        <th><b>Image</b></th>
                        <th><b>Name</b></th>
                        <th><b>Brand</b></th>
                        <th><b>Categories</b></th>
                        <th><b>Origin</b></th>
                        <th><b>Price</b></th>
                        <th><b>Stock</b></th>
                        <th><b>Status</b></th>
                        <th><b>Action</b></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>
                            @if ($product->image)
                                <img src="{{asset('public/storage/'. $product->image)}}" width="96px" alt="">
                            @endif
                        </td>
                        <td>{{$product->name}}</td>
                        <td>{{$product->merk}}</td>
                        <td>
                            <ul class="pl-3">
                                @foreach ($product->categories as $cat)
                                    <li>{{$cat->name}}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{$product->origin}}</td>
                        <td>{{$product->price}}</td>
                        <td>{{$product->stock}}</td>
                        <td>
                            @if ($product->status == "DRAFT")
                                <span class="badge dg-dark text-white">{{$product->status}}</span>
                            @else
                                <span class="badge badge-success">{{$product->status}}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('products.edit', [$product->id])}}" class="btn btn-info btn-sm"> Edit</a>
                            <form action="{{route('products.destroy', [$product->id])}}" method="POST" onsubmit="return confirm('Move product to trash?')" class="d-inline">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="submit" name="" value="trash" class="btn btn-danger btn-sm">
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