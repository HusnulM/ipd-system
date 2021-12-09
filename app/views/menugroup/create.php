    <section class="content">
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>
                        </div>
                        <div class="body">
                            <form action="<?= BASEURL; ?>/menugroup/save" method="POST">
                                <div class="row clearfix">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="menugroup" class="form-control" placeholder="Group Name" required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="groupindex" class="form-control" placeholder="Group Index" required="true">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">                            
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group" style="padding:10dp;">
                                            <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Save</button>

                                            <a href="<?= BASEURL; ?>/menugroup" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>