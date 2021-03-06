<main class="main-wrapper clearfix">
    <div class="row page-title clearfix">
        <div class="page-title-left">
            <p class="page-title-description mr-0 d-none d-md-inline-block">Sistem Informasi Pengarsipan Dokumen</p>
        </div>
        <!-- /.page-title-left -->
        <div class="page-title-right d-none d-sm-inline-flex">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= site_url('Kasatker') ?>">Dashboard</a>
                </li>
                <li class="breadcrumb-item"><a href=""><?php echo $namappk[0]['nama'] ?></a></li>
                <li class="breadcrumb-item active"><?php echo $get_tahun[0]['nama_tahun'] ?></li>
            </ol>
        </div>
        <!-- /.page-title-right -->
    </div>

 
        <div class="row">
            <div class="col-md-10"></div>
            <div class="col-md-2">
                <a href="<?php  echo site_url('Kasatker/laporan/'.$get_tahun[0]['id_tahun']) ?>" style="float: right;" class="btn btn-info"> <i class="feather feather-printer" title="Cetak Laporan"></i>&nbsp;Cetak Laporan</a>
            </div>
        </div>            
        <br>    
        <?php foreach ($hasil as $r) {?>
        <div class="widget-holder widget-sm col-md-12 widget-full-height">
            <div class="widget-bg">
                <div class="widget-body">
                    <div class="counter-w-info media">
                        <div class="media-body">
                            <p class="text-muted mr-b-5"><?php echo ucwords($r->nama_paket) ?></p><span class="counter-title color-danger"><span class="counter"><?php echo $r->total ?></span>%</span>
                            <!-- /.counter-title -->
                           <div class="progress progress-md" style="width: 95%; position: relative; top: 25px">
                                <div class="progress-bar bg-danger" style="width: <?php echo $r->total ?>%" role="progressbar">
                                </div>
                            </div>
                        </div>
                        <!-- /.media-body -->
                        <div class="pull-right align-self-center"><i class="list-icon feather feather-file bg-danger"></i>
                        </div>
                    </div>
                    <!-- /.counter-w-info -->
                </div>
                <!-- /.widget-body -->
            </div>
            <!-- /.widget-bg -->
        </div>
        <?php } ?>
    </div>
</main>