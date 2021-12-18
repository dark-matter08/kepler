<?php
  include("includes/header.php");
  if(urldecode($_GET['propId']) || urldecode($_GET['propId'])){
    $id = urldecode($_GET['propId']);
    echo "<script>propId = '$id';</script>";

  } else {
    header("Location: index.php");
  }


  $propSql = "SELECT * FROM property WHERE id = :propId";
  $propQuery = $con->prepare($propSql);
  $propQuery->bindParam(":propId", $id);
  $propQuery->execute();

  while ($row = $propQuery->fetch(PDO::FETCH_ASSOC)){
    $propId = $row['id'];
    $propName = $row['propName'];
    echo "<script>propName = '$propName';</script>";
    $propDesc = $row['propDescription'];
    $propPrice = $row['propPrice'];
    $formattedpropPrice = number_format($propPrice);
    $annRet = $row['annualReturns'];
    $annRet = round($annRet, 2);
    $propType = $row['propertyType'];
    $status = $row['status'];
    $capital = 0.25 * $propPrice;
    $formattedCapital = number_format($capital);
    $mortgage = (0.75 * $propPrice)/300;
    $formattedMortgage = number_format($mortgage);
    $primeImage = $row['imagePath'];
    $uploaded_by = $row['uploaded_by'];

    $rentIncome = $row['rent_income'];
    $formattedrentIncome = number_format($rentIncome);
    $price_5_years_ago = $row['old_price'];
    $formattedprice_5_years_ago = number_format($price_5_years_ago);
    $return_on_capital = (((12 * $rentIncome)/$capital)*100);

    $dots = (strlen($propName) >= 15) ? "..." : "";
    $shortName = str_split($propName, 15);
    $shortName = $shortName[0] . $dots;

  }

  $userQuery = $con->prepare("SELECT * FROM propertyseller WHERE propertyId = :id");
  $userQuery->bindParam(":id", $propId);
  $userQuery->execute();
  while ($row = $userQuery->fetch(PDO::FETCH_ASSOC)) {
    # code...
    $f_name = $row['first_name'];
    $l_name = $row['last_name'];
    $email = $row['email'];
    $user_tel = $row['telephone'];
  }

  // ================================== image Query ============================================

  $allPhotoQuery = $con->prepare("SELECT imgPath FROM propertyphoto WHERE propId = :id");
  $allPhotoQuery->bindParam(":id", $propId);
  $allPhotoQuery->execute();
  $imgStr = '';
  $count = $allPhotoQuery->rowCount();
  if($count > 0){
    while ($row = $allPhotoQuery->fetch(PDO::FETCH_ASSOC)) {
      // code...
      $allImagePath = $row['imgPath'];
      $imgStr .= "<div class='carousel-item-b'>
                    <img src='dashboard/dist/$allImagePath' style='height: 400px;' alt=''>
                  </div>";
    }
  } else{
    $allImagePath = $primeImage;
    $imgStr .= "<div class='carousel-item-b'>
                    <img src='dashboard/dist/$allImagePath' style='height: 400px;' alt=''>
                  </div>";
  }



  // ==================================== Descriptiove Features query ========================================

  $descFeatQuery = $con->prepare("SELECT * FROM descfeatures WHERE propertyId = :propId");
  $descFeatQuery->bindParam(":propId", $propId);
  $descFeatQuery->execute();
  while ($row = $descFeatQuery->fetch(PDO::FETCH_ASSOC)){
    $area = $row['area'];
    $bedrooms = $row['bedrooms'];
    $number_of_building_floors = $row['number_of_building_floors'];
  }
  // ==================================== Ammenities query ========================================

  $ammn = $con->prepare("SELECT * FROM propertyamenities WHERE propertyId = :propId");
  $ammn->bindParam(":propId", $propId);
  $ammn->execute();
  while ($row = $ammn->fetch(PDO::FETCH_ASSOC)){
    $parking = $row['parking'];
    $balcony = $row['balcony'];
  }

  // ================================ Location Query ================================================

  $locQuery = $con->prepare("SELECT * FROM propertycity WHERE propertyId = :propId");
  $locQuery->bindParam(":propId", $propId);
  $locQuery->execute();
  while ($row = $locQuery->fetch(PDO::FETCH_ASSOC)){
    $cities = $row['cityName'];
    $country = $row['countryName'];
    $lng = $row['lng'];
    $lat = $row['lat'];

    echo "<script>lng = '$lng';</script>";
    echo "<script>lat = '$lat';</script>";

    $location = "$cities, $country";
    echo "<script>propLocation = '$location';</script>";
  }

  // ============================= Extra Expenses =====================================================

  $query4 = $con->prepare("SELECT * FROM propertyextraexpenses WHERE propertyId = $propId");
  $query4->execute();

  $row4 = $query4->fetch(PDO::FETCH_ASSOC);
  $lawyer = $row4['lawyer'];
  $lawyer = number_format($lawyer);
  $renovation = $row4['renovation'];
  $lawrenovationyer = number_format($renovation);
  $brokerage = $row4['brokerage_fee'];
  $brokerage = number_format($brokerage);
  $tax = $row4['tax'];
  $tax = number_format($tax);
  $appraiser = $row4['appraiser'];
  $appraiser = number_format($appraiser);
