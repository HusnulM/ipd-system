<META HTTP-EQUIV="Refresh" Content="20; <?= BASEURL; ?>/production/productionview">

<div class="content" style="margin-top:60px;">
        <div class="container-fluid">   
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>
            
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="body">
                                <div class="row">                   
                                    <div class="col-lg-12">
                                        <table id="report-data" class="table table-bordered table-striped table-hover" style="width:100%;font-size:13px;">
                                            <thead>
                                                <tr>
                                                    <th>LINE</th>
                                                    <th>MODEL</th>
                                                    <th colspan="4" style="text-align:center;">
                                                        <?= $data['hdata']['date1']; ?>
                                                    </th>
                                                    <th colspan="4" style="text-align:center;">
                                                        <?= $data['hdata']['date2']; ?>
                                                    </th>
                                                    <th colspan="4" style="text-align:center;">
                                                        <?= $data['hdata']['date3']; ?>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2"></th>
                                                    <th colspan="2">Day Shift</th>
                                                    <th colspan="2">Night Shift</th>
                                                    <th colspan="2">Day Shift</th>
                                                    <th colspan="2">Night Shift</th>
                                                    <th colspan="2">Day Shift</th>
                                                    <th colspan="2">Night Shift</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="2"></th>
                                                    <th colspan="1">Plan Qty</th>
                                                    <th colspan="1">Output Qty</th>
                                                    <th colspan="1">Plan Qty</th>
                                                    <th colspan="1">Output Qty</th>
                                                    <th colspan="1">Plan Qty</th>
                                                    <th colspan="1">Output Qty</th>
                                                    <th colspan="1">Plan Qty</th>
                                                    <th colspan="1">Output Qty</th>
                                                    <th colspan="1">Plan Qty</th>
                                                    <th colspan="1">Output Qty</th>
                                                    <th colspan="1">Plan Qty</th>
                                                    <th colspan="1">Output Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data['rdata'] as $row) : ?>
                                                <tr>
                                                    <td><?= $row['linename']; ?></td>
                                                    <td><?= $row['model']; ?></td>
                                                    <td><?= $row['planqtyd1s1']; ?></td>
                                                    <?php if($row['qtyoutd1s1'] < $row['planqtyd1s1']): ?>
                                                        <td style="background-color:red;color:white;"><?= $row['qtyoutd1s1']; ?></td>
                                                    <?php elseif($row['qtyoutd1s1'] >= $row['planqtyd1s1'] && $row['qtyoutd1s1'] > 0): ?>
                                                        <td style="background-color:green;color:white;">
                                                            <?= $row['qtyoutd1s1']; ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td><?= $row['qtyoutd1s1']; ?></td>
                                                    <?php endif; ?>

                                                    <td><?= $row['planqtyd1s2']; ?></td>
                                                    <?php if($row['qtyoutd1s2'] < $row['planqtyd1s2']): ?>
                                                        <td style="background-color:red;color:white;">
                                                            <?= $row['qtyoutd1s2']; ?>
                                                        </td>
                                                    <?php elseif($row['qtyoutd1s2'] >= $row['planqtyd1s2'] && $row['qtyoutd1s2'] > 0): ?>
                                                        <td style="background-color:green;color:white;">
                                                            <?= $row['qtyoutd1s2']; ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td><?= $row['qtyoutd1s2']; ?></td>
                                                    <?php endif; ?>

                                                    <td><?= $row['planqtyd2s1']; ?></td>
                                                    <?php if($row['qtyoutd2s1'] < $row['planqtyd2s1']): ?>
                                                        <td style="background-color:red;color:white;"><?= $row['qtyoutd2s1']; ?></td>
                                                    <?php elseif($row['qtyoutd2s1'] >= $row['planqtyd2s1'] && $row['qtyoutd2s1'] > 0): ?>
                                                        <td style="background-color:green;color:white;">
                                                            <?= $row['qtyoutd2s1']; ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td><?= $row['qtyoutd2s1']; ?></td>
                                                    <?php endif; ?>
                                                    
                                                    <td><?= $row['planqtyd2s2']; ?></td>
                                                    <?php if($row['qtyoutd2s2'] < $row['planqtyd2s2']): ?>
                                                        <td style="background-color:red;color:white;"><?= $row['qtyoutd2s2']; ?></td>
                                                    <?php elseif($row['qtyoutd2s2'] >= $row['planqtyd2s2'] && $row['qtyoutd2s2'] > 0): ?>
                                                        <td style="background-color:green;color:white;">
                                                            <?= $row['qtyoutd2s2']; ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td><?= $row['qtyoutd2s2']; ?></td>
                                                    <?php endif; ?>

                                                    <td><?= $row['planqtyd3s1']; ?></td>
                                                    <?php if($row['qtyoutd3s1'] < $row['planqtyd3s1']): ?>
                                                        <td style="background-color:red;color:white;"><?= $row['qtyoutd3s1']; ?></td>
                                                    <?php elseif($row['qtyoutd3s1'] >= $row['planqtyd3s1'] && $row['qtyoutd3s1'] > 0): ?>
                                                        <td style="background-color:green;color:white;">
                                                            <?= $row['qtyoutd3s1']; ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td><?= $row['qtyoutd3s1']; ?></td>
                                                    <?php endif; ?>
                                                    
                                                    <td><?= $row['planqtyd3s2']; ?></td>
                                                    <?php if($row['qtyoutd3s2'] < $row['planqtyd3s2']): ?>
                                                        <td style="background-color:red;color:white;"><?= $row['qtyoutd3s2']; ?></td>
                                                    <?php elseif($row['qtyoutd3s2'] >= $row['planqtyd3s2'] && $row['qtyoutd3s2'] > 0): ?>
                                                        <td style="background-color:green;color:white;">
                                                            <?= $row['qtyoutd3s2']; ?>
                                                        </td>
                                                    <?php else: ?>
                                                        <td><?= $row['qtyoutd3s2']; ?></td>
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
    </div>

    <script>
        $(document).ready(function() {
            // $('#report-data').DataTable( {
            //     // "scrollY": 200,
            //     // "scrollX": true,
            //     // "pageResize": true
            // } );

            $('#leftsidebar').hide();
        } );
    </script>