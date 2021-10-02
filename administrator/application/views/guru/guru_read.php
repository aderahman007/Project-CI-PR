
<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">Guru</a></li>
		<li class="active"><?php echo $button ?> Guru</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Tampil Data Guru -->
			<legend><?php echo $button ?> Guru</legend>
			<!-- Button untuk melakukan update -->
			<a href="<?php echo site_url('guru/update/' . $id_guru) ?>" class="btn btn-primary">Update</a>
			<!-- Button cancel untuk kembali ke halaman guru list -->
			<a href="<?php echo site_url('guru') ?>" class="btn btn-warning">Cancel</a>
			<p></p>
			<!-- Menampilkan data guru secara detail -->
			<table class="table table-striped table-bordered">
				<tr>
					<td>Photo</td>
					<td><img src="../../../images/guru/<?php echo $photo; ?>" </td>
				</tr>
				<tr>
					<td>NIDN</td>
					<td><?php echo $nidn; ?></td>
				</tr>
				<tr>
					<td>Nama Guru</td>
					<td><?php echo $nama_guru; ?></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td><?php echo $alamat; ?></td>
				</tr>
				<tr>
					<td>Jenis Kelamin</td>
					<td><?php echo $jenis_kelamin; ?></td>
				</tr>
				<tr>
					<td>Email</td>
					<td><?php echo $email; ?></td>
				</tr>
				<tr>
					<td>Telp</td>
					<td><?php echo $telp; ?></td>
				</tr>
				<tr>
					<td></td>
					<td><a href="<?php echo site_url('guru') ?>" class="btn btn-default">Cancel</a></td>
				</tr>
			</table>