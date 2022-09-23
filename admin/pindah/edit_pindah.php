<?php

if (isset($_GET['kode'])) {
    $sql_cek = "SELECT p.nama, d.id_pindah, d.tgl_pindah, d.alasan FROM 
		tb_pindah d join tb_pdd p on d.id_pdd=p.id_pend WHERE id_pindah='" . $_GET['kode'] . "'";
    $query_cek = mysqli_query($koneksi, $sql_cek);
    $data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);
}
?>

<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fa fa-edit"></i> Ubah Data
        </h3>
    </div>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="card-body">

            <input type="hidden" class="form-control" id="id_pindah" name="id_pindah"
                value="<?php echo $data_cek['id_pindah']; ?>" readonly />

            <input type="hidden" class="form-control" id="nama" name="nama" value="<?php echo $data_cek['nama']; ?>"
                readonly required>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tgl pindah</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" id="tgl_pindah" name="tgl_pindah"
                        value="<?php echo $data_cek['tgl_pindah']; ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Alasan</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="alasan" name="alasan"
                        value="<?php echo $data_cek['alasan']; ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Surat Pindah</label>
                <div class="col-sm-6">
                    <input type="file" class="form-control" id="file_pindah" name="file_pindah"
                        placeholder="Alasan Pindah">
                </div>
            </div>

        </div>
        <div class="card-footer">
            <input type="submit" name="Ubah" value="Simpan" class="btn btn-info">
            <a href="?page=data-pindah" title="Kembali" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php

if (isset($_POST['Ubah'])) {
    if ($_FILES['file_pindah']['size'] != 0) {
        $ext_allowed = 'pdf';
        $filename = $_FILES['file_pindah']['name'];
        $explod = explode('.', $filename);
        $ext = strtolower(end($explod));
        $size = $_FILES['file_pindah']['size'];
        $file_tmp = $_FILES['file_pindah']['tmp_name'];
        if ($ext === $ext_allowed) {
            if ($size < 102400) {
                move_uploaded_file($file_tmp, 'dist/files/pindah/' . $filename);
                $sql_simpan =
                    "UPDATE tb_pindah SET 
                    tgl_pindah='" . $_POST['tgl_pindah'] . "',
		            alasan='" . $_POST['alasan'] . "',
                    filename_pindah = '" . $filename . "'
		            WHERE id_pindah='" . $_POST['id_pindah'] . "'";
                $query_update = mysqli_query($koneksi, $sql_simpan);

                if ($query_update) {
                    echo "<script>
					Swal.fire({title: 'Ubah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
					}).then((result) => {if (result.value){
						window.location = 'index.php?page=data-pindah';
						}
					})</script>";
                } else {
                    echo "<script>
					Swal.fire({title: 'Ubah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
					}).then((result) => {if (result.value){
						window.location = 'index.php?page=edit-pindah&kode=" . $data_cek['id_pindah'] . "';
						}
					})</script>";
                }
            } else {
                echo "<script>
				Swal.fire({title: 'Ukuran file maksimal 10MB',text: '',icon: 'error',confirmButtonText: 'OK'
				}).then((result) => {if (result.value){
					window.location = 'index.php?page=edit-pindah&kode=" . $data_cek['id_pindah'] . "';
					}
				})</script>";
            }
        } else {
            echo "<script>
			Swal.fire({title: 'Ekstensi file harus (.pdf)',text: '',icon: 'error',confirmButtonText: 'OK'
			}).then((result) => {if (result.value){
				window.location = 'index.php?page=edit-pindah&kode=" . $data_cek['id_pindah'] . "';
}
})</script>";
        }
    } else {
        $sql_ubah = "UPDATE tb_pindah SET
tgl_pindah='" . $_POST['tgl_pindah'] . "',
alasan='" . $_POST['alasan'] . "'
WHERE id_pindah='" . $_POST['id_pindah'] . "'";
        $query_ubah = mysqli_query($koneksi, $sql_ubah);
        mysqli_close($koneksi);

        if ($query_ubah) {
            echo "<script>
Swal.fire({
    title: 'Ubah Data Berhasil',
    text: '',
    icon: 'success',
    confirmButtonText: 'OK'
}).then((result) => {
    if (result.value) {
        window.location = 'index.php?page=data-pindah';
    }
})
</script>";
        } else {
            echo "<script>
Swal.fire({
    title: 'Ubah Data Gagal',
    text: '',
    icon: 'error',
    confirmButtonText: 'OK'
}).then((result) => {
    if (result.value) {
        window.location = 'index.php?page=edit-pindah&kode=" . $data_cek['id_pindah'] . "';
    }
})
</script>";
        }
    }
}