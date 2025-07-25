<?php

include '../database/koneksi.php';
include '../layout/encryp.php';
session_start();

$sqlSalery = mysqli_query($koneksi, "SELECT user.*, shifting.* FROM shifting LEFT JOIN user on shifting.id_pegawai = user.id");

$listJadwal = [];
while ($rowJadwal = mysqli_fetch_assoc($sqlSalery)) {
    $listJadwal[] = $rowJadwal;
}
// print_r($listJadwal);
// die();

foreach ($listJadwal as $key) {
    $date1 = new DateTime($key['tgl_mulai']);
    $date2 = new DateTime($key['tgl_selesai']);
}

$lamaKerja = $date1->diff($date2);
$jumlahHariKerja = $lamaKerja->days + 1;

$gajiPerhari = 200000;
$totalGaji = $gajiPerhari * $jumlahHariKerja;
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
                            <?php if (isset($_GET['add-gaji']) || isset($_GET['edit'])): ?>

                            <?php else : ?>
                                <div class="col-md-12 text-center">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <a href="#">Data gaji pegawai</a>
                                            <!-- <a class="btn-sm btn-primary" href="gaji.php?add-gaji">Tambah gaji</a> -->
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>Nomor</td>
                                                            <td>NIP</td>
                                                            <td>Nama Pegawai</td>
                                                            <td>Shift</td>
                                                            <td>Tanggal Masuk</td>
                                                            <td>Tanggal Selesai</td>
                                                            <td>Gaji / Hari</td>
                                                            <td>Hari kerja</td>
                                                            <td>Total Gaji</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1;
                                                        foreach ($listJadwal as $resultSalery) { ?>
                                                            <tr>
                                                                <td><?php echo $no++ ?></td>
                                                                <td><?php echo $resultSalery['nip'] ?></td>
                                                                <td><?php echo $resultSalery['nama_lengkap'] ?></td>
                                                                <td><?php echo $resultSalery['nama_shift'] ?></td>
                                                                <td><?php echo $resultSalery['tgl_mulai'] ?></td>
                                                                <td><?php echo $resultSalery['tgl_selesai'] ?></td>
                                                                <td><?php echo number_format($gajiPerhari, 0, '' . '') ?></td>
                                                                <td><?php echo $jumlahHariKerja ?></td>
                                                                <td><?php echo number_format($totalGaji, 0, '' . '') ?></td>
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
        "add_gaji" => "Data Berhasil Ditambahkan",
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
                    window.location.href = 'gaji.php';
                });
            </script>
            ";
            break;
        }
    }
    ?>


</body>

</html>