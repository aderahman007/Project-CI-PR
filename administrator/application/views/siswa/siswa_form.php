
<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">Siswa</a></li>
		<li class="active"><?php echo $button ?> Siswa</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Form input dan edit Mahasiswa-->
			<legend><?php echo $button ?> Siswa</legend>
			<form role="form" class="form-horizontal" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" class="form-control" name="photo" id="photo" value="<?php echo $photo; ?>" />
				<div class="form-group">
					<label class="col-sm-2" for="char">NRP</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="nim" id="nim" placeholder="NRP" value="<?php echo $nim; ?>" />
						<?php echo form_error('nim'); ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2" for="varchar">Nama Lengkap</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" placeholder="Nama Lengkap" value="<?php echo $nama_lengkap; ?>" />
						<?php echo form_error('nama_lengkap') ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2" for="varchar">Nama Panggilan </label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="nama_panggilan" id="nama_panggilan" placeholder="Nama Panggilan" value="<?php echo $nama_panggilan; ?>" />
						<?php echo form_error('nama_panggilan') ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2" for="varchar">Alamat </label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>" />
						<?php echo form_error('alamat') ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2" for="varchar">Email </label>
					<div class="col-sm-4">
						<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
						<?php echo form_error('email') ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2" for="varchar">Telp </label>
					<div class="col-sm-8">
						<input type="text" class="form-control" name="telp" id="telp" placeholder="Telp" value="<?php echo $telp; ?>" />
						<?php echo form_error('telp') ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2" for="varchar">Tempat Lahir </label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" placeholder="Tempat Lahir" value="<?php echo $tempat_lahir; ?>" />
						<?php echo form_error('tempat_lahir') ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2" for="date">Tanggal Lahir </label>
					<div class="col-sm-4">
						<input type="date" class="form-control" name="tgl_lahir" value="<?php echo isset($tgl_lahir) ? set_value('tgl_lahir', date('Y-m-d', strtotime($tgl_lahir))) : set_value('tgl_lahir'); ?>">
						<?php echo form_error('tgl_lahir') ?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2" for="enum">Jenis Kelamin</label>
					<div class="col-sm-4">
						<?php
						$pilihan = array("" => "-- Pilihan --", "L" => "Laki-laki", "P" => "Perempuan");
						echo form_dropdown('jenis_kelamin', $pilihan, $jenis_kelamin, 'class="form-control" id="jenis_kelamin"');
						echo form_error('jenis_kelamin');
						?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2" for="varchar">Agama </label>
					<div class="col-sm-4">
						<?php
						$pil_agama = array(
							"" => "-- Pilihan --",
							"Islam" => "Islam",
							"Katholik" => "Katholik",
							"Protestan" => "Protestan",
							"Hindu" => "Hindu",
							"Budha" => "Budha",
							"Lainnya" => "Lainnya"
						);
						echo form_dropdown('agama', $pil_agama, $agama, 'class="form-control" id="agama"');
						echo form_error('agama')
						?>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2" for="int">Kelas </label>
					<div class="col-sm-4">
						<?php
						$query = $this->db->query('SELECT id_kelas,nama_kelas FROM kelas');
						$dropdowns = $query->result();
						foreach ($dropdowns as $dropdown) {
							$dropDownList[$dropdown->id_kelas] = $dropdown->nama_kelas;
						}
						$finalDropDown = array_merge(array("0" => "-- Pilihan --"), $dropDownList);
						echo  form_dropdown(
							'id_kelas',
							$finalDropDown,
							$id_kelas,
							'class="form-control" id="id_kelas"'
						);
						echo form_error('id_kelas')
						?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2" for="photo">Photo</label>
					<div class="col-sm-4">
						<?php
						if ($photo == "") {
							echo "<p class='help-block'>Silahkan upload foto mahasiswa </p>";
						} else {
						?>
							<div>
								<img src="<?php echo base_url() ?>images/<?php echo $photo; ?>">
							</div><br />
						<?php
						}
						?>
						<input type="file" name="photo" id="photo" value="<?= $photo; ?>">
					</div>
				</div>
				<button type="submit" class="btn btn-primary"><?php echo $button ?></button>
				<a href="<?php echo site_url('siswa') ?>" class="btn btn-default">Cancel</a>
			</form>