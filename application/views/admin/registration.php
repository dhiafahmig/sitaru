<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?=$title?> </title>

    <!-- Bootstrap -->
    <link href="<?=templates('vendors/bootstrap/dist/css/bootstrap.min.css')?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?=templates('vendors/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?=templates('vendors/nprogress/nprogress.css')?>" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?=templates('vendors/animate.css/animate.min.css')?>" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?=templates('build/css/custom.min.css')?>" rel="stylesheet">
    <style type="text/css">
      body{
        background-image: url('<?=assets('images/background.jpg')?>');
        background-size: cover;
        background-repeat: no-repeat;
        height: 100vh;
        width: 100%;
        top: 0
      }
      .login_wrapper{
        margin-top: 0
      }
      .form-login{
        background: #fffe;
        margin: 30px;
        padding: 30px
      }
    </style>
  </head>

  <body class="d-flex align-items-center justify-content-center">
        <div class="col-md-6 col-sm-6 col-12">
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-9">
              <div class="animate form-login">
                <section class="">
                  <form action="<?=site_url('admin/auth/registration')?>" method="POST">
                    <h2 class="text-danger"><i class="fa fa-map-marker"></i> Daftar!</h2>
                    <?=$this->session->flashdata('info')?>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" placeholder="Email" name="email" required="" />
                    </div>
					<div class="form-group">
                      <label>Nama Lengkap</label>
                      <input type="text" class="form-control" placeholder="Nama" name="nm_lengkap" required="" />
                    </div>
					<div class="form-group">
                      <label>NIK</label>
                      <input type="text" class="form-control" placeholder="NIK" name="nik" required="" />
                    </div>
					<div class="form-group">
                      <label>Tanggal Lahir</label>
                      <input type="date" class="form-control" name="tgl_lahir" required="" />
                    </div>
					 <div class="form-group">
        <label for="jns_kelamin">Jenis Kelamin</label>
        <select class="form-control" id="jns_kelamin" name="jns_kelamin">
            <option value="">Pilih Jenis Kelamin</option>
            <option value="Laki-Laki">Laki-Laki</option>
            <option value="Perempuan">Perempuan</option>
        </select>
        <?= form_error('jns_kelamin', '<small class="text-danger pl-3">', '</small>'); ?>
    </div>
                    <div class="form-group">
                      <label>Password</label>
                      <input type="password" class="form-control" placeholder="Password" name="kt_sandi" required="" />
                    </div>
                      <button type="submit" class="btn btn-primary btn-block submit">Daftar</button>
                    </div>
					<a class="registration" href="<?=site_url('admin/auth')?>">Sudah punya akun</a>
                    <div class="clearfix"></div>
                  </form>
                </section>
              </div>
            </div>
          </div>
          
        </div>
  </body>
</html>
