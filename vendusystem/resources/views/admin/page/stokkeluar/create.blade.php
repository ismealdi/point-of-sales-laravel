@extends('admin.layouts.frame')
@section('title', 'Tambah Stok Keluar')
@section('description', 'Mohon lengkapi seluruh informasi data')
@section('button')
    <a href="{{ url('/admin/keluar') }}" class="btn btn-info btn-xs no-border">Kembali</a>
@endsection

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-danger {{ (count($errors)) ? '' : 'hidden' }}">
                    <div class="panel-body panel-bordered ">
                        <div class="row">
                            <div class="col-xs-12">
                                {!! $errors->first('toko', '<label class="lb-di error">:message</label>') !!}
                                {!! $errors->first('catatan', '<label class="lb-di error">:message</label>') !!}
                                {!! $errors->first('tanggal', '<label class="lb-di error">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::open(['url' => 'admin/keluar', 'id' => 'formValidate', 'files' => true]) !!}
                <div class="panel panel-default m-b-0">
                    <div class="panel-body sm-p-t-15">

                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group form-group-default input-group {{ $errors->has('tanggal') ? 'has-error' : ''}}">
                                    {!! Form::label('tanggal', "tanggal") !!}
                                    {!! Form::text('tanggal', Date('Y-m-d'), ['class' => 'form-control input-md datepicker-text input-re', 'required', 'readonly']) !!}
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                                <div class="form-group form-group-default form-group-default-select2 input-group required {{ $errors->has('toko') ? 'has-error' : ''}}">
                                    {!! Form::label('toko', "toko", ["class" => 'label-top-0']) !!}
                                    {!! Form::select('toko', $toko, null, ['class' => 'full-width', 'data-init-plugin' => 'select2', 'id' => 'toko', 'required']) !!}
                                    <div class="input-group-addon no-padding">
                                        <a class="btn btn-default btn-group p-t-15" onclick="addToko()"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group form-group-default {{ $errors->has('catatan') ? 'has-error' : ''}}">
                                    {!! Form::label('catatan', "catatan") !!}
                                    {!! Form::textarea('catatan', null, ['class' => 'form-control input-md',  'style' => 'min-height: 90px;max-height: 90px;']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row b-t b-grey p-t-10">
                            <div class="col-sm-6 col-xs-8">
                                <div class="form-group form-group-default form-group-default-select2">
                                    {!! Form::label('produk', "produk", ["class" => '']) !!}
                                    {!! Form::select(null, $produk, null, ['class' => 'full-width', 'data-init-plugin' => 'select2', 'id' => 'produkSelector']) !!}
                                </div>
                            </div>
                            <div class="col-sm-5 col-xs-4 font-montserrat fs-12">
                                <div class="form-group form-group-default">
                                    {!! Form::label('jumlah', "jumlah", ['id' => 'jumlahLabel']) !!}
                                    {!! Form::text(null, 0, ['class' => 'form-control input-md autonumeric onfocus', 'id' => 'jumlahSelector', 'data-m-dec' => '0', 'data-a-sep' => ',', 'data-a-pad' => 'true', 'data-m-round' => 's']) !!}
                                </div>
                            </div>
                            <div class="col-sm-1 col-xs-12">
                                <a onClick="addData()" class="btn btn-success btn-xs btn-rounded" type="button"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <div id="bodySelector">

                        </div>

                        <br/>

                        <div class="pull-left m-b-20">
                            <div class="checkbox check-success">
                                <input id="checkbox-agree" type="checkbox" required> <label for="checkbox-agree"><small>Saya sudah mengecek data sebelum menyimpan</small></label>
                            </div>
                        </div>

                        <br/>

                        <button class="btn btn-default btn-rounded btn-sm p-l-30 p-r-30 m-r-10" type="reset">BERSIHKAN</button>
                        {!! Form::submit('SIMPAN', ['type' => 'submit', 'class' => 'btn btn-success btn-rounded btn-sm p-l-30 p-r-30']) !!}


                    </div>
                </div>

                <textarea id="valueSelector" class="hidden" name="details">{"data":[]}</textarea>

                {!! Form::close() !!}
            </div>
        </div>
    </div>


    <div class="modal fade stick-up" id="modalAddError" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header p-b-25">
                    <h5><span class="semi-bold">Data</span> Tidak Lengkap!</h5>
                </div>
            </div>
        </div>
    </div>

    @include('admin.dialog.toko.create')
@endsection

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(".onfocus").on("click", function () {
                $(this).select();
            });

            $('.autonumeric').autoNumeric('init');
            $('.datepicker-text').datepicker({
                title: "Tanggal",
                todayHighlight: true,
                toggleActive: true,
                clearBtn: true,
                defaultViewDate: true,
                language: 'id',
                enableOnReadonly: true,
                forceParse: true,
                format: 'yyyy-mm-dd',
                startDate: "{{ Date('Y-m-d') }}",
                disableTouchKeyboard: true
            });
        });



        function addData() {
            var produkVal = $("#produkSelector option:selected").val();
            var produkText = $("#produkSelector option:selected").text();
            var jumlahVal = $("#jumlahSelector").autoNumeric('get');
            var jumlahText = $("#jumlahSelector").val();

            if(produkVal > 0 && jumlahVal > 0){
                $("#produkSelector").select2('val', '0');
                $("#jumlahSelector").val(0);

                var idSelector = produkVal;
                var html = '<div id="'+ idSelector +'" class="row b-t b-grey p-t-10 p-b-10">\n' +
                    '    <div class="col-sm-6 col-xs-8">\n' +
                    '        <div class="form-group form-group-default">\n' +
                    '            <label>produk</label>\n' +
                    '            <input class="form-control input-md input-re" readonly type="text" value="'+ produkText +'">\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '    <div class="col-sm-5 col-xs-4 font-montserrat fs-12">\n' +
                    '        <div class="form-group form-group-default">\n' +
                    '            <label>jumlah</label>\n' +
                    '            <input class="form-control input-md input-re" readonly type="text" value="'+ jumlahText +'">\n' +
                    '        </div>\n' +
                    '    </div>\n' +
                    '    <div class="col-sm-1 col-xs-12">\n' +
                    '        <a onClick="deleteData(\''+ idSelector +'\')" class="btn btn-danger btn-xs btn-rounded" type="button"><i class="fa fa-trash"></i></a>\n' +
                    '        <a onClick="editData(\''+ produkVal +'\',\''+ jumlahVal +'\')" class="btn btn-complete btn-xs btn-rounded" type="button"><i class="fa fa-pencil"></i></a>\n' +
                    '    </div>\n' +
                    '</div>';

                var dataArray = JSON.parse($("#valueSelector").val());

                for(var i = 0; i < dataArray.data.length; i++) {
                    if(dataArray.data[i].unique == idSelector) {
                        $('#' + idSelector).remove();
                        dataArray.data.splice(i, 1);
                        break;
                    }
                }

                $('#bodySelector').append(html);

                var dataValue = {"unique": idSelector, "produk": produkVal, "jumlah": jumlahVal};
                    dataArray.data.push(dataValue);


                $("#valueSelector").val(JSON.stringify(dataArray));


                var id = 2;
                for(var i = 0; i < dataValue.length; i++) {
                    if(dataValue.data[i].produk == id) {
                        dataValue.splice(i, 1);
                        break;
                    }
                }

            }else{
                $('#modalAddError').modal('show');
            }


        }

        function deleteData(id) {
            $('#' + id).remove();
            var dataArray = JSON.parse($("#valueSelector").val());
            for(var i = 0; i < dataArray.data.length; i++) {
                if(dataArray.data[i].unique == id) {
                    dataArray.data.splice(i, 1);
                    break;
                }
            }

            $("#valueSelector").val(JSON.stringify(dataArray));

        }

        function editData(produk, jumlah) {
            $('#produkSelector').val(produk).trigger('change');
            $("#jumlahSelector").val(String(jumlah).replace(/(.)(?=(\d{3})+$)/g,'$1,'));

        }

        function addToko() {
            $('#modalAddToko').modal('show');
        }

        function initMax(max, satuan) {
            if(satuan != ""){
                $('#jumlahLabel').html('jumlah (' + satuan + ') max (' + max + ')');
            }else{
                $('#jumlahLabel').html('jumlah');
            }
            $('#jumlahSelector').autoNumeric('destroy');
            $("#jumlahSelector").autoNumeric('init', {
                aSep: '.',
                aDec: ',',
                mDec: 0,
                aForm: true,
                vMax: max,
                vMin: 0
            });

        }

        $('#produkSelector').on('change', function() {
            var x = document.getElementById("produkSelector").value;
            $.ajax({
                type:'GET',
                url:'{{ url("api/v1/admin/produk/stok") }}/' + x,
                contentType: 'application/json; charset=utf-8',
                success:function(json){
                    $.each(json, function(i, value) {
                        if(i === "data") {
                            if(value.jumlah > 0) {
                                initMax(value.jumlah, value.satuan);
                            }else{
                                initMax(9, "");
                            }
                        }

                    });
                },
                error:function (json) {
                    initMax(9, "");
                }
            });
        });

    </script>
@endpush