
<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">Tahun Akademik</a></li>
		<li class="active"><?php echo $button ?> Tahun Akademik</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Form input atau edit Tahun Akademik-->
			<legend><?php echo $button ?> Tahun Akademik</legend>
			<form action="<?php echo $action; ?>" method="post">
				<div class="form-group">
					<label for="varchar">Tahun Akademik <?php echo form_error('thn_akad') ?></label>
					<input type="text" class="form-control" name="thn_akad" id="thn_akad" placeholder="Tahun Akademik" value="<?php echo $thn_akad; ?>" />
				</div>
				<div class="form-group">
					<label for="varchar">Semester <?php echo form_error('semester') ?></label>
					<div class="radio">
						<label>
							<input type="radio" name="semester" id="semester" value="1" <?php
																						echo set_value('semester', $semester) == 1 ? "checked" : "";
																						?> checked />
							Ganjil
						</label>
						<label>
							<input type="radio" name="semester" id="semester" value="2" <?php
																						echo set_value('semester', $semester) == 2 ? "checked" : "";
																						?> />
							Genap
						</label>
					</div>
				</div>
				<input type="hidden" name="id_thn_akad" value="<?php echo $id_thn_akad; ?>" />
				<button type="submit" class="btn btn-primary"><?php echo $button ?></button>
				<a href="<?php echo site_url('thn_akad_semester') ?>" class="btn btn-default">Cancel</a>
			</form>