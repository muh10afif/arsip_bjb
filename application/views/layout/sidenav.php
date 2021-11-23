
<style type="text/css">
    .a .aktif {
        /*background-color: #418afa;*/
        background: linear-gradient(to right, #3366ff 0%, #99ccff 100%);
        color: white;
        box-shadow: 2px 0.5px rgb(71, 142, 255);
        border-radius: 7px;
        margin-left: 0px;
        margin-top: 5px;
        width: 97%;
    }
    .aktif:hover{
        color: white;
    }
    .nav-link {
        color: black;
    }
    .a .nav-link:hover{
      background: #fff;
      color: #26425E;
      box-shadow: 2px 1px 1px 1px rgb(71, 142, 255);
      border-radius: 2px;
      margin-left: 10px;
    }
</style>
<div id="layoutSidenav_nav" class="p-2 text-dark">
    <nav class="sb-sidenav accordion text-dark my-3" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav bg-white rounded a shadow">
                <a class="nav-link <?= ($title == 'Dashboard') ? 'aktif' : '' ?>" href="<?= base_url('')?>dashboard"><div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard</a>

                <a class="nav-link text-dark <?= ($title == 'Data Level' || $title == 'Data Jabatan' || $title == 'Data Pegawai' || $title == 'Data User' || $title == 'Data Unit Kerja') ? 'collapse' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"
                    ><div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Manajemen User
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                ></a>

                <?php $level = $this->session->userdata('level'); ?>

                <?php if ($level == 1) : ?>
                    <div class="collapse <?= ($title == 'Data Level' || $title == 'Data Jabatan' || $title == 'Data Pegawai' || $title == 'Data User' || $title == 'Data Unit Kerja') ? 'show' : '' ?>" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav a">
                            <a class="nav-link <?= ($title == 'Data Level') ? 'aktif' : '' ?>" href="<?= base_url('')?>man_user/level">Data Level</a>
                            <a class="nav-link <?= ($title == 'Data Jabatan') ? 'aktif' : '' ?>" href="<?= base_url('')?>man_user/jabatan">Data Jabatan</a>
                            <a class="nav-link <?= ($title == 'Data Pegawai') ? 'aktif' : '' ?>" href="<?= base_url('')?>man_user/pegawai">Data Pegawai</a>
                            <a class="nav-link <?= ($title == 'Data User') ? 'aktif' : '' ?>" href="<?= base_url('')?>man_user/user">Data User</a>
                            <a class="nav-link <?= ($title == 'Data Unit Kerja') ? 'aktif' : '' ?>" href="<?= base_url('')?>man_user/unit_kerja">Data Unit Kerja</a>
                        </nav>
                    </div>
                <?php elseif($level == 2) : ?>
                    <div class="collapse <?= ($title == 'Data Level' || $title == 'Data Jabatan' || $title == 'Data Pegawai' || $title == 'Data User' || $title == 'Data Unit Kerja') ? 'show' : '' ?>" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav a">
                            <a class="nav-link <?= ($title == 'Data Jabatan') ? 'aktif' : '' ?>" href="<?= base_url('')?>man_user/jabatan">Data Jabatan</a>
                            <a class="nav-link <?= ($title == 'Data Pegawai') ? 'aktif' : '' ?>" href="<?= base_url('')?>man_user/pegawai">Data Pegawai</a>
                            <a class="nav-link <?= ($title == 'Data User') ? 'aktif' : '' ?>" href="<?= base_url('')?>man_user/user">Data User</a>
                        </nav>
                    </div>
                <?php endif; ?>
            

                <a class="nav-link text-dark <?= ($title == 'Kode Masalah' || $title == 'Jenis Berkas' || $title == 'Sarana Penyimpanan' || $title == 'Dokumen Unit' || $title == 'Gudang Arsip' || $title == 'Lemari Berkas' || $title == 'Rak Arsip') ? 'collapse' : 'collapsed' ?>" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages"
                    ><div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                    Master Kearsipan
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div
                ></a>
                <div class="collapse <?= ($title == 'Kode Masalah' || $title == 'Jenis Berkas' || $title == 'Sarana Penyimpanan' || $title == 'Dokumen Unit' || $title == 'Gudang Arsip' || $title == 'Lemari Berkas' || $title == 'Rak Arsip') ? 'show' : '' ?>" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion a" id="sidenavAccordionPages">
                        <a class="nav-link <?= ($title == 'Kode Masalah') ? 'aktif' : '' ?>" href="<?= base_url('')?>master_kearsipan/kode_masalah">Kode Masalah</a>
                        <a class="nav-link <?= ($title == 'Jenis Berkas') ? 'aktif' : '' ?>" href="<?= base_url('')?>master_kearsipan/jenis_berkas">Jenis Berkas</a>
                        <a class="nav-link <?= ($title == 'Sarana Penyimpanan') ? 'aktif' : '' ?>" href="<?= base_url('')?>master_kearsipan/sarana_penyimpanan">Sarana Penyimpanan</a>
                        <a class="nav-link <?= ($title == 'Dokumen Unit') ? 'aktif' : '' ?>" href="<?= base_url('')?>master_kearsipan/dok_unit">Dokumen Unit</a>
                        <a class="nav-link <?= ($title == 'Gudang Arsip') ? 'aktif' : '' ?>" href="<?= base_url('')?>master_kearsipan/gudang_arsip">Gudang Arsip</a>
                        <a class="nav-link <?= ($title == 'Lemari Berkas') ? 'aktif' : '' ?>" href="<?= base_url('')?>master_kearsipan/lemari_berkas">Lemari Berkas</a>
                        <a class="nav-link <?= ($title == 'Rak Arsip') ? 'aktif' : '' ?>" href="<?= base_url('')?>master_kearsipan/rak_arsip">Rak Arsip</a>
                    </nav>
                </div>

                <?php if ($level == 1) : ?>
                    <a class="nav-link <?= ($title == 'Data Pengarsipan') ? 'aktif' : '' ?>" href="<?= base_url('')?>trans/pengarsipan">
                        <div class="sb-nav-link-icon"><i class="fas fa-edit"></i></div>
                        Pengarsipan
                    </a>
                    <a class="nav-link <?= ($title == 'Data Peminjaman') ? 'aktif' : '' ?>" href="<?= base_url('')?>trans/peminjaman">
                        <div class="sb-nav-link-icon"><i class="fas fa-upload"></i></div>
                        Peminjaman
                    </a>
                    <a class="nav-link <?= ($title == 'Data Penyiangan') ? 'aktif' : '' ?>" href="<?= base_url('')?>trans/penyiangan">
                        <div class="sb-nav-link-icon"><i class="fas fa-filter"></i></div>
                        Penyiangan
                    </a>
                    <a class="nav-link <?= ($title == 'Data Pemusnahan') ? 'aktif' : '' ?>" href="<?= base_url('')?>trans/pemusnahan">
                        <div class="sb-nav-link-icon"><i class="fas fa-trash-alt"></i></div>
                        Pemusnahan
                    </a>
                    <a class="nav-link <?= ($title == 'Data Pelaporan') ? 'aktif' : '' ?>" href="<?= base_url('')?>trans/pelaporan">
                        <div class="sb-nav-link-icon"><i class="fas fa-file-archive"></i></div>
                        Pelaporan
                    </a>
                <?php elseif($level == 2) : ?>
                    <a class="nav-link <?= ($title == 'Data Pengarsipan') ? 'aktif' : '' ?>" href="<?= base_url('')?>trans/pengarsipan">
                        <div class="sb-nav-link-icon"><i class="fas fa-edit"></i></div>
                        Pengarsipan
                    </a>
                    <a class="nav-link <?= ($title == 'Data Peminjaman') ? 'aktif' : '' ?>" href="<?= base_url('')?>trans/peminjaman">
                        <div class="sb-nav-link-icon"><i class="fas fa-upload"></i></div>
                        Peminjaman
                    </a>
                <?php endif; ?>
                
                

            </div>
        </div>
    </nav>
</div>