<!doctype html>
<html>
    <head>
        <title>Detail kategori</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Kategori Read</h2>
		
		
		 <a href="<?php echo site_url('kategori/update/'.$id_kategori) ?>" class="btn btn-primary">Update</a>
		 
		 <a href="<?php echo site_url('kategori') ?>" class="btn btn-warning">Cancel</a>
		 
        <table class="table table-striped table-bordered">
	    <tr><td>Id Kategori</td><td><?php echo $id_kategori; ?></td></tr>
	    <tr><td>Nama Kategori</td><td><?php echo $nama_kategori; ?></td></tr>
	    <tr><td>Kategori Seo</td><td><?php echo $kategori_seo; ?></td></tr>
	    <tr><td>Aktif</td><td><?php echo $aktif; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('kategori') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>