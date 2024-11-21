<?php
include 'koneksi.php';
include '../template/header.php';
if (isset($_GET['id_siswa'])) {
    $id_siswa = $_GET['id_siswa'];
    $query = "SELECT siswa.*, jurusan.nama_jurusan, kelas.nama_kelas FROM siswa INNER JOIN jurusan ON siswa.id_jurusan = jurusan.id_jurusan INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas WHERE siswa.id_siswa = $id_siswa";
    $exec = mysqli_query($conn, $query);
    $res = mysqli_fetch_assoc($exec);
}

if (isset($_POST['edit'])) {
    $id_siswa = $_POST['id_siswa'];
    $id_kelas = $_POST['id_kelas'];
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $ttl = $_POST['ttl'];

    $query_update_siswa = "UPDATE siswa SET id_kelas = '$id_kelas', nama = '$nama', alamat = '$alamat', jenis_kelamin = '$jenis_kelamin', ttl = '$ttl' WHERE id_siswa = '$id_siswa'";


    $result = mysqli_query($conn, $query_update_siswa);

    if ($result) {
        echo "<script>alert('Data siswa berhasil disimpan'); document.location = 'siswa.php';</script>";
    } else {
        echo "<script>alert('Data siswa gagal disimpan'); document.location = 'siswa.php';</script>";
    }
}
?>

<form action="" method="post">
    <!-- Hidden field untuk menyimpan id_siswa dan nisn -->
    <input type="hidden" name="id_siswa" value="<?=$res['id_siswa']?>">
    <input type="hidden" name="nisn" value="<?= $res['nisn'] ?>">
    <input type="hidden" name="id_kelas" value="<?= $res['id_kelas'] ?>">



    <!-- Input untuk menampilkan nisn -->
    <input type="text" class="form-control mb-2" readonly value="<?= $res['nisn'] ?>" disabled>
    <input type="text" class="form-control mb-2" readonly value="<?= $res['id_angkatan'] ?>" disabled>
    <input type="text" class="form-control mb-2" readonly value="<?= $res['nama_kelas'] ?>" disabled>
    <input type="text" class="form-control mb-2" readonly value="<?= $res['nama_jurusan'] ?>" disabled>
    <input type="text" class="form-control mb-2" required name="nama" value="<?= $res['nama'] ?>">
    <input type="text" class="form-control mb-2" required name="ttl" value="<?= $res['ttl'] ?>">
    <SELECT class="form-control mb-2" name="jenis_kelamin">
      <option selected=""><?= empty($res['jenis_kelamin']) ? 'Jenis Kelamin' : $res['jenis_kelamin']; ?></option>
      <option value="laki-laki">Laki-Laki</option>
      <option value="perempuan">Perempuan</option>
    </SELECT>
    <textarea class="form-control mb-2" required name="alamat" placeholder="Alamat Siswa"><?= $res['alamat'] ?></textarea>

    <button type="submit" name="edit" class="btn btn-primary" style="float:right;">Simpan</button>

</form>


<form action="" method="POST">
  <div class="col-md-12 mb-4">
    <div class="card shadow">
      <div class="card-header">
        <strong class="card-title"><h3>Tambah Data Siswa</h3></strong>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="custom-multiselect">NISN</label>
          <input type="text" class="form-control mb-2" readonly value="<?= $res['nisn'] ?>" disabled>
          <input type="hidden" name="id_siswa" value="<?=$res['id_siswa']?>">
          <input type="hidden" name="nisn" value="<?= $res['nisn'] ?>">
          <input type="hidden" name="id_kelas" value="<?= $res['id_kelas'] ?>">
        </div>
        <div class="form-group">
          <label for="custom-multiselect">Angkatan</label>
          <input type="text" class="form-control mb-2" readonly value="<?= $res['id_angkatan'] ?>" disabled>
        </div>
        <div class="form-group mb-3">
          <label for="custom-multiselect">Kelas</label>
          <input type="text" class="form-control mb-2" readonly value="<?= $res['nama_kelas'] ?>" disabled>
        </div>
        <div class="form-group mb-3">
          <label for="custom-multiselect">Jurusan</label>
          <input type="text" class="form-control mb-2" readonly value="<?= $res['nama_jurusan'] ?>" disabled>
        <div>
        <div class="form-group mb-3">
          <label for="custom-multiselect">Nama</label>
          <input type="text" class="form-control mb-2" required name="nama" value="<?= $res['nama'] ?>">
        </div>
        <div class="form-group mb-3">
          <label for="custom-multiselect">Tempat Tanggal Lahir</label>
          <input type="text" class="form-control mb-2" required name="ttl" value="<?= $res['ttl'] ?>">
        </div>
        <div class="form-group">
          <label for="custom-multiselect">Alamat</label>
          <SELECT class="form-control mb-2" name="jenis_kelamin">
            <option selected=""><?= empty($res['jenis_kelamin']) ? 'Jenis Kelamin' : $res['jenis_kelamin']; ?></option>
            <option value="laki-laki">Laki-Laki</option>
            <option value="perempuan">Perempuan</option>
          </SELECT>        
        </div>
        <div class="form-group mb-3">
          <label for="custom-multiselect">Alamat</label>
          <input type="text" class="form-control mb-2" required name="alamat" value="<?= $res['alamat'] ?>">
        </div>
        <button type="submit" name="simpan" class="btn btn-primary" style="float:right;">Simpan</button>
      </div>
    </div>
  </div>
</form>

<?php
    include '../template/footer.php';
?>