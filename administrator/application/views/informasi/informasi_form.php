
<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">Informasi</a></li>
		<li class="active"><?php echo $button ?> Informasi</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Form input dan edit Informasi -->
			<legend><?php echo $button ?> Informasi</legend>
			<form role="form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" class="form-control" name="id_informasi" id="id_informasi" value="<?php echo $id_informasi; ?>" />
				<input type="hidden" class="form-control" name="gambar" id="gambar" value="<?php echo $gambar; ?>" />
				<div class="form-group">
					<label for="int">Kategori <?php echo form_error('id_kategori') ?></label>
					<?php
					echo combobox('id_kategori', 'kategori', 'nama_kategori', 'id_kategori', $id_kategori);
					?>
				</div>
				<div class="form-group">
					<label for="varchar">Judul Informasi <?php echo form_error('judul_informasi') ?></label>
					<input type="text" class="form-control" name="judul_informasi" id="judul_informasi" placeholder="Judul Informasi" value="<?php echo $judul_informasi; ?>" />
				</div>
				<div class="form-group">
					<label for="isi_informasi">Isi Informasi <?php echo form_error('isi_informasi') ?></label>
					<textarea class="form-control" rows="3" name="isi_informasi" id="isi_informasi" placeholder="Isi Informasi"><?php echo $isi_informasi; ?></textarea>
				</div>
				<div class="form-group">
					<label for="varchar">Gambar <?php echo form_error('gambar') ?></label>
					<div>
						<?php
						if ($gambar == "") {
							echo "<p class='help-block'>Silahkan upload gambar pendukung informasi kampus </p>";
						} else {
						?>
							<div>
								<img width="280px" src="../../../images/info_kampus/<?php echo $gambar; ?>">
							</div><br />
						<?php
						}
						?>
						<input type="file" name="gambar" id="gambar">
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
				<a href="<?php echo site_url('informasi') ?>" class="btn btn-default">Cancel</a>
			</form>
			<!--// Form Informasi -->