@extends('admin.layouts.frame')
@section('title', 'Tipe Pelanggan')
@section('description')
    Masukan daftar tipe pelanggan
@endsection


@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading p-b-15">
                        <div class="panel-title">
                            {!! Form::open(['url' => 'admin/tipepelanggan', 'method' => 'get', 'class' => 'form-inline']) !!}
                            {!! Form::text('search', null, ['class' => 'form-control input-md  b-rad-md search-text', "placeholder" => "Pencarian"]) !!}
                            <button class="btn btn-success pull-right btn-rounded btn-xs" type="submit" style="width:28px;height:28px;margin-right:4px;margin-left:-15px;margin-top: 3px;"><i class="fa fa-search" style="width:8px;"></i></button>
                            {!! Form::close() !!}
                        </div>
                        <a href="{{ url('admin/tipe-pelanggan/create') }}" class="btn btn-complete pull-right btn-rounded btn-xs" type="button" style="width:28px;height:28px;margin-right:4px;margin-top: 3px"><i class="fa fa-plus" style="width:8px;"></i></a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body b-t b-grey no-padding" style="background: #FFF;">
                        <div class="widget-11-2-table">
                            <table class="table table-hover table-t-b-0">
                                <tbody>
                                <tr>
                                    <td style="min-width: 20px;">No</td>
                                    <td width="45%">Nama</td>
                                    <td width="20%">Toko</td>
                                    <td style="min-width: 80px;">Dibuat</td>
                                    <td style="min-width: 80px;">Diperbarui</td>
                                    <td style="min-width: 150px;">Action</td>
                                </tr>
                                @if(count($tipepelanggans) == 0)
                                <tr class="no-data-empty">
                                    <td colspan="6">Data Kosong</td>
                                </tr>
                                @endif
                                @foreach($tipepelanggans as $tipepelanggan)
                                <tr id="TipePelanggan{{ $tipepelanggan->id }}">
                                    <td>{{ $no++ }}.</td>
                                    <td class="font-montserrat fs-12">
                                        {{ $tipepelanggan->nama }}</small>
                                    </td>
                                    <td class="text-left b-r b-dashed b-grey">
                                        <span class="hint-text">{{ $tipepelanggan->getToko() }}</span><br/>
                                    </td>
                                    <td class="b-r b-dashed b-grey"><span class="font-montserrat fs-10">{!! $tipepelanggan->formatedDate($tipepelanggan->created_at) !!}</span></td>
                                    <td class="b-r b-dashed b-grey"><span class="font-montserrat fs-10">{!! $tipepelanggan->formatedDate($tipepelanggan->updated_at) !!}</span></td>
                                    <td class="font-montserrat fs-12">
                                        <a onClick="deleteData({{ $tipepelanggan->id }}, 'TipePelanggan')" class="btn btn-danger b-rad-md btn-xs" type="button" style="height:28px;margin-right:4px;margin-top: -5px;">Hapus</a>
                                        <a href="{{ url('admin/tipe-pelanggan/'.$tipepelanggan->id.'/edit') }}" class="btn btn-complete b-rad-md btn-xs" type="button" style="height:28px;margin-top: -5px;">Ubah</a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="panel-footer no-border p-t-0 p-b-0" style="background: #FFF;color: #101010;font-size: 13px;font-weight: 300">
                        {{ $tipepelanggans->appends($appends)->links()  }}
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
    function deleteData(id, tipepelanggan) {
        $('#modalDelete').modal('show');
        $('#deleteID').val(id);
        $('#deleteSD').val(tipepelanggan);
    }

    function hapus(){
        $('#modalDelete').modal('hide');
        var id = $('#deleteID').val();
        var sd = $('#deleteSD').val();
        $.ajax({
            url: '{{url("admin/tipe-pelanggan")}}' + "/" + id + '?' + $.param({"cont": sd, "_token" : '{{ csrf_token() }}' }),
            type: 'DELETE',
            complete: function(data) {
                $('#'+sd+ id).remove();
            }
        });
    }
</script>
@endpush
