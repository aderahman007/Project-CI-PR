
<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">Gallery</a></li>
		<li class="active"><?php echo $button ?> Gallery</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Form input dan edit Gallery-->
			<legend><?php echo $button ?> Gallery</legend>
			<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" class="form-control" name="id_gallery" id="id_gallery" value="<?php echo $id_gallery; ?>" />
				<input type="hidden" class="form-control" name="gambar" id="gambar" value="<?php echo $gambar; ?>" />
				<div class="form-group">
					<label for="varchar">Judul Gallery <?php echo form_error('judul_gallery') ?></label>
					<input type="text" class="form-control" name="judul_gallery" id="judul_gallery" placeholder="Judul Gallery" value="<?php echo $judul_gallery; ?>" />
				</div>
				<div class="form-group">
					<label for="varchar">Gambar <?php echo form_error('gambar') ?></label>
					<div>
						<?php
						if ($gambar == "") {
							echo "<p class='help-block'>Silahkan upload gambar kegiatan & lomba</p>";
						} else {
						?>
							<div>
								<img src="../../../images/gallery/<?php echo $gambar; ?>">
							</div><br />
						<?php
						}
						?>
						<input type="file" name="gambar" id="gambar" value="<?= $gambar; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="enum">Aktif <?php echo form_error('aktif') ?></label>
					<select name="aktif" class="form-control select2" style="width: 100%;">
						<?php
						if ($aktif == 'Y') {
						?>
							<option value="Y" selected>Ya</option>
							<option value="N">Tidak</option>
						<?php
						} elseif ($aktif == 'N') {
						?>
							<option value="Y">Ya</option>
							<option value="N" selected>Tidak</option>
						<?php
						} else {
						?>
							<option value="Y">Ya</option>
							<option value="N">Tidak</option>
						<?php
						}
						?>
					</select>
				</div>

				<button type="submit" class="btn btn-primary"><?php echo $button ?></button>
				<a href="<?php echo site_url('gallery') ?>" class="btn btn-default">Cancel</a>
			</form>
			</body>

			</html>