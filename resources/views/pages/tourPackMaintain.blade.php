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
                <li class="breadcrumb-item active"><a href="/managetour">Pengaturan Tour</a></li>
                <li class="breadcrumb-item active">Tambah Tour</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <form id="formPack" name="formPack" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <label>Gambar</label>
                        <div class="row">
                            <div class="col-3">
                                <figure class="figure">
                                    <img src="assets/img/imgdefault.png" id="img_cov" class="figure-img img-fluid rounded" alt="...">
                                    <figcaption class="figure-caption text-end">A caption for the above image.</figcaption>
                                </figure>
                            </div>
                            <div class="col-3">
                                <figure class="figure">
                                    <img src="assets/img/imgdefault.png" class="figure-img img-fluid rounded" alt="...">
                                    <figcaption class="figure-caption text-end">A caption for the above image.</figcaption>
                                </figure>
                            </div>
                            <div class="col-3">
                                <figure class="figure">
                                    <img src="assets/img/imgdefault.png" class="figure-img img-fluid rounded" alt="...">
                                    <figcaption class="figure-caption text-end">A caption for the above image.</figcaption>
                                </figure>
                            </div>
                            <div class="col-3">
                                <figure class="figure">
                                    <img src="assets/img/imgdefault.png" class="figure-img img-fluid rounded" alt="...">
                                    <figcaption class="figure-caption text-end">A caption for the above image.</figcaption>
                                </figure>
                            </div>
                        </div>
                        <label>Cover</label>
                        <input type="file" id="pack_cov" name="pack_cov" class="form-control"/>
                        <label>Gambar 1</label>
                        <input type="file" id="img_1" name="img_1" class="form-control"/>
                        <label>Gambar 2</label>
                        <input type="file" id="img_2" name="img_2" class="form-control"/>
                        <label>Gambar 3</label>
                        <input type="file" id="img_3" name="img_3" class="form-control"/>
                        <hr>
                        <label>Video</label>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
                        </div>
                        <label>Video URL</label>
                        <input type="text" id="pack_vid" name="pack_vid" class="form-control"/>
                    </div>
                    <div class="col-md-6">
                        <label>Nama Tour</label>
                        <input type="text" id="pack_nm" name="pack_nm" class="form-control"/>
                        <label>Waktu Tour</label>
                        <input type="text" id="pack_time" name="pack_time" class="form-control"/>
                        <label>Kota/Lokasi</label>
                        <input type="text" id="pack_city" name="pack_city" class="form-control"/>
                        <label>Harga Pack</label>
                        <input type="number" id="pack_price" name="pack_price" class="form-control"/>
                        <label>Deskripsi</label>
                        <textarea id="pack_desc" name="pack_desc">

                        </textarea>
                        <div class="row" style="padding-left: 5%">
                        @foreach ($facilities as $fac)
                            <div class="col-sm-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="{{'F'.$fac->id}}" id="{{'F'.$fac->id}}">
                                    <label class="form-check-label" for="{{'F'.$fac->id}}">{{$fac->fac_nm}}</label>
                                </div>
                            </div>
                        @endForeach
                        </div>
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalfacility">
                                <i class="fas fa-plus"></i>
                                Tambah Fasilitas
                            </button>
                        <hr>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-md-2">
                                <button id="saveBtn" type="button" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modalfacility" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tambah Fasilitas</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formfacility" name="formfacility">
              <label>Nama Fasilitas</label>
              <input type="text" id="fac_nm" name="fac_nm" class="form-control">
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="button" id="btnSaveFac" class="btn btn-primary">Simpan Fasilitas</button>
        </div>
      </div>
    </div>
  </div>
@endsection



