    <section class="content">
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <form action="<?= BASEURL; ?>/material/save" method="POST">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <button type="submit" id="btn-save" class="btn bg-blue"  data-type="success">
                                    <i class="material-icons">save</i> <span>SAVE</span>
                                </button>

                                <a href="<?= BASEURL; ?>/material" type="button" id="btn-back" class="btn bg-red"  data-type="success">
                                    <i class="material-icons">highlight_off</i> <span>CANCEL</span>
                                </a>
                            </ul>
                        </div>
                        <div class="body">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#basic_data_view" data-toggle="tab">
                                        <i class="material-icons">description</i> Basic Data
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane fade in active" id="basic_data_view">
                                    <div class="row clearfix">
                                    <br>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label for="">Part Code / Material Code</label>
                                                    <input type="text" name="kodebrg" id="kodebrg" class="form-control" placeholder="Part Code" autocomplete="off" required="true">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label for="">Description / Model</label>
                                                    <input type="text" name="namabrg" id="namabrg" class="form-control" placeholder="Description" required="true" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="form-line">
                                                    <label for="">Base UOM</label>
                                                    <input type="text" name="satuan" id="satuan" class="form-control" placeholder="Base UOM" required="true" autocomplete="off">
                                                </div>
                                            </div>
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

    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        var alt_uom = [];
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });
        });    
    </script>