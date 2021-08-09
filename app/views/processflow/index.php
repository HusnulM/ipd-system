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
							
							</ul>
                        </div>
                        
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Transaction</th>
                                            <th>Process Name</th>
                                            <th>Sequence</th>
                                            <th>User ID</th>
                                            <th style="width:100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 0; ?>
                                        <?php foreach($data['rdata'] as $row) : ?>
                                            <?php $no++; ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $row['transtype']; ?></td>
                                                <td><?= $row['processname']; ?></td>
                                                <td><?= $row['sequence']; ?></td>
                                                <td><?= $row['username']; ?></td>
                                                <td>
                                                    <button type="button" class="btn btn-primary btnChangeUser" data-processid="<?= $row['id'] ?>" data-type="<?= $row['transtype'] ?>" data-processname="<?= $row['processname'] ?>" data-sequence="<?= $row['sequence'] ?>" data-username="<?= $row['username'] ?>">Change User</button>
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

        <div class="modal fade" id="modalChangePIC" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-m" role="document">
                <form action="<?= BASEURL; ?>/processflow/save" method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="menuModalText">Change PIC</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label for="transtype">Transaction Type</label>
                                    <input type="text" class="form-control" name="transtype" id="transtype" readonly>
                                    <input type="hidden" name="processid" id="processid">
                                </div>
                                <div class="col-lg-12">
                                    <label for="process">Process Name</label>
                                    <input type="text" class="form-control" name="process" id="process" readonly>
                                </div>
                                <div class="col-lg-12">
                                    <label for="sequence">Sequence</label>
                                    <input type="text" class="form-control" name="sequence" id="sequence" readonly>
                                </div>
                                <div class="col-lg-12">
                                    <label for="pic">PIC</label>
                                    <input type="text" class="form-control" name="pic" id="pic">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">
                                CLOSE
                            </button>
                            <button type="submit" class="btn btn-primary" id="btn-save">
                                SAVE
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <script>
        $(function(){
            $('.btnChangeUser').on('click', function(){
                var _data = $(this).data();
                $('#processid').val(_data.processid);
                $('#transtype').val(_data.type);
                $('#process').val(_data.processname);
                $('#sequence').val(_data.sequence);
                $('#pic').val(_data.username);

                $('#modalChangePIC').modal('show');
            });

            // $('#btn-save').on('click', function(){
            //     $('#modalChangePIC').modal('hide');
            // });
        })
    </script>