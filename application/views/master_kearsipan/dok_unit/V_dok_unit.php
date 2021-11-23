<ol class="breadcrumb bg-transparent mt-4">
    <?php $i=0; foreach ($breadcrumb as $bc): ?>
    <li class="breadcrumb-item active"><?= $bclink[$i] ?><?=  $bc ?></a></li>
    <?php $i++; endforeach ?>
</ol>

<div class="card mb-4 shadow" id="kartu">
    <div class="card-header">
        <button class="btn btn-primary" id="tambah_data" type="button" data-toggle="modal" data-target="#staticBackdrop"><i class="fas fa-plus mr-1"></i>Tambah Data</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tabel_dokumen_unit" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Dokumen Unit</th>
                        <th>Dokumen Unit</th>
                        <th>Status</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal dokumen_unit -->
<div id="modal_dokumen_unit" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="vcenter">Tambah Dokumen Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">

                <form id="form_dokumen_unit" autocomplete="off">

                <input type="hidden" id="id_dokumen_unit" name="id_dokumen_unit">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">

                <div class="row d-flex justify-content-center mt-3 mb-3">
                    <div class="col-md-10">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Kode Dokumen Unit</label>
                            <div class="col-md-9">
                                <input type="text" id="kode_dokumen_unit" name="kode_dokumen_unit" class="form-control" value="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Dokumen Unit</label>
                            <div class="col-md-9">
                            <input type="text" class="form-control" id="dokumen_unit" name="dokumen_unit" placeholder="Masukkan Dokumen Unit">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3 list-status" hidden>
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Status</label>
                            <div class="col-md-9">

                                <select name="status" id="status" placeholder="Pilih Status" data-allow-clear="1">
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                                
                            </div>
                        </div>
                    </div>
                </div>

                </form>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="simpan_dokumen_unit">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>

  $(document).ready(function () {

      // dataTables dokumen_unit
      var tabel_dokumen_unit = $('#tabel_dokumen_unit').DataTable({
          "processing"        : true,
          "serverSide"        : true,
          "order"             : [],
          "ajax"              : {
              "url"   : "<?= base_url("Master_kearsipan/tampil_dokumen_unit") ?>",
              "type"  : "POST"
          },
          "columnDefs"        : [{
              "targets"   : [0,4],
              "orderable" : false
          }]

      })

      $('#tambah_data').on('click', function () {

          $.ajax({
            url         : "<?= base_url('Master_kearsipan/tampil_kode_dokumen_unit') ?>",
            beforeSend  : function () {
                swal({
                    title   : 'Menunggu',
                    html    : 'Memproses Data',
                    onOpen  : () => {
                        swal.showLoading();
                    }
                })
            },
            dataType    : "JSON",
            success     : function (data) {
                swal.close();

                $('#modal_dokumen_unit').modal('show');

                $('#form_dokumen_unit').trigger("reset");

                $('#kode_dokumen_unit').val(data.kode_dokumen_unit)

                $('.modal-title').text('Tambah Dokumen Unit');
                $('#aksi').val('Tambah');

                $('.list-status').attr('hidden', true);

            }
        })

        return false;
      })

      // aksi simpan dokumen_unit
      $('#simpan_dokumen_unit').on('click', function () {
          
          var form_dokumen_unit = $('#form_dokumen_unit').serialize();
          var aksi              = $('#aksi').val();

            swal({
            title       : 'Konfirmasi',
            text        : 'Yakin akan kirim data',
            type        : 'warning',

            buttonsStyling      : false,
            confirmButtonClass  : "btn btn-info",
            cancelButtonClass   : "btn btn-danger mr-3",

            showCancelButton    : true,
            confirmButtonText   : 'Kirim Data',
            confirmButtonColor  : '#d33',
            cancelButtonColor   : '#3085d6',
            cancelButtonText    : 'Batal',
            reverseButtons      : true
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url         : "<?= base_url('Master_kearsipan/aksi_dokumen_unit') ?>",
                    method      : "POST",
                    beforeSend  : function () {
                        swal({
                            title   : 'Menunggu',
                            html    : 'Memproses Data',
                            onOpen  : () => {
                                swal.showLoading();
                            }
                        })
                    },
                    data        : form_dokumen_unit,
                    dataType    : "JSON",
                    success     : function (data) {

                        tabel_dokumen_unit.ajax.reload(null, false);

                            swal({
                                title               : aksi+' Dokumen Unit',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                  showConfirmButton   : false,
                                  timer               : 1000
                            }); 
                        
                        $('#modal_dokumen_unit').modal('hide');
                    },
                    error       : function(xhr, status, error) {
                        var err = eval("(" + xhr.responseText + ")");
                        alert(err.Message);
                    }

                })

                return false;
            } else if (result.dismiss === swal.DismissReason.cancel) {

                swal({
                        title               : 'Batal',
                        text                : 'Anda membatalkan '+aksi.toLowerCase()+' dokumen unit',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error',
                                  showConfirmButton   : false,
                                  timer               : 1000
                    }); 
            }
        })

      })

      // aksi edit dokumen_unit
      $('#tabel_dokumen_unit').on('click', '.edit-dokumen-unit', function () {
           var id_dokumen_unit = $(this).data('id');

           console.log(id_dokumen_unit);

           $.ajax({
              url : "<?php echo base_url('Master_kearsipan/ambil_data_dokumen_unit')?>/"+id_dokumen_unit,
              type: "GET",
              beforeSend  : function () {
                swal({
                    title   : 'Menunggu',
                    html    : 'Memproses Data',
                    onOpen  : () => {
                        swal.showLoading();
                    }
                })
              },
              dataType: "JSON",
              success: function(data)
              {
                  swal.close();

                  console.log(data);

                  $('#id_dokumen_unit').val(data.id_dokumen_unit);
                  $('#kode_dokumen_unit').val(data.kode_dokumen_unit);
                  $('#dokumen_unit').val(data.dokumen_unit);
                  $('#status').select2("val", data.status);

                  $('#modal_dokumen_unit').modal('show');
                  $('.modal-title').text('Edit Dokumen Unit');
                  $('#aksi').val('Edit');

                  $('.list-status').removeAttr('hidden');
       
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
           })        
      })

      // hapus dokumen_unit
      $('#tabel_dokumen_unit').on('click', '.hapus-dokumen-unit', function () {
          
          var id_dokumen_unit = $(this).data('id');

          swal({
                title       : 'Konfirmasi',
                text        : 'Yakin akan hapus data',
                type        : 'warning',

                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-info",
                cancelButtonClass   : "btn btn-danger mr-3",

                showCancelButton    : true,
                confirmButtonText   : 'Kirim Data',
                confirmButtonColor  : '#d33',
                cancelButtonColor   : '#3085d6',
                cancelButtonText    : 'Batal',
                reverseButtons      : true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url         : "<?= base_url('Master_kearsipan/aksi_dokumen_unit') ?>",
                        method      : "POST",
                        beforeSend  : function () {
                            swal({
                                title   : 'Menunggu',
                                html    : 'Memproses Data',
                                onOpen  : () => {
                                    swal.showLoading();
                                }
                            })
                        },
                        data        : {aksi:'hapus', id_dokumen_unit:id_dokumen_unit},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_dokumen_unit.ajax.reload(null, false);

                              swal({
                                  title               : 'Hapus Dokumen Unit',
                                  text                : 'Data Berhasil Dihapus',
                                  buttonsStyling      : false,
                                  confirmButtonClass  : "btn btn-success",
                                  type                : 'success',
                                  showConfirmButton   : false,
                                  timer               : 1000
                              }); 
                            
                        },
                        error       : function(xhr, status, error) {
                            var err = eval("(" + xhr.responseText + ")");
                            alert(err.Message);
                        }

                    })

                    return false;
                } else if (result.dismiss === swal.DismissReason.cancel) {

                    swal({
                          title               : 'Batal',
                          text                : 'Anda membatalkan hapus dokumen unit',
                          buttonsStyling      : false,
                          confirmButtonClass  : "btn btn-info",
                          type                : 'error',
                          showConfirmButton   : false,
                          timer               : 1000
                      }); 
                }
            })

      })
      
  })

</script>