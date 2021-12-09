<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div id="msg-alert" class="msg-alert">
                    <?php
                        Flasher::msgInfo();
                    ?>
                </div>
                <div class="card">
                    <div class="header">
                        <h2>
                            <?= $data['menu']; ?>
                        </h2>
                    </div>
                    <div class="body">
                        <form action="<?= BASEURL; ?>/transaction/formsave" method="POST">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                    <label for="partnumber">PART NUMBER</label>
                                    <input type="text" name="partnumber" id="partnumber" class="form-control" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                    <label for="partmodel">MODEL</label>
                                    <input type="text" name="partmodel" id="partmodel" class="form-control"  readonly="true"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                    <label for="lotnumber">LOT / SERIAL</label>
                                    <input type="text" name="lotnumber" id="lotnumber" class="form-control" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
									<div class="form-group">
                                        <button type="submit" id="btn-save" class="btn btn-primary">SAVE</button>
										<a href="<?= BASEURL; ?>" class="btn btn-danger">CANCEL</a>
									</div>
								</div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        

        document.getElementById("partnumber").focus();

        $('#partnumber').keydown(function(e){
            var inputMaterial = this.value;
            if(e.keyCode == 13) {
                $.ajax({
                    url: base_url+'/material/getMaterialbyCode/data?material='+inputMaterial,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){

                    },
                    error: function(err){
                        console.log(err)
                    }
                }).done(function(data){
                    console.log(data)
                    if(data){
                        $('#partmodel').val(data.matdesc);
                        document.getElementById("lotnumber").focus();
                    }else{
                        showErrorMessage('Part Code Not Found');
                    }
                })
            }
        });

        function showSuccessMessage(message) {
            swal({title: "Success!", text: message, type: "success"},
                function(){ 
                    // window.location.href = base_url+'/wos';
                }
            );
        }

        function showErrorMessage(message){
            swal("", message, "warning");
        }
    });
</script>