<div class="row">
	<div class="col-xs-12 col-sm-12">
		<?php
			Flasher::msgInfo();
		?>
		<div class="widget">
			<form action="<?= BASEURL; ?>/user/updatedepartment" method="POST" enctype="multipart/form-data">
				<div class="col-md-6">
					<input type="hidden" name="id" id="id">
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" name="username" class="form-control" value="<?= $data['userid'];?>" readonly="true">
					</div>
					<div class="form-group">
						<label for="nama">Department</label>
						<select name="deptid" id="" class="form-control">
                            <?php foreach($data['deptlist'] as $dept) : ?>
                                <option value="<?= $dept['deptid'] ?>"><?= $dept['deptName'] ?></option>
                            <?php endforeach ?>
                        </select>
					</div>
                    <div class="form-group">
						<button type="submit" class="btn btn-primary">Save</button>
						<a href="<?= BASEURL; ?>/user" class="btn btn-primary">Back</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>