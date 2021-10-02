<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">Kartu Hasil Studi Siswa</a></li>
		<li class="active"><?php echo $button ?> Kartu Hasil Studi Siswa</li>

	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Form Kartu Hasil Studi Siswa -->
			<?php
			$ci = get_instance(); // Memanggil object utama
			$ci->load->helper('my_function'); // Memanggil fungsi pada helper dengan nama my_function
			?>
			<!-- Menampilkan Kartu Hasil Studi -->
			<center>
				<h2>LAPORAN HASIL STUDI SISWA</h2>
				<h3>Sekolah Polisi Negara Polda Lampung</h3>
				<legend>
					<h4>Tahun Angkatan <?= $tahun_angkatan; ?></h4>
				</legend>
				<!-- <table>
					<tr>
						<td><strong>NIS </strong></td>
						<td> : <?php echo $mhs_nim; ?></td>
					</tr>
					<tr>
						<td><strong>Nama</strong></td>
						<td> : <?php echo $mhs_nama; ?></td>
					</tr>
					<tr>
						<td><strong>Kelas</strong></td>
						<td> : <?php echo $mhs_kelas; ?></td>
					</tr>
					<tr>
						<td><strong>Angkatan</strong></td>
						<td>&nbsp;: <?php echo $nama_angkatan; ?></td>
					</tr>
				</table>
				<br /> -->
				<table class="table table-bordered table table-striped">
					<tr>
						<td>NO</td>
						<td>NRP</td>
						<td>NAMA LENGKAP</td>
						<td>KELAS</td>
						<td>NILAI AKHIR</td>
					</tr>


					<?php
					$no   	=	0; // Nomor urut dalam menampilkan data 



					// Menampilkan data siswa
					foreach ($siswa_data as $row) {
						$no++;
					?>
						<tr>
							<td> <?php echo $no; ?></td>
							<td> <?php echo $row->nim; ?></td>
							<td> <?php echo $row->nama_lengkap; ?></td>
							<td> <?php echo $row->nama_kelas; ?></td>
							<td> <?php echo number_format($row->nilai_akhir / $row->jml_pel, 1); ?></td>

						</tr>

					<?php
					}
					?>

				</table>

				<a href="javascript:window.print()" class="btn btn-info al">Cetak</a>
				

			</center>
