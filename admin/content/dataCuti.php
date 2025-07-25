<?php
include '../database/koneksi.php';
include '../layout/helper.php';
include '../layout/encryp.php';
session_start();

$sqlCuti = mysqli_query($koneksi, "SELECT cuti.*, user.nama_lengkap, user.nip FROM cuti LEFT JOIN user ON cuti.id_pegawai = user.id");

$id = isset($_GET['edit']) ? decryptId($_GET['edit'], $key) : '';
$rowEditCuti = [];
if ($id != '') {
    $queryEditCuti = mysqli_query($koneksi, "SELECT user.nama_lengkap, user.nip, user.jabatan, cuti.* 
    FROM cuti 
    LEFT JOIN user ON cuti.id_pegawai = user.id
    WHERE cuti.id = '$id'");
    $rowEditCuti = mysqli_fetch_assoc($queryEditCuti);
}


$queryPegawai = mysqli_query($koneksi, "SELECT * FROM user");
$listPegawai = [];
while ($pegawai = mysqli_fetch_assoc($queryPegawai)) {
    $listPegawai[] = $pegawai;
}
if (isset($_POST['simpan'])) {
    $id_pegawai = $_POST['id_pegawai'];
    $tgl_mulai = $_POST['tgl_mulai'];
    $tgl_selesai = $_POST['tgl_selesai'];
    // $status = $_GET['status'];

    $date1 = new DateTime($tgl_mulai);
    $date2 = new DateTime($tgl_selesai);

    $diff = $date1->diff($date2);
    $lamacuti = $diff->days + 1;


    $query = mysqli_query($koneksi, "INSERT INTO cuti (id_pegawai, tgl_mulai, tgl_selesai,lama_cuti) 
    VALUES ('$id_pegawai', '$tgl_mulai', '$tgl_selesai',$lamacuti)");

    if ($query) {
        header("Location: dataCuti.php?add_cuti=berhasil");
    } else {
        echo "Gagal menambah data<br>" . mysqli_error($koneksi);
    }
}

if (isset($_POST['edit'])) {
    $id_pegawai = $_POST['id_pegawai'];
    $tgl_mulai = $_POST['tgl_mulai'];
    $tgl_selesai = $_POST['tgl_selesai'];
    // $status = $_GET['status'];
    $date1 = new DateTime($tgl_mulai);
    $date2 = new DateTime($tgl_selesai);

    $diff = $date1->diff($date2);
    $lamacuti = $diff->days + 1;


    $query = mysqli_query($koneksi, "UPDATE cuti SET id_pegawai='$id_pegawai', tgl_mulai='$tgl_mulai', tgl_selesai='$tgl_selesai', lama_cuti = $lamacuti
    WHERE id = '$id'");

    if ($query) {
        header("Location: dataCuti.php?edited=berhasil");
    } else {
        echo "Gagal mengedit data<br>" . mysqli_error($koneksi);
    }
}

if (isset($_GET['delete'])) {
    $id = decryptId($_GET['delete'], $key);
    $delete = mysqli_query($koneksi, "DELETE FROM cuti WHERE id = '$id'");
    header("location: dataCuti.php?deleted=berhasil");
}

//status 

if (isset($_GET['status']) && isset($_GET['cancel'])) {
    $id = decryptId($_GET['status'], $key);
    $cancel = (int) $_GET['cancel'];

    if ($cancel == 0) {
        $afterStatus = 1;
    } elseif ($cancel == 1) {
        $afterStatus = 2;
    } else {
        $afterStatus = 0;
    }

    // Update status cuti
    mysqli_query($koneksi, "UPDATE cuti SET status = $afterStatus WHERE id='$id'");

    header("Location: dataCuti.php");
    exit;
}

//statuslist
$statuslist = [
    0 => 'Pending',
    1 => 'Disetujui',
    2 => 'Ditolak'
];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../layout/head.php' ?>
</head>

<body id="page-top">
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
                            <?php if (isset($_GET['add-cuti']) || isset($_GET['edit'])): ?>
                                <div class="col-sm-8 offset-2" style="height: 100vh;">
                                    <div class="card mt-5">
                                        <div class="card-header"><?php echo isset($_GET['edit']) ? 'Edit' : 'Tambah' ?> Cuti Pegawai</div>
                                        <div class="card-body">
                                            <form action="" method="post">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="my-3">
                                                            <label for="">Nama Pegawai</label>
                                                            <select name="id_pegawai" class="form-control" required>
                                                                <option value="">-- Pilih Pegawai --</option>
                                                                <?php foreach ($listPegawai as $pegawai): ?>
                                                                    <option value="<?= $pegawai['id'] ?>" <?= (isset($rowEditCuti['id_pegawai']) && $rowEditCuti['id_pegawai'] == $pegawai['id']) ? 'selected' : '' ?>>
                                                                        <?= $pegawai['nama_lengkap'] . " - " . $pegawai['nip'] ?>
                                                                    </option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="my-3">
                                                            <label for="status">Status Cuti</label>
                                                            <select name="status" class="form-control" required>
                                                                <?php foreach ($statuslist as $values => $label): ?>
                                                                    <option value="<?= $values ?>"><?= $label ?></option>
                                                                <?php endforeach ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="">
                                                            <label for="">Tanggal Mulai</label>
                                                            <input type="date" name="tgl_mulai" class="form-control" value="<?= $rowEditCuti['tgl_mulai'] ?? '' ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="">
                                                            <label for="">Tanggal Selesai</label>
                                                            <input type="date" name="tgl_selesai" class="form-control" value="<?= $rowEditCuti['tgl_selesai'] ?? '' ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <button class="btn btn-primary" name="<?= isset($_GET['edit']) ? 'edit' : 'simpan' ?>" type="submit">
                                                        Simpan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between">
                                            <h5>Data Cuti Pegawai</h5>
                                            <a href="dataCuti.php?add-cuti" class="btn-sm btn-primary">Tambah Data</a>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Pegawai</th>
                                                            <th>NIP</th>
                                                            <th>Tanggal Mulai</th>
                                                            <th>Tanggal Selesai</th>
                                                            <th>Lama Cuti</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1;
                                                        while ($cuti = mysqli_fetch_assoc($sqlCuti)) : $encryp = encryptId($cuti['id'], $key) ?>
                                                            <tr>
                                                                <td><?= $no++ ?></td>
                                                                <td><?= $cuti['nama_lengkap'] ?></td>
                                                                <td><?= $cuti['nip'] ?></td>
                                                                <td><?= $cuti['tgl_mulai'] ?></td>
                                                                <td><?= $cuti['tgl_selesai'] ?></td>
                                                                <td><?= $cuti['lama_cuti'] ?> Hari</td>
                                                                <td>
                                                                    <a class="btn btn-success btn-sm" href="dataCuti.php?edit=<?= urlencode($encryp) ?>">Edit</a>
                                                                    <a href="dataCuti.php?delete=<?= urlencode($encryp) ?>" class="btn btn-danger btn-sm">Delete</a>
                                                                    <a href="?status=<?php echo urlencode($encryp) ?>&cancel=<?php echo $cuti['status'] ?>" class="text-white"><?php echo changeStatus($cuti['status']) ?></a>
                                                                </td>
                                                            </tr>
                                                        <?php endwhile ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
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
        "add_cuti" => "Data Cuti Berhasil Ditambahkan !",
        "edited" => "Data Cuti Berhasil Diedit",
        "deleted" => "Data Cuti Berhasil Dihapus",
    ];

    foreach ($alert as $key => $value) {
        if (isset($_GET[$key])) {
            echo "
            <script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: '$value',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'dataCuti.php';
                });
            </script>
            ";
            break;
        }
    }
    ?>

</body>

</html>