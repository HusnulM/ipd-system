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
                    <form action="<?= BASEURL; ?>/barcodeserial/saveUpload" method="POST" enctype="multipart/form-data">
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="form-line">
                                        <label for="">Choose File</label>
                                        <input type="file" class="form-control" name="file">
                                        <!-- <input type="file" name="file" class="pull-left"> -->
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="row clearfix">                            
                            <div class="col-sm-6">
                                <div class="form-group" style="padding:10dp;">
                                    <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Start Upload</button>
                                    <a href="template/Template Upload Slip Gaji.xlsx" target="_blank" class="btn btn-success">Download Template</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>        
</section>
    