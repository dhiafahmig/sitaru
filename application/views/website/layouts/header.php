

    
    <!-- Navbar Start -->
    <div class="container-fluid bg-white sticky-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-2 py-lg-0">
                <div class="navbar-brand">
                    <img class="img-fluid" src=<?=templates("img/kotabandarlampung.png",'website')?> alt="Logo">
                </div>
                <button type="button" class="navbar-toggler ms-auto me-0" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">			
                        <a href="<?= site_url('admin/leafletstandar') ?>" class="nav-item nav-link">Informasi Tata Ruang</a>
                    </div>
       			 <div class="nav-right text-center text-lg-right py-4 py-lg-0">
    			<?php if(!isset($this->session->level)) : ?>
        <!-- Jika belum login -->
        <a class="btn btn-dark rounded-pill" href="<?=site_url('admin')?>"><b>Login</b></a>
  			  <?php else : ?>
       		 <!-- Jika sudah login -->
       			 <a class="btn btn-dark rounded-pill" href="<?=site_url('admin')?>"><b><?= $this->session->userdata('nm_lengkap')?></b></a>
   			 <?php endif; ?>
</div>

            </nav>
        </div>
    </div>
    <!-- Navbar End -->
