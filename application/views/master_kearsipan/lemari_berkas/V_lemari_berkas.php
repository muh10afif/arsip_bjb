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
            <table class="table table-bordered table-hover" id="tabel_lemari_berkas" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Lemari Berkas</th>
                        <th>Lemari Berkas</th>
                        <th>Letak</th>
                        <th>Keterangan</th>
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

<!-- modal lemari_berkas -->
<div id="modal_lemari_berkas" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="vcenter">Tambah Lemari Berkas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">

                <form id="form_lemari_berkas" autocomplete="off">

                <input type="hidden" id="id_lemari_berkas" name="id_lemari_berkas">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">

                <div class="row d-flex justify-content-center mt-3 mb-3">
                    <div class="col-md-10">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Kode Lemari Berkas</label>
                            <div class="col-md-9">
                                <input type="text" id="kode_lemari_berkas" name="kode_lemari_berkas" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Lemari Berkas</label>
                            <div class="col-md-9">
                            <input type="text" class="form-control" id="lemari_berkas" name="lemari_berkas" placeholder="Masukkan Lemari Berkas">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Letak</label>
                            <div class="col-md-9">
                                
                                <select name="gudang_arsip" id="gudang_arsip" placeholder="Pilih Gudang Arsip" data-allow-clear="1">
                                    <?php foreach ($gudang_arsip as $k): ?>
                                        <option value="<?= $k['id_gudang_arsip'] ?>"><?= $k['gudang_arsip'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Keterangan</label>
                            <div class="col-md-9">
                                <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Masukkan Keterangan"></textarea>
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
                <button type="button" class="btn btn-success" id="simpan_lemari_berkas">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>

  $(document).ready(function () {

      // dataTables lemari_berkas
      var tabel_lemari_berkas = $('#tabel_lemari_berkas').DataTable({
          "processing"        : true,
          "serverSide"        : true,
          "order"             : [],
          "ajax"              : {
              "url"   : "<?= base_url("Master_kearsipan/tampil_lemari_berkas") ?>",
              "type"  : "POST"
          },
          "columnDefs"        : [{
              "targets"   : [0,6],
              "orderable" : false
          }]

      })

      $('#tambah_data').on('click', function () {

          $.ajax({
            url         : "<?= base_url('Master_kearsipan/tampil_kode_lemari_berkas') ?>",
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

                $('#modal_lemari_berkas').modal('show');

                $('#form_lemari_berkas').trigger("reset");

                $('#kode_lemari_berkas').val(data.kode_lemari_berkas);

                $('.modal-title').text('Tambah Lemari Berkas');
                $('#aksi').val('Tambah');

                $('#gudang_arsip').select2("val", ' ');

                $('.list-status').attr('hidden', true);

            }
        })

        return false;
      })

      // aksi simpan lemari_berkas
      $('#simpan_lemari_berkas').on('click', function () {
          
          var form_lemari_berkas    = $('#form_lemari_berkas').serialize();
          var aksi                  = $('#aksi').val();

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
                    url         : "<?= base_url('Master_kearsipan/aksi_lemari_berkas') ?>",
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
                    data        : form_lemari_berkas,
                    dataType    : "JSON",
                    success     : function (data) {

                        tabel_lemari_berkas.ajax.reload(null, false);

                            swal({
                                title               : aksi+' Lemari Berkas',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 
                        
                        $('#modal_lemari_berkas').modal('hide');
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
                        text                : 'Anda membatalkan '+aksi.toLowerCase()+' lemari berkas',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 
            }
        })


      })

      // aksi edit lemari_berkas
      $('#tabel_lemari_berkas').on('click', '.edit-lemari-berkas', function () {
           var id_lemari_berkas = $(this).data('id');

           console.log(id_lemari_berkas);

           $.ajax({
              url : "<?php echo base_url('Master_kearsipan/ambil_data_lemari_berkas')?>/"+id_lemari_berkas,
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

                  $('#id_lemari_berkas').val(data.id_lemari_berkas);
                  $('#kode_lemari_berkas').val(data.kode_lemari_berkas);
                  $('#lemari_berkas').val(data.lemari_berkas);
                  $('#gudang_arsip').select2("val", data.letak);
                  $('#keterangan').val(data.ket);
                  $('#status').select2("val", data.status);

                  $('.list-status').removeAttr("hidden");

                  $('#modal_lemari_berkas').modal('show');
                  $('.modal-title').text('Edit Lemari Berkas');
                  $('#aksi').val('Edit');
       
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
           })        
      })

      // hapus lemari_berkas
      $('#tabel_lemari_berkas').on('click', '.hapus-lemari-berkas', function () {
          
          var id_lemari_berkas = $(this).data('id');

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
                        url         : "<?= base_url('Master_kearsipan/aksi_lemari_berkas') ?>",
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
                        data        : {aksi:'hapus', id_lemari_berkas:id_lemari_berkas},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_lemari_berkas.ajax.reload(null, false);

                              swal({
                                  title               : 'Hapus Lemari Berkas',
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
                          text                : 'Anda membatalkan hapus lemari berkas',
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