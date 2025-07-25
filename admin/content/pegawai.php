<?php
session_start();
include '../database/koneksi.php';
include '../layout/encryp.php';

function generateNipCode()
{
    $kode = date('Ymdhis');
    return $kode;
}

if (isset($_POST['simpan'])) {
    $id_level = $_POST['id_level'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $no_telepon = $_POST['no_telepon'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $nip = $_POST['nip'];
    $jabatan = $_POST['jabatan'];
    $pass = $_POST['password'];
    $periode_cuti = 12;

    if (!empty($_FILES['foto']['name'])) {
        $nama_foto = $_FILES['foto']['name'];
        $ukuran_foto = $_FILES['foto']['size'];


        $ext = array('png', 'jpg', 'jpeg');
        $extFoto = pathinfo($nama_foto, PATHINFO_EXTENSION);

        if (!in_array($extFoto, $ext)) {
            echo "Ext tidak ditemukan";
            die;
        } else {
            move_uploaded_file($_FILES['foto']['tmp_name'], '../upload/' . $nama_foto);
            $insert = mysqli_query($koneksi, "INSERT INTO user (id_level, nama_lengkap, no_telepon, alamat, email,nip,jabatan, password,foto,periode_cuti) VALUES ('$id_level', '$nama_lengkap', '$no_telepon', '$alamat', '$email','$nip','$jabatan', '$pass','$nama_foto','$periode_cuti')");
            header("location: pegawai.php?add_data=berhasil");
        }
    } else {
        $insert = mysqli_query($koneksi, "INSERT INTO user (id_level, nama_lengkap, no_telepon, alamat, email,nip,jabatan, password,periode_cuti) VALUES ('$id_level', '$nama_lengkap', '$no_telepon', '$alamat', '$email','$nip','$jabatan','$pass','$periode_cuti')");
    }
    header("location: pegawai.php?add_data=berhasil");
}


$idUser  = isset($_GET['edit-user']) ? decryptId($_GET['edit-user'], $key) : '';
$queryEditUser = mysqli_query($koneksi, "SELECT level.nama_level, user.* FROM user LEFT JOIN level on user.id_level = level.id WHERE user.id ='$idUser'");
$rowEditUser   = mysqli_fetch_assoc($queryEditUser);


// jika button edit di klik

if (isset($_POST['edit'])) {
    $id_level = $_POST['id_level'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $no_telepon = $_POST['no_telepon'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email'];
    $nip = $_POST['nip'];
    $jabatan = $_POST['jabatan'];
    $pass = $_POST['password'];

    if (!empty($_FILES['foto']['name'])) {
        $nama_foto = $_FILES['foto']['name'];
        $ukuran_foto = $_FILES['foto']['size'];

        // png, jpg, jpeg
        $ext = array('png', 'jpg', 'jpeg');
        $extFoto = pathinfo($nama_foto, PATHINFO_EXTENSION);

        if (!in_array($extFoto, $ext)) {
            echo "Extensi gambar tidak ditemukan";
            die;
        } else {
            unlink('../upload/' . $rowEditUser['foto']);
            move_uploaded_file($_FILES['foto']['tmp_name'], '../upload/' . $nama_foto);

            $update = mysqli_query($koneksi, "UPDATE user SET 
                id_level = '$id_level',
                nama_lengkap = '$nama_lengkap',
                no_telepon = '$no_telepon', 
                alamat = '$alamat',
                email = '$email',
                nip = '$nip',
                jabatan = '$jabatan',
                password = '$pass',
                foto = '$nama_foto'
                WHERE id = '$idUser'");
            header("location:pegawai.php?ubah=berhasil");
        }
    } else {
        $update = mysqli_query($koneksi, "UPDATE user SET 
            id_level = '$id_level',
            nama_lengkap = '$nama_lengkap',
            no_telepon = '$no_telepon', 
            alamat = '$alamat',
            email = '$email',
            jabatan = '$jabatan',
            nip = '$nip',
            password = '$pass'
            WHERE id = '$idUser'");
    }
    header("location: pegawai.php?edited=berhasil");
}

// ambil data dari level

$id_level = isset($_GET['level']) ? $_GET['level'] : '';
$queryLevel = mysqli_query($koneksi, "SELECT * FROM level");

$queryuser = mysqli_query($koneksi, "SELECT level.nama_level, user.* FROM user LEFT JOIN level ON level.id = user.id_level WHERE user.id");


// jika parameternya ada ?delete=nilai param
if (isset($_GET['delete'])) {
    $id = decryptId($_GET['delete'], $key);

    $delete = mysqli_query($koneksi, "DELETE FROM user  WHERE id ='$id'");
    header("location:pegawai.php?deleted=berhasil");
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
                        <!-- Page Heading -->
                        <div class="row">
                            <?php if (isset($_GET['add-user']) || isset($_GET['edit-user'])) : ?>
                                <div class="col-sm-12">
                                    <div class="card">
                                        <div class="card-header"><?php echo isset($_GET['edit-user']) ? 'Edit' : 'Tambah' ?> users</div>
                                        <div class="card-body">
                                            <?php if (isset($_GET['hapus'])): ?>
                                                <div class="alert alert-success" role="alert">
                                                    Data berhasil dihapus
                                                </div>
                                            <?php endif ?>

                                            <form action="" method="post" enctype="multipart/form-data">
                                                <div class="mb-3 row">
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Tambah Nama</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            name="nama_lengkap"
                                                            placeholder="Masukkan nama user anda"
                                                            required
                                                            value="<?php echo isset($_GET['edit-user']) ? $rowEditUser['nama_lengkap'] : '' ?>">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Tambah Email</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            name="email"
                                                            placeholder="Masukkan email anda"
                                                            required
                                                            value="<?php echo isset($_GET['edit-user']) ? $rowEditUser['email'] : '' ?>">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Nomor Telepon</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            name="no_telepon"
                                                            placeholder="Masukkan nomor telepon anda"
                                                            required
                                                            value="<?php echo isset($_GET['edit-user']) ? $rowEditUser['no_telepon'] : '' ?>">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Alamat</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            name="alamat"
                                                            placeholder="Masukkan nama user disini"
                                                            required
                                                            value="<?php echo isset($_GET['edit-user']) ? $rowEditUser['alamat'] : '' ?>">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">NIP Pegawai</label>
                                                        <input type="text" class="form-control" id="nip" name="nip" value="<?php echo "PSBD-" . generateNipCode() ?>" readonly>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Password</label>
                                                        <input type="password"
                                                            class="form-control"
                                                            name="password"
                                                            placeholder="Masukkan password disini"
                                                            required
                                                            value="<?php echo isset($_GET['edit-user']) ? $rowEditUser['password'] : '' ?>">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Jabatan</label>
                                                        <input type="text"
                                                            class="form-control"
                                                            name="jabatan"
                                                            placeholder="Masukkan jabatan anda disini"
                                                            required
                                                            value="<?php echo isset($_GET['edit-user']) ? $rowEditUser['jabatan'] : '' ?>">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Level</label>
                                                        <select name="id_level" class="form-control" id="">
                                                            <option value="<?php echo isset($_GET['edit-user']) ? $rowEditUser['id_level'] : '' ?>"><?php echo isset($_GET['edit']) ? $rowEditUser['nama_level'] : '--Pilih level--' ?></option>
                                                            <?php while ($rowLevel = mysqli_fetch_assoc($queryLevel)) { ?>
                                                                <option value="<?php echo $rowLevel['id'] ?>"><?php echo $rowLevel['nama_level'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="" class="form-label">Foto</label>
                                                        <input type="file"
                                                            class="form-control"
                                                            name="foto"
                                                            placeholder="Masukkan foto disini"
                                                            value="<?php echo isset($_GET['edit-user']) ? $rowEditUser['foto'] : '' ?>">
                                                    </div>

                                                </div>
                                                <div class="mt-3">
                                                    <button class="btn btn-primary" name="<?php echo isset($_GET['edit-user']) ? 'edit' : 'simpan' ?>" type="submit">
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
                                            <a href="">Data user</a>
                                            <a href="?add-user" class="btn-sm btn-primary">Tambah Data Pengguna</a>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama Level</th>
                                                            <th>NIP pegawai</th>
                                                            <th>Nama pegawai</th>
                                                            <th>Jabatan</th>
                                                            <th>Telepon</th>
                                                            <th>Alamat</th>
                                                            <th>Aksi</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $no = 1;
                                                        while ($rowuser = mysqli_fetch_assoc($queryuser)) {
                                                            $encryp = encryptId($rowuser['id'], $key); ?>
                                                            <tr>
                                                                <td><?php echo $no++ ?></td>
                                                                <td><?php echo $rowuser['nama_level'] ?></td>
                                                                <td><?php echo $rowuser['nip'] ?></td>
                                                                <td><?php echo $rowuser['nama_lengkap'] ?></td>
                                                                <td><?php echo $rowuser['jabatan'] ?></td>
                                                                <td><?php echo $rowuser['no_telepon'] ?></td>
                                                                <td><?php echo $rowuser['alamat'] ?></td>
                                                                <td>
                                                                    <a href="pegawai.php?edit-user=<?php echo urlencode($encryp) ?>" class="btn btn-success btn-sm">
                                                                        <span class="tf-icon bx bx-pencil bx-18px "></span>
                                                                    </a>
                                                                    <a
                                                                        href="pegawai.php?delete=<?php echo urlencode($encryp) ?>" class="btn btn-danger btn-sm">
                                                                        <span class="tf-icon bx bx-trash bx-18px "></span>
                                                                    </a>

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
        "add_data" => "Data Berhasil dibuat",
        "edited" => "Data Berhasil Diedit",
        "deleted" => "Data Berhasil Dihapus",
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
                    window.location.href = 'pegawai.php';
                });
            </script>
            ";
            break;
        }
    }


    ?>

</body>

</html>