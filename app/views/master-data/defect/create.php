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
                    <form action="<?= BASEURL; ?>/master/savedefect" method="POST">
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" name="defectname" id="defectname" class="form-control" placeholder="Defect Name" required="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">                            
                            <div class="col-sm-6">
                                <div class="form-group" style="padding:10dp;">
                                    <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">SAVE</button>

                                    <a href="<?= BASEURL; ?>/master/defect" type="button" id="btn-back" class="btn btn-danger"  data-type="success">CANCEL</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>