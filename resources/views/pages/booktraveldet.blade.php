@extends('layouts.html')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
        <!-- Main content -->
        <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
            <div class="col-12">
                <h4>
                    <img height="100px" src="{{asset('assets/img/travel.png')}}"/> Airlangga Sejahtera Travel.
                    <small class="float-right">Book Date: {{$packages->book_time}}</small>
                </h4>
                <h3 class="float-right text-primary">STATUS :[{{$packages->pay_status}}]</h3>
            </div>
            <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                From
                <address>
                <strong>Airlangga Sejahtera Group</strong><br>
                Perum Puri Anggrek Blok F5 No 4<br>
                Serang- Banten<br>
                Phone: 0811-121-143<br>
                Email: info@airalnggasejahtera.com
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                To
                <address>
                <strong> {{$packages->name}}</strong><br>
                <i class="fas fa-envelope-open-text"></i> Email: {{$packages->email}}<br>
                <i class="fas fa-phone"></i> Phone: {{$packages->phone_no}}<br>
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <input type="hidden" id="idpack" value="{{$packages->id}}"/>
                <input type="hidden" id="totalamt" value="{{$packages->pack_qty*$packages->price}}"/>
                <b >Booking No # <span class="bookno">{{$packages->book_no}}</span></b><br>
                <b>Package Order:</b> [{{$packages->city}}]- {{$packages->pack_nm}}<br>
                <b>Travel Date:</b> {{$packages->pack_date}}<br>
                <b>Harga:  </b>IDR {{number_format($packages->price)}}<br>
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped">
                <thead>
                <tr>
                    <th>Package</th>
                    <th>Pack Qty</th>
                    <th>Travel Date</th>
                    <th>Subtotal</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>[{{$packages->city}}]-{{$packages->pack_nm}}</td>
                        <td>{{$packages->pack_qty}} Pack</td>
                        <td>{{$packages->pack_date}}</td>
                        <td><p><small>IDR</small> {{number_format($packages->pack_qty*$packages->price)}}</p></td>
                    </tr>
                </tbody>
                </table>
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
            <!-- accepted payments column -->
            <div class="col-6">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                        <th style="width:50%">DP Telah dibayar:</th>
                        <td><small>IDR</small> {{number_format($packages->dp_pay)}}</td>
                        </tr>
                        <tr>
                        <th>Sisa Pembayaran</th>
                        <td><small>IDR</small> {{number_format(($packages->pack_qty*$packages->price)-$packages->dp_pay)}}</td>
                        </tr>
                    </table>
                    </div>
            </div>
            <!-- /.col -->
            <div class="col-6">
                <p class="lead">Amount Due {{date('Y-m-d', strtotime('-2 days', strtotime($packages->pack_date)))}}</p>
                <script src="{{ mix('js/app/actionNewbook.js') }}"></script>
                <div class="table-responsive">
                <table class="table">
                    <tr>
                    <th style="width:50%">Subtotal:</th>
                    <td><small>IDR</small> {{number_format($packages->pack_qty*$packages->price)}}</td>
                    </tr>
                    <tr>
                    <th>Discount</th>
                    <td><small>IDR</small> {{number_format($packages->disc)}}</td>
                    </tr>
                    <tr>
                    <th>Total</th>
                    <td><h5><small>IDR</small> {{number_format(($packages->pack_qty*$packages->price)-$packages->disc)}}</h5></td>
                    </tr>
                    <tr>
                    <th>Booking DP Min 30%:</th>
                    <td><h5><small>min IDR </small> {{number_format((($packages->pack_qty*$packages->price)-$packages->disc)*0.3)}}</h5></td>
                    </tr>
                </table>
                </div>
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
            <div class="col-12 text-right">
                {{-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                Payment
                </button> --}}
                <button class="btn btn-danger">Refund</button>
                <button class="btn btn-success">Pelunasan</button>
                <button id="btnbyrdp"  class="btn btn-success {{$packages->pay_status=="Booked"?'':'disabled'}}">Bayar DP</button>
                <button id="btnbtltrip" class="btn btn-danger">Batalkan Trip</button>
                <button class="btn btn-warning">Ubah Tanggal Trip</button>
                <a href="{{'/bookpdf/'.$packages->id}}" target="_blank" type="button" class="btn btn-primary" style="margin-right: 5px;">
                <i class="fas fa-download"></i> Generate PDF
                </a>
            </div>
            </div>
        </div>
        <!-- /.invoice -->
        </div><!-- /.col -->
    </div>
</div>

@endsection
