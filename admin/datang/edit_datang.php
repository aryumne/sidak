<?php

if (isset($_GET['kode'])) {
	$sql_cek = "SELECT d.id_datang, d.nik, d.nama_datang, d.jekel, d.tgl_datang, p.id_pend, p.nama from 
		tb_datang d inner join tb_pdd p on d.pelapor=p.id_pend WHERE id_datang='" . $_GET['kode'] . "'";
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

            <input type="hidden" class="form-control" id="id_datang" name="id_datang"
                value="<?php echo $data_cek['id_datang']; ?>" readonly />

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">NIK</label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" id="nik" name="nik" maxlenght="16"
                        value="<?php echo $data_cek['nik']; ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="nama_datang" name="nama_datang"
                        value="<?php echo $data_cek['nama_datang']; ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-3">
                    <select name="jekel" id="jekel" class="form-control">
                        <option value="">-- Pilih jekel --</option>
                        <?php
						//menhecek data yg dipilih sebelumnya
						if ($data_cek['jekel'] == "LK") echo "<option value='LK' selected>Laki-laki</option>";
						else echo "<option value='LK'>Laki-laki</option>";

						if ($data_cek['jekel'] == "PR") echo "<option value='PR' selected>Perempuan</option>";
						else echo "<option value='PR'>Perempuan</option>";
						?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tgl Datang</label>
                <div class="col-sm-3">
                    <input type="date" class="form-control" id="tgl_datang" name="tgl_datang"
                        value="<?php echo $data_cek['tgl_datang']; ?>" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Pelapor</label>
                <div class="col-sm-6">
                    <select name="pelapor" id="prlapor" class="form-control select2bs4" required>
                        <option selected="">- Pilih -</option>
                        <?php
						// ambil data dari database
						$query = "select * from tb_pdd";
						$hasil = mysqli_query($koneksi, $query);
						while ($row = mysqli_fetch_array($hasil)) {
						?>
                        <option value="<?php echo $row['id_pend'] ?>"
                            <?= $data_cek['id_pend'] == $row['id_pend'] ? "selected" : null ?>>
                            <?php echo $row['nik'] ?>
                            -
                            <?php echo $row['nama'] ?>
                        </option>
                        <?php
						}
						?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Surat Pindah</label>
                <div class="col-sm-6">
                    <input type="file" class="form-control" id="file_datang" name="file_datang">
                </div>
            </div>

        </div>
        <div class="card-footer">
            <input type="submit" name="Ubah" value="Simpan" class="btn btn-info">
            <a href="?page=data-datang" title="Kembali" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?php

if (isset($_POST['Ubah'])) {
	if ($_FILES['file_datang']['size'] != 0) {
		$ext_allowed = 'pdf';
		$filename = $_FILES['file_datang']['name'];
		$explod = explode('.', $filename);
		$ext = strtolower(end($explod));
		$size = $_FILES['file_datang']['size'];
		$file_tmp = $_FILES['file_datang']['tmp_name'];
		if ($ext === $ext_allowed) {
			if ($size < 102400) {
				move_uploaded_file($file_tmp, 'dist/files/datang/' . $filename);
				$sql_simpan =
					"UPDATE tb_datang SET 
                    nik='" . $_POST['nik'] . "',
					nama_datang='" . $_POST['nama_datang'] . "',
					jekel='" . $_POST['jekel'] . "',
					tgl_datang='" . $_POST['tgl_datang'] . "',
					pelapor='" . $_POST['pelapor'] . "',
                    filename_datang = '" . $filename . "'
		            WHERE id_datang='" . $_POST['id_datang'] . "'";
				$query_update = mysqli_query($koneksi, $sql_simpan);

				if ($query_update) {
					echo "<script>
					Swal.fire({title: 'Ubah Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
					}).then((result) => {if (result.value){
						window.location = 'index.php?page=data-datang';
						}
					})</script>";
				} else {
					echo "<script>
					Swal.fire({title: 'Ubah Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
					}).then((result) => {if (result.value){
						window.location = 'index.php?page=edit-datang&kode=" . $data_cek['id_datang'] . "';
						}
					})</script>";
				}
			} else {
				echo "<script>
				Swal.fire({title: 'Ukuran file maksimal 10MB',text: '',icon: 'error',confirmButtonText: 'OK'
				}).then((result) => {if (result.value){
					window.location = 'index.php?page=edit-datang&kode=" . $data_cek['id_datang'] . "';
					}
				})</script>";
			}
		} else {
			echo "<script>
			Swal.fire({title: 'Ekstensi file harus (.pdf)',text: '',icon: 'error',confirmButtonText: 'OK'
			}).then((result) => {if (result.value){
				window.location = 'index.php?page=edit-datang&kode=" . $data_cek['id_datang'] . "';
            }
            })</script>";
		}
	} else {
		$sql_ubah = "UPDATE tb_datang SET 
		nik='" . $_POST['nik'] . "',
		nama_datang='" . $_POST['nama_datang'] . "',
		jekel='" . $_POST['jekel'] . "',
		tgl_datang='" . $_POST['tgl_datang'] . "',
		pelapor='" . $_POST['pelapor'] . "'
		WHERE id_datang='" . $_POST['id_datang'] . "'";
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
                    window.location = 'index.php?page=data-datang';
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
                    window.location = 'index.php?page=edit-datang&kode=" . $data_cek['id_datang'] . "';
                }
            })
            </script>";
		}
	}
}