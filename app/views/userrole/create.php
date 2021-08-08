<section class="content">
        <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>
                        </div>
                        <div class="body">
                            <form action="<?= BASEURL; ?>/userrole/save" method="POST">
                                <div class="row clearfix">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="username">User</label>
                                                <select name="username" class="form-control">
                                                    <?php foreach($data['user'] as $out): ?>
                                                    <option value="<?= $out['username']; ?>"><?= $out['username']; ?> - <?= $out['nama']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="username">Role</label>
                                                <select name="roleid" class="form-control">
                                                    <?php foreach($data['roles'] as $role): ?>
                                                    <option value="<?= $role['roleid']; ?>"><?= $role['rolename']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                <!-- <div class="row clearfix">                            
                                    <div class="col-sm-6">
                                        <div class="form-group" style="padding:10dp;">
                                            <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Save</button>

                                            <a href="<?= BASEURL; ?>/userrole" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Cancel</a>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="card">
                                    <div class="header">
                                        <h2>
                                            Add Role
                                        </h2>
                                                
                                        <ul class="header-dropdown m-r--5">                                
                                            
                                        </ul>
                                    </div>
                                    <div class="body">
                                        <div class="table-responsive">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <table class="table table-bordered table-striped table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th style="width:150px;">Role ID</th>
                                                            <th>Role Name</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbl-pr-body" class="mainbodynpo">

                                                    </tbody>
                                                </table>
                                                <ul class="pull-right">    
                                                    <button type="button" id="btn-dlg-add-item" class="btn bg-blue">
                                                        <i class="material-icons">playlist_add</i> <span>ADD ROLE</span>
                                                    </button>
                                                    <a href="<?= BASEURL; ?>/userrole" class="btn bg-red">
                                                        <i class="material-icons">highlight_off</i> <span>CANCEL</span>
                                                    </a>
                                                    <button type="submit" class="btn bg-blue">
                                                        <i class="material-icons">save</i> <span>SAVE</span>
                                                    </button>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="menuModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-m" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="menuModalText">Add User Role</h4>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-responsive" id="list-menu" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Role ID</th>
                                            <th>Role Name</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">TUTUP</button>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <script>
        $(document).ready(function(){
            var count = 0;
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            $('#btn-dlg-add-item').on('click', function(){
                $('#menuModal').modal('show')
            });

            loaddatabarang();
            function loaddatabarang(){
                $('#list-menu').dataTable({
                    "ajax": base_url+'/role/listrole',
                    "columns": [
                        { "data": "roleid" },
                        { "data": "rolename" },
                        {"defaultContent": "<button class='btn btn-primary btn-xs'>Add</button>"}
                    ],
                    "bDestroy": true,
                    "paging":   true,
                    "searching":   true
                });

                $('#list-menu tbody').on( 'click', 'button', function () {
                    var table = $('#list-menu').DataTable();
                    selected_data = [];
                    selected_data = table.row($(this).closest('tr')).data();

                    count = count+1;
                    html = '';
                    html = `
                        <tr counter="`+ count +`" id="tr`+ count +`">
                            <td class="nurut"> 
                                `+ count +`
                                <input type="hidden" name="itm_no[]" value="`+ count +`" />
                            </td>
                            <td> 
                                <input type="text" name="itm_roleid[]" counter="`+count+`" class="form-control materialCode" style="width:150px;" required="true" value="`+ selected_data.roleid +`" readonly/>
                            </td>
                            <td> 
                                <input type="text" name="itm_rolename[]" counter="`+count+`" class="form-control" style="width:100%;" value="`+ selected_data.rolename +`" readonly/>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm removePO hideComponent" counter="`+count+`">Remove</button>
                            </td>
                        </tr>
                    `;
                    $('#tbl-pr-body').append(html);
                    renumberRows();

                    $('.removePO').on('click', function(e){
                        e.preventDefault();
                        $(this).closest("tr").remove();
                        renumberRows();
                    });
                } );
            }

            function renumberRows() {
                $(".mainbodynpo > tr").each(function(i, v) {
                    $(this).find(".nurut").text(i + 1);
                });
            }
        })
    </script>