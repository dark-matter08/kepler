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
                $propFeat = $row['propFeatures'];
                $aucType = $row['auctionType'];
                $propType = $row['propertyType'];
                $propLoc = $row['propLocation'];
                $propPrice = $row['propPrice'];
                $invPrice = $row['invPrice'];
                $annReturns = $row['annualReturns'];
                $formattedannReturns = number_format($annReturns);
                $imagePath = $row['imagePath'];
                $status = $row['status'];
                $date = $row['dateAdded'];
                $rentIncome = $row['rent_income'];
                $oldPrice = $row['old_price'];
            }

            $query2 = $con->prepare("SELECT * FROM descfeatures WHERE propertyId = $propId");
            $query2->execute();


            while ($row2 = $query2->fetch(PDO::FETCH_ASSOC)){
                $descFeatureId = $row2['id'];
                $area = $row2['area'];
                $bedrooms = $row2['bedrooms'];
                $baths = $row2['baths'];
                $garage = $row2['garage'];
            }

            $query3 = $con->prepare("SELECT * FROM propertycity WHERE propertyId = $propId");
            $query3->execute();


            while ($row3 = $query3->fetch(PDO::FETCH_ASSOC)){
                $cityId = $row3['id'];
                $city = $row3['cityName'];
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

        } elseif ($type == 'new') {
            $query = $con->prepare("SELECT * FROM property WHERE id = $propId");
            $query->execute();

            while ($row = $query->fetch(PDO::FETCH_ASSOC)){
                $id = $row['id'];
                $propName = $row['propName'];
                echo "<script>propName = '$propName';</script>";
                if ($propName != "New Property"){
                    $propDesc = $row['propDescription'];
                    $propFeat = $row['propFeatures'];
                    $aucType = $row['auctionType'];
                    $propType = $row['propertyType'];
                    $propLoc = $row['propLocation'];
                    $propPrice = $row['propPrice'];
                    $invPrice = $row['invPrice'];
                    $annReturns = $row['annualReturns'];
                    $annReturns = round($annReturns, 2);
                    $formattedannReturns = number_format($annReturns);
                    $imagePath = $row['imagePath'];
                    $status = $row['status'];
                    $date = $row['dateAdded'];
                    $rentIncome = $row['rent_income'];
                    $oldPrice = $row['old_price'];


                    $query2 = $con->prepare("SELECT * FROM descfeatures WHERE propertyId = $propId");
                    $query2->execute();


                    while ($row2 = $query2->fetch(PDO::FETCH_ASSOC)){
                        $descFeatureId = $row2['id'];
                        $area = $row2['area'];
                        $bedrooms = $row2['bedrooms'];
                        $baths = $row2['baths'];
                        $garage = $row2['garage'];
                    }

                    $query3 = $con->prepare("SELECT * FROM propertycity WHERE propertyId = $propId");
                    $query3->execute();


                    while ($row3 = $query3->fetch(PDO::FETCH_ASSOC)){
                        $cityId = $row3['id'];
                        $city = $row3['cityName'];
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
                }else{
                    $propName = "";
                    $propDesc = "";
                    $propFeat = "";
                    $propType = "";
                    $aucType = "";
                    $propLoc = "";
                    $propPrice = "";
                    $imagePath = "";
                    $status = "";
                    $rentIncome = "";
                    $date = "";
                    $descFeatureId = "";
                    $formattedannReturns = "";
                    $area = "";
                    $bedrooms = "";
                    $baths = "";
                    $garage = "";
                    $cityId = "";
                    $city = "";
                    $country = "";
                    $lat = "";
                    $lng = "";
                    $annReturns = '';
                    $lawyer = '';
                    $renovation = '';
                    $brokerage = '';
                    $tax = '';
                    $appraiser = '';
                    $oldPrice = '';

                }
            }

        }else {
          header('Location: property.php');
        }
    } else{
    header('Location: property.php');
    }

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
  <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
  <link href="assets/normalize/normalize.css" rel="stylesheet" type="text/css">
  <link href="assets/card-slider/dist/css/cardslider.css" rel="stylesheet">
  <link href="summernote-master/dist/summernote-bs4.min.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet" />
  <link href="assets/card-slider/demo.css" rel="stylesheet">
	<script src="assets/jquery/jquery.min.js"></script>
  <script src="assets/all-js/all.min.js" crossorigin="anonymous"></script>
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
<body>
	<div id='loader' class="loader"></div>
	<main>
		<div class="container-fluid">
			<h1 class="mt-4">Property</h1>
			<ol class="breadcrumb mb-4">
				<li class="breadcrumb-item active">Editing Property | <?php echo "$propName"?> | <span class="mx-5 text-right font-weight-bold">Annual Returns: <?php echo $annReturns;?>%</span></li>
			</ol>
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
			<div class="my-slider">
  <ul>
    <li class="card-slider-item">
      <div class="form-group">
          <label for="propName">Propert Name*</label>
          <input type='hidden' class='form-control input d-block' id="agentName" name='agentName' value='<?php echo $username; ?>' required>
          <input type='text' class='form-control input d-block' id="propName" name='propName' value='<?php echo $propName; ?>' placeholder='Property Name' width="100%" required>
      </div>
      <div class="form-group">
          <label for="propDesc">Property Description</label>
          <textarea class="" id="propDesc" rows="25"><?php echo $propDesc; ?></textarea>
      </div>
    </li>
    <li class="center card-slider-item">
      <div class="form-group">
          <label for="propFeatures">Property Feartures <span class="featureComent hidden">(Separate Each Feature with a Comma)</span></label><br>
          <textarea class="w-100 form-control" id="propFeatures" placeholder="Separate Each Feature with a Comma. e.g. Balcony, Deck, Parking" rows="4"><?php echo $propFeat; ?></textarea>
      </div>
    </li>
    <li class="center card-slider-item">
      <div class="column">
          <div class="my-auto">
              <h4 class="text-center mb-2">Set Location</h4>
              <div class="row">
                  <div class="col-lg-12 mx-auto">
                      <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="cities">City</label><br>
                                  <!-- <input class="input form-control" type="text" id="city" value="<?php echo $city; ?>"> -->
                                  <input class="input form-control" list="citynames" id="cities" list="citynames" value="<?php echo $city; ?>">
                                  <datalist id="citynames">
                                  </datalist>
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="country">Country</label><br>
                                  <input class="input form-control" type="text" id="country" value="<?php echo $country; ?>">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="country">Longitude</label><br>
                                  <input class="input form-control" type="text" id="lng" value="<?php echo $lng; ?>">
                              </div>
                          </div>
                          <div class="col-md-6">
                              <div class="form-group">
                                  <label for="country">Latitude</label><br>
                                  <input class="input form-control" type="text" id="lat" value="<?php echo $lat; ?>">
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-12">
                      <div class="form-group">
                          <label for="propPrice">Property Type&nbsp;<span class="small">e.g. House, Apartment, Studio...</span></label><br>
                          <input class="input form-control" placehoder='' type="text" id="propType" value="<?php echo $propType; ?>">
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </li>
    <li class="card-slider-item">
      <div class="column">
          <div class="my-auto">
              <h4 class="text-center mb-2">Descriptive Feartures</h4>
              <div class="row">
                  <div class="col-lg-12 mx-auto">
                      <div class="row">
                          <div class="col-lg-6">
                              <div class="form-group">
                                  <label for="area">Area</label><br>
                                  <input class="input form-control" type="text" id="area" value="<?php echo $area; ?>">
                              </div>
                              <div class="form-group">
                                  <label for="bedrooms">Bedrooms</label><br>
                                  <input class="input form-control" type="number" id="bedrooms" value="<?php echo $bedrooms; ?>">
                              </div>
                          </div>
                          <div class="col-lg-6">
                              <div class="form-group">
                                  <label for="baths">Baths</label><br>
                                  <input class="input form-control" type="number" id="baths" value="<?php echo $baths; ?>">
                              </div>
                              <div class="form-group">
                                  <label for="garage">Garage</label><br>
                                  <input class="input form-control" type="number" id="garage" value="<?php echo $garage; ?>">
                              </div>
                          </div>
                      </div>
                  </div>
                  <hr>
                  <div class="col-lg-12">
                      <div class="row">
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="propPrice">Rent Income</label><br>
                                  <input class="input form-control" type="number" id="rentIncome" value="<?php echo $rentIncome; ?>">
                              </div>
                          </div>
                          <div class="col-6">
                              <div class="form-group">
                                  <label for="propPrice">Price 5 years Ago</label><br>
                                  <input class="input form-control" type="number" id="oldPrice" value="<?php echo $oldPrice; ?>">
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </li>
    <li class="card-slider-item">
      <div class="column">
        <h4 class="text-center mb-2">Pricing</h4>
        <div class="form-group">
          <label for="invPrice">Property Price*</label><br>
          <input class="input form-control" type="number" id="invPrice" value="<?php echo $invPrice; ?>">
        </div>
        <div class="form-group">
          <label for="propPrice">Rent Income</label><br>
          <input class="input form-control" type="number" id="rentIncome" value="<?php echo $rentIncome; ?>">
        </div>
      </div>
    </li>
    <li class="card-slider-item">
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

                  $str .= "
                              <li class='ImageListItem $selected' onclick='setSelectedPhoto($photoId, $propId, this)'><img src='$imgPath' alt='$photoId' class='propImage' class='mb-2'></li>$delete_button

                          ";

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
                  echo $str;
                  echo "</ul>";
              ?>
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
                      <li class='breadcrumb-item active'>$delete_button &nbsp&nbsp|&nbsp&nbsp$fileName</li>
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
    </li>
		<li class="center card-slider-item">
			<div class="column">
					<div class="my-auto">
							<h4 class="text-center mb-2">Extra Expenses</h4>
							<div class="row">
									<div class="col-lg-12 mx-auto">
											<div class="row">
													<div class="col-md-6">
															<div class="form-group">
																	<label for="lawyer">Lawyer</label><br>
																	<input class="input form-control" id="lawyer" type="text" value="<?php echo $lawyer; ?>">
															</div>
													</div>
													<div class="col-md-6">
															<div class="form-group">
																	<label for="renovation">Renovation</label><br>
																	<input class="input form-control" type="text" id="renovation" value="<?php echo $renovation; ?>">
															</div>
													</div>
													<div class="col-md-6">
															<div class="form-group">
																	<label for="brokerage">Brokerage Fee</label><br>
																	<input class="input form-control" type="text" id="brokerage" value="<?php echo $brokerage; ?>">
															</div>
													</div>
													<div class="col-md-6">
															<div class="form-group">
																	<label for="tax">Tax</label><br>
																	<input class="input form-control" type="text" id="tax" value="<?php echo $tax; ?>">
															</div>
													</div>
											</div>
									</div>
									<div class="col-lg-12">
											<div class="form-group">
													<label for="appraiser">Appraiser</label><br>
													<input class="input form-control" type="text" id="appraiser" value="<?php echo $appraiser; ?>">

											</div>
									</div>
							</div>
					</div>
			</div>
		</li>
    <li class="card-slider-item">
      <div class="column mt-5">
          <div class="my-auto">
              <a href="" class="btn btn-block btn-primary" id="saveDrafts"><i class="fab fa-firstdraft"></i>  Save Drafts</a>
              <a href="" class="btn btn-block btn-success" id="publish"><i class="fas fa-newspaper"></i>  Publish</a>
              <a href="" class="btn btn-block btn-secondary" id="preview"><i class="fa fa-eye"></i>  Preview</a>
          </div>
      </div>
    </li>
  </ul>
</div>
		</div>
	</main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <!-- <script src="http://code.jquery.com/jquery-2.2.3.min.js"></script> -->
  <script src="assets/card-slider/jquery.event.move.js"></script>
  <script src="assets/card-slider/jquery.event.swipe.js"></script>
  <script src="assets/card-slider/dist/js/jquery.cardslider.min.js"></script>
  <script src="summernote-master/dist/summernote-bs4.min.js"></script>
  <script src="js/scripts.js"></script>
  <script src="js/scripts1.js"></script>
  <script>
  			$('.my-slider').cardslider({
  				// swipe: true,
  				// dots: true
  			});
  		</script><script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-36251023-1']);
    _gaq.push(['_setDomainName', 'jqueryscript.net']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

  </script>
</body>
</html>
