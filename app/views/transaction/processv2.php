<?php 
    $isFirstProcess = false;
    $transid = date_create();
    $formid  = date_timestamp_get($transid);
    if($data['process']['sequence'] == 1){
        $isFirstProcess = true;
    }
?>
<style>
    .defect-table {

        max-height: 150px;
        overflow-y: scroll;
    }
</style>
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
                            <?= $data['menu']; ?> <b>[ <?= $data['process']['processname']; ?> ]</b>
                        </h2>
                    </div>
                    <div class="body">
                    <!-- action="<?= BASEURL; ?>/transaction/saveprocess" -->
                        <form id="form-process-data" method="POST">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php if($isFirstProcess): ?>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
                                            <label for="partcode">SCAN ASSY NO</label>
                                            <input type="text" name="partcode" id="partcode" class="form-control" autocomplete="off"/>
                                        </div>
                                        <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
                                            <label for="scanlotcode">LOT CODE</label>
                                            <input type="text" name="scanlotcode" id="scanlotcode" class="form-control" autocomplete="off"/>
                                        </div>
                                        <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
                                            <label for="lotnumber">SCAN LOT / SERIAL</label>
                                            <input type="text" name="lotnumber" id="lotnumber" class="form-control" autocomplete="off"/>
                                        </div>
                                        <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
                                            <label for="_lotnumber">LOT / SERIAL</label>
                                            <input type="text" name="_lotnumber" id="_lotnumber" class="form-control" readonly required/>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                        <div class="row">
                                            <div class="col-lg-8 col-md-12 col-sm-12 col-xm-12">
                                                <label for="lotnumber">SCAN LOT / SERIAL</label>
                                                <input type="text" name="lotnumber" id="lotnumber" class="form-control" autocomplete="off"/>
                                            </div>
                                            <div class="col-lg-4 col-md-12 col-sm-12 col-xm-12">
                                                <label for="_lotnumber">LOT / SERIAL</label>
                                                <input type="text" name="_lotnumber" id="_lotnumber" class="form-control" readonly required/>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
                                            <label for="formid">FORM ID</label>
                                            <input type="text" name="formid" id="formid" class="form-control" autocomplete="off" readonly/>
                                        </div>
                                        <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
                                            <label for="partmodel">MODEL CODE</label>
                                            <input type="text" name="partmodel" id="partmodel" class="form-control"  readonly="true"/>
                                        </div>
                                        <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
                                            <label for="partnumber">ASSY NO</label>
                                            <input type="text" name="partnumber" id="partnumber" class="form-control" readonly="true" required/>
                                        </div>
                                        <div class="col-lg-3 col-md-12 col-sm-12 col-xm-12">
                                            <label for="lotcode">LOT CODE</label>
                                            <input type="text" name="lotcode" id="lotcode" class="form-control" readonly="true" required/>
                                            <input type="hidden" name="status" id="status">
                                            <input type="hidden" name="otherstatus" id="otherstatus" class="form-control" style="display:none;">
                                        </div>
                                    </div>
                                </div>                                
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <button type="submit" id="btn-save" class="btn btn-primary" style="height: 50px; width:150px;">
                                                    <i class="material-icons">done</i> GOOD
                                                </button>
                                                <button type="button" id="btn-no-good" class="btn btn-danger" style="height: 50px; width:150px;">
                                                    <i class="material-icons">close</i> NO GOOD
                                                </button>
                                                <button type="submit" id="btn-save-nogood" class="btn btn-primary" style="height: 50px; width:150px;display:none;">
                                                    <i class="material-icons">save</i> SAVE
                                                </button>
                                                <button type="button" id="btn-cancel" class="btn btn-danger" style="height: 50px; width:150px; display:none;">
                                                    <i class="material-icons">close</i> CANCEL
                                                </button>
                                                <!-- <a href="<?= BASEURL; ?>" class="btn btn-danger">NO GOOD</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 ngInput" style="display:none;">                                   
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <button type="button" class="btn btn-primary" id="btn-show-add-defect">ADD Defect</button>
                                            <table id="tbl-defect-data" class="table table-stripped table-bordered">
                                                <thead>
                                                    <th>No</th>
                                                    <th>Defect Name</th>
                                                    <th>Location</th>
                                                    <th>Cause Name</th>
                                                    <th>Action</th>
                                                    <th></th>
                                                </thead>
                                                <tbody id="tbl-defect-body" class="mainbodynpo">
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table">
                                        <thead>
                                            <th>MODEL</th>
                                            <th>PART NUMBER</th>
                                            <th>SERIAL NO</th>
                                            <th>LAST PROCESS</th>
                                            <th>LAST STATUS</th>
                                        </thead>
                                        <tbody id="tbl-body-lastproc">

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

    <div class="modal fade" id="addDefectModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="addDefectModalTitle">Add Defect</h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                <div class="form-group">
                                    <label for="defect">DEFECT NAME</label>
                                    <select name="defect" id="defect" class="form-control">
                                        <option value=""></option>
                                        <?php foreach($data['defect'] as $row) : ?>
                                            <option value="<?= $row['defectname']; ?>"><?= $row['defectname']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                <div class="form-group">
                                    <label for="location">LOCATION</label>
                                    <select name="location" id="location" class="form-control" data-live-search="true">
                                        <option value=""></option>
                                        <?php foreach($data['location'] as $row) : ?>
                                            <option value="<?= $row['locationname']; ?>"><?= $row['locationname']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                <label for="cause">CAUSE NAME</label>
                                <input type="text" name="cause" id="cause" class="form-control">
                                </br>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                <label for="action">ACTION</label>
                                <input type="text" name="action" id="action" class="form-control">
                            </div>
                        </div>
                        <br></br>
                    </div>
                </div>
                <div class="modal-footer">
                    <hr>
                    <button type="button" class="btn btn-primary" id="btn-add-defect">ADD</button>
                    <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CLOSE</button>
                </div>
            </div>
        </div>            
    </div>
