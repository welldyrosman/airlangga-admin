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
                    <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                    <li class="breadcrumb-item active">New Booking Travel</li>
                </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <script src="{{ mix('js/app/newbooktravelEvent.js') }}"></script>
    <div class="content">
        <div class="container-fluid">
            <div class="card card-body table-responsive">
                <table class="table table-hover table-bordered"
                id="tablenewbooktravel"
                data-toggle="table"
                data-height="460"
                data-search="true"
                data-show-refresh="true"
                data-method="get"
                data-pagination="true"
                data-side-pagination="server"
                data-url="/getbookstravel">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th data-field="book_no">Booking No</th>
                            <th data-field="name">Nama Pemesan</th>
                            <th data-field="phone_no">No Telp</th>
                            <th data-field="email">email</th>
                            <th data-field="pack_nm">Nama Paket</th>
                            <th data-field="book_time">Tgl Book</th>
                            <th data-field="pack_date">Tgl Berangkat</th>
                            <th data-field="pack_qty">Pack Qty</th>
                            <th data-field="price">Total</th>
                            <th data-formatter="operateFormatter" >Aksi</th>
                        </tr>
                    </thead>

                </table>
            </div>
        </div>
    </div>
</div>
<script>
</script>
@endsection
