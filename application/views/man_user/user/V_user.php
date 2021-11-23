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
            <table class="table table-bordered table-hover" id="tabel_user" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th width="10%">No</th>
                        <th>Reg Employee</th>
                        <th>Nama Pegawai</th>
                        <th>Level</th>
                        <th>Username</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal user -->
<div id="modal_user" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="vcenter">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">

                <form id="form_user" autocomplete="off" method="POST">

                <input type="hidden" id="id_data_user" name="id_data_user">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">

                <div id="form-tambah">

                <div class="row d-flex justify-content-center mt-3 mb-3">
                    <div class="col-md-10">
                        <?php $level = $this->session->userdata('level'); ?>

                        <?php if ($level == 1) : ?>
                            <div class="row">
                                <label class="col-md-3 control-label col-form-label">Unit Kerja</label>
                                <div class="col-md-9">
                                    <select name="unit_kerja" id="unit_kerja" placeholder="Pilih Unit Kerja" data-allow-clear="1">
                                        <?php foreach ($unit as $k): ?>
                                            <option value="<?= $k['id_unit_kerja'] ?>"><?= $k['unit_kerja'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        <?php endif ?>
                        
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Jabatan</label>
                            <div class="col-md-9">
                                <select name="jabatan" id="jabatan" placeholder="Pilih Jabatan" data-allow-clear="1">
                                    <?php if ($level == 2) : ?>
                                        <?php foreach ($jabatan as $k): ?>
                                            <option value="<?= $k['id_data_jabatan'] ?>"><?= $k['nama_jabatan'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif ?>
                                </select>
                                <div id="loading_jabatan" style="margin-top: 10px;" align='center'>
                                    <img src="<?= base_url('assets/img/loading.gif') ?>" width="18"> <small>Loading...</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Nama Pegawai</label>
                            <div class="col-md-9">
                                <select name="nm_pegawai" id="nm_pegawai" placeholder="Pilih Nama Pegawai" data-allow-clear="1">
                                </select>
                                <div id="loading_nama" style="margin-top: 10px;" align='center'>
                                    <img src="<?= base_url('assets/img/loading.gif') ?>" width="18"> <small>Loading...</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Reg Employee</label>
                            <div class="col-md-9">
                                <input type="text" id="reg_emp" name="reg_emp" class="form-control" readonly>

                                <div id="loading_reg" style="margin-top: 10px;" align='center'>
                                    <img src="<?= base_url('assets/img/loading.gif') ?>" width="18"> <small>Loading...</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Username</label>
                            <div class="col-md-9">
                                <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan Username">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Password</label>
                            <div class="col-md-9">
                                <input type="password" id="password" name="password" class="form-control mb-2 password" placeholder="Masukkan Password">
                                <mark class="mark_pass"></mark> <br>
                                <small class="float-right" style="margin-top: -30px;"><input type="checkbox" class="form-checkbox mt-2" id="show"> <label for="show">Show password</label></small>
                            </div>
                        </div>
                    </div>
                </div>

                </div>

                <div id="form-edit" hidden>

                <input type="hidden" id="id_data_pegawai" name="id_data_pegawai">

                <div class="row d-flex justify-content-center mt-3 mb-3">
                    <div class="col-md-10">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Unit Kerja</label>
                            <div class="col-md-9">
                                <input type="text" name="unit_kerja_edit" id="unit_kerja_edit" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Jabatan</label>
                            <div class="col-md-9">
                                <input type="text" name="jabatan_edit" id="jabatan_edit" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Nama Pegawai</label>
                            <div class="col-md-9">
                                <input type="text" name="nm_pegawai_edit" id="nm_pegawai_edit" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Reg Employee</label>
                            <div class="col-md-9">
                                <input type="text" id="reg_emp_edit" name="reg_emp_edit" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Username</label>
                            <div class="col-md-9">
                                <input type="text" id="username_edit" name="username_edit" class="form-control" placeholder="Masukkan Username">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Password</label>
                            <div class="col-md-9">
                                <input type="password" id="password_edit" name="password_edit" class="form-control mb-2 password" placeholder="Masukkan Password">
                                <mark class="mark_pass"></mark> <br>
                                <small class="float-right" style="margin-top: -30px;"><input type="checkbox" class="form-checkbox mt-2" id="show2"> <label for="show2">Show password</label></small>
                            </div>
                        </div>
                    </div>
                </div>

                </div>


                </form>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="simpan_user">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>

  $(document).ready(function () {

      // dataTables user
      var tabel_user = $('#tabel_user').DataTable({
          "processing"        : true,
          "serverSide"        : true,
          "order"             : [],
          "ajax"              : {
              "url"   : "<?= base_url("man_user/tampil_user") ?>",
              "type"  : "POST"
          },
          "columnDefs"        : [{
              "targets"   : [0,5],
              "orderable" : false
          }]

      })

        // linked combobox
        $('#loading_jabatan').hide();
        $('#loading_nama').hide();
        $('#loading_reg').hide();

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
                    $('#nm_pegawai').html(data.pegawai);
                    $('#reg_emp').val(data.reg_emp);
                },
                error 		: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })

        $('#jabatan').on('change', function () {
            var id_jabatan      = $(this).val();
            var id_unit_kerja   = $('#unit_kerja').val();

            console.log(id_jabatan);

            $('#nm_pegawai').next('.select2-container').hide();
            $('#loading_nama').show();

            $.ajax({
                url         : "<?= base_url('man_user/ambil_nama_pegawai') ?>",
                type        : "POST",
                beforeSend 	: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charshet=UTF-8");
                    }				
                },
                data        : {id_jabatan:id_jabatan, id_unit_kerja:id_unit_kerja},
                dataType    : "JSON",
                success     : function (data) {
                    $('#loading_nama').hide();
                    $('#nm_pegawai').next('.select2-container').show();
                    $('#nm_pegawai').html(data.pegawai);
                },
                error 		: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })

        $('#nm_pegawai').on('change', function () {
            var id_data_pegawai = $(this).val();

            $('#reg_emp').next('.select2-container').hide();
            $('#loading_reg').show();

            $.ajax({
                url         : "<?= base_url('man_user/ambil_reg_emp') ?>",
                type        : "POST",
                beforeSend 	: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charshet=UTF-8");
                    }				
                },
                data        : {id_data_pegawai:id_data_pegawai},
                dataType    : "JSON",
                success     : function (data) {
                    $('#loading_reg').hide();
                    $('#reg_emp').next('.select2-container').show();
                    $('#reg_emp').val(data.reg_emp);
                },
                error 		: function (xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            })
        })

        $('.form-checkbox').click(function(){
            if($(this).is(':checked')){
                $('.password').attr('type','text');
            }else{
                $('.password').attr('type','password');
            }
        });
        
      $('#tambah_data').on('click', function () {

          $('#modal_user').modal('show');

          $('#form_user').trigger("reset");

          $('#unit_kerja').select2("val", ' ');
          $('#jabatan').select2("val", ' ');
          $('#nm_pegawai').select2("val", ' ');

          $('.modal-title').text('Tambah User');

          $('#aksi').val('Tambah');

          $('.mark_pass').text('Harap Catat Pasword Anda!!');

          $('#form-tambah').removeAttr('hidden');
          $('#form-edit').attr('hidden', true);
      })

      // aksi simpan user
      $('#simpan_user').on('click', function () {
          
          var form_user = $('#form_user').serialize();

          var aksi      = $('#aksi').val();

          if ($('#nm_pegawai').val() == '') {
              swal({
                    title               : "Peringatan",
                    text                : 'Nama Pegawai harus terisi!',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-danger",
                    type                : 'warning'
                }); 

              return false;

          } else if ($('#username').val() == '') {
              swal({
                    title               : "Peringatan",
                    text                : 'Username harus terisi!',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-danger",
                    type                : 'warning'
                }); 

              return false;

          } else if ($('#password').val() == '') {
              swal({
                    title               : "Peringatan",
                    text                : 'Password harus terisi!',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-danger",
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
                        url         : "<?= base_url('man_user/aksi_user') ?>",
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
                        data        : form_user,
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_user.ajax.reload(null, false);

                              swal({
                                  title               : aksi+' User',
                                  text                : 'Data Berhasil Disimpan',
                                  buttonsStyling      : false,
                                  confirmButtonClass  : "btn btn-success",
                                  type                : 'success'
                              }); 
                            
                            $('#modal_user').modal('hide');
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
                          text                : 'Anda membatalkan '+aksi.toLowerCase()+' user',
                          buttonsStyling      : false,
                          confirmButtonClass  : "btn btn-info",
                          type                : 'error'
                      }); 
                }
            })

          }

      })

      // aksi edit user
      $('#tabel_user').on('click', '.edit-user', function () {
           var id_data_user = $(this).data('id');

           console.log(id_data_user);

           $.ajax({
              url : "<?php echo base_url('man_user/ambil_data_user')?>/"+id_data_user,
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

                  $('#id_data_user').val(data.id_data_user);
                  $('#unit_kerja_edit').val(data.unit_kerja);
                  $('#jabatan_edit').val(data.jabatan);
                  $('#nm_pegawai_edit').val(data.nm_pegawai);
                  $('#reg_emp_edit').val(data.reg_emp);
                  $('#username_edit').val(data.username);
                  $('#id_data_pegawai').val(data.id_data_pegawai);

                  $('#modal_user').modal('show');
                  $('#form-edit').removeAttr('hidden');
                  $('#form-tambah').attr('hidden', true);
                  $('.modal-title').text('Edit User');
                  $('#aksi').val('Edit');

                  $('.mark_pass').text('Isi password bila ingin ganti password !!');
       
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
           })        
      })

      // hapus user
      $('#tabel_user').on('click', '.hapus-user', function () {
          
          var id_data_user = $(this).data('id');

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
                        url         : "<?= base_url('man_user/aksi_user') ?>",
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
                        data        : {aksi:'hapus', id_data_user:id_data_user},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_user.ajax.reload(null, false);

                              swal({
                                  title               : 'Hapus User',
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
                          text                : 'Anda membatalkan hapus user',
                          buttonsStyling      : false,
                          confirmButtonClass  : "btn btn-info",
                          type                : 'error'
                      }); 
                }
            })

      })
      
  })

</script>