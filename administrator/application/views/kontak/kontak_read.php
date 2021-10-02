<!doctype html>
<html>
    <head>
        <title>Detail kontak</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Kontak Read</h2>
		
		
		 <a href="<?php echo site_url('kontak/update/'.$id_kontak) ?>" class="btn btn-primary">Update</a>
		 
		 <a href="<?php echo site_url('kontak') ?>" class="btn btn-warning">Cancel</a>
		 
        <table class="table table-striped table-bordered">
	    <tr><td>Id Kontak</td><td><?php echo $id_kontak; ?></td></tr>
	    <tr><td>Nama</td><td><?php echo $nama; ?></td></tr>
	    <tr><td>Email</td><td><?php echo $email; ?></td></tr>
	    <tr><td>Telp</td><td><?php echo $telp; ?></td></tr>
	    <tr><td>Pesan</td><td><?php echo $pesan; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('kontak') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>