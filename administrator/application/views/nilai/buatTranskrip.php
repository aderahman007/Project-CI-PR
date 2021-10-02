
<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="../admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Transkrip Nilai</li>
	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Menampilkan Transkrip Nilai -->
			<?php
			$ci = get_instance(); // Memanggil object utama
			$ci->load->helper('my_function'); // Memanggil fungsi pada helper dengan nama my_function
			?>
			<center>
				<legend>TRANKRIP NILAI</legend>
				<table>
					<tr>
						<td>NIS </td>
						<td> : <?php echo $nim; ?></td>
					</tr>
					<tr>
						<td>Nama </td>
						<td> : <?php echo $nama; ?></td>
					</tr>
					<tr>
						<td>Kelas </td>
						<td> : <?php echo $kelas; ?></td>
					</tr>
				</table>
				<br />
				<table class="table table-bordered table table-striped">
					<tr>
						<td>NO</td>
						<td>KODE</td>
						<td>PELAJARAN</td>
						<td align="center">KKM</td>
						<td align="center">NILAI</td>
						<td align="center">SKOR</td>
					</tr>
					<?php
					$no   = 0; // Nomor urut dalam menampilkan data 
					$jSks = 0; // Jumlah SKS awal yaitu 0
					$jSkor = 0; // Jumlah Skor awal yaitu 0

					// Menampilkan data transkrip atau nilai
					foreach ($trans as $row) {
						$no++;
					?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><?php echo $row->kode_pelajaran; ?></td>
							<td><?php echo $row->nama_pelajaran; ?></td>
							<td align="center"><?php echo $row->kkm; ?></td>
							<td align="center"><?php echo $row->nilai; ?></td>
							<td align="center"><?php echo skorNilai($row->nilai, $row->kkm); ?></td>
							<?php
							$jSks += $row->kkm;
							$jSkor += skorNilai($row->nilai, $row->kkm);
							?>
						</tr>
					<?php
					}
					?>
					<tr>
						<td colspan="3">Jumlah </td>
						<td align="center"><?php echo $jSks; ?></td>
						<td>&nbsp;</td>
						<td align="center"><?php echo $jSkor; ?></td>
					</tr>
				</table>
				Indeks Prestasi : <?php echo number_format($jSkor / $jSks, 2); ?>
			</center>