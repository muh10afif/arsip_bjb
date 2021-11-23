<ol class="breadcrumb bg-transparent mt-4">
    <?php $i=0; foreach ($breadcrumb as $bc): ?>
    <li class="breadcrumb-item active"><?= $bclink[$i] ?><?=  $bc ?></a></li>
    <?php $i++; endforeach ?>
</ol>

<div class="card mb-4 shadow" id="kartu">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tabel_pelaporan" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th  width="10%">No</th>
                        <th>Unit Kerja Pemilik</th>
                        <th>Kode Masalah</th>
                        <th>Jenis Berkas</th>
                        <th>Kode Berkas</th>
                        <th>Judul Berkas</th>
                        <th>Tanggal Pelaporan</th>
                        <th>Status</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

    <!-- modal pelaporan -->
    <div id="modal_pelaporan" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title text-white" id="vcenter">Tambah Penyiangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <input type="hidden" id="id_pelaporan" name="id_pelaporan">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">
                <div class="modal-body">

                    <form id="form_pelaporan" autocomplete="off">

                    <div class="row d-flex justify-content-center mt-3 mb-3">
                        <div class="col-md-10">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Kode Penyiangan</label>
                                <div class="col-md-9">
                                    <input type="text" id="kode_pelaporan" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 mt-3">
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Nama Penyiangan</label>
                                <div class="col-md-9">
                                <input type="text" class="form-control" id="nama_pelaporan" placeholder="Masukkan Nama Penyiangan">
                                </div>
                            </div>
                        </div>
                    </div>

                    </form>
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" id="simpan_pelaporan">Simpan</button>
                </div>
            </div>
        </div>
    </div>

<script>

$(document).ready(function () {

    // dataTables pelaporan
    var tabel_pelaporan = $('#tabel_pelaporan').DataTable({
        "processing"        : true,
        "serverSide"        : true,
        "order"             : [],
        "ajax"              : {
            "url"   : "<?= base_url("trans/tampil_pelaporan") ?>",
            "type"  : "POST"
        },
        "columnDefs"        : [{
            "targets"   : [0,8],
            "orderable" : false
        }]

    })

    $('#tambah_data').on('click', function () {
        // $("a[href='#profile']").tab('show');

        

        $.ajax({
            url         : "<?= base_url('trans/tampil_kode_pelaporan') ?>",
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

                console.log(data.kode_pelaporan);

                $('#modal_pelaporan').modal('show');

                $('#form_pelaporan').trigger("reset");

                $('#kode_pelaporan').val(data.kode_pelaporan);

                $('.modal-title').text('Tambah Penyiangan');
                $('#aksi').val('Tambah');

            }
        })

        return false;
    })

    // aksi simpan pelaporan
    $('#simpan_pelaporan').on('click', function () {
        
        var nama_pelaporan  = $('#nama_pelaporan').val();
        var kode_pelaporan  = $('#kode_pelaporan').val();
        var aksi        = $('#aksi').val();
        var id_pelaporan    = $('#id_pelaporan').val();

        console.log(id_pelaporan);

        if (nama_pelaporan == '') {
            swal({
                  title               : "Peringatan",
                  text                : 'Nama Penyiangan harus terisi!',
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
                      url         : "<?= base_url('trans/aksi_pelaporan') ?>",
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
                      data        : {nama_pelaporan:nama_pelaporan, kode_pelaporan:kode_pelaporan, aksi:aksi, id_pelaporan:id_pelaporan},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_pelaporan.ajax.reload(null, false);

                            swal({
                                title               : aksi+' Penyiangan',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 800
                            }); 
                          
                          $('#modal_pelaporan').modal('hide');
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
                        text                : 'Anda membatalkan '+aksi.toLowerCase()+' pelaporan',
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

    // aksi edit pelaporan
    $('#tabel_pelaporan').on('click', '.edit-pelaporan', function () {
         var id_pelaporan = $(this).data('id');

         console.log(id_pelaporan);

         $.ajax({
            url : "<?php echo base_url('trans/ambil_data_pelaporan')?>/"+id_pelaporan,
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

                $('#id_pelaporan').val(data.id_data_pelaporan);
                $('#nama_pelaporan').val(data.nama_pelaporan);
                $('#kode_pelaporan').val(data.kode_pelaporan);

                $('#modal_pelaporan').modal('show');
                $('.modal-title').text('Edit Penyiangan');
                $('#aksi').val('Edit');
     
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
         })        
    })

    // hapus pelaporan
    $('#tabel_pelaporan').on('click', '.hapus-pelaporan', function () {
        
        var id_pelaporan = $(this).data('id');

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
                      url         : "<?= base_url('trans/aksi_pelaporan') ?>",
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
                      data        : {aksi:'hapus', id_pelaporan:id_pelaporan},
                      dataType    : "JSON",
                      success     : function (data) {

                          tabel_pelaporan.ajax.reload(null, false);

                            swal({
                                title               : 'Hapus Penyiangan',
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
                        text                : 'Anda membatalkan hapus pelaporan',
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