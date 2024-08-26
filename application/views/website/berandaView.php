 <!-- Carousel Start -->
    <div class="container-fluid px-0 mb-5">
        <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src=<?=templates("img/kota.jpg",'website')?> alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-7 text-center">
                                    <p class="fs-4 text-white animated zoomIn"> <strong class="text-dark">Selamat Datang di</strong></p>
                                    <h1 class="display-1 text-dark mb-4 animated zoomIn">Layanan Pengaduan</h1>
                                  <?php if ($this->session->userdata('logged')): ?>
    <a href="/user/hotspot/form/tambah" class="btn btn-light rounded-pill py-3 px-5 animated zoomIn"><b>Laporkan</b></a>
<?php else: ?>
    <a href="<?= site_url('admin/auth') ?>" class="btn btn-light rounded-pill py-3 px-5 animated zoomIn"><b>Laporkan</b></a>
<?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- About Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-6 text-end">
                            <img class="img-fluid bg-white w-100 mb-3 wow fadeIn" data-wow-delay="0.1s" src=<?=templates("img/faq1.jpg",'website')?> alt="">
							<img class="img-fluid bg-white w-50 mb-3 wow fadeIn" data-wow-delay="0.3s"src=<?=templates("img/kota.jpg",'website')?>  alt="">
                        </div>
                        <div class="col-6">
                            <img class="img-fluid bg-white w-50 mb-3 wow fadeIn" data-wow-delay="0.3s"src=<?=templates("img/faq3.jpg",'website')?>  alt="">
                            <img class="img-fluid bg-white w-100 wow fadeIn" data-wow-delay="0.4s" src=<?=templates("img/faq2.jpg",'website')?>  alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="section-title">
                        <p class="fs-5 fw-medium fst-italic text-primary">Tentang Kami</p>
                    </div>
                    <div class="row g-3 mb-6">
                        <div class="col-sm-10">
                            <h5>Dinas Perumahan dan Permukiman</h5>
                            <p class="mb-0">Dinas Perumahan, Kawasan Permukiman dan Cipta Karya berawal dari Dinas Perumahan dan Kawasan Permukiman, dan pada saat terbitnya perda Nomor 4 tahun 2019 cakupan tugas Dinas menjadi lebih luas, dengan bergabungnya penataan ruang yang semula berada pada Dinas Pekerjaan Umum dan Penataan Ruang, Dinas ini mempunyai tugas menyelenggarakan sebagian urusan Pemerintahan Kota di bidang Perumahan dan Kawasan Permukiman.</p>
                        </div>
                    </div>
                    <div class="border-top mb-6"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->
