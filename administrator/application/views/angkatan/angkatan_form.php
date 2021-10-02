<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">Angkatan</a></li>
		<li class="active"><?php echo $button ?> Angkatan</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Form input atau edit Angkatan-->
			<legend><?php echo $button ?> Angkatan</legend>
			<form action="<?php echo $action; ?>" method="post">
				<div class="form-group">
					<label for="varchar">Kode Angkatan <?php echo form_error('kode_angkatan') ?></label>
					<input type="text" class="form-control" name="kode_angkatan" id="kode_angkatan" placeholder="Kode Angkatan" value="<?php echo $kode_angkatan; ?>" />
				</div>
				<div class="form-group">
					<label for="varchar">Tahun Angkatan <?php echo form_error('tahun_angkatan') ?></label>
					<input type="text" class="form-control" name="tahun_angkatan" id="tahun_angkatan" placeholder="Tahun Angkatan" value="<?php echo $tahun_angkatan; ?>" />
				</div>
				<div class="form-group">
					<label for="varchar">Nama Angkatan <?php echo form_error('nama_angkatan') ?></label>
					<input type="text" class="form-control" name="nama_angkatan" id="nama_angkatan" placeholder="Nama Angkatan" value="<?php echo $nama_angkatan; ?>" />
				</div>
				<input type="hidden" name="id" value="<?php echo $kode_angkatan; ?>" />
				<button type="submit" class="btn btn-primary"><?php echo $button ?></button>
				<a href="<?php echo site_url('angkatan') ?>" class="btn btn-default">Cancel</a>
			</form>