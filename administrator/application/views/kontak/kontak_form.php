
<section class="content-header">
  <h1>
    Sekolah Polisi Negara Polda Lampung
    <small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo $back ?>">Kontak</a></li>
    <li class="active"><?php echo $button ?> Kontak</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-body">
      <form action="<?php echo $action; ?>" method="post">
        <div class="form-group">
          <label for="varchar">Nama <?php echo form_error('nama') ?></label>
          <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama; ?>" />
        </div>
        <div class="form-group">
          <label for="varchar">Email <?php echo form_error('email') ?></label>
          <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" />
        </div>
        <div class="form-group">
          <label for="varchar">Telp <?php echo form_error('telp') ?></label>
          <input type="text" class="form-control" name="telp" id="telp" placeholder="Telp" value="<?php echo $telp; ?>" />
        </div>
        <div class="form-group">
          <label for="varchar">Pesan <?php echo form_error('pesan') ?></label>
          <input type="text" class="form-control" name="pesan" id="pesan" placeholder="Pesan" value="<?php echo $pesan; ?>" />
        </div>
        <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
        <a href="<?php echo site_url('kontak') ?>" class="btn btn-default">Cancel</a>
      </form>