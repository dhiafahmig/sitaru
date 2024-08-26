 <div class="col-md-3 left_col">
 	<div class="left_col scroll-view">
 		<div class="navbar nav_title" style="border: 0;">
 			<a href="/" class="site_title"><i class="fa fa-map"></i> <span>SIMTARU </span></a>
 		</div>

 		<div class="clearfix"></div>

 		<!-- menu profile quick info -->
 		<div class="profile clearfix">
 			<div class="profile_pic">
 				<img src="<?= templates('production/images/img.jpg') ?>" alt="..." class="img-circle profile_img">
 			</div>
 			<div class="profile_info">
 				<span><?= $this->session->nm_pengguna ?></span>
 				<h2><?= $this->session->level ?></h2>
 			</div>
 			<div class="clearfix"></div>
 		</div>
 		<!-- /menu profile quick info -->

 		<br />

 		<!-- sidebar menu -->
 		<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
 			<div class="menu_section">
 				<ul class="nav side-menu">
					<!-- ///Admin -->
					<?php if ($this->session->level == 'Admin') { ?>
						<li><a href="<?= site_url('admin/') ?>"><i class="fa fa-home"></i> Beranda</a></li>
 					<?php } ?>


 					<?php if ($this->session->level == 'Admin') { ?>
 						<li><a><i class="fa fa-folder"></i> Master Data <span class="fa fa-chevron-down"></span></a>
 							<ul class="nav child_menu">
 								<li><a href="<?= site_url('admin/kecamatan') ?>">Pola Ruang</a></li>
 								<li><a href="<?= site_url('admin/hotspot') ?>">Hotspot</a></li>
 								<li><a href="<?= site_url('admin/kategorihotspot') ?>">Kategori Hotspot</a></li>
								<li><a href="<?= site_url('admin/petugas') ?>">Petugas</a></li>
								<li><a href="<?= site_url('admin/masyarakat') ?>">Masyarakat</a></li>
								
 							</ul>
 						</li>
 					<?php } ?>
					<!-- ///Petugas -->
					<?php if ($this->session->level == 'Petugas') { ?>
						<li><a href="<?= site_url('admin/') ?>"><i class="fa fa-home"></i> Beranda</a></li>
 					<?php } ?>


 					<?php if ($this->session->level == 'Petugas') { ?>
 						<li><a><i class="fa fa-folder"></i> Master Data <span class="fa fa-chevron-down"></span></a>
 							<ul class="nav child_menu">
 								<li><a href="<?= site_url('admin/kecamatan') ?>">Pola Ruang</a></li>
 								<li><a href="<?= site_url('admin/hotspot') ?>">Hotspot</a></li>
 								<li><a href="<?= site_url('admin/kategorihotspot') ?>">Kategori Hotspot</a></li>
								<li><a href="<?= site_url('admin/leafletroutingmachine') ?>">Hotspot Point</a></li>
 							</ul>
 						</li>
 					<?php } ?>
					
					
					<!-- //User -->
					<?php if ($this->session->level == 'User') { ?>
						<!-- <li><a href="<?= site_url('user/') ?>"><i class="fa fa-home"></i> Beranda</a></li> -->
 						<li><a><i class="fa fa-tags"></i> Layanan Pengaduan <span class="fa fa-chevron-down"></span></a>
  							<ul class="nav child_menu">
							<li><a href="<?= site_url('user/hotspot') ?>">Hotspot</a></li>
 							</ul>
 						</li>
 					<?php } ?>
					<!-- ///Maps -->
 					<li><a><i class="fa fa-map"></i> Maps <span class="fa fa-chevron-down"></span></a>
 						<ul class="nav child_menu">
							<?php if ($this->session->level == 'Admin') { ?>
							<li><a href="<?= site_url('admin/leafletroutingmachine') ?>">Hotspot Point</a></li>
							<?php } ?>
 							<li><a href="<?= site_url('admin/leafletstandar') ?>">Pola Ruang</a></li>
 						</ul>
 					</li>
 				</ul>
 			</div>
 		</div>
 		<!-- /sidebar menu -->
 	</div>
 </div>
