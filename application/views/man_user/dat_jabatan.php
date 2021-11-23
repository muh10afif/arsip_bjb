<?php $this->load->view('layout/head'); ?>
    <body class="sb-nav-fixed">
<?php $this->load->view('layout/topbar'); ?>
        <div id="layoutSidenav">
<?php $this->load->view('layout/sidenav'); ?>

            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <ol class="breadcrumb bg-transparent mt-4">
                          <?php $i=0; foreach ($breadcrumb as $bc): ?>
                            <li class="breadcrumb-item active"><?= $bclink[$i] ?><?=  $bc ?></a></li>
                          <?php $i++; endforeach ?>
                        </ol>
                        <div class="card mb-4" style="background-color: rgba(0,0,0,0);">
                            <div class="card-header">
                                <button class="btn btn-primary" id="tbh" type="button" data-toggle="modal" data-target="#staticBackdrop"><i class="fas fa-plus mr-1"></i>Tambah Data</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered bg-light" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Kode</th>
                                                <th>Jabatan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php $no=1; foreach ($jabatan as $jab): ?>
                                          <tr>
                                              <td class="w-">
                                                  <?php echo $no.'.' ?>
                                              </td>
                                              <td class="w-25">
                                                  <?php echo $jab->kode_jabatan ?>
                                              </td>
                                              <td class="w-50">
                                                  <?php echo $jab->nama_jabatan ?>
                                              </td>
                                              <td class="w-50">
                                                  <a value="<?= $jab->id_data_jabatan?>"class="btn btn-small edit"><i class="fas fa-edit"></i> Edit</a>
                                                  <a value="<?= site_url('man_user/deleteJabatan/'.$jab->id_data_jabatan) ?>"  class="btn btn-small text-danger hps"><i class="fas fa-trash"></i> Delete</a>
                                              </td>
                                          </tr>
                                          <?php $no+=1; endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                <!-- Modal Input -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Jabatan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">

                        <form>

                          <div class="row mb-3" id="form_select">
                            <div class="col py-">
                              <label class="small mb-1" for="selectUnit">Unit Kerja</label>
                                <div class="invalid-feedback" id="invalid-tambahUnit">
                                  Silahkan isi kolom  Unit Kerja
                                </div>
                              
                              <select name="selectUnit" id="selectUnit" class="custom-select">
                                <option value="">-pilih-</option>
                                <?php $no=1; foreach ($unit as $un): ?>
                                  <option value="<?= $un->id_unit_kerja ?>"><?= $un->unit_kerja ?></option>
                                <?php $no+=1; endforeach; ?>
                              </select>
                                <div class="invalid-feedback" id="invalid-selectUnit">
                                  Silahkan isi kolom  Unit Kerja
                                </div>
                            </div>
                            <div id="tb" class="col- mt-4 mr-3">
                              <button type="button" id="btUnit" class="btn btn-primary">
                                  Tambah Unit
                              </button>
                            </div>
                          </div>


                          <div id="form_add" hidden="true">
                            <div class="form-group">
                                <label class="small mb-1" for="kodejabatan">Unit Kerja</label>
                                <input class="form-control" id="tambahUnit" type="text" />
                                <div class="invalid-feedback" id="invalid-kodeJabatan">
                                  Silahkan isi kolom Kode Jabatan
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="small mb-1" for="tambahLokasiUnit">Lokasi Unit</label>
                                <input class="form-control" id="tambahLokasiUnit" type="text" />
                                <div class="invalid-feedback" id="invalid-tambahLokasiUnit">
                                  Silahkan isi kolom Lokasi Unit
                                </div>
                            </div>
                          </div>

                            <div class="form-group">
                                <label class="small mb-1" for="kodejabatan">Kode Jabatan</label>
                                <input class="form-control" id="kodeJabatan" type="text" />
                                <div class="invalid-feedback" id="invalid-kodeJabatan">
                                  Silahkan isi kolom Kode Jabatan
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="small mb-1" for="namaJabatan">Nama Jabatan</label>
                                <input class="form-control" id="namaJabatan" type="text" />
                                <div class="invalid-feedback" id="invalid-namaJabatan">
                                  Silahkan isi kolom Nama Jabatan
                                </div>
                            </div>

                        </form>

                      </div>
                      <div class="modal-footer">
                        <button type="button" id="tambah" class="btn btn-primary">Simpan Data</button>
                        <button type="button" id="editBTN" class="btn btn-primary" hidden />Update Data</button>
                      </div>
                    </div>
                  </div>
                </div>

<?php $this->load->view('layout/footer'); ?>

            </div>
        </div>

