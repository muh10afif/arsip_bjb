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
            <table class="table table-bordered table-hover" id="tabel_gudang_arsip" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Gudang Arsip</th>
                        <th>Gudang Arsip</th>
                        <th>Lokasi</th>
                        <th>Kuota</th>
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

<!-- modal gudang_arsip -->
<div id="modal_gudang_arsip" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="vcenter">Tambah Gudang Arsip</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">

                <form id="form_gudang_arsip" autocomplete="off">

                <input type="hidden" id="id_gudang_arsip" name="id_gudang_arsip">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">

                <div class="row d-flex justify-content-center mt-3 mb-3">
                    <div class="col-md-10">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Kode Gudang Arsip</label>
                            <div class="col-md-9">
                                <input type="text" id="kode_gudang_arsip" name="kode_gudang_arsip" class="form-control" value="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Gudang Arsip</label>
                            <div class="col-md-9">
                            <input type="text" class="form-control" id="gudang_arsip" name="gudang_arsip" placeholder="Masukkan Gudang Arsip">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Lokasi</label>
                            <div class="col-md-9">
                                <textarea name="lokasi" id="lokasi" class="form-control" placeholder="Masukkan Lokasi"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Kuota</label>
                            <div class="col-md-9">
                            <input type="number" class="form-control" id="kuota" name="kuota" placeholder="Masukkan Kuota">
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
                <button type="button" class="btn btn-success" id="simpan_gudang_arsip">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>

  $(document).ready(function () {

      // dataTables gudang_arsip
      var tabel_gudang_arsip = $('#tabel_gudang_arsip').DataTable({
          "processing"        : true,
          "serverSide"        : true,
          "order"             : [],
          "ajax"              : {
              "url"   : "<?= base_url("Master_kearsipan/tampil_gudang_arsip") ?>",
              "type"  : "POST"
          },
          "columnDefs"        : [{
              "targets"   : [0,6],
              "orderable" : false
          }]

      })

      $('#tambah_data').on('click', function () {

          $.ajax({
            url         : "<?= base_url('Master_kearsipan/tampil_kode_gudang_arsip') ?>",
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

                console.log(data.kode_gudang_arsip);
                
                $('#modal_gudang_arsip').modal('show');

                $('#form_gudang_arsip').trigger("reset");

                $('#kode_gudang_arsip').val(data.kode_gudang_arsip);

                $('.modal-title').text('Tambah Gudang Arsip');
                $('#aksi').val('Tambah');

                $('.list-status').attr('hidden', true);

            }
        })

        return false;
      })

      // aksi simpan gudang_arsip
      $('#simpan_gudang_arsip').on('click', function () {
          
          var form_gudang_arsip = $('#form_gudang_arsip').serialize();
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
                    url         : "<?= base_url('Master_kearsipan/aksi_gudang_arsip') ?>",
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
                    data        : form_gudang_arsip,
                    dataType    : "JSON",
                    success     : function (data) {

                        tabel_gudang_arsip.ajax.reload(null, false);

                            swal({
                                title               : aksi+' Gudang Arsip',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 
                        
                        $('#modal_gudang_arsip').modal('hide');
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
                        text                : 'Anda membatalkan '+aksi.toLowerCase()+' gudang arsip',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 
            }
        })

      })

      // aksi edit gudang_arsip
      $('#tabel_gudang_arsip').on('click', '.edit-gudang-arsip', function () {
           var id_gudang_arsip = $(this).data('id');

           console.log(id_gudang_arsip);

           $.ajax({
              url : "<?php echo base_url('Master_kearsipan/ambil_data_gudang_arsip')?>/"+id_gudang_arsip,
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

                  $('#id_gudang_arsip').val(data.id_gudang_arsip);
                  $('#kode_gudang_arsip').val(data.kode_gudang_arsip);
                  $('#gudang_arsip').val(data.gudang_arsip);
                  $('#lokasi').val(data.lokasi);
                  $('#kuota').val(data.kuota);
                  $('#status').select2("val", data.status);

                  $('#modal_gudang_arsip').modal('show');
                  $('.modal-title').text('Edit Gudang Arsip');
                  $('#aksi').val('Edit');

                  $('.list-status').removeAttr('hidden');
       
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
           })        
      })

      // hapus gudang_arsip
      $('#tabel_gudang_arsip').on('click', '.hapus-gudang-arsip', function () {
          
          var id_gudang_arsip = $(this).data('id');

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
                        url         : "<?= base_url('Master_kearsipan/aksi_gudang_arsip') ?>",
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
                        data        : {aksi:'hapus', id_gudang_arsip:id_gudang_arsip},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_gudang_arsip.ajax.reload(null, false);

                              swal({
                                  title               : 'Hapus Gudang Arsip',
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
                          text                : 'Anda membatalkan hapus gudang arsip',
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