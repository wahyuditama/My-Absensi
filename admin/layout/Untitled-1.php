<?php if ($_SESSION['NamaLevel'] == 1) : ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Data Admin</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Admin Akses</h6>
                <a class="collapse-item" href="../content/level.php"> Level</a>
                <a class="collapse-item" href="../content/level.php">Tambah Level</a>
                <a class="collapse-item" href="../content/add-user.php">Tambah Pengguna</a>
            </div>
        </div>
    </li>
<?php endif ?>

<!-- Pimpinan -->
<?php if ($_SESSION['NamaLevel'] == 1 or $_SESSION['NamaLevel'] == 6) : ?>
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
            aria-controls="collapsePages">
            <!-- <i class="fas fa-fw fa-wrench"></i> -->
            <i class="fas fa-fw fa-folder"></i>
            <span>pegawai</span>
        </a>
        <div id="collapsePages" class="collapse show" aria-labelledby="headingPages"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"></h6>
                <a class="collapse-item" href="../content/pegawai.php">Data pegawai</a>
                <a class="collapse-item" href="../content/dataCuti.php">Data Cuti pegawai</a>

            </div>
        </div>
    </li>
<?php endif ?>
<!-- Nav Item - Utilities Collapse Menu -->

<?php if ($_SESSION['NamaLevel'] == 1 or ($_SESSION['NamaLevel']) == 4) : ?>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <!-- <i class="fas fa-fw fa-wrench"></i> -->
            <i class='bx bx-user'></i>
            <span>
                Menu
            </span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header"></h6>

                <a class="collapse-item" href="../html/Brand.php">Brand Utilities</a>
                <a class="collapse-item" href="../html/suggestion.php">suggestions</a>
            </div>
        </div>
    </li>
<?php endif; ?>