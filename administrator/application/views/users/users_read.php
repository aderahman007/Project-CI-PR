
<!doctype html>
<html>
    <head>
        <title>Detail users</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">Users Read</h2>	
		 <!-- Button untuk melakukan update data -->
		 <a href="<?php echo site_url('users/update/'.$username) ?>" class="btn btn-primary">Update</a>
		 <!-- Button untuk melakukan cancel atau kembali ke halaman users list -->
		 <a href="<?php echo site_url('users') ?>" class="btn btn-warning">Cancel</a>
		 
        <table class="table table-striped table-bordered">
	    <tr><td>Username</td><td><?php echo $username; ?></td></tr>
	    <tr><td>Password</td><td><?php echo $password; ?></td></tr>
	    <tr><td>Email</td><td><?php echo $email; ?></td></tr>
	    <tr><td>Level</td><td><?php echo $level; ?></td></tr>
	    <tr><td>Blokir</td><td><?php echo $blokir; ?></td></tr>
	    <tr><td>Id Sessions</td><td><?php echo $id_sessions; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('users') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>