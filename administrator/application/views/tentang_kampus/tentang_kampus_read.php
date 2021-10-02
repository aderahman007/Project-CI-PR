<!doctype html>
<html>
    <head>
        <title>Detail tentang_kampus</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Tentang_kampus Read</h2>
		
		
		 <a href="<?php echo site_url('tentang_kampus/update/'.$id_tentangkampus) ?>" class="btn btn-primary">Update</a>
		 
		 <a href="<?php echo site_url('tentang_kampus') ?>" class="btn btn-warning">Cancel</a>
		 
        <table class="table table-striped table-bordered">
	    <tr><td>Id Tentangkampus</td><td><?php echo $id_tentangkampus; ?></td></tr>
	    <tr><td>Judul Tentangkampus</td><td><?php echo $judul_tentangkampus; ?></td></tr>
	    <tr><td>Isi Tentangkampus</td><td><?php echo $isi_tentangkampus; ?></td></tr>
	    <tr><td>Keterangan Tambahan</td><td><?php echo $keterangan_tambahan; ?></td></tr>
	    <tr><td>Gambar</td><td><?php echo $gambar; ?></td></tr>
	    <tr><td>Aktif</td><td><?php echo $aktif; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('tentang_kampus') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>