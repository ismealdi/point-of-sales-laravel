<div class="modal fade stick-up" data-backdrop="static" data-keyboard="false" id="modalAddSatuan" tabindex="-1" role="dialog" aria-labelledby="modalAddSatuan" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix text-left b-b b-grey p-b-10">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" data-content="close">
                    <i class="pg-close fs-18"></i>
                </button>
                <div class="panel-title bold text-uppercase fs-12">Tambah Satuan</div>
                <p class="fs-12">Mohon lengkapi seluruh informasi data</p>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => 'admin/satuan', 'id' => 'saveSatuan', 'files' => true]) !!}
                    <div class="form-group-attached">
                        <div class="row">
                            <div class="col-xs-12">
                                <div aria-required="true" class="form-group form-group-default required {{ $errors->has('nama') ? 'has-error' : ''}}">
                                    {!! Form::label('nama', "nama") !!}
                                    {!! Form::text('nama', null, ['class' => 'form-control input-md', 'required']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="pull-left m-t-20 m-b-10">
                                <div class="checkbox check-success">
                                    <input id="checkbox-agree-tipepemasok" type="checkbox" required> <label for="checkbox-agree-tipepemasok"><small>Saya sudah mengecek data sebelum menyimpan</small></label>
                                </div>
                            </div>

                            <br/>

                            <button class="btn btn-default btn-rounded btn-sm p-l-30 p-r-30 m-r-10" type="reset">BERSIHKAN</button>
                            {!! Form::submit('SIMPAN', ['type' => 'submit', 'class' => 'btn btn-success btn-rounded btn-sm p-l-30 p-r-30']) !!}
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade stick-up" id="modalFailedSatuan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm alert-warning">
        <div class="modal-content">
            <div class="modal-header p-b-25">
                <h5>Data Tidak <span class="semi-bold">Tersimpan!</span></h5>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        $("#saveSatuan").submit(function(e) {
            var formURL = $(this).attr("action");
            var formData = new FormData(this);

            $.ajax({
                url: formURL,
                type: 'POST',
                data:  formData,
                mimeType:"multipart/form-data",
                contentType: false,
                cache: false,
                processData:false,
                success: function(data, textStatus, jqXHR) {
                    $("#saveSatuan").trigger('reset');
                    $('#modalAddSatuan').modal('hide');
                    loadSatuan();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#modalAddSatuan').modal('hide');
                    $('#modalFailedSatuan').modal('show');
                }
            });

            e.preventDefault();
        });

        $('#modalFailedSatuan').on('hidden.bs.modal', function () {
            $('#modalAddSatuan').modal('show');
        });

        function loadSatuan() {
            $.ajax({
                type:'GET',
                url:'{{ url("api/v1/admin/satuan") }}',
                contentType: 'application/json; charset=utf-8',
                success:function(json){
                    $.each(json, function(i, value) {
                        if(i === "data") {
                            $('#satuanSelector').html("");
                            $('#satuanSelector').append($('<option>').text("Pilih Satuan").attr('value', 0));
                            $.each(value, function(ind, valu) {
                                $('#satuanSelector').append($('<option>').text(valu.nama).attr('value', valu.id));
                            });

                            $("#satuanSelector").select2('val', '0');
                        }else if(i === "last") {
                            $.each(value, function(ind, valu) {
                                if(ind === "id") {
                                    $('#satuanSelector').val(valu).trigger('change');
                                }
                            });
                        }

                    });
                }
            });
        }
    </script>
@endpush