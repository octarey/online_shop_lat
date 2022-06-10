@extends('layouts.globe')
@section('title')
    Create Product
@endsection
@section('footer-scripts')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
        $('#categories').select2({
            ajax: {
                url: '/ashashop/ajax/categories/search',
                processResults: function(data){
                    return {
                        results: data.map(function(item){return {id: item.id, text: item.name} })
                    }
                }
             }
        });
    </script>
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{session('status')}}
        </div>
    @endif
    <div class="row">
        <div class="col-md-8">
            <form action="{{route('products.store')}}" method="POST" enctype="multipart/form-data" class="p-3 shadow-sm bg-white">
                @csrf

                <label for="name">Product Name</label><br>
                <input type="text" name="name" id="name" class="form-control {{$errors->first('name') ? 'is-invalid' : ''}}" placeholder="Product Name">
                <div class="invalid-feedback">{{$errors->first('name')}}</div>
                <br>

                <label for="description">Product Description</label><br>
                <textarea name="description" id="description" class="form-control {{$errors->first('description') ? 'is-invalid' : ''}}" placeholder="Give a desription about this product"></textarea>
                <div class="invalid-feedback">{{$errors->first('description')}}</div>
                <br>

                <label for="categories">Product Category</label><br>
                <select name="categories[]" id="categories" multiple class="form-control"></select>
                <br>

                <div class="row">
                    <div class="col-md-6">
                        <label for="merk">Product Brand</label><br>
                        <input type="text" name="merk" id="merk" class="form-control {{$errors->first('merk') ? 'is-invalid' : ''}}" placeholder="Product Brand">
                        <div class="invalid-feedback">{{$errors->first("merk")}}</div>
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label for="origin">Product Origin</label><br>
                        <input type="radio" name="origin" id="local" value="local" {{Request::get('origin') == 'local' ? 'checked' : ''}} class="form control {{$errors->first('origin') ? 'is-invalid' : ''}}">
                        <label for="local">Local</label>
                        <input type="radio" name="origin" id="import" value="import" {{Request::get('origin') == 'import' ? 'checked' : ''}} class="form-control {{$errors->first('origin') ? 'is-invalid' : ''}}">
                        <label for="import">Import</label>
                        <div class="invalid-feedback">{{$errors->first('origin')}}</div>        
                    </div>
                </div>


                <label for="price">Product Price</label><br>
                <input type="number" name="price" id="price" class="form-control {{$errors->first('price') ? 'is-invalid' : ''}}" placeholder="Product Price">
                <div class="invalid-feedback">{{$errors->first('price')}}</div>
                <br>

                <label for="stock">Product Stock</label><br>
                <input type="number" name="stock" id="stock" class="form-control {{$errors->first('stock') ? 'is-invalid' : ''}}" placeholder="Product Stock">
                <div class="invalid-feedback">{{$errors->first('stock')}}</div>
                <br>

                <label for="image">Product Image</label>
                <input type="file" name="image" id="image" class="form-control {{$errors->first('image') ? 'is-invalid' : ''}}">
                <div class="invalid-feedback">{{$errors->first('image')}}</div>
                <br>

                <button name="save_action" class="btn btn-primary" value="PUBLISH">Publish</button>
                <button name="save_action" class="btn btn-secondary" value="DRAFT">Save as Draft</button>
            </form>
        </div>
    </div>
@endsection