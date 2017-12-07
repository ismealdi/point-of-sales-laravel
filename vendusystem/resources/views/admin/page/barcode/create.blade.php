@extends('admin.layouts.frame')
@section('title', 'Tambah Barcode')
@section('description', 'Mohon lengkapi seluruh informasi data')
@section('button')
    <a href="{{ url('/admin/barcode') }}" class="btn btn-info btn-xs no-border">Kembali</a>
@endsection

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-danger {{ (count($errors)) ? '' : 'hidden' }}">
                    <div class="panel-body panel-bordered ">
                        <div class="row">
                            <div class="col-xs-12">
                                {!! $errors->first('barcode', '<label class="lb-di error">:message</label>') !!}
                                {!! $errors->first('produk', '<label class="lb-di error">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body sm-p-t-15">
                        {!! Form::open(['url' => 'admin/barcode', 'id' => 'formValidate', 'files' => true]) !!}

                        <div class="row">
                            <div class="col-xs-6">
                                <div aria-required="true" class="form-group form-group-default required {{ $errors->has('barcode') ? 'has-error' : ''}}">
                                    {!! Form::label('barcode', "barcode") !!}
                                    {!! Form::text('barcode', null, ['class' => 'form-control input-md', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div aria-required="true" class="form-group form-group-default form-group-default-select2  required {{ $errors->has('produk') ? 'has-error' : ''}}">
                                    {!! Form::label('produk', "produk") !!}
                                    {!! Form::select('produk', $produk, null, ['class' => 'full-width', 'data-init-plugin' => 'select2']) !!}
                                </div>
                            </div>
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


                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {


        });
    </script>
@endpush