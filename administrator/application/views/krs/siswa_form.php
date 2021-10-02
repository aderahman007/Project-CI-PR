
<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">KRS Siswa</a></li>
		<li class="active"><?php echo $button ?> KRS Siswa</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Form KRS Siswa-->
			<legend>Kartu Rencana Studi Siswa</legend>
			<form action="<?php echo $action; ?>" method="post">
				<?php echo validation_errors(); ?>
				<div class="form-group">
					<label for="char">Nomor Siswa <?php echo form_error('nim') ?></label>
					<input type="text" class="form-control" name="nim" id="nim" placeholder="Nomor Siswa" value="<?php echo $nim; ?>" />
				</div>
				<!-- <div class="form-group">
					<label for="int">
						Kode Angkatan
						<?php echo form_error('kode_angkatan') ?>
					</label>
					<?php
					// Query untuk menampilkan data tahun akademik	
					$query = $this->db->query('SELECT kode_angkatan, tahun_angkatan, nama_angkatan
												FROM angkatan ORDER BY tahun_angkatan DESC');
					$dropdowns = $query->result();

					foreach ($dropdowns as $dropdown) {

						$dropDownList[$dropdown->kode_angkatan] = $dropdown->nama_angkatan . " (" . $dropdown->tahun_angkatan . ")";
					}
					echo  form_dropdown('kode_angkatan', $dropDownList, '', 'class="form-control" id="kode_angkatan"');
					?>
				</div> -->
				<button type="submit" class="btn btn-primary">Proses</button>
			</form>