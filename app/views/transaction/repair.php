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
                        <form action="<?= BASEURL; ?>/transaction/saverepair" method="POST">
                            <div class="row">
                                <div class="col-lg-6">
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
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="partmodel">MODEL CODE</label>
                                            <input type="text" name="partmodel" id="partmodel" class="form-control"  readonly="true"/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="partnumber">PART CODE</label>
                                            <input type="text" name="partnumber" id="partnumber" class="form-control" readonly="true" required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="status">STATUS</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value=""></option>
                                                <option value="PASS">PASS</option>
                                                <option value="NOT PASS">NOT PASS</option>
                                            </select>
                                            <input type="text" name="otherstatus" id="otherstatus" class="form-control" style="display:none;">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
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
                                            <input type="text" name="actionName" id="actionName" class="form-control" readonly="true"/>
                                        </div>
                                    </div>
                                    <?php if($data['process']['sequence'] == 6): ?>
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                                <label for="remark">REMARK</label>
                                                <input type="text" name="remark" id="remark" class="form-control"/>
                                            </div>
                                        </div>
                                    <?php endif; ?>
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
        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        document.getElementById("lotnumber").focus();

        $('#status').on('change', function(){
            if(this.value === "Other"){
                $('#otherstatus').show();
            }else{
                $('#otherstatus').hide();
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
                        $('#defectname').val(data.repair_defect);
                        $('#location').val(data.repair_location);
                        $('#cause').val(data.cause);
                        $('#actionName').val(data.repair_action);
                        document.getElementById("lotnumber").focus();

                        if(data.lastrepair == null){

                        }else{
                            var lastProc = 'repair'+data.lastrepair;
                            // alert(lastProc)

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