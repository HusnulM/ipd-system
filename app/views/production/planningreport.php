    <style>
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 1px;
            right: 1px;
            width: 20px;
            display: none;
        }
    </style>
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
                        <form>
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="reqdate1">Plan Date</label>
                                            <input type="date" name="reqdate1" id="strdate" class="datepicker form-control" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>    
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="reqdate1">-</label>
                                            <input type="date" name="reqdate1" id="enddate" class="datepicker form-control" value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>    
                                </div>    
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <label for="reqdate1">Model</label>
                                    <select name="model[]" id="find-model" class="find-model" style="width: 500px !important;"></select>
                                    
                                </div>    
                                
                            </div>
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <div class="form-group">
                                        <button type="button" id="btn-process" class="btn btn-primary"  data-type="success">Show Data</button>
                                    </div>    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <script src="<?= BASEURL; ?>/plugins/sweetalert/sweetalert.min.js"></script>
    <script>
        $(function(){

            $('.select2-selection__arrow').hide();

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
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    text: item.matdesc,
                                    slug: item.matdesc,
                                    id: item.matdesc,
                                    ...item
                                }
                            })
                        };
                    },
                }
            });

            $('#btn-process').on('click', function(){
                var model    = $('#find-model').val();
                var strdate  = $('#strdate').val();
                var enddate  = $('#enddate').val();
                if(model === "null" || model == null){
                    model = "ALL";
                }
                // alert(model);
                window.location.href = base_url+'/planningreport/planningreportview/'+strdate+'/'+enddate+'/data?model='+model;
            });
        })
    </script>