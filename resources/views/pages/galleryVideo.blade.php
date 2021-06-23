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
                    <li class="breadcrumb-item active">Gallery Video</li>
                </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <button class="btn btn-primary"  id="addvid" data-bs-toggle="modal" data-bs-target="#modalgalvid"><i class="fas fa-plus"></i> Tambah Video Baru</button>
            <hr>
            <div class="card card-body table-responsive">
                <table class="table table-striped table-hover table-bordered ">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>View</th>
                            <th>Video Name</th>
                            <th>Video URL</th>
                            <th>Desc</th>
                            <th>Seq</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vidoes as $vid)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                <div class="ratio ratio-16x9">
                                <iframe src="{{$vid->video_url}}" title="YouTube video" allowfullscreen></iframe>
                              </div>
                            </td>
                            <td>{{$vid->video_nm}}</td>
                            <td>{{$vid->video_url}}</td>
                            <td>{{$vid->video_desc}}</td>
                            <td>{{$vid->seq}}</td>
                            <td>
                                <button type="button" data="{{json_encode($vid)}}" class="btn btn-info btneditvid" ><i class="fas fa-edit"></i></button>
                                <button type="button" id="{{'vidbtndel_'.$vid->id}}" class="btn btn-danger btndelvid"><i class="fas fa-trash"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalgalvid" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Video Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <form id="formvid" name="formvid" >
             <label>Nama Video</label>
             <input type="text" required class="form-control" id="vidname" name="vidname">
             <input type="hidden" id="idvid" name="idvid">
             <label>URL</label>
             <input type="text" required class="form-control" id="url" name="url">
             <label>Deskrpsi</label>
             <textarea class="form-control" required id="viddesk" name="viddesk"></textarea>
             <label>Urutan</label>
             <input type="number" required class="form-control" id="seq" name="seq">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="btnsavevid" name="btnsavevid" class="btn btn-primary">Save changes</button>
        </div>
    </form>
      </div>
    </div>
  </div>
@endsection
