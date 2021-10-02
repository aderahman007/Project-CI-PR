
<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">Menu</a></li>
		<li class="active"><?php echo $button ?> Menu</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Form input dan edit Menu -->
			<h2 style="margin-top:0px">Menu <?php echo $button ?></h2>
			<form action="<?php echo $action; ?>" method="post">
				<div class="form-group">
					<label for="varchar">Nama Menu <?php echo form_error('nama_menu') ?></label>
					<input type="text" class="form-control" name="nama_menu" id="nama_menu" placeholder="Nama Menu" value="<?php echo $nama_menu; ?>" />
				</div>
				<div class="form-group">
					<label for="varchar">Link <?php echo form_error('link') ?></label>
					<input type="text" class="form-control" name="link" id="link" placeholder="Link" value="<?php echo $link; ?>" />
				</div>
				<div class="form-group">
					<label for="varchar">Icon <?php echo form_error('icon') ?></label>
					<input type="text" class="form-control" name="icon" id="icon" placeholder="Icon" value="<?php echo $icon; ?>" />
				</div>
				<div class="form-group">
					<label for="int">Main Menu <?php echo form_error('main_menu') ?></label>
					<?php
					echo combobox('main_menu', 'menu', 'nama_menu', 'id_menu', $id_menu);
					?>
				</div>
				<input type="hidden" name="id_menu" value="<?php echo $id_menu; ?>" />
				<button type="submit" class="btn btn-primary"><?php echo $button ?></button>
				<a href="<?php echo site_url('menu') ?>" class="btn btn-default">Cancel</a>
			</form>