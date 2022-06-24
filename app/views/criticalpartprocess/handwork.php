
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
                        <form action="<?= BASEURL; ?>/handworkprocess/save" method="POST">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                    <label for="assycode">ASSY CODE</label>
                                    <input type="text" name="assycode" id="assycode" class="form-control" autocomplete="off" required/>
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
                                    <label for="kepilot">KEPI LOT NO</label>
                                    <input type="text" name="kepilot" id="kepilot" class="form-control" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                    <label for="lotnumber">PART LOT NO</label>
                                    <input type="text" name="lotnumber" id="lotnumber" class="form-control" autocomplete="off" required/>
                                </div>
                                <!-- <div class="col-lg-2 col-md-12 col-sm-12 col-xm-12">
                                    <label for="issue_date">SMT DATE Process</label>
                                    <input type="date" name="issue_date" id="issue_date" class="form-control" value="<?= date('Y-m-d'); ?>" required/>
                                </div> -->
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                    <label for="hwline">HW LINE</label>
                                    <input type="text" name="hwline" id="hwline" class="form-control" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                    <label for="hwshift">HW SHIFT</label>
                                    <input type="text" name="hwshift" id="hwshift" class="form-control" autocomplete="off" required/>
                                </div>
                            </div>
                            <!-- <div class="row">                                
                                <div class="col-lg-3 col-md-6 col-sm-12 col-xm-12">
                                    <label for="line">LINE</label>
                                    <select name="assy_line" id="find-line" class="find-line select2 form-control"></select>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 col-xm-12">
                                    <label for="status">STATUS</label>
                                    <input type="text" name="status" id="status" class="form-control" autocomplete="off"/>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
                                        <button type="submit" id="btn-save" class="btn btn-primary">SAVE</button>
										<a href="<?= BASEURL; ?>" class="btn btn-danger">CANCEL</a>
									</div>
								</div>
                            </div>
                            <div class="row" id="additional-component">

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
                // alert(2)
                // $('#find-line').select2({ 
                //     width: '100%',
                //     minimumInputLength: 0,
                //     data: null
                // });
                // $("#find-line").select2("val", "");
                $('#find-line').html('');
            }

            // $('#find-line').on('select2:select', async function (e) {
            //     const _data = e.params.data
            // });
        }

        document.getElementById("assycode").focus();

        $('#assycode').keydown(function(e){
            var inputMaterial = this.value;
            if(e.keyCode == 13) {
                xdata = [];
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
                    // console.log(data)
                    if(data){
                        $('#partmodel').val(data.matdesc);
                        $('#uom').val(data.matunit);
                        document.getElementById("kepilot").focus();
                        
                    }else{
                        showErrorMessage('Assy Code Not Found');
                    }

                    // setLineItems();
                });
            }
        });

        $('#lotnumber').keydown(function(e){
            if(e.keyCode == 13) {
                document.getElementById("hwline").focus();
            }
        });

        $('#hwline').keydown(function(e){
            if(e.keyCode == 13) {
                document.getElementById("hwshift").focus();
            }
        });

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
                    if(data){
                        document.getElementById("lotnumber").focus();                     
                    }else{
                        showErrorMessage('Kepi Lot '+ inputMaterial +' Not Found');
                        $('#kepilot').val('');
                    }
                });
            }
        });

        // $('#kepilot').keydown(function(e){
        //     if(e.keyCode == 13) {
        //         document.getElementById("lotnumber").focus();
        //     }
        // });

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