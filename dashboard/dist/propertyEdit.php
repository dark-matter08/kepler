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

    $logoStr = '';
    if($logo == ''){
        $logoStr .= "<i class='far fa-images circledTimes fa-4x'></i>Select Logo";
    }else{
        $logoStr .= "<span class='logoSpan'><img src='$logo'  class='logoImage' class='mb-2'></span>";
    }

    if(isset($_GET['id'])){
        $propId = urldecode($_GET['id']);
        $type = urldecode($_GET['type']);
        $date = date("Y:m:d");
        echo "<script>propId = '$propId';</script>";
        echo "<script>date = '$date';</script>";

        // check instance of product edit, new and edit old
        $type = urldecode($_GET['type']);
        if ($type == 'edit') {

            $query = $con->prepare("SELECT * FROM property WHERE id = $propId");
            $query->execute();


            while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                $id = $row['id'];
                $propName = $row['propName'];
                echo "<script>propName = '$propName';</script>";
                $propDesc = $row['propDescription'];
                $propLoc = $row['propLocation'];
                $propPrice = $row['propPrice'];
                $annReturns = $row['annualReturns'];
								$annReturns = round($annReturns, 2);
                $imagePath = $row['imagePath'];
                $status = $row['status'];
                $date = $row['dateAdded'];
                $rentIncome = $row['rent_income'];
								$oldPrice = $row['old_price'];
								$rent_status = $row['rent_status'];
								$year_built = $row['year_built'];
                $prop_condition = $row['propCondition'];

								$check_rent_status = ($rent_status == "yes") ? "checked" : "";
								$check_prop_condition_bad = ($prop_condition == "red") ? "checked" : "";
								$check_prop_condition_partial = ($prop_condition == "yellow") ? "checked" : "";
								$check_prop_condition_good = ($prop_condition == "green") ? "checked" : "";
            }

            $query2 = $con->prepare("SELECT * FROM descfeatures WHERE propertyId = $propId");
            $query2->execute();


            while ($row2 = $query2->fetch(PDO::FETCH_ASSOC)){
                $descFeatureId = $row2['id'];
                $area = $row2['area'];
                $bedrooms = $row2['bedrooms'];
                $number_of_building_floors = $row2['number_of_building_floors'];
                $floor_in_building = $row2['floor_in_building'];
            }

            $query3 = $con->prepare("SELECT * FROM propertycity WHERE propertyId = $propId");
            $query3->execute();


            while ($row3 = $query3->fetch(PDO::FETCH_ASSOC)){
                $cityId = $row3['id'];
                $city = $row3['cityName'];
								$strt = $row3['street'];
								$neighbourhood = $row3['neighbourhood'];
                $country = $row3['countryName'];
                $lat = $row3['lat'];
                $lng = $row3['lng'];
            }

            $query4 = $con->prepare("SELECT * FROM propertyextraexpenses WHERE propertyId = $propId");
            $query4->execute();

            $row4 = $query4->fetch(PDO::FETCH_ASSOC);
            $lawyer = $row4['lawyer'];
            $renovation = $row4['renovation'];
            $brokerage = $row4['brokerage_fee'];
            $tax = $row4['tax'];
            $appraiser = $row4['appraiser'];

						$query5 = $con->prepare("SELECT * FROM propertyamenities WHERE propertyId = $propId");
            $query5->execute();

            $row5 = $query5->fetch(PDO::FETCH_ASSOC);
            $balcony = $row5['balcony'];
            $parking = $row5['parking'];
            $elevator = $row5['elevator'];
            $storeroom = $row5['storeroom'];
						$secroom = $row5['secroom'];
            $ac = $row5['ac'];

						$selected_balcony_yes = ($balcony == "yes") ? "selected='selected'" : "";
						$selected_balcony_no = ($balcony == "no") ? "selected='selected'" : "";

						$selected_parking_yes = ($parking == "yes") ? "selected='selected'" : "";
						$selected_parking_no = ($parking == "no") ? "selected='selected'" : "";

						$selected_elevator_yes = ($elevator == "yes") ? "selected='selected'" : "";
						$selected_elevator_no = ($elevator == "no") ? "selected='selected'" : "";

						$selected_storeroom_yes = ($storeroom == "yes") ? "selected='selected'" : "";
						$selected_storeroom_no = ($storeroom == "no") ? "selected='selected'" : "";

						$selected_secroom_yes = ($secroom == "yes") ? "selected='selected'" : "";
						$selected_secroom_no = ($secroom == "no") ? "selected='selected'" : "";

						$selected_ac_yes = ($ac == "yes") ? "selected='selected'" : "";
						$selected_ac_no = ($ac == "no") ? "selected='selected'" : "";

						$query6 = "SELECT * FROM propertyseller WHERE propertyId = :propId";
						$userQuery = $con->prepare($query6);
						$userQuery->bindParam(":propId", $propId);
						$userQuery->execute();

						$row = $userQuery->fetch(PDO::FETCH_ASSOC);
						$f_name = $row['first_name'];
						$l_name = $row['last_name'];
						$user_email = $row['email'];
						$user_tel = $row['telephone'];

        } elseif ($type == 'new') {
						$query = "SELECT * FROM users WHERE username = :username";
						$userQuery = $con->prepare($query);
						$userQuery->bindParam(":username", $username);
						$userQuery->execute();

						$row = $userQuery->fetch(PDO::FETCH_ASSOC);
						$f_name = $row['firstName'];
						$l_name = $row['lastName'];
						$user_email = $row['email'];
						$user_tel = $row['user_tel'];

            $query = $con->prepare("SELECT * FROM property WHERE id = $propId");
            $query->execute();

            while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                $id = $row['id'];
                $propName = $row['propName'];
                echo "<script>propName = '$propName';</script>";
								$propDesc = $row['propDescription'];
								$propLoc = $row['propLocation'];
								$propPrice = $row['propPrice'];
								$annReturns = $row['annualReturns'];
								$annReturns = round($annReturns, 2);
								$imagePath = $row['imagePath'];
								$status = $row['status'];
								$date = $row['dateAdded'];
								$rentIncome = $row['rent_income'];
								$oldPrice = $row['old_price'];
								$rent_status = $row['rent_status'];
								$year_built = $row['year_built'];
								$prop_condition = $row['propCondition'];

								$check_rent_status = ($rent_status == "yes") ? "checked" : "";
								$check_prop_condition_bad = ($prop_condition == "red") ? "checked" : "";
								$check_prop_condition_partial = ($prop_condition == "yellow") ? "checked" : "";
								$check_prop_condition_good = ($prop_condition == "green") ? "checked" : "";

								$query2 = $con->prepare("SELECT * FROM descfeatures WHERE propertyId = $propId");
								$query2->execute();


								while ($row2 = $query2->fetch(PDO::FETCH_ASSOC)){
									$descFeatureId = $row2['id'];
									$area = $row2['area'];
									$bedrooms = $row2['bedrooms'];
									$number_of_building_floors = $row2['number_of_building_floors'];
									$floor_in_building = $row2['floor_in_building'];
								}

								$query3 = $con->prepare("SELECT * FROM propertycity WHERE propertyId = $propId");
								$query3->execute();


								while ($row3 = $query3->fetch(PDO::FETCH_ASSOC)){
									$cityId = $row3['id'];
									$city = $row3['cityName'];
									$strt = $row3['street'];
									$neighbourhood = $row3['neighbourhood'];
									$country = $row3['countryName'];
									$lat = $row3['lng'];
									$lng = $row3['lat'];
								}

								$query4 = $con->prepare("SELECT * FROM propertyextraexpenses WHERE propertyId = $propId");
								$query4->execute();

								$row4 = $query4->fetch(PDO::FETCH_ASSOC);
								$lawyer = $row4['lawyer'];
								$renovation = $row4['renovation'];
								$brokerage = $row4['brokerage_fee'];
								$tax = $row4['tax'];
								$appraiser = $row4['appraiser'];

								$query5 = $con->prepare("SELECT * FROM propertyamenities WHERE propertyId = $propId");
								$query5->execute();

								$row5 = $query5->fetch(PDO::FETCH_ASSOC);
								$balcony = $row5['balcony'];
								$parking = $row5['parking'];
								$elevator = $row5['elevator'];
								$storeroom = $row5['storeroom'];
								$secroom = $row5['secroom'];
								$ac = $row5['ac'];

								$selected_balcony_yes = ($balcony == "yes") ? "selected='selected'" : "";
								$selected_balcony_no = ($balcony == "no") ? "selected='selected'" : "";

								$selected_parking_yes = ($parking == "yes") ? "selected='selected'" : "";
								$selected_parking_no = ($parking == "no") ? "selected='selected'" : "";

								$selected_elevator_yes = ($elevator == "yes") ? "selected='selected'" : "";
								$selected_elevator_no = ($elevator == "no") ? "selected='selected'" : "";

								$selected_storeroom_yes = ($storeroom == "yes") ? "selected='selected'" : "";
								$selected_storeroom_no = ($storeroom == "no") ? "selected='selected'" : "";

								$selected_secroom_yes = ($secroom == "yes") ? "selected='selected'" : "";
								$selected_secroom_no = ($secroom == "no") ? "selected='selected'" : "";

								$selected_ac_yes = ($ac == "yes") ? "selected='selected'" : "";
								$selected_ac_no = ($ac == "no") ? "selected='selected'" : "";

            }

        }else {
          header('Location: property.php');
        }
    } else{
    header('Location: property.php');
    }

		$query = "SELECT * FROM users WHERE username = :username";
    $userQuery = $con->prepare($query);
    $userQuery->bindParam(":username", $username);
    $userQuery->execute();

    $row = $userQuery->fetch(PDO::FETCH_ASSOC);
    $f_name = $row['firstName'];
    $l_name = $row['lastName'];
    $user_email = $row['email'];
    $user_tel = $row['user_tel'];

 ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Dashboard | Kepler</title>
  <link href="<?php echo $logo; ?>" rel="icon">
	<link href="assets/cards/dist/stackedCards.css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link href="assets/cards/demo/css/highlight.css" rel="stylesheet">
	<link href="assets/bootstrap-switch/css/bootstrap3/bootstrap-switch.css" rel="stylesheet">

	<script src="https://cdn.jsdelivr.net/highlight.js/9.9.0/highlight.min.js"></script>
	<script>hljs.initHighlightingOnLoad();</script>
  <link href="summernote-master/dist/summernote-bs4.min.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet" />
  <!-- <link href="assets/card-slider/demo.css" rel="stylesheet"> -->
	<script src="assets/jquery/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

  <!-- <script src="assets/all-js/all.min.js" crossorigin="anonymous"></script> -->
