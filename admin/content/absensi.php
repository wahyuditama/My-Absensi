<?php

include '../database/koneksi.php';
include '../layout/encryp.php';
include '../layout/helper.php';
session_start();
//Untuk Tampilan Data absensi
$queryAbsensi = mysqli_query(mysql: $koneksi, query: "SELECT user.id as id_user,user.nama_lengkap,user.nip, absensi.* FROM absensi LEFT JOIN user on absensi.id_pegawai = user.id");

$resultAbsensi = [];
while ($row = mysqli_fetch_assoc($queryAbsensi)) {
    $resultAbsensi[] =  $row;
}


// jika button simpan di tekan
if (isset($_POST['simpan'])) {
    $nip = $_POST['nip'];
    $tgl = date('Y-m-d');
    $jamMasuk = date(format: 'H:i:s');
    $jamPulang = date('H:i:s');
    //Untuk Mengambil data NIP table user
    $queryUser = mysqli_query($koneksi, "SELECT id FROM user WHERE nip = '$nip'");
    $dataUser = mysqli_fetch_assoc($queryUser);

    if (!$dataUser) {
        echo "NIP tidak ditemukan.";
    }

    $id_pegawai = $dataUser['id'];

    if (isset($_GET['clokin'])) {
        $status = 1;
        $ket = $_POST['keterangan'];

        if (!empty($_FILES['foto_absen']['name'])) {
            $foto_absen = $_FILES['foto_absen']['name'];
            $ukuran_foto = $_FILES['foto_absen']['size'];

            $ext = array('png', 'jpg', 'jpeg');
            $extFoto = pathinfo($foto_absen, PATHINFO_EXTENSION);

            if (!in_array($extFoto, $ext)) {
                echo "Ext tidak ditemukan";
                die;
            } else {
                move_uploaded_file($_FILES['foto_absen']['tmp_name'], '../upload/' . $foto_absen);
                mysqli_query($koneksi, "INSERT INTO absensi (id_pegawai, tanggal, jam_masuk, status_absen, keterangan, foto)
                 VALUES ('$id_pegawai', '$tgl', '$jamMasuk', '$status', '$ket', '$foto_absen')");
            }
        } else {
            mysqli_query($koneksi, "INSERT INTO absensi (id_pegawai, tanggal, jam_masuk, status_absen, keterangan)
             VALUES ('$id_pegawai', '$tgl', '$jamMasuk', '$status', '$ket')");
        }
    } elseif (isset($_GET['clokout'])) {
        // Untuk jam_pulang
        mysqli_query($koneksi, "UPDATE absensi 
        SET jam_pulang = '$jamPulang'  WHERE id_pegawai = '$id_pegawai' AND tanggal = '$tgl'");
    } else {
        echo "Aksi tidak valid.";
        exit;
    }
    include 'absen_detail.php';

    header("location: absensi.php?add_absen=success");
}



$idAbsensi  = isset($_GET['edit-Absensi']) ? decryptId($_GET['edit-Absensi'], $key) : '';
$queryEditAbsensi = mysqli_query($koneksi, "SELECT user.id as id_user,user.nama_lengkap,user.nip, absensi.* FROM absensi LEFT JOIN user on absensi.id_pegawai = user.id WHERE absensi.id ='$idAbsensi'");
$rowEditAbsensi   = mysqli_fetch_assoc($queryEditAbsensi);

// print_r($rowEditAbsensi);
// die();

// jika button edit di klik

if (isset($_POST['edit'])) {
    $nip = $_POST['nip'];
    $tgl = date('Y-m-d');
    $jamMasuk = $_POST['jam_masuk'];
    $jamPulang = $_POST['jam_pulang'];
    $status = $_POST['status_absen'];
    $ket = $_POST['keterangan'];


    $queryEdit = mysqli_query($koneksi, "SELECT id FROM user WHERE nip = '$nip'");
    $dataEdit = mysqli_fetch_assoc($queryEdit);

    $id_pegawai = $dataEdit['id'];

    if (!empty($_FILES['foto_absen']['name'])) {
        $foto_absen = $_FILES['foto_absen']['name'];
        $ukuran_foto = $_FILES['foto_absen']['size'];


        $ext = array('png', 'jpg', 'jpeg');
        $extFoto = pathinfo($foto_absen, PATHINFO_EXTENSION);

        if (!in_array($extFoto, $ext)) {
            echo "Extensi gambar tidak ditemukan";
            die;
        } else {
            unlink('../upload/' . $rowEditAbsensi['foto']);
            move_uploaded_file($_FILES['foto']['tmp_name'], '../upload/' . $foto_absen);

            $update = mysqli_query($koneksi, "UPDATE absensi SET 
                -- id_pegawai = '$id_pegawai',
                -- tanggal = '$tgl',
                jam_masuk = '$jamMasuk', 
                jam_pulang = '$jamPulang',
                status_absen = '$status',
                keterangan = '$ket',
                foto = '$foto_absen'
                WHERE id = '$idAbsensi'");
            header("location:absensi.php?edited=success");
        }
    } else {
        $update = mysqli_query($koneksi, "UPDATE absensi SET 
                -- id_pegawai = '$id_pegawai',
                -- tanggal = '$tgl',
                jam_masuk = '$jamMasuk', 
                jam_pulang = '$jamPulang',
                status_absen = '$status',
                keterangan = '$ket'
            WHERE id = '$idAbsensi'");
        // print_r($update);
        // die();
    }
    include 'absen_detail.php';

    header("location: absensi.php?edited=success");
}


if (isset($_GET['delete'])) {
    $idAbsensi = decryptId($_GET['delete'], $key);
    $delete = mysqli_query($koneksi, "DELETE from absensi WHERE id = '$idAbsensi'");
    header('location:absensi.php?deleted=success');
}

//status

if (isset($_GET['statusAbsen']) && isset($_GET['cancelAbsen'])) {
    $id = decryptId($_GET['statusAbsen'], $key);
    $cancel = ((int) $_GET['cancelAbsen']);

    if ($cancel == 0) {
        $statusAbsen = 1;
    } elseif ($cancel == 1) {
        $statusAbsen = 2;
    } else {
        $statusAbsen = 0;
    }

    mysqli_query($koneksi, "UPDATE absensi SET status_absen = '$statusAbsen' WHERE id = '$id'");
    header('location: absensi.php');
    exit;
}

$absenList = [
    0 => 'Terlambat',
    1 => 'Hadir',
    2 => 'izin'
];

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

                    <!-- Page Heading -->
                    <div class="container-xxl flex-grow-1 container-p-y">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between"><?php echo isset($_GET['edit-Absensi']) ? 'Edit' : 'Data' ?>
                                        Absensi
                                        <?php if (isset($_GET['clokin'])): ?>
                                            <div class="card text-center">
                                                <img src="../assets/img/icons/brands/Absen-Masuk-7-25-2025.png" style="width:3rem; height: 3rem;;">
                                            </div>
                                        <?php elseif (isset($_GET['clokout'])) : ?>
                                            <div class="card text-center">
                                                <img src="../assets/img/icons/brands/Absen-pulang-7-25-2025.png" style="width:3rem; height: 3rem;;">
                                            </div>
                                        <?php endif ?>
                                    </div>
                                    <div class="card-body">
                                        <?php if (isset($_GET['hapus'])): ?>
                                            <div class="alert alert-success" role="alert">
                                                Data berhasil dihapus
                                            </div>
                                        <?php endif ?>

                                        <?php if (isset($_GET['add-Absensi']) || isset($_GET['edit-Absensi'])): ?>
                                            <div class="card-text d-flex">
                                                <a href="?add-Absensi&clokin" class="btn-sm btn-outline-primary border ms-3">Absen Masuk</a>
                                                <a href="?add-Absensi&clokout" class="btn-sm btn-outline-danger border ms-3">Absen Pulang</a>
                                            </div>
                                            <hr>
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <div class="mb-3 row">

                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">user</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            name="nip"
                                                            placeholder="Masukkan NIP disini"
                                                            <?= (!isset($_GET['clokin']) && !isset($_GET['clokout']) && !isset(($_GET['edit-Absensi']))) ? 'disabled' : '' ?>
                                                            value="<?php echo isset($_GET['edit-Absensi']) ? $rowEditAbsensi['nip'] : '' ?>">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Foto</label>
                                                        <input type="file"
                                                            class="form-control"
                                                            name="foto"
                                                            placeholder="Masukkan foto disini"
                                                            value="<?php echo isset($_GET['edit-Absensi']) ? $rowEditAbsensi['foto_absen'] : '' ?>">
                                                    </div>
                                                    <?php if (isset($_GET['edit-Absensi'])) : ?>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">Jam Masuk</label>
                                                            <input type="time"
                                                                class="form-control"
                                                                name="jam_masuk"
                                                                placeholder="Masukkan data disini"
                                                                value="<?php echo isset($_GET['edit-Absensi']) ? $rowEditAbsensi['jam_masuk'] : '' ?>">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">Jam Pulang</label>
                                                            <input type="time"
                                                                class="form-control"
                                                                name="jam_pulang"
                                                                placeholder="Masukkan foto disini"
                                                                value="<?php echo isset($_GET['edit-Absensi']) ? $rowEditAbsensi['jam_pulang'] : '' ?>">
                                                        </div>
                                                    <?php endif ?>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Ketreangan</label>
                                                        <input type="test"
                                                            class="form-control"
                                                            name="keterangan"
                                                            placeholder="Masukkan test disini"
                                                            required
                                                            value="<?php echo isset($_GET['edit-Absensi']) ? $rowEditAbsensi['keterangan'] : '' ?>">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Status</label>
                                                        <select name="status_absen" id="" class="form-control">
                                                            <?php foreach ($absenList as $key => $label) : ?>
                                                                <option value="<?= $key ?>"><?= $label ?></option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <button class="btn btn-primary" name="<?php echo isset($_GET['edit-Absensi']) ? 'edit' : 'simpan' ?>" type="submit">
                                                        Simpan
                                                    </button>
                                                </div>
                                            </form>
                                    </div>
                                <?php else : ?>
                                    <div class="col-md-12 text-center">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <a href="#">Data Absensi pegawai</a>
                                                <?php
                                                $text = '';
                                                if (!empty($resultAbsensi[0]['jam_masuk']) && !empty($resultAbsensi[0]['jam_pulang'])) {
                                                    $text = 'Tambah';
                                                } else {
                                                    $text = !empty($resultAbsensi[0]['jam_masuk']) ? 'Edit' : 'Tambah';
                                                }
                                                ?>
                                                <a class="btn-sm btn-primary" href="absensi.php?add-Absensi"><?= $text ?> Absensi</a>
                                            </div>
                                            <hr>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <td>Nomor</td>
                                                                <td>NIP</td>
                                                                <td>Nama pegawai</td>
                                                                <td>Jam Masuk</td>
                                                                <td>Jam Pulang</td>
                                                                <td>Jam Kerja</td>
                                                                <td>Status</td>
                                                                <td>Katerangan</td>
                                                                <?php if ($_SESSION['NamaLevel'] == 1) : ?>
                                                                    <td>Alat</td>
                                                                <?php endif ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $no = 1;
                                                            foreach ($resultAbsensi as $var) {
                                                                $encrypt = encryptId($var['id'], $key); ?>
                                                                <?php
                                                                //lama jama kerja
                                                                $date1 = new DateTime($var['jam_masuk']);
                                                                $date2 = new DateTime($var['jam_pulang']);
                                                                $diff = $date1->diff($date2);
                                                                $jam = $diff->h;
                                                                $menit = $diff->i;
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $no++ ?></td>
                                                                    <td><?php echo $var['nip'] ?></td>
                                                                    <td><?php echo $var['nama_lengkap'] ?></td>
                                                                    <td><?php echo $var['jam_masuk'] ?></td>
                                                                    <td><?php echo $var['jam_pulang'] ?></td>
                                                                    <td><?php echo $jam ?> Jam <?= $menit ?> Menit </td>
                                                                    <td>
                                                                        <a href="?statusAbsen=<?= urlencode($encrypt) ?>&cancelAbsen=<?= $var['status_absen'] ?>"><?= changeAbsen($var['status_absen'])  ?></a>
                                                                    </td>
                                                                    <td><?php echo $var['keterangan'] ?></td>
                                                                    <?php if ($_SESSION['NamaLevel'] == 1) : ?>
                                                                        <td>
                                                                            <a class="btn-sm btn-success" href="absensi.php?edit-Absensi=<?php echo urlencode($encrypt) ?>">Edit absensi</a>
                                                                            <a href="absensi.php?delete=<?php echo urlencode($encrypt) ?>" class="btn-sm btn-danger">Delete</a>
                                                                        </td>
                                                                    <?php endif ?>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <?php endif ?>
                                </div>
                            </div>
                        </div>
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
    <?php $alert = [
        'add_absen' => 'Ditambahkan!',
        'edited' => 'Diedit!',
        'deleted' => 'Dihapus!',
    ];

    foreach ($alert as $key => $message) {
        if (isset($_GET[$key])) {
            echo "
              <script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data berhasil $message',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'absensi.php';
            });
        </script>
            ";
        }
    }
    ?>


</body>

</html>