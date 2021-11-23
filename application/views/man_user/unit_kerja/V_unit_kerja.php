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
            <table class="table table-bordered table-hover" id="tabel_unit_kerja" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Unit Kerja</th>
                        <th>Nama Unit Kerja</th>
                        <th>Lokasi</th>
                        <th>Level</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal unit_kerja -->
<div id="modal_unit_kerja" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="vcenter">Tambah Unit Kerja</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">

                <form id="form_unit_kerja" autocomplete="off">

                <input type="hidden" id="id_unit_kerja" name="id_unit_kerja">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">

                <div class="row d-flex justify-content-center mt-3 mb-3">
                    <div class="col-md-10">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Kode Unit Kerja</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="kode_unit_kerja" id="kode_unit_kerja" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Nama Unit Kerja</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="nama_unit_kerja" name="nama_unit_kerja" placeholder="Masukkan Nama Unit Kerja">
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
                </div>

                </form>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="simpan_unit_kerja">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>

  $(document).ready(function () {

      // dataTables unit_kerja
      var tabel_unit_kerja = $('#tabel_unit_kerja').DataTable({
          "processing"        : true,
          "serverSide"        : true,
          "order"             : [],
          "ajax"              : {
              "url"   : "<?= base_url("man_user/tampil_unit_kerja") ?>",
              "type"  : "POST"
          },
          "columnDefs"        : [{
              "targets"   : [0,5],
              "orderable" : false
          }]

      })

    $('#tambah_data').on('click', function () {

        $.ajax({
            url         : "<?= base_url('man_user/tampil_kode_unit_kerja') ?>",
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

                $('#modal_unit_kerja').modal('show');

                $('#form_unit_kerja').trigger("reset");

                $('#kode_unit_kerja').val(data.kode_unit_kerja);

                $('.modal-title').text('Tambah Unit Kerja');
                $('#aksi').val('Tambah');

                $('#level').select2("val", ' ');

            }
        })

        return false;
    })

      // aksi simpan unit_kerja
      $('#simpan_unit_kerja').on('click', function () {
          
          var form_uk = $('#form_unit_kerja').serialize();

          var aksi    = $('#aksi').val();

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
                    url         : "<?= base_url('man_user/aksi_unit_kerja') ?>",
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
                    data        : form_uk,
                    dataType    : "JSON",
                    success     : function (data) {

                        tabel_unit_kerja.ajax.reload(null, false);

                            swal({
                                title               : aksi+' Unit Kerja',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 
                        
                        $('#modal_unit_kerja').modal('hide');
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
                        text                : 'Anda membatalkan '+aksi.toLowerCase()+' unit_kerja',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 
            }
        })

      })

      // aksi edit unit_kerja
      $('#tabel_unit_kerja').on('click', '.edit-unit-kerja', function () {
           var id_unit_kerja = $(this).data('id');

           console.log(id_unit_kerja);

           $.ajax({
              url : "<?php echo base_url('man_user/ambil_data_unit_kerja')?>/"+id_unit_kerja,
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

                  $('#id_unit_kerja').val(data.id_unit_kerja);
                  $('#nama_unit_kerja').val(data.unit_kerja);
                  $('#lokasi').val(data.lokasi);
                  $('#kode_unit_kerja').val(data.kode_unit_kerja);
                  $('#level').select2("val", data.id_data_level);


                  $('#modal_unit_kerja').modal('show');
                  $('.modal-title').text('Edit Unit Kerja');
                  $('#aksi').val('Edit');
       
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
           })        
      })

      // hapus unit_kerja
      $('#tabel_unit_kerja').on('click', '.hapus-unit-kerja', function () {
          
          var id_unit_kerja = $(this).data('id');

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
                        url         : "<?= base_url('man_user/aksi_unit_kerja') ?>",
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
                        data        : {aksi:'hapus', id_unit_kerja:id_unit_kerja},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_unit_kerja.ajax.reload(null, false);

                              swal({
                                  title               : 'Hapus Unit Kerja',
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
                          text                : 'Anda membatalkan hapus unit_kerja',
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