</head>
<script type="text/javascript">
    $(document).ready(function(){
        newPageTitle = 'Dashboard | ' + propName;
        document.title = newPageTitle;
        $('#propDesc').summernote({
                placeholder: 'Property Description',
                tabsize: 2,
                height: 350
            });
    });

</script>
<style>
	*, *:before, *:after {
		box-sizing: border-box;
	}

	html {
		height: 100%;
	}
	.title-box-d {
    padding-bottom: 1.8rem;
    margin-bottom: 0rem;
    position: relative;
}
	.title-box-d .title-d:after {
    content: '';
    position: absolute;
    width: 70px;
    height: 4px;
    background-color: #2eca6a;
    bottom: 20px;
    left: 0;
}
	body {
		font-family: "Roboto", sans-serif;
		width:  100%;
		height: 100%;
		min-height: 100%;
		min-width: 550px;
		margin: 0px;
		padding: 0px;
	  background-color:#cccccc !important;
	}

	.stacked-cards h2 {
		text-align: center;
		position: relative;
		top: -20px;
	}

	.intro {
		max-width: 600px;
		margin: 20px auto;
		text-align: center;
	}

	.container-fuild {
		max-width: 80%;
		margin: 0 auto;
	}

	.container-fixed {
		max-width: 767px;
		margin: 0 auto;
	}

	.divider {
		max-width: 500px;
		margin: 25px auto;
		background-color: #ccc;
		height: 2px;
		width: 100%;
	}

	.stacked-cards {
		padding-top: 10px;
		padding-bottom: 15px;
	}

	.stacked-cards-fanOut {
		padding-bottom: 40px;
	}

	.stacked-cards-fanOut li img {
		max-height: 200px;
	}

	.stacked-cards li {
		height: 600px;
		width: 450px;
		padding-left: 10px;
		padding-right: 10px;
		padding-top: 7px;
		background-color: #98f98d;
	}
	.stacked-cards li.active{
		background-color: #eee;
		color: #26a356;
	}

	@media (max-width: 767px) {
		.stacked-cards li {
			height: 600px;
		}
	}

	input, textarea, select{
		/* border: 2px solid #26a356 !important; */
		border: 2px solid #98f98d !important;
	}


	.source {
		margin: 25px auto;
	}

	.header {
		margin: 0px auto;
		padding: 25px 5px;
		background-color: #fff;
	}
	.header img {
		display: block;
		margin: 0 auto;
		max-width: 300px;
		height: auto;
	}
	.dot {
    height: 25px;
    width: 25px;
    border-radius: 50%;
		display: inline-block;
		margin-right: 10px;
  }
	.dot-status{
		height: 25px;
		top: 0;
		display: inline-block;
		font-weight: 400;
		font-size: 22px;
	}
	.dot-1{
    background-color: #EB0F0F;
  }
  .dot-2{
    background-color: #F8D308;
  }
  .dot-3{
    background-color: #13DA06;
  }

    .column.town-plan .card-body{
    	max-height: 100px;
    	overflow-y: scroll;
    }
    .column.prop-photos .card-body{
    	max-height: 100px;
    	overflow-y: scroll;
    }
