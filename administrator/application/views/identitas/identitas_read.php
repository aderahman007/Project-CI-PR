<!doctype html>
<html>
    <head>
        <title>Detail identitas</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Identitas Read</h2>
		
		
		 <a href="<?php echo site_url('identitas/update/'.$id_identitas) ?>" class="btn btn-primary">Update</a>
		 
		 <a href="<?php echo site_url('identitas') ?>" class="btn btn-warning">Cancel</a>
		 
        <table class="table table-striped table-bordered">
	    <tr><td>Id Identitas</td><td><?php echo $id_identitas; ?></td></tr>
	    <tr><td>Nama Pemilik</td><td><?php echo $nama_pemilik; ?></td></tr>
	    <tr><td>Judul Website</td><td><?php echo $judul_website; ?></td></tr>
	    <tr><td>Url</td><td><?php echo $url; ?></td></tr>
	    <tr><td>Meta Deskripsi</td><td><?php echo $meta_deskripsi; ?></td></tr>
	    <tr><td>Meta Keyword</td><td><?php echo $meta_keyword; ?></td></tr>
	    <tr><td>Alamat</td><td><?php echo $alamat; ?></td></tr>
	    <tr><td>Email</td><td><?php echo $email; ?></td></tr>
	    <tr><td>Telp</td><td><?php echo $telp; ?></td></tr>
	    <tr><td>Facebook</td><td><?php echo $facebook; ?></td></tr>
	    <tr><td>Twitter</td><td><?php echo $twitter; ?></td></tr>
	    <tr><td>Twitter Widget</td><td><?php echo $twitter_widget; ?></td></tr>
	    <tr><td>Google Map</td><td><?php echo $google_map; ?></td></tr>
	    <tr><td>Favicon</td><td><?php echo $favicon; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('identitas') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>