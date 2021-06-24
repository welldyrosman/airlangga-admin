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
                    <li class="breadcrumb-item active">FAQ Control</li>
                </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <button class="btn btn-primary" id="addfaq" data-bs-toggle="modal" data-bs-target="#modalfaq"><i class="fas fa-plus"></i> Tambah Pertanyaan Baru</button>
            <hr>
            <div class="card card-body table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pertanyaan</th>
                            <th>Jawaban</th>
                            <th>Urutan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($faqs as $faq)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$faq->subject}}</td>
                            <td>{{$faq->deskripsi}}</td>
                            <td>{{$faq->seq}}</td>
                            <td>
                                <button type="button" data="{{json_encode($faq)}}" class="btn btn-info btn-sm btneditfaq" ><i class="fas fa-edit"></i> Edit</button>
                                <button type="button" id="{{'btndel_'.$faq->id}}" class="btn btn-danger btn-sm btndelfaq"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalfaq" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">FAQ Form</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
         <form id="formfaq" name="formfaq" >
             <label>Pertanyaan</label>
             <input type="text" required class="form-control" id="question" name="question">
             <input type="hidden" id="idfaq" name="idfaq">
             <label>Jawaban</label>
             <textarea class="form-control" required id="answer" name="answer"></textarea>
             <label>Urutan</label>
             <input type="number" required class="form-control" id="seq" name="seq">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" id="btnsavefaq" name="btnsavefaq" class="btn btn-primary">Save changes</button>
        </div>
    </form>
      </div>
    </div>
  </div>
@endsection
