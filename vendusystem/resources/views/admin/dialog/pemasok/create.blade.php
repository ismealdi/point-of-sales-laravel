<div class="modal fade stick-up" data-backdrop="static" data-keyboard="false" id="modalAddPemasok" tabindex="-1" role="dialog" aria-labelledby="modalAddPemasok" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header clearfix text-left b-b b-grey p-b-10">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="pg-close fs-18"></i>
                </button>
                <div class="panel-title bold text-uppercase fs-12">Tambah Pemasok</div>
                <p class="fs-12">Mohon lengkapi seluruh informasi data</p>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => 'admin/pemasok', 'id' => 'savePemasok', 'files' => true]) !!}
                    <div class="form-group-attached">
                        <div class="row">
                            <div class="col-xs-6">
                                <div aria-required="true" class="form-group form-group-default required {{ $errors->has('nama') ? 'has-error' : ''}}">
                                    {!! Form::label('nama', "nama") !!}
                                    {!! Form::text('nama', null, ['class' => 'form-control input-md', 'required']) !!}
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div aria-required="true" class="form-group form-group-default form-group-default-select2 {{ $errors->has('tipe') ? 'has-error' : ''}} input-group">
                                    {!! Form::label('tipe', "tipe", ["class" => 'label-top-0']) !!}
                                    {!! Form::select('tipe', $tipepemasoks, null, ['class' => 'full-width', 'data-init-plugin' => 'select2', 'style' => 'z-index: 50000 !important', 'id' => 'tipePemasok']) !!}
                                    <div class="input-group-addon no-padding">
                                        <a class="btn btn-default btn-group p-t-15" onclick="addTipePemasok()"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <div aria-required="true" class="form-group form-group-default {{ $errors->has('telepon') ? 'has-error' : ''}}">
                                    {!! Form::label('telepon', "telepon") !!}
                                    {!! Form::number('telepon', null, ['class' => 'form-control input-md']) !!}
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div aria-required="true" class="form-group form-group-default {{ $errors->has('email') ? 'has-error' : ''}}">
                                    {!! Form::label('email', "email") !!}
                                    {!! Form::email('email', null, ['class' => 'form-control input-md']) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="pull-left m-t-20 m-b-10">
                                <div class="checkbox check-success">
                                    <input id="checkbox-agreee" type="checkbox" required> <label for="checkbox-agreee"><small>Saya sudah mengecek data sebelum menyimpan</small></label>
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


<div class="modal fade stick-up" id="modalFailedPemasok" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm alert-warning">
        <div class="modal-content">
            <div class="modal-header p-b-25">
                <h5>Data Tidak <span class="semi-bold">Tersimpan!</span></h5>
            </div>
        </div>
    </div>
</div>

@include("admin.dialog.tipe-pemasok.create")

@push('script')
    <script>
        $("#savePemasok").submit(function(e) {
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
                    $("#tipePemasok").select2('val', '0');
                    $("#savePemasok").trigger('reset');
                    $('#modalAddPemasok').modal('hide');
                    loadPemasok();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#modalAddPemasok').modal('hide');
                    $('#modalFailedPemasok').modal('show');
                }
            });

            e.preventDefault();
        });

        $('#modalFailedPemasok').on('hidden.bs.modal', function () {
            $('#modalAddPemasok').modal('show');
        });

        function loadPemasok() {
            $.ajax({
                type:'GET',
                url:'{{ url("api/v1/admin/pemasok") }}',
                contentType: 'application/json; charset=utf-8',
                success:function(json){
                    $.each(json, function(i, value) {
                        if(i === "data") {
                            $('#pemasok').html("");
                            $('#pemasok').append($('<option>').text("Pilih Pemasok").attr('value', 0));
                            $.each(value, function(ind, valu) {
                                $('#pemasok').append($('<option>').text(valu.nama).attr('value', valu.id));
                            });

                            $("#pemasok").select2('val', '0');
                        }else if(i === "last") {
                            $.each(value, function(ind, valu) {
                                if(ind === "id") {
                                    $('#pemasok').val(valu).trigger('change');
                                }
                            });
                        }

                    });
                }
            });
        }

        function addTipePemasok() {
            $('#modalAddPemasok').modal('hide');
            $('#modalAddTipePemasok').modal('show');
        }
    </script>
@endpush