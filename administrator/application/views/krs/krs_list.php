<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active"> Kartu Rencana Studi</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Form KRS-->
			<center>
				<legend><strong>KARTU RENCANA PENGAJARAN</strong></legend>
				<table>
					<tr>
						<td><strong>NIS </strong></td>
						<td> &nbsp;: <?php echo $nim; ?></td>
					<tr>
					<tr>
						<td><strong>Nama </strong></td>
						<td> &nbsp;: <?php echo $nama_lengkap; ?> </td>
					</tr>
					<tr>
						<td><strong>Kelas</strong></td>
						<td> &nbsp;: <?php echo $kelas; ?> </td>
					</tr>
					<tr>
						<td><strong>Nama Angkatan</strong></td>
						<td> &nbsp;: <?php echo $nama_angkatan . " (" . $tahun_angkatan . ")"; ?> </td>
					</tr>
				</table>
			</center>
			<br />
			<table class="table table-bordered table table-striped" style="margin-bottom: 10px;">
				<tr>
					<th>NO</th>
					<th>KODE</th>
					<th>PELAJARAN</th>
					<th>KKM</th>
					<th>ACTION</th>
				</tr>
				<?php
				$no = 1; // Nomor urut dalam menampilkan data
				$jumlahSks = 0; // Jumlah SKS dimulai dari 0

				// Menampilkan data KRS
				foreach ($krs_data as $krs) {
				?>
					<tr>
						<td width="80px"><?php echo $no++; ?></td>
						<td><?php echo $krs->kode_pelajaran; ?></td>
						<td><?php echo $krs->nama_pelajaran; ?></td>
						<td>
							<?php
							echo $krs->kkm;
							// $jumlahKkm += $krs->kkm;
							?>
						</td>
						<td style="text-align:center" width="120px">
							<?php
							// Button untuk melakukan edit KRS
							echo anchor(
								site_url('krs/update/' . $krs->id_krs),
								'<button type="button" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i></button>'
							);
							echo '&nbsp';
							// Button untuk melakukan delete KRS
							echo anchor(
								site_url('krs/delete/' . $krs->id_krs),
								'<button type="button" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>',
								'onclick="javasciprt: return confirm(\'Are You Sure ?\')"'
							);
							?>
						</td>
					</tr>
				<?php
				}
				?>
				<!-- <tr>
					<td colspan="3"><strong>JUMLAH SKS</strong></td>
					<td><strong><?php echo $jumlahKkm; ?></strong></td>
					<td></td>
				</tr> -->
			</table>
			<?php
			// Button untuk melakukan create KRS
			echo anchor(site_url('krs/create/' . $nim . '/' . $kode_angkatan), 'Create', 'class="btn btn-primary"');
			echo anchor(site_url('krs/cetak_krs/' . $nim . '/' . $kode_angkatan), 'Cetak', 'class="btn btn-info ml"');
			?>
		</div>
