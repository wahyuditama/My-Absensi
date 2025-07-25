<?php

include '../database/koneksi.php';


$sql = mysqli_query($koneksi, "SELECT * FROM absensi WHERE tanggal = CURDATE()");

$jamMasukIdeal = new DateTime('08:00:00');
$jamPulangIdeal = new DateTime('17:00:00');

while ($row = mysqli_fetch_assoc($sql)) {
    $jamMasuk = new DateTime($row['jam_masuk']);
    $jamPulang = new DateTime($row['jam_pulang']);

    // --- Evaluasi Terlambat ---
    $terlambat = 0;
    $menitTerlambat = 0;
    if ($jamMasuk > $jamMasukIdeal) {
        $diffMasuk = $jamMasukIdeal->diff($jamMasuk);
        $terlambat = 1;
        $menitTerlambat = $diffMasuk->h * 60 + $diffMasuk->i;
    }

    // --- Evaluasi Pulang Cepat ---
    $pulangCepat = 0;
    $menitPulangCepat = 0;
    if ($jamPulang < $jamPulangIdeal) {
        $diffPulang = $jamPulang->diff($jamPulangIdeal);
        $pulangCepat = 1;
        $menitPulangCepat = $diffPulang->h * 60 + $diffPulang->i;
    }

    // Data untuk insert
    $id_absen = $row['id'];
    $id_pegawai = $row['id_pegawai'];
    $tgl = $row['tanggal'];
    $catatan = $row['keterangan'];
    // print_r($id_pegawai);
    // die();

    // Simpan ke absen_detail
    $query = mysqli_query($koneksi, "INSERT INTO absen_detail (
        absen_id, pegawai_id, tanggal, terlambat, menit_terlambat, pulang_cepat, menit_pulang_cepat, catatan
    ) VALUES (
        '$id_absen', '$id_pegawai', '$tgl', '$terlambat', '$menitTerlambat', '$pulangCepat', '$menitPulangCepat', '$catatan'
    )");
}

echo "Evaluasi berhasil disimpan.";
