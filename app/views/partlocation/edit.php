<section class="content">
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <form action="<?= BASEURL; ?>/partlocation/update" method="POST">
                <div class="card">
                    <div class="header">
                        <h2>
                            <?= $data['menu']; ?>
                        </h2>
                        <ul class="header-dropdown m-r--5">
                            <button type="submit" id="btn-save" class="btn bg-blue"  data-type="success">
                                <i class="material-icons">save</i> <span>SAVE</span>
                            </button>

                            <a href="<?= BASEURL; ?>/partlocation" type="button" id="btn-back" class="btn bg-red"  data-type="success">
                                <i class="material-icons">highlight_off</i> <span>CANCEL</span>
                            </a>
                        </ul>
                    </div>
                    <div class="body">
                        <!-- <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#basic_data_view" data-toggle="tab">
                                    <i class="material-icons">description</i> Basic Data
                                </a>
                            </li>
                        </ul> -->

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="basic_data_view">
                                <!-- <div class="row clearfix">
                                    <div class="col-sm-6" style="display:none;">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="">Description / Model</label>
                                                <select name="model" id="find-model" class="find-model"></select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="">Assy Code</label>
                                                <input type="text" name="assy_code" id="assy_code" class="form-control" placeholder="Assy Code" required="true" autocomplete="off" readonly value="<?= $data['location']['assy_code']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="">Part Number</label>
                                                <input type="text" name="part_number" id="part_number" class="form-control" placeholder="Part Number" autocomplete="off" required="true" value="<?= $data['location']['part_number']; ?>">
                                                <input type="hidden" name="uniq_id" value="<?= $data['location']['uniq_id']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <label for="">Location</label>
                                                <input type="text" name="assy_location" id="assy_location" class="form-control" placeholder="Location" required="true" autocomplete="off" value="<?= $data['location']['assy_location']; ?>">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
    

    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        var alt_uom = [];
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                event.preventDefault();
                return false;
                }
            });

            $(document).on('select2:open', (event) => {
    
                const searchField = document.querySelector(
                    `.select2-search__field`,
                );
                if (searchField) {
                    searchField.focus();
                }
            });
    
            $('#find-model').select2({ 
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
                        // console.log(data);
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

            $('#find-model').on('select2:select', async function (e) {
                const _data = e.params.data
                // alert(_data.material);    
                $('#assy_code').val(_data.material);
                document.getElementById("part_number").focus();
            });
        });    

    </script>