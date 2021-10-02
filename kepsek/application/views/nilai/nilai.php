<?php
$ci = get_instance(); // Memanggil object utama	 
$ci->load->helper('my_function'); // Memanggil fungsi pada helper dengan nama my_function
$ci->load->model('Krs_model'); // Memanggil Krs_model yang terdapat pada model
$ci->load->model('Siswa_model'); // Memanggil Siswa_model yang terdapat pada model
$ci->load->model('Pelajaran_model'); // Memanggil Pelajaran_model yang terdapat pada model
$ci->load->model('Angkatan_model'); // Memanggil Angkatan_model yang terdapat pada model

$krs             = $ci->Krs_model->get_by_id($id_krs[0]); // Menampilkan nilai KRS berdasarkan id 
$kode_pelajaran = $krs->kode_pelajaran; // Mengambil data kode_pelajaran
$kode_angkatan     = $krs->kode_angkatan; // Mengambil data kode_angkatan
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

			<!-- Form Input Nilai Permatakuliah Akhir -->
			<center>
				<legend>MASUKKAN NILAI AKHIR</legend>

				<table>
					<tr>
						<td>Kode Pelajaran </td>
						<td>: <?php echo $kode_pelajaran; ?></td>
					</tr>
					<tr>
						<td>Pelajaran</td>
						<td> : <?php echo $ci->Pelajaran_model->get_by_id($kode_pelajaran)->nama_pelajaran; ?></td>
					</tr>
					<tr>
						<td>KKM </td>
						<td> : <?php echo $ci->Pelajaran_model->get_by_id($kode_pelajaran)->kkm; ?></td>
					</tr>
					<?php
					$angkatan      = $ci->Angkatan_model->get_by_id($kode_angkatan); // Memanggil data berdasarkan id 	 	 

					?>

					<tr>
						<td>Angkatan</td>
						<td> : <?php echo $angkatan->nama_angkatan . " (" . $angkatan->tahun_angkatan . ")"; ?> </td>
					</tr>
				</table>
			</center>
			<div>&nbsp;</div>
			<table class="table table-bordered table table-striped">
				<tr>
					<td>NO</td>
					<td>NIS</td>
					<td>NAMA LENGKAP</td>
					<td>NILAI KEAKTIFAN 20%</td>
					<td>NILAI PENUGASAN 20%</td>
					<td>NILAI UJIAN 60%</td>
					<td>NILAI AKHIR</td>
					<td>KELULUSAN</td>
				</tr>
				<?php
				$no = 0;
				for ($i = 0; $i < sizeof($id_krs); $i++) {
					$no++;
				?>
					<tr>
						<td><?php echo $no; ?></td>
						<?php $nim = $ci->Krs_model->get_by_id($id_krs[$i])->nim; ?>
						<td><?php echo $nim; ?></td>
						<td><?php echo $ci->Siswa_model->get_by_id($nim)->nama_lengkap; ?></td>
						<td><?php echo $ci->Krs_model->get_by_id($id_krs[$i])->nilai_keaktifan; ?></td>
						<td><?php echo $ci->Krs_model->get_by_id($id_krs[$i])->nilai_penugasan; ?></td>
						<td><?php echo $ci->Krs_model->get_by_id($id_krs[$i])->nilai_ujian; ?></td>
						<!-- Nilai Akhir -->
						<?php
						$nilai_keaktifan = $ci->Krs_model->get_by_id($id_krs[$i])->nilai_keaktifan;
						$nilai_penugasan = $ci->Krs_model->get_by_id($id_krs[$i])->nilai_penugasan;
						$nilai_ujian = $ci->Krs_model->get_by_id($id_krs[$i])->nilai_ujian;

						$nilai_akhir = ($nilai_keaktifan * 0.3) + ($nilai_penugasan * 0.3) + ($nilai_ujian * 0.4);

						if ($nilai_akhir >= $ci->Pelajaran_model->get_by_id($kode_pelajaran)->kkm) {
							$kelulusan = "Lulus";
						} else {
							$kelulusan = "Tidak Lulus";
						}
						?>
						<td><?php echo $nilai_akhir ?></td>
						<td><?php echo $kelulusan ?></td>
					</tr>
				<?php
				}
				?>
			</table>
