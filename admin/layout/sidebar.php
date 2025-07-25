      <?php include '../layout/auth_check.php'; ?>
      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
              <a href="index.html" class="app-brand-link">
                  <span class="app-brand-logo demo">
                      <img src="../assets/img/icons/brands/pngwing.com.png" style="width: 3rem; height: 3rem;" alt="">
                  </span>
                  <span class="app-brand-text demo menu-text fw-bolder ms-2" style="font-family:'Dancing Script, cursive'" ;>My~Absen</span>
              </a>

              <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                  <i class="bx bx-chevron-left bx-sm align-middle"></i>
              </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
              <!-- Dashboard -->
              <li class="menu-item active">
                  <a href="index.php" class="menu-link">
                      <i class="menu-icon tf-icons bx bx-home-circle"></i>
                      <div data-i18n="Analytics">Dashboard</div>
                  </a>
              </li>

              <!-- Layouts -->
              <!-- <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <i class="menu-icon tf-icons bx bx-layout"></i>
                  <div data-i18n="Layouts">Layouts</div>
              </a>

              <ul class="menu-sub">
                  <li class="menu-item">
                      <a href="layouts-without-menu.html" class="menu-link">
                          <div data-i18n="Without menu">Without menu</div>
                      </a>
                  </li>
                  <li class="menu-item">
                      <a href="layouts-without-navbar.html" class="menu-link">
                          <div data-i18n="Without navbar">Without navbar</div>
                      </a>
                  </li>
                  <li class="menu-item">
                      <a href="layouts-container.html" class="menu-link">
                          <div data-i18n="Container">Container</div>
                      </a>
                  </li>
                  <li class="menu-item">
                      <a href="layouts-fluid.html" class="menu-link">
                          <div data-i18n="Fluid">Fluid</div>
                      </a>
                  </li>
                  <li class="menu-item">
                      <a href="layouts-blank.html" class="menu-link">
                          <div data-i18n="Blank">Blank</div>
                      </a>
                  </li>
              </ul>
          </li> -->
              <?php if ($_SESSION['NamaLevel'] == 1) : ?>
                  <li class="menu-header small text-uppercase">
                      <span class="menu-header-text">Data Admin</span>
                  </li>
                  <li class="menu-item">
                      <a href="../content/level.php" class="menu-link ">
                          <i class="menu-icon tf-icons bx bx-dock-top"></i>
                          <div data-i18n="Account Settings"> Level</div>
                      </a>
                  </li>
                  <li class="menu-item">
                      <a href="../content/pegawai.php" class="menu-link">
                          <i class="menu-icon tf-icons bx bx-box"></i>
                          <div data-i18n="User interface">Data pegawai</div>
                      </a>
                  </li>
                  <li class="menu-item">
                      <a href="../content/gaji.php" class="menu-link">
                          <i class="menu-icon tf-icons bx bx-lock-open-alt"></i>
                          <div data-i18n="Authentications" href="../content/gaji.php">Salery</div>
                      </a>

                  </li>
                  <li class="menu-item">
                      <a href="../content/dataCuti.php" class="menu-link">
                          <i class="menu-icon tf-icons bx bx-copy"></i>
                          <div data-i18n="Extended UI">Data Cuti pegawai</div>
                      </a>
                  </li>

              <?php endif ?>
              <!-- Components -->
              <?php if ($_SESSION['NamaLevel'] == 1 or $_SESSION['NamaLevel'] == 2) : ?>

                  <li class="menu-header small text-uppercase"><span class="menu-header-text">pegawai</span></li>
                  <!-- Cards -->
                  <li class="menu-item">
                      <a href="absensi.php" class="menu-link">
                          <i class="menu-icon tf-icons bx bx-collection"></i>
                          <div data-i18n="Basic">Absensi</div>
                      </a>
                  </li>
                  <!-- User interface -->


                  <!-- Extended components -->
                  <li class="menu-item">

                      <ul class="menu-sub">
                          <li class="menu-item">
                              <a href="extended-ui-perfect-scrollbar.html" class="menu-link">
                                  <div data-i18n="Perfect Scrollbar">Perfect scrollbar</div>
                              </a>
                          </li>
                          <li class="menu-item">
                              <a href="extended-ui-text-divider.html" class="menu-link">
                                  <div data-i18n="Text Divider">Text Divider</div>
                              </a>
                          </li>
                      </ul>
                  </li>
              <?php endif ?>

              <li class="menu-item">
                  <a href="shifting.php" class="menu-link">
                      <i class="menu-icon tf-icons bx bx-crown"></i>
                      <div data-i18n="Boxicons">shifting</div>
                  </a>
              </li>

              <!-- Forms & Tables -->
              <!-- <li class="menu-header small text-uppercase"><span class="menu-header-text">Forms &amp; Tables</span></li> -->
              <!-- Forms -->
              <!-- <li class="menu-item">
                  <a href="javascript:void(0);" class="menu-link">
                      <i class="menu-icon tf-icons bx bx-detail"></i>
                      <div data-i18n="Form Elements">Form Elements</div>
                  </a>
                  <ul class="menu-sub">
                      <li class="menu-item">
                          <a href="forms-basic-inputs.html" class="menu-link">
                              <div data-i18n="Basic Inputs">Basic Inputs</div>
                          </a>
                      </li>
                      <li class="menu-item">
                          <a href="forms-input-groups.html" class="menu-link">
                              <div data-i18n="Input groups">Input groups</div>
                          </a>
                      </li>
                  </ul>
              </li>
              <li class="menu-item">
                  <a href="javascript:void(0);" class="menu-link menu-toggle">
                      <i class="menu-icon tf-icons bx bx-detail"></i>
                      <div data-i18n="Form Layouts">Form Layouts</div>
                  </a>
                  <ul class="menu-sub">
                      <li class="menu-item">
                          <a href="form-layouts-vertical.html" class="menu-link">
                              <div data-i18n="Vertical Form">Vertical Form</div>
                          </a>
                      </li>
                      <li class="menu-item">
                          <a href="form-layouts-horizontal.html" class="menu-link">
                              <div data-i18n="Horizontal Form">Horizontal Form</div>
                          </a>
                      </li>
                  </ul>
              </li> -->
              <!-- Tables -->
              <li class="menu-item">
                  <a href="tables-basic.html" class="menu-link">
                      <i class="menu-icon tf-icons bx bx-table"></i>
                      <div data-i18n="Tables">Tables</div>
                  </a>
              </li>
              <!-- Misc -->
              <li class="menu-header small text-uppercase"><span class="menu-header-text">Tools & Properti</span></li>
              <li class="menu-item">
                  <a
                      href="https://themewagon.com/"
                      target="_blank"
                      class="menu-link">
                      <i class="menu-icon tf-icons bx bx-support"></i>
                      <div data-i18n="Support">Support</div>
                  </a>
              </li>
              <li class="menu-item">
                  <a
                      href="https://getbootstrap.com/"
                      target="_blank"
                      class="menu-link">
                      <i class="menu-icon tf-icons bx bx-file"></i>
                      <div data-i18n="Documentation">Documentation</div>
                  </a>
              </li>
          </ul>
      </aside>