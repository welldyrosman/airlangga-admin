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
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <label>Gambar</label>
                    <div class="row">
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
                        <div class="col-3">
                            <figure class="figure">
                                <img src="assets/img/imgdefault.png" class="figure-img img-fluid rounded" alt="...">
                                <figcaption class="figure-caption text-end">A caption for the above image.</figcaption>
                            </figure>
                        </div>
                    </div>
                    <label>Cover</label>
                    <input type="file" class="form-control"/>
                    <label>Gambar 1</label>
                    <input type="file" class="form-control"/>
                    <label>Gambar 2</label>
                    <input type="file" class="form-control"/>
                    <label>Gambar 3</label>
                    <input type="file" class="form-control"/>
                    <hr>
                    <label>Video</label>
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
                      </div>
                    <label>Video URL</label>
                    <input type="text" class="form-control"/>
                </div>
                <div class="col-md-6">
                    <label>Nama Tour</label>
                    <input type="text" class="form-control"/>
                    <label>Waktu Tour</label>
                    <input type="text" class="form-control"/>
                    <label>Kota/Lokasi</label>
                    <input type="text" class="form-control"/>
                    <label>Harga Pack</label>
                    <input type="text" class="form-control"/>
                    <label>Deskripsi</label>
                    <textarea id="summernote">

                    </textarea>
                    <div class="row" style="padding-left: 5%">
                    @for ($i = 0; $i <= 10; $i++)
                        <div class="col-sm-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="{{'x'.$i}}">
                                <label class="form-check-label" for="{{'x'.$i}}">Default switch checkbox input</label>
                            </div>
                        </div>
                      @endfor
                    </div>
                    <button class="btn btn-sm btn-info">Tambah Facility</button>
                    <hr>
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-md-2">
                            <button class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

