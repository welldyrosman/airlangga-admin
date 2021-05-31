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
                <li class="breadcrumb-item active">{{$title}}</li>
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
                                    <img src="assets/img/imgdefault.png" id="view_img_1" class="figure-img img-fluid rounded" alt="...">
                                    <figcaption class="figure-caption text-end">A caption for the above image.</figcaption>
                                </figure>
                            </div>
                            <div class="col-3">
                                <figure class="figure">
                                    <img src="assets/img/imgdefault.png" id="view_img_2" class="figure-img img-fluid rounded" alt="...">
                                    <figcaption class="figure-caption text-end">A caption for the above image.</figcaption>
                                </figure>
                            </div>
                            <div class="col-3">
                                <figure class="figure">
                                    <img src="assets/img/imgdefault.png" id="view_img_3" class="figure-img img-fluid rounded" alt="...">
                                    <figcaption class="figure-caption text-end">A caption for the above image.</figcaption>
                                </figure>
                            </div>
                            <div class="col-3">
                                <figure class="figure">
                                    <img src="assets/img/imgdefault.png" id="view_img_4" class="figure-img img-fluid rounded" alt="...">
                                    <figcaption class="figure-caption text-end">A caption for the above image.</figcaption>
                                </figure>
                            </div>
                        </div>
                        @for($i=1;$i<5;$i++)
                            <label>Gambar {{$i}}</label>
                            <input type="file" id="{{'img_'.$i}}" name="{{'img_'.$i}}" class="form-control"/>
                            <div class="row">
                                <div class="col-9">
                                    <input type="text" id="{{'img_'.$i.'_note'}}" name="{{'img_'.$i.'_note'}}" class="form-control form-control-sm" placeholder="Note/Caption"/>
                                </div>
                                <div class="col-3" style="padding-left: 5%">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="radio" name="{{'iscover'}}" value="{{$i}}" id="{{'isCover'.$i}}">
                                        <label class="form-check-label" for="{{'isCover'.$i}}">Cover</label>
                                    </div>
                                </div>
                            </div>
                        @endFor
                        <hr>
                        <label>Video</label>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="{{$isNew?null:$datatour->vid_url}}" allowfullscreen></iframe>
                        </div>
                        <label>Video URL</label>
                        <input type="text" id="pack_vid" name="pack_vid" value="{{$isNew?null:$datatour->vid_url}}" class="form-control"/>
                    </div>
                    <div class="col-md-6">
                        <label>Nama Tour</label>
                        <input type="text" id="pack_nm" name="pack_nm" value="{{$isNew?null:$datatour->pack_nm}}" class="form-control"/>
                        <label>Kota/Lokasi</label>
                        <input type="text" id="pack_city" name="pack_city" value="{{$isNew?null:$datatour->city}}" class="form-control"/>
                        <label>Harga Pack</label>
                        <input type="number" id="pack_price" name="pack_price" value="{{$isNew?null:$datatour->price}}" class="form-control"/>
                        <label>Deskripsi</label>
                        <textarea id="pack_desc" name="pack_desc">
                            {{$isNew?null:$datatour->pack_desc}}
                        </textarea>
                        <div class="row" style="padding-left: 5%">
                        @foreach ($facilities as $fac)
                            <div class="col-sm-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" {{$fac->use_mk?'checked':''}} name="{{'F'.$fac->id}}" id="{{'F'.$fac->id}}">
                                    <label class="form-check-label" for="{{'F'.$fac->id}}">{{$fac->fac_nm}}</label>
                                    <input type="text" name="{{'NF'.$fac->id}}" id="{{'NF'.$fac->id}}" value="{{$isNew?null:$fac->note}}" class="form-control form-control-sm" placeholder="Note/Caption"/>
                                </div>

                            </div>
                        @endForeach
                        </div>
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalfacility">
                                <i class="fas fa-plus"></i>
                                Tambah Fasilitas
                            </button>
                        <hr>
                        <label>Waktu Tour</label>
                            <button type="button" id="btntime" class="btn btn-sm btn-primary"><i class="fas fa-plus"></i></button>
                            <button type="button" id="btntime" class="btn btn-sm btn-info butdeldate"><i class="fas fa-plus"></i></button>
                            <div id="contime"></div>
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
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>



