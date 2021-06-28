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
                    <li class="breadcrumb-item active">Slide Photo</li>
                </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <button class="btn btn-primary" id="addslide" data-bs-toggle="modal" data-bs-target="#modalslide"><i class="fas fa-plus"></i> Tambah Slide</button>
            <hr>
            <div class="card card-body">
                <table class="table table-striped table-hover table-bordered projects">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Slide Name</th>
                            <th>Slide Desc</th>
                            <th>Seq</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($slides as $slide)
                        <tr>
                            <td align="center" colspan="6"> <img class="img-fluid" src="{{asset('storage/'.$slide->photo_path.'/'.$slide->photo)}}" ></td>
                        </tr>
                        <tr>
                            <th>{{$loop->iteration}}</th>
                            <th>{{$slide->slide_nm}}</th>
                            <th>{{$slide->slide_desc}}</th>
                            <th>{{$slide->seq}}</th>
                            <th>Status</th>
                            <th><button type="button" data="{{json_encode($slide)}}" img-src="{{asset('storage/'.$slide->photo_path.'/'.$slide->photo)}}" class="btn btn-info btn-sm btneditslide" ><i class="fas fa-edit"></i> Edit</button>
                                <button type="button" id="{{'slideban_'.$slide->id}}" class="{{($slide->stop_mk==0?'btn btn-warning':'btn btn-success').' btn-sm btnbanslide'}}"><i class="{{$slide->stop_mk==0?'fas fa-ban':'fas fa-plug'}}"></i> {{$slide->stop_mk==0?'Disabled':'Enabled'}}</button>
                                <button type="button" id="{{'slidedel_'.$slide->id}}" class="btn btn-danger btn-sm btndelslide"><i class="fas fa-trash"></i> Delete</button></th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalslide" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Photo Slide Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="text-center">
                <input type="hidden" id="pathslide" value="{{asset('vendors/dist/img/avatar5.png')}}"/>
                <img width="100px" id="view_img_slide" height="100px" src="{{asset('vendors/dist/img/avatar5.png')}}" class="img-thumbnail" alt="...">
            </div>
            <form id="formslide" name="formslide" enctype="multipart/form-data" >
                <div class="form-group">
                    <label>Caption Slide</label>
                    <input type="hidden" id="idslide" name="idslide">
                    <input type="text"  class="form-control" id="slidenm" name="slidenm">
                </div>
                <div class="form-group">
                    <label>Deksripsi Slide</label>
                    <textarea class="form-control"  id="slidedesc" name="slidedesc"></textarea>
                </div>
                <label>Photo</label>
                <input type="file" class="form-control" id="imgslide" name="imgslide">
                <div class="form-group">
                    <label>Urutan</label>
                    <input type="number"  class="form-control" id="slideseq" name="slideseq">
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="btnsaveslide" name="btnsaveslide" class="btn btn-primary">Save changes</button>
        </div>
            </form>
      </div>
    </div>
  </div>
@endsection
