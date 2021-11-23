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

                        <div class="card mb-4" id="kartu" style="background-color: rgba(0,0,0,0);">
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
                                                <th>Level</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          <?php $no=1; foreach ($level as $lev): ?>
                                          <tr>
                                              <td class="w-">
                                                  <?php echo $no.'.' ?>
                                              </td>
                                              <td class="w-25">
                                                  <?php echo $lev->kode_level ?>
                                              </td>
                                              <td class="w-50">
                                                  <?php echo $lev->nama_level ?>
                                              </td>
                                              <td class="w-50">
                                                  <a value="<?= $lev->id_data_level?>"class="btn btn-small edit"><i class="fas fa-edit"></i> Edit</a>
                                                  <a value="<?= site_url('man_user/deleteLevel/'.$lev->id_data_level) ?>"  class="btn btn-small text-danger hps"><i class="fas fa-trash"></i> Delete</a>
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
                        <h5 class="modal-title" id="staticBackdropLabel">Tambah Level</h5>
                        <button tabindex="-1" type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">

                        <form>

                            <div class="form-group">
                                <label class="small mb-1" for="kodeLevel">Kode Level</label>
                                <input class="form-control" id="kodeLevel" name="kodeLevel" type="text" />
                                <div class="invalid-feedback" id="invalid-kodeLevel">
                                  Silahkan isi kolom Kode Level
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="small mb-1" for="namaLevel">Nama Level</label>
                                <input class="form-control" id="namaLevel" name="namaLevel" type="text" />
                                <div class="invalid-feedback" id="invalid-namaLevel">
                                  Silahkan isi kolom Nama Level
                                </div>
                            </div>

                        </form>

                      </div>
                      <div class="modal-footer" id="divBTN">
                        <button type="button" id="tambah" class="btn btn-primary">Simpan Data</button>
                        <button type="button" id="editBTN" class="btn btn-primary" hidden>Update Data</button>
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

              //TAMBAH START
              $('#tambah').on('click', function(){
                $('#namaLevel').val();
                $('#kodeLevel').val();
                $.ajax({
                  type:"POST",
                  url:"<?= base_url() ?>man_user/addLevel",
                  data:{
                    kodeLevel : $('#kodeLevel').val(),
                    namaLevel : $('#namaLevel').val(),
                        },
                  success:function (data) {
                    if (data == 'The Kode Level field is required.\nThe Nama Level field is required.\n') {

                      $('#kodeLevel').addClass('is-invalid');
                      $('#namaLevel').addClass('is-invalid');
                      $('#kodeLevel').focus();

                    }else if (data == 'The Kode Level field is required.\n') {

                      fieldReq('kodeLevel');

                    }else if (data == 'The Nama Level field is required.\n') {

                      fieldReq('namaLevel');

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
                  url : "getLevel/"+href,
                  dataType: 'json',
                  success: function(res){
                    var inp_id = '<input type="text" name="id" id="id" value="'+res.id_data_level+'" hidden>';
                    var inp_date = '<input type="text" name="date" id="date" value="'+res.add_time+'" hidden>';

                    $('#staticBackdropLabel').html('Edit Level '+res.kode_level);
                    $('form').append(inp_id);
                    $('form').append(inp_date);
                    $('#kodeLevel').val(res.kode_level);
                    $('#namaLevel').val(res.nama_level);
                    $('#tambah').attr('hidden','true');
                    $('#editBTN').removeAttr('hidden');
                    
                    $('#staticBackdrop').modal();


                    //RESET MODAL BA'DA DITUTUP
                    $('#staticBackdrop').on('hidden.bs.modal', function (e) {

                      $('#staticBackdropLabel').html('Tambah Level');
                      $('#kodeLevel').val("");
                      $('#namaLevel').val("");
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
                  url:"<?= base_url() ?>man_user/editLevel",
                  data:{
                    kodeLevel : $('#kodeLevel').val(),
                    namaLevel : $('#namaLevel').val(),
                    id        : $('#id').val(),
                    date      : $('#date').val()
                        },
                  success:function (data) {
                    if (data == 'The Kode Level field is required.\nThe Nama Level field is required.\n') {

                      $('#kodeLevel').addClass('is-invalid');
                      $('#namaLevel').addClass('is-invalid');
                      $('#kodeLevel').focus();

                    }else if (data == 'The Kode Level field is required.\n') {

                      fieldReq('kodeLevel');

                    }else if (data == 'The Nama Level field is required.\n') {

                      fieldReq('namaLevel');

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

              onInput('kodeLevel');
              onInput('namaLevel');

            });
        </script>

    </body>
</html>
