
<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">Pelajaran</a></li>
		<li class="active"><?php echo $button ?> Pelajaran</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Form input dan edit Pelajaran-->
			<legend><?php echo $button ?> Pelajaran</legend>
			<form action="<?php echo $action; ?>" method="post">
				<div class="form-group">
					<label for="varchar">Kode Pelajaran <?php echo form_error('kode_pelajaran') ?></label>
					<input type="text" class="form-control" name="kode_pelajaran" id="kode_pelajaran" placeholder="Kode Pelajaran" value="<?php echo $kode_pelajaran; ?>" />
				</div>
				<div class="form-group">
					<label for="varchar">Nama Pelajaran <?php echo form_error('nama_pelajaran') ?></label>
					<input type="text" class="form-control" name="nama_pelajaran" id="nama_pelajaran" placeholder="Nama Pelajaran" value="<?php echo $nama_pelajaran; ?>" />
				</div>
				<div class="form-group">
					<label for="varchar">KKM <?php echo form_error('kkm') ?></label>
					<input type="text" class="form-control" name="kkm" id="kkm" placeholder="KKM" value="<?php echo $kkm; ?>" />
				</div>
				

				<div class="form-group">
					<div class="form-group">
						<label for="enum">Semester <?php echo form_error('semester'); ?></label>
						<?php
						$pilihan = array(
							"" => "-- Pilihan --",
							"1" => "1",
							"2" => "2",
						);
						echo  form_dropdown('semester', $pilihan, $semester, 'class="form-control" id="semester"'); ?>
					</div>
				</div>

				<div class="form-group">
					<label for="int">Kelas <?php echo form_error('id_kelas') ?></label>
					<?php
					echo combobox('id_kelas', 'kelas', 'nama_kelas', 'id_kelas', $id_kelas);
					?>
				</div>

				<button type="submit" class="btn btn-primary"><?php echo $button ?></button>
				<a href="<?php echo site_url('pelajaran') ?>" class="btn btn-default">Cancel</a>
			</form>
			<!--// Form Pelajaran-->
