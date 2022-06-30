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
                            <a href="<?= BASEURL; ?>/barcodeserial/create" class="btn bg-green">
                                <i class="material-icons">add</i> <span>Create Barcode Serial</span>
                            </a>
                            <a href="<?= BASEURL; ?>/barcodeserial/upload" class="btn bg-blue">
                                <i class="material-icons">upload</i> <span>Upload Barcode Serial</span>
                            </a>
                        </ul>
                    </div>
                    
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover" id="tbl-barcode">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Barcode Serial</th>
                                        <th>Part Number</th>
                                        <th>Part Lot Number</th>
                                        <th style="width:100px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() { 
        // $("#tbl-barcode").DataTable({
        //     serverSide: true,
        //     ajax: {
        //         url: base_url+'/barcodeserial/barcodelist',
        //         type: "POST",
        //         data: function (data) {
        //             data.params = {
        //                 sac: "sac"
        //             }
        //         }
        //     },
        //     "paging": true,
        //     "lengthChange": false,
        //     "searching": false,
        //     "ordering": true,
        //     "info": true,
        //     "autoWidth": false,
        //     "responsive": true,
        //         // "processing": true,
        //         // "pageLength": [10, 25],
        //     columns: [
        //         { "data": null,"sortable": false, 
        //             render: function (data, type, row, meta) {
        //                 return meta.row + meta.settings._iDisplayStart + 1;
        //             }  
        //         },
        //         {data: "barcode_serial", className: 'uid'},
        //         {data: "part_number", className: 'fname'},
        //         {data: "part_lot", className: 'uname'},
        //         {"defaultContent": 
        //             "<button class='btn btn-danger btn-sm button-delete'> Delete</button> <button class='btn btn-success btn-sm button-edit'> Edit</button>"
        //         }                
        //     ]  
        // });
        $('#tbl-barcode').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                    //    "url": "http://localhost:8181/ipd-system/loadbarcode.php?action=table_data",
                "url": base_url+'/barcodeserial/barcodelist?action=table_data',
                "dataType": "json",
                "type": "POST"
            },
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
                "columns": [
                    { "data": "no" },
                    { "data": "barcode_serial" },
                    { "data": "part_number" },
                    { "data": "part_lot" },
                    {"defaultContent": 
                        "<button class='btn btn-danger btn-sm button-delete'> Delete</button> <button class='btn btn-success btn-sm button-edit'> Edit</button>"
                    }   
                ]   
        });

        $('#tbl-barcode tbody').on( 'click', '.button-delete', function () {
            
            var table = $('#tbl-barcode').DataTable();
            selected_data = [];
            selected_data = table.row($(this).closest('tr')).data();
            alert(selected_data.barcode_serial);
            window.location = base_url+"/barcodeserial/delete/"+selected_data.barcode_serial;
        });

        $('#tbl-barcode tbody').on( 'click', '.button-edit', function () {
            // alert('edit')
            var table = $('#tbl-barcode').DataTable();
            selected_data = [];
            selected_data = table.row($(this).closest('tr')).data();
            window.location = base_url+"/barcodeserial/edit/"+selected_data.barcode_serial;
            // alert(selected_data.barcode_serial);
        });
    });
</script>