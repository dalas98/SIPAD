  <main class="main-wrapper clearfix">
            <!-- Page Title Area -->
            <div class="row page-title clearfix">
                <div class="page-title-left">
                    <h6 class="page-title-heading mr-0 mr-r-5">Input Tahun</h6>
                </div>
                <!-- /.page-title-left -->
                <div class="page-title-right d-none d-sm-inline-flex">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('PPK1') ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">Input Tahun</li>
                    </ol>
                </div>
                <!-- /.page-title-right -->
            </div>
            <!-- /.page-title -->
            <!-- =================================== -->
            <!-- Different data widgets ============ -->
            <!-- =================================== -->
            <div class="widget-list">
                <div class="row">
                    <div class="col-md-12 widget-holder">
                        <div class="widget-bg">
                            <div class="widget-body clearfix">
                                <h5 class="box-title mr-b-0">Tahun Project</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php if ($this->session->flashdata('berhasil')): ?>
                                        <div class="alert alert-icon alert-success border-success alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                            </button> <i class="material-icons list-icon">check_circle</i>  <strong>Well done!</strong> Tahun baru berhasil di daftarkan.
                                        </div>
                                        <?php elseif ($this->session->flashdata('tahunsalah')): ?>
                                        <div class="alert alert-icon alert-danger border-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                            </button> <i class="material-icons list-icon">not_interested</i>  <strong>Oh snap!</strong> Tahun yang dimasukkan sudah terdaftar
                                        </div>
                                        <?php elseif ($this->session->flashdata('gagal')): ?>
                                         <div class="alert alert-icon alert-danger border-danger alert-dismissible fade show" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                                            </button> <i class="material-icons list-icon">not_interested</i>  <strong>Oh snap!</strong> Tahun baru gagal di daftarkan
                                        </div>
                                        <?php endif ?>
                                    </div>
                                </div> 
                                <form action ="<?php echo base_url ('PPK1/tambahtahun') ?>"  method="post">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="l0">Nama Tahun</label>
                                        <div class="col-md-9">
                                            <span class="text-danger"><?=form_error('tahun') ?></span>
                                            <input class="form-control" id="" placeholder="ex: 2014" type="number" min="1990" name="tahun">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label" for="l15">Keterangan</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" id="" rows="3" name="deskripsi"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="form-group row">
                                            <div class="col-md-9 ml-md-auto btn-list">
                                                <button class="btn btn-primary btn-rounded" type="submit">Submit</button>
                                                <button class="btn btn-outline-default btn-rounded" type="reset">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.widget-body -->
                        </div>
                        <!-- /.widget-bg -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.widget-list -->
        </main>