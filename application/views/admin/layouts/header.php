        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <div class="nav toggle">
                  <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <nav class="nav navbar-nav">
                <ul class=" navbar-right">
                  <li class="nav-item dropdown open" style="padding-left: 15px;">
                 <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
    <?php if ($this->session->userdata('nm_lengkap')): ?>
        <?= $this->session->userdata('nm_lengkap') ?>
    <?php else: ?>
        Guest
    <?php endif; ?>
</a>
                    <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                      <?php if (!in_array($this->session->userdata('level'), ['Admin', 'Petugas'])): ?>
                      <a class="dropdown-item"  href=<?= site_url('user/user/profile/lihat/'.  $this->session->id_pengguna) ?>>Profile</a>
                      <?php endif; ?>
                      <a class="dropdown-item"  href=<?= site_url('admin/auth/out') ?>><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                    </div>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        <!-- /top navigation -->