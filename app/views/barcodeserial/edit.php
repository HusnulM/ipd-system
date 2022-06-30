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
                        <form action="<?= BASEURL; ?>/barcodeserial/save" method="POST">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="barcode">Barcode Serial</label>
                                                <input type="text" name="barcode" class="form-control" placeholder="Barcode Serial" value="<?= $data['barcodeserial']['barcode_serial']; ?>" required="true" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="partnumber">Part Number</label>
                                                <input type="text" name="partnumber" class="form-control" placeholder="Part Number" value="<?= $data['barcodeserial']['part_number']; ?>" required="true">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="partlot">Part Lot Number</label>
                                                <input type="text" name="partlot" class="form-control" placeholder="Part Lot Number" value="<?= $data['barcodeserial']['part_lot']; ?>" required="true">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row clearfix">                            
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group" style="padding:10dp;">
                                        <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Save</button>

                                        <a href="<?= BASEURL; ?>/barcodeserial" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</section>
    