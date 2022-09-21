<?php
if(isset($_GET['pdd']) && isset($_GET['mendu'])){
            $sql_update = "UPDATE tb_pdd SET 
			status='Ada'
			WHERE id_pend='".$_GET['pdd']."'";
            $sql_hapus = "DELETE FROM tb_mendu WHERE id_mendu='".$_GET['mendu']."'";
            $query_update = mysqli_query($koneksi, $sql_update);
            $query_hapus = mysqli_query($koneksi, $sql_hapus);

            if ($query_hapus) {
                echo "<script>
                Swal.fire({title: 'Hapus Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.value) {
                        window.location = 'index.php?page=data-mendu';
                    }
                })</script>";
                }else{
                echo "<script>
                Swal.fire({title: 'Hapus Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.value) {
                        window.location = 'index.php?page=data-mendu';
                    }
                })</script>";
            }
        }

