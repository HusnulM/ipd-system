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
                            <?php if($data['process']['sequence'] === "1"): ?>
                                <?= $data['menu']; ?>
                            <?php else: ?>
                                <?= $data['menu']; ?> <b>[ <?= $data['process']['processname']; ?> ]</b>
                            <?php endif; ?>
                        </h2>
                    </div>
                    <div class="body">
                        <form action="<?= BASEURL; ?>/transaction/saverepair" method="POST">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-12 col-sm-12 col-xm-12">
                                            <label for="lotnumber">SCAN LOT / SERIAL</label>
                                            <input type="text" name="lotnumber" id="lotnumber" class="form-control" autocomplete="off"/>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-sm-12 col-xm-12">
                                            <label for="_lotnumber">LOT / SERIAL</label>
                                            <input type="text" name="_lotnumber" id="_lotnumber" class="form-control" readonly required/>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-sm-12 col-xm-12">
                                            <label for="formid">FORM ID</label>
                                            <input type="text" name="formid" id="formid" class="form-control" autocomplete="off" readonly/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-12 col-sm-12 col-xm-12">
                                            <label for="partmodel">MODEL CODE</label>
                                            <input type="text" name="partmodel" id="partmodel" class="form-control"  readonly="true"/>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-sm-12 col-xm-12">
                                            <label for="partnumber">PART CODE</label>
                                            <input type="text" name="partnumber" id="partnumber" class="form-control" readonly="true" required/>
                                        </div>
                                        <div class="col-lg-4 col-md-12 col-sm-12 col-xm-12">
                                            <label for="lotcode">LOT CODE</label>
                                            <input type="text" name="lotcode" id="lotcode" class="form-control" readonly="true" />
                                            <input type="hidden" name="status" id="status">
                                            <input type="hidden" name="otherstatus" id="otherstatus" class="form-control" style="display:none;">
                                        </div>
                                    </div>
                                    <div class="row showRemark" style="display:none;">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="remark">REMARK</label>
                                            <input type="text" name="remark" id="remark" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="defect">DEFECT NAME</label>
                                            <input type="text" name="defectname" id="defectname" class="form-control" readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="location">LOCATION</label>
                                            <input type="text" name="location" id="location" class="form-control" readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="cause">CAUSE NAME</label>
                                            <input type="text" name="cause" id="cause" class="form-control" readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="action">ACTION</label>
                                            <input type="text" name="actionName" id="actionName" class="form-control" <?= $data['process']['sequence'] === "1" ? '' : 'readonly'; ?>/>
                                        </div>
                                    </div>
                                    <div class="row showRemark" style="display:none;">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="remark">REMARK</label>
                                            <input type="text" name="remark" id="remark" class="form-control"/>
                                        </div>
                                    </div>                                    
                                </div> -->
                                
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                            <div class="form-group">
                                                <button type="submit" id="btn-save" class="btn btn-primary" style="height: 50px; width:150px;">
                                                    <i class="material-icons">done</i> PASS
                                                </button>
                                                <button type="button" id="btn-no-good" class="btn btn-danger" style="height: 50px; width:150px;">
                                                    <i class="material-icons">close</i> NOT PASS
                                                </button>
                                                <button type="submit" id="btn-save-nogood" class="btn btn-primary" style="height: 50px; width:150px;display:none;">
                                                    <i class="material-icons">save</i> SAVE
                                                </button>
                                                <button type="button" id="btn-cancel" class="btn btn-danger" style="height: 50px; width:150px; display:none;">
                                                    <i class="material-icons">close</i> CANCEL
                                                </button>
                                                <!-- <button type="submit" id="btn-save" class="btn btn-primary">SAVE</button> -->
                                                <!-- <a href="<?= BASEURL; ?>" class="btn btn-danger">CANCEL</a> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <table id="tbl-defect-data" class="table table-stripped table-bordered">
                                        <thead>
                                            <th>No</th>
                                            <th>Defect Name</th>
                                            <th>Location</th>
                                            <th>Cause Name</th>
                                            <th>Action</th>
                                            <th>Repair Action</th>
                                            <!-- <th>Remark</th> -->
                                        </thead>
                                        <tbody id="tbl-defect-body" class="mainbodynpo">
                                            
                                        </tbody>
                                    </table>
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
        var processStatus = 'PASS';
        $('#status').val('PASS');

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        document.getElementById("lotnumber").focus();

        $('#btn-no-good').on('click', function(){
            $('#btn-save').hide();
            $('#btn-save-nogood').show();
            $('#btn-cancel').show();
            $('#btn-no-good').hide();
            $('.showRemark').show();
            processStatus = 'NOT PASS';

            $('#status').val('NOT PASS');
        });

        $('#btn-cancel').on('click', function(){
            $('#btn-save').show();
            $('#btn-save-nogood').hide();
            $('#btn-cancel').hide();
            $('#btn-no-good').show();

            $('.showRemark').hide();
            $('#defect').val('');
            $('#location').val('');
            $('#cause').val('');
            $('#action').val('');
            processStatus = 'Good';
            $('#status').val('Good');
        });

        $('#status').on('change', function(){
            if(this.value === "NOT PASS"){
                $('.showRemark').show();
            }else{
                $('.showRemark').hide();
            }
        });

        $('#lotnumber').keydown(function(e){
            var inputSerial = this.value;
            if(e.keyCode == 13) {
                $.ajax({
                    url: base_url+'/transaction/getserialrepair/data?serial='+inputSerial,
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
                        $('#_lotnumber').val(data.serial_no);
                        $('#formid').val(data.transactionid);
                        $('#partnumber').val(data.partnumber);
                        $('#partmodel').val(data.partmodel);
                        $('#lotcode').val(data.lotcode);
                        $('#defectname').val(data.repair_defect);
                        $('#location').val(data.repair_location);
                        $('#cause').val(data.cause);
                        $('#actionName').val(data.repair_action);
                        document.getElementById("lotnumber").focus();

                        if(data.lastrepair == null){

                        }else{
                            var lastProc = 'repair'+data.lastrepair;

                            if(data._lastrepair){
                                $('#tbl-body-lastproc').html('');
                                $('#tbl-body-lastproc').append(`
                                    <tr>
                                        <td>`+ data.partmodel +`</td>
                                        <td>`+ data.partnumber +`</td>
                                        <td>`+ data.serial_no +`</td>
                                        <td>`+ data._lastrepair.processname +`</td>
                                        <td>`+ data[lastProc] +`</td>
                                    </tr>
                                `);
                            }
                        }

                        readDefectData(data.transactionid);
                    }else{
                        showErrorMessage('Serial No Not Found');
                        $('#lotnumber').val('');
                        $('#formid').val('');
                        $('#partnumber').val('');
                        $('#partmodel').val('');
                        document.getElementById("lotnumber").focus();
                    }

                    $('#lotnumber').val('');
                });
            }
        });

        function readDefectData(formid){
            $('#tbl-defect-body').html('');
            $.ajax({
                url: base_url+'/transaction/getDefectData/'+formid,
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
                var repairAct = '';
                var remarkItm = '';
                for(var i = 0; i < data.length; i++){
                    if(data[i].repairaction !== null && data[i].repairaction !== 'null'){
                        repairAct = data[i].repairaction;
                    }
                    // if(data[i].remark !== null && data[i].remark !== 'null'){
                    //     remarkItm = data[i].remark;
                    // }
                    $('#tbl-defect-body').append(`
                        <tr>
                            <td class="nurut"></td>
                            <td>
                                <input type="text" name="defectItem[]" class="form-control" value="`+data[i].defect+`" readonly>
                                <input type="hidden" name="defectId[]" class="form-control" value="`+data[i].id+`" readonly>
                            </td>
                            <td>
                                <input type="text" name="locationItem[]" class="form-control" value="`+data[i].location+`" readonly>
                            </td>
                            <td>
                                <input type="text" name="causeItem[]" class="form-control" value="`+data[i].cause+`" readonly>
                            </td>
                            <td>
                                <input type="text" name="actionItem[]" class="form-control" value="`+data[i].action+`" readonly>
                            </td>
                            <td>
                                <input type="text" name="repairactionItem[]" class="form-control" value="`+repairAct+`">
                            </td>
                            
                        </tr>
                    `);
                    renumberRows();
                }
                // if(data){
                //     $('#partnumber').val(inputMaterial);
                //     $('#partmodel').val(data.matdesc);
                //         // document.getElementById("lotnumber").focus();
                //     if(isFirstprocess == 1){
                //         document.getElementById("scanlotcode").focus();
                //     }else{
                //         document.getElementById("lotnumber").focus();
                //     }
                // }else{
                //     showErrorMessage('Assy NO, Not Found');
                // }
                // $('#partcode').val('');
            });
        }

        function renumberRows() {
            $(".mainbodynpo > tr").each(function(i, v) {
                $(this).find(".nurut").text(i + 1);
            });
        }

        function showSuccessMessage(message) {
            swal({title: "Success!", text: message, type: "success"},
                function(){ 
                    // window.location.href = base_url+'/wos';
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