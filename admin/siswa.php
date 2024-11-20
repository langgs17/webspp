<?php 
include '../template/header.php';
include 'koneksi.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['id_siswa'])) {
  $id_siswa = $_GET['id_siswa'];
  $exec     = mysqli_query($conn, "DELETE FROM siswa WHERE id_siswa='$id_siswa'");
  $exec1     = mysqli_query($conn, "DELETE FROM pembayaran WHERE id_siswa='$id_siswa'");
  if ($exec && $exec1) {
    echo "<script>alert('data siswa berhasil dihapus')
    document.location = 'siswa.php';
    </script>";
  } else {
    echo "<script>alert('data siswa gagal dihapus')
    document.location = 'siswa.php';
    </script>";
  }
}
$sqlx = "SELECT siswa.*, angkatan.*, jurusan.*, kelas.* FROM siswa, angkatan, jurusan, kelas WHERE siswa.id_angkatan = angkatan.nama_angkatan AND siswa.id_jurusan = jurusan.id_jurusan AND siswa.id_kelas = kelas.id_kelas";
$q = mysqli_query($conn, $sqlx);
while ($hasil = mysqli_fetch_array($q)) {
  //UPDATE `siswatemp` SET `kls11` = '1' WHERE `siswatemp`.`nisn` = '20220728092600';;

  $updates = "UPDATE `siswatemp` SET kls$hasil[kelas]='$hasil[nama_kelas]' WHERE `siswatemp`.`nisn` = '$hasil[nisn]'";
  //echo $updates;
  $qupd = mysqli_query($conn, $updates);
  //if($qupd) echo "berhasil";
  //else echo "gagal";
}

?>

<!-- button triger -->
<!-- button triger -->

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h5 class="m-0 font-weight-bold text-primary">Data Siswa
    <a class="btn btn-primary" style="position:relative; float:right;" href="siswa_tambah.php">Tambah Siswa</a>
    </h5>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>NISN</th>
            <th>Nama</th>
            <th>Angkatan</th>
            <th>Jurusan</th>
            <th>Kelas</th>
            <th>Alamat</th>
            <th>Jenis Kelamin</th>
            <th>Tempat Tgl Lahir</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $query = "SELECT siswa.*, angkatan.*, jurusan.*, kelas.* FROM siswa, angkatan, jurusan, kelas WHERE siswa.id_angkatan = angkatan.nama_angkatan AND siswa.id_jurusan = jurusan.id_jurusan AND siswa.id_kelas = kelas.id_kelas ORDER BY id_siswa";
          $exec = mysqli_query($conn, $query);
          while ($res = mysqli_fetch_assoc($exec)) :

          ?>
            <tr>
              <td><?= $res['nisn'] ?></td>
              <td><?= $res['nama'] ?></td>
              <td><?= $res['nama_angkatan'] ?></td>
              <td><?= $res['nama_jurusan'] ?></td>
              <td><?= $res['nama_kelas'] ?></td>
              <td><?= $res['alamat'] ?></td>
              <td><?= $res['jenis_kelamin'] ?></td>
              <td><?= $res['ttl'] ?></td>
              <td>
                <a href="siswa.php?id_siswa=<?= $res['id_siswa'] ?>" class="btn btn-sm btn-danger" onclick="return confirm ('Apakah yakin ingin menghapus data?')">Hapus</a>
                <a href="siswa_ubah.php?id_siswa=<?= $res['id_siswa'] ?>" class="btn btn-sm btn-warning">EDIT</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include '../template/footer.php'; ?>


