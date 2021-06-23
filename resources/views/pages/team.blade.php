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
                    <li class="breadcrumb-item active">Team Control</li>
                </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <button class="btn btn-primary" id="addtim" data-bs-toggle="modal" data-bs-target="#modaltim"><i class="fas fa-plus"></i> Tambah Team Baru</button>
            <hr>
            <div class="card card-body">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>View</th>
                            <th>Nama Panggil</th>
                            <th>Nama Lengkap</th>
                            <th>Akun IG</th>
                            <th>Jabatan</th>
                            <th>Seq</th>
                            <th>Desc</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($teams as $team)
                        <tr>
                            <th>{{$loop->iteration}}</th>
                            <th><img src="{{asset('storage/'.$team->photo_path.'/'.$img->photo)}}}}" width="50px" width="50px"></th>
                            <th>{{$team->nickname}}</th>
                            <th>{{$team->fullname}}</th>
                            <th>{{$team->ig}}</th>
                            <th>{{$team->position}}</th>
                            <th>{{$team->seq}}</th>
                            <th>Desc</th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modaltim" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Team Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="text-center">
            <img width="100px" id="view_img_tim" height="100px" src="{{asset('vendors/dist/img/avatar5.png')}}" class="img-thumbnail" alt="...">
        </div>
         <form id="formtim" name="formtim" enctype="multipart/form-data" >

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>Nama Pangilan</label>
                        <input type="text"  class="form-control" id="nicknm" name="nicknm">
                        <input type="hidden" id="idtim" name="idtim">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text"  class="form-control" id="fullnm" name="fullnm">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>Akun Instagram</label>
                        <input type="text"  class="form-control" id="akunig" name="akunig">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text"  class="form-control" id="jabatan" name="jabatan">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label>Photo</label>
                        <input type="file" class="form-control" id="imgtim" name="imgtim">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>Urutan</label>
                        <input type="number"  class="form-control" id="timseq" name="timseq">
                        </div>
                    </div>

            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="btnsavetim" name="btnsavetim" class="btn btn-primary">Save changes</button>
        </div>
    </form>
      </div>
    </div>
  </div>
@endsection
