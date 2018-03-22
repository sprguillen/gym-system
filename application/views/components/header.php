<!DOCTYPE html>
<html>
<head>
    <title>Elevation Fitness</title>
    <!-- Stylesheet declarations  -->
    <link rel="stylesheet" href="<?php echo base_url('assets/vendors/bootstrap-4.0.0/dist/css/bootstrap.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/product.css'); ?>" />
    <link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
    <!-- Stylesheet declarations end -->

    <!-- JS declarations -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/vendors/bootstrap-4.0.0/dist/js/bootstrap.js"); ?>"></script>
    <!-- JS declarations end -->
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
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('dashboard'); ?>"><?php echo $nav[0]; ?></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="dropdownMembersButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $nav[1]; ?>
                    </a>
                    <div class="pull-right dropdown-menu" aria-labelledby="dropdownMembersButton">
                        <a class="dropdown-item" href="<?php echo base_url('members/list'); ?>">Members List</a>
                        <a class="dropdown-item" href="<?php echo base_url('members/register'); ?>">Member Registration</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><?php echo $nav[2]; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url('dashboard/logout'); ?>">Logout</a>
                </li>
            </ul>
        </nav>


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
