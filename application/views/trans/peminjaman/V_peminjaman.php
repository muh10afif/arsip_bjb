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
            <table class="table table-bordered table-hover" id="tabel_peminjaman" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Instansi Peminjam</th>
                        <th>Unit Kerja Pemilik</th>
                        <th>Kode Masalah</th>
                        <th>Peminjaman</th>
                        <th>Kode Berkas</th>
                        <th>Judul Berkas</th>
                        <th>Status</th>
                        <th width="13%">Aksi</th>
                        <th>Dokumen</th>
                        <th>Pemgembalian</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- modal peminjaman -->
<div id="modal_peminjaman" class="modal fade" role="dialog" aria-labelledby="vcenter" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="vcenter">Tambah Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            
            <div class="modal-body">

                <form id="form_peminjaman" autocomplete="off" method="post">

                <input type="hidden" id="id_peminjaman" name="id_peminjaman">
                <input type="hidden" id="aksi" name="aksi" value="Tambah">

                <div class="row d-flex justify-content-center mt-3 mb-3">
                    
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Instansi Peminjam</label>
                            <div class="col-md-9">
                                <input type="text" name="instansi_peminjam" id="instansi_peminjam" class="form-control" placeholder="Masukkan Instansi Peminjam">
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
                            <label class="col-md-3 control-label col-form-label">Kode Masalah</label>
                            <div class="col-md-9">
                                
                                <select name="kode_masalah" id="kode_masalah" placeholder="Pilih Kode Masalah" data-allow-clear="1">
                                    
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Jenis Berkas</label>
                            <div class="col-md-9">
                                
                                <select name="jenis_berkas" id="jenis_berkas" placeholder="Pilih Jenis Berkas" data-allow-clear="1">
                                    
                                </select>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Kode Berkas</label>
                            <div class="col-md-9">
                                <select name="kode_berkas" id="kode_berkas" placeholder="Pilih Kode Berkas" data-allow-clear="1">
                                    
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Nomor Dokumen</label>
                            <div class="col-md-9">
                                <input type="text" name="no_dokumen" id="no_dokumen" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row">
                            <label class="col-md-3 control-label col-form-label">Judul Berkas</label>
                            <div class="col-md-9">
                                <input type="text" name="judul_berkas" id="judul_berkas" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row durasi">
                            <label class="col-md-3 control-label col-form-label">Durasi Peminjaman</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input type="number" class="form-control" name="durasi" id="durasi" placeholder="Masukkan Durasi Peminjaman">
                                    <div class="input-group-append">
                                        <span class="input-group-text">Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="id_pengarsipan" id="id_pengarsipan">
                    <div class="col-md-10 mt-3">
                        <div class="row surat_peminjaman">
                            <label class="col-md-3 control-label col-form-label">Surat Peminjaman</label>
                            <div class="col-md-9">
                                
                                <input type="file" name="surat_peminjam" id="surat_peminjam" accept="application/pdf" class="form-control mb-2">
                                <mark id="ket_upload">Upload file bertipe .pdf !</mark>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 mt-3">
                        <div class="row identitas_peminjam">
                            <label class="col-md-3 control-label col-form-label">Identitas Peminjam</label>
                            <div class="col-md-9">
                                
                                <input type="file" name="identitas_peminjam" id="identitas_peminjam" accept="application/pdf" class="form-control mb-2">
                                <mark id="ket_upload">Upload file bertipe .pdf !</mark>

                            </div>
                        </div>
                    </div>
                </div>

                </form>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="simpan_peminjaman">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>

  $(document).ready(function () {

      // dataTables peminjaman
      var tabel_peminjaman = $('#tabel_peminjaman').DataTable({
          "processing"        : true,
          "serverSide"        : true,
          "order"             : [],
          "ajax"              : {
              "url"   : "<?= base_url("trans/tampil_peminjaman") ?>",
              "type"  : "POST"
          },
          "columnDefs"        : [{
              "targets"   : [0,7,8,9,10],
              "orderable" : false
          }]

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
                    $('.surat_peminjaman').attr('hidden', true);
                    $('.identitas_peminjam').attr('hidden', true);
                    $('.durasi').removeAttr('hidden');
                } else {
                    $('.surat_peminjaman').removeAttr('hidden');
                    $('.identitas_peminjam').removeAttr('hidden');
                    $('.durasi').attr('hidden', true);
                }

            }
        })

        return false;

      })

      $('#unit_kerja').change(function () {
          
        var id_unit_kerja = $(this).val();

        $.ajax({
            url         : "<?= base_url('trans/ambil_kode_masalah') ?>",
            type        : "POST",
            beforeSend 	: function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charshet=UTF-8");
                }				
            },
            data        : {id_unit_kerja:id_unit_kerja},
            dataType    : "JSON",
            success     : function (data) {
                $('#kode_masalah').html(data.kode_masalah);
                $('#jenis_berkas').html("");
                $('#kode_berkas').html("");
                $('#no_dokumen').val('');
                $('#judul_berkas').val('');
            },
            error 		: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })

      })

      $('#kode_masalah').change(function () {
          
        var id_unit_kerja   = $('#unit_kerja').val();
        var id_kode_masalah = $(this).val();

        $.ajax({
            url         : "<?= base_url('trans/ambil_id_jenis_berkas') ?>",
            type        : "POST",
            beforeSend 	: function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charshet=UTF-8");
                }				
            },
            data        : {id_kode_masalah:id_kode_masalah, id_unit_kerja:id_unit_kerja},
            dataType    : "JSON",
            success     : function (data) {
                $('#jenis_berkas').html(data.jenis_berkas);
                $('#kode_berkas').html("");
                $('#no_dokumen').val('');
                $('#judul_berkas').val('');
            },
            error 		: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })

      })

      $('#jenis_berkas').change(function () {
          
        var id_kode_masalah = $('#kode_masalah').val();
        var id_unit_kerja   = $('#unit_kerja').val();
        var id_jenis_berkas = $(this).val();

        $.ajax({
            url         : "<?= base_url('trans/ambil_id_kode_berkas') ?>",
            type        : "POST",
            beforeSend 	: function (e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charshet=UTF-8");
                }				
            },
            data        : {id_jenis_berkas:id_jenis_berkas, id_kode_masalah:id_kode_masalah, id_unit_kerja:id_unit_kerja},
            dataType    : "JSON",
            success     : function (data) {
                $('#kode_berkas').html(data.kode_berkas);
                $('#no_dokumen').val('');
                $('#judul_berkas').val('');
            },
            error 		: function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        })

      })

      $('#kode_berkas').change(function () {
          
          var id_kode_berkas = $('#kode_berkas').val();
  
          $.ajax({
              url         : "<?= base_url('trans/ambil_data_dari_kode_berkas') ?>",
              type        : "POST",
              beforeSend 	: function (e) {
                  if (e && e.overrideMimeType) {
                      e.overrideMimeType("application/json;charshet=UTF-8");
                  }				
              },
              data        : {kode_berkas:id_kode_berkas},
              dataType    : "JSON",
              success     : function (data) {
                  $('#no_dokumen').val(data.no_dokumen);
                  $('#judul_berkas').val(data.judul_berkas);
                  $('#id_pengarsipan').val(data.id_pengarsipan);
              },
              error 		: function (xhr, ajaxOptions, thrownError) {
                  alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
              }
          })
  
        })

        $('#durasi').on('change', function () {
            var durasi = $(this).val();

            if (durasi > 11) {
                swal({
                    title               : 'Peringatan',
                    html                : 'Durasi peminjaman harus kurang dari <br> atau sama dengan <b>11 hari</b>',
                    buttonsStyling      : false,
                    confirmButtonClass  : "btn btn-info",
                    type                : 'warning'
                });

                $(this).val('');

                return false;
            }
        })

        $('#tabel_peminjaman').on('click', '.pengembalian', function () {
            
            var id_peminjaman   = $(this).data('id');

            swal({
                title       : 'Konfirmasi',
                text        : 'Yakin data ini sudah dikembalikan',
                type        : 'warning',

                buttonsStyling      : false,
                confirmButtonClass  : "btn btn-primary",
                cancelButtonClass   : "btn btn-danger mr-3",

                showCancelButton    : true,
                confirmButtonText   : 'Ya',
                confirmButtonColor  : '#d33',
                cancelButtonColor   : '#3085d6',
                cancelButtonText    : 'Batal',
                reverseButtons      : true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url         : "<?= base_url('trans/aksi_peminjaman') ?>",
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
                        data        : {id_peminjaman:id_peminjaman, aksi:'dikembalikan'},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_peminjaman.ajax.reload(null, false);

                            swal({
                                title               : 'Pengembalian',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 800
                            }); 
                            
                            $('#modal_peminjaman').modal('hide');
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
                        text                : 'Anda membatalkan aksi',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-primary",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 800
                    }); 
                }
            })

        })

      $('#tambah_data').on('click', function () {
          // $("a[href='#profile']").tab('show');

          $('#modal_peminjaman').modal('show');

          $('#form_peminjaman').trigger("reset");

          $('.modal-title').text('Tambah Peminjaman');
          $('#aksi').val('Tambah');

        $('#unit_kerja').select2("val", ' ');
        $('#kode_masalah').select2("val", ' ');
        $('#jenis_berkas').select2("val", ' ');
        $('#kode_berkas').select2("val", ' ');

        $('.surat_peminjaman').removeAttr('hidden');
        $('.identitas_peminjam').removeAttr('hidden');
        $('.durasi').removeAttr('hidden');
      })

      // aksi simpan peminjaman
      $('#simpan_peminjaman').on('click', function () {
          
        var form_peminjaman = $('#form_peminjaman')[0];
        var formData        = new FormData(form_peminjaman);

        console.log(form_peminjaman);

        var aksi            = $('#aksi').val();

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
                    url         : "<?= base_url('trans/aksi_peminjaman') ?>",
                    method      : "POST",
                    data        : formData,
                    processData : false,
                    contentType : false,
                    cache       : false,
                    async       : false,
                    dataType    : "JSON",
                    success     : function (data) {

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
                        } else if (data.hasil == 'berhasil') {
                            tabel_peminjaman.ajax.reload(null, false);

                            swal({
                                title               : aksi+' Pengarsipan',
                                text                : 'Data Berhasil Disimpan',
                                buttonsStyling      : false,
                                confirmButtonClass  : "btn btn-success",
                                type                : 'success',
                                showConfirmButton   : false,
                                timer               : 1000
                            }); 

                            $('#modal_peminjaman').modal('hide');
                        } else {
                            tabel_peminjaman.ajax.reload(null, false);

                            $('#modal_peminjaman').modal('hide');
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
                        text                : 'Anda membatalkan '+aksi.toLowerCase()+' peminjaman',
                        buttonsStyling      : false,
                        confirmButtonClass  : "btn btn-info",
                        type                : 'error',
                        showConfirmButton   : false,
                        timer               : 1000
                    }); 
            }
        })

      })

      // aksi edit peminjaman
      $('#tabel_peminjaman').on('click', '.edit-peminjaman', function () {
           var id_peminjaman = $(this).data('id');

           console.log(id_peminjaman);

           $.ajax({
              url : "<?php echo base_url('trans/ambil_data_peminjaman')?>/"+id_peminjaman,
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

                  $('#id_peminjaman').val(data.id_peminjaman);
                  $('#nama').val(data.peminjaman);
                  $('#singkatan').val(data.singkatan);

                  $('#modal_peminjaman').modal('show');
                  $('.modal-title').text('Edit Peminjaman');
                  $('#aksi').val('Edit');
       
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  alert('Error get data from ajax');
              }
           })        
      })

      // hapus peminjaman
      $('#tabel_peminjaman').on('click', '.hapus-peminjaman', function () {
          
          var id_peminjaman = $(this).data('id');

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
                        url         : "<?= base_url('trans/aksi_peminjaman') ?>",
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
                        data        : {aksi:'hapus', id_peminjaman:id_peminjaman},
                        dataType    : "JSON",
                        success     : function (data) {

                            tabel_peminjaman.ajax.reload(null, false);

                              swal({
                                  title               : 'Hapus Peminjaman',
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
                          text                : 'Anda membatalkan hapus peminjaman',
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