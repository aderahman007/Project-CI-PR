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

            <!-- Tampil Data Kegiatan -->
            <legend><?php echo $button ?> Kegiatan</legend>
            <!-- Button untuk melakukan update -->
            <a href="<?php echo site_url('kegiatan/update/' . $id_kegiatan) ?>" class="btn btn-primary">Update</a>
            <!-- Button cancel untuk kembali ke halaman mahakegiatan list -->
            <a href="<?php echo site_url('kegiatan') ?>" class="btn btn-warning">Cancel</a>
            <p></p>
            <!-- Menampilkan data kegiatan secara detail -->
            <table class="table table-striped table-bordered">
                <tr>
                    <td>Galery Kegiatan</td>
                    <td><img width="420px" height="380px" src="../../../images/kegiatan/<?php echo $galery; ?>"></td>
                </tr>
                <tr>
                    <td>Nama Kegiatan</td>
                    <td><?php echo $nama_kegiatan; ?></td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td><?php echo $deskripsi; ?></td>
                </tr>

            </table>