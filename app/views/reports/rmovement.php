<section class="content">
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Report Inventory Movement
                            </h2>
                        </div>
                        <div class="body">
                            <form>
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="reqdate1">Movement Date</label>
                                                <input type="date" name="reqdate1" id="strdate" class="datepicker form-control" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="reqdate1">-</label>
                                                <input type="date" name="reqdate1" id="enddate" class="datepicker form-control" value="<?php echo date('Y-m-d'); ?>">
                                            </div>
                                        </div>    
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="reqdate1">Movement</label>
                                                <select name="movement" id="movement" class="form-control">
                                                    <option value="All">All</option>
                                                    <option value="1">Penerimaan</option>
                                                    <option value="2">Pengeluaran</option>
                                                </select>
                                            </div>
                                        </div>    
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <button type="button" id="btn-process" class="btn btn-primary"  data-type="success">Show Data</button>
                                        </div>    
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    
    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(function(){
            $('#btn-process').on('click', function(){
                var movement = $('#movement').val();
                var strdate  = $('#strdate').val();
                var enddate  = $('#enddate').val();
                window.location.href = base_url+'/reports/movementview/'+strdate+'/'+enddate+'/'+movement
            })
        })
    </script>