
<section class="content-header">
  <h1>
    Sekolah Polisi Negara Polda Lampung
    <small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="<?php echo $back ?>">Materi Perkuliahan</a></li>
    <li class="active"><?php echo $button ?> Materi Perkuliahan</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="box">
    <div class="box-body">

      <!-- Form input dan edit Materi Perkuliahan-->
      <legend><?php echo $button ?> Materi Perkuliahan</legend>
      <form action="<?php echo $action; ?>" method="post">
        <input type="hidden" class="form-control" name="id_materiperkuliahan" id="id_materiperkuliahan" value="<?php echo $id_materiperkuliahan; ?>" />
        <div class="form-group">
          <label for="varchar">Judul Materi Perkuliahan <?php echo form_error('judul_materiperkuliahan') ?></label>
          <input type="text" class="form-control" name="judul_materiperkuliahan" id="judul_materiperkuliahan" placeholder="Judul Materi Perkuliahan" value="<?php echo $judul_materiperkuliahan; ?>" />
        </div>
        <div class="form-group">
          <label for="varchar">Isi Materi Perkuliahan <?php echo form_error('isi_materiperkuliahan') ?></label>
          <input type="text" class="form-control" name="isi_materiperkuliahan" id="isi_materiperkuliahan" placeholder="Isi Materi Perkuliahan" value="<?php echo $isi_materiperkuliahan; ?>" />
        </div>
        <div class="form-group">
          <label for="varchar">Icon <?php echo form_error('icon') ?></label>
          <input type="text" class="form-control" name="icon" id="icon" placeholder="Icon" value="<?php echo $icon; ?>" />
        </div>
        <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
        <a href="<?php echo site_url('materi_perkuliahan') ?>" class="btn btn-default">Cancel</a>
      </form>
      <!-- // Form input dan edit Materi Perkuliahan-->