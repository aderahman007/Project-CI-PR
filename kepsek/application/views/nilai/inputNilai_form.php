
<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="../admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">Nilai Per Pelajaran</a></li>
		<li class="active"><?php echo $button ?> Nilai Per Pelajaran</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Form Input Nilai Permatakuliah -->
			<legend>Input Nilai Per Pelajaran</legend>
			<form action="<?php echo $action; ?>" method="post">
				<?php echo validation_errors(); ?>
				<div class="form-group">
					<label for="int">Tahun Akademik (Semester <?php echo form_error('id_thn_akad') ?> )</label>
					<?php
					// Query untuk menampilkan data tahun akademik dan semester
					$query = $this->db->query('SELECT kode_angkatan, tahun_angkatan, 
													 nama_angkatan 
													 FROM angkatan
													 ORDER BY kode_angkatan DESC');
					$dropdowns = $query->result();

					foreach ($dropdowns as $dropdown) {

						$dropDownList[$dropdown->kode_angkatan] = $dropdown->nama_angkatan . " (" . $dropdown->tahun_angkatan . ")";
					}
					echo  form_dropdown('kode_angkatan', $dropDownList, '', 'class="form-control" id="kode_angkatan"'); ?>

					<div class="form-group">
						<label for="char">Kode Pelajaran <?php echo form_error('kode_pelajaran') ?></label>
						<input type="text" class="form-control" name="kode_pelajaran" id="kode_pelajaran" placeholder="Kode Pelajaran" value="<?php echo $kode_pelajaran; ?>" />
					</div>
				</div>

				<button type="submit" class="btn btn-primary">Proses</button>
			</form>
			<!--// Form Input Nilai Perpelajaran -->