?>
<script type="text/javascript">
  $(document).ready(function(){
    $(".navbar-nav li .active").removeClass("active");
    $(".navbar-nav li .property").addClass("active");

    newPageTitle = propName + ' | KEPLER';
    document.title = newPageTitle;
  });

</script>
<style media="screen">
  .nav-tabs {
    border: none !important;
  }
  .tabs-nav, .tabs-nav1{
    margin-top: 10px;
    font-size: 15px;
    padding: 0px;
    list-style: none;
    /* background: #fff; */
    /* box-shadow: 0px 5px 20px rgba(0,0,0,0.1); */
    border-radius: 50px;
    position: relative;
    /* border: 1px solid #000; */
  }
  .tabs-nav a, .tabs-nav1 a{
    text-decoration: none;
    color: #777;
    text-transform: uppercase;
    padding: 5px 20px;
    display: inline-block;
    position: relative;
    z-index: 1;
    transition-duration: 0.6s;
  }

  .tabs-nav a.active, .tabs-nav1 a.active{
    color: #fff;
  }

  .tabs-nav a i, .tabs-nav1 a i {
    margin-right: 5px;
  }

  .tabs-nav .selector, .tabs-nav1 .selector2{
    height: 100%;
    display: inline-block;
    position: absolute;
    left: 0px;
    top: 0px;
    z-index: 1;
    border-radius: 50px;
    transition-duration: 0.6s;
    transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
    background: #2eca6a;
    background: -moz-linear-gradient(45deg, #2eca6a, 0%, #8200f4, 100%);
    background: -webkit-linear-gradient(45deg, #2eca6a, 0%, #8200f4, 100%);
    background: linear-gradient(45deg, #2eca6a, 0%, #8200f4, 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(starColorstr='#2eca6a', endColourstr='#8200f4', GradienType=1);
  }
  .tab-name{
    color: #000;
    font-size: .7rem;
  }
  .active .tab-name{
    color: #fff;
  }
</style>

  <main id="main">

    <!-- ======= Intro Single ======= -->
    <section class="intro-single">
      <!-- <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-8">
            <div class="title-single-box">
              <h1 class="title-single"><?php echo $propName?></h1>
              <span class="color-text-a"><?php echo $location?></span>
            </div>
          </div>
          <div class="col-md-12 col-lg-4">
            <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="index.html">Home</a>
                </li>
                <li class="breadcrumb-item">
                  <a href="property.php">Properties</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  <?php echo $shortName?>
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div> -->
    </section>

    <!-- ======= Property Single ======= -->
    <section class="property-single nav-arrow-b">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="row">
              <div class="col-6" style="border: none; border-right: 4px solid #2eca6a">
                <div id="property-single-carousel" class="owl-carousel owl-arrow gallery-property" style="min-height: 400px;">
                  <?php echo $imgStr?>
                </div>
                <div class="row">
                  <div class="col-md-3 col-6 mx-auto prop-carousel-bellow text-center">
                    <?php echo $bedrooms?><br>Roooms
                  </div>
                  <div class="col-md-2 col-6 mx-auto prop-carousel-bellow text-center">
                    <?php echo $area?><br>m<sup>2</sup>
                  </div>
                  <div class="col-md-2 col-6 mx-auto prop-carousel-bellow text-center">
                    <?php echo $number_of_building_floors?><br>floor(s)
                  </div>
                  <div class="col-md-2 col-6 mx-auto prop-carousel-bellow text-center">
                    <span class="text-uppercase"><?php echo $balcony?></span> <br>Balcony
                  </div>
                  <div class="col-md-3 col-12 mx-auto text-center" style="font-size:13px">
                    <span class="text-uppercase"><?php echo $parking?></span><br>Parking
                  </div>
                </div>
              </div>
              <div class="col-6">
                <?php
                  $manualSql = "SELECT * FROM propertytownplan WHERE propId = $propId ORDER BY id ASC";
                  $manualQuery = $con->prepare($manualSql);
                  $manualQuery->execute();
                  $docCount = $manualQuery->rowCount();
                  $str = "";
                ?>
                <!-- map and video here -->
                <div class="tab" role="tabpanel">
                  <!-- Tab panes -->
                  <div class="tab-content tabs" style="min-height:400px; max-height:400px;">
                    <div role="tabpanel" class="tab-pane fade in show active" id="Section1">
                      <div class="w-100">
                        <div id="map" class="full-map"></div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section2">
                      <?php
                        while ($row = $manualQuery->fetch(PDO::FETCH_ASSOC)){
                            $manId = $row['id'];
                            $fileName = $row['fileName'];
                            $filePath = $row['filePath'];
                            $fileSize = $row['size'];

                            $delete_button = "<a href='dashboard/dist/$filePath' download='$fileName'><i class='fa fa-download text-primary'></i></a>";
                            $str .= "<ol class='breadcrumb mb-4'>
                            <li class='breadcrumb-item active'>$delete_button &nbsp&nbsp|&nbsp&nbsp$fileName</li>
                            </ol>";

                          }

                          echo $str;
                        ?>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="Section3">
                      <iframe src="https://player.vimeo.com/video/73221098" width="100%" height="400" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                    </div>
                  </div>
                  <!-- Nav tabs -->
                  <nav class="tabs-nav">
                    <div class="selector"></div>
                    <ul  class="nav nav-tabs" role="tablist">
                      <li  role="presentation" id="Section11" class="nav-list">
                        <a href="#Section1" aria-controls="home" role="tab" data-toggle="tab" class="active">
                          <i class="fa fa-map"></i>
                          <span class="tab-name">Location Map</span>
                        </a>
                      </li>
                      <li  role="presentation" id="Section22" class="nav-list">
                        <a href="#Section2" aria-controls="home" role="tab" data-toggle="tab" class="">
                          <i class="fa fa-file">
                          </i><span class="tab-name">Plans in this Area(<?php echo $docCount;?>)</span>
                        </a>
                      </li>
                      <li  role="presentation" id="Section33" class="nav-list">
                        <a href="#Section3" aria-controls="home" role="tab" data-toggle="tab" class="">
                          <i class="fa fa-video-camera"></i>
                          <span class="tab-name">Property Video</span>
                        </a>
                      </li>
                    </ul>
                  </nav>
                </div>
              </div>
            </div>
          </div>


          <div class="col-sm-12 my-5">
            <div class="row justify-content-between">
              <div class="col-md-5 col-lg-4">
                <!-- <div class="property-price d-flex justify-content-center foo">
                  <div class="card-header-c d-flex">
                    <div class="card-box-ico">
                      <span class="ion-money"><?php echo $cur?></span>
                    </div>
                    <div class="card-title-c align-self-center">
                      <h5 class="title-c"><?php echo $formattedpropPrice?></h5>
                    </div>
                  </div>
                </div> -->
                <div class="property-summary">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="title-box-d">
                        <h3 class="title-d"><a class="navbar-brand text-brand" href="javascript:void(0);">Kep<span class="color-b">ler.</span></a> View</h3>
                      </div>
                    </div>
                  </div>
                  <div class="summary-list">
                    <ul class="list">
                      <!-- <li class="d-flex justify-content-between">
                        <strong>Property ID:</strong>
                        <span><?php echo $propId?></span>
                      </li> -->
                      <li class="d-flex justify-content-between">
                        <strong><?php echo $cur?><?php echo $formattedpropPrice?></strong>
                        <span>Price</span>
                      </li>
                      <li class="d-flex justify-content-between">
                        <strong><?php echo $cur?><?php echo $formattedCapital?></strong>
                        <span>Equity</span>
                      </li>
                      <li class="d-flex justify-content-between">
                        <strong><?php echo $cur?><?php echo $formattedMortgage?></strong>
                        <span>Mortgage</span>
                      </li>
                      <li class="d-flex justify-content-between">
                        <strong><?php echo $cur?><?php echo $formattedrentIncome?></strong>
                        <span>Rent Income</span>
                      </li>
                      <li class="d-flex justify-content-between">
                       <strong><?php echo $annRet?>%</strong>
                       <span>Annual Returns</span>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="property-summary">
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="title-box-d section-t4">
                        <h3 class="title-d">Extra Expenses</h3>
                      </div>
                    </div>
                  </div>
                  <div class="summary-list">
                    <ul class="list">
                      <li class="d-flex justify-content-between">
                        <strong><?php echo $cur?><?php echo $tax?></strong>
                        <span>Tax</span>
                      </li>
                      <li class="d-flex justify-content-between">
                        <strong><?php echo $cur?><?php echo $lawyer?></strong>
                        <span>Lawyer</span>
                      </li>
                      <li class="d-flex justify-content-between">
                        <strong><?php echo $cur?><?php echo $appraiser?></strong>
                        <span>Appraiser</span>
                      </li>
                      <li class="d-flex justify-content-between">
                        <strong><?php echo $cur?><?php echo $renovation?></strong>
                        <span>Renovation</span>
                      </li>
                      <li class="d-flex justify-content-between">
                        <strong><?php echo $cur?><?php echo $brokerage?></strong>
                        <span>Brokerage Fee</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-md-7 col-lg-7 section-md-t3">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="title-box-d">
                      <h3 class="title-d">Property Description</h3>
                    </div>
                  </div>
                </div>
                <div class="property-description">
                  <p class="description color-text-a">
                    <?php echo nl2br($propDesc); ?>
                  </p>
                </div>
                <div class="row section-t3">
                  <div class="col-sm-12">
                    <div class="row">
                      <div class="col-md-7">
                        <nav class="tabs-nav1">
                          <div class="selector2"></div>
                          <ul  class="nav nav-tabs" role="tablist">
                            <li  role="presentation" id="Section44" class="nav-list">
                              <a href="#Section4" aria-controls="home" role="tab" data-toggle="tab" class="active text-center" style="width: 150px">
                                Tour
                              </a>
                            </li>
                            <li  role="presentation" id="Section55" class="nav-list">
                              <a href="#Section5" aria-controls="home" role="tab" data-toggle="tab" class="">
                                Seller Contact <i class='fa fa-phone'></i>
                              </a>
                            </li>
                          </ul>
                        </nav>
                        <div class="tab-content tabs mt-3" style="min-height:100px; max-height:100px;">
                          <div role="tabpanel" class="tab-pane fade in show active some2" id="Section4">
                            <div class="" style="border-radius: 10px; color: #00000; background-color: #999999; padding: 0.7rem 1.5rem;">
                              <div class="row">
                                <div class="col-7" style="border:none; border-right: 2px dotted #000;">
                                  <p class="my-0"><?php echo "$f_name $l_name"; ?></p>
                                </div>
                                <div class="col-5">
                                  <p class="my-0"><?php echo "$user_tel"; ?></p>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div role="tabpanel" class="tab-pane fade some2" id="Section5">
                            <div class="" style="border-radius: 10px; color: #00000; background-color: #999999; padding: 0.7rem 1.5rem;">
                              <div class="row">
                                <div class="col-7" style="border:none; border-right: 2px dotted #000;">
                                  <p class="my-0"><?php echo "$f_name $l_name"; ?></p>
                                </div>
                                <div class="col-5">
                                  <p class="my-0"><?php echo "$user_tel"; ?></p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                      <div class="col-md-5 w-100 mt-2 text-right display-md-none display-lg-block">
                        <a class="text-center" style="border-radius: 20px; color: #2eca6a; background-color: #999999; padding: 1rem 1.5rem; font-size:13px">
                          Mortgage Componenses
                        </a>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="title-box-d">
                      <h3 class="title-d">Similar Purchases</h3>
                    </div>
                  </div>
                  <div class="col-sm-12">
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
                                    </tr>";


                        }
                        $str .= "</tbody>
                            </table>";
                        echo $str;
                    ?>
                  </div>
                </div>
                <!-- <div class="amenities-list color-text-a">
                  <ul class="list-a no-margin">
                    <?php
                      foreach ($amenities as $value){
                        $amenStrsingle = "<li>$value</li>";
                        echo $amenStrsingle;
                      }
                    ?>
                  </ul>
                </div> -->
              </div>
            </div>
          </div>
          <!-- <div class="col-md-10 col-lg-10 mx-auto">
            <div class="row">
              <div class="col-sm-12">
                <div class="title-box-d section-t4">
                  <h3 class="title-d">Similar Purchases</h3>
                </div>
              </div>
            </div>
          </div> -->
           <!-- <div class="col-md-12">
            <div class="row section-t3">
              <div class="col-sm-12">
                <div class="title-box-d">
                  <h3 class="title-d">Contact Seller</h3>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-lg-4 mx-auto">
                <img src="dashboard/dist/<?php echo $agent_img; ?>" alt="" class="img-fluid">
              </div>
              <div class="col-md-6 col-lg-4 mx-auto">
                <div class="property-agent">
                  <h4 class="title-agent"><?php echo "$f_name $l_name"; ?></h4>
                  <p class="color-text-a">
                    <?php echo "$user_about"; ?>
                  </p>
                  <ul class="list-unstyled">
                    <li class="d-flex justify-content-between">
                      <strong>Phone:</strong>
                      <span class="color-text-a"><?php echo "$user_tel"; ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Email:</strong>
                      <span class="color-text-a"><?php echo "$email"; ?></span>
                    </li>
                    <li class="d-flex justify-content-between">
                      <strong>Skype:</strong>
                      <span class="color-text-a">Annabela.ge</span>
                    </li>
                  </ul>
                  -->
                  <!--<div class="socials-a">
                    <ul class="list-inline">
                      <li class="list-inline-item">
                        <a href="#">
                          <i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="#">
                          <i class="fa fa-twitter" aria-hidden="true"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="#">
                          <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="#">
                          <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="#">
                          <i class="fa fa-dribbble" aria-hidden="true"></i>
                        </a>
                      </li>
                    </ul>
                  </div>-->
                </div>
              </div>
              <!--<div class="col-md-12 col-lg-4">
                <div class="property-contact">
                  <form class="form-a">
                    <div class="row">
                      <div class="col-md-12 mb-1">
                        <div class="form-group">
                          <input type="text" class="form-control form-control-lg form-control-a" id="inputName" placeholder="Name *" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-1">
                        <div class="form-group">
                          <input type="email" class="form-control form-control-lg form-control-a" id="inputEmail1" placeholder="Email *" required>
                        </div>
                      </div>
                      <div class="col-md-12 mb-1">
                        <div class="form-group">
                          <textarea id="textMessage" class="form-control" placeholder="Comment *" name="message" cols="45" rows="8" required></textarea>
                        </div>
                      </div>
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-a">Send Message</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>-->
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Property Single-->

  </main><!-- End #main -->
  <script type="text/javascript">
    var tabs = $('.tabs-nav');
    var tabs1 = $('.tabs-nav1');
    var selector = $('.tabs-nav').find('a').length;
    var selector1 = $('.tabs-nav1').find('a').length;
    //var selector = $(".tabs").find(".selector");
    var activeItem = tabs.find('.active');
    var activeItem1 = tabs1.find('.active');
    var activeWidth = activeItem.innerWidth();
    var activeWidth1 = activeItem1.innerWidth();
    $(".selector").css({
    "left": activeItem.position.left + "px",
    "width": activeWidth + "px"
    });
    $(".selector2").css({
    "left": activeItem1.position.left + "px",
    "width": activeWidth1 + "px"
    });

    $(".tabs-nav").on("click","a",function(e){
      // e.preventDefault();
      $('.tabs-nav a').removeClass("active");
      $(this).addClass('active');

      newactivewidth = $(this).attr("href")
      console.log(newactivewidth);
      $('.tab-content .tab-pane').removeClass("in")
      $('.tab-content .tab-pane').removeClass("show")
      $('.tab-content .tab-pane').removeClass("active")

      $(newactivewidth).addClass('in');
      $(newactivewidth).addClass('show');
      $(newactivewidth).addClass('active');


      var activeWidth = $(this).innerWidth();
      var itemPos = $(this).position();
      $(".selector").css({
        "left":itemPos.left + "px",
        "width": activeWidth + "px"
      });
    });

    $(".tabs-nav1").on("click","a",function(e){
      // e.preventDefault();
      $('.tabs-nav1 a').removeClass("active");
      $(this).addClass('active');

      newactivewidth1 = $(this).attr("href")
      console.log(newactivewidth1);
      $('.tab-content .some2').removeClass("in")
      $('.tab-content .some2').removeClass("show")
      $('.tab-content .some2').removeClass("active")

      $(newactivewidth1).addClass('in');
      $(newactivewidth1).addClass('show');
      $(newactivewidth1).addClass('active');


      var activeWidth = $(this).innerWidth();
      var itemPos = $(this).position();
      $(".selector2").css({
        "left":itemPos.left + "px",
        "width": activeWidth + "px"
      });
    });

  </script>


  <?php
    include("includes/footer.php");
  ?>
