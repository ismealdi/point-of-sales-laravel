@extends('admin.layouts.frame')
@section('title', 'Informasi Pelanggan')
@section('description', 'Informasi lengkap data terpilih')
@section('button')
    <a href="{{ url('/admin/pelanggan') }}" class="btn btn-info btn-xs no-border">Kembali</a>
@endsection

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading p-b-15">
                        <div class="panel-title">
                            {!! Form::open(['url' => 'admin/pelanggan', 'method' => 'get', 'class' => 'form-inline']) !!}
                            Tanggal Dibuat: {!! $pelanggan->formatedDate($pelanggan->created_at) !!}<br/>
                            {!! Form::close() !!}
                        </div>
                        <a href="{{ url('admin/pelanggan/'.$pelanggan->id.'/edit?back=detail') }}" class="btn btn-complete btn-rounded btn-xs  pull-right" type="button" style="height:28px;margin-top: 0px;"><i class="fa fa-pencil"></i></a>
                        <a onClick="deleteData({{ $pelanggan->id }}, 'Pelanggan')" class="btn btn-danger btn-rounded btn-xs pull-right" type="button" style="height:28px;margin-right:4px;margin-top: 0px;"><i class="fa fa-trash"></i></a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body b-t b-grey no-padding" style="background: #FFF;">
                        <div class="widget-11-2-table">
                            <table class="table table-hover table-t-b-0">
                                <tbody>
                                <tr>
                                    <td class="text-left b-r b-dashed b-grey">Nama</td>
                                    <td class="font-montserrat fs-12" width="85%">{{ $pelanggan->nama }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left b-r b-dashed b-grey">Telepon</td>
                                    <td class="font-montserrat fs-12" width="85%">{{ $pelanggan->telepon }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left b-r b-dashed b-grey">Toko</td>
                                    <td class="font-montserrat fs-12" width="85%">{{ $pelanggan->getToko() }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left b-r b-dashed b-grey">Alamat</td>
                                    <td class="font-montserrat fs-12" width="85%">{{ $pelanggan->alamat }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left b-r b-dashed b-grey">Email</td>
                                    <td class="font-montserrat fs-12" width="85%">{{ $pelanggan->email }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="deleteID" />
    <input type="hidden" id="deleteSD" />
@endsection


@push("script")
    <script>
        function deleteData(id, pelanggan) {
            $('#modalDelete').modal('show');
            $('#deleteID').val(id);
            $('#deleteSD').val(pelanggan);
        }

        function hapus(){
            $('#modalDelete').modal('hide');
            var id = $('#deleteID').val();
            var sd = $('#deleteSD').val();
            $.ajax({
                url: '{{url("admin/pelanggan")}}' + "/" + id + '?' + $.param({"cont": sd, "_token" : '{{ csrf_token() }}' }),
                type: 'DELETE',
                complete: function(data) {
                    window.location.assign("{{url('admin/pelanggan')}}");
                }
            });
        }
    </script>
@endpush