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
            <table class="table table-bordered table-hover" id="tabel_kode_masalah" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Masalah</th>
                        <th>Masalah</th>
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

<!-- modal kode_masalah -->
<div id="modal_kode_masalah" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="vcenter">Tambah Kode Masalah</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">

                <form id="form_kode_masalah" autocomplete="off">

                <input type="hidden" id="id_kode_masalah" name="id_kode_masalah">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">

                <div class="row d-flex justify-content-center mt-3 mb-3">
                    <div class="col-md-10">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Kode Masalah</label>
                            <div class="col-md-9">
                                <input type="text" id="kode_masalah" name="kode_masalah" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Masalah</label>
                            <div class="col-md-9">
                            <input type="text" class="form-control" id="masalah" name="masalah" placeholder="Masukkan Masalah">
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
                <button type="button" class="btn btn-success" id="simpan_kode_masalah">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>

  $(document).ready(function () {

      // dataTables kode_masalah
      var tabel_kode_masalah = $('#tabel_kode_masalah').DataTable({
          "processing"        : true,
          "serverSide"        : true,
          "order"             : [],
          "ajax"              : {
              "url"   : "<?= base_url("master_kearsipan/tampil_kode_masalah") ?>",
              "type"  : "POST"
          },
          "columnDefs"        : [{
              "targets"   : [0,4],
              "orderable" : false
          }]

      })

      $('#tambah_data').on('click', function () {

          $.ajax({
            url         : "<?= base_url('master_kearsipan/generate_kode_masalah') ?>",
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

                $('#modal_kode_masalah').modal('show');

                $('#form_kode_masalah').trigger("reset");

                $('#kode_masalah').val(data.kode_masalah);

                $('.list-status').attr('hidden', true);

                $('.modal-title').text('Tambah Kode Masalah');
                $('#aksi').val('Tambah');

            }
        })

        return false;
      })

      // aksi simpan kode_masalah
      $('#simpan_kode_masalah').on('click', function () {
          
          var form_kd_masalah = $('#form_kode_masalah').serialize();

          var aksi        = $('#aksi').val();

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
                    url         : "<?= base_url('master_kearsipan/aksi_kode_masalah') ?>",
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
                    data        : form_kd_masalah,
                    dataType    : "JSON",
                    success     : function (data) {

                        tabel_kode_masalah.ajax.reload(null, false);

                            swal({
                                title               : aksi+' Kode Masalah',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 
                        
                        $('#modal_kode_masalah').modal('hide');
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
                        text                : 'Anda membatalkan '+aksi.toLowerCase()+' kode masalah',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 
            }
        })

      })

      // aksi edit kode_masalah
      $('#tabel_kode_masalah').on('click', '.edit-kode-masalah', function () {
           var id_kode_masalah = $(this).data('id');

           console.log(id_kode_masalah);

           $.ajax({
              url : "<?php echo base_url('master_kearsipan/ambil_data_kode_masalah')?>/"+id_kode_masalah,
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

                  $('#id_kode_masalah').val(data.id_kode_masalah);
                  $('#kode_masalah').val(data.kode_masalah);
                  $('#masalah').val(data.masalah);
                  $('#status').select2("val", data.status);

                  $('.list-status').removeAttr('hidden');

                  $('#modal_kode_masalah').modal('show');
                  $('.modal-title').text('Edit Kode Masalah');
                  $('#aksi').val('Edit');
       
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
           })        
      })

      // hapus kode_masalah
      $('#tabel_kode_masalah').on('click', '.hapus-kode-masalah', function () {
          
          var id_kode_masalah = $(this).data('id');

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
                        url         : "<?= base_url('master_kearsipan/aksi_kode_masalah') ?>",
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
                        data        : {aksi:'hapus', id_kode_masalah:id_kode_masalah},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_kode_masalah.ajax.reload(null, false);

                              swal({
                                  title               : 'Hapus Kode Masalah',
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
                          text                : 'Anda membatalkan hapus kode_masalah',
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