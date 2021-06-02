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
            <div class="d-flex justify-content-center">
                {!! $datarows->links() !!}
            </div>
            <div class="row">
                @foreach ($datarows as $item)
                <div class="col-md-3">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h5>{{$item->pack_nm}}</h5>
                        </div>
                        <div class="card-body">
                            <img src="{{URL::asset('assets/img/imgdefault.png')}}"class="figure-img img-fluid rounded"/>
                            <strong ><i class="fas fa-map-marker-alt mr-1"></i>{{$item->city}}</strong>
                            <br>
                            <strong ><i class="fas fa-tags mr-1"></i> Rp.{{number_format($item->price)}}</strong>
                            <hr>
                            <p class="text-muted">{{substr($item->pack_desc,1,50)}}...</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{'editpack/'.$item->id}}" class="btn btn-sm btn-primary"><i class="fas fa-eye"></i> Lihat</a>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Hapus</button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-ban"></i> Non Aktif</button>
                        </div>
                      </div>
                </div>
                @endForeach
                <div class="d-flex justify-content-center">
                    {!! $datarows->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

