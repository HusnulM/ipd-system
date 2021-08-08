    <section class="content">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="<?= BASEURL; ?>/warehouse/update" method="POST">
                <div class="card">
                    <div class="header">
                        <h2>
                            <?= $data['menu']; ?>
                        </h2>

                        <ul class="header-dropdown m-r--5">
                            <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Simpan</button>

                            <a href="<?= BASEURL; ?>/warehouse" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Batal</a>
                        </ul>
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="whscode">Kode Warehouse</label>
                                            <input type="text" name="whscode" id="whscode" class="form-control" placeholder="Kode Warehouse" required="true" value="<?= $data['whs']['gudang']; ?>">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="deskripsi">Nama Warehouse</label>
                                            <input type="text" name="deskripsi" id="deskripsi" class="form-control" placeholder="Nama Warehouse" value="<?= $data['whs']['deskripsi']; ?>">
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