
<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="../admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">Users</a></li>
		<li class="active"><?php echo $button ?> Users</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Form input atau edit Users -->
			<h2 style="margin-top:0px">Users <?php echo $button ?></h2>
			<form action="<?php echo $action; ?>" method="post">
				<div class="form-group">
					<label for="varchar">Username <?php echo form_error('username') ?></label>
					<input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>" />
				</div>
				<div class="form-group">
					<label for="varchar">Password <?php echo form_error('password') ?></label>
					<input type="text" class="form-control" name="password" id="password" placeholder="Password" />
				</div>
				<div class="form-group">
					<label for="varchar">Email <?php echo form_error('email') ?></label>
					<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
				</div>
				<div class="form-group">
					<label for="enum">Level <?php echo form_error('level') ?></label>
					<select name="level" class="form-control select2" style="width: 100%;">
						<?php
						if ($level == 'admin') {
						?>
							<option value="admin" selected>Admin</option>
							<option value="user">Siswa</option>
							<option value="kepsek">Kepala Sekolah</option>
						<?php
						} else if ($level == 'user') {
						?>
							<option value="admin">Admin</option>
							<option value="user" selected>Siswa</option>
							<option value="kepsek">Kepala Sekolah</option>
						<?php
						} else if ($level == 'kepsek') {
						?>
							<option value="admin">Admin</option>
							<option value="user">Siswa</option>
							<option value="kepsek" selected>Kepala Sekolah</option>
						<?php
						} else {
						?>
							<option value="admin">Admin</option>
							<option value="user">Siswa</option>
							<option value="kepsek">Kepala Sekolah</option>
						<?php
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="enum">Blokir <?php echo form_error('blokir') ?></label>
					<select name="blokir" class="form-control select2" style="width: 100%;">
						<?php
						if ($blokir == 'Y') {
						?>
							<option value="Y" selected>Ya</option>
							<option value="N">Tidak</option>
						<?php
						} elseif ($blokir == 'N') {
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
				<a href="<?php echo site_url('users') ?>" class="btn btn-default">Cancel</a>
			</form>