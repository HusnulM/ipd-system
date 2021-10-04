    <section class="content">
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
                            <!-- <ul class="header-dropdown m-r--5">                                
							    <a href="<?= BASEURL; ?>/menugroup/create" class="btn btn-success waves-effect pull-right">Create Menu Group</a>
							</ul> -->
                        </div>
                        <div class="body">
                            <form action="<?= BASEURL; ?>/production/save" method="POST">
                                <div class="row clearfix">
                                    <div class="col-sm-4">
                                        <div class="form-line">
                                            <label for="">PLAN DATE</label>
                                            <input type="date" name="plandate" class="form-control" value="<?= date('Y-m-d'); ?>">
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
                                    <div class="col-sm-4">
                                        <div class="form-line">
                                            <label for="shift">Shift</label>
                                            <select name="shift" id="shift" class="form-control" data-live-search="true" required>
                                                <option value="1">Day Shift</option>
                                                <option value="2">Night Shift</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <table class="table">
                                            <thead>
                                                <th>NO.</th>
                                                <!-- <th>PLAN DATE</th> -->
                                                <!-- <th>LINE</th> -->
                                                <th style="width:200px;">MODEL</th>
                                                <th style="width:300px;">LOT NUMBER</th>
                                                <!-- <th>SHIFT</th> -->
                                                <th>PLAN QTY</th>
                                                <!-- <th>OUTPUT QTY</th> -->
                                                <th></th>
                                            </thead>
                                            <tbody class="mainbody" id="tbl-plan-item">

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td colspan="3" style="text-align:right;">
                                                        <button type="button" class="btn btn-success btnAddItem">
                                                            <i class="material-icons">add</i> ADD
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="material-icons">save</i> SAVE
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <!-- <div class="row clearfix">                            
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group" style="padding:10dp;">
                                            <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Save</button>

                                            <a href="<?= BASEURL; ?>/menugroup" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Cancel</a>
                                        </div>
                                    </div>
                                </div> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <script>
        $(function(){
            var count = 0;

            $('.btnAddItem').on('click', function(){
                count = count + 1;    
                // $('#tbl-plan-item').append(`
                //     <tr>
                //         <td class="nurut"> </td>
                //         <td>
                //             <input type="date" name="plandate[]" class="form-control" >
                //         </td>
                //         <td>
                //             <select name="line[]" id="find-line`+count+`" class="find-line" style="width: 200px;"></select>
                //         </td>
                //         <td>
                //             <select name="model[]" id="find-model`+count+`" class="find-model" style="width: 200px;"></select>
                //         </td>
                //         <td>
                //             <input type="text" name="shift[]" class="form-control" > 
                //         </td>
                //         <td>
                //             <input type="text" name="inputqty[]" class="form-control" > 
                //         </td>
                //         <td>
                //             <input type="text" name="outputqty[]" class="form-control" > 
                //         </td>
                //         <td>
                //             <button type="button" class="btn btn-danger btn-sm removeItem hideComponent" counter="`+count+`">Remove</button>
                //         </td>
                //     </tr>
                // `);

                $('#tbl-plan-item').append(`
                    <tr>
                        <td class="nurut"> </td>
                        <td>
                            <select name="model[]" id="find-model`+count+`" class="find-model" style="width: 200px;"></select>
                        </td>
                        <td>
                            <input type="text" name="lotnumber[]" class="form-control" style="width: 300px;"> 
                        </td>
                        <td>
                            <input type="text" name="inputqty[]" class="form-control" > 
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm removeItem hideComponent" counter="`+count+`">Remove</button>
                        </td>
                    </tr>
                `);

                renumberRows();

                $(document).on('select2:open', (event) => {

                    const searchField = document.querySelector(
                        `.select2-search__field`,
                    );
                    if (searchField) {
                        searchField.focus();
                    }
                });

                // $('#find-line'+count).select2({ 
                //     placeholder: 'Type Model Name',
                //     width: '100%',
                //     minimumInputLength: 5,
                //     ajax: {
                //         url: base_url + '/production/searchMaterial',
                //         dataType: 'json',
                //         delay: 250,
                //         data: function(data){
                //             return{
                //                 searchName: data.term
                //             }
                //         },
                //         processResults: function (data) {
                //             return {
                //                 results: $.map(data.data, function (item) {
                //                     return {
                //                         text: item.matdesc,
                //                         slug: item.matdesc,
                //                         id: item.material,
                //                         ...item
                //                     }
                //                 })
                //             };
                //         },
                //     }
                // });

                $('#find-model'+count).select2({ 
                    placeholder: 'Type Model Name',
                    width: '100%',
                    minimumInputLength: 3,
                    ajax: {
                        url: base_url + '/production/searchMaterial',
                        dataType: 'json',
                        delay: 250,
                        data: function(data){
                            return{
                                searchName: data.term
                            }
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data.data, function (item) {
                                    return {
                                        text: item.matdesc,
                                        slug: item.matdesc,
                                        id: item.material,
                                        ...item
                                    }
                                })
                            };
                        },
                    }
                });

                $('.removeItem').on('click', function(e){
                    e.preventDefault();
                    var row_index = $(this).closest("tr").index(); 
                    $(this).closest("tr").remove();
                    renumberRows();
                });
            });

            function renumberRows() {
                $(".mainbody > tr").each(function(i, v) {
                    $(this).find(".nurut").text(i + 1);
                });
            }
        })
    </script>