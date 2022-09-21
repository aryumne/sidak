<?php
if(isset($_GET['pend']) && isset($_GET['pindah'])){
            $sql_hapus = "DELETE FROM tb_pindah WHERE id_pindah='".$_GET['pindah']."'";
            $sql_update = "UPDATE tb_pdd SET 
			status='Ada'
			WHERE id_pend='".$_GET['pend']."'";
            $query_hapus = mysqli_query($koneksi, $sql_hapus);
            $query_update = mysqli_query($koneksi, $sql_update);

            if ($query_hapus) {
                echo "<script>
                Swal.fire({title: 'Hapus Data Berhasil',text: '',icon: 'success',confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.value) {
                        window.location = 'index.php?page=data-pindah';
                    }
                })</script>";
                }else{
                echo "<script>
                Swal.fire({title: 'Hapus Data Gagal',text: '',icon: 'error',confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.value) {
                        window.location = 'index.php?page=data-pindah';
                    }
                })</script>";
            }
        }

