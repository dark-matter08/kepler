<?php
	include("includes/config.php");
	include("includes/classes/User.php");
	//session_destroy();
	if(isset($_SESSION['userLoggedIn'])){
		$userLoggedIn = new User($con, $_SESSION['userLoggedIn']);
		$username = $userLoggedIn->getUsername();
        echo "<script>userLoggedIn = '$username';</script>";
        $disabled = ($username != "kepler123") ? "disabled" : "" ;
	} else {
		header("Location: login.php");
    }
    // ---------------------------------------------------------------
    // -----------------------RANDOW VARIABLES------------------------
    // ---------------------------------------------------------------
    $query = "SELECT value FROM randomvalues WHERE name = 'webName'";
    $nameQuery = $con->prepare($query);
    $nameQuery->execute();

    $row = $nameQuery->fetch(PDO::FETCH_ASSOC);
    $webName = $row['value'];
    // ----------------------------------------------------------------
    $query = "SELECT value FROM randomvalues WHERE name = 'currency'";
    $curQuery = $con->prepare($query);
    $curQuery->execute();

    $row = $curQuery->fetch(PDO::FETCH_ASSOC);
    $cur = $row['value'];
    // -----------------------------------------------------------------
    $query = "SELECT value FROM randomvalues WHERE name = 'logoPath'";
    $logoQuery = $con->prepare($query);
    $logoQuery->execute();

    $row = $logoQuery->fetch(PDO::FETCH_ASSOC);
    $logo = $row['value'];
    // ------------------------------------------------------------------
    $query = "SELECT value FROM randomvalues WHERE name = 'email'";
    $emailQuery = $con->prepare($query);
    $emailQuery->execute();

    $row = $emailQuery->fetch(PDO::FETCH_ASSOC);
    $email = $row['value'];
    // -----------------------------------------------------------------
    $query = "SELECT value FROM randomvalues WHERE name = 'telephone'";
    $telQuery = $con->prepare($query);
    $telQuery->execute();

    $row = $telQuery->fetch(PDO::FETCH_ASSOC);
    $tel = $row['value'];
    // ------------------------------------------------------------------
		$query = "SELECT value FROM randomvalues WHERE name = 'annret_desc'";
    $telQuery = $con->prepare($query);
    $telQuery->execute();

    $row = $telQuery->fetch(PDO::FETCH_ASSOC);
    $annualreturnDesc = $row['value'];
    // ------------------------------------------------------------------
		$query = "SELECT value FROM randomvalues WHERE name = 'nedeq_desc'";
    $telQuery = $con->prepare($query);
    $telQuery->execute();

    $row = $telQuery->fetch(PDO::FETCH_ASSOC);
    $neededequityDesc = $row['value'];
    // ------------------------------------------------------------------
		$query = "SELECT value FROM randomvalues WHERE name = 'mort_desc'";
    $telQuery = $con->prepare($query);
    $telQuery->execute();

    $row = $telQuery->fetch(PDO::FETCH_ASSOC);
    $mortgageDesc = $row['value'];
    // ------------------------------------------------------------------
		$query = "SELECT value FROM randomvalues WHERE name = 'renint_desc'";
    $telQuery = $con->prepare($query);
    $telQuery->execute();

    $row = $telQuery->fetch(PDO::FETCH_ASSOC);
    $rentincomeDesc = $row['value'];
    // ------------------------------------------------------------------

    $logoStr = '';
    if($logo == ''){
        $logoStr .= "<i class='far fa-images circledTimes fa-4x'></i>Select Logo";
    }else{
        $logoStr .= "<span class='logoSpan'><img src='$logo'  class='logoImage' class='mb-2'></span>";
    }

 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard | Kepler</title>
        <link href="<?php echo $logo; ?>" rel="icon">
        <link href="css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link href="summernote-master/dist/summernote-bs4.min.css" rel="stylesheet">
				<script src="assets/jquery/jquery.min.js"></script>
        <!-- <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

    </head>
    <body class="sb-nav-fixed">

        <div id='loader' class="loader"></div>

        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand text-uppercase" href="index.php">
                <?php echo "$webName"?>
            </a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto ml-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="user_settings.php">Settings</a>
                        <!-- <a class="dropdown-item" href="#">Activity Log</a> -->
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" <?php echo $disabled;?> href="homepage.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-th-large"></i></div>
                                Home Page
                            </a>
                            <a class="nav-link" href="property.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-home"></i></div>
                                Properties
                            </a>
                            <a class="nav-link" <?php echo $disabled;?> href="aboutpage.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-info-circle"></i></div>
                                About Page
                            </a>
                            <a class="nav-link" <?php echo $disabled;?> href="policypage.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-info-circle"></i></div>
                                Policy Page
                            </a>
                            <a class="nav-link" href="agents.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Agents Page
                            </a>
                            <a class="nav-link" href="blog.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-blog"></i></div>
                                Blog Page
                            </a>
                            <!-- <a class="nav-link" href="similarpurchases.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-shopping-cart"></i></div>
                                Similar Purchases
                            </a> -->
                            <!-- <div class="sb-sidenav-menu-heading">Main Website</div> -->

                            <div class="sb-sidenav-menu-heading">General Settings</div>
                            <a class="nav-link" <?php echo $disabled;?> href="siteSettings.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                                Site Settings
                            </a>
                            <a class="nav-link" <?php echo $disabled;?> href="socialLinks.php">
                                <div class="sb-nav-link-icon"><i class="fa fa-hashtag"></i></div>
                                Social Links
                            </a>
                            <div class="sb-sidenav-menu-heading">User Settings</div>
                            <a class="nav-link" <?php echo $disabled;?> href="user_settings.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                                User Settings
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:
                            <?php echo "$username"?>
                            </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
