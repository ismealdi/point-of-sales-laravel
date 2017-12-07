@extends('admin.layouts.frame')
@section('title', 'Informasi Stok Retur')
@section('description', 'Informasi lengkap data terpilih')
@section('button')
    <a href="{{ url('/admin/retur') }}" class="btn btn-info btn-xs no-border">Kembali</a>
@endsection

@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default  m-b-50">
                    <div class="panel-heading p-b-15">
                        <div class="panel-title">
                            {!! Form::open(['url' => 'admin/retur', 'method' => 'get', 'class' => 'form-inline']) !!}
                            Tanggal Dibuat: {!! $information->formatedDate($information->created_at) !!}<br/>
                            {!! Form::close() !!}
                        </div>
                        <a onClick="deleteData({{ $information->id }}, 'Stok Retur')" class="btn btn-danger btn-rounded btn-xs pull-right" type="button" style="height:28px;margin-right:4px;margin-top: 0px;"><i class="fa fa-trash"></i></a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body b-t b-grey no-padding" style="background: #FFF;">
                        <div class="widget-11-2-table">
                            <table class="table table-hover table-t-b-0">
                                <tbody>
                                <tr>
                                    <td class="text-left b-r b-dashed b-grey">Pemasok</td>
                                    <td class="font-montserrat fs-12" width="85%">{{ $information->getNamaPemasok() }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left b-r b-dashed b-grey">Alamat Pemasok</td>
                                    <td class="font-montserrat fs-12" width="85%">{{ $information->getPemasok->alamat }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left b-r b-dashed b-grey">Jumlah Produk</td>
                                    <td class="font-montserrat fs-12" width="85%">{{ number_format($information->getDaftar->sum('jumlah')) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left b-r b-dashed b-grey">Total Pembelian</td>
                                    <td class="font-montserrat fs-12" width="85%">{{ "Rp".number_format($information->getDaftar->sum('total')) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="panel-heading p-b-15">
                        <div class="panel-title">
                            Rincian Daftar Produk Retur
                        </div>
                    </div>
                    <div class="panel-body b-t b-grey no-padding" style="background: #FFF;">
                        <div class="widget-11-2-table">
                            <table class="table table-hover table-t-b-0">
                                <tbody>
                                <tr class="no-hover">
                                    <td style="min-width: 20px;">No</td>
                                    <td width="25%">Nama</td>
                                    <td width="15%">Satuan</td>
                                    <td style="min-width: 80px;">Harga Satuan</td>
                                    <td width="20%">Jumlah</td>
                                    <td style="min-width: 80px;">Total</td>
                                </tr>
                                @if(count($information->getDaftar) == 0)
                                    <tr class="no-data-empty">
                                        <td colspan="7">Data Kosong</td>
                                    </tr>
                                @endif
                                @foreach($information->getDaftar as $info)
                                    <tr id="Barcode{{ $info->id }}">
                                        <td>{{ $no++ }}.</td>
                                        <td class="text-left b-r b-dashed b-grey">
                                            <span class="hint-text">{{ $info->getProduk->nama }}</span><br/>
                                        </td>
                                        <td class="text-left b-r b-dashed b-grey">
                                            <span class="hint-text">{{ $info->getSatuan->nama }}</span><br/>
                                        </td>
                                        <td class="b-r b-dashed b-grey"><span class="font-montserrat fs-10">{{ "Rp".number_format($info->harga) }}</span></td>
                                        <td class="b-r b-dashed b-grey"><span class="font-montserrat fs-10">{{ number_format($info->jumlah) }}</span></td>
                                        <td class="b-r b-dashed b-grey"><span class="font-montserrat fs-10">{{ "Rp".number_format($info->total) }}</span></td>
                                    </tr>
                                @endforeach


                                <tr class="no-hover">
                                    <td class="b-r b-dashed b-grey" colspan="3"></td>
                                    <td class="b-r b-dashed b-grey bold">{{ "Rp".number_format($information->getDaftar->sum('harga')) }}</td>
                                    <td class="b-r b-dashed b-grey bold">{{ number_format($information->getDaftar->sum('jumlah')) }}</td>
                                    <td class="b-r b-dashed b-grey bold">{{ "Rp".number_format($information->getDaftar->sum('total')) }}</td>
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
        function deleteData(id, stokretur) {
            $('#modalDelete').modal('show');
            $('#deleteID').val(id);
            $('#deleteSD').val(stokretur);
        }

        function hapus(){
            $('#modalDelete').modal('hide');
            var id = $('#deleteID').val();
            var sd = $('#deleteSD').val();
            $.ajax({
                url: '{{url("admin/retur")}}' + "/" + id + '?' + $.param({"cont": sd, "_token" : '{{ csrf_token() }}' }),
                type: 'DELETE',
                complete: function(data) {
                    window.location.assign("{{url('admin/retur')}}");
                }
            });
        }
    </script>
@endpush