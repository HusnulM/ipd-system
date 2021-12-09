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
                            <form action="<?= BASEURL; ?>/menu/update" method="POST">
                                <div class="row clearfix">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="hidden" name="idmenu" id="idmenu" value="<?= $data['menus']['id']; ?>">
                                                <input type="text" name="menu" class="form-control" placeholder="Application Menu" required="true" value="<?= $data['menus']['menu']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <input type="text" name="route" class="form-control" placeholder="Route" required="true" value="<?= $data['menus']['route']; ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <div class="form-line">
                                                <select name="group">
                                                    <option value="<?= $data['currentgroup']['menugroup']; ?>">
                                                        <?= $data['currentgroup']['description']; ?>
                                                    </option>
                                                    <?php foreach($data['menugroups'] as $menugroup) : ?>
                                                    <option value="<?= $menugroup['menugroup']; ?>">
                                                        <?= $menugroup['description']; ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row clearfix">                            
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group" style="padding:10dp;">
                                            <button type="submit" id="btn-save" class="btn btn-primary"  data-type="success">Save</button>

                                            <a href="<?= BASEURL; ?>/menu" type="button" id="btn-back" class="btn btn-danger"  data-type="success">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>