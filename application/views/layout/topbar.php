<nav class="sb-topnav navbar navbar-expand navbar-dark bg-white text-dark shadow">
    <a class="navbar-brand text-dark" href="<?= base_url() ?>dashboard"><h4 class="text-center font-weight">Arsip BJB</h4></a>
    <button class="btn btn-link text-dark btn-sm order-1 order-lg-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>
<div class="d-none d-md-inline-block form-inline ml-auto">
    <div class="float-center w-20 mx-lg-5">

        <img src="<?= base_url('')?>dist/assets/img/logo.svg" alt="" style="width:80px;height:80px;">
    </div>
</div>
    
    <div class="text-secondary text-right d-none d-md-inline-block form-inline ml-auto mr-0  my-md-0">
        <div class="row">
            <div class="col text-capitalize"><?= $this->session->userdata('username'); ?></div>
        </div>
        <div class="row">
            <div class="col">
                <small class="text-info "><?= $this->session->userdata('unit_kerja');?></small>
            </div>
        </div>
    </div>

    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link text-dark mt-3" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <h1><i class="fas fa-user-circle fa-fw mb-2"></i></h1>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?= base_url()?>login/logout">Logout</a>
            </div>
        </li>
    </ul>
</nav>