::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: red;
}

:-ms-input-placeholder { /* Internet Explorer 10-11 */
  color: #26a356;
}

::-ms-input-placeholder { /* Microsoft Edge */
  color: #26a356;
}

</style>
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
	<main>
		<div class="container-fluid">
			<!-- <h1 class="mt-4">Property</h1> -->
			<!-- <ol class="breadcrumb mb-2 mt-2">
				<li class="breadcrumb-item active">Editing Property | <?php echo "$propName"?> | <span class="mx-5 text-right font-weight-bold">Annual Returns: <?php echo $annReturns;?>%</span></li>
			</ol> -->
			<div class="title-box-d mt-3">
				<h1 class="title-d">Publish Ad</h1>
			</div>
			<div class="alert alert-danger alert-dismissible fade hidden" id="dangerAlert"role="alert">
				<strong>Error!!!</strong><span id="errorMessage">   </span>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="alert alert-success alert-dismissible fade hidden" id="successAlert" role="alert">
				<strong id="status">Success!!!</strong><span id="successMessage">   </span>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="container-fixed stacked-cards stacked-cards-slide">
			  <ul>
					<li>
						<div class="row mt-4">
							<div class="col-md-10 col-11 mx-auto">
								<h4 class="text-center mb-2">Location Setting</h4>
					      <div class="form-group my-3">
									<label for="city"> </label><br>
				          <input class="input form-control text-center" type="text" id="city" value="<?php echo $city; ?>" placeholder="City">
								</div>
								<div class="form-group">
									<label for="street"> </label><br>
				          <input class="input form-control text-center" type="text" id="street" value="<?php echo $strt; ?>" placeholder="Street">
								</div>
								<div class="form-group">
									<label for="neighb"> </label><br>
				          <input class="input form-control text-center" type="text" id="neighb" value="<?php echo $neighbourhood; ?>" placeholder="Neighbourhood">
								</div>
								<div class="form-group">
									<label for="price"> </label><br>
				          <input class="input form-control text-center" type="text" id="price" value="<?php echo $propPrice; ?>" placeholder="Price">
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="row mt-4">
							<div class="col-md-10 col-11 mx-auto">
								<h4 class="text-center mb-2">Features</h4>
					      <div class="form-group">
									<label for="rooms">Rooms</label><br>
				          <input class="input form-control" type="number" id="rooms" value="<?php echo $bedrooms; ?>">
								</div>
								<div class="form-group">
									<label for="area">Area in m<sup>2</sup> </label><br>
				          <input class="input form-control" type="number" id="area" value="<?php echo $area; ?>">
								</div>
								<div class="form-group">
									<label for="floor">Number of Floors</label><br>
				          <input class="input form-control" type="number" id="floor" value="<?php echo $number_of_building_floors; ?>">
								</div>
								<div class="form-group">
									<label for="floor_in_build">Floor in Building</label><br>
				          <input class="input form-control" type="number" id="floor_in_build" value="<?php echo $floor_in_building; ?>">
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="row mt-3">
							<div class="col-md-10 col-11 mx-auto">
								<h4 class="text-center mb-2">Amenities</h4>
					      <div class="form-group">
									<label for="balcony">Balcony</label><br>
									<select class="form-control" id="balcony">
										<option value="">Select Option</option>
										<option <?php echo $selected_balcony_yes; ?> value="yes">Yes</option>
										<option <?php echo $selected_balcony_no; ?> value="no">No</option>
									</select>
								</div>
								<div class="form-group">
									<label for="parking">Parking</label><br>
									<select class="form-control" id="parking">
										<option value="">Select Option</option>
										<option <?php echo $selected_parking_yes; ?> value="yes">Yes</option>
										<option <?php echo $selected_parking_no; ?> value="no">No</option>
									</select>
								</div>
								<div class="form-group">
									<label for="elevator">Elevator</label><br>
									<select class="form-control" id="elevator">
										<option value="">Select Option</option>
										<option <?php echo $selected_elevator_yes; ?> value="yes">Yes</option>
										<option <?php echo $selected_elevator_no; ?> value="no">No</option>
									</select>
								</div>
								<div class="form-group">
									<label for="storeroom">Storeroom</label><br>
									<select class="form-control" id="storeroom">
										<option value="">Select Option</option>
										<option <?php echo $selected_storeroom_yes; ?> value="yes">Yes</option>
										<option <?php echo $selected_storeroom_no; ?> value="no">No</option>
									</select>
								</div>
								<div class="form-group">
									<label for="air_condition">Air Conditioning</label><br>
									<select class="form-control" id="air_condition">
										<option value="">Select Option</option>
										<option <?php echo $selected_ac_yes; ?> value="yes">Yes</option>
										<option <?php echo $selected_ac_no; ?> value="no">No</option>
									</select>
								</div>
								<div class="form-group">
									<label for="security_room">Security Room</label><br>
									<select class="form-control" id="security_room">
										<option value="">Select Option</option>
										<option <?php echo $selected_secroom_yes; ?> value="yes">Yes</option>
										<option <?php echo $selected_secroom_no; ?> value="no">No</option>
									</select>
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="row mt-3">
							<div class="col-md-10 col-11 mx-auto">
								<div class="column prop-photos">
					          <div class="card imgCard card-common">
					          <div class="card-header" id="productImageCardHeader">
					              <h4 class="text-center mb-2">Property Photos</h4>
					          </div>
					          <div class="card-body" id="productImageCard">
					              <?php
					                  $str = "";
					                  $str .= " <ul id='propertyImageList' class=''>";
					                  $propPhotoSql = "SELECT * FROM propertyphoto WHERE propId = $propId ORDER BY id ASC";
					                  $propPhotoQuery = $con->prepare($propPhotoSql);
					                  $propPhotoQuery->execute();

					                  while ($row = $propPhotoQuery->fetch(PDO::FETCH_ASSOC)){
					                  $photoId = $row['id'];
					                  $imgPath = $row['imgPath'];
					                  $selected = ($row["selected"] == 1) ? "selected" : "";

					                  $delete_button = "<span class='delete_photo'><i class='fa fa-times-circle text-danger' data-toggle='modal' data-target='#propPhoto$photoId'></i></span>";

					                  $str .= "<span class='ImageListItem $selected' onclick='setSelectedPhoto($photoId, $propId, this)'><img src='$imgPath' alt='$photoId' class='propImage' class='mb-2'></span>$delete_button";

					              ?>
					                  <!-- delete modal -->
					                  <div class="modal fade" id="propPhoto<?php echo $photoId;?>" role="dialog">
					                          <div class="modal-dialog">
					                              <div class="modal-content">
					                                  <div class="modal-header">
					                                      Are you sure you want to delete this photo?
					                                      <button type="button" class="close" data-dismiss="modal">
					                                          &times;
					                                      </button>
					                                  </div>

					                                  <div class="modal-footer">
					                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">
					                                          Cancel
					                                      </button>
					                                          <a href="includes/handlers/delete.php?photoId=<?php echo $photoId;?>&propId=<?php echo $propId ?>&for=photo" class="btn btn-danger text-light"> OK</a>

					                                  </div>
					                              </div>
					                          </div>
					                      </div>
					                  <!-- end of delete modal -->

					              <?php
					                  }
														$str .= "</ul>";
					              ?>


												<?php echo $str ; ?>
					          </div>
					          <div class="card-footer text-dark">
					              <a class="btn btn-info btn-block" data-toggle="modal" data-target="#photoModal">Add Photo</a>
					          </div>
					              <div class="modal fade" id="photoModal" role="dialog">
					                  <div class="modal-dialog modal-dialog-centered">
					                      <div class="modal-content">
					                          <div class="modal-header">
					                              <h4 class="modal-title">Select Photos to upload</h4>
					                              <button type="button" class="close" data-dismiss="modal">
					                                  &times;
					                              </button>
					                          </div>
					                          <div class="modal-body text-center">
					                              <form method="POST" id="photoForm">
					                                  <input type="text" id="propId" name="propId" value="<?php echo $propId ?>" hidden>
					                                  <label class="">
					                                      <i class="far fa-images circledTimes fa-4x"></i>
					                                      <input type="file" size="60" name="photoInput" class="photoInput" id="photoInput" multiple="multiple"/>
					                                  </label>
					                                  <p id="photoValue"></p>
					                                  <button type="submit" name="uploadPhoto" class="btn btn-primary" id="uploadPhoto">Upload</button>
					                              </form>
					                          </div>
					                          <div class="modal-footer">
					                          </div>
					                      </div>
					                  </div>
					              </div>
					          </div>
					      </div>
								<div class="column town-plan">
					          <div class="card imgCard card-common">
					          <div class="card-header" id="productImageCardHeader">
					              <h4 class="text-center mb-2">Town Plan</h4>
					          </div>
					          <div class="card-body" id="productImageCard">
					              <!-- display plans here -->
					              <?php
					                  $manualSql = "SELECT * FROM propertytownplan WHERE propId = $propId ORDER BY id ASC";
					                  $manualQuery = $con->prepare($manualSql);
					                  $manualQuery->execute();
					                  $str = "";

					                  while ($row = $manualQuery->fetch(PDO::FETCH_ASSOC)){
					                      $manId = $row['id'];
					                      $fileName = $row['fileName'];
					                      $fileSize = $row['size'];

					                      $delete_button = "<a class='mt-1 btn' data-toggle='modal' data-target='#manual$manId'><i class='fa fa-times-circle text-danger'></i></a>";
					                      $str .= "<ol class='breadcrumb mb-4'>
					                      <span class='breadcrumb-item active'>$delete_button &nbsp&nbsp|&nbsp&nbsp$fileName</span>
					                  </ol>";

					                  ?>
					                  <!-- delete modal -->
					                  <div class="modal fade" id="manual<?php echo $manId;?>" role="dialog">
					                          <div class="modal-dialog">
					                              <div class="modal-content">
					                                  <div class="modal-header">
					                                      Are you sure you want to delete this Document?
					                                      <button type="button" class="close" data-dismiss="modal">
					                                          &times;
					                                      </button>
					                                  </div>

					                                  <div class="modal-footer">
					                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">
					                                          Cancel
					                                      </button>
					                                          <a href="includes/handlers/delete.php?townplanId=<?php echo $manId;?>&propId=<?php echo $propId ?>&for=townplan" class="btn btn-danger text-light"> OK</a>

					                                  </div>
					                              </div>
					                          </div>
					                      </div>
					                  <!-- end of delete modal -->

					              <?php
					                  }
					                  echo $str;
					              ?>
					          </div>
					          <div class="card-footer text-dark">
					          <a class="btn btn-block btn-secondary text-light" data-toggle="modal" data-target="#manualModal">
					                        <i class="fa fa-upload"></i>
					                        Upload Plan
					                      </a>
					          </div>
					              <div class="modal fade" id="manualModal" role="dialog">
					                  <div class="modal-dialog modal-dialog-centered">
					                      <div class="modal-content">
					                          <div class="modal-header">
					                              <h4 class="modal-title">Select Town Plan to upload</h4>
					                              <button type="button" class="close" data-dismiss="modal">
					                                  &times;
					                              </button>
					                          </div>
					                          <div class="modal-body text-center">
					                                  <form method="POST" id="manualForm">
					                              <input type="text" id="manualprodId" name="manualprodId" value="<?php echo $propId ?>" hidden>
					                              <label class="">
					                                  <i class="fa fa-file circledTimes fa-4x"></i>
					                                  <input type="file" size="60" name="manualInput" class="manualInput" id="manualInput" multiple="multiple"/>
					                              </label>
					                              <p id="manualValue"></p>
					                              <button type="submit" name="uploadManual" class="btn btn-primary" id="uploadManual">Upload</button>
					                              </form>
					                          </div>
					                          <div class="modal-footer">
					                          </div>
					                      </div>
					                  </div>
					              </div>
					          </div>
					      </div>
							</div>
						</div>
					</li>
					<li>
						<div class="my-4 mx-2">
							<div class="row">
								<div class="col-md-10 col-11 mx-auto my-3">
									<div class="row my-3" style="border: 2px solid #98f98d; border-radius: 5px; padding-top: 10px; padding-bottom: 10px; background-color: #fff;">
										<div class="col-8">Appartment Rented?</div>
										<div class="col-4text-right">
											<input type="checkbox" <?php echo $check_rent_status; ?> name="rent_status" id="rent_status" data-bootstrap-switch data-off-color="danger" data-on-color="success" value="yes">
										</div>
									</div>
									<div class="form-group">
										<label for="rent_income">Rent Income</label><br>
										<input class="input form-control" type="number" id="rent_income" value="<?php echo $rentIncome; ?>">
									</div>
									<div class="form-group">
											<label for="propPrice">Price 5 years Ago</label><br>
											<input class="input form-control" type="number" id="oldPrice" value="<?php echo $oldPrice; ?>">
									</div>
									<div class="form-group">
										<label for="built_year">Built Year</label><br>
										<input class="input form-control" type="number" id="built_year" value="<?php echo $year_built; ?>">
									</div>
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="row mt-3">
							<div class="col-md-10 col-11 mx-auto">
								<h4 class="text-center mb-2">Renovation Status</h4>
								<div class="row">
									<div class="col-12 mt-3" style="border: 2px solid #98f98d; border-radius: 5px; padding-top: 10px; padding-bottom: 10px; background-color: #fff;">
										<div class="form-group px-4">
											<input class='form-check-input' <?php echo $check_prop_condition_good; ?> type='radio' value='green' name='renovation_status' id='fr'>
											<label class='form-check-label text-capitalize' for='fr'>
												<span class='dot dot-3'></span><span class="dot-status">Fully Renovated</span>
											</label>
										</div>
									</div>
									<div class="col-12 mt-3" style="border: 2px solid #98f98d; border-radius: 5px; padding-top: 10px; padding-bottom: 10px; background-color: #fff;">
										<div class="form-group px-4">
											<input class='form-check-input' type='radio' value='yellow' name='renovation_status' id='pr'>
			 								<label class='form-check-label text-capitalize' for='pr'>
			 									 <span class='dot dot-2'></span><span class="dot-status">Partially Renovated</span>
			 							 </label>
										</div>
									</div>
									<div class="col-12 mt-3" style="border: 2px solid #98f98d; border-radius: 5px; padding-top: 10px; padding-bottom: 10px; background-color: #fff;">
										<div class="form-group px-4">
											<input class='form-check-input' <?php echo $check_prop_condition_partial; ?> type='radio' value='yellow' name='renovation_status' id='nr'>
			 								<label class='form-check-label text-capitalize' for='nr'>
			 									 	<span class='dot dot-2'></span><span class="dot-status">Not Renovated</span>
			 							 </label>
										</div>
									</div>
									<div class="col-12 mt-3" style="border: 2px solid #98f98d; border-radius: 5px; padding-top: 10px; padding-bottom: 10px; background-color: #fff;">
										<div class="form-group px-4">
											<input class='form-check-input' type='radio' <?php echo $check_prop_condition_bad; ?> value='red' name='renovation_status' id='rn'>
			 								<label class='form-check-label text-capitalize' for='rn'>
			 									 <span class='dot dot-1'></span><span class="dot-status">Renovation Needed</span>
			 							 </label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
					<li>
						<div class="row mt-3">
							<div class="col-md-10 col-11 mx-auto">
								<h4 class="text-center mb-2">Extra Expenses</h4>
								<div class="form-group">
									<label for="lawyer">Lawyer</label><br>
									<input class="input form-control" id="lawyer" type="text" value="<?php echo $lawyer; ?>">
								</div>
								<div class="form-group">
									<label for="renovation">Renovation</label><br>
									<input class="input form-control" type="text" id="renovation" value="<?php echo $renovation; ?>">
								</div>
								<div class="form-group">
									<label for="brokerage">Brokerage Fee</label><br>
									<input class="input form-control" type="text" id="brokerage" value="<?php echo $brokerage; ?>">
								</div>
								<div class="form-group">
									<label for="tax">Tax</label><br>
									<input class="input form-control" type="text" id="tax" value="<?php echo $tax; ?>">
								</div>
								<div class="form-group">
									<label for="appraiser">Appraiser</label><br>
									<input class="input form-control" type="text" id="appraiser" value="<?php echo $appraiser; ?>">
								</div>
							</div>
						</div>
					</li>
			  </ul>
			</div>
			<div class="column mt-5 mb-3">
				<div class="row">
					<div class="col-lg-6 col-10 mx-auto">
						<!-- <label for="property_description" class="mt-2">Tell us about your property</label> -->
						<textarea class="form-control" style="background: #98f98d; border-radius: 35px;" id="property_description" rows="8" placeholder="Tell us about your property"><?php echo $propDesc; ?></textarea>
					</div>
					<div class="col-lg-6 col-10 mx-auto">
						<div class="title-box-d">
							<h4 class="title-d">Contact Details</h4>
						</div>
						<div class="form-row">
							<div class="form-group col-6">
								<label for="firstName">Frist Name*</label>
								<input type='text' class='form-control input d-block' id="firstname" name='firstname' value='<?php echo $f_name; ?>' placeholder='First Name' width="100%" required>
							</div>
							<div class="form-group col-6">
								<label for="lastName">Last Name*</label>
								<input type='text' class='form-control input d-block' id="lastname" name='lastname' value='<?php echo $l_name; ?>' placeholder='Last Name' width="100%" required>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-6">
								<label for="agentEmail">Email*</label>
								<input type='text' class='form-control input d-block' id="agentEmail" name='agentEmail' value='<?php echo $user_email; ?>' placeholder='Agent Email' width="100%" required>
							</div>
							<div class="form-group col-6">
								<label for="agentNumber">Seller Tel*</label>
								<input type='text' class='form-control input d-block' id="agentNumber" name='agentNumber' value='<?php echo $user_tel; ?>' placeholder='Tel: +' width="100%" required>
							</div>
						</div>
						<!-- <p class="text-center" style="font-size: 14px">*If these details are ok please proceed. if not, please make appropriate changes then proceed</p> -->
					</div>
					<!-- <p class="text-center text-danger" style="font-size: 14px">*Ensure that you have filled all provided fields</p> -->
				</div>
			</div>
			<div class="row my-2">
				<div class="col-11 mx-auto">
					<div class="card card-common">
              <div class="card-header">
								<div class="title-box-d">
									<h4 class="title-d">Similar Purchases</h4>
								</div>
              </div>
              <div class="card-body">
                <div class="row">
                	<div class="col-md-8 mx-auto">
										<?php
                        $str = "<table style='width:100%'>
                                    <thead class='text-center'>
                                    <tr>
                                        <th>ID</th>
                                        <th>Address</th>
                                        <th>Rooms</th>
                                        <th>Price</th>
                                        <th>Date</th>
                                        <th>Building Year</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>";
                        $str .= "<div class='row'>";
                        $homeServiceSql = "SELECT * FROM similarpurchases WHERE propertyId = :id";
                        $homeServiceQuery = $con->prepare($homeServiceSql);
												$homeServiceQuery->bindParam(":id", $propId);
                        $homeServiceQuery->execute();
                        $count = $homeServiceQuery->rowCount();
                        // echo $count;
                        if($count == 0){
                            $str .= "<tr class='text-danger text-center my-3'>
                                        <td colspan='7'>No Similar purchases available for this product</td>
                                    </tr>";
                        }

                        while ($row = $homeServiceQuery->fetch(PDO::FETCH_ASSOC)){
                            $id = $row['id'];
                            $address = $row['address'];
                            $rooms = $row['rooms'];
                            $price = $row['price'];
                            $price = number_format($price);
                            $date = $row['date'];
                            $building_year = $row['building_year'];

                           $delete_button = "<span class='delete_prod btn'><i class='fa fa-times-circle text-danger' data-toggle='modal' data-target='#serv$id'></i></span>";

                            $str .= "<tr class='text-center'>
                                        <td>$id</td>
                                        <td>$address</td>
                                        <td>$rooms</td>
                                        <td>$cur $price</td>
                                        <td>$date</td>
                                        <td>$building_year</td>
                                        <td>$delete_button</td>
                                    </tr>";

                        ?>

                        <!-- delete modal -->
                            <div class="modal fade" id="serv<?php echo $id;?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                                Are you sure you want to delete this purchase?
                                            <button type="button" class="close" data-dismiss="modal">
                                                &times;
                                            </button>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Cancel
                                            </button>
                                            <a href="includes/handlers/delete.php?simpurchId=<?php echo $id;?>&propId=<?php echo $propId ?>&for=similarpurchase" class="btn btn-danger text-light"> OK</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- end of delete modal -->

                        <?php
                        }
                        $str .= "</tbody>
                            </table>";
                        echo $str;
                    ?>
              		</div>
									<div class="col-md-4 mx-auto">
											<form action="" id="sim_purchase_form" method="POST">
												<input type="hidden" id="sim_propertyId" value="<?php echo $propId; ?>">
	                        <div class="form-row">
	                            <div class="col-6">
	                                <label for="">Address*</label>
	                                <input type='text' class='form-control input d-block' id='address' placeholder='Address'>
	                            </div>
	                            <div class="col-6">
	                                <label for="">rooms*</label>
	                                <input type='number' class='form-control input d-block' id='sim_rooms' placeholder='rooms'>
	                            </div>
	                        </div>
	                        <div class="form-row">
	                            <div class="col-6">
	                                <label for="">Price*</label>
	                                <input type='number' class='form-control input d-block' id='sim_price' placeholder='Price'>
	                            </div>
	                            <div class="col-6">
	                                <label for="">Date*</label>
	                                <input type='date' class='form-control input d-block' id='date_prop' placeholder='Date'>
	                            </div>
	                        </div>
	                        <div class="form-group">
	                            <label for="">Building Year*</label>
	                            <input type='text' class='form-control input d-block' id='sim_build_year' placeholder='Building Year'>
	                        </div>
	                        <button class="btn btn-info btn-block" type="submit" name="add_sim_purchase">Submit</button>
	                    </form>
										</div>
	            	</div>
	        	</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-5 col-md-7 col-10 mx-auto">
					<div class="column text-center">
		          <div class="my-auto w-50 mx-auto">
		              <!-- <a href="" class="btn btn-block btn-primary" style="border-radius:50px" id="saveDrafts"><i class="fab fa-firstdraft"></i>  Save Drafts</a> -->
		              <a href="" class="btn btn-block btn-success" style="border-radius:50px" id="publish"><i class="fas fa-newspaper"></i>  Publish</a>
		              <!-- <a href="" class="btn btn-block btn-secondary" style="border-radius:50px" id="preview"><i class="fa fa-eye"></i>  Preview</a> -->
		          </div>
		      </div>
				</div>
			</div>
		</div>
	</main>
<footer class="py-4 bg-light mt-auto">
  <div class="container-fluid">
      <div class="d-flex align-items-center justify-content-between small">
          <div class="text-muted">Copyright &copy; <?php echo "$webName "; echo date("Y");?></div>
          <div>
              <a href="#">Privacy Policy</a>
              &middot;
              <a href="#">Terms &amp; Conditions</a>
          </div>
      </div>
  </div>
</footer>
</div>
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
	<script src="assets/cards/dist/stackedCards.min.js"></script>
  <script src="summernote-master/dist/summernote-bs4.min.js"></script>
	<script src="assets/bootstrap-switch/js/bootstrap-switch.js"></script>
  <script src="js/scripts.js"></script>
  <script src="js/scripts1.js"></script>
	<script>
		var stackedCardSlide = new stackedCards({
			selector: '.stacked-cards-slide',
			layout: "slide",
			transformOrigin: "center",
		 });

		stackedCardSlide.init();
		$("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
	</script>
</body>
</html>
