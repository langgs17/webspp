<?php
include '../template/header.php';
include '../template/footer.php';
if(isset($_POST['simpan'])){
  $nama_kelas = htmlentities(strip_tags(strtoupper($_POST['nama_kelas'])));
  
  $query      = "INSERT INTO kelas (nama_kelas) VALUES ('$nama_kelas')";
  $exec       = mysqli_query($conn, $query);
  if($exec){
    echo "<script>alert('data kelas berhasil disimpan')
    document.location = 'editdatakelas.php';
    </script>";
  }else {
    echo "<script>alert('data kelas gagal disimpan')
    document.location = 'editdatakelas.php';
    </script>";
  }
}
?>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Data Kelas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
      </div>
      <div class="modal-body">
        <form action="" method="POST">
          <input type="text" required name="nama_kelas" placeholder="Nama Kelas" class="form-control mb-2">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="Submit" name="simpan" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include '../template/footer.php'; ?>