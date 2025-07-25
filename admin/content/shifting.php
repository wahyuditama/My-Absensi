<?php

include '../database/koneksi.php';
include '../layout/encryp.php';
session_start();

$sqlshifting = mysqli_query($koneksi, "SELECT user.id,user.nama_lengkap, shifting.* FROM shifting LEFT JOIN user ON shifting.id_pegawai = user.id");

$queryShifting = mysqli_query($koneksi, "SELECT * FROM user");
$listShifting = [];
while ($shifting = mysqli_fetch_assoc($queryShifting)) {
    $listShifting[] = $shifting;
}

// query delet shifting 

if (isset($_POST['tambah'])) {
    $idPegawai = $_POST['id_pegawai'];
    $nama_shifting = $_POST['nama_shifting'];
    $jamMasuk = $_POST['jam_masuk'];
    $jamKeluar = $_POST['jam_keluar'];
    $tanggalMulai = $_POST['tgl_mulai'];
    $tanggalSelesai = $_POST['tgl_selesai'];
    $ket = $_POST['keterangan'];

    $query = mysqli_query($koneksi, "INSERT INTO shifting (id_pegawai,nama_shift,jam_masuk,jam_keluar,tgl_mulai,tgl_selesai,keterangan) values ('$idPegawai','$nama_shifting','$jamMasuk','$jamKeluar','$tanggalMulai','$tanggalSelesai','$ket')");
    if ($query) {
        header("Location: shifting.php?add_shifting");
    } else {
        echo "Gagal menambah data";
        echo mysqli_error($koneksi);
    }
}

//query edit shifting
$id = isset($_GET['edit']) ? decryptId($_GET['edit'], $key) : '';
$queryEditshifting = mysqli_query($koneksi, "SELECT * FROM shifting WHERE id ='$id'");
$rowEditshifting = mysqli_fetch_assoc($queryEditshifting);

