<div class="card card-secondary">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fa fa-table"></i> Data Pendatang
        </h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="table-responsive">
            <div>
                <a href="?page=add-datang" class="btn btn-info">
                    <i class="fa fa-edit"></i> Tambah Data</a>
            </div>
            <br>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Jekel</th>
                        <th>Tanggal</th>
                        <th>Pelapor</th>
                        <th>File Surat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
					$no = 1;
					$sql = $koneksi->query("SELECT d.id_datang, d.nik, d.nama_datang, d.jekel, d.tgl_datang, p.nama, d.filename_datang, d.path_file from 
			  tb_datang d inner join tb_pdd p on d.pelapor=p.id_pend");
					while ($data = $sql->fetch_assoc()) {
					?>

                    <tr>
                        <td>
                            <?php echo $no++; ?>
                        </td>
                        <td>
                            <?php echo $data['nik']; ?>
                        </td>
                        <td>
                            <?php echo $data['nama_datang']; ?>
                        </td>
                        <td>
                            <?php
								if ($data['jekel'] == 'LK') {
									echo "laki-laki";
								} else {
									echo "perempuan";
								}

								?>
                        </td>
                        <td>
                            <?php echo $data['tgl_datang']; ?>
                        </td>
                        <td>
                            <?php echo $data['nama']; ?>
                        </td>
                        <td>
                            <a href="<?= $data['path_file'] . $data['filename_datang'] ?>"
                                class="btn btn-sm btn-warning" target="_BLANK">Lihat surat</a>
                        </td>
                        <td>
                            <a href="?page=edit-datang&kode=<?php echo $data['id_datang']; ?>" title="Ubah"
                                class="btn btn-success btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="?page=del-datang&kode=<?php echo $data['id_datang']; ?>"
                                onclick="return confirm('Apakah anda yakin hapus data ini ?')" title="Hapus"
                                class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                                </>
                        </td>
                    </tr>

                    <?php
					}
					?>
                </tbody>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- /.card-body -->