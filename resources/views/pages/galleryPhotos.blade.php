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
                    <li class="breadcrumb-item active">Gallery Photo</li>
                </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <button class="btn btn-primary" id="addpic" data-bs-toggle="modal" data-bs-target="#modalpic"><i class="fas fa-plus"></i> Tambah picmoni</button>
            <hr>
            <div class="card card-body">
                <table class="table table-striped table-hover table-bordered projects">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>View</th>
                            <th>Photo Name</th>
                            <th>Photo Desc</th>
                            <th>Seq</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($photos as $pic)
                        <tr>
                            <th>{{$loop->iteration}}</th>
                            <th><img class="table-avatar" src="{{asset('storage/'.$pic->photo_path.'/'.$pic->photo)}}" ></th>
                            <th>{{$pic->photo_nm}}</th>
                            <th>{{$pic->photo_desc}}</th>
                            <th>{{$pic->seq}}</th>
                            <th>Status</th>
                            <th><button type="button" data="{{json_encode($pic)}}" img-src="{{asset('storage/'.$pic->photo_path.'/'.$pic->photo)}}" class="btn btn-info btn-sm btneditpic" ><i class="fas fa-edit"></i> Edit</button>
                                <button type="button" id="{{'picdel_'.$pic->id}}" class="btn btn-danger btn-sm btndelpic"><i class="fas fa-trash"></i> Delete</button></th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalpic" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Photo Gallery Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="text-center">
                <input type="hidden" id="pathpic" value="{{asset('vendors/dist/img/avatar5.png')}}"/>
                <img width="100px" id="view_img_pic" height="100px" src="{{asset('vendors/dist/img/avatar5.png')}}" class="img-thumbnail" alt="...">
            </div>
            <form id="formpic" name="formpic" enctype="multipart/form-data" >
                <div class="form-group">
                    <label>Nama Foto</label>
                    <input type="hidden" id="idpic" name="idpic">
                    <input type="text"  class="form-control" id="photonm" name="photonm">
                </div>
                <div class="form-group">
                    <label>Deksripsi Foto</label>
                    <textarea class="form-control"  id="photodesc" name="photodesc"></textarea>
                </div>
                <label>Photo</label>
                <input type="file" class="form-control" id="imgpic" name="imgpic">
                <div class="form-group">
                    <label>Urutan</label>
                    <input type="number"  class="form-control" id="picseq" name="picseq">
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="btnsavepic" name="btnsavepic" class="btn btn-primary">Save changes</button>
        </div>
            </form>
      </div>
    </div>
  </div>
@endsection
