
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

			<!-- Tampil Data Pelajaran -->
			<legend><?php echo $button ?> Pelajaran</legend>
			<!-- Button untuk melakukan update -->
			<a href="<?php echo site_url('pelajaran/update/' . $kode_pelajaran) ?>" class="btn btn-primary">Update</a>
			<!-- Button cancel untuk kembali ke halaman siswa list -->
			<a href="<?php echo site_url('pelajaran') ?>" class="btn btn-warning">Cancel</a>
			<p></p>
			<table class="table table-striped table-bordered">
				<tr>
					<td>Kode Pelajaran</td>
					<td><?php echo $kode_pelajaran; ?></td>
				</tr>
				<tr>
					<td>Nama Pelajaran</td>
					<td><?php echo $nama_pelajaran; ?></td>
				</tr>
				<tr>
					<td>Kkm</td>
					<td><?php echo $kkm; ?></td>
				</tr>
				<tr>
					<td>Semester</td>
					<td><?php echo $semester; ?></td>
				</tr>
				
				<tr>
					<td>Kelas</td>
					<td><?php echo $nama_kelas; ?></td>
				</tr>
				<tr>
					<td></td>
					<td><a href="<?php echo site_url('pelajaran') ?>" class="btn btn-default">Cancel</a></td>
				</tr>
			</table>
			<!--// Tampil Data Pelajaran -->
