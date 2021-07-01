@extends('layouts.html')
@section('content')
<div id="content">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0">{{$title}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">New Booking Travel</li>
                </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card card-body table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Booking No</th>
                            <th>Nama Pemesan</th>
                            <th>No Telp</th>
                            <th>email</th>
                            <th>Pack Qty</th>
                            <th>Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $book)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$book->book_no}}</td>
                            <td>{{$book->name}}</td>
                            <td>{{$book->phone_no}}</td>
                            <td>{{$book->email}}</td>
                            <td>{{$book->pack_qty}}</td>
                            <td>{{'Rp. '.number_format($book->pack_qty*$book->price)}}</td>
                            <td>
                                <button type="button" data="{{json_encode($book)}}" class="btn btn-info btn-sm btnpaytravel" ><i class="fas fa-cash-register"></i> Bayar</button>
                               {{--  <button type="button" id="{{'btndel_'.$faq->id}}" class="btn btn-danger btn-sm btndelfaq"><i class="fas fa-trash"></i> Delete</button> --}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
