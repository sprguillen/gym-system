<!DOCTYPE html>
<html>
<head>
    <title>Elevation Fitness</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/product.css'); ?>" />
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
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
        <?php
          $nav = ['Home', 'Members', 'Programs', 'Coaches'];
          $segment = $this->uri->segment(1);

          switch ($segment) {
            case 'dashboard':
              $nav[0] = '<strong>' . $nav[0] . '</strong>'; 
              break;

            case 'members':
              $nav[1] = '<strong>' . $nav[1] . '</strong>'; 
              break;

            case 'programs':
              $nav[2] = '<strong>' . $nav[2] . '</strong>'; 
              break;

            case 'coaches':
              $nav[3] = '<strong>' . $nav[3] . '</strong>'; 
              break;
          }
        ?>

        <a class="py-3 d-none pr-4 d-md-inline-block" href="<?php echo base_url('dashboard/home'); ?>"><?php echo $nav[0]; ?></a>
        <a class="py-3 d-none pr-4 d-md-inline-block" href="<?php echo base_url('dashboard/members'); ?>"><?php echo $nav[1]; ?></a>
        <a class="py-3 d-none pr-4 d-md-inline-block" href="#"><?php echo $nav[2]; ?></a>
        <a class="py-3 d-none pr-4 d-md-inline-block" href="#"><?php echo $nav[3]; ?></a>

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