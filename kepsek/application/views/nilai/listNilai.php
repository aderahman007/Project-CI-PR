<?php
$ci = get_instance(); // Memanggil object utama	  
$ci->load->model('Pelajaran_model'); // Memanggil Pelajaran_model yang terdapat pada model
$ci->load->model('Angkatan_model'); // Memanggil Angkatan_model yang terdapat pada model
?>
<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">Nilai Per Pelajaran</a></li>
		<li class="active"><?php echo $button ?> Nilai Per Pelajaran</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Form KRS-->
			<?php
			// Jika tidak ada matakuliah di tahun akademik yang dipilih 
			if ($list_nilai == null) {
				$angkatan      = $ci->Angkatan_model->get_by_id($kode_angkatan); // Memilih tahun akademik berdasarkan id
				$cek = $angkatan->kode_angkatan == null; // Semester ditampilkan dalam bentuk interger yaitu 1 (ganjil dan 2 (genap)

				$pelajaran      = $ci->Pelajaran_model->get_by_id($kode_pelajaran); // Memilih tahun akademik berdasarkan id

				if ($pelajaran == null) {
					$tampilPelajaran = $kode_pelajaran;
				} else {
					$tampilPelajaran = $pelajaran->nama_pelajaran;
				}

			?>
				<div class="alert alert-danger">
					<strong>MAAF!</strong> tidak ada pelajaran <?php echo $tampilPelajaran; ?> di Angkatan <?php echo $angkatan->nama_angkatan . " (" . $angkatan->tahun_angkatan . ")"; ?>
				</div>
			<?php
			} else {
			?>
				<center>
					<legend>MASUKKAN NILAI AKHIR</legend>

					<table>
						<tr>
							<td>Kode Pelajaran </td>
							<td>:
								<?php echo $kode_pelajaran; ?></td>
						</tr>
						<tr>
							<td>Pelajaran</td>
							<td> :
								<?php echo $ci->Pelajaran_model->get_by_id($kode_pelajaran)->nama_pelajaran; ?></td>
						</tr>
						<tr>
							<td>KKM </td>
							<td> :
								<?php echo $ci->Pelajaran_model->get_by_id($kode_pelajaran)->kkm; ?></td>
						</tr>
						<?php
						$angkatan      = $ci->Angkatan_model->get_by_id($kode_angkatan); // Memilih tahun akademik berdasarkan id

						?>

						<tr>
							<td>Angkatan</td>
							<td> : <?php echo $angkatan->nama_angkatan . "(" . $angkatan->tahun_angkatan . ")"; ?> </td>
						</tr>
					</table>
				</center>
				<form action="<?php echo $action; ?>" method="post">
					<table class="table table-bordered table table-striped">
						<tr>
							<td>NO</td>
							<td>NIS</td>
							<td>NAMA</td>
							<td>NILAI KEAKTIFAN 20%</td>
							<td>NILAI PENUGASAN 20%</td>
							<td>NILAI UJIAN 60%</td>
						</tr>

						<?php
						$no = 0; // Nomor urut dalam menampilkan data 

						// Menampilkan data nilai
						foreach ($list_nilai as $row) {
							$no++;
						?>
							<tr>
								<td><?php echo $no; ?></td>
								<td><?php echo $row->nim; ?></td>
								<td><?php echo $row->nama_lengkap; ?></td>
								<input type="hidden" name="id_krs[]" value="<?php echo $row->id_krs; ?>" />
								<td><input type="text" name="nilai_keaktifan[]" value="<?php echo $row->nilai_keaktifan; ?>" /></td>
								<td><input type="text" name="nilai_penugasan[]" value="<?php echo $row->nilai_penugasan; ?>" /></td>
								<td><input type="text" name="nilai_ujian[]" value="<?php echo $row->nilai_ujian; ?>" /></td>
							</tr>
						<?php
						}
						?>
					</table>
					<button type="submit" class="btn btn-primary">Proses</button>
				</form>
			<?php
			}
			?>
