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
                        <form id="form-handwork-data" method="POST">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="assycode">ASSY CODE</label>
                                            <input type="text" name="assycode" id="assycode" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="partmodel">MODEL</label>
                                            <input type="text" name="partmodel" id="partmodel" class="form-control"  readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="kepilot">KEPI LOT NO</label>
                                            <input type="text" name="kepilot" id="kepilot" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xm-12">
                                            <label for="barcode">BARCODE SERIAL</label>
                                            <input type="text" name="barcode" id="barcode" class="form-control" autocomplete="off" required/>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xm-12">
                                            <label for="lotnumber">PART LOT NO</label>
                                            <input type="text" name="lotnumber" id="lotnumber" class="form-control" autocomplete="off" readonly/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xm-12">
                                            <label for="partnumber">PART NO</label>
                                            <input type="text" name="partnumber" id="partnumber" class="form-control" autocomplete="off" readonly/>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 col-xm-12">
                                            <label for="partlocation">PART LOCATION</label>
                                            <input type="text" name="partlocation" id="partlocation" class="form-control" autocomplete="off" readonly/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                            <label for="hwline">HW LINE</label>
                                            <input type="text" name="hwline" id="hwline" class="form-control" autocomplete="off" required/>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                            <label for="hwshift">HW SHIFT</label>
                                            <input type="text" name="hwshift" id="hwshift" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>
                                </div>
                                <div id="msg-success-div" class="col-lg-6 msg-alert" style="display:none;">
                                    <div>
                                        <img src="<?= BASEURL; ?>/images/successgif.gif" alt="Success" class="center-block img-rounded img-responsive" style="width:300px; height:240px; margin-top:20px;">
                                    </div>
                                    <div style="text-align:center; font-size: 15px; font-weight: bold; margin:5px;">
                                        Handwork Process Success!
                                    </div>
                                </div>
                                <div id="msg-error-div" class="col-lg-6 msg-alert" style="display:none;">
                                    <div>
                                        <img src="<?= BASEURL; ?>/images/error_icon.png" alt="Error" class="center-block img-rounded img-responsive" style="width:250px; height:240px; margin-top:20px;">
                                    </div>
                                    <div style="text-align:center; font-size: 15px; font-weight: bold; margin:5px;">
                                        <span id="span-msg-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
                                        <button type="submit" id="btn-save" class="btn btn-primary">SAVE</button>
										<a href="<?= BASEURL; ?>/handworkprocess" class="btn btn-danger">CANCEL</a>
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

        $('#barcode').keydown(function(e){
            if(e.keyCode == 13) {
                var inputBarcode = this.value;
                $.ajax({
                    url: base_url+'/smtprocess/getbarcodedetail/data?barcode='+inputBarcode,
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
                    if(data['barcode']){
                        $('#partnumber').val(data['barcode'].part_number);
                        $('#lotnumber').val(data['barcode'].part_lot);
                        $('#partlocation').val(data['location'][0].assy_location);
                        document.getElementById("hwline").focus();
                    }else{
                        showErrorMessage('Barcode Serial '+ inputBarcode +'  Not Found');
                        $('#barcode').val('');
                    }

                    // setLineItems();
                });
                
            }
        });

        // $('#kepilot').keydown(function(e){
        //     var inputMaterial = this.value;
        //     if(e.keyCode == 13) {                
        //         $.ajax({
        //             url: base_url+'/ageingprocess/checkKepiLot/data?kepilot='+inputMaterial,
        //             type: 'GET',
        //             dataType: 'json',
        //             cache:false,
        //             success: function(result){

        //             },
        //             error: function(err){
        //                 console.log(err)
        //             }
        //         }).done(function(data){
        //             if(data){
        //                 document.getElementById("lotnumber").focus();                     
        //             }else{
        //                 showErrorMessage('Kepi Lot '+ inputMaterial +' Not Found');
        //                 $('#kepilot').val('');
        //             }
        //         });
        //     }
        // });

        $('#kepilot').keydown(function(e){
            if(e.keyCode == 13) {
                var inputKepi = this.value;
                $.ajax({
                    url: base_url+'/handworkprocess/getkepi/'+inputKepi,
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
                        $('#hwline').val(data.hw_line);
                        $('#hwshift').val(data.hw_shift);
                    }

                    // setLineItems();
                });
                document.getElementById("barcode").focus();
            }
        });

        $('#hwline').keydown(function(e){
            if(e.keyCode == 13) {
                document.getElementById("hwshift").focus();
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

        $('#form-handwork-data').on('submit', function(event){
            event.preventDefault();
                
            var formData = new FormData(this);
            console.log($(this).serialize())
            $.ajax({
                url:base_url+'/handworkprocess/saveshandwork',
                method:'post',
                data:formData,
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend:function(){
                    // showBasicMessage();
                },
                success:function(data)
                {
                    console.log(data);
                },
                error:function(err){
                    // showErrorMessage(JSON.stringify(err))
                }
            }).done(function(result){
                console.log(result);
                if(result.msgtype === "1"){
                    $("#barcode").val('');
                    $("#partnumber").val('');
                    $("#lotnumber").val('');
                    $("#partlocation").val('');
                    // $("#hwline").val('');
                    // $("#hwshift").val('');
                    document.getElementById("barcode").focus();
                    $('#msg-success-div').show();

                    setTimeout(function(){ 
                        $('.msg-alert').hide();
                    }, 5000);
                }else{
                    $("#barcode").val('');
                    $("#lotnumber").val('');
                    $("#partlocation").val('');
                    $("#partnumber").val('');
                    $('#span-msg-error').html('');
                    $('#span-msg-error').html(result.message);
                    $('#msg-error-div').show();
                    document.getElementById("barcode").focus();
                    setTimeout(function(){ 
                        $('.msg-alert').hide();
                    }, 5000);
                }
            });
        });
    });
</script>