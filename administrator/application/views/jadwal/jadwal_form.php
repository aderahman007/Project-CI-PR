<section class="content-header">
    <h1>
        Sekolah Polisi Negara Polda Lampung
        <small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo $back ?>">Jadwal</a></li>
        <li class="active"><?php echo $button ?> Jadwal</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-body">

            <!-- Form input dan edit Jadwal-->
            <legend><?php echo $button ?> Jadwal</legend>
            <form action="<?php echo $action; ?>" method="post">
                <input type="hidden" class="form-control" name="id_jadwal" id="id_jadwal" value="<?php echo $id_jadwal; ?>" />
                <div class="form-group">
                    <label for="varchar">Angkatan<?php echo form_error('id_thn_akad') ?></label>
                    <?php
                    // Query untuk menampilkan data tahun akademik	
                    $query = $this->db->query('SELECT kode_angkatan, tahun_angkatan, 
											       nama_angkatan
												   FROM angkatan ORDER BY kode_angkatan DESC');
                    $dropdowns = $query->result();

                    foreach ($dropdowns as $dropdown) {

                        $dropDownList[$dropdown->kode_angkatan] = $dropdown->nama_angkatan . " " . $dropdown->tahun_angkatan;
                    }
                    echo  form_dropdown('kode_angkatan', $dropDownList, '', 'class="form-control" id="kode_angkatan"');
                    ?>
                </div>
                <div class="form-group">
                    <label for="varchar">Kode Pelajaran <?php echo form_error('kode_pelajaran') ?></label>
                    <?php
                    echo combobox('kode_pelajaran', 'pelajaran', 'nama_pelajaran', 'kode_pelajaran', $kode_pelajaran);
                    ?>
                </div>
                <div class="form-group">
                    <label for="int">Guru <?php echo form_error('id_guru') ?></label>
                    <?php
                    echo combobox('id_guru', 'guru', 'nama_guru', 'id_guru', $id_guru);
                    ?>
                </div>
                <div class="form-group">
                    <label for="int">Kelas <?php echo form_error('id_kelas') ?></label>
                    <?php
                    echo combobox('id_kelas', 'kelas', 'nama_kelas', 'id_kelas', $id_kelas);
                    ?>
                </div>
                <div class="form-group">
                    <label for="enum">Hari <?php echo form_error('hari'); ?></label>
                    <?php
                    $pilhari = array(
                        "" => "-- Pilihan --",
                        "Senin" => "Senin",
                        "Selasa" => "Selasa",
                        "Rabu" => "Rabu",
                        "Kamis" => "Kamis",
                        "Jumat" => "Jumat",
                        "Sabtu" => "Sabtu",
                        "Minggu" => "Minggu",

                    );
                    echo  form_dropdown('hari', $pilhari, $hari, 'class="form-control" id="hari"');
                    ?>
                </div>

                <div class="form-group">
                    <label for="enum">Jam Mulai <?php echo form_error('jam_mulai'); ?></label>
                    <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                        <input class="form-control" name="jam_mulai" id="jam_mulai" type="text" value="<?= $jam_selesai; ?>" />
                        <div class="input-group-addon">
                            <span class="input-group-text"><i class="glyphicon glyphicon-time"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="enum">Jam Selesai <?php echo form_error('jam_selesai'); ?></label>
                    <div class="input-group clockpicker" data-placement="top" data-align="top" data-autoclose="true">
                        <input class="form-control" name="jam_selesai" id="jam_selesai" type="text" value="<?= $jam_selesai; ?>" />
                        <div class="input-group-addon">
                            <span class="input-group-text"><i class="glyphicon glyphicon-time"></i></span>
                        </div>
                    </div>
                </div>




                <button type="submit" class="btn btn-primary"><?php echo $button ?></button>
                <a href="<?php echo site_url('jadwal') ?>" class="btn btn-default">Cancel</a>
            </form>
            <!--// Form jadwal-->