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
                        <form action="<?= BASEURL; ?>/transaction/saveprocess" method="POST">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
                                            <label for="lotnumber">LOT / SERIAL</label>
                                            <input type="text" name="lotnumber" id="lotnumber" class="form-control" autocomplete="off" required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xm-12">
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

        $('#lotnumber').keydown(function(e){
            var inputSerial = this.value;
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
                    if(data){
                        $('#formid').val(data.transactionid);
                        $('#partnumber').val(data.partnumber);
                        $('#partmodel').val(data.partmodel);
                        document.getElementById("lotnumber").focus();
                    }else{
                        showErrorMessage('Serial No Not Found');
                        $('#lotnumber').val('');
                        $('#formid').val('');
                        $('#partnumber').val('');
                        $('#partmodel').val('');
                        document.getElementById("lotnumber").focus();
                    }
                })
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