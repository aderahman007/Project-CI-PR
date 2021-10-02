<section class="content-header">
    <h1>
        Sekolah Polisi Negara Polda Lampung
        <small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $back ?>">Kegiatan</a></li>
        <li class="active"><?php echo $button ?> Kegiatan</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-body">

            <!-- Form input dan edit Kegiatan -->
            <legend><?php echo $button ?> Kegiatan</legend>
            <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" class="form-control" name="id_kegiatan" id="id_kegiatan" value="<?php echo $id_kegiatan; ?>" />
                <div class="form-group">
                    <label for="varchar">Nama Kegiatan <?php echo form_error('nama_kegiatan') ?></label>
                    <input type="text" class="form-control" name="nama_kegiatan" id="nama_kegiatan" placeholder="Nama kegiatan" value="<?php echo $nama_kegiatan; ?>" />
                </div>

                <div class="form-group">
                    <label for="varchar">Galery Kegiatan <?php echo form_error('galery') ?></label>
                    <div>
                        <?php
                        if ($galery == "") {
                            echo "<p class='help-block'>Silahkan upload galery kegiatan polri</p>";
                        } else {
                        ?>
                            <div>
                                <img width="420px" height="380px" src="../../../images/kegiatan/<?php echo $galery; ?>">
                            </div><br />
                        <?php
                        }
                        ?>
                        <input type="file" name="galery" id="galery" value="<?= $galery; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="varchar">Deskripsi Kegiatan <?php echo form_error('deskripsi') ?></label>
                    <input type="text" class="form-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi kegiatan" value="<?php echo $deskripsi; ?>" />
                </div>

                <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                <a href="<?php echo site_url('kegiatan') ?>" class="btn btn-default">Cancel</a>
            </form>