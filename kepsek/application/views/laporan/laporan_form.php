<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Kartu Hasil Studi Siswa</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">
			<!-- Form Input Nilai Permatakuliah Akhir -->
			<legend>Laporan</legend>

			<div style="margin-top: 4px; text-align: center; font-weight: bold;" id="message">
				<?php
				// Menampilkan error message
				echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : '';
				?>
			</div>

			<form action="<?php echo $action; ?>" method="post">
				<?php echo validation_errors(); ?>

				<div class="form-group">
					<label for="enum">Jenis Laporan <?php echo form_error('laporan'); ?></label>
					<?php
					$pilihan = array(
						"" => "-- Jenis Laporan --",
						"laporan_jadwal" => "Laporan Jadwal",
						"laporan_pengumuman" => "Laporan Pengumuman",
						"laporan_kegiatan" => "Laporan Kegiatan",

					);
					echo  form_dropdown('laporan', $pilihan, $laporan, 'class="form-control" id="laporan"');
					?>
				</div>


				<button type="submit" class="btn btn-primary">Proses</button>

			</form>