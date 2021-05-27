@extends('layouts.app')
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
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Pesanan Baru</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <table
                    id="table"
                    class="table table-bordered table-striped"
                    data-toggle="table"
                    data-url="json/data1.json"
                    >
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Status</th>
                            <th scope="col">Kode Tour</th>
                            <th scope="col">Nama Tour</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Harga Pack</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">Total</th>
                            <th scope="col">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datarows as $item)

                        <tr>
                            <td>{{($datarows->currentPage()*$datarows->count())-$datarows->count()+$loop->iteration }}</td>
                            <td></td>
                            <td>{{$item->pack_nm}}</td>
                            <td>{{$item->city}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                  <div class="d-flex justify-content-center">
                    {!! $datarows->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

