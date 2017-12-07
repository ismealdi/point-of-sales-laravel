@extends('admin.layouts.frame')
@section('title', 'Ubah Data Pemilik')
@section('description', 'Mohon lengkapi seluruh informasi data')
@section('button')
    <a href="{{ (Request::get('back') == 'detail') ? url('admin/pemilik/'.$information->id) : url('admin/pemilik') }}" class="btn btn-info btn-xs no-border">Kembali</a>
@endsection

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-danger {{ (count($errors)) ? '' : 'hidden' }}">
                    <div class="panel-body panel-bordered ">
                        <div class="row">
                            <div class="col-xs-12">
                                {!! $errors->first('nama', '<label class="lb-di error">:message</label>') !!}
                                {!! $errors->first('status', '<label class="lb-di error">:message</label>') !!}
                                {!! $errors->first('telepon', '<label class="lb-di error">:message</label>') !!}
                                {!! $errors->first('email', '<label class="lb-di error">:message</label>') !!}
                                {!! $errors->first('password', '<label class="lb-di error">:message</label>') !!}
                                {!! $errors->first('username', '<label class="lb-di error">:message</label>') !!}
                                {!! $errors->first('toko', '<label class="lb-di error">:message</label>') !!}
                                {!! $errors->first('alamat', '<label class="lb-di error">:message</label>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body sm-p-t-15">

                        {!! Form::model($information, [
                          'method' => 'PATCH',
                          'url' => ['/admin/pemilik', $information->id],
                          'files' => true,
                          'id' => 'formValidate',
                          ]) !!}

                        {!! Form::hidden('back', Request::get('back')) !!}

                        <div class="row">

                            <div class="col-xs-6">
                                <div aria-required="true" class="form-group form-group-default required {{ $errors->has('nama') ? 'has-error' : ''}}">
                                    {!! Form::label('nama', "nama") !!}
                                    {!! Form::text('nama', null, ['class' => 'form-control input-md', 'required']) !!}
                                </div>
                                <div aria-required="true" class="form-group form-group-default form-group-default-select2  required {{ $errors->has('status') ? 'has-error' : ''}}">
                                    {!! Form::label('status', "status") !!}
                                    {!! Form::select('status', ["Tidak Aktif", "Aktif"], 1, ['class' => 'full-width', 'data-init-plugin' => 'select2']) !!}
                                </div>
                                <div aria-required="true" class="form-group form-group-default {{ $errors->has('telepon') ? 'has-error' : ''}}">
                                    {!! Form::label('telepon', "telepon") !!}
                                    {!! Form::number('telepon', null, ['class' => 'form-control input-md']) !!}
                                </div>
                                <div aria-required="true" class="form-group form-group-default {{ $errors->has('email') ? 'has-error' : ''}}">
                                    {!! Form::label('email', "email") !!}
                                    {!! Form::email('email', $information->getUser->email, ['class' => 'form-control input-md', 'readonly']) !!}
                                </div>
                                <div aria-required="true" class="form-group form-group-default form-group-default-select2  required {{ $errors->has('toko') ? 'has-error' : ''}}">
                                    {!! Form::label('toko', "toko") !!}
                                    {!! Form::select('toko', $tokos, null, ['class' => 'full-width', 'data-init-plugin' => 'select2']) !!}
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div aria-required="true" class="form-group form-group-default {{ $errors->has('username') ? 'has-error' : ''}}">
                                    {!! Form::label('username', "username") !!}
                                    {!! Form::text('username', $information->getUser->username, ['class' => 'form-control input-md', 'readonly']) !!}
                                </div>
                                <div aria-required="true" class="form-group form-group-default {{ $errors->has('password') ? 'has-error' : ''}}">
                                    {!! Form::label('password', "password") !!}
                                    {!! Form::password('password', ['class' => 'form-control input-md']) !!}
                                </div>
                                <div aria-required="true" class="form-group form-group-default {{ $errors->has('alamat') ? 'has-error' : ''}}">
                                    {!! Form::label('alamat', "alamat") !!}
                                    {!! Form::textarea('alamat', null, ['class' => 'form-control input-md',  'style' => 'min-height: 90px;max-height: 90px;']) !!}
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
//        $('#formValidate').validate();

    });
</script>
@endpush