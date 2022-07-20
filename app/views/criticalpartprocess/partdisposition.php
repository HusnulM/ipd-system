<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div id="msg-box" style="display:none;">
                    <div class="alert alert-success alert-dismissible" role="alert" id="msg-box-success" style="display:none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong id="kepi-update-success"></strong>
                    </div>
                    <div class="alert alert-danger alert-dismissible" role="alert" id="msg-box-error" style="display:none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong id="kepi-update-error"></strong>
                    </div>
                </div>
                <div class="card">
                    <div class="header">
                        <h2>
                            <?= $data['menu']; ?>
                        </h2>

                        <ul class="header-dropdown m-r--5">                                
                            <!-- <button type="button" class="btn bg-green" id="btn-select-part-lot">
                                <i class="material-icons">add</i> <span>Select Part Lot</span>
                            </button> -->
                        </ul>
                    </div>
                    <div class="body">
                        <form id="form-submit-data" method="POST">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                        <label for="kepilot">KEPI LOT NO</label>
                                        <input type="text" name="kepilot" id="kepilot" class="form-control" autocomplete="off" required/>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-stripped table-sm" id="tbl-kepi">
                                        <thead>
                                            <th>KEPI LOT</th>
                                            <th>ASSY CODE</th>
                                            <th>MODEL</th>
                                            <th>QUANTITY</th>
                                            <th>MANPOWER NAME</th>
                                            <th>AGEING TIME</th>
                                            <th>AGEINT RESULT</th>
                                            <th>FT RESULT</th>
                                            <th style="width:100px;"></th>
                                        </thead>
                                        <tbody id="tbl-kepi-body">
                                        </tbody>
                                    </table>
                                </div>
                            </div>     
                                
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table table-stripped table-sm">
                                        <thead>
                                            <th>BARCODE SERIAL</th>
                                            <th>PART LOT NO</th>
                                            <th>AGEING RESULT</th>
                                            <th>FT RESULT</th>
                                            <th style="width:100px;"></th>
                                        </thead>
                                        <tbody id="tbl-kepi-detail-body">
                                            
                                        </tbody>
                                    </table>
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
                                    <tr>
                                        <th>Barcode Serial</th>
                                        <th>Assy Code</th>
                                        <th>Kepi Lot Number</th>
                                        <th>Part Lot Number</th>
                                        <th>SMT Process</th>
                                        <th>HW Process</th>
                                        <th></th>
                                    </tr>
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

    
    <div class="modal fade" id="modalUpdateKepi" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form id="form-update-kepi">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalUpdateKepiLabel">UPDATE KEPI STATUS</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="ageing_result">KEPI LOT</label>
                                    <input type="text" class="form-control" name="kepi_lot_update" id="kepi_lot_update" readonly>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="ageing_result">AGEING RESULT</label>
                                    <select name="ageing_result" id="ageing_result" class="form-control">
                                        <option value="">Select Ageing Result</option>
                                        <option value="GOOD">GOOD</option>
                                        <option value="NG">NG</option>
                                        <option value="HOLD">HOLD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="ft_result">FT RESULT</label>
                                    <select name="ft_result" id="ft_result" class="form-control">
                                        <option value="">Select Ageing Result</option>
                                        <option value="GOOD">GOOD</option>
                                        <option value="NG">NG</option>
                                        <option value="HOLD">HOLD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-blue">SAVE</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUpdateKepiPartLot" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <form id="form-update-kepi-partlot">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalUpdateKepiPartLotLabel">UPDATE PART LOT STATUS</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="ageing_result">KEPI LOT</label>
                                    <input type="text" class="form-control" name="kepi_part_lot_update" id="kepi_part_lot_update" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-12">
                                <div class="form-group">
                                    <label for="qrcode_selected">QR CODE</label>
                                    <input type="text" class="form-control" name="qrcode_selected" id="qrcode_selected" readonly>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-12">
                                <div class="form-group">
                                    <label for="part_lot_selected">PART LOT</label>
                                    <input type="text" class="form-control" name="part_lot_selected" id="part_lot_selected" readonly>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="part_ageing_result">AGEING RESULT</label>
                                    <select name="part_ageing_result" id="part_ageing_result" class="form-control">
                                        <option value="">Select Ageing Result</option>
                                        <option value="GOOD">GOOD</option>
                                        <option value="NG">NG</option>
                                        <option value="HOLD">HOLD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="part_ft_result">FT RESULT</label>
                                    <select name="part_ft_result" id="part_ft_result" class="form-control">
                                        <option value="">Select Ageing Result</option>
                                        <option value="GOOD">GOOD</option>
                                        <option value="NG">NG</option>
                                        <option value="HOLD">HOLD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-blue">SAVE</button>
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                    </div>
                </form>
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

        var _selectedKEPI = '';

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
                 
                loadKEPI(inputMaterial);
            }
        });

        function loadKEPI(_KepiNum){
            $('#tbl-kepi-body, #tbl-kepi-detail-body').html('');     
                $.ajax({
                    url: base_url+'/partlotdisposition/getkepilot/data?kepilot='+_KepiNum,
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
                    if(data['agheader'] && data['ftheader']){
                        if(data['agheader'].ageing_result === "GOOD" && (data['ftheader'].ft_result === "GOOD" || data['ftheader'].ft_result === "undefined")){
                            $('#tbl-kepi-body').append(`
                                <tr>
                                    <td>`+ data['agheader'].kepi_lot +`</td>
                                    <td>`+ data['agheader'].assy_code +`</td>
                                    <td>`+ data['agheader'].model +`</td>
                                    <td>`+ data['agheader'].quantity +`</td>
                                    <td>`+ data['agheader'].manpower_name +`</td>
                                    <td>`+ data['agheader'].ageing_time +`</td>
                                    <td>`+ data['agheader'].ageing_result +`</td>
                                    <td>`+ data['ftheader'].ft_result +`</td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            `);
                        }else{
                            $('#tbl-kepi-body').append(`
                                <tr>
                                    <td>`+ data['agheader'].kepi_lot +`</td>
                                    <td>`+ data['agheader'].assy_code +`</td>
                                    <td>`+ data['agheader'].model +`</td>
                                    <td>`+ data['agheader'].quantity +`</td>
                                    <td>`+ data['agheader'].manpower_name +`</td>
                                    <td>`+ data['agheader'].ageing_time +`</td>
                                    <td>`+ data['agheader'].ageing_result +`</td>
                                    <td>`+ data['ftheader'].ft_result +`</td>
                                    <td>
                                        <button type="button" class="btn bg-green btn-update-kepi" data-kepi="`+ data['agheader'].kepi_lot +`">UPDATE RESULT</button>
                                    </td>
                                </tr>
                            `);
                        }
                    }else if(data['agheader']){
                        if(data['agheader'].ageing_result === "GOOD"){
                            $('#tbl-kepi-body').append(`
                                <tr>
                                    <td>`+ data['agheader'].kepi_lot +`</td>
                                    <td>`+ data['agheader'].assy_code +`</td>
                                    <td>`+ data['agheader'].model +`</td>
                                    <td>`+ data['agheader'].quantity +`</td>
                                    <td>`+ data['agheader'].manpower_name +`</td>
                                    <td>`+ data['agheader'].ageing_time +`</td>
                                    <td>`+ data['agheader'].ageing_result +`</td>
                                    <td></td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            `);
                        }else{
                            $('#tbl-kepi-body').append(`
                                <tr>
                                    <td>`+ data['agheader'].kepi_lot +`</td>
                                    <td>`+ data['agheader'].assy_code +`</td>
                                    <td>`+ data['agheader'].model +`</td>
                                    <td>`+ data['agheader'].quantity +`</td>
                                    <td>`+ data['agheader'].manpower_name +`</td>
                                    <td>`+ data['agheader'].ageing_time +`</td>
                                    <td>`+ data['agheader'].ageing_result +`</td>
                                    <td></td>
                                    <td>
                                        <button type="button" class="btn bg-green btn-update-kepi" data-kepi="`+ data['agheader'].kepi_lot +`">UPDATE RESULT</button>
                                    </td>
                                </tr>
                            `);
                        }
                    }

                    $('.btn-update-kepi').on('click', function(){
                        var _data = $(this).data();
                        console.log(_data)
                        $('#kepi_lot_update').val(_data.kepi);
                        $('#modalUpdateKepi').modal('show');
                    });

                    for(var i = 0; i < data['details'].length; i++){
                        var aresult = data['details'][i].part_lot_ageing_result;
                        var fresult = data['details'][i].part_lot_ft_result;
                        if(aresult === null || aresult == "null"){
                            aresult = "";
                        }
                        if(fresult === null || fresult == "null"){
                            fresult = "";
                        }
                        if(data['details'][i].part_lot_ageing_result === "GOOD" && data['details'][i].part_lot_ft_result === "GOOD"){
                            $('#tbl-kepi-detail-body').append(`
                                <tr>
                                    <td>`+ data['details'][i].barcode_serial +`</td>
                                    <td>`+ data['details'][i].part_lot +`</td>
                                    <td>`+ aresult +`</td>
                                    <td>`+ fresult +`</td>
                                    <td>
                                        
                                    </td>
                                </tr>
                            `);
                        }else{
                            $('#tbl-kepi-detail-body').append(`
                                <tr>
                                    <td>`+ data['details'][i].barcode_serial +`</td>
                                    <td>`+ data['details'][i].part_lot +`</td>
                                    <td>`+ aresult +`</td>
                                    <td>`+ fresult +`</td>
                                    <td>
                                        <button type="button" class="btn bg-green btn-update-kepi-part" data-kepi=`+data['agheader'].kepi_lot+` data-qrcode=`+ data['details'][i].barcode_serial +` data-partlot=`+ data['details'][i].part_lot +`>UPDATE RESULT</button>
                                    </td>
                                </tr>
                            `);
                        }

                        $('.btn-update-kepi-part').on('click', function(){
                            var _data = $(this).data();
                            console.log(_data)
                            $('#kepi_part_lot_update').val(_data.kepi);
                            $('#qrcode_selected').val(_data.qrcode);
                            $('#part_lot_selected').val(_data.partlot);
                            $('#modalUpdateKepiPartLot').modal('show');
                        });
                    }

                    _selectedKEPI = _KepiNum;
                    $('#kepilot').val('');
                });
        }

        $('#quantity').keydown(function(e){
            if(e.keyCode == 13) {
                document.getElementById("manpower_name").focus();
            }
        });

        $('#manpower_name').keydown(function(e){
            if(e.keyCode == 13) {
                document.getElementById("ageing_time").focus();
            }
        });

        // $('#ageing_result').keydown(function(e){
        //     if(e.keyCode == 13) {
        //         document.getElementById("failure_remark").focus();
        //     }
        // }); ageing-result
        $('#ageing_result').on('change',function(){
            if(this.value === 'NG'){
                $('.ageing-result').show();
                $("#failure_remark").prop('required',true);
                $("#defect_qty").prop('required',true);
            }else{
                $('.ageing-result').hide();
                $('#failure_remark').val('');
                $('#defect_qty').val('');
                $("#failure_remark").prop('required',false);
                $("#defect_qty").prop('required',false);
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

        $("#btn-select-part-lot").on('click', function(){
            $('#modalPartLotList').modal('show');
            var _KepiLot = $('#kepilot').val();
            $('#tbl-part-lot-list').DataTable({
                "ajax":{
                    "url": base_url+'/ageingprocess/getLotByKepi/data?kepilot='+_KepiLot+'&action=table_data',
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
                    { "data": "smt_process" },
                    { "data": "hw_process" },
                    {"defaultContent": 
                        "<button class='btn btn-success btn-sm button-select'> Select</button>"
                    }   
                ],
                // columnDefs: [
                //     { orderable: false, targets: [ 1, 2, 3 ] } //This part is ok now
                // ]   
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

        $('#form-update-kepi').on('submit', function(event){
            event.preventDefault();
                
            var formData = new FormData(this);
            // console.log($(this).serialize())
            $.ajax({
                url:base_url+'/partlotdisposition/saveUpdate1',
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
                    console.log(JSON.stringify(err));
                }
            }).done(function(result){
                console.log(result);
                $('#msg-box').show();
                if(result.msgtype === "1"){
                    $('#kepi-update-success').html('KEPI Status Updated');
                    // $("#qrcode, #lotnumber, #failure_remark, #defect_qty").val('');
                    $('#msg-box-success').show();
                    $('#msg-box-error').hide();
                    setTimeout(function(){ 
                        $('#msg-box').hide();
                    }, 5000);

                    $('#modalUpdateKepi').modal('hide');

                    loadKEPI(_selectedKEPI);
                }else{
                    $('#kepi-update-error').html('Update KEPI Status Failed');
                    $('#msg-box-error').show();
                    $('#msg-box-success').hide();
                    setTimeout(function(){ 
                        $('#msg-box').hide();
                    }, 5000);
                    $('#modalUpdateKepi').modal('hide');
                }
            });
        });

        $('#form-update-kepi-partlot').on('submit', function(event){
            event.preventDefault();
                
            var formData = new FormData(this);
            // console.log($(this).serialize())
            $.ajax({
                url:base_url+'/partlotdisposition/saveUpdate2',
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
                    console.log(JSON.stringify(err));
                }
            }).done(function(result){
                console.log(result);
                $('#msg-box').show();
                if(result.msgtype === "1"){
                    $('#kepi-update-success').html('Part Lot Status Updated');
                    $('#msg-box-success').show();
                    $('#msg-box-error').hide();
                    setTimeout(function(){ 
                        $('#msg-box').hide();
                    }, 5000);
                    loadKEPI(_selectedKEPI);
                }else{
                    $('#kepi-update-error').html('Update Part Lot Status Failed');
                    $('#msg-box-error').show();
                    $('#msg-box-success').hide();
                    setTimeout(function(){ 
                        $('#msg-box').hide();
                    }, 5000);
                }
                $('#modalUpdateKepiPartLot').modal('hide');
            });
        });
    });
</script>