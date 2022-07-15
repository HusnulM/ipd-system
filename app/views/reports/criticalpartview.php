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
                                <!-- <a href="<?= BASEURL; ?>/exportdata/exportransaction/<?= $data['strdate']; ?>/<?= $data['enddate']; ?>" target="_blank" class="btn bg-teal">
                                   <i class="material-icons">cloud_download</i> EXPORT DATA
                                </a> -->

                                <a href="<?= BASEURL; ?>/reports/criticalpart" type="button" class="btn bg-teal">
                                    <i class="material-icons">backspace</i> <span>BACK</span>
                                </a>
							</ul>
                        </div>
                        <div class="body">                                
                            <div class="table-responsive">
                                    <table id="report-data" class="table table-bordered table-striped table-hover" style="width:150%;font-size:13px;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>SMT DATE</th>
                                                <th>AGEING TIME</th>
                                                <th>SMT SHIFT</th>
                                                <th>SMT LINE</th>
                                                <th>HANDWORK SHIFT</th>
                                                <th>HANDWORK LINE</th>
                                                <th>MODEL</th>
                                                <th>ASSY CODE</th>
                                                <th>KEPI LOT</th>
                                                <th>PART LOT</th>
                                                <th>BARCODE SERIAL</th>
                                                <th>QUANTITY</th>
                                                <th>DEFECT QTY</th>
                                                <th>AGEING RESULT</th>
                                                <th>AGEING REMARK</th>
                                                <th>FT RESULT</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            <?php foreach ($data['rdata'] as $row) : ?>
                                                <?php $no++; ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $row['smt_date'] ?></td>
                                                    <td><?= $row['ageing_time'] ?></td>
                                                    <td><?= $row['smt_shift'] ?></td>
                                                    <td><?= $row['smt_line'] ?></td>
                                                    <td><?= $row['hw_shift'] ?></td>
                                                    <td><?= $row['hw_line'] ?></td>
                                                    <td><?= $row['model'] ?></td>
                                                    <td><?= $row['assy_code'] ?></td>
                                                    <td><?= $row['kepi_lot'] ?></td>
                                                    <td><?= $row['part_lot'] ?></td>
                                                    <td><?= $row['barcode_serial'] ?></td>
                                                    <td><?= $row['ageing_qty'] ?></td>
                                                    <td><?= $row['defect_quantity'] ?></td>
                                                    <td><?= $row['ageing_result'] ?></td>
                                                    <td><?= $row['failure_remark'] ?></td>
                                                    <td><?= $row['ft_result'] ?></td>
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