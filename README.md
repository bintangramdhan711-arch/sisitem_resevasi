<?php
// ... (kode bagian atas tetap sama)

$biaya = $pasien->hitungBiaya();

/* Query Update */
// KOREKSI 1: Sudah ditambahkan kutip tunggal penutup setelah $id_antrian
$query = mysqli_query($conn, "UPDATE antrian SET nama_pasien='$nama_pasien', poli_tujuan='$poli_tujuan', jenis_pasien='$jenis_pasien', biaya='$biaya' WHERE id_antrian='$id_antrian'");

if($query) {
    // KOREKSI 2: Tanda kutip penutup pada alert sudah diperbaiki menjadi kutip tunggal
    echo "<script>
            alert('Sukses! Data pasien berhasil diperbarui.'); 
            window.location.href='../../html/public/dashboard.php';
          </script>";
} else {
    echo "<h1>GAGAL MENGEDIT DATA!</h1>";
    echo "Pesan Error: ". mysqli_error($conn);
}
?>