if (isset($_POST['edit'])) {
    $nama_shifting = $_POST['nama_shifting'];
    $jamMasuk = $_POST['jam_masuk'];
    $jamKeluar = $_POST['jam_keluar'];
    $tanggalMulai = $_POST['tgl_mulai'];
    $tanggalSelesai = $_POST['tgl_selesai'];
    $ket = $_POST['keterangan'];

    $query = mysqli_query($koneksi, "UPDATE shifting SET 
    nama_shift= '$nama_shifting',
    jam_masuk = '$jamMasuk',
    jam_keluar = '$jamKeluar',
    tgl_mulai = '$tanggalMulai',
    tgl_selesai = '$tanggalSelesai',
    keterangan = '$ket'
    WHERE id = '$id'");
    if ($query) {
        header("Location: shifting.php?edited");
    } else {
        echo "Gagal mengedit data";
        echo mysqli_error($koneksi);
    }
}

if (isset($_GET['delete'])) {
    $id = decryptId($_GET['delete'], $key);

    $delete = mysqli_query($koneksi, "DELETE FROM shifting  WHERE id ='$id'");
    header("Location: shifting.php?deleted=$id");
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

                    <div class="container-xl flex-grow-1 container-p-y">
                        <div class="row">
                            <?php if (isset($_GET['add-shifting']) || isset($_GET['edit'])): ?>
                                <div class="col-sm-12">
                                    <div class="card mt-5">
                                        <div class="card-header"><?php echo (isset($_GET['edit']) ? 'edit' : 'tambah') ?> shifting</div>
                                        <hr>
                                        <div class="card-body">
                                            <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="my-3">
                                                            <label for="">Nama Pegawai</label>
                                                            <select name="id_pegawai" id="" class="form-control">
                                                                <?php foreach ($listShifting as $key) : ?>
                                                                    <option value="<?= $key['id'] ?>" <?= (isset($rowEditshifting['id_pegawai']) && $rowEditshifting['id_pegawai'] == $key['id']) ? 'selected' : '' ?>>
                                                                        <?= $key['nama_lengkap'] . " - " . $key['nip'] ?>
                                                                    </option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                        <div class="my-3">
                                                            <label for="">Nama shifting</label>
                                                            <input type="text" class="form-control" name="nama_shifting" placeholder="Masukan Jenis Shift" value="<?= isset($_GET['edit']) ? $rowEditshifting['nama_shift'] : '' ?>">
                                                        </div>
                                                        <div class="my-3">
                                                            <label for="">Jam Masuk</label>
                                                            <input type="time" class="form-control" name="jam_masuk" placeholder="Masukan Jenis Shift" value="<?= isset($_GET['edit']) ? $rowEditshifting['jam_masuk'] : '' ?>">
                                                        </div>
                                                        <div class="my-3">
                                                            <label for="">Jam Selesai</label>
                                                            <input type="Time" class="form-control" name="jam_keluar" placeholder="Masukan Jenis Shift" value="<?= isset($_GET['edit']) ? $rowEditshifting['jam_keluar'] : '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="my-3">
                                                            <label for="">Tanggal Mulai</label>
                                                            <input type="date" class="form-control" name="tgl_mulai" placeholder="Masukan Jenis Shift" value="<?= isset($_GET['edit']) ? $rowEditshifting['tgl_mulai'] : '' ?>">
                                                        </div>
                                                        <div class="my-3">
                                                            <label for="">Tanggal Selesai</label>
                                                            <input type="date" class="form-control" name="tgl_selesai" placeholder="Masukan Jenis Shift" value="<?= isset($_GET['edit']) ? $rowEditshifting['tgl_selesai'] : '' ?>">
                                                        </div>
                                                        <div class="my-3">
                                                            <label for="">keterangan</label>
                                                            <input type="test" class="form-control" name="keterangan" placeholder="Masukan Jenis Shift" value="<?= isset($_GET['edit']) ? $rowEditshifting['keterangan'] : '' ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="mt-3 btn-primary" name="<?php echo (isset($_GET['edit']) ? 'edit' : 'tambah') ?>"><?php echo (isset($_GET['edit'])) ? 'Edit' : 'tambah' ?></button>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="col-md-12 text-center">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <a href="#">Data shifting pegawai</a>
                                            <a class="btn-sm btn-primary" href="shifting.php?add-shifting">Tambah shifting</a>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>Nomor</td>
                                                            <td>Nama Lengkap</td>
                                                            <td>shifting</td>
                                                            <td>Jam Masuk</td>
                                                            <td>Jam Selesai</td>
                                                            <td>Tanggal Masuk</td>
                                                            <td>Tanggal Selesau</td>
                                                            <td>Keterangan</td>
                                                            <?php if ($_SESSION['NamaLevel'] == 1) : ?>
                                                                <td>alat</td>
                                                            <?php endif ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1;
                                                        while ($resultshifting = mysqli_fetch_assoc($sqlshifting)) {
                                                            $encrypt = encryptId($resultshifting['id'], $key); ?>
                                                            <?php
                                                            $time1 = new DateTime($resultshifting['jam_masuk']);
                                                            $time2 = new DateTime($resultshifting['jam_keluar']);
                                                            $diff = $time1->diff($time2);
                                                            $schedul = $diff->h + ($diff->i / 60);
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $no++ ?></td>
                                                                <td><?php echo $resultshifting['nama_lengkap'] ?></td>
                                                                <td><?php echo $resultshifting['nama_shift'] ?></td>
                                                                <td><?php echo $resultshifting['jam_masuk'] ?></td>
                                                                <td><?php echo $resultshifting['jam_keluar'] ?></td>
                                                                <td><?php echo $resultshifting['tgl_mulai'] ?></td>
                                                                <td><?php echo $resultshifting['tgl_selesai'] ?></td>
                                                                <td><?php echo $schedul ?> Jam Kerja</td>
                                                                <?php if ($_SESSION['NamaLevel'] == 1) : ?>
                                                                    <td>
                                                                        <a class="btn-sm btn-success" href="shifting.php?edit=<?php echo urlencode($encrypt) ?>">Edit shifting</a>
                                                                        <a href="shifting.php?delete=<?php echo urlencode($encrypt) ?>" class="btn-sm btn-danger">Delete</a>
                                                                    </td>
                                                                <?php endif ?>
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
        "add_shifting" => "Data Berhasil Ditambahkan",
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
                    window.location.href = 'shifting.php';
                });
            </script>
            ";
            break;
        }
    }
    ?>


</body>

</html>