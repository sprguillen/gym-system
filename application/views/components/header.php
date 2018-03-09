<!DOCTYPE html>
<html>
<head>
    <title>Elevation Fitness</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/open-iconic-bootstrap.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/product.css'); ?>" />
</head>
<body>

<header>
    <nav class="site-header sticky-top py-2">
    <div class="container d-flex flex-column flex-md-row justify-content-between">
      <a class="py-3 d-none d-md-inline-block font-weight-bold" href="<?php echo base_url(); ?>">
        <img class="header-icon" src="<?php echo base_url('assets/images/fitness.png'); ?>">
        Elevation Fitness
      </a>

      
      <?php if ($isDashboard): ?>
        <a class="py-3 d-none pr-4 d-md-inline-block" href="#"><strong>Home</strong></a>
        <a class="py-3 d-none pr-4 d-md-inline-block" href="#">Members</a>
        <a class="py-3 d-none pr-4 d-md-inline-block" href="#">Programs</a>
        <a class="py-3 d-none pr-4 d-md-inline-block" href="#">Coaches</a>

        <a class="btn btn-outline-dark py-3" href="#">Logout</a>
      <?php endif; ?>

      <?php if (!$isDashboard): ?>
        <a class="py-3 d-none pr-4 d-md-inline-block" href="#">About</a>
        <a class="py-3 d-none pr-4 d-md-inline-block" href="#">Pricing</a>
        <a class="py-3 d-none pr-4 d-md-inline-block" href="#">Facilities</a>
        <a class="py-3 d-none pr-4 d-md-inline-block" href="#">Contact</a>
      <?php endif; ?>
    </div>
  </nav>
</header>