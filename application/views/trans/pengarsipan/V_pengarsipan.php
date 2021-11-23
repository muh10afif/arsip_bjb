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
            <table class="table table-bordered table-hover" id="tabel_pengarsipan" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Kode Masalah</th>
                        <th>Jenis Berkas</th>
                        <th>Kode Berkas</th>
                        <th>Judul Berkas</th>
                        <th>Status</th>
                        <th width="20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal pengarsipan -->
<div id="modal_pengarsipan" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="vcenter">Tambah Pengarsipan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">

                <form id="form_pengarsipan" autocomplete="off" method="post">

                <input type="hidden" id="id_pengarsipan" name="id_pengarsipan">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">

                <div class="row d-flex justify-content-center mt-3 mb-3">
                    <div class="col-md-10">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Kode Masalah</label>
                            <div class="col-md-9">
                                
                                <select name="kode_masalah" id="kode_masalah" placeholder="Pilih Kode Masalah" data-allow-clear="1">
                                    <?php foreach ($kode_masalah as $k): ?>
                                        <option value="<?= $k['id_kode_masalah'] ?>"><?= $k['masalah'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Jenis Berkas</label>
                            <div class="col-md-9">
                                
                                <select name="jenis_berkas" id="jenis_berkas" placeholder="Pilih Jenis Berkas" data-allow-clear="1">
                                    <?php foreach ($jenis_berkas as $k): ?>
                                        <option value="<?= $k['id_jenis_berkas'] ?>"><?= $k['jenis_berkas'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Sarana Penyimpanan</label>
                            <div class="col-md-9">
                                
                                <select name="sarana_penyimpanan" id="sarana_penyimpanan" placeholder="Pilih Sarana Penyimpanan" data-allow-clear="1">
                                    <?php foreach ($sarana_penyimpanan as $k): ?>
                                        <option value="<?= $k['id_sarana_penyimpanan'] ?>"><?= $k['sarana_penyimpanan'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Dokumen Unit</label>
                            <div class="col-md-9">
                                
                                <select name="dokumen_unit" id="dokumen_unit" placeholder="Pilih Dokumen Unit" data-allow-clear="1">
                                    <?php foreach ($dokumen_unit as $k): ?>
                                        <option value="<?= $k['id_dokumen_unit'] ?>"><?= $k['dokumen_unit'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Lemari Berkas</label>
                            <div class="col-md-9">
                                
                                <select name="lemari_berkas" id="lemari_berkas" placeholder="Pilih Lemari Berkas" data-allow-clear="1">
                                    <?php foreach ($lemari_berkas as $k): ?>
                                        <option value="<?= $k['id_lemari_berkas'] ?>"><?= $k['lemari_berkas'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Rak Arsip</label>
                            <div class="col-md-9">
                                
                                <select name="rak_arsip" id="rak_arsip" placeholder="Pilih Rak Arsip" data-allow-clear="1">
                                    <?php foreach ($rak_arsip as $k): ?>
                                        <option value="<?= $k['id_rak_arsip'] ?>"><?= $k['rak_arsip'] ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Kode Berkas</label>
                            <div class="col-md-9">
                                <input type="text" name="kode_berkas" id="kode_berkas" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Nomor Dokumen</label>
                            <div class="col-md-9">
                                <input type="text" name="no_dokumen" id="no_dokumen" class="form-control" placeholder="Masukkan Nomor Dokumen">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Judul Berkas</label>
                            <div class="col-md-9">
                                <input type="text" name="judul_berkas" id="judul_berkas" class="form-control" placeholder="Masukkan Judul Berkas">
                            </div>
                        </div>
                    </div>
                    <?php $level = $this->session->userdata('level'); ?>

                    <?php if ($level == 1) : ?>
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
                    <?php endif; ?>

                    <div class="col-md-10 mt-3">
                        <div class="row upload-berkas" >
                            <label class="col-md-3 control-label col-form-label">Upload Berkas</label>
                            <div class="col-md-9">
                                
                                <input type="file" name="upload_berkas" id="upload_berkas" accept="application/pdf" class="form-control mb-2">
                                <mark id="ket_upload">Upload file bertipe .pdf !</mark>
                                <mark id="ket_upload_ganti" hidden>Input upload file jika ingin ganti dokumen !</mark>
                                

                            </div>
                        </div>
                    </div>
                </div>

                </form>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="simpan_pengarsipan">Simpan</button>
            </div>
        </div>
    </div>
</div>

<div id="modal_detail_arsip" class="modal fade border-info" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" id="detail_arsip">
            
        </div>
        <!-- /.modal-content -->
    </div>
</div>


<script>

  $(document).ready(function () {

      // dataTables pengarsipan
      var tabel_pengarsipan = $('#tabel_pengarsipan').DataTable({
          "processing"        : true,
          "serverSide"        : true,
          "order"             : [],
          "ajax"              : {
              "url"   : "<?= base_url("trans/tampil_pengarsipan") ?>",
              "type"  : "POST"
          },
          "columnDefs"        : [{
              "targets"   : [0,6],
              "orderable" : false
          }]

      })

      $('#tabel_pengarsipan').on('click', '.detail-pengarsipan', function () {
            var id_pengarsipan = $(this).data('id');

            $.ajax({
                url         : "<?= base_url('trans/tampil_detail_arsip') ?>",
                type        : "POST",
                beforeSend  : function () {
                    swal({
                        title   : 'Menunggu',
                        html    : 'Memproses data',
                        onOpen  : () => {
                            swal.showLoading();
                        }
                    })
                },
                data        : {id_pengarsipan:id_pengarsipan},
                success     : function (data) {
                    swal.close();

                    $('#modal_detail_arsip').modal('show');
                    $('#detail_arsip').html(data);
                }
            })
        })

      $('#jenis_berkas').on('change', function () {
          
          var id_jenis_berkas = $(this).val();

          console.log(id_jenis_berkas);

          $.ajax({
            url         : "<?= base_url('trans/ambil_status_scan') ?>",
            method      : "POST",
            data        : {id_jenis_berkas:id_jenis_berkas},
            dataType    : "JSON",
            success     : function (data) {

                if (data.scan == 0) {
                    $('.upload-berkas').attr('hidden', true);
                } else {
                    $('.upload-berkas').removeAttr('hidden');
                }

            }
        })

        return false;

      })

      $('#tambah_data').on('click', function () {

          $.ajax({
            url         : "<?= base_url('trans/tampil_kode_berkas') ?>",
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

                $('#modal_pengarsipan').modal('show');

                $('#form_pengarsipan').trigger("reset");

                $('.modal-title').text('Tambah Pengarsipan');
                $('#aksi').val('Tambah');

                $('#kode_berkas').val(data.kode_berkas);
                $('#unit_kerja').select2("val", ' ');
                $('#kode_masalah').select2("val", ' ');
                $('#dokumen_unit').select2("val", ' ');
                $('#jenis_berkas').select2("val", ' ');
                $('#sarana_penyimpanan').select2("val", ' ');
                $('#lemari_berkas').select2("val", ' ');
                $('#rak_arsip').select2("val", ' ');

                $('#ket_upload').removeAttr('hidden');
                $('#ket_upload_ganti').attr('hidden', true);

                $('.upload-berkas').removeAttr('hidden');

            }
        })

        return false;
      })

      // aksi simpan pengarsipan
      $('#simpan_pengarsipan').on('click', function () {
          
            var form_pengarsipan    = $('#form_pengarsipan')[0];
            var formData            = new FormData(form_pengarsipan);
            var aksi                = $('#aksi').val();

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
                    url         : "<?= base_url('trans/aksi_pengarsipan') ?>",
                    method      : "POST",
                    data        : formData,
                    processData : false,
                    contentType : false,
                    cache       : false,
                    async       : false,
                    dataType    : "JSON",
                    success     : function (data) {

                        tabel_pengarsipan.ajax.reload(null, false);

                        if (data.hasil == 0) {
                            swal({
                                title               : 'Upload Berkas',
                                text                : 'Data Tidak Berhasil Diupload',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-danger",
                                type                : 'error',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 

                            return false;
                        } else if (data.hasil == 1) {
                            swal({
                                title               : aksi+' Pengarsipan',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 

                            $('#modal_pengarsipan').modal('hide');
                        } else {
                            swal({
                                title               : aksi+' Pengarsipan',
                                text                : 'Data telah ada pada pengarsipan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-info",
                                type                : 'warning',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 

                            return false;
                        }
                        
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
                        text                : 'Anda membatalkan '+aksi.toLowerCase()+' pengarsipan',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 
            }
        })

      })

      // aksi edit pengarsipan
      $('#tabel_pengarsipan').on('click', '.edit-pengarsipan', function () {
           var id_pengarsipan = $(this).data('id');

           console.log(id_pengarsipan);

           $.ajax({
              url : "<?php echo base_url('trans/ambil_data_pengarsipan')?>/"+id_pengarsipan,
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

                    // $kode_masalah           = $this->input->post('kode_masalah');
                    // $jenis_berkas           = $this->input->post('jenis_berkas');
                    // $sarana_penyimpanan     = $this->input->post('sarana_penyimpanan');
                    // $dokumen_unit           = $this->input->post('dokumen_unit');
                    // $lemari_berkas          = $this->input->post('lemari_berkas');
                    // $rak_arsip              = $this->input->post('rak_arsip');
                    // $unit_kerja             = $this->input->post('unit_kerja');
                    // $kode_berkas            = $this->input->post('kode_berkas');
                    // $no_dokumen             = $this->input->post('no_dokumen');
                    // $judul_berkas           = $this->input->post('judul_berkas');
                    // $id_pengarsipan         = $this->input->post('id_pengarsipan');
                    // $aksi                   = $this->input->post('aksi');

                  $('#id_pengarsipan').val(data.id_pengarsipan);
                  $('#kode_masalah').select2("val", data.id_kode_masalah);
                  $('#jenis_berkas').select2("val", data.id_jenis_berkas);
                  $('#sarana_penyimpanan').select2("val", data.id_sarana_penyimpanan);
                  $('#dokumen_unit').select2("val", data.id_dokumen_unit);
                  $('#lemari_berkas').select2("val", data.id_lemari_berkas);
                  $('#rak_arsip').select2("val", data.id_rak_arsip);
                  $('#unit_kerja').select2("val", data.id_unit_kerja);
                  $('#kode_berkas').val(data.kode_berkas);
                  $('#no_dokumen').val(data.no_dokumen);
                  $('#judul_berkas').val(data.judul_berkas);

                  $('#ket_upload_ganti').removeAttr('hidden');
                  $('#ket_upload').attr('hidden', true);

                  $('#modal_pengarsipan').modal('show');
                  $('.modal-title').text('Edit Pengarsipan');
                  $('#aksi').val('Edit');
       
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
           })        
      })

      // hapus pengarsipan
      $('#tabel_pengarsipan').on('click', '.hapus-pengarsipan', function () {
          
          var id_pengarsipan = $(this).data('id');

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
                        url         : "<?= base_url('trans/aksi_pengarsipan') ?>",
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
                        data        : {aksi:'hapus', id_pengarsipan:id_pengarsipan},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_pengarsipan.ajax.reload(null, false);

                              swal({
                                  title               : 'Hapus Pengarsipan',
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
                          text                : 'Anda membatalkan hapus pengarsipan',
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