@extends('layouts.globe')
@section('title')
    Orders List
@endsection
@section('content')
    <form action="{{route('orders.index')}}">
        <div class="row">
            <div class="col-md-5">
                <input value="{{Request::get('user_email')}}" name="user_email" type="text" class="form-control" placeholder="search by buyer email">
            </div>
            <div class="col-md-2">
                <select name="status" id="status" class="form-control">
                    <option value="">ALL</option>
                    <option value="SUBMIT" {{Request::get('status') == "SUBMIT" ? "selected" : ""}}>SUBMIT</option>
                    <option value="PROCESS" {{Request::get('status') == "PROCESS" ? "selected" : ""}}>PROCESS</option>
                    <option value="FINISH" {{Request::get('status') == "FINISH" ? "selected" : ""}}>FINISH</option>
                    <option value="CANCEL" {{Request::get('status') == "CANCEL" ? "selected" : ""}}>CANCEL</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="submit" value="filter" class="btn btn-primary">
            </div>
        </div>
    </form>
    <hr class="my-3">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-stripped table-bordered">
                <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Status</th>
                        <th>Buyer</th>
                        <th>Total Quantity</th>
                        <th>Order Date</th>
                        <th>Total Price</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{$order->invoice_number}}</td>
                            <td>
                                @if ($order->status == "SUBMIT")
                                    <span class="badge bg-warning text-light">{{$order->status}}</span>
                                @elseif($order->status == "PROCESS")
                                    <span class="badge bg-info text-light">{{$order->status}}</span>
                                @elseif($order->status == "FINISH")
                                    <span class="badge bg-success text-light">{{$order->status}}</span>                                    
                                @elseif($order->status == "CANCEL")
                                    <span class="badge bg-dark text-light">{{$order->status}}</span>
                                @endif
                            </td>
                            <td>
                                {{$order->user->name}} <br>
                                <small>{{$order->user->email}}</small>
                            </td>
                            <td>{{$order->Totalquantity}}</td>
                            <td>{{$order->created_at}}</td>
                            <td>{{$order->total_price}}</td>
                            <td>
                                <a href="{{route('orders.edit', [$order->id])}}" class="btn btn-info btn-sm"> Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="10">
                            {{$orders->appends(Request::all())->links()}}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection