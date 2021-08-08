<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card" id="div-po-item">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">                                
                                <a href="<?= BASEURL; ?>/exportdata/exportmovement/<?= $data['strdate']; ?>/<?= $data['enddate']; ?>/<?= $data['movement']; ?>" target="_blank" class="btn bg-teal">
                                   <i class="material-icons">cloud_download</i> EXPORT DATA
                                </a>

                                <a href="<?= BASEURL; ?>/reports/transaction" type="button" class="btn bg-teal">
                                    <i class="material-icons">backspace</i> <span>BACK</span>
                                </a>
							</ul>
                        </div>
                        <div class="body">                                
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable" style="width:200%;font-size:13px;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>MODEL</th>
                                                <th>PART CODE</th>
                                                <th>LOT / SERIAL NO</th>
                                                <th>AOI SMT-BOTTOM (1st)</th>
                                                <th>AOI SMT-TOP (2nd)</th>
                                                <th>SMT SI</th>
                                                <th>ICT</th>
                                                <th>QPIT</th>
                                                <th>AOI HW-TOP</th>
                                                <th>AOI HW-BOTTOM</th>
                                                <th>FVI</th>
                                                <th>ERROR PROCESS</th>
                                                <th>DEFECT NAME</th>
                                                <th>LOCATION</th>
                                                <th>CAUSE</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            <?php foreach ($data['rdata'] as $row) : ?>
                                                <?php $no++; ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $row['partmodel'] ?></td>
                                                    <td><?= $row['partnumber'] ?></td>
                                                    <td><?= $row['serial_no'] ?></td>
                                                    <td><?= $row['process1'] ?></td>
                                                    <td><?= $row['process2'] ?></td>
                                                    <td><?= $row['process3'] ?></td>
                                                    <td><?= $row['process4'] ?></td>
                                                    <td><?= $row['process5'] ?></td>
                                                    <td><?= $row['process6'] ?></td>
                                                    <td><?= $row['process7'] ?></td>
                                                    <td><?= $row['process8'] ?></td>
                                                    <td><?= $row['error_process'] ?></td>
                                                    <td><?= $row['defect_name'] ?></td>
                                                    <td><?= $row['location'] ?></td>
                                                    <td><?= $row['cause'] ?></td>
                                                    <td><?= $row['action'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>