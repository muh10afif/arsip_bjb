<!DOCTYPE html>
<html lang="en">
    <head>
        
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content=""/>
        <meta name="author" content="" />
        <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('')?>dist/assets/img/logo.png">
        <title><?= (!empty($title)) ? $title.' |' : ' ' ?> Arsip BJB</title>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <?php $this->load->view('layout/css'); ?>
    </head>

    <body class="sb-nav-fixed">

        <?php $this->load->view('layout/topbar'); ?>

            <div id="layoutSidenav">
                <?php $this->load->view('layout/sidenav'); ?>

                <div id="layoutSidenav_content">
                    <main>
                        <div class="container-fluid">

                            <?= $konten ?>

                        </div>
                    </main>

                    <?php $this->load->view('layout/footer'); ?>
                </div>
            
            </div>

        <?php $this->load->view('layout/bottom'); ?>

    </body>

</html>


