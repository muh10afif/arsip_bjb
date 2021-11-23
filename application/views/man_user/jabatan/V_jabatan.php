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
            <table class="table table-bordered table-hover" id="tabel_jabatan" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="10%">No</th>
                        <th>Kode Jabatan</th>
                        <th>Jabatan</th>
                        <?php $level = $this->session->userdata('level'); ?>

                        <?php if ($level == 1) : ?>
                            <th>Unit Kerja</th>
                        <?php endif ?>
                        
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal jabatan -->
<div id="modal_jabatan" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="vcenter">Tambah Jabatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <input type="hidden" id="id_jabatan" name="id_jabatan">
            <input type="hidden" id="aksi" name="aksi" value="Tambah">
            <div class="modal-body">

                <form id="form_jabatan" autocomplete="off">

                <div class="row d-flex justify-content-center mt-3 mb-3">
                    <div class="col-md-10">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Kode Jabatan</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="kode_jabatan" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <?php $level = $this->session->userdata('level'); ?>

                    <?php if ($level == 1) : ?>

                    <div class="col-md-10 mt-3 list-unit">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Unit Kerja</label>
                            <div class="col-md-9">
                                
                                <div class="input-group sel-unit">
                                    <select name="unit_kerja" id="unit_kerja" class="form-control">
                                        <?php foreach ($unit_kerja as $k): ?>
                                            <option value="<?= $k['id_unit_kerja'] ?>"><?= $k['unit_kerja'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="tambah_unit" data-toggle="tooltip" data-placement="top" title="Tekan untuk aksi tambah unit, bila data tidak ada pada list unit"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>

                                <div class="sel-unit-edit" hidden>
                                    <select name="unit_kerja" id="unit_kerja_edit" class="form-control">
                                        <?php foreach ($unit_kerja as $k): ?>
                                            <option value="<?= $k['id_unit_kerja'] ?>"><?= $k['unit_kerja'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                            </div>
                        </div>
                    </div>

                    <?php endif ?>

                    <div class="col-md-10 mt-3 form-unit" hidden>
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Unit Kerja</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="unit_kerja_input" placeholder="Masukkan Unit Kerja">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label class="col-md-3 control-label col-form-label">Lokasi</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="lokasi" placeholder="Masukkan Lokasi">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label class="col-md-3 control-label col-form-label">Level</label>
                            <div class="col-md-9">
                                <select name="level" id="level" placeholder="Pilih Level" data-allow-clear="1">
                                    <?php foreach ($level as $k): ?>
                                        <option value="<?= $k['id_data_level'] ?>"><?= $k['nama_level'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Nama Jabatan</label>
                            <div class="col-md-9">
                            <input type="text" class="form-control" id="nama_jabatan" placeholder="Masukkan Nama Jabatan">
                            </div>
                        </div>
                    </div>
                </div>

                </form>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="simpan_jabatan">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>

  $(document).ready(function () {

      // dataTables jabatan
      var tabel_jabatan = $('#tabel_jabatan').DataTable({
          "processing"        : true,
          "serverSide"        : true,
          "order"             : [],
          "ajax"              : {
              "url"   : "<?= base_url("man_user/tampil_jabatan") ?>",
              "type"  : "POST"
          },

                "columnDefs"        : [{
                    "targets"   : [0],
                    "orderable" : false
                }]
          

      })

      $('#tambah_data').on('click', function () {

        $.ajax({
            url         : "<?= base_url('man_user/tampil_kode_jabatan') ?>",
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

                $('#modal_jabatan').modal('show');

                $('#form_jabatan').trigger("reset");

                $('#kode_jabatan').val(data.kode_jabatan);

                $('.modal-title').text('Tambah Jabatan');
                $('#aksi').val('Tambah');

                $('.modal [data-toggle="tooltip"]').tooltip({trigger: 'hover'}); 

                $('.form-unit').attr('hidden', true);
                $('.list-unit').removeAttr('hidden');

                // $('.sel-unit-edit').attr('hidden', true);
                // $('.sel-unit').removeAttr('hidden');

            }
        })

        return false;
      })

      $('#tambah_unit').on('click', function () {
          
        $('.list-unit').attr('hidden', true);
        $('.form-unit').removeAttr('hidden');

      })

      // aksi simpan jabatan
      $('#simpan_jabatan').on('click', function () {
          
          var kode_jabatan      = $('#kode_jabatan').val();
          var nama_jabatan      = $('#nama_jabatan').val();
          var unit_kerja        = $('#unit_kerja').val();
          var unit_kerja_input  = $('#unit_kerja_input').val();
          var unit_kerja_edit   = $('#unit_kerja_edit').val();
          var lokasi            = $('#lokasi').val();
          var level             = $('#level').val();
          var aksi              = $('#aksi').val();
          var id_jabatan        = $('#id_jabatan').val();

          if (nama_jabatan == '') {
              swal({
                    title               : "Peringatan",
                    text                : 'Nama jabatan harus terisi!',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-warning",
                    type                : 'warning'
                }); 

              return false;
          } else if (unit_kerja == '') {
              swal({
                    title               : "Peringatan",
                    text                : 'Unit kerja harus terisi!',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-warning",
                    type                : 'warning'
                }); 

              return false;
          } else {

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
                        url         : "<?= base_url('man_user/aksi_jabatan') ?>",
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
                        data        : {kode_jabatan:kode_jabatan, nama_jabatan:nama_jabatan, unit_kerja:unit_kerja, unit_kerja_input:unit_kerja_input, unit_kerja_edit:unit_kerja_edit, lokasi:lokasi, level:level, aksi:aksi, id_data_jabatan:id_jabatan},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_jabatan.ajax.reload(null, false);

                              swal({
                                  title               : aksi+' Jabatan',
                                  text                : 'Data Berhasil Disimpan',
                                  buttonsStyling      : false,
                                  confirmButtonClass  : "btn btn-success",
                                  type                : 'success',
                                  showConfirmButton   : false,
                                  timer               : 1000
                              }); 
                            
                            $('#modal_jabatan').modal('hide');
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
                          text                : 'Anda membatalkan '+aksi.toLowerCase()+' jabatan',
                          buttonsStyling      : false,
                          confirmButtonClass  : "btn btn-info",
                          type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                      }); 
                }
            })

          }

      })

      // aksi edit jabatan
      $('#tabel_jabatan').on('click', '.edit-jabatan', function () {
           var id_jabatan = $(this).data('id');

           console.log(id_jabatan);

           $.ajax({
              url : "<?php echo base_url('man_user/ambil_data_jabatan')?>/"+id_jabatan,
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

                //   $('.sel-unit').attr('hidden', true);
                //   $('.sel-unit-edit').removeAttr('hidden');

                  $('.form-unit').attr('hidden', true);
                  $('.list-unit').removeAttr('hidden');
                  
                  $('#id_jabatan').val(data.id_data_jabatan);
                  $('#kode_jabatan').val(data.kode_jabatan);
                  $('#nama_jabatan').val(data.nama_jabatan);
                  $('#unit_kerja').select2("val", data.id_unit_kerja);

                  $('#modal_jabatan').modal('show');
                  $('.modal-title').text('Edit Jabatan');
                  $('#aksi').val('Edit');

                  $('.modal [data-toggle="tooltip"]').tooltip({trigger: 'hover'}); 
       
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
           })        
      })

      // hapus jabatan
      $('#tabel_jabatan').on('click', '.hapus-jabatan', function () {
          
          var id_jabatan = $(this).data('id');

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
                        url         : "<?= base_url('man_user/aksi_jabatan') ?>",
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
                        data        : {aksi:'hapus', id_data_jabatan:id_jabatan},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_jabatan.ajax.reload(null, false);

                              swal({
                                  title               : 'Hapus Jabatan',
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
                          text                : 'Anda membatalkan hapus jabatan',
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