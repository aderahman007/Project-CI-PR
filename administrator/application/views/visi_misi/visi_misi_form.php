<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">Visi & Misi</a></li>
		<li class="active"><?php echo $button ?> Visi & Misi</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Form input dan edit Dosen-->
			<legend><?php echo $button ?> Visi & Misi</legend>
			<form role="form" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" class="form-control" name="id" id="id" value="<?php echo $id; ?>" />

				<div class="form-group">
					<label for="varchar">Visi <?php echo form_error('visi') ?></label>
					<textarea type="text" class="form-control" name="visi" id="visi" placeholder="Visi" value="<?php echo $visi; ?>" cols="30" rows="10"><?= ($this->uri->segment('2') == 'update' ? $visi : '') ?></textarea>
				</div>
				<div class="form-group">
					<label for="varchar">Misi <?php echo form_error('misi') ?></label>
					<textarea type="text" class="form-control" name="misi" id="misi" placeholder="Misi" value="<?php echo $misi; ?>" cols="30" rows="10"><?= ($this->uri->segment('2') == 'update' ? $misi : '') ?></textarea>
				</div>

				<button type="submit" class="btn btn-primary"><?php echo $button ?></button>
				<a href="<?php echo site_url('visi_misi') ?>" class="btn btn-default">Cancel</a>
			</form>