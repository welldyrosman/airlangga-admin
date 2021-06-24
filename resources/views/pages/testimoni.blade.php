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
                    <li class="breadcrumb-item active">Testimoni Control</li>
                </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <button class="btn btn-primary" id="addtesti" data-bs-toggle="modal" data-bs-target="#modaltesti"><i class="fas fa-plus"></i> Tambah Testimoni</button>
            <hr>
            <div class="card card-body">
                <table class="table table-striped table-hover table-bordered projects">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>View</th>
                            <th>Nama</th>
                            <th>Testimoni</th>
                            <th>Seq</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($testimonies as $testi)
                        <tr>
                            <th>{{$loop->iteration}}</th>
                            <th><img class="table-avatar" src="{{asset('storage/'.$testi->photo_path.'/'.$testi->photo)}}" ></th>
                            <th>{{$testi->people_name}}</th>
                            <th>{{$testi->testimoni}}</th>
                            <th>{{$testi->seq}}</th>
                            <th><button type="button" data="{{json_encode($testi)}}" img-src="{{asset('storage/'.$testi->photo_path.'/'.$testi->photo)}}" class="btn btn-info btn-sm btnedittim" ><i class="fas fa-edit"></i> Edit</button>
                                <button type="button" id="{{'testidel_'.$testi->id}}" class="btn btn-danger btn-sm btndeltesti"><i class="fas fa-trash"></i> Delete</button></th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modaltesti" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Testimoni Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="text-center">
                <img width="100px" id="view_img_testi" height="100px" src="{{asset('vendors/dist/img/avatar5.png')}}" class="img-thumbnail" alt="...">
            </div>
            <form id="formtesti" name="formtesti" enctype="multipart/form-data" >
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="hidden" id="idtesti" name="idtesti">
                    <input type="text"  class="form-control" id="fullnm" name="fullnm">
                </div>
                <div class="form-group">
                    <label>Testimoni</label>
                    <textarea class="form-control" required id="testimoni" name="testimoni"></textarea>
                </div>
                <label>Photo</label>
                <input type="file" class="form-control" id="imgtesti" name="imgtesti">
                <div class="form-group">
                    <label>Urutan</label>
                    <input type="number"  class="form-control" id="testiseq" name="testiseq">
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="btnsavetesti" name="btnsavetesti" class="btn btn-primary">Save changes</button>
        </div>
            </form>
      </div>
    </div>
  </div>
@endsection
