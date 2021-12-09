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
                    <form action="<?= BASEURL; ?>/master/updatecause" method="POST">
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="hidden" name="causeid" value="<?= $data['cause']['id']; ?>">
                                        <input type="text" name="causename" id="causename" class="form-control" placeholder="Cause Name" required="true" value="<?= $data['cause']['causename']; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">                            
                            <div class="col-sm-6">
                                <div class="form-group" style="padding:10dp;">
                                    <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">SAVE</button>

                                    <a href="<?= BASEURL; ?>/master/cause" type="button" id="btn-back" class="btn btn-danger"  data-type="success">CANCEL</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>