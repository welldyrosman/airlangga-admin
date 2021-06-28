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
                <li class="breadcrumb-item active"><a href="/managetour">Pengaturan Studio</a></li>
                <li class="breadcrumb-item active">{{$title}}</li>
            </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <form id="formPack" name="formPack" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="travel_id" id="travel_id" value="{{$travel_id}}"/>
            <input type="hidden" name="isNew" id="isNew" value="{{$isNew}}"/>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <label>Gambar</label>
                        <div class="row">
                            @foreach ($imagelist as $img)
                                <div class="col-3">
                                    <figure class="figure">
                                        <img src="{{$isNew||$img->path==null?URL::asset('assets/img/imgdefault.png'):asset('storage/'.$img->path.'/'.$img->file_nm)}}" id="{{'view_img_'.$loop->iteration}}" class="figure-img img-fluid rounded" alt="...">
                                        <figcaption class="figure-caption text-end">{{$isNew?'Caption Here':$img->note}}</figcaption>
                                    </figure>
                                </div>
                            @endforeach
                        </div>
                        @foreach ($imagelist as $img)
                            <label>Gambar {{$loop->iteration}}</label>
                            <input type="file" id="{{'img_'.$loop->iteration}}" name="{{'img_'.$loop->iteration}}" class="form-control"/>
                            <br>
                            <div class="row">
                                <div class="col-9">
                                    <input type="text"
                                    id="{{'img_'.$loop->iteration.'_note'}}"
                                    name="{{'img_'.$loop->iteration.'_note'}}"
                                    class="form-control form-control-sm"
                                    value="{{$isNew?'':$img->note}}"
                                    placeholder="Note/Caption"/>
                                </div>
                                <div class="col-3" style="padding-left: 5%">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="radio" name="iscover" {{!$isNew?($img->iscover?'checked':''):''}}  value="{{$loop->iteration}}" id="{{'isCover'.$loop->iteration}}">
                                        <label class="form-check-label" for="{{'isCover'.$loop->iteration}}">Cover</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @endforeach
                       </div>
                    <div class="col-md-6">
                        <label>Nama Paket Photo</label>
                        <input type="text" id="pack_nm" name="pack_nm" value="{{$isNew?null:$datatour->pack_nm}}" class="form-control"/>
                        <label>Tipe Photo</label>
                        <select class="form-control" id="type"  value="{{$isNew?null:$datatour->type}}" name="type">
                            <option value="indoor">IN DOOR</option>
                            <option value="outdoor">OUT DOOR</option>
                            <option value="Other">Lain-Lain</option>
                        </select>
                        <label>Harga Pack</label>
                        <input type="number" id="pack_price" name="pack_price" value="{{$isNew?null:$datatour->price}}" class="form-control"/>
                        <label>Deskripsi</label>
                        <textarea id="pack_desc" name="pack_desc"  class="form-control">{{$isNew?null:$datatour->pack_desc}}</textarea>
                        <hr>
                        <h4>Fasilitas</h4>
                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalstufacility">
                            <i class="fas fa-plus"></i>
                            Tambah Fasilitas
                        </button>
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
                        <hr>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-md-2">
                                <a href="/managestudio" class="btn btn-app bg-dark"><i class="fas fa-arrow-left"></i> Kembali</a>
                            </div>
                            <div class="col-md-2">
                                <button id="saveStuBtn" type="button" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="modalstufacility" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
          <button type="button" id="btnSaveFacstudio" class="btn btn-primary">Simpan Fasilitas</button>
        </div>
      </div>
    </div>
  </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>



