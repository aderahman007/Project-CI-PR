<!doctype html>
<html>
    <head>
        <title>Detail informasi</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Informasi Read</h2>
		
		
		 <a href="<?php echo site_url('informasi/update/'.$id_informasi) ?>" class="btn btn-primary">Update</a>
		 
		 <a href="<?php echo site_url('informasi') ?>" class="btn btn-warning">Cancel</a>
		 
        <table class="table table-striped table-bordered">
	    <tr><td>Id Informasi</td><td><?php echo $id_informasi; ?></td></tr>
	    <tr><td>Id Kategori</td><td><?php echo $id_kategori; ?></td></tr>
	    <tr><td>Username</td><td><?php echo $username; ?></td></tr>
	    <tr><td>Judul Informasi</td><td><?php echo $judul_informasi; ?></td></tr>
	    <tr><td>Judul Seo</td><td><?php echo $judul_seo; ?></td></tr>
	    <tr><td>Isi Informasi</td><td><?php echo $isi_informasi; ?></td></tr>
	    <tr><td>Tanggal</td><td><?php echo $tanggal; ?></td></tr>
	    <tr><td>Hari</td><td><?php echo $hari; ?></td></tr>
	    <tr><td>Gambar</td><td><?php echo $gambar; ?></td></tr>
	    <tr><td>Dibaca</td><td><?php echo $dibaca; ?></td></tr>
	    <tr><td>Aktif</td><td><?php echo $aktif; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('informasi') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>