<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit User
                            </h2>
                        </div>
                        <div class="body">
                            <form action="<?= BASEURL; ?>/user/update" method="POST">
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="username">User ID / Username</label>
                                                <input type="text" name="username" class="form-control" placeholder="Username" readonly="true" value="<?= $data['user']['username']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
												<input type="hidden" name="oldpass" value="<?= $data['user']['password']; ?>">
                                                <label for="password">Password</label>
                                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                            </div>
                                        </div>    
                                    </div>
									
									<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="nama">Name</label>
                                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama" value="<?= $data['user']['nama']; ?>">
                                            </div>
                                        </div>
                                    </div>								
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
										<div class="form-group">
											<button type="submit" id="btn-save" class="btn btn-primary">SAVE</button>
											<a href="<?= BASEURL; ?>/user" class="btn btn-danger">CANCEL</a>
										</div>
									</div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>