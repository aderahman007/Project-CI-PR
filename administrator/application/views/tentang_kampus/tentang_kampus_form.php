
<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">Tentang Kampus</a></li>
		<li class="active"><?php echo $button ?> Tentang Kampus</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Form input dan edit Tentang Kampus-->
			<legend><?php echo $button ?> Tentang Kampus</legend>
			<form role="form" action="<?php echo $action; ?>" method="post" method="post" enctype="multipart/form-data">
				<input type="hidden" class="form-control" name="id_tentangkampus" id="id_tentangkampus" value="<?php echo $id_tentangkampus; ?>" />
				<input type="hidden" class="form-control" name="gambar" id="gambar" value="<?php echo $gambar; ?>" />
				<div class="form-group">
					<label for="varchar">Judul Tentang Kampus <?php echo form_error('judul_tentangkampus') ?></label>
					<input type="text" class="form-control" name="judul_tentangkampus" id="judul_tentangkampus" placeholder="Judul Tentangkampus" value="<?php echo $judul_tentangkampus; ?>" />
				</div>
				<div class="form-group">
					<label for="varchar">Isi <?php echo form_error('isi_tentangkampus') ?></label>
					<input type="text" class="form-control" name="isi_tentangkampus" id="isi_tentangkampus" placeholder="Isi Tentangkampus" value="<?php echo $isi_tentangkampus; ?>" />
				</div>
				<div class="form-group">
					<label for="varchar">Keterangan Tambahan <?php echo form_error('keterangan_tambahan') ?></label>
					<input type="text" class="form-control" name="keterangan_tambahan" id="keterangan_tambahan" placeholder="Keterangan Tambahan" value="<?php echo $keterangan_tambahan; ?>" />
				</div>
				<div class="form-group">
					<label for="varchar">Gambar <?php echo form_error('gambar') ?></label>
					<div>
						<?php
						if ($gambar == "") {
							echo "<p class='help-block'>Silahkan upload gambar pendukung tentang kampus </p>";
						} else {
						?>
							<div>
								<img width="300px" src="../../../images/tentang_kampus/<?php echo $gambar; ?>">
							</div><br />
						<?php
						}
						?>
						<input type="file" name="gambar" id="gambar">
					</div>
				</div>
				<button type="submit" class="btn btn-primary"><?php echo $button ?></button>
				<a href="<?php echo site_url('tentang_kampus') ?>" class="btn btn-default">Cancel</a>
			</form>