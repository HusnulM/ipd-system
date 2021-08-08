<section class="content">
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Reset Data
                            </h2>
                        </div>
                        <div class="body">
                            <div class="row clearfix">                            
                                <div class="col-sm-6">
                                    <div class="form-group" style="padding:10dp;">
                                        <button type="submit" id="btn-reset" class="btn btn-primary"  data-type="success">Reset Data</button>

                                        <a href="<?= BASEURL; ?>" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(function(){
            $('#btn-reset').on('click', function(){
                $("#btn-reset").attr("disabled", true);
                $.ajax({
                    url: base_url+'/reset/resetdata',
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        showSuccessMessage('Data Berhasil Di Reset')
                        $("#btn-reset").attr("disabled", false);
                    },error: function(err){
                        showSuccessMessage('Data Berhasil Di Reset')
                        $("#btn-reset").attr("disabled", false);
                    }
                });
            });

            function showSuccessMessage(message) {
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        window.location.href = base_url;
                    }
                );
            }

            function showErrorMessage(message){
                swal("Error", message, "error");
            }
        })
    </script>