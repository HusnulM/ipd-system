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
							<a href="<?= BASEURL; ?>/menurole/create" class="btn btn-success waves-effect pull-right">Create Assignment</a>
							</ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Menu</th>
                                            <th>Role</th>
                                            <th style="width:250px;text-align:center;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach($data['data'] as $out) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $out['menu']; ?></td>
                                                <td><?= $out['rolename']; ?></td>
                                                <td>
                                                    <!-- <a href="<?= BASEURL; ?>/menurole/edit/<?= $out['menuid']; ?>" type="button" class="btn btn-success">Edit</a> -->
                                                    <a href="<?= BASEURL; ?>/menurole/delete/<?= $out['roleid']; ?>/<?= $out['menuid']; ?>" type="button" class="btn btn-danger">Delete Assignment</a>
                                                    <button type="button" class="btn btn-primary btn_set_avtivity" data-menuid="<?= $out['menuid']; ?>" data-roleid="<?= $out['roleid']; ?>" data-role="<?= $out['rolename']; ?>" data-menu="<?= $out['menu']; ?>">Set Menu Activity</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
            <div class="modal fade" id="setAvtivitiModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-m" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" >Avtivity Setting</h4>
                            <hr>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <table class="table table-responsive">
                                    <thead>
                                        <th>Role</th>
                                        <th>Menu</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" id="selectedrole" class="form-control" readonly>
                                            </td>
                                            <td>
                                                <input type="text" id="selectedmenu" class="form-control" readonly>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                
                                <table class="table table-responsive">
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="cb1" class="filled-in" />
                                            <label for="cb1">Display</label>
                                        </td>
                                        <td>
                                            <input type="checkbox" id="cb2" class="filled-in" />
                                            <label for="cb2">Create</label>
                                        </td>
                                        <td>
                                            <input type="checkbox" id="cb3" class="filled-in" />
                                            <label for="cb3">Update</label>
                                        </td>
                                        <td>
                                            <input type="checkbox" id="cb4" class="filled-in" />
                                            <label for="cb4">Delete</label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" id="btn-set-activity" class="btn btn-primary waves-effect" data-dismiss="modal">SAVE</button>
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>        
    </section>
    
    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        var selected = '';
        $(function(){
            $('.btn_set_avtivity').on('click', function(){
                selected = $(this).data();
                // console.log(selected)
                readActivity(selected.roleid,selected.menuid);

                $('#selectedrole').val(selected.role);
                $('#selectedmenu').val(selected.menu);
                $('#setAvtivitiModal').modal('show');
            })

            $('#btn-set-activity').on('click', function(){
                var oheader = {};
                var oitem   = {};
                var pdata   = {};
                var header  = [];
                var items   = [];

                if($('#cb1').prop('checked') == true){
                    oheader = {}
                    oheader.roleid     = selected.roleid;
                    oheader.menuid     = selected.menuid;
                    oheader.activity   = 'Read';
                    oheader.status     = 1;
                    header.push(oheader);
                }else{
                    oheader = {}
                    oheader.roleid     = selected.roleid;
                    oheader.menuid     = selected.menuid;
                    oheader.activity   = 'Read';
                    oheader.status     = 0;
                    header.push(oheader);
                }

                if($('#cb2').prop('checked') == true){
                    oheader = {}
                    oheader.roleid     = selected.roleid;
                    oheader.menuid     = selected.menuid;
                    oheader.activity   = 'Create';
                    oheader.status     = 1;
                    header.push(oheader);
                }else{
                    oheader = {}
                    oheader.roleid     = selected.roleid;
                    oheader.menuid     = selected.menuid;
                    oheader.activity   = 'Create';
                    oheader.status     = 0;
                    header.push(oheader);
                }

                if($('#cb3').prop('checked') == true){
                    oheader = {}
                    oheader.roleid     = selected.roleid;
                    oheader.menuid     = selected.menuid;
                    oheader.activity   = 'Update';
                    oheader.status     = 1;
                    header.push(oheader);
                }else{
                    oheader = {}
                    oheader.roleid     = selected.roleid;
                    oheader.menuid     = selected.menuid;
                    oheader.activity   = 'Update';
                    oheader.status     = 0;
                    header.push(oheader);
                }

                if($('#cb4').prop('checked') == true){
                    oheader = {}
                    oheader.roleid     = selected.roleid;
                    oheader.menuid     = selected.menuid;
                    oheader.activity   = 'Delete';
                    oheader.status     = 1;
                    header.push(oheader);
                }else{
                    oheader = {}
                    oheader.roleid     = selected.roleid;
                    oheader.menuid     = selected.menuid;
                    oheader.activity   = 'Delete';
                    oheader.status     = 0;
                    header.push(oheader);
                }

                
                pdata = {
                            'activity' : header
                        }
                
                $("#btn-set-activity").attr("disabled", true);
                $.ajax({
                    url: base_url+'/menurole/saveactivity',
                    data: pdata,
                    type: 'POST',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                                    
                    },error: function(err){
                        showErrorMessage(JSON.stringify(err))
                        $("#btn-set-activity").attr("disabled", false);
                    }
                }).done(function(data){
                    console.log(data)
                    showSuccessMessage('Role Activity Updated!');
                    $("#btn-set-activity").attr("disabled", false);
                    
                });

            })

            function readActivity(roleid, menuid){
                $('#cb1').prop('checked',false);
                $('#cb2').prop('checked',false);
                $('#cb3').prop('checked',false);
                $('#cb4').prop('checked',false);
                // alert(base_url+'/menurole/getActivity/'+roleid+'/'+menuid);
                $.ajax({
                    url: base_url+'/menurole/getActivity/'+roleid+'/'+menuid,
                    type: 'GET',
                    dataType: 'json',
                    cache:false,
                    success: function(result){
                        console.log(result)
                        for(var i=0; i<result.length;i++){
                            if(result[i].activity === 'Read' && result[i].status === '1'){
                                $('#cb1').prop('checked',true);
                            }else if(result[i].activity === 'Create' && result[i].status === '1'){
                                $('#cb2').prop('checked',true);
                            }else if(result[i].activity === 'Update' && result[i].status === '1'){
                                $('#cb3').prop('checked',true);
                            }else if(result[i].activity === 'Delete' && result[i].status === '1'){
                                $('#cb4').prop('checked',true);
                            }
                        }
                    },
                    error: function(err){
                        console.log(err)
                    }
                })
            }

            function showSuccessMessage(message) {
                swal({title: "Success!", text: message, type: "success"},
                    function(){ 
                        // window.location.href = base_url+'/menurole';
                        $('#setAvtivitiModal').modal('hide');
                    }
                );
            }

            function showErrorMessage(message){
                swal("Error", message, "error");
            }
        })
    </script>