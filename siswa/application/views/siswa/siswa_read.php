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

			<!-- Tampil Data Siswa -->
			<legend><?php echo $button ?> Siswa</legend>
			<!-- Button untuk melakukan update -->
			<a href="<?php echo site_url('siswa/update/' . $nim) ?>" class="btn btn-primary">Update</a>
			<!-- Button cancel untuk kembali ke halaman siswa list -->
			<a href="<?php echo site_url('siswa') ?>" class="btn btn-warning">Cancel</a>
			<p></p>
			<!-- Menampilkan data siswa secara detail -->
			<table class="table table-striped table-bordered">
				<tr>
					<td>Photo</td>
					<td><img src="<?=base_url()?>../administrator/images/<?php echo $photo; ?>"></td>
				</tr>
				<tr>
					<td>Nis</td>
					<td><?php echo $nim; ?></td>
				</tr>
				<tr>
					<td>Nama Lengkap</td>
					<td><?php echo $nama_lengkap; ?></td>
				</tr>
				<tr>
					<td>Nama Panggilan</td>
					<td><?php echo $nama_panggilan; ?></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td><?php echo $alamat; ?></td>
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
					<td>Tempat Lahir</td>
					<td><?php echo $tempat_lahir; ?></td>
				</tr>
				<tr>
					<td>Tanggal Lahir</td>
					<td><?php echo tgl_indo($tgl_lahir); ?></td>
				</tr>
				<tr>
					<td>Jenis Kelamin</td>
					<td>
						<?php
						if ($jenis_kelamin == "L") {
							echo "Laki-laki";
						} else {
							echo "Perempuan";
						}
						?>
					</td>
				</tr>
				<tr>
					<td>Agama</td>
					<td><?php echo $agama; ?></td>
				</tr>
				<tr>
					<td>Kelas</td>
					<td><?php echo inputtext('id_kelas', 'kelas', 'nama_kelas', 'id_kelas', $id_kelas); ?></td>
				</tr>
			</table>