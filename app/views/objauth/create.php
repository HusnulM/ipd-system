    <section class="content">
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="<?= BASEURL; ?>/objauth/save" method="POST">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>

                            <ul class="header-dropdown m-r--5">                                
							    <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Save</button>

                                <a href="<?= BASEURL; ?>/objauth" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Cancel</a>
							</ul>
                        </div>
                        <div class="body">
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="roleid">User</label>
                                                <select class="form-control" name="username">
                                                    <?php foreach($data['user'] as $out) : ?>
                                                    <option value="<?= $out['username']; ?>"><?= $out['username']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="menuid">Object Authorization</label>
                                                <select class="form-control" name="ob_auth">
                                                    <?php foreach($data['objauth'] as $out) : ?>
                                                    <option value="<?= $out['ob_auth']; ?>"><?= $out['description']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="menuid">Object Authorization Value</label>
                                                <input type="text" name="ob_value" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
    </section>