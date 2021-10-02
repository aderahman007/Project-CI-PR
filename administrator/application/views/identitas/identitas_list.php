
<section class="content-header">
    <h1>
        Sekolah Polisi Negara Polda Lampung
        <small>Mahir, Terpuji, Patuh Hukum, Unggul</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="admin"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Identitas</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
        <div class="box-body">

            <!-- Tampil Data Identitas -->
            <div class="row" style="margin-bottom: 10px">
                <div class="col-md-4">
                    <h2 style="margin-top:0px">Identitas Website</h2>
                </div>
                <div class="col-md-4 text-center">
                    <div style="margin-top: 4px" id="message">
                        <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                    </div>
                </div>
                <div class="col-md-4 text-right"> </div>
            </div>
            <table class="table table-bordered table-striped" id="mytable">
                <thead>
                    <tr>
                        <th width="80px">No</th>
                        <th>Nama Website</th>
                        <th>Url</th>
                        <th>Email</th>
                        <th>Telp</th>
                        <th width="200px">Action</th>
                    </tr>
                </thead>

            </table>
            <script src="<?php echo base_url('assets/js/jquery-1.11.2.min.js') ?>"></script>
            <script src="<?php echo base_url('assets/datatables/jquery.dataTables.js') ?>"></script>
            <script src="<?php echo base_url('assets/datatables/dataTables.bootstrap.js') ?>"></script>
            <script type="text/javascript">
                $(document).ready(function() {
                    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
                        return {
                            "iStart": oSettings._iDisplayStart,
                            "iEnd": oSettings.fnDisplayEnd(),
                            "iLength": oSettings._iDisplayLength,
                            "iTotal": oSettings.fnRecordsTotal(),
                            "iFilteredTotal": oSettings.fnRecordsDisplay(),
                            "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                            "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                        };
                    };

                    var t = $("#mytable").dataTable({
                        initComplete: function() {
                            var api = this.api();
                            $('#mytable_filter input')
                                .off('.DT')
                                .on('keyup.DT', function(e) {
                                    if (e.keyCode == 13) {
                                        api.search(this.value).draw();
                                    }
                                });
                        },
                        oLanguage: {
                            sProcessing: "loading..."
                        },
                        processing: true,
                        serverSide: true,
                        ajax: {
                            "url": "identitas/json",
                            "type": "POST"
                        },
                        columns: [{
                                "data": "id_identitas",
                                "orderable": false
                            },
                            {
                                "data": "judul_website"
                            },
                            {
                                "data": "url"
                            },
                            {
                                "data": "email"
                            },
                            {
                                "data": "telp"
                            },
                            {
                                "data": "action",
                                "orderable": false,
                                "className": "text-center"
                            }
                        ],
                        order: [
                            [0, 'desc']
                        ],
                        rowCallback: function(row, data, iDisplayIndex) {
                            var info = this.fnPagingInfo();
                            var page = info.iPage;
                            var length = info.iLength;
                            var index = page * length + (iDisplayIndex + 1);
                            $('td:eq(0)', row).html(index);
                        }
                    });
                });
            </script>
            <!--// Tampil Data Identitas -->