<div class="row text-center">
	<?php if($_SESSION['usr']['userlevel'] === '1'){ ?>
	<div class="col-md-12">
		<!-- <a href="<?= BASEURL; ?>/department">
			<div class="infobox infobox-blue">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-plus-square-o"></i>
				</div>

				<div class="infobox-data">
					<p></p>
					<div class="infobox-content"><b>Manage Department</b></div>
				</div>
			</div>
		</a> -->

		<a href="<?= BASEURL; ?>/project">
			<div class="infobox infobox-blue">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-plus-square-o"></i>
				</div>

				<div class="infobox-data">
					<p></p>
					<div class="infobox-content"><b>Manage Project</b></div>
				</div>
			</div>
		</a>
		
		<a href="<?= BASEURL; ?>/user">
			<div class="infobox infobox-blue">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-plus-square-o"></i>
				</div>

				<div class="infobox-data">
					<p></p>
					<div class="infobox-content"><b>Manage User</b></div>
				</div>
			</div>
		</a>

		<a href="<?= BASEURL; ?>/setting">
			<div class="infobox infobox-blue">
				<div class="infobox-icon">
					<i class="ace-icon fa fa-plus-square-o"></i>
				</div>

				<div class="infobox-data">
					<p></p>
					<div class="infobox-content"><b>General Setting</b></div>
				</div>
			</div>
		</a>
		<hr>
		<a href="<?= BASEURL; ?>/purchasing/operPR">
					<div class="infobox infobox-red">
						<div class="infobox-icon">
							<i class="ace-icon fa fa-info-circle"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number"><?= $data['totalpr']['Total']; ?></span>
							<div class="infobox-content">List Open PR</div>
						</div>
					</div>
				</a>

				<a href="<?= BASEURL; ?>/purchasing/historyPR">
					<div class="infobox infobox-blue">
						<div class="infobox-icon">
							<i class="ace-icon fa fa-plus-square-o"></i>
						</div>

						<div class="infobox-data">
							<p></p>
							<div class="infobox-content"><b>History PR</b></div>
						</div>
					</div>
				</a>
		<?php } else if($_SESSION['usr']['userlevel'] === '2') { ?>

			<div class="col-md-12">
				<a href="<?= BASEURL; ?>/purchasing">
					<div class="infobox infobox-blue">
						<div class="infobox-icon">
							<i class="ace-icon fa fa-plus-square-o"></i>
						</div>

						<div class="infobox-data">
							<p></p>
							<div class="infobox-content"><b>Create PR</b></div>
						</div>
					</div>
				</a>

				<a href="<?= BASEURL; ?>/purchasing/historyPR">
					<div class="infobox infobox-blue">
						<div class="infobox-icon">
							<i class="ace-icon fa fa-plus-square-o"></i>
						</div>

						<div class="infobox-data">
							<p></p>
							<div class="infobox-content"><b>History PR</b></div>
						</div>
					</div>
				</a>

				<a href="<?= BASEURL; ?>/purchasing/operPR">
					<div class="infobox infobox-red">
						<div class="infobox-icon">
							<i class="ace-icon fa fa-info-circle"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number"><?= $data['totalpr']['Total']; ?></span>
							<div class="infobox-content">Outstanding PR</div>
						</div>
					</div>
				</a>
			</div>
		<?php } else{ ?>
			<div class="col-md-12">
				<a href="<?= BASEURL; ?>/purchasing/operPR">
					<div class="infobox infobox-red">
						<div class="infobox-icon">
							<i class="ace-icon fa fa-info-circle"></i>
						</div>

						<div class="infobox-data">
							<span class="infobox-data-number"><?= $data['totalpr']['Total']; ?></span>
							<div class="infobox-content">List Open PR</div>
						</div>
					</div>
				</a>

				<a href="<?= BASEURL; ?>/purchasing/historyPR">
					<div class="infobox infobox-blue">
						<div class="infobox-icon">
							<i class="ace-icon fa fa-plus-square-o"></i>
						</div>

						<div class="infobox-data">
							<p></p>
							<div class="infobox-content"><b>History PR</b></div>
						</div>
					</div>
				</a>
		<?php } ?>
	</div>
	<hr>
</div>