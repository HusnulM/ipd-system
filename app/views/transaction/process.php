<?php 
    $isFirstProcess = false;
    $transid = date_create();
    $formid  = date_timestamp_get($transid);
    if($data['process']['sequence'] == 1){
        $isFirstProcess = true;
    }
?>
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
                                <div class="col-lg-6">
                                    <?php if($isFirstProcess): ?>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="partcode">SCAN ASSY NO</label>
                                            <input type="text" name="partcode" id="partcode" class="form-control" autocomplete="off"/>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="lotnumber">SCAN LOT / SERIAL</label>
                                            <input type="text" name="lotnumber" id="lotnumber" class="form-control" autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                            <label for="_lotnumber">LOT / SERIAL</label>
                                            <input type="text" name="_lotnumber" id="_lotnumber" class="form-control" readonly required/>
                                        </div>
                                        <div class="col-lg-6 col-md-12 col-sm-12 col-xm-12">
                                            <label for="formid">FORM ID</label>
                                            <input type="text" name="formid" id="formid" class="form-control" autocomplete="off" readonly/>
                                        </div>
                                    </div>
                                    <!-- <div class="row">
                                    </div> -->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="partmodel">MODEL CODE</label>
                                            <input type="text" name="partmodel" id="partmodel" class="form-control"  readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="partnumber">ASSY NO</label>
                                            <input type="text" name="partnumber" id="partnumber" class="form-control" readonly="true" required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="status">STATUS</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value=""></option>
                                                <option value="Good">Good</option>
                                                <option value="NG">NG</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <input type="text" name="otherstatus" id="otherstatus" class="form-control" style="display:none;">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 ngInput" style="display:none;">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="defect">DEFECT NAME</label>
                                            <select name="defect" id="defect" class="form-control">
                                                <option value=""></option>
                                                <?php foreach($data['defect'] as $row) : ?>
                                                    <option value="<?= $row['defectname']; ?>"><?= $row['defectname']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="location">LOCATION</label>
                                            <select name="location" id="location" class="form-control">
                                                <option value=""></option>
                                                <?php foreach($data['location'] as $row) : ?>
                                                    <option value="<?= $row['locationname']; ?>"><?= $row['locationname']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="cause">CAUSE NAME</label>
                                            <select name="cause" id="cause" class="form-control">
                                                <option value=""></option>
                                                <?php foreach($data['cause'] as $row) : ?>
                                                    <option value="<?= $row['causename']; ?>"><?= $row['causename']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="action">ACTION</label>
                                            <select name="action" id="action" class="form-control">
                                                <option value=""></option>
                                                <?php foreach($data['action'] as $row) : ?>
                                                    <option value="<?= $row['actionname']; ?>"><?= $row['actionname']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <button type="submit" id="btn-save" class="btn btn-primary">SAVE</button>
                                                <a href="<?= BASEURL; ?>" class="btn btn-danger">CANCEL</a>
                                            </div>
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
</section>

<script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
<script>

    $(document).ready(function(){
        var isFirstprocess = "<?= $isFirstProcess; ?>";
        var formID = "<?= $formid; ?>";
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        if(isFirstprocess == 1){
            document.getElementById("partcode").focus();
        }else{
            document.getElementById("lotnumber").focus();
        }

        $('#status').on('change', function(){
            if(this.value === "Other"){
                $('#otherstatus').show();
            }else{
                $('#otherstatus').hide();
            }

            if(this.value === "NG"){
                $('.ngInput').show();
            }else{
                $('.ngInput').hide();
                $('#defect').val('');
                $('#location').val('');
                $('#cause').val('');
                $('#action').val('');
            }
        });

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
                        document.getElementById("lotnumber").focus();
                    }else{
                        showErrorMessage('Assy NO, Not Found');
                    }

                    $('#partcode').val('');
                })
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
                    if(isFirstprocess == 1){
                        if(data._lastprocess){
                            $('#_lotnumber').val(inputSerial);
                            $('#formid').val(data.transactionid);
                            $('#partnumber').val(data.partnumber);
                            $('#partmodel').val(data.partmodel);
                            document.getElementById("lotnumber").focus();
    
                            var lastProc = 'process'+data.lastprocess;
    
                            if(data._lastprocess){
                                $('#tbl-body-lastproc').html('');
                                $('#tbl-body-lastproc').append(`
                                    <tr>
                                        <td>`+ data.partmodel +`</td>
                                        <td>`+ data.partnumber +`</td>
                                        <td>`+ data.serial_no +`</td>
                                        <td>`+ data._lastprocess.processname +`</td>
                                        <td>`+ data[lastProc] +`</td>
                                    </tr>
                                `);
                            }
                        }else{
                            $('#_lotnumber').val(inputSerial);
                            $('#formid').val(timestamp);   
                        }                                             
                    }else{
                        if(data){
                            $('#_lotnumber').val(inputSerial);
                            $('#formid').val(data.transactionid);
                            $('#partnumber').val(data.partnumber);
                            $('#partmodel').val(data.partmodel);
                            document.getElementById("lotnumber").focus();
    
                            var lastProc = 'process'+data.lastprocess;
    
                            if(data._lastprocess){
                                $('#tbl-body-lastproc').html('');
                                $('#tbl-body-lastproc').append(`
                                    <tr>
                                        <td>`+ data.partmodel +`</td>
                                        <td>`+ data.partnumber +`</td>
                                        <td>`+ data.serial_no +`</td>
                                        <td>`+ data._lastprocess.processname +`</td>
                                        <td>`+ data[lastProc] +`</td>
                                    </tr>
                                `);
                            }
                        }else{
                            showErrorMessage('Serial No Not Found');
                            $('#lotnumber').val('');
                            $('#formid').val('');
                            $('#partnumber').val('');
                            $('#partmodel').val('');
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
                    $('#_lotnumber').val('');
                    $('#formid').val('');   
                    $('#status').val('');
                    document.getElementById("lotnumber").focus();
                })
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