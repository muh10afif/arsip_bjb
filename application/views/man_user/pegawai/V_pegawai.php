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
            <table class="table table-bordered table-hover" id="tabel_pegawai" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="10%">No</th>
                        <th>Reg Employee</th>
                        <th>Nama Pegawai</th>
                        <th>Jabatan</th>
                        <th>Telepon</th>
                        <th>Email</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal pegawai -->
<div id="modal_pegawai" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="vcenter">Tambah Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">

                <form id="form-pegawai" autocomplete="off" method="POST">

                    <input type="hidden" id="id_pegawai" name="id_pegawai">
                    <input type="hidden" id="aksi" name="aksi" value="Tambah">

                <div class="row mt-3 mb-3">
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Reg Employee</label>
                            <div class="col-md-9">
                                <input type="text" id="reg_emp" name="reg_emp" class="form-control" value="" readonly>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label class="col-md-3 control-label col-form-label">NIK</label>
                            <div class="col-md-9">
                                <input type="number" id="nik" name="nik" class="form-control" placeholder="Masukkan NIK">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label class="col-md-3 control-label col-form-label">Nama Pegawai</label>
                            <div class="col-md-9">
                                <input type="text" id="nama_pegawai" name="nama_pegawai" class="form-control" placeholder="Masukkan Nama Pegawai">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label class="col-md-3 control-label col-form-label">Tanggal Lahir</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" name="tgl_lahir" id="tgl_lahir" placeholder="Tanggal Lahir" readonly>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label class="col-md-3 control-label col-form-label">No Telepon</label>
                            <div class="col-md-9">
                                <input type="number" id="no_telp" name="no_telp" class="form-control" placeholder="Masukkan No Telepon">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Email</label>
                            <div class="col-md-9">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Masukkan Nama Pegawai">
                            </div>
                        </div>

                        <?php $level = $this->session->userdata('level'); ?>

                        <?php if ($level == 1) : ?>
                            <div class="row mt-3 list-unit">
                                <label class="col-md-3 control-label col-form-label">Unit Kerja</label>
                                <div class="col-md-9">
                                    
                                    <div class="input-group sel-unit">
                                        <select name="unit_kerja" id="unit_kerja" placeholder="Pilih Unit Kerja" data-allow-clear="1">
                                            <?php foreach ($unit_kerja as $k): ?>
                                                <option value="<?= $k['id_unit_kerja'] ?>"><?= $k['unit_kerja'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" id="tambah_unit" data-toggle="tooltip" data-placement="top" title="Tekan untuk aksi tambah unit, bila data tidak ada pada list unit"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="mt-3  form-unit" hidden>
                                <div class="row">
                                    <label class="col-md-3 control-label col-form-label">Unit Kerja</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="unit_kerja_input" id="unit_kerja_input" placeholder="Masukkan Unit Kerja">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label col-form-label">Lokasi</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="lokasi" id="lokasi" placeholder="Masukkan Lokasi">
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <label class="col-md-3 control-label col-form-label">Level</label>
                                    <div class="col-md-9">
                                        <select name="level" id="level" class="form-control">
                                            <?php foreach ($level as $k): ?>
                                                <option value="<?= $k['id_data_level'] ?>"><?= $k['nama_level'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>

                        
                        <div class="row mt-3 list-jabatan">
                            <label class="col-md-3 control-label col-form-label">Jabatan</label>
                            <div class="col-md-9">
                                
                                <div class="input-group sel-unit">
                                    <select name="jabatan" id="jabatan" placeholder="Pilih Jabatan" data-allow-clear="1">
                                        <?php foreach ($jabatan as $k): ?>
                                            <option value="<?= $k['id_data_jabatan'] ?>"><?= $k['nama_jabatan'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div id="loading_jabatan" style="margin-top: 10px;" align='center'>
                                        <img src="<?= base_url('assets/img/loading.gif') ?>" width="18"> <small>Loading...</small>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" id="tambah_jabatan" data-toggle="tooltip" data-placement="top" title="Tekan untuk aksi tambah jabatan, bila data tidak ada pada list jabatan"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                
                            </div>
                        </div> 
                        <div class="mt-3 form-jabatan" hidden>
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Nama Jabatan</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="jabatan_input" id="jabatan_input" placeholder="Masukkan Nama Jabatan">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label class="col-md-3 control-label col-form-label">Alamat</label>
                            <div class="col-md-9">
                                <textarea name="alamat" class="form-control" id="alamat" rows="3" placeholder="Masukkan Alamat"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                </form>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="simpan_pegawai">Simpan</button>
            </div>
        </div>
    </div>
</div>

<!-- modal detail pegawai -->
<div id="modal_detail_pegawai" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="vcenter">Detail Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">

                <div class="row mt-3 mb-3">
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Reg Employee</label>
                            <div class="col-md-9">
                                <input type="text" name="reg_emp" class="form-control reg_emp" value="" readonly>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label class="col-md-3 control-label col-form-label">NIK</label>
                            <div class="col-md-9">
                                <input type="number" class="form-control nik" readonly>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label class="col-md-3 control-label col-form-label">Nama Pegawai</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control nama_pegawai" readonly>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label class="col-md-3 control-label col-form-label">Tanggal Lahir</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker tgl_lahir" disabled>
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <label class="col-md-3 control-label col-form-label">No Telepon</label>
                            <div class="col-md-9">
                                <input type="number" class="form-control no_telp" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Email</label>
                            <div class="col-md-9">
                                <input type="email" class="form-control email" readonly>
                            </div>
                        </div>
                        <div class="row mt-3 list-unit">
                            <label class="col-md-3 control-label col-form-label">Unit Kerja</label>
                            <div class="col-md-9">
                                
                                <input type="text" class="form-control unit_kerja" readonly>

                            </div>
                        </div>
                        <div class="row mt-3 list-jabatan">
                            <label class="col-md-3 control-label col-form-label">Jabatan</label>
                            <div class="col-md-9">
                                
                            <input type="text" class="form-control jabatan" readonly>
                                
                            </div>
                        </div> 
                        <div class="row mt-3">
                            <label class="col-md-3 control-label col-form-label">Alamat</label>
                            <div class="col-md-9">
                                <textarea class="form-control alamat" rows="3" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </div>

            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>

  $(document).ready(function () {

      // dataTables pegawai
      var tabel_pegawai = $('#tabel_pegawai').DataTable({
          "processing"        : true,
          "serverSide"        : true,
          "order"             : [],
          "ajax"              : {
              "url"   : "<?= base_url("man_user/tampil_pegawai") ?>",
              "type"  : "POST"
          },
          "columnDefs"        : [{
              "targets"   : [0,4],
              "orderable" : false
          }]

      })

      $('#tambah_data').on('click', function () {

          $.ajax({
            url         : "<?= base_url('man_user/tampil_reg_emp') ?>",
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

                $('#modal_pegawai').modal('show');

                $('#form-pegawai').trigger("reset");

                $('#reg_emp').val(data.reg_emp);

                $('.datepicker').datepicker('setDate', null);

                $('#unit_kerja').select2("val", ' ');
                $('#jabatan').select2("val", ' ');

                $('.modal-title').text('Tambah Pegawai');
                $('#aksi').val('Tambah');

                $('.form-unit').attr('hidden', true);
                $('.list-unit').removeAttr('hidden');

                $('.form-jabatan').attr('hidden', true);
                $('.list-jabatan').removeAttr('hidden');

                $('.modal [data-toggle="tooltip"]').tooltip({trigger: 'hover'});

            }
        })

        return false;
      })

    $('#tambah_unit').on('click', function () {
        
        $('.list-unit').attr('hidden', true);
        $('.form-unit').removeAttr('hidden');

        $('.list-jabatan').attr('hidden', true);
        $('.form-jabatan').removeAttr('hidden');

    })

    $('#tambah_jabatan').on('click', function () {
        
        $('.list-jabatan').attr('hidden', true);
        $('.form-jabatan').removeAttr('hidden');

    })

    // linked combobox
    $('#loading_jabatan').hide();

    $('#unit_kerja').on('change', function () {
        var id_unit_kerja = $(this).val();

        $('#jabatan').next('.select2-container').hide();
        $('#loading_jabatan').show();

        $.ajax({
            url         : "<?= base_url('man_user/ambil_jabatan') ?>",
            type        : "POST",
            beforeSend 	: function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charshet=UTF-8");
                }				
            },
            data        : {id_unit_kerja:id_unit_kerja},
            dataType    : "JSON",
            success     : function (data) {
                $('#loading_jabatan').hide();
                $('#jabatan').next('.select2-container').show();
                $('#jabatan').html(data.jabatan);
            },
            error 		: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })
    })

      // aksi simpan pegawai
      $('#simpan_pegawai').on('click', function () {
          
          var form_pegawai  = $('#form-pegawai').serialize();
          var aksi          = $('#aksi').val();

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
                    url         : "<?= base_url('man_user/aksi_pegawai') ?>",
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
                    data        : form_pegawai,
                    dataType    : "JSON",
                    success     : function (data) {

                        tabel_pegawai.ajax.reload(null, false);

                            swal({
                                title               : aksi+' Pegawai',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success'
                            }); 
                        
                        $('#modal_pegawai').modal('hide');
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
                        text                : 'Anda membatalkan '+aksi.toLowerCase()+' pegawai',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error'
                    }); 
            }
        })


      })

      // aksi edit pegawai
      $('#tabel_pegawai').on('click', '.edit-pegawai', function () {
           var id_pegawai = $(this).data('id');

           console.log(id_pegawai);

           $.ajax({
              url : "<?php echo base_url('man_user/ambil_data_pegawai')?>/"+id_pegawai,
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

                  console.log(data.id_data_jabatan);

                  $('#id_pegawai').val(data.id_data_pegawai);
                  $('#reg_emp').val(data.reg_employee);
                  $('#nik').val(data.nik);
                  $('#nama_pegawai').val(data.nama_pegawai);
                  $('#tgl_lahir').datepicker('setDate', data[0].tgl_lahir);
                  $('#no_telp').val(data.no_telp);
                  $('#email').val(data.email);
                  $('#alamat').val(data.alamat);

                  $('#unit_kerja').select2("val", data.id_unit_kerja);
                  $('#jabatan').select2("val", data.id_data_jabatan);


                  $('#modal_pegawai').modal('show');
                  $('.modal-title').text('Edit Pegawai');
                  $('#aksi').val('Edit');

                $('.form-unit').attr('hidden', true);
                $('.list-unit').removeAttr('hidden');

                $('.form-jabatan').attr('hidden', true);
                $('.list-jabatan').removeAttr('hidden');
       
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
           })        
      })

      // aksi detail pegawai
      $('#tabel_pegawai').on('click', '.detail-pegawai', function () {
           var id_pegawai = $(this).data('id');

           console.log(id_pegawai);

           $.ajax({
              url : "<?php echo base_url('man_user/ambil_data_pegawai')?>/"+id_pegawai,
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

                  $('.reg_emp').val(data.reg_employee);
                  $('.nik').val(data.nik);
                  $('.nama_pegawai').val(data.nama_pegawai);
                  $('.tgl_lahir').datepicker('setDate', data[0].tgl_lahir);
                  $('.no_telp').val(data.no_telp);
                  $('.email').val(data.email);
                  $('.alamat').val(data.alamat);

                  $('.unit_kerja').val(data[0].nm_unit);
                  $('.jabatan').val(data[0].nm_jabatan);


                  $('#modal_detail_pegawai').modal('show');
                  $('.modal-title').text('Detail Pegawai');
       
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
           })        
      })

      // hapus pegawai
      $('#tabel_pegawai').on('click', '.hapus-pegawai', function () {
          
          var id_pegawai = $(this).data('id');

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
                        url         : "<?= base_url('man_user/aksi_pegawai') ?>",
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
                        data        : {aksi:'hapus', id_pegawai:id_pegawai},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_pegawai.ajax.reload(null, false);

                              swal({
                                  title               : 'Hapus Pegawai',
                                  text                : 'Data Berhasil Dihapus',
                                  buttonsStyling      : false,
                                  confirmButtonClass  : "btn btn-success",
                                  type                : 'success'
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
                          text                : 'Anda membatalkan hapus pegawai',
                          buttonsStyling      : false,
                          confirmButtonClass  : "btn btn-info",
                          type                : 'error'
                      }); 
                }
            })

      })
      
  })

</script>