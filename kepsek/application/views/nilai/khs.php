
<section class="content-header">
	<h1>
		Sekolah Polisi Negara Polda Lampung
		<small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
		<li><a href="<?php echo $back ?>">Kartu Hasil Studi Siswa</a></li>
		<li class="active"><?php echo $button ?> Kartu Hasil Studi Siswa</li>

	</ol>
</section>
<!-- Main content -->
<section class="content">

	<!-- Default box -->
	<div class="box">
		<div class="box-body">

			<!-- Form Kartu Hasil Studi Siswa -->
			<?php
			$ci = get_instance(); // Memanggil object utama
			$ci->load->helper('my_function'); // Memanggil fungsi pada helper dengan nama my_function
			?>
			<!-- Menampilkan Kartu Hasil Studi -->
			<center>
				<legend>KARTU HASIL STUDI</strong></legend>
				<table>
					<tr>
						<td><strong>NIS </strong></td>
						<td> : <?php echo $mhs_nim; ?></td>
					</tr>
					<tr>
						<td><strong>Nama</strong></td>
						<td> : <?php echo $mhs_nama; ?></td>
					</tr>
					<tr>
						<td><strong>Kelas</strong></td>
						<td> : <?php echo $mhs_kelas; ?></td>
					</tr>
					<tr>
						<td><strong>Angkatan</strong></td>
						<td>&nbsp;: <?php echo $nama_angkatan; ?></td>
					</tr>
				</table>
				<br />
				<table class="table table-bordered table table-striped">
					<tr>
						<td>NO</td>
						<td>KODE</td>
						<td>PELAJARAN</td>
						<td>KKM</td>
						<td>NILAI KEAKTIFAN 20%</td>
						<td>NILAI PENUGASAN 20%</td>
						<td>NILAI UJIAN 60%</td>
						<td>NILAI AKHIR</td>
						<td>KELULUSAN</td>
					</tr>
					<?php
					$no   	=	0; // Nomor urut dalam menampilkan data 
					// $jSks 	=	0; // Jumlah SKS awal yaitu 0
					$jmlNilai	=	0; // Jumlah Skor awal yaitu 0
					$banyakNilai = 0;
					$rata_rata = 0;

					// Menampilkan data KHS
					foreach ($mhs_data as $row) {
						$no++;
					?>
						<tr>
							<td> <?php echo $no; ?></td>
							<td> <?php echo $row->kode_pelajaran; ?></td>
							<td> <?php echo $row->nama_pelajaran; ?></td>
							<td align="right"> <?php echo $row->kkm; ?></td>
							<td align="center"> <?php echo $row->nilai_keaktifan; ?></td>
							<td align="center"> <?php echo $row->nilai_penugasan; ?></td>
							<td align="center"> <?php echo $row->nilai_ujian; ?></td>
							<?php
							$nilai_keaktifan = $row->nilai_keaktifan;
							$nilai_penugasan = $row->nilai_penugasan;
							$nilai_ujian = $row->nilai_ujian;

							$nilai_akhir = ($nilai_keaktifan * 0.3) + ($nilai_penugasan * 0.3) + ($nilai_ujian * 0.4);

							$banyakNilai += 1;
							$jmlNilai += $nilai_akhir;
							$rata_rata = $jmlNilai / $banyakNilai;

							if ($nilai_akhir >= $row->kkm) {
								$kelulusan = "Lulus";
							} else {
								$kelulusan = "Tidak Lulus";
							}
							?>
							<td align="center"> <?php echo $nilai_akhir; ?></td>
							<td align="center"> <?php echo $kelulusan; ?></td>
							<!-- <td align="right"> <?php echo skorNilai($row->nilai, $row->kkm); ?></td> -->
							<?php
							// $jSks += $row->sks;
							// $jSkor += skorNilai( $row->nilai, $row->kkm);
							?>
						</tr>
					<?php
					}
					?>
					<tr>

						<td align="right" colspan="7"> <?php echo "Total Nilai Akhir : "; ?></td>
						<td align="left" colspan="2" style="padding-left: 55px;"> <?php echo $jmlNilai; ?></td>
					</tr>
					<tr>
						<td align="right" colspan="7"> <?php echo "Rata-Rata Nilai Akhir : "; ?></td>
						<td align="left" colspan="2" style="padding-left: 55px;"> <?php echo number_format($rata_rata, 1); ?></td>
					</tr>
				</table>

				<?php
					echo anchor(site_url('nilai/cetak_nilai/' . $mhs_nim . '/' . $kode_angkatan), 'Cetak KRS', 'class="btn btn-info al"');
				?>

			</center>
