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
            <table class="table table-bordered table-hover" id="tabel_sarana_penyimpanan" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Sarana Penyimpanan</th>
                        <th>Sarana Penyimpanan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal sarana_penyimpanan -->
<div id="modal_sarana_penyimpanan" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="vcenter">Tambah Sarana Penyimpanan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">

                <form id="form_sarana_penyimpanan" autocomplete="off">

                <input type="hidden" id="id_sarana_penyimpanan" name="id_sarana_penyimpanan">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">

                <div class="row d-flex justify-content-center mt-3 mb-3">
                    <div class="col-md-10">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Kode Sarana Penyimpanan</label>
                            <div class="col-md-9">
                                <input type="text" id="kode_sarana_penyimpanan" name="kode_sarana_penyimpanan" class="form-control" value="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Nama Sarana Penyimpanan</label>
                            <div class="col-md-9">
                            <input type="text" class="form-control" id="sarana_penyimpanan" name="sarana_penyimpanan" placeholder="Masukkan Sarana Penyimpanan">
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
                <button type="button" class="btn btn-success" id="simpan_sarana_penyimpanan">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>

  $(document).ready(function () {

      // dataTables sarana_penyimpanan
      var tabel_sarana_penyimpanan = $('#tabel_sarana_penyimpanan').DataTable({
          "processing"        : true,
          "serverSide"        : true,
          "order"             : [],
          "ajax"              : {
              "url"   : "<?= base_url("Master_kearsipan/tampil_sarana_penyimpanan") ?>",
              "type"  : "POST"
          },
          "columnDefs"        : [{
              "targets"   : [0,4],
              "orderable" : false
          }]

      })

      $('#tambah_data').on('click', function () {

          $.ajax({
            url         : "<?= base_url('Master_kearsipan/tampil_kode_sarana_p') ?>",
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

                $('#modal_sarana_penyimpanan').modal('show');

                $('#form_sarana_penyimpanan').trigger("reset");

                $('.modal-title').text('Tambah Sarana Penyimpanan');
                $('#aksi').val('Tambah');

                $('#kode_sarana_penyimpanan').val(data.kode_sarana_penyimpanan)

                $('.list-status').attr('hidden', true);

            }
        })

        return false;
      })

      // aksi simpan sarana_penyimpanan
      $('#simpan_sarana_penyimpanan').on('click', function () {
          
            var form_sarana_penyimpanan = $('#form_sarana_penyimpanan').serialize();

            var aksi            = $('#aksi').val();


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
                        url         : "<?= base_url('Master_kearsipan/aksi_sarana_penyimpanan') ?>",
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
                        data        : form_sarana_penyimpanan,
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_sarana_penyimpanan.ajax.reload(null, false);

                              swal({
                                  title               : aksi+' Sarana Penyimpanan',
                                  text                : 'Data Berhasil Disimpan',
                                  buttonsStyling      : false,
                                  confirmButtonClass  : "btn btn-success",
                                  type                : 'success',
                                  showConfirmButton   : false,
                                  timer               : 1000
                              }); 
                            
                            $('#modal_sarana_penyimpanan').modal('hide');
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
                          text                : 'Anda membatalkan '+aksi.toLowerCase()+' sarana_penyimpanan',
                          buttonsStyling      : false,
                          confirmButtonClass  : "btn btn-info",
                          type                : 'error',
                            showConfirmButton   : false,
                            timer               : 1000
                      }); 
                }
            })

      })

      // aksi edit sarana_penyimpanan
      $('#tabel_sarana_penyimpanan').on('click', '.edit-sarana_penyimpanan', function () {
           var id_sarana_penyimpanan = $(this).data('id');

           console.log(id_sarana_penyimpanan);

           $.ajax({
              url : "<?php echo base_url('Master_kearsipan/ambil_data_sarana_penyimpanan')?>/"+id_sarana_penyimpanan,
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

                  $('#id_sarana_penyimpanan').val(data.id_sarana_penyimpanan);
                  $('#kode_sarana_penyimpanan').val(data.kode_sarana_penyimpanan);
                  $('#sarana_penyimpanan').val(data.sarana_penyimpanan);
                  $('#status').select2("val", data.status);

                  $('#modal_sarana_penyimpanan').modal('show');
                  $('.modal-title').text('Edit Sarana Penyimpanan');
                  $('#aksi').val('Edit');

                  $('.list-status').removeAttr('hidden');
       
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
           })        
      })

      // hapus sarana_penyimpanan
      $('#tabel_sarana_penyimpanan').on('click', '.hapus-sarana_penyimpanan', function () {
          
          var id_sarana_penyimpanan = $(this).data('id');

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
                        url         : "<?= base_url('Master_kearsipan/aksi_sarana_penyimpanan') ?>",
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
                        data        : {aksi:'hapus', id_sarana_penyimpanan:id_sarana_penyimpanan},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_sarana_penyimpanan.ajax.reload(null, false);

                              swal({
                                  title               : 'Hapus Sarana Penyimpanan',
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
                          text                : 'Anda membatalkan hapus sarana_penyimpanan',
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