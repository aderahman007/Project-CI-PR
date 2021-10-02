
<section class="content-header">
  <h1>
    Sekolah Polisi Negara Polda Lampung
    <small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo $back ?>">Fasilitas</a></li>
    <li class="active"><?php echo $button ?> Fasilitas</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-body">

      <!-- Form input dan edit Fasilitas -->
      <legend><?php echo $button ?> Fasilitas</legend>
      <form action="<?php echo $action; ?>" method="post">
        <input type="hidden" class="form-control" name="id_fasilitas" id="id_fasilitas" value="<?php echo $id_fasilitas; ?>" />
        <div class="form-group">
          <label for="varchar">Nama Fasilitas <?php echo form_error('nama_fasilitas') ?></label>
          <input type="text" class="form-control" name="nama_fasilitas" id="nama_fasilitas" placeholder="Nama Fasilitas" value="<?php echo $nama_fasilitas; ?>" />
        </div>
        <div class="form-group">
          <label for="varchar">Icon <?php echo form_error('icon_fasilitas') ?></label>
          <input type="text" class="form-control" name="icon_fasilitas" id="icon_fasilitas" placeholder="Icon" value="<?php echo $icon_fasilitas; ?>" />
        </div>
        <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
        <a href="<?php echo site_url('fasilitas') ?>" class="btn btn-default">Cancel</a>
      </form>