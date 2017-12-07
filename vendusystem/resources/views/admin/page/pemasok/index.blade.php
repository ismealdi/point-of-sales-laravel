@extends('admin.layouts.frame')
@section('title', 'Pemasok')
@section('description')
    Masukan daftar pemasok
@endsection


@section('content')
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading p-b-15">
                        <div class="panel-title">
                            {!! Form::open(['url' => 'admin/pemasok', 'method' => 'get', 'class' => 'form-inline']) !!}
                            {!! Form::text('search', null, ['class' => 'form-control input-md  b-rad-md search-text', "placeholder" => "Pencarian"]) !!}
                            <button class="btn btn-success pull-right btn-rounded btn-xs" type="submit" style="width:28px;height:28px;margin-right:4px;margin-left:-15px;margin-top: 3px;"><i class="fa fa-search" style="width:8px;"></i></button>
                            {!! Form::close() !!}
                        </div>
                        <a href="{{ url('admin/pemasok/create') }}" class="btn btn-complete pull-right btn-rounded btn-xs" type="button" style="width:28px;height:28px;margin-right:4px;margin-top: 3px"><i class="fa fa-plus" style="width:8px;"></i></a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body b-t b-grey no-padding" style="background: #FFF;">
                        <div class="widget-11-2-table">
                            <table class="table table-hover table-t-b-0">
                                <tbody>
                                <tr>
                                    <td style="min-width: 20px;">No</td>
                                    <td width="45%">Nama, <small>Pemasok Toko</small></td>
                                    <td>Alamat</td>
                                    <td>Telepon</td>
                                    <td>Email</td>
                                    <td>Tipe</td>
                                    <td style="min-width: 150px;">Action</td>
                                </tr>
                                @if(count($pemasoks) == 0)
                                <tr class="no-data-empty">
                                    <td colspan="7">Data Kosong</td>
                                </tr>
                                @endif
                                @foreach($pemasoks as $pemasok)
                                <tr id="Pemasok{{ $pemasok->id }}">
                                    <td>{{ $no++ }}.</td>
                                    <td class="font-montserrat fs-12">
                                        <a href="{{ url('admin/pemasok/'.$pemasok->id) }}">{{ $pemasok->nama }}</a>, <small>{{ $pemasok->getToko() }}</small>
                                    </td>
                                    <td class="font-montserrat fs-12">
                                        <span class="hint-text small">{{ $pemasok->alamat }}</span><br/>
                                    </td>
                                    <td class="font-montserrat fs-12">
                                        <span class="hint-text small">{{ $pemasok->telepon }}</span><br/>
                                    </td>
                                    <td class="text-left b-r b-dashed b-grey" >
                                        <span class="hint-text small">{{ $pemasok->email }}</span><br/>
                                    </td>
                                    <td class="text-left b-r b-dashed b-grey" >
                                        <span class="hint-text small">{{ $pemasok->getTipe->nama }}</span><br/>
                                    </td>
                                    <td class="font-montserrat fs-12">
                                        <a onClick="deleteData({{ $pemasok->id }}, 'Pemasok')" class="btn btn-danger b-rad-md btn-xs" type="button" style="height:28px;margin-right:4px;margin-top: -5px;">Hapus</a>
                                        <a href="{{ url('admin/pemasok/'.$pemasok->id.'/edit') }}" class="btn btn-complete b-rad-md btn-xs" type="button" style="height:28px;margin-top: -5px;">Ubah</a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <div class="panel-footer no-border p-t-0 p-b-0" style="background: #FFF;color: #101010;font-size: 13px;font-weight: 300">
                        {{ $pemasoks->appends($appends)->links()  }}
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
    function deleteData(id, pemasok) {
        $('#modalDelete').modal('show');
        $('#deleteID').val(id);
        $('#deleteSD').val(pemasok);
    }

    function hapus(){
        $('#modalDelete').modal('hide');
        var id = $('#deleteID').val();
        var sd = $('#deleteSD').val();
        $.ajax({
            url: '{{url("admin/pemasok")}}' + "/" + id + '?' + $.param({"cont": sd, "_token" : '{{ csrf_token() }}' }),
            type: 'DELETE',
            complete: function(data) {
                $('#'+sd+ id).remove();
            }
        });
    }
</script>
@endpush
