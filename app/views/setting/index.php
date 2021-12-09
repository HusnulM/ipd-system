	<section class="content">
        <div class="container-fluid">
            <div id="msg-alert">
                <?php
                    Flasher::msgInfo();
                ?>
            </div>
            <div class="row clearfix">
            <form action="<?= BASEURL; ?>/generalsetting/save" method="POST" enctype="multipart/form-data">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                <?= $data['menu']; ?>
                            </h2>

                            <ul class="header-dropdown m-r--5">  

                                <!-- <a href="<?= BASEURL; ?>/service" class="btn bg-teal waves-effect">
                                    <i class="material-icons">backspace</i> <span>BACK</span>
                                </a> -->
								<button type="submit" class="btn bg-blue waves-effect">
								<i class="material-icons">save</i> <span>SAVE</span>
								</button>
							</ul>
                        </div>
                        <div class="body">                     
                            <div class="row" style="margin-bottom:0px;">
                                <div class="col-lg-12 col-md-9 col-sm-12 col-xs-12" style="margin-bottom:0px;">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="cname">Company Name</label>
                                            <input type="text" name="cname" id="cname" class="form-control" placeholder="Company Name" value="<?= $data['setting']['company']; ?>">
											<input type="hidden" name="setid" value="<?= $data['setting']['id']; ?>">
                                        </div>
                                    </div>
                                </div>
                                
								<div class="col-lg-12 col-md-9 col-sm-12 col-xs-12" style="margin-bottom:0px;">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <label for="address">Company Address</label>
                                            <input type="text" name="address" id="address" class="form-control" placeholder="address" value="<?= $data['setting']['address']; ?>">
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