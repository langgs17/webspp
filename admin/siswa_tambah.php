
<?php
include '../template/header.php';
include 'koneksi.php';

if (isset($_POST['simpan'])) {
  $nama          = htmlentities(strip_tags(ucwords($_POST['nama'])));
  $id_angkatan   = htmlentities(strip_tags($_POST['id_angkatan']));
  $id_jurusan    = htmlentities(strip_tags($_POST['id_jurusan']));
  $id_kelas      = htmlentities(strip_tags($_POST['id_kelas']));
  $alamat        = htmlentities(strip_tags(ucwords($_POST['alamat'])));
  $nisn          = date('YmdHis');
  $tahun         = htmlentities(strip_tags($_POST['id_angkatan']));
  $jenis_kelamin = htmlentities(strip_tags($_POST['jenis_kelamin']));
  $ttl           = htmlentities(strip_tags($_POST['ttl']));

  $tahunanggaran = substr($tahun, 0, 4);
  $nexttahunanggaran = $tahunanggaran + 1;

  $query = "INSERT INTO siswa (nisn, nama, id_angkatan, id_jurusan, id_kelas, alamat, jenis_kelamin, ttl) VALUES('$nisn','$nama','$id_angkatan','$id_jurusan','$id_kelas','$alamat','$jenis_kelamin','$ttl')";
  $exec = mysqli_query($conn, $query);



  $q2 = "INSERT INTO siswatemp (nisn, tahun) VALUES ('$nisn','$tahun')";
  $qq = mysqli_query($conn, $q2);

  if ($exec) {

    $bulanIndo = [
      '1' => 'Januari',
      '2' => 'Februari',
      '3' => 'Maret',
      '4' => 'April',
      '5' => 'Mei',
      '6' => 'Juni',
      '7' => 'Juli',
      '8' => 'Agustus',
      '9' => 'September',
      '10' => 'Oktober',
      '11' => 'November',
      '12' => 'Desember'
    ];

  

    $query = "SELECT siswa.*,angkatan.* FROM siswa,angkatan WHERE siswa.id_angkatan = angkatan.nama_angkatan ORDER BY  siswa.id_siswa DESC LIMIT 1";
    $exec       = mysqli_query($conn, $query);
    $res        = mysqli_fetch_assoc($exec);
    $biaya      = $res['biaya'];
    $id_siswa   = $res['id_siswa'];
    $ket        = $res['ket'];
    $awaltempo  = date('d-m-Y');
    $id_kelas = $res['id_kelas'];

    $getkelas=mysqli_query($conn, "SELECT kelas FROM kelas WHERE id_kelas=$id_kelas");
    $hasil=mysqli_fetch_array($getkelas);

    for ($i = 7; $i <= 12; $i++) {
      // tanggal jatuh tempo setiap tanggal ?
      $jatuhtempo = date("d-m-Y", strtotime("+$i month", strtotime($awaltempo)));

      $bulan = "$bulanIndo[$i] $tahunanggaran";
      // simpan data

      $ket    = 'BELUM DIBAYAR';

      $add = mysqli_query($conn, "INSERT INTO pembayaran(id_siswa , jatuhtempo, bulan, jumlah, ket, tahun, kelas) VALUES ('$id_siswa','$tahunanggaran','$bulan','$biaya', '$ket','$tahunanggaran','$hasil[0]')");
    }
    for ($i = 1; $i <= 6; $i++) {
      // tanggal jatuh tempo setiap tanggal ?
      $jatuhtempo = date("d-m-Y", strtotime("+$i month", strtotime($awaltempo)));

      $bulan = "$bulanIndo[$i] $nexttahunanggaran";
      // simpan data

      $ket    = 'BELUM DIBAYAR';

      $add = mysqli_query($conn, "INSERT INTO pembayaran(id_siswa , jatuhtempo, bulan, jumlah, ket, tahun, kelas) VALUES ('$id_siswa','$nexttahunanggaran','$bulan','$biaya', '$ket','$tahunanggaran','$hasil[0]')");
    }

    echo "<script>alert('data siswa berhasil disimpan')
    document.location = 'siswa.php';
    </script>";
  } else {
    echo "<script>alert('data siswa gagal disimpan')
    document.location = 'siswa.php';
    </script>";
  }
}
?>

<form action="" method="POST">
  <div class="col-md-12 mb-4">
    <div class="card shadow">
      <div class="card-header">
        <strong class="card-title"><h3>Tambah Data Siswa</h3></strong>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="custom-multiselect">Nama Lengkap</label>
          <input type="text" required name="nama" placeholder="Nama Siswa" class="form-control mb-2">
        </div>
        <div class="form-group">
          <label for="custom-multiselect">Tempat Tanggal Lahir</label>
          <input type="text" name="ttl" placeholder="Tempat Tanggal Lahir contoh: Bandung, 11-11-2011" required class="form-control mb-2">
        </div>
        <div class="form-group mb-3">
          <label for="custom-multiselect">Jenis Kelamin</label>
          <select class="custom-select" name="jenis_kelamin">
            <option selected="">Pilih Jenis Kelamin</option>
            <option value="laki-laki">Laki-Laki</option>
            <option value="perempuan">Perempuan</option>
          </select>
        </div>
        <div class="form-group mb-3">
          <label for="custom-multiselect">Angkatan</label>
          <select class="form-control mb-2" name="id_angkatan">
            <option selected="">Pilih Angkatan</option>
            <?php
            $exec = mysqli_query($conn, "SELECT * FROM angkatan order by id_angkatan");
            while ($angkatan = mysqli_fetch_assoc($exec)) :
                echo "<option value = " . $angkatan['nama_angkatan'] . ">" . $angkatan['nama_angkatan'] . "</option>";
            endwhile;
            ?>
          </select>
        <div>
        <div class="form-group mb-3">
          <label for="custom-multiselect">Jurusan</label>
          <select class="form-control mb-2" name="id_jurusan">
              <option selected="">Pilih Jurusan</option>
              <?php
              $exec = mysqli_query($conn, "SELECT * FROM jurusan order by id_jurusan");
              while ($angkatan = mysqli_fetch_assoc($exec)) :
                  echo "<option value = " . $angkatan['id_jurusan'] . ">" . $angkatan['nama_jurusan'] . "</option>";
              endwhile;
              ?>
          </select>
        </div>
        <div class="form-group mb-3">
          <label for="custom-multiselect">Kelas</label>
          <select class="form-control mb-2" name="id_kelas">
              <option selected="">Pilih Kelas</option>
              <?php
              $exec = mysqli_query($conn, "SELECT * FROM kelas order by id_kelas");
              while ($angkatan = mysqli_fetch_assoc($exec)) :
                  echo "<option value = " . $angkatan['id_kelas'] . ">" . $angkatan['nama_kelas'] . "</option>";
              endwhile;
              ?>
          </select>
        </div>
        <div class="form-group">
          <label for="custom-multiselect">Alamat</label>
          <input type="text" class="form-control mb-2" required name="alamat" placeholder="Alamat Siswa"></input>
        </div>
        <button type="submit" name="simpan" class="btn btn-primary" style="float:right;">Simpan</button>
      </div>
    </div>
  </div>
</form>

<?php
include '../template/footer.php';
?>

