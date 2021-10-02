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
			<legend>Kartu Hasil Studi Siswa</legend>
			<form action="<?php echo $action; ?>" method="post">
				<?php echo validation_errors(); ?>

				<div class="form-group">
					<label for="char">Nis <?php echo form_error('nim') ?></label>
					<input type="text" class="form-control" name="nim" id="nim" placeholder="NIS" value="<?php echo $username; ?>" readonly />
				</div>
				<div class="form-group">
					<label for="int">Angkatan <?php echo form_error('kode_angkatan') ?></label>
					<?php
					// Query untuk menampilkan data tahun akademik semester
					$query = $this->db->query('SELECT kode_angkatan, tahun_angkatan, 
													 nama_angkatan
													 FROM angkatan
													 ORDER BY kode_angkatan DESC');

					$dropdowns = $query->result();

					// Menampilkan data tahun akademik semester
					foreach ($dropdowns as $dropdown) {

						
						$dropDownList[$dropdown->kode_angkatan] = $dropdown->nama_angkatan . " " . $dropdown->tahun_angkatan;
					}

					echo  form_dropdown('kode_angkatan', $dropDownList, '', 'class="form-control" id="kode_angkatan"');
					?>

				</div>

				<button type="submit" class="btn btn-primary">Proses</button>

			</form>