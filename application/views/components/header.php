<!DOCTYPE html>
<html>
	<head>
		<title>Elevation Fitness</title>
		<!-- Stylesheet declarations  -->
		<link rel="stylesheet" href="<?php echo base_url('assets/vendors/bootstrap-4.0.0/dist/css/bootstrap.min.css'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/vendors/vex/dist/css/vex.css'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/vendors/vex/dist/css/vex-theme-os.css'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/members.css'); ?>" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/product.css'); ?>" />
		<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
		<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
		<!-- Stylesheet declarations end -->

		<!-- JS declarations -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		<script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url("assets/vendors/bootstrap-4.0.0/dist/js/bootstrap.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("assets/vendors/jquery.steps-1.1.0/jquery.steps.min.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("assets/vendors/jquery-validation-1.17.0/dist/jquery.validate.min.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("assets/vendors/jquery-validation-1.17.0/dist/additional-methods.min.js"); ?>"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url("assets/vendors/webcamjs/webcam.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("assets/js/Base64.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("assets/vendors/vex/dist/js/vex.combined.min.js"); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url("assets/js/Global.js"); ?>"></script>

		<script>vex.defaultOptions.className = 'vex-theme-os'</script>
		<!-- JS declarations end -->
	</head>
	<body>

	<header>
		<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
	  		<h5 class="my-2 mr-md-auto font-weight-normal">
				<img class="header-icon" src="<?php echo base_url('assets/images/fitness.png'); ?>">
				<a class="d-none d-md-inline-block font-weight-bold text-danger" href="<?php echo base_url(); ?>">Elevation Fitness</a>
	  		</h5>

			<?php if ($this->session->userdata('logged_in') && $isDashboard): ?>
				<?php
			  		$title = ['Home', 'Members'];
			  		$nav = ['Home', 'Members'];
			  		$segment = $this->uri->segment(1);

			  		switch ($segment) {
						case 'dashboard':
				  			$title[0] = '<strong>' . $nav[0] . '</strong>';
				  			break;

						case 'members':
				  			$title[1] = '<strong>' . $nav[1] . '</strong>';
				  			break;

					}
				?>
				<nav class="my-2 my-md-0 mr-md-3">
					<a class="p-2 text-danger" href="<?php echo base_url('dashboard'); ?>"><?php echo $title[0]; ?></a>
					<a class="p-2 text-danger" href="<?php echo base_url(lcfirst($nav[1])); ?>"><?php echo $title[1]; ?></a>
				</nav>
	  			<a class="btn btn-outline-danger" href="<?php echo base_url('dashboard/logout'); ?>">Log out</a>
			<?php endif; ?>
		</div>
	</header>
