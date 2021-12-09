<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Edit Password
                            </h2>
                        </div>
                        <div class="body">
                            <form action="<?= BASEURL; ?>/user/updatepassword" method="POST">
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="username">User ID / Username</label>
                                                <input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?= $_SESSION['usr']['user']; ?>" readonly="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="password">New Password</label>
                                                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                            </div>
                                        </div>    
                                    </div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
										<div class="form-group">
											<button type="submit" id="btn-save" class="btn btn-primary waves-effect pull-left">
                                                SAVE
                                            </button>
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