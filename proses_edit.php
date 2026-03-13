<?php
// 1. Panggil koneksi database
include_once __DIR__ . "/../../php/config/koneksi.php";

// 2. Panggil file Helper yang berisi fungsi formatRupiah
require_once __DIR__ . "/../../php/interfaceandmodel/SistemHelper.php";

// 3. Gunakan fungsi formatRupiah dari namespace SistemHelper
use function SistemHelper\formatRupiah;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Reservasi RS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">🏥 Manajemen Antrian RS</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h3>Daftar Pasien Menunggu</h3>
        <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
            + Daftar Pasien Baru
        </button>

        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No. Antrian (ID)</th>
                            <th>Nama Pasien</th>
                            <th>Poli Tujuan</th>
                            <th>Status Pasien</th>
                            <th>Biaya Periksa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        /* Looping Array Asosiatif */
                        $query = mysqli_query($conn, "SELECT * FROM antrian");
                        while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr>
                            <td>#<?php echo $row['id_antrian']; ?></td>
                            <td><?php echo $row['nama_pasien']; ?></td>
                            <td><?php echo $row['poli_tujuan']; ?></td>
                            <td>
                                <span class="badge <?php echo ($row['jenis_pasien'] == 'BPJS') ? 'bg-success' : 'bg-secondary'; ?>">
                                    <?php echo $row['jenis_pasien']; ?>
                                </span>
                            </td>
                            <td><?php echo formatRupiah($row['biaya']); ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $row['id_antrian']; ?>">Edit</button>
                                <a href="../../php/controller/proses_hapus.php?id=<?php echo $row['id_antrian']; ?>" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Tandai pasien ini sudah selesai periksa?');">Selesai</a>
                            </td>
                        </tr>

                        <div class="modal fade" id="modalEdit<?php echo $row['id_antrian']; ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Data Pasien #<?php echo $row['id_antrian']; ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="../../php/controller/proses_edit.php" method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_antrian" value="<?php echo $row['id_antrian']; ?>">
                                            
                                            <div class="mb-3">
                                                <label>Nama Lengkap</label>
                                                <input type="text" name="nama_pasien" class="form-control" value="<?php echo $row['nama_pasien']; ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label>Poli Tujuan</label>
                                                <select name="poli_tujuan" class="form-select" required>
                                                    <option value="Poli Umum" <?php if($row['poli_tujuan'] == 'Poli Umum') echo 'selected'; ?>>Poli Umum</option>
                                                    <option value="Poli Gigi" <?php if($row['poli_tujuan'] == 'Poli Gigi') echo 'selected'; ?>>Poli Gigi</option>
                                                    <option value="Poli Anak" <?php if($row['poli_tujuan'] == 'Poli Anak') echo 'selected'; ?>>Poli Anak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label>Status Pasien</label>
                                                <select name="jenis_pasien" class="form-select" required>
                                                    <option value="Umum" <?php if($row['jenis_pasien'] == 'Umum') echo 'selected'; ?>>Umum (Bayar Penuh)</option>
                                                    <option value="BPJS" <?php if($row['jenis_pasien'] == 'BPJS') echo 'selected'; ?>>BPJS (Gratis)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Pendaftaran Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="../../php/controller/proses_tambah.php" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama_pasien" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Poli Tujuan</label>
                            <select name="poli_tujuan" class="form-select" required>
                                <option value="Poli Umum">Poli Umum</option>
                                <option value="Poli Gigi">Poli Gigi</option>
                                <option value="Poli Anak">Poli Anak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Status Pasien</label>
                            <select name="jenis_pasien" class="form-select" required>
                                <option value="Umum">Umum (Bayar Penuh)</option>
                                <option value="BPJS">BPJS (Gratis)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan ke Antrian</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>