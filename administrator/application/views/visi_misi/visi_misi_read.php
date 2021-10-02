<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">Visi & Misi</a></li>
		<li class="active"><?php echo $button ?> visi & Misi</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Tampil Data Dosen -->
			<legend><?php echo $button ?> Visi & Misi</legend>
			<!-- Button untuk melakukan update -->
			<a href="<?php echo site_url('visi_misi/update/' . $id) ?>" class="btn btn-primary">Update</a>
			<!-- Button cancel untuk kembali ke halaman dosen list -->
			<a href="<?php echo site_url('visi_misi') ?>" class="btn btn-warning">Cancel</a>
			<p></p>
			<!-- Menampilkan data dosen secara detail -->
			<table class="table table-striped table-bordered">

				<tr>
					<td>Visi</td>
					<td><?php echo $visi; ?></td>
				</tr>
				<tr>
					<td>Misi</td>
					<td><?php echo $misi; ?></td>
				</tr>

				<tr>
					<td></td>
					<td><a href="<?php echo site_url('visi_misi') ?>" class="btn btn-default">Cancel</a></td>
				</tr>
			</table>