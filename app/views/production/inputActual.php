<section class="content">
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>
                            <!-- <ul class="header-dropdown m-r--5">                                
							    <a href="<?= BASEURL; ?>/menugroup/create" class="btn btn-success waves-effect pull-right">Create Menu Group</a>
							</ul> -->
                        </div>
                        <div class="body">
                            <form action="<?= BASEURL; ?>/production/save" method="POST">
                                <div class="row clearfix">
                                    <div class="col-sm-3">
                                        <div class="form-line">
                                            <label for="">PLAN DATE</label>
                                            <input type="date" name="plandate" id="plandate" class="form-control" value="<?= date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-line">
                                            <label for="prodline">Production Line</label>
                                            <select name="prodline" id="prodline" class="form-control" data-live-search="true" required>
                                                <?php foreach($data['lines'] as $d) : ?>
                                                    <option value="<?= $d['id']; ?>"><?= $d['description']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-line">
                                            <label for="shift">Shift</label>
                                            <select name="shift" id="shift" class="form-control" data-live-search="true" required>
                                                <option value="1">Day Shift</option>
                                                <option value="2">Night Shift</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-line" style="text-align:center;">
                                            <br>
                                            <button type="button" class="btn bg-blue" id="btn-show-data">
                                                <i class="material-icons">search</i>SHOW DATA
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <table class="table">
                                            <thead>
                                                <th>NO.</th>
                                                <th style="width:500px;">MODEL</th>
                                                <th style="text-align:right;">PLAN QTY</th>
                                                <th style="text-align:right;">OUTPUT QTY</th>
                                                <th></th>
                                            </thead>
                                            <tbody class="mainbody" id="tbl-plan-item">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="actualQtyModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="actualQtyModalLabel">Input Actual Quantity</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table">
                                        <thead>
                                            <th>Model</th>
                                            <th>Planning Quantity</th>
                                            <th>Output Quantity</th>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" name="model_selected" id="model_selected" class="form-control" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="plan_qty" id="displ_plan_qty" class="form-control" style="text-align:right;" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" name="output_qty" id="output_qty" class="form-control" onkeypress="return onlyNumberKey(event)" maxlength="11" style="text-align:right;">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" style="text-align:right;">
                                                    <button type="button" class="btn btn-primary" id="btn-save-actual">SAVE</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-responsive" id="list-actual-qty" style="width:100%;">
                                        <thead>
                                            <th>No.</th>
                                            <th>Plan Date</th>
                                            <th>Line</th>
                                            <th>Shift</th>
                                            <th>Model</th>
                                            <th>Output Qty</th>
                                            <th>Input Date</th>
                                        </thead>
                                        <tbody id="tbl-actual-item">
                                            
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
        function onlyNumberKey(evt) {
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }

        $(function(){
            var count = 0;

            $('#btn-show-data').on('click', function(){
                getPlanning();
            });

            function getPlanning(){
                $.ajax({
                    url: base_url+'/production/getplanning',
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        plandate : $('#plandate').val(),
                        prodline : $('#prodline').val(),
                        shift: $('#shift').val()
                    },
                    cache:false,
                    success: function(result){

                    },
                    error: function(err){
                        console.log(err)
                    }
                }).done(function(data){
                    console.log(data)
                    $('#tbl-plan-item').html('');
                    if(data.length > 0){
                        count = 0;
                        for(var i = 0; i < data.length; i++){
                            count = count + 1;
                            $('#tbl-plan-item').append(`
                                <tr>
                                    <td>`+ count +`</td>
                                    <td>`+ data[i].model +`</td>
                                    <td style="text-align:right;">`+ data[i].plan_qty +`</td>
                                    <td style="text-align:right;">`+ data[i].outputqty +`</td>
                                    <td style="text-align:center;">
                                        <button type="button" class="btn btn-primary btn-sm btnInputActual" data-model="`+ data[i].model +`" data-planqty="`+ data[i].plan_qty +`">Input Actual Qty</button>
                                    </td>
                                </tr>
                            `);
                        }

                        $('.btnInputActual').on('click', function(){
                            var _data = $(this).data();
                            console.log(_data);
                            $('#model_selected').val(_data.model);
                            $('#displ_plan_qty').val(_data.planqty);
                            getActualQuantity(_data.model);
                            $('#actualQtyModal').modal('show');
                            // document.getElementById("output_qty").focus();
                            setTimeout(function() { 
                                $('#output_qty').focus();
                            }, 1000);
                        });
                    }
                });
            }

            function getActualQuantity(_model){
                // alert(_model)
                $('#tbl-actual-item').html('');
                $.ajax({
                    url: base_url+'/production/getactualdata',
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        plandate : $('#plandate').val(),
                        prodline : $('#prodline').val(),
                        shift: $('#shift').val(),
                        model: _model
                    },
                    cache:false,
                    success: function(result){

                    },
                    error: function(err){
                        console.log(err)
                    }
                }).done(function(data){
                    count = 0;
                    var _shift = '';
                    for(var i = 0; i < data.length; i++){
                        if(data[i].shift == 1){
                            _shift = 'Day Shift';
                        }else if(data[i].shift == 2){
                            _shift = 'Night Shift';
                        }
                        count = count + 1;
                        $('#tbl-actual-item').append(`
                            <tr>
                                <td>`+ count +`</td>
                                <td>`+ data[i].plandate +`</td>
                                <td>`+ data[i].linename +`</td>
                                <td>`+ _shift +`</td>
                                <td>`+ data[i].model +`</td>
                                <td style="text-align:right;">`+ data[i].output_qty +`</td>
                                <td>`+ data[i].createdon +`</td>
                            </tr>
                        `);
                        }
                });
            }

            $('#btn-save-actual').on('click', function(){
                if($('#output_qty').val() === "" ){
                    alert("Input Actual Quantity")
                }else{
                    saveActualQuantity($('#model_selected').val(),$('#output_qty').val());
                }
                setTimeout(function() { 
                    $('#output_qty').focus();
                }, 1000);
            });

            function saveActualQuantity(_model, _quantity){
                $.ajax({
                    url: base_url+'/production/saveactualdata',
                    type: 'POST',
                    dataType: 'json',
                    data:{
                        plandate : $('#plandate').val(),
                        prodline : $('#prodline').val(),
                        shift: $('#shift').val(),
                        model: _model,
                        quantity: _quantity
                    },
                    cache:false,
                    success: function(result){

                    },
                    error: function(err){
                        console.log(err)
                    }
                }).done(function(data){
                    if(data.msgtype === "1"){
                        showSuccessMessage(data.message);
                        $('#actualQtyModal').modal('hide');
                    }else{
                        showErrorMessage(data.message);
                    }
                    getPlanning();
                    $('#output_qty').val('')
                })
            }

            function renumberRows() {
                $(".mainbody > tr").each(function(i, v) {
                    $(this).find(".nurut").text(i + 1);
                });
            }

            function showSuccessMessage(message) {
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        // window.location.href = base_url+'/wos';
                        // document.getElementById("lotnumber").focus();
                    }
                );
            }

            function showErrorMessage(message){
                swal({title:"", text: message, type:"warning"},
                    function(){
                        // document.getElementById("lotnumber").focus();
                    }
                );
            }
        });
    </script>