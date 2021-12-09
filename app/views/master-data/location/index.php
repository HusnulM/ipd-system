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
							<a href="<?= BASEURL; ?>/master/createlocatoin" class="btn btn-success waves-effect pull-right">Add New Location</a>
						</ul>
                    </div>
                        
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Location Name</th>
                                        <th style="width:100px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0; ?>
                                    <?php foreach($data['location'] as $row) : ?>
                                        <?php $no++; ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $row['locationname']; ?></td>
                                            <td>
                                                <a href="<?= BASEURL; ?>/master/editlocation/<?= $row['id']; ?>" type="button" class="btn btn-success">Edit</a>
                                                <a href="<?= BASEURL; ?>/master/deletelocation/<?= $row['id']; ?>" type="button" class="btn btn-danger">Delete</a>
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