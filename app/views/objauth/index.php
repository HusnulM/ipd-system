    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div id="msg-alert">
                        <?php
                            Flasher::msgInfo();
                        ?>
                    </div>
                    <div class="card">
                        <div class="header">
                            <h2>
                                User Object Authorization
                            </h2>
							
                            <ul class="header-dropdown m-r--5">                                
							<a href="<?= BASEURL; ?>/objauth/create" class="btn btn-success waves-effect pull-right">User Object Authorization</a>
							</ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Username</th>
                                            <th>Object Auth</th>
                                            <th>Object Description</th>
                                            <th>Object Value</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach($data['objauth'] as $out) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $out['username']; ?></td>
                                                <td><?= $out['ob_auth']; ?></td>
                                                <td><?= $out['description']; ?></td>
                                                <td><?= $out['ob_value']; ?></td>
                                                <td>
                                                    <a href="<?= BASEURL; ?>/objauth/delete/<?= $out['username']; ?>/<?= $out['ob_auth']; ?>/<?= $out['ob_value']; ?>" type="button" class="btn btn-danger btn-sm"> <i class="material-icons">delete</i> Delete</a>
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