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
                                <a href="<?= BASEURL; ?>/exportdata/exportplanning/<?= $data['strdate']; ?>/<?= $data['enddate']; ?>/data?model=<?= $data['model']; ?>" target="_blank" class="btn bg-teal">
                                   <i class="material-icons">cloud_download</i> EXPORT DATA
                                </a>

                                <a href="<?= BASEURL; ?>/planningreport" type="button" class="btn bg-teal">
                                    <i class="material-icons">backspace</i> <span>BACK</span>
                                </a>
							</ul>
                        </div>
                        <div class="body">                                
                            <div class="table-responsive">
                                    <table id="report-data" class="table table-bordered table-striped table-hover" style="width:100%;font-size:13px;">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>PLAN DATE</th>
                                                <th>LINE</th>
                                                <th>MODEL</th>
                                                <th>LOT NUMBER</th>
                                                <th>SHIFT</th>
                                                <th style="text-align:right;">PLAN QTY</th>
                                                <th style="text-align:right;">OUTPUT QTY</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            <?php foreach ($data['rdata'] as $row) : ?>
                                                <?php $no++; ?>
                                                <tr>
                                                    <td><?= $no; ?></td>
                                                    <td><?= $row['plandate'] ?></td>
                                                    <td><?= $row['linename'] ?></td>
                                                    <td><?= $row['model'] ?></td>
                                                    <td><?= $row['lot_number'] ?></td>
                                                    <td>
                                                        <?php if($row['shift'] == 1): ?>
                                                            Day Shift
                                                        <?php elseif($row['shift'] == 2): ?>
                                                            Night Shift
                                                        <?php endif; ?>
                                                    </td>
                                                    <td style="text-align:right;"><?= $row['plan_qty'] ?></td>
                                                    <?php if($row['outputqty'] < $row['plan_qty']): ?>
                                                        <td style="background-color:red;color:white;text-align:right;"><?= $row['outputqty'] ?></td>
                                                    <?php else: ?>
                                                        <td style="background-color:green;color:white;text-align:right;"><?= $row['outputqty'] ?></td>
                                                    <?php endif; ?>
                                                    
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