<?php $this->load->view('layout/bottom'); ?>

        <script type="text/javascript" charset="utf-8" async defer>
            $(document).ready(function(){
              var select = true;

              $('#btUnit').on('click',function(){
                $('#form_select').attr('hidden','true');
                $('#form_add').removeAttr('hidden');
                select = false;
              });

              //TAMBAH START
              $('#tambah').on('click', function(){

                //TAMBAH (SELECT) END
                if (select) {
                $.ajax({
                  type:"POST",
                  url:"<?= base_url() ?>man_user/addJabatan",
                  data:{
                    selectUnit : $('#selectUnit').val(),
                    kodeJabatan : $('#kodeJabatan').val(),
                    namaJabatan : $('#namaJabatan').val(),
                        },
                  success:function (data) {

                    if (data.includes("Kode") && data.includes("Nama") && data.includes("Unit")) {

                      $('#selectUnit').addClass('is-invalid');
                      $('#kodeJabatan').addClass('is-invalid');
                      $('#namaJabatan').addClass('is-invalid');
                      $('#selectUnit').focus();

                    }else if (data.includes("Kode")) {
                      fieldReq('kodeJabatan');
                    }else if (data.includes("Nama")) {
                      fieldReq('namaJabatan');
                    }else if (data.includes("Unit")) {
                      fieldReq('selectUnit');
                    }else if (data == 'Sukses') {

                      //FUNGSI BERHASIL
                      swal({
                        title: "Data Tersimpan!",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1000
                      }, function(){
                        swal.close();
                        $('#staticBackdrop').modal('hide');
                        location.reload();
                      });
                    }else{
                      console.log(data);
                    }
                  }
                  });
                }
                //TAMBAH (SELECT) END

                //TAMBAH (INPUT) START
                else{

                }
              });
              //TAMBAH END

              //HAPUS START
              $('.hps').click(function(event){
                  var href = $(this).attr("value");
                  var row = this;

                  swal({
                      title: 'Are you sure want to Delete data?',
                      text: "It can't be undone",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6',
                      cancelButtonColor: '#d33',
                      confirmButtonText: 'Delete'

                  },function () {
                      $.ajax({
                        type: "GET",
                        url: href,
                        success: function(response) {
                          console.log(response);
                          if (response == "Success")
                          {
                              $(row).closest('tr').fadeOut("slow");
                              swal({
                                  title: "Deleted a row of data!",
                                  type: "success",
                                  showConfirmButton: false,
                                  timer: 800
                              },function(){
                                  // container.load('users');
                              setTimeout(function(){ location.reload(); }, 500);
                              });
                          }
                          else
                          {
                            alert("Error");
                          }

                        }
                      });
                  });
              });
              //HAPUS END

              $('.edit').on('click',function(){
                var href = $(this).attr("value");
                $.ajax({
                  type : "POST",
                  url : "getJabatan/"+href,
                  dataType: 'json',
                  success: function(res){
                    var inp_id = '<input type="text" name="id" id="id" value="'+res.id_data_jabatan+'" hidden>';
                    var inp_date = '<input type="text" name="date" id="date" value="'+res.add_time+'" hidden>';

                    $('#staticBackdropLabel').html('Edit Jabatan '+res.nama_jabatan);
                    $('form').append(inp_id);
                    $('form').append(inp_date);
                    $('#selectUnit').val(res.id_unit_kerja);
                    $('#kodeJabatan').val(res.kode_jabatan);
                    $('#namaJabatan').val(res.nama_jabatan);
                    $('#tambah').attr('hidden','true');
                    $('#editBTN').removeAttr('hidden');
                    
                    $('#staticBackdrop').modal();


                    //RESET MODAL BA'DA DITUTUP
                    $('#staticBackdrop').on('hidden.bs.modal', function (e) {

                      $('#staticBackdropLabel').html('Tambah Level');
                      $('#kodeJabatan').val("");
                      $('#namaJabatan').val("");
                      $('#editBTN').attr('hidden','true');
                      $('#tambah').removeAttr('hidden');
                    
                    })

                  }
                });
              });

              //EDIT START
              $('#editBTN').on('click', function(){
                $.ajax({
                  type:"POST",
                  url:"<?= base_url() ?>man_user/editJabatan",
                  data:{
                    selectUnit : $('#selectUnit').val(),
                    kodeJabatan : $('#kodeJabatan').val(),
                    namaJabatan : $('#namaJabatan').val(),
                    id        : $('#id').val(),
                    date      : $('#date').val()
                        },
                  success:function (data) {
                    if (data.includes("Kode") && data.includes("Nama") && data.includes("Unit")) {

                      $('#selectUnit').addClass('is-invalid');
                      $('#kodeJabatan').addClass('is-invalid');
                      $('#namaJabatan').addClass('is-invalid');
                      $('#selectUnit').focus();

                    }else if (data.includes("Kode")) {
                      fieldReq('kodeJabatan');
                    }else if (data.includes("Nama")) {
                      fieldReq('namaJabatan');
                    }else if (data.includes("Unit")) {
                      fieldReq('selectUnit');
                    }else if (data == 'Sukses') {

                      //FUNGSI BERHASIL
                      swal({
                        title: "Data Diupdate!",
                        type: "success",
                        showConfirmButton: false,
                        timer: 1000
                      }, function(){
                        swal.close();
                        $('#staticBackdrop').modal('hide');
                        location.reload();
                      });
                    }else{
                      console.log(data);
                    }
                  }
                  });
              });
              // EDIT END

              onInput('selectUnit');
              onInput('kodeJabatan');
              onInput('namaJabatan');

            });
        </script>

    </body>
</html>
