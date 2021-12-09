    <section class="content">
        <div class="container-fluid">
            <!-- <div class="block-header">
                <h2>DASHBOARD</h2>
            </div> -->

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="form-group">
                    <img src="<?= BASEURL; ?>/images/login-wlp.jpg" alt="logo" style="width:100%;height:100%;">
                </div>
                <!-- <a href="<?= BASEURL; ?>/pr" class="tile-default">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-red hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">note_add</i>
                            </div>
                            <div class="content">
                                <div class="text">
                                    Purchase Request
                                </div>
                                <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"><?= $data['totalPR']['Total']; ?></div>
                            </div>
                        </div>
                    </div>
                </a>
                
                <a href="<?= BASEURL; ?>/po" class="tile-default">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-cyan hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">shopping_cart</i>
                            </div>
                            <div class="content">
                                <div class="text">Purchase Order</div>
                                <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"><?= $data['totalPO']['Total']; ?></div>
                            </div>
                        </div>
                    </div>
                </a>

                <?php if($_SESSION['usr']['userlevel'] == 'Staff') : ?>
                <a href="<?= BASEURL; ?>/grpo" class="tile-default">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-light-green hover-expand-effect">
                            <div class="icon">
                                <i class="material-icons">receipt</i>
                            </div>
                            <div class="content">
                                <div class="text">Receipt PO</div>
                                <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"><?= $data['totalGR']['Total']; ?></div>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endif; ?> -->
                          
            </div>
            <!-- #END# Widgets -->

            <!-- List Open PR -->
            <!-- <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>Open Request</h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No. Request</th>
                                            <th>Tanggal Request</th>
                                            <th>Keterangan</th>
                                            <th>Project</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach ($data['prdata'] as $pr) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $pr['prnum']; ?></td>
                                                <td><?= $pr['tglrequest']; ?></td>
                                                <td><?= $pr['note']; ?></td>
                                                <td><?= $pr['namaproject']; ?></td>
                                                <td>Waiting</td>
                                                <td>
                                                    <a href="<?= BASEURL; ?>/pr/detail/<?= $pr['prnum']; ?>/1" type="button" class="btn btn-success">Detail</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </section>

    <script>
        $(function(){
            $('div').css('cursor', 'pointer');
        })
    </script>