</section>

<script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
<script>

    $(document).ready(function(){
        var processStatus = 'Good';
        $('#status').val('Good');

        var isFirstprocess = "<?= $isFirstProcess; ?>";
        var formID = "<?= $formid; ?>";
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        // $('#location').select2();

        if(isFirstprocess == 1){
            document.getElementById("partcode").focus();
        }else{
            document.getElementById("lotnumber").focus();
        }

        $('#btn-no-good').on('click', function(){
            $('#btn-save').hide();
            $('#btn-save-nogood').show();
            $('#btn-cancel').show();
            $('#btn-no-good').hide();
            $('.ngInput').show();
            processStatus = 'NG';

            $('#status').val('NG');
        });

        $('#btn-cancel').on('click', function(){
            $('#btn-save').show();
            $('#btn-save-nogood').hide();
            $('#btn-cancel').hide();
            $('#btn-no-good').show();

            $('.ngInput').hide();
            $('#defect').val('');
            $('#location').val('');
            $('#cause').val('');
            $('#action').val('');
            processStatus = 'Good';
            $('#status').val('Good');
        });

        $('#btn-show-add-defect').on('click', function(){
            $('#addDefectModal').modal('show');
        });

        $('#btn-add-defect').on('click', function(){
            if($('#defect').val() === ""){
                showErrorMessage('Select Defect');
            }else if($('#location').val() === ""){
                showErrorMessage('Select Location');
            }else if($('#cause').val() === ""){
                showErrorMessage('Input Cause');
            }else if($('#action').val() === ""){
                showErrorMessage('Input Action');
            }else{
                $('#tbl-defect-body').append(`
                    <tr>
                        <td class="nurut"></td>
                        <td>
                            <input type="text" name="defectItem[]" class="form-control" value="`+$('#defect').val()+`" readonly>
                        </td>
                        <td>
                            <input type="text" name="locationItem[]" class="form-control" value="`+$('#location').val()+`" readonly>
                        </td>
                        <td>
                            <input type="text" name="causeItem[]" class="form-control" value="`+$('#cause').val()+`" readonly>
                        </td>
                        <td>
                            <input type="text" name="actionItem[]" class="form-control" value="`+$('#action').val()+`" readonly>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm btnDeleteDefect">DELETE</button>
                        </td>
                    </tr>
                `);

                renumberRows();

                $('.btnDeleteDefect').on('click', function(e){
                    e.preventDefault();
                    var row_index = $(this).closest("tr").index();                  
                    $(this).closest("tr").remove();
                    renumberRows();
                });

                $('#cause').val('');
                $('#action').val('');
            }
        });

        function renumberRows() {
            $(".mainbodynpo > tr").each(function(i, v) {
                $(this).find(".nurut").text(i + 1);
            });
        }

        $('#partcode').keydown(function(e){
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
                        $('#partnumber').val(inputMaterial);
                        $('#partmodel').val(data.matdesc);
                        // document.getElementById("lotnumber").focus();
                        if(isFirstprocess == 1){
                            document.getElementById("scanlotcode").focus();
                        }else{
                            document.getElementById("lotnumber").focus();
                        }
                    }else{
                        showErrorMessage('Assy NO, Not Found');
                    }

                    $('#partcode').val('');
                })
            }
        });

        $('#scanlotcode').keydown(function(e){
            var inputLotcode = this.value;
            if(e.keyCode == 13) {
                $('#lotcode').val(inputLotcode);
                document.getElementById("lotnumber").focus();
                $('#scanlotcode').val('');
            }
        });

        $('#lotnumber').keydown(function(e){
            var inputSerial = this.value;

            const currentDate = new Date();
            const timestamp = currentDate.getTime();

            if(e.keyCode == 13) {
                $.ajax({
                    url: base_url+'/transaction/getserialprocess/data?serial='+inputSerial,
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
                    $('#tbl-body-lastproc').html('');
                    
                    if(isFirstprocess == 1){
                        if(data._lastprocess){
                            $('#_lotnumber').val(inputSerial);
                            $('#formid').val(data.transactionid);
                            $('#partnumber').val(data.partnumber);
                            $('#partmodel').val(data.partmodel);
                            $('#lotcode').val(data.lotcode);
                            document.getElementById("lotnumber").focus();
                            var lastProc = 'process'+data.lastprocess;
                            var lastProcessStatus = data[lastProc];
                            if(data._lastprocess){
                                $('#tbl-body-lastproc').append(`
                                    <tr>
                                        <td>`+ data.partmodel +`</td>
                                        <td>`+ data.partnumber +`</td>
                                        <td>`+ data.serial_no +`</td>
                                        <td>`+ data._lastprocess.processname +`</td>
                                        <td>`+ lastProcessStatus +`</td>
                                    </tr>
                                `);
                            }else{

                                if(lastProcessStatus === null || lastProcessStatus === 'null'){
                                    lastProcessStatus = '';
                                }
                                $('#tbl-body-lastproc').append(`
                                    <tr>
                                        <td>`+ data.partmodel +`</td>
                                        <td>`+ data.partnumber +`</td>
                                        <td>`+ data.serial_no +`</td>
                                        <td>`+ data._lastprocess.processname +`</td>
                                        <td>`+ lastProcessStatus +`</td>
                                    </tr>
                                `);
                            }
                        }else{
                            if(data.lastprocess == 0){
                                // alert(data.lastprocess)
                                // var lastProc = 'process'+data.lastprocess;
                                // var lastProcessStatus = data[lastProc];
                                // alert(lastProcessStatus)
                                $('#_lotnumber').val(inputSerial);
                                $('#formid').val(data.transactionid);
                                $('#partnumber').val(data.partnumber);
                                $('#partmodel').val(data.partmodel);
                                $('#lotcode').val(data.lotcode);

                                // if(lastProcessStatus === null || lastProcessStatus === 'null'){
                                //     lastProcessStatus = '';
                                // }
                                $('#tbl-body-lastproc').append(`
                                    <tr>
                                        <td>`+ data.partmodel +`</td>
                                        <td>`+ data.partnumber +`</td>
                                        <td>`+ data.serial_no +`</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                `);
                            }else{
                                $('#_lotnumber').val(inputSerial);
                                $('#formid').val(timestamp);
                            }
                        }                                             
                    }else{
                        if(data){
                            $('#_lotnumber').val(inputSerial);
                            $('#formid').val(data.transactionid);
                            $('#partnumber').val(data.partnumber);
                            $('#partmodel').val(data.partmodel);
                            $('#lotcode').val(data.lotcode);
                            document.getElementById("lotnumber").focus();
    
                            var lastProc = 'process'+data.lastprocess;
                            var lastProcessStatus = data[lastProc];

                            if(lastProcessStatus === null || lastProcessStatus === 'null'){
                                lastProcessStatus = '';
                            }
    
                            if(data._lastprocess){
                                $('#tbl-body-lastproc').html('');
                                $('#tbl-body-lastproc').append(`
                                    <tr>
                                        <td>`+ data.partmodel +`</td>
                                        <td>`+ data.partnumber +`</td>
                                        <td>`+ data.serial_no +`</td>
                                        <td>`+ data._lastprocess.processname +`</td>
                                        <td>`+ lastProcessStatus +`</td>
                                    </tr>
                                `);
                            }
                        }else{
                            showErrorMessage('Serial No Not Found');
                            $('#lotnumber').val('');
                            $('#formid').val('');
                            $('#partnumber').val('');
                            $('#partmodel').val('');
                            $('#lotcode').val('');
                            document.getElementById("lotnumber").focus();
                        }
                    }

                    $('#lotnumber').val('');
                });
            }
        });

        $('#form-process-data').on('submit', function(event){
            event.preventDefault();
                
            var formData = new FormData(this);
            console.log($(this).serialize())
                $.ajax({
                    url:base_url+'/transaction/saveprocess',
                    method:'post',
                    data:formData,
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend:function(){
                        $('#btn-save').attr('disabled','disabled');
                    },
                    success:function(data)
                    {
                    	console.log(data);
                    },
                    error:function(err){
                        showErrorMessage(JSON.stringify(err))
                    }
                }).done(function(result){
                    if(result.msgtype === "1"){
                        showSuccessMessage(result.message);
                    }else if(result.msgtype === "2"){
                        showErrorMessage(JSON.stringify(result.message))            
                    }
                    $("#btn-save").attr("disabled", false);
                    // $('#_lotnumber').val('');
                    // $('#formid').val('');   
                    // $('#status').val('');
                    document.getElementById("lotnumber").focus();
                    $('#btn-save').show();
                    $('#btn-save-nogood').hide();
                    $('#btn-cancel').hide();
                    $('#btn-no-good').show();

                    $('.ngInput').hide();
                    $('#defect').val('');
                    $('#location').val('');
                    $('#cause').val('');
                    $('#action').val('');
                    processStatus = 'Good';
                    $('#status').val('Good');
                });
            })

        function showSuccessMessage(message) {
            swal({title: "Success!", text: message, type: "success"},
                function(){ 
                    // window.location.href = base_url+'/wos';
                    document.getElementById("lotnumber").focus();
                }
            );
        }

        function showErrorMessage(message){
            swal({title:"", text: message, type:"warning"},
                function(){
                    document.getElementById("lotnumber").focus();
                }
            );
        }
    });
</script>