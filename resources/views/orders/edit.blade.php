@extends('layouts.globe')
@section('title')
    Order Edit
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            @if (session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
            @endif

            <form action="{{route('orders.update', [$order->id])}}" method="POST" class="shadow-sm bg-white p-3">
                @csrf

                <input type="hidden" name="_method" value="PUT">
                <label for="invoice_number">Invoice Number</label><br>
                <input type="text" name="" id="" value="{{$order->invoice_number}}" class="form-control" disabled>
                <br>
                <label for="">Buyer</label><br>
                <input type="text" name="" id="" value="{{$order->user->name}}" class="form-control" disabled>
                <br>
                <label for="created_at">Order Date</label><br>
                <input type="text" name="" id="" value="{{$order->created_at}}" class="form-control" disabled>
                <br>
                <label for="">Products ({{$order->totalQuantity}})</label><br>
                <ul>
                    @foreach ($order->products as $product)
                        <li>{{$product->name}} <b>({{$product->pivot->quantity}})</b></li>
                    @endforeach
                </ul>

                <label for="">Toatal Price</label><br>
                <input type="text" name="" id="" value="{{$order->total_price}}" class="form-control" disabled>
                <br>
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="SUBMIT" {{$order->status == "SUBMIT" ? "selected" : ""}}>SUBMIT</option>
                    <option value="PROCESS" {{$order->status == "PROCESS" ? "selected" : ""}}>PROCESS</option>
                    <option value="FINISH" {{$order->status == "FINISH" ? "selected" : ""}}>FINISH</option>
                    <option value="CANCEL" {{$order->status == "CANCEL" ? "selected" : ""}}>CANCEL</option>
                </select>
                <br>

                <input type="submit" class="btn btn-primary" value="update">
            </form>
        </div>
    </div>
@endsection