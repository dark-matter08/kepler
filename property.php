<?php
  include("includes/header.php");
  include("pagination/function.php");

  $orderBy = "id";
  $dir = "ASC";
  $sortText = "";

  $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
  if (isset($_GET['sort'])){
    $sorting = $_GET['sorting'];
    echo "sorting";
 
    if($sorting == 'phtl'){
      $sortText .= "Sorting by Price; High to Low";
      $orderBy = "propPrice";
      $dir = "DESC";
    }
    if($sorting == 'plth'){
      $sortText .= "Sorting by Price; Low to High";
      $orderBy = "propPrice";
      $dir = "ASC";
    }
    
  }
  $limit = 12; //if you want to dispaly 10 records per page then you have to change here
  $startpoint = ($page * $limit) - $limit;
  $statement = "property WHERE status = '1' ORDER BY $orderBy $dir"; //you have to pass your query over here

    // $res=mysql_query("select * from {$statement} LIMIT {$startpoint} , {$limit}");

  $str = "";
  // $propSql = "SELECT * FROM property WHERE status = '1' ORDER BY $orderBy $dir LIMIT :startpoint , :lim";
  // echo $propSql;
  $propQuery = $con->prepare("SELECT * FROM property WHERE status = '1' ORDER BY $orderBy $dir LIMIT :startpoint , :lim");
  // $propQuery->bindParam(":statement", $statement);
  // $propQuery->bindParam(":orderBy", $orderBy);
  // $propQuery->bindParam(":dir", $dir);
  $propQuery->bindParam(":startpoint", $startpoint, PDO::PARAM_INT);
  $propQuery->bindParam(":lim", $limit, PDO::PARAM_INT);
  $propQuery->execute();
  // $count = $propQuery->rowCount();
  // echo $count;

  while ($row = $propQuery->fetch(PDO::FETCH_ASSOC)){
    $propId = $row['id'];
    $propName = $row['propName'];
    $propDesc = $row['propDescription'];
    $propFeatures = $row['propFeatures'];
    $propPrice = $row['propPrice'];
    $invPrice = $row['invPrice'];
    $formattedpropPrice = number_format($propPrice);
    $formattedinvPrice = number_format($invPrice);
    $aucType = $row['auctionType'];
    $annRet = $row['annualReturns'];
    $annRet = round($annRet, 2);
    $propType = $row['propertyType'];
    $status = $row['status'];
    $capital = 0.25 * $invPrice;
    $formattedCapital = number_format($capital);
    $mortgage = (0.75 * $invPrice)/300;
    $formattedMortgage = number_format($mortgage);
    $primeImage = $row['imagePath'];
    $rentIncome = $row['rent_income'];
    $formattedrentIncome = number_format($rentIncome);
    $price_5_years_ago = $row['old_price'];
    $formattedprice_5_years_ago = number_format($price_5_years_ago);


    if($aucType == 'Sale'){
      $annRet = 'X';
    } else {
      $annRet = $annRet;
    }

    $dots = (strlen($propName) >= 25) ? "..." : "";
    $shortName = str_split($propName, 25);
    $shortName = $shortName[0] . $dots;

    // ================================== image Query ============================================
    $photoQuery = $con->prepare("SELECT imgPath FROM propertyphoto WHERE propId = :id AND selected = '1'");
    $photoQuery->bindParam(":id", $propId);
    $photoQuery->execute();
    $count = $photoQuery->rowCount();
    if($count > 0){
      $row = $photoQuery->fetch(PDO::FETCH_ASSOC);
      $imagePath = $row['imgPath'];
    } else{
      $imagePath = $primeImage;
    }
    

    // ==================================== Descriptiove Features query ========================================

    $descFeatQuery = $con->prepare("SELECT * FROM descfeatures WHERE propertyId = :propId");
    $descFeatQuery->bindParam(":propId", $propId);
    $descFeatQuery->execute();
    while ($row = $descFeatQuery->fetch(PDO::FETCH_ASSOC)){
      $area = $row['area'];
      $bedrooms = $row['bedrooms'];
      $baths = $row['baths'];
      $garage = $row['garage'];
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

      $location = "$cities, $country";
    }
    $priceperarea =( $propPrice/$area);
    $priceperarea = round($priceperarea, 2);


    $str .= "<div class='col-12 mx-auto my-2'>
              <div class='row'>
                <div class='col-lg-5'>
                  <div class='card-box-a card-shadow' style='height: 18rem;'>
                    <div class='img-box-a' style='height: 100%; width: 100%;'>
                      <img src='dashboard/dist/$imagePath' alt='' class='img-a img-fluid' style='height: 100%; width: 100%;'>
                    </div>
                    <div class='card-overlay'>
                      <div class='card-overlay-a-content'>
                        <div class='card-header-a'>
                          
                        </div>
                        <div class='card-body-a'>
                          <a href='property-single.php?propId=$propId' class='link-a'>Click here to view
                            <span class='ion-ios-arrow-forward'></span>
                          </a>
                        </div>
                        <div class='card-footer-a'>
                          <ul class='card-info d-flex justify-content-around'>
                            <li>
                              <h4 class='card-info-title'>Area</h4>
                              <span>$area m
                                <sup>2</sup>
                              </span>
                            </li>
                            <li>
                              <h4 class='card-info-title'>Beds</h4>
                              <span>$bedrooms</span>
                            </li>
                            <li>
                              <h4 class='card-info-title'>Baths</h4>
                              <span>$baths</span>
                            </li>
                            <li>
                              <h4 class='card-info-title'>Garage</h4>
                              <span>$garage</span>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class='col-lg-7'>
                  <div class='prop-card-side'>
                    <div class='row'>
                      <div class='col-md-10 mt-2'>
                        <h3>
                          <a href='#'>$location</a>
                        </h3>
                      </div>
                      <div class='col-md-2'>
                        <i class='fa fa-heart fa-2x'></i>
                      </div>
                    </div>
                    <div class='row'>
                      <div class='col-md-12 mt-1'>
                        <span class='h2'>
                            $cur$formattedpropPrice
                        </span>
                        <span>
                          $cur$priceperarea per m<sup>2</sup>
                        </span>
                      </div>
                    </div>
                    <div class='row my-2'>
                      <div class='col-md-3 col-sm-6'>
                        <p class='m-0'>Price</p>
                        <div class='price-box w-100 d-flex'>
                          <span class='price-a text-dark'>$cur $formattedinvPrice</span>
                        </div>
                      </div>
                      <div class='col-md-3 col-sm-6'>
                        <p class='m-0'>Needed Equity</p>
                        <div class='price-box w-100 d-flex'>
                          <span class='price-a text-dark'>$cur $formattedCapital</span>
                        </div>
                      </div>
                      <div class='col-md-3 col-sm-6'>
                        <p class='m-0'>Mortgage</p>
                        <div class='price-box w-100 d-flex'>
                          <span class='price-a text-dark'>$cur $formattedMortgage</span>
                        </div>
                      </div>
                      <div class='col-md-3 col-sm-6'>
                        <p class='m-0'>Rent Income</p>
                        <div class='price-box w-100 d-flex'>
                          <span class='price-a text-dark'>$cur $formattedrentIncome</span>
                        </div>
                      </div>
                    </div>
                    <div class='row'>
                      <div class='col-md-9 col-6 mt-1'>
                        <p>Annual Return - $annRet%</p>
                        <p>Return on Capital - X%</p>
                        <p>Price % years ago - $cur $formattedprice_5_years_ago</p>
                      </div>
                      <div class='col-md-3 col-6 text-right h-100'>
                        <br><br><br>
                        <a class='btn mb-0 view-btn' href='property-single.php?propId=$propId'>View Details</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>";
  }
 

