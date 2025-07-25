<?php

include '../database/koneksi.php';
include '../layout/encryp.php';
session_start();

$sqlLevel = mysqli_query($koneksi, "SELECT * FROM level ");

// query delet level 

if (isset($_POST['tambah'])) {
    $nama_level = $_POST['nama_level'];

    $query = mysqli_query($koneksi, "INSERT INTO level (nama_level) values ('$nama_level')");
    if ($query) {
        header("Location: level.php?add_level");
    } else {
        echo "Gagal menambah data";
        echo mysqli_error($koneksi);
    }
}

//query edit level
$id = isset($_GET['edit']) ? decryptId($_GET['edit'], $key) : '';
$queryEditLevel = mysqli_query($koneksi, "SELECT * FROM level WHERE id ='$id'");
$rowEditLevel = mysqli_fetch_assoc($queryEditLevel);

if (isset($_POST['edit'])) {
    $nama_level = $_POST['nama_level'];

    $query = mysqli_query($koneksi, "UPDATE level SET nama_level = '$nama_level' WHERE id = '$id'");
    if ($query) {
        header("Location: level.php?edited");
    } else {
        echo "Gagal mengedit data";
        echo mysqli_error($koneksi);
    }
}

if (isset($_GET['delete'])) {
    $id = decryptId($_GET['delete'], $key);

    $delete = mysqli_query($koneksi, "DELETE FROM level  WHERE id ='$id'");
    header("Location: level.php?deleted=$id");
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <?php include '../layout/head.php' ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Sidebar -->
            <?php include '../layout/sidebar.php' ?>
            <!-- End of Sidebar -->

            <!-- Content Wrapper -->
            <div class="layout-page">

                <!-- Main Content -->
                <!-- Navbar Topbar-posittion -->
                <?php include '../layout/navbar.php' ?>
                <!-- End of Topbar-posittion -->

                <!-- Begin Page Content -->
                <!-- Content wrapper -->

                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row">
                            <?php if (isset($_GET['add-level']) || isset($_GET['edit'])): ?>
                                <div class="col-md-6 offset-3" style="height: 100vh;">
                                    <div class="card mt-5">
                                        <div class="card-header"><?php echo (isset($_GET['edit']) ? 'edit' : 'tambah') ?> Level</div>
                                        <div class="card-body">
                                            <form action="" method="post">
                                                <div class="my-3">
                                                    <label for="">Nama Level</label>
                                                    <input type="text" name="nama_level" class="form-control" id="nama_level" value="<?php echo (isset($_GET['edit']) ? $rowEditLevel['nama_level'] : '') ?>" required>
                                                    <button type="submit" class="mt-3 btn-primary" name="<?php echo (isset($_GET['edit']) ? 'edit' : 'tambah') ?>">Tambah</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="col-md-12 text-center">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <a href="#">Data Level pegawai</a>
                                            <a class="btn-sm btn-primary" href="level.php?add-level">Tambah Level</a>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>Nomor</td>
                                                            <td>Nama Level</td>
                                                            <td>alat</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1;
                                                        while ($resultLevel = mysqli_fetch_assoc($sqlLevel)) {
                                                            $encrypt = encryptId($resultLevel['id'], $key); ?>
                                                            <tr>
                                                                <td><?php echo $no++ ?></td>
                                                                <td><?php echo $resultLevel['nama_level'] ?></td>
                                                                <td>
                                                                    <a class="btn-sm btn-success" href="level.php?edit=<?php echo urlencode($encrypt) ?>">Edit Level</a>
                                                                    <a href="level.php?delete=<?php echo urlencode($encrypt) ?>" class="btn-sm btn-danger">Delete</a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                        <div class="row">
                            <!-- Order Statistics -->

                            <!--/ Order Statistics -->

                            <!-- Expense Overview -->

                            <!--/ Expense Overview -->

                            <!-- Transactions -->

                            <!--/ Transactions -->
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    <?php include '../layout/footer.php' ?>
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <div class="buy-now">
        <a
            href="https://themeselection.com/products/sneat-bootstrap-html-admin-template/"
            target="_blank"
            class="btn btn-success btn-buy-now-new">My~Absen</a>
    </div>

    <?php
    $alert = [
        "add_level" => "Data Berhasil Ditambahkan",
        "edited" => "Data Berhasil Diedit!",
        "deleted" => "Data Berhasil Dihapus!",
    ];

    foreach ($alert as $val => $message) {
        if (isset($_GET[$val])) {
            echo "
            <script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: '$message',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'level.php';
                });
            </script>
            ";
            break;
        }
    }
    ?>


</body>

</html>