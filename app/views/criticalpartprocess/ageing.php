
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
                        <form action="<?= BASEURL; ?>/ageingprocess/save" method="POST">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="kepilot">KEPI LOT NO</label>
                                            <input type="text" name="kepilot" id="kepilot" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="quantity">QUANTITY</label>
                                            <input type="text" name="quantity" id="quantity" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="manpower_name">MANPOWER NAME</label>
                                            <input type="text" name="manpower_name" id="manpower_name" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="ageing_result">AGEING RESULT</label>
                                            <input type="text" name="ageing_result" id="ageing_result" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="assycode">ASSY CODE</label>
                                            <input type="text" name="assycode" id="assycode" class="form-control" autocomplete="off" readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                            <label for="partmodel">MODEL</label>
                                            <input type="text" name="partmodel" id="partmodel" class="form-control"  readonly="true"/>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                            <label for="lotnumber">PART LOT NO</label>
                                            <input type="text" name="lotnumber" id="lotnumber" class="form-control" autocomplete="off" readonly="true"/>
                                        </div>
                                    </div>      
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="failure_remark">FAILURE REMARK</label>
                                            <input type="text" name="failure_remark" id="failure_remark" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="defect_qty">DEFECT QUANTITY</label>
                                            <input type="text" name="defect_qty" id="defect_qty" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>                      
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
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

        var locations = [];

        var listItems = '';

        var xdata = [];
        // setLineItems();
        // $('.dropdown-toggle').hide();
        function setLineItems(){

            $('.dropdown-toggle').hide();
            $(document).on('select2:open', (event) => {
        
                const searchField = document.querySelector(
                    `.select2-search__field`,
                );
                if (searchField) {
                    searchField.focus();
                }
            });           
            // alert(xdata.length)
            if(xdata.length > 0){
                // alert(1)
                $('#find-line').select2({ 
                    width: '100%',
                    minimumInputLength: 0,
                    data: xdata
                });
            }else{
                $('#find-line').html('');
            }
        }

        document.getElementById("kepilot").focus();

        $('#kepilot').keydown(function(e){
            var inputMaterial = this.value;
            if(e.keyCode == 13) {                
                $.ajax({
                    url: base_url+'/ageingprocess/checkKepiLot/data?kepilot='+inputMaterial,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){

                    },
                    error: function(err){
                        console.log(err)
                    }
                }).done(function(data){
                    // console.log(data)
                    if(data){
                        $('#partmodel').val(data.matdesc);
                        $('#lotnumber').val(data.part_lot);
                        $('#assycode').val(data.assy_code);
                        document.getElementById("quantity").focus();                        
                    }else{
                        showErrorMessage('Kepi Lot '+ inputMaterial +' Not Found');
                        $('#kepilot').val('');
                    }
                });
            }
        });

        $('#quantity').keydown(function(e){
            if(e.keyCode == 13) {
                document.getElementById("manpower_name").focus();
            }
        });

        $('#manpower_name').keydown(function(e){
            if(e.keyCode == 13) {
                document.getElementById("ageing_result").focus();
            }
        });

        $('#ageing_result').keydown(function(e){
            if(e.keyCode == 13) {
                document.getElementById("failure_remark").focus();
            }
        });

        $('#failure_remark').keydown(function(e){
            if(e.keyCode == 13) {
                document.getElementById("defect_qty").focus();
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