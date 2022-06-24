<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div id="msg-alert" class="msg-alert">
                    <?php
                        Flasher::msgInfo();
                    ?>
                </div>
                <div class="card">
                    <div class="header">
                        <h2>
                            <?= $data['menu']; ?>
                        </h2>
                        
                        <ul class="header-dropdown m-r--5">                                
                        <a href="<?= BASEURL; ?>/partlocation/create" class="btn btn-success waves-effect pull-right">Create Location</a>
                        </ul>
                    </div>
                    
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Part Number</th>
                                        <!-- <th>Description / Model</th> -->
                                        <th>Location</th>
                                        <!-- <th>Part Number</th> -->
                                        <th style="width:100px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0; ?>
                                    <?php foreach($data['location'] as $barang) : ?>
                                        <?php $no++; ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <!-- <td><?= $barang['assy_code']; ?></td> -->
                                            <!-- <td><?= $barang['model']; ?></td> -->
                                            <td><?= $barang['part_number']; ?></td>
                                            <td><?= $barang['assy_location']; ?></td>
                                            <td>
                                                <a href="<?= BASEURL; ?>/partlocation/edit/<?= $barang['uniq_id']; ?>" type="button" class="btn btn-success">Edit</a>
                                                <a href="<?= BASEURL; ?>/partlocation/delete/<?= $barang['uniq_id']; ?>" type="button" class="btn btn-danger">Delete</a>
                                            </td>
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
</section>
    

    