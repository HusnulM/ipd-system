<section class="content">
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
                            USER Lists
                        </h2>
							
                        <ul class="header-dropdown m-r--5">                                
							<a href="<?= BASEURL; ?>/user/create" class="btn btn-success waves-effect pull-right">Add New User</a>
						</ul>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>User ID</th>
                                        <th>Name</th>
										<th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 0; ?>
                                    <?php foreach($data['rdata'] as $user) : ?>
                                        <?php $no++; ?>
                                        <tr>
                                            <td><?= $no; ?></td>
                                            <td><?= $user['username']; ?></td>
                                            <td><?= $user['nama']; ?></td>
                                            <td>
                                                <a href="<?= BASEURL; ?>/user/edit/<?= $user['username']; ?>"  class="btn btn-success">Edit</a>
                                                <a href="<?= BASEURL; ?>/user/delete/<?= $user['username']; ?>" class="btn btn-danger">Delete</a>
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