?>

<script type="text/javascript">
  $(document).ready(function(){
    $(".navbar-nav li .active").removeClass("active");
    $(".navbar-nav li .property").addClass("active");

    newPageTitle = 'PROPERTIES | KEPLER';
    document.title = newPageTitle;
  });

</script>
  <main id="main">

<div class='section-services section-t8'>
  <?php include("includes/searchbox.php"); ?>
</div>

    <!-- ======= Intro Single ======= -->
    <section class="intro-single">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-8">
            <div class="title-single-box">
              <h1 class="title-single">Our Amazing Properties</h1>
              <span class="color-text-a">Grid Properties</span>
            </div>
          </div>
          <div class="col-md-12 col-lg-4">
            <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="index.php">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Properties
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section><!-- End Intro Single-->

    <!-- ======= Property Grid ======= -->
    <section class="property-grid grid">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="grid-option">
              <form class="" method="GET" action="property.php">
                <input type="hidden" name='page' value="<?php echo $page; ?>">
                <select name="sorting" class="custom-select">
                  <option selected value="all">Default Sort</option>
                  <option value="phtl">Price High to Low</option>
                  <option value="plth">Price Low to High</option>
                  <option value="rhtl">Returns High to Low</option>
                  <option value="rlth">Returns Low to High</option>
                </select>

                <button type="submit" name="sort" value="Sort" class="btn btn-b-n">Sort</button>
              </form>
              <span class="color-text-b"><?php echo $sortText?> </span>
            </div>
          </div>
          <?php echo $str; ?>
        </div>
        <div class="row">
          <div class="col-sm-12">
          <nav class="pagination-a">
            <?php
              echo pagination($statement, $limit, $page, $con, $orderBy, $dir);
            ?>   
          </nav>
          </div>
        </div>
      </div>
    </section><!-- End Property Grid Single-->

  </main><!-- End #main -->

<?php
  include("includes/footer.php");
?>