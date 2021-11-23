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
            <table class="table table-bordered table-hover" id="tabel_jenis_berkas" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Jenis Berkas</th>
                        <th>Jenis Berkas</th>
                        <th>Unit Kerja</th>
                        <th>Jangka Waktu</th>
                        <th>Scan Requirement</th>
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

<!-- modal jenis_berkas -->
<div id="modal_jenis_berkas" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="vcenter">Tambah Jenis Berkas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">

                <form id="form_jenis_berkas" autocomplete="off">

                <input type="hidden" id="id_jenis_berkas" name="id_jenis_berkas">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">

                <div class="row d-flex justify-content-center mt-3 mb-3">
                    <div class="col-md-10">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Kode Jenis Berkas</label>
                            <div class="col-md-9">
                                <input type="text" name="kode_jenis_berkas" id="kode_jenis_berkas" class="form-control" value="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Jenis Berkas</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="jenis_berkas" id="jenis_berkas" placeholder="Masukkan Jenis Berkas">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Unit Kerja</label>
                            <div class="col-md-9">
                                
                                <select name="unit_kerja" id="unit_kerja" placeholder="Pilih Unit Kerja" data-allow-clear="1">
                                    <?php foreach ($unit_kerja as $k): ?>
                                        <option value="<?= $k['id_unit_kerja'] ?>"><?= $k['unit_kerja'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Jangka Waktu Retensi</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="retensi" id="retensi" placeholder="Masukkan Jangka Waktu Rentensi">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Tahun</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Scan Document Requirement</label>
                            <div class="col-md-9">

                                <select name="scan_dok" id="scan_dok" placeholder="Pilih Aksi" data-allow-clear="1">
                                    <option value="1">Ya</option>
                                    <option value="0">Tidak</option>
                                </select>
                                
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
                <button type="button" class="btn btn-success" id="simpan_jenis_berkas">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>

  $(document).ready(function () {

      // dataTables jenis_berkas
      var tabel_jenis_berkas = $('#tabel_jenis_berkas').DataTable({
          "processing"        : true,
          "serverSide"        : true,
          "order"             : [],
          "ajax"              : {
              "url"   : "<?= base_url("Master_kearsipan/tampil_jenis_berkas") ?>",
              "type"  : "POST"
          },
          "columnDefs"        : [{
              "targets"   : [0,7],
              "orderable" : false
          }]

      })

      $('#tambah_data').on('click', function () {

          $.ajax({
            url         : "<?= base_url('Master_kearsipan/tampil_kode_jenis_berkas') ?>",
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

                console.log(data.kode_jenis_berkas);

                $('#modal_jenis_berkas').modal('show');

                $('#form_jenis_berkas').trigger("reset");
                $('#kode_jenis_berkas').val(data.kode_jenis_berkas)

                $('.modal-title').text('Tambah Jenis Berkas');
                $('#aksi').val('Tambah');

                $('#unit_kerja').select2("val", ' ');
                $('#scan_dok').select2("val", ' ');

                $('.list-status').attr('hidden', true);

            }
        })

        return false;
      })

      // aksi simpan jenis_berkas
      $('#simpan_jenis_berkas').on('click', function () {
          
        var form_jns_berkas = $('#form_jenis_berkas').serialize();

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
                        url         : "<?= base_url('Master_kearsipan/aksi_jenis_berkas') ?>",
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
                        data        : form_jns_berkas,
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_jenis_berkas.ajax.reload(null, false);

                              swal({
                                  title               : aksi+' Jenis Berkas',
                                  text                : 'Data Berhasil Disimpan',
                                  buttonsStyling      : false,
                                  confirmButtonClass  : "btn btn-success",
                                  type                : 'success',
                                  showConfirmButton   : false,
                                  timer               : 1000
                              }); 
                            
                            $('#modal_jenis_berkas').modal('hide');
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
                          text                : 'Anda membatalkan '+aksi.toLowerCase()+' jenis_berkas',
                          buttonsStyling      : false,
                          confirmButtonClass  : "btn btn-info",
                          type                : 'error',
                          showConfirmButton   : false,
                          timer               : 1000
                      }); 
                }
            })

      })

      // aksi edit jenis_berkas
      $('#tabel_jenis_berkas').on('click', '.edit-jenis_berkas', function () {
           var id_jenis_berkas = $(this).data('id');

           console.log(id_jenis_berkas);

           $.ajax({
              url : "<?php echo base_url('Master_kearsipan/ambil_data_jenis_berkas')?>/"+id_jenis_berkas,
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

                  $('#id_jenis_berkas').val(data.id_jenis_berkas);
                  $('#kode_jenis_berkas').val(data.kode_jenis_berkas);
                  $('#jenis_berkas').val(data.jenis_berkas);
                  $('#retensi').val(data.jangka_waktu_retensi);
                  $('#unit_kerja').select2("val", data.id_unit_kerja);
                  $('#scan_dok').select2("val", data.scan_requirment);
                  $('#status').select2("val", data.status);

                  $('#modal_jenis_berkas').modal('show');
                  $('.modal-title').text('Edit Jenis Berkas');
                  $('#aksi').val('Edit');

                  $('.list-status').removeAttr('hidden');
       
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
           })        
      })

      // hapus jenis_berkas
      $('#tabel_jenis_berkas').on('click', '.hapus-jenis_berkas', function () {
          
          var id_jenis_berkas = $(this).data('id');

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
                        url         : "<?= base_url('Master_kearsipan/aksi_jenis_berkas') ?>",
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
                        data        : {aksi:'hapus', id_jenis_berkas:id_jenis_berkas},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_jenis_berkas.ajax.reload(null, false);

                              swal({
                                  title               : 'Hapus Jenis Berkas',
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
                          text                : 'Anda membatalkan hapus jenis berkas',
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