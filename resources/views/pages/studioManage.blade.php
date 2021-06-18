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
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Pengaturan Studio</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <a href="/addnewtour" class="btn btn-primary"><i class="fas fa-plus"></i>  Tambah Studio Baru</a>
            <hr>
            <div class="d-flex justify-content-center">
                {!! $datarows->links() !!}
            </div>
            <div class="row">
                @foreach ($datarows as $item)
                <div class="col-md-3">
                    <div class="{{$item->use_mk?'card card-primary':'card card-secondary'}}">
                        <div class="card-header">
                            <h5>{{$item->pack_nm}}</h5>
                        </div>
                        <a href="{{'editpack/'.$item->id}}">
                        <div class="card-body">
                            <img src="{{asset('storage/images/370x300/'.$item->file_nm)}}"class="figure-img img-fluid rounded"/>
                            <strong ><i class="fas fa-map-marker-alt mr-1"></i>{{$item->city}}</strong>
                            <br>
                            <strong ><i class="fas fa-tags mr-1"></i> Rp.{{number_format($item->price)}}</strong>
                            <hr>
                            <p class="text-muted">{{substr($item->pack_desc,1,50)}}...</p>
                        </div>
                        </a>
                        <div class="card-footer">
                            {{-- <div class="row">
                                <div class="col-md-12">
                                    <a href="{{'editpack/'.$item->id}}" class="form-control btn btn-app bg-primary"><i class="fas fa-eye"></i> Lihat</a>
                                </div>
                            </div> --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <button id="{{'btndelpack_'.$item->id}}" type="button" value="{{$item->id}}" class="form-control  btn btn-app bg-danger btndelpack"><i class="fas fa-trash"></i> Hapus</button>
                                    </div>
                                <div class="col-md-6">
                                    <button id="{{'btndisbpack_'.$item->id}}" type="button" value="{{$item->id}}"
                                        class="form-control {{$item->use_mk?'btn btn-app bg-danger btndisbpack':'btn btn-app bg-success btndisbpack'}}">
                                        <i class="{{$item->use_mk?'fas fa-ban':'fas fa-check'}}"></i>{{$item->use_mk?'Disable':'Enable'}}
                                    </button>
                                </div>
                            </div>
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

