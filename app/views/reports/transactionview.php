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
                                <a href="<?= BASEURL; ?>/exportdata/exportransaction/<?= $data['strdate']; ?>/<?= $data['enddate']; ?>" target="_blank" class="btn bg-teal">
                                   <i class="material-icons">cloud_download</i> EXPORT DATA
                                </a>

                                <a href="<?= BASEURL; ?>/reports/transaction" type="button" class="btn bg-teal">
                                    <i class="material-icons">backspace</i> <span>BACK</span>
                                </a>
							</ul>
                        </div>
                        <div class="body">                                
                            <div class="table-responsive">
                                    <table id="report-data" class="table table-bordered table-striped table-hover" style="width:450%;font-size:13px;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>DATE PROD</th>
                                                <th>TEN NO</th>
                                                <th>MODEL</th>
                                                <th>ASSY NO</th>
                                                <th>LOT / SERIAL NO</th>
                                                <th>AOI SMT-BOTTOM (1st)</th>
                                                <th>AOI SMT-TOP (2nd)</th>
                                                <th>SMT SI</th>
                                                <th>ICT</th>
                                                <th>QPIT</th>
                                                <th>AOI HW-TOP</th>
                                                <th>AOI HW-BOTTOM</th>
                                                <th>FVI</th>
                                                <th>QQA</th>
                                                <th>ERROR PROCESS</th>
                                                <th>DEFECT NAME</th>
                                                <th>LOCATION</th>
                                                <th>CAUSE</th>
                                                <th>ACTION</th>
                                                <th>REPAIR DEFECT</th>
                                                <th>REPAIR LOCATION</th>
                                                <th>REPAIR ACTION</th>
                                                <th>AFTER REPAIR-ICT</th>
                                                <th>AFTER REPAIR-QPIT</th>
                                                <th>AFTER REPAIR-AOI TOP</th>
                                                <th>AFTER REPAIR-BOT</th>
                                                <th>AFTER REPAIR-FVI</th>
                                                <th>QQA</th>
                                                <th>QQA REMARK</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            <?php foreach ($data['rdata'] as $row) : ?>
                                                <?php $no++; ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $row['createdon'] ?></td>
                                                    <td></td>
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
                                                    <td><?= $row['process9'] ?></td>
                                                    <td><?= $row['error_process'] ?></td>
                                                    <td><?= $row['defect_name'] ?></td>
                                                    <td><?= $row['location'] ?></td>
                                                    <td><?= $row['cause'] ?></td>
                                                    <td><?= $row['action'] ?></td>
        
                                                    <td><?= $row['repair_defect'] ?></td>
                                                    <td><?= $row['repair_location'] ?></td>
                                                    <td><?= $row['repair_action'] ?></td>
                                                    <td><?= $row['repair1'] ?></td>
                                                    <td><?= $row['repair2'] ?></td>
                                                    <td><?= $row['repair3'] ?></td>
                                                    <td><?= $row['repair4'] ?></td>
                                                    <td><?= $row['repair5'] ?></td>
                                                    <td><?= $row['repair6'] ?></td>
                                                    <td><?= $row['remark'] ?></td>
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

    <script>
        $(document).ready(function() {
            $('#report-data').DataTable( {
                // "scrollY": 200,
                // "scrollX": true,
                // "pageResize": true
            } );

            
        } );
    </script>