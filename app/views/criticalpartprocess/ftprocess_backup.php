
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

                        <ul class="header-dropdown m-r--5">                                
                            <button type="button" class="btn bg-green" id="btn-select-part-lot">
                                <i class="material-icons">add</i> <span>Select Part Lot</span>
                            </button>
                        </ul>
                    </div>
                    <div class="body">
                        <form action="<?= BASEURL; ?>/ftprocess/save" method="POST">
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
                                            <label for="ft_jig_no">FT JIG NO</label>
                                            <input type="text" name="ft_jig_no" id="ft_jig_no" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <!-- <div class="row">
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
                                    </div>       -->
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                            <label for="assycode">ASSY CODE</label>
                                            <input type="text" name="assycode" id="assycode" class="form-control" autocomplete="off" readonly="true"/>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                            <label for="partmodel">MODEL</label>
                                            <input type="text" name="partmodel" id="partmodel" class="form-control"  readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                            <label for="qrcode">BARCODE SERIAL</label>
                                            <input type="text" name="qrcode" id="qrcode" class="form-control" autocomplete="off" readonly="true"/>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                            <label for="lotnumber">PART LOT NO</label>
                                            <input type="text" name="lotnumber" id="lotnumber" class="form-control" autocomplete="off" readonly="true"/>
                                        </div>
                                    </div>   
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="ft_result">FT RESULT</label>
                                            <input type="text" name="ft_result" id="ft_result" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="ft_remark">FAILURE REMARK</label>
                                            <input type="text" name="ft_remark" id="ft_remark" class="form-control" autocomplete="off" required/>
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

    <div class="modal fade" id="modalPartLotList" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modalPartLotListLabel">Lot Number List of KEPI</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-responsive" id="tbl-part-lot-list" style="width:100%;">
                                <thead>
                                    <th>Barcode Serial</th>
                                    <th>Assy Code</th>
                                    <th>Kepi Lot Number</th>
                                    <th>Part Lot Number</th>
                                    <th></th>
                                </thead>
                                <tbody id="tbl-part-lot-item">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
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
                        // $('#lotnumber').val(data.part_lot);
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
                document.getElementById("ft_jig_no").focus();
            }
        });

        $('#ft_jig_no').keydown(function(e){
            if(e.keyCode == 13) {
                document.getElementById("ft_result").focus();
            }
        });

        $('#ft_result').keydown(function(e){
            if(e.keyCode == 13) {
                document.getElementById("ft_remark").focus();
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

        $("#btn-select-part-lot").on('click', function(){
            $('#modalPartLotList').modal('show');
            var _KepiLot = $('#kepilot').val();
            $('#tbl-part-lot-list').DataTable({
                "ajax":{
                    "url": base_url+'/ftprocess/getLotByKepi/data?kepilot='+_KepiLot+'&action=table_data',
                    "dataType": "json",
                    "type": "POST"
                },
                "bDestroy": true,
                "paging":   true,
                "searching":   true,
                "columns": [
                    { "data": "barcode_serial" },
                    { "data": "assy_code" },
                    { "data": "kepi_lot" },
                    { "data": "part_lot" },
                    {"defaultContent": 
                        "<button class='btn btn-success btn-sm button-select'> Select</button>"
                    }   
                ]   
            });

            $('#tbl-part-lot-list tbody').on( 'click', '.button-select', function () {
                
                var table = $('#tbl-part-lot-list').DataTable();
                selected_data = [];
                selected_data = table.row($(this).closest('tr')).data();
                // alert(selected_data.barcode_serial);
                $('#lotnumber').val(selected_data.part_lot);
                $('#qrcode').val(selected_data.barcode_serial);

                $('#modalPartLotList').modal('hide');
            });
        });
    });
</script>