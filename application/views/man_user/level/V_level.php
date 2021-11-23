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
            <table class="table table-bordered table-hover" id="tabel_level" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th  width="10%">No</th>
                        <th>Kode Level</th>
                        <th>Level</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

    <!-- modal level -->
    <div id="modal_level" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="vcenter">Tambah Level</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <input type="hidden" id="id_level" name="id_level">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">
                <div class="modal-body">

                    <form id="form_level" autocomplete="off">

                    <div class="row d-flex justify-content-center mt-3 mb-3">
                        <div class="col-md-10">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Kode Level</label>
                                <div class="col-md-9">
                                    <input type="text" id="kode_level" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Nama Level</label>
                                <div class="col-md-9">
                                <input type="text" class="form-control" id="nama_level" placeholder="Masukkan Nama Level">
                                </div>
                            </div>
                        </div>
                    </div>

                    </form>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="simpan_level">Simpan</button>
                </div>
            </div>
        </div>
    </div>

<script>

$(document).ready(function () {

    // dataTables level
    var tabel_level = $('#tabel_level').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "<?= base_url("man_user/tampil_level") ?>",
            "type"  : "POST"
        },
        "columnDefs"        : [{
            "targets"   : [0,3],
            "orderable" : false
        }]

    })

    $('#tambah_data').on('click', function () {
        // $("a[href='#profile']").tab('show');

        $.ajax({
            url         : "<?= base_url('man_user/tampil_kode_level') ?>",
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

                console.log(data.kode_level);

                $('#modal_level').modal('show');

                $('#form_level').trigger("reset");

                $('#kode_level').val(data.kode_level);

                $('.modal-title').text('Tambah Level');
                $('#aksi').val('Tambah');

            }
        })

        return false;
    })

    // aksi simpan level
    $('#simpan_level').on('click', function () {
        
        var nama_level  = $('#nama_level').val();
        var kode_level  = $('#kode_level').val();
        var aksi        = $('#aksi').val();
        var id_level    = $('#id_level').val();

        console.log(id_level);

        if (nama_level == '') {
            swal({
                  title               : "Peringatan",
                  text                : 'Nama Level harus terisi!',
                  buttonsStyling      : false,
                  confirmButtonClass  : "btn btn-success",
                  type                : 'warning'
              }); 

            return false;
        } else {

            swal({
              title       : 'Konfirmasi',
              text        : 'Yakin akan kirim data',
              type        : 'warning',

              buttonsStyling      : false,
              confirmButtonClass  : "btn btn-primary",
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
                      url         : "<?= base_url('man_user/aksi_level') ?>",
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
                      data        : {nama_level:nama_level, kode_level:kode_level, aksi:aksi, id_level:id_level},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_level.ajax.reload(null, false);

                            swal({
                                title               : aksi+' Level',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 800
                            }); 
                          
                          $('#modal_level').modal('hide');
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
                        text                : 'Anda membatalkan '+aksi.toLowerCase()+' level',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-primary",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 800
                    }); 
              }
          })

        }

    })

    // aksi edit level
    $('#tabel_level').on('click', '.edit-level', function () {
         var id_level = $(this).data('id');

         console.log(id_level);

         $.ajax({
            url : "<?php echo base_url('man_user/ambil_data_level')?>/"+id_level,
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

                $('#id_level').val(data.id_data_level);
                $('#nama_level').val(data.nama_level);
                $('#kode_level').val(data.kode_level);

                $('#modal_level').modal('show');
                $('.modal-title').text('Edit Level');
                $('#aksi').val('Edit');
     
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
         })        
    })

    // hapus level
    $('#tabel_level').on('click', '.hapus-level', function () {
        
        var id_level = $(this).data('id');

        swal({
              title       : 'Konfirmasi',
              text        : 'Yakin akan hapus data',
              type        : 'warning',

              buttonsStyling      : false,
              confirmButtonClass  : "btn btn-primary",
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
                      url         : "<?= base_url('man_user/aksi_level') ?>",
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
                      data        : {aksi:'hapus', id_level:id_level},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_level.ajax.reload(null, false);

                            swal({
                                title               : 'Hapus Level',
                                text                : 'Data Berhasil Dihapus',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 800
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
                        text                : 'Anda membatalkan hapus level',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-primary",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 800
                    }); 
              }
          })

    })
    
})

</script>