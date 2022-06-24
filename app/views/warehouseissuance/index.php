
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
                        <form action="<?= BASEURL; ?>/warehouseissuance/saveWhIssuance" method="POST">
                            <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                    <label for="assycode">PART NUMBER</label>
                                    <input type="text" name="assycode" id="assycode" class="form-control" autocomplete="off" required/>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                    <label for="partmodel">MODEL</label>
                                    <input type="text" name="partmodel" id="partmodel" class="form-control"  readonly="true"/>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-lg-4 col-md-12 col-sm-12 col-xm-12">
                                    <label for="lotnumber">PART LOT NO</label>
                                    <input type="text" name="lotnumber" id="lotnumber" class="form-control" autocomplete="off" required/>
                                </div>
                                <div class="col-lg-2 col-md-12 col-sm-12 col-xm-12">
                                    <label for="issue_date">ISSUANCE DATE</label>
                                    <input type="date" name="issue_date" id="issue_date" class="form-control" value="<?= date('Y-m-d'); ?>" required/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xm-12">
                                    <label for="quantity">QUANTITY</label>
                                    <input type="text" name="quantity" id="quantity" class="form-control" style="text-align:right;" autocomplete="off" required/>
                                </div>
                                <!-- <div class="col-lg-2 col-md-6 col-sm-12 col-xm-12">
                                    <label for="uom">UNIT</label>
                                    <input type="text" name="uom" id="uom" class="form-control" readonly autocomplete="off"/>
                                </div> -->
                            </div>
                            <div class="row">
                                
                                <div class="col-lg-3 col-md-6 col-sm-12 col-xm-12">
                                    <label for="line">LINE</label>
                                    <select name="assy_line" id="find-line" class="find-line select2 form-control"></select>
                                    <!-- <select name="assy_line"  id="assy_line" class="form-control" style="width:200px;">
                                        <option value="">Select Line</option>
                                        <option value="Apel">Apel</option>
                                        <option value="Mangga">Mangga</option>
                                    </select> -->
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12 col-xm-12">
                                    <label for="status">STATUS</label>
                                    <input type="text" name="status" id="status" class="form-control" autocomplete="off"/>
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
            
            // $('#find-line').val(null).trigger('change');
            var inputMaterial = this.value;
            if(e.keyCode == 13) {
                xdata = [];
                $.ajax({
                    url: base_url+'/partlocation/getMaterialbyCode/data?material='+inputMaterial,
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
                        // $('#partmodel').val(data['mat'].matdesc);
                        // $('#uom').val(data['mat'].matunit);
                        document.getElementById("lotnumber").focus();

                        $("#assy_line").html('');
                        
                        for (var x = 0; x < data['loc'].length; x++) {
                            xdata.push({
                                id: data['loc'][x]['assy_location'],
                                text: data['loc'][x]['assy_location']
                            });
                        };
                        
                    }else{
                        showErrorMessage('Part Code Not Found');
                    }

                    setLineItems();
                });
            }
        });

        $('#lotnumber').keydown(function(e){
            if(e.keyCode == 13) {
                document.getElementById("quantity").focus();
            }
        });

        $('#quantity').keydown(function(e){
            if(e.keyCode == 13) {
                // document.getElementById("line").focus();
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