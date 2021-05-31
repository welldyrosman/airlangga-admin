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
                <li class="breadcrumb-item active">Pengaturan Tour</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <a href="/addnewtour" class="btn btn-primary"><i class="fas fa-plus"></i>  Tambah Tour Baru</a>
            <hr>
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
                            <th scope="col">Kode Tour</th>
                            <th scope="col">Nama Tour</th>
                            <th scope="col">Kota</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Deskrpsi</th>
                            <th scope="col">#</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datarows as $item)
                        <tr>
                            <td>{{($datarows->currentPage()*$datarows->count())-$datarows->count()+$loop->iteration }}</td>
                            <td>{{'TRVL'.$item->id}}</td>
                            <td>{{$item->pack_nm}}</td>
                            <td>{{$item->city}}</td>
                            <td>{{number_format($item->price)}}</td>
                            <td>{{$item->pack_desc}}</td>
                            <td><a href="{{'editpack/'.$item->id}}" class="btn btn-sm btn-info"><i class="fas fa-edit"></i>Edit</a></td>
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

