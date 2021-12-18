<?php
  include("includes/header.php");
  include("pagination/function.php");


  $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
  $limit = 12; //if you want to dispaly 10 records per page then you have to change here
  $startpoint = ($page * $limit) - $limit;
  $statement = "property WHERE status = '1' ORDER BY :orderBy ASC"; //you have to pass your query over here

  if (isset($_GET['equity'])) {
		# code...
    $equity = $_GET['equity'];
    if (isset($_GET['firstHome'])) {
      $firstHome = $_GET['firstHome'];
    }else{
      $firstHome = "";
    }
    echo "<script>equity = '$equity';</script>";
    echo "<script>firstHome = '$firstHome';</script>";
    $city = "";
    $type = "";
    $formattedEquity = number_format($equity);
    if($firstHome == "yes"){
      $searchEquity = $equity * 4;
      $mortgageEq = ((0.75 * $searchEquity)/100000)*400;
    }else{
      $searchEquity = $equity * 2;
      $mortgageEq = ((0.5 * $searchEquity)/100000)*400;
    }
    // echo $searchEquity;
    // rent income -if- block;
    function getRentincomeEq($searchEquity){
      if( 375000 < $searchEquity && $searchEquity < 550001){
        $rent_income = 2050;
      }elseif (550000 < $searchEquity && $searchEquity < 670001) {
        $rent_income = 2550;
      }elseif (670000 < $searchEquity && $searchEquity < 810001) {
        $rent_income = 3020;
      }elseif (810000 < $searchEquity && $searchEquity < 1000001) {
        $rent_income = 3550;
      }elseif (1000000 < $searchEquity && $searchEquity < 1300001) {
        $rent_income = 4020;
      }elseif (1300000 < $searchEquity && $searchEquity < 1600001) {
        $rent_income = 4550;
      }elseif (1600000 < $searchEquity && $searchEquity < 1800001) {
        $rent_income = 4800;
      }elseif (1800000 < $searchEquity && $searchEquity < 2000001) {
        $rent_income = 5500;
      }elseif (2000000 < $searchEquity && $searchEquity < 2400001) {
        $rent_income = 6420;
      }elseif (2400000 < $searchEquity && $searchEquity < 2700001) {
        $rent_income = 6900;
      }elseif (2700000 < $searchEquity && $searchEquity < 3100001) {
        $rent_income = 7300;
      }elseif ($searchEquity > 3100000) {
        $rent_income = 7400;
      }else{
        $rent_income = 2000;
      }

      return $rent_income;
    }

    $rentIncomeEq = getRentincomeEq($searchEquity);
    $formattedrentIncomeEq = number_format($rentIncomeEq);
    $formattedsearchEquity = number_format($searchEquity);
    $formattedMortgageEq = number_format($mortgageEq);
  } else{
    header("Location: index.php");
  }
  // echo "$equity $type $city $searchEquity";

  $str = "";
  $sortBtns = "<div class='row'>
                  <div class='col-4 p-1'>
                    <form class='' method='GET' action='search.php'>
                      <input type='hidden' name='equity' value='$equity'>
                      <input type='hidden' name='sorting' value='plth'>
                      <input type='hidden' name='firstHome' value='$firstHome'>
                      <input type='hidden' name='city' value='$city'>
                      <button type='submit' name='sort' value='Sort' class='view-btn-o btn text-dark text-center py-0' style='font-size: 13px'>
                            Price<br> <span class='small'>Low to High</span>
                      </button>
                    </form>
                  </div>
                  <div class='col-4 p-1'>
                    <form class='' method='GET' action='search.php'>
                      <input type='hidden' name='equity' value='$equity'>
                      <input type='hidden' name='sorting' value='rhtl'>
                      <input type='hidden' name='firstHome' value='$firstHome'>
                      <input type='hidden' name='city' value='$city'>
                      <button type='submit' name='sort' value='Sort' class='view-btn-o btn text-dark text-center py-0' style='font-size: 13px'>
                            Annual<br> <span class='small'>High to Low</span>
                      </button>
                    </form>
                  </div>
                </div>";
  if (isset($_GET['sort'])){
    $sorting = $_GET['sorting'];
    $equity = $_GET['equity'];
    $firstHome = $_GET['firstHome'];
    $formattedEquity = number_format($equity);
    if($firstHome == "yes"){
      $searchEquity = $equity * 4;
      $mortgageEq = ((0.75 * $searchEquity)/100000)*400;
    }else{
      $searchEquity = $equity * 2;
      $mortgageEq = ((0.5 * $searchEquity)/100000)*400;
    }

    $formattedsearchEquity = number_format($searchEquity);
    $formattedMortgageEq = number_format($mortgageEq);


    $city = $_GET['city'];

    if($sorting == 'all'){
      if($equity != "" && $city != 'all' && $type != 'all'){
        $propSql = "SELECT * FROM property WHERE status = '1' AND propPrice <= :searchEquity AND propLocation =:city AND auctionType =:aucType";
        $propQuery = $con->prepare($propSql);
        $propQuery->bindParam(":searchEquity", $searchEquity);
        $propQuery->bindParam(":city", $city);
        $propQuery->bindParam(":aucType", $type);
      }
      if($city == 'all' && $type == 'all'){
        $propSql = "SELECT * FROM property WHERE status = '1' AND propPrice <= :searchEquity";
        $propQuery = $con->prepare($propSql);
        $propQuery->bindParam(":searchEquity", $searchEquity);
      }
      if($city == 'all' && $type != 'all'){
        $propSql = "SELECT * FROM property WHERE status = '1' AND propPrice <= :searchEquity AND auctionType =:aucType";
        $propQuery = $con->prepare($propSql);
        $propQuery->bindParam(":searchEquity", $searchEquity);
        $propQuery->bindParam(":aucType", $type);
      }
      if($type == 'all' && $city != 'all'){
        $propSql = "SELECT * FROM property WHERE status = '1' AND propPrice <= :searchEquity AND propLocation =:city";
        $propQuery = $con->prepare($propSql);
        $propQuery->bindParam(":searchEquity", $searchEquity);
        $propQuery->bindParam(":city", $city);
      }
    }
    if($sorting == 'phtl'){
      $sortText .= "Sorting by Price; High to Low";
      if($equity != "" && $city != ""){
        $propSql = "SELECT * FROM property WHERE status = '1' AND propPrice <= :searchEquity AND propLocation =:city ORDER BY propPrice DESC";
        $propQuery = $con->prepare($propSql);
        $propQuery->bindParam(":searchEquity", $searchEquity);
        $propQuery->bindParam(":city", $city);
      }
      if($city == ''){
        $propSql = "SELECT * FROM property WHERE status = '1' AND propPrice <= :searchEquity ORDER BY propPrice DESC";
        $propQuery = $con->prepare($propSql);
        $propQuery->bindParam(":searchEquity", $searchEquity);
      }
    }
    if($sorting == 'plth'){
      $sortBtns = "<div class='row'>
                      <div class='col-4 p-1'>
                        <form class='' method='GET' action='search.php'>
                          <input type='hidden' name='equity' value='$equity'>
                          <input type='hidden' name='sorting' value='plth'>
                          <input type='hidden' name='firstHome' value='$firstHome'>
                          <input type='hidden' name='city' value='$city'>
                          <button type='submit' name='sort' value='Sort' class='view-btn btn text-dark text-center py-0' style='font-size: 13px'>
                                Price<br> <span class='small'>Low to High</span>
                          </button>
                        </form>
                      </div>
                      <div class='col-4 p-1'>
                        <form class='' method='GET' action='search.php'>
                          <input type='hidden' name='equity' value='$equity'>
                          <input type='hidden' name='sorting' value='rhtl'>
                          <input type='hidden' name='firstHome' value='$firstHome'>
                          <input type='hidden' name='city' value='$city'>
                          <button type='submit' name='sort' value='Sort' class='view-btn-o btn text-dark text-center py-0' style='font-size: 13px'>
                                Annual<br> <span class='small'>High to Low</span>
                          </button>
                        </form>
                      </div>
                    </div>";

      if($equity != "" && $city != ""){
        $propSql = "SELECT * FROM property WHERE status = '1' AND propPrice <= :searchEquity AND propLocation =:city ORDER BY propPrice ASC";
        $propQuery = $con->prepare($propSql);
        $propQuery->bindParam(":searchEquity", $searchEquity);
        $propQuery->bindParam(":city", $city);
      }
      if($city == ''){
        $propSql = "SELECT * FROM property WHERE status = '1' AND propPrice <= :searchEquity ORDER BY propPrice ASC";
        $propQuery = $con->prepare($propSql);
        $propQuery->bindParam(":searchEquity", $searchEquity);
      }
    }
    if($sorting == 'rhtl'){
      $sortBtns = "<div class='row'>
                      <div class='col-4 p-1'>
                        <form class='' method='GET' action='search.php'>
                          <input type='hidden' name='equity' value='$equity'>
                          <input type='hidden' name='sorting' value='plth'>
                          <input type='hidden' name='firstHome' value='$firstHome'>
                          <input type='hidden' name='city' value='$city'>
                          <button type='submit' name='sort' value='Sort' class='view-btn-o btn text-dark text-center py-0' style='font-size: 13px'>
                                Price<br> <span class='small'>Low to High</span>
                          </button>
                        </form>
                      </div>
                      <div class='col-4 p-1'>
                        <form class='' method='GET' action='search.php'>
                          <input type='hidden' name='equity' value='$equity'>
                          <input type='hidden' name='sorting' value='rhtl'>
                          <input type='hidden' name='firstHome' value='$firstHome'>
                          <input type='hidden' name='city' value='$city'>
                          <button type='submit' name='sort' value='Sort' class='view-btn btn text-dark text-center py-0' style='font-size: 13px'>
                                Annual<br> <span class='small'>High to Low</span>
                          </button>
                        </form>
                      </div>
                    </div>";
      if($equity != "" && $city != ""){
        $propSql = "SELECT * FROM property WHERE status = '1' AND propPrice <= :searchEquity AND propLocation =:city ORDER BY annualReturns DESC";
        $propQuery = $con->prepare($propSql);
        $propQuery->bindParam(":searchEquity", $searchEquity);
        $propQuery->bindParam(":city", $city);
      }
      if($city == ''){
        $propSql = "SELECT * FROM property WHERE status = '1' AND propPrice <= :searchEquity ORDER BY annualReturns DESC";
        $propQuery = $con->prepare($propSql);
        $propQuery->bindParam(":searchEquity", $searchEquity);
      }
    }
    if($sorting == 'rlth'){
      $sortText .= "Sorting by Annual Returns; Low to High";
      if($equity != "" && $city != ""){
        $propSql = "SELECT * FROM property WHERE status = '1' AND propPrice <= :searchEquity AND propLocation =:city ORDER BY annualReturns ASC";
        $propQuery = $con->prepare($propSql);
        $propQuery->bindParam(":searchEquity", $searchEquity);
        $propQuery->bindParam(":city", $city);
      }
      if($city == ''){
        $propSql = "SELECT * FROM property WHERE status = '1' AND propPrice <= :searchEquity ORDER BY annualReturns ASC";
        $propQuery = $con->prepare($propSql);
        $propQuery->bindParam(":searchEquity", $searchEquity);
      }
    }

  }else{
    if (isset($_GET['citySearch'])){
      $equity = $_GET['equity'];
      $firstHome = $_GET['firstHome'];
      $formattedEquity = number_format($equity);
      $city = $_GET['city'];
      if($firstHome == "yes"){
        $searchEquity = $equity * 4;
        $mortgageEq = ((0.75 * $searchEquity)/100000)*400;
      }else{
        $searchEquity = $equity * 2;
        $mortgageEq = ((0.5 * $searchEquity)/100000)*400;
      }
      $formattedsearchEquity = number_format($searchEquity);
      $formattedMortgageEq = number_format($mortgageEq);

      if($city == ''){
        $propSql = "SELECT * FROM property WHERE status = '1' AND propPrice <= :searchEquity";
        $propQuery = $con->prepare($propSql);
        $propQuery->bindParam(":searchEquity", $searchEquity);
      }else{
        $propSql = "SELECT * FROM property WHERE status = '1' AND propPrice <= :searchEquity and propLocation = :city";
        $propQuery = $con->prepare($propSql);
        $propQuery->bindParam(":searchEquity", $searchEquity);
        $propQuery->bindParam(":city", $city);
      }

    }else{
      if($equity == ""){
        header("Location: index.php");
      }
      $propSql = "SELECT * FROM property WHERE status = '1' AND propPrice <= :searchEquity";
      $propQuery = $con->prepare($propSql);
      $propQuery->bindParam(":searchEquity", $searchEquity);
    }
  }
  $propQuery->execute();
  $count = $propQuery->rowCount();
  // echo $count;

  if($count > 0){
    while ($row = $propQuery->fetch(PDO::FETCH_ASSOC)){
      $propId = $row['id'];
      $propName = $row['propName'];
      $propDesc = $row['propDescription'];
      $propPrice = $row['propPrice'];
      $formattedpropPrice = number_format($propPrice);
      $annRet = $row['annualReturns'];
      $annRet = round($annRet, 2);
      $propType = $row['propertyType'];
      $status = $row['status'];
      if($firstHome == "yes"){
        $capital = 0.25 * $propPrice;
        $mortgage = ((0.75 * $propPrice)/100000)*400;
      }else{
        $capital = 0.5 * $propPrice;
        $mortgage = ((0.5 * $propPrice)/100000)*400;
      }
      $formattedCapital = number_format($capital);
      $formattedMortgage = number_format($mortgage);
      $primeImage = $row['imagePath'];
      $rentIncome = $row['rent_income'];
      $formattedrentIncome = number_format($rentIncome);
      $price_5_years_ago = $row['old_price'];
      $formattedprice_5_years_ago = number_format($price_5_years_ago);
      $return_on_capital = ((($rentIncome * 12)/$equity)*100);
      $return_on_capital = round($return_on_capital, 2);
      $propCondition = $row['propCondition'];



      // setting condion
      $condion_raised = '';
      if($propCondition == 'red'){
        $conditions_viewed = "<div class='col-11 mx-auto mb-sm-2'>
                                <div class='row'>
                                  <div class='col-4 text-center dot-1-a px-2'>
                                    <div class='box-poped-red'>
                                      <span class='dot dot-1'></span>
                                      <p class='mb-0'>Requires Renovation</p>
                                    </div>
                                  </div>
                                  <div class='col-4 text-center dot-2-a'>
                                    <span class='dot dot-2'></span>
                                    <p class='mb-0'>Good Condition</p>
                                  </div>
                                  <div class='col-4 text-center dot-3-a'>
                                    <span class='dot dot-3'></span>
                                    <p class='mb-0'>Fully Renovated</p>
                                  </div>
                                </div>
                              </div>";
      }elseif ($propCondition == 'yellow') {
        $conditions_viewed = "<div class='col-11 mx-auto mb-sm-2'>
                                <div class='row'>
                                  <div class='col-4 text-center dot-1-a'>
                                    <span class='dot dot-1'></span>
                                    <p class='mb-0'>Requires Renovation</p>
                                  </div>
                                  <div class='col-4 text-center dot-2-a px-2'>
                                    <div class='box-poped-yellow'>
                                      <span class='dot dot-2'></span>
                                      <p class='mb-0'>Good Condition</p>
                                    </div>
                                  </div>
                                  <div class='col-4 text-center dot-3-a'>
                                    <span class='dot dot-3'></span>
                                    <p class='mb-0'>Fully Renovated</p>
                                  </div>
                                </div>
                              </div>";
      }elseif ($propCondition == 'green') {
        $conditions_viewed = "<div class='col-11 mx-auto mb-sm-2'>
                                <div class='row'>
                                  <div class='col-4 text-center dot-1-a'>
                                    <span class='dot dot-1'></span>
                                    <p class='mb-0'>Requires Renovation</p>
                                  </div>
                                  <div class='col-4 text-center dot-2-a'>
                                    <span class='dot dot-2'></span>
                                    <p class='mb-0'>Good Condition</p>
                                  </div>
                                  <div class='col-4 text-center dot-3-a px-2'>
                                    <div class='box-poped-green'>
                                    <span class='dot dot-3'></span>
                                    <p class='mb-0'>Fully Renovated</p>
                                    </div>
                                  </div>
                                </div>
                              </div>";
      }else{
        $conditions_viewed = "<div class='col-11 mx-auto mb-sm-2'>
                                <div class='row'>
                                  <div class='col-4 text-center dot-1-a'>
                                    <span class='dot dot-1'></span>
                                    <p class='mb-0'>Requires Renovation<p>
                                  </div>
                                  <div class='col-4 text-center dot-2-a'>
                                    <span class='dot dot-2'></span>
                                    <p class='mb-0'>Good Condition<p>
                                  </div>
                                  <div class='col-4 text-center dot-3-a'>
                                    <span class='dot dot-3'></span>
                                    <p class='mb-0'>Fully Renovated<p>
                                  </div>
                                </div>
                              </div>";
      }

      // ================================== image Query ============================================
      // $photoQuery = $con->prepare("SELECT imgPath FROM propertyphoto WHERE propId = :id AND selected = '1'");
      // $photoQuery->bindParam(":id", $propId);
      // $photoQuery->execute();
      // if($count > 0){
      //   $row = $photoQuery->fetch(PDO::FETCH_ASSOC);
      //   $imagePath = $row['imgPath'];
      // } else{
      //   $imagePath = $primeImage;
      // }
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
                        <img src='dashboard/dist/$allImagePath' alt='' class='img-a img-fluid' style='height: 100%; width: 100%;'>
                      </div>";
        }
      } else{
        $allImagePath = $primeImage;
        $imgStr .= "<div class='carousel-item-b'>
                      <img src='dashboard/dist/$allImagePath' alt='' class='img-a img-fluid' style='height: 100%; width: 100%;'>
                    </div>";
      }

      // ==================================== Descriptiove Features query ========================================

      $descFeatQuery = $con->prepare("SELECT * FROM descfeatures WHERE propertyId = :propId");
      $descFeatQuery->bindParam(":propId", $propId);
      $descFeatQuery->execute();
      while ($row = $descFeatQuery->fetch(PDO::FETCH_ASSOC)){
        $area = $row['area'];
        $bedrooms = $row['bedrooms'];
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
        $strt = $row['street'];
        $neighbourhood = $row['neighbourhood'];
        $lng = $row['lng'];
        $lat = $row['lat'];

        $location = "$strt, $cities";
      }
      $priceperarea =( $propPrice/$area);
      $priceperarea = round($priceperarea, 2);

        $dots = (strlen($location) >= 15) ? "..." : "";
        $shortName = str_split($location, 15);
        $shortName = $shortName[0] . $dots;



      $str .= "<div class='col-md-6 col-11 mx-auto my-3 px-4'>
                <div class='row full-prop-card p-2'>
                  <div class='col-lg-6 p-0'>
                    <div class='card-box-a card-shadow p-0' style='height: 14rem;'>
                      <div class='img-box-a' style='height: 100%; width: 100%;'>
                        <div class='property-grid-carousel owl-carousel owl-arrow gallery-property'>
                          $imgStr
                        </div>
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
                          <div class='card-footer-a text-center'>
                            <ul class='card-info d-flex justify-content-around'>
                              <li>
                                <h4 class='card-info-title'>Area</h4>
                                <span>$area
                                  m<sup>2</sup>
                                </span>
                              </li>
                              <li>
                                <h4 class='card-info-title'>Beds</h4>
                                <span>$bedrooms</span>
                              </li>
                              <li>
                                <h4 class='card-info-title'>Balcony</h4>
                                <span class='text-capitalize'>$balcony</span>
                              </li>
                              <li>
                                <h4 class='card-info-title'>Parking</h4>
                                <span class='text-capitalize'>$parking</span>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class='row'>
                      $conditions_viewed
                    </div>
                  </div>
                  <div class='col-lg-6 pl-4'>
                    <div class='prop-card-side'>
                      <div class='row'>
                        <div class='col-md-10 mt-1'>
                          <h3>
                            <a href='property-single.php?propId=$propId' class='h5'>$shortName</a>
                          </h3>
                        </div>
                        <div class='col-md-2'>
                          <a href='javascript:void(0);' onclick='addToWatchList($propId, $equity, this)'>";
                          if(array_key_exists($propId, $_SESSION['watchlist'])){
                            $str .= "<i style='color: #26a356;' id='watchlistHeart$propId' class='fa fa-heart fa-2x'></i>";
                          }else{
                            $str .= "<i style='color: #26a356;' id='watchlistHeart-2$propId' class='fa fa-heart-o fa-2x'></i>";

                          }
        $str .=         "</a>
                        </div>
                      </div>
                      <div class='row'>
                        <div class='col-md-12'>
                          <span class='h3'>
                              $cur$formattedpropPrice
                          </span>
                          <span>
                            $cur$priceperarea per m<sup>2</sup>
                          </span>
                        </div>
                      </div>
                      <div class='row my-1'>
                        <div class='col-md-6 col-sm-12 p-1 text-center'>
                          <p class='m-0'>Annual Returns</p>
                          <div class='price-box w-100 d-flex' data-toggle='tooltip' data-placement='top' title='$annualreturnDesc'>
                            <span class='price-a text-dark text-center'> $annRet%</span>
                          </div>
                        </div>
                        <div class='col-md-6 col-sm-12 p-1 text-center'>
                          <p class='m-0'>Needed Equity</p>
                          <div class='price-box w-100 d-flex' data-toggle='tooltip' data-placement='top' title='$neededequityDesc'>
                            <span class='price-a text-dark text-center'>$cur$formattedCapital</span>
                          </div>
                        </div>
                        <div class='col-md-6 col-sm-12 p-1 text-center'>
                          <p class='m-0'>Mortgage</p>
                          <div class='price-box w-100 d-flex' data-toggle='tooltip' data-placement='top' title='$mortgageDesc'>
                            <span class='price-a text-dark text-center'>$cur$formattedMortgage</span>
                          </div>
                        </div>
                        <div class='col-md-6 col-sm-12 p-1 text-center'>
                          <p class='m-0'>Rent Income</p>
                          <div class='price-box w-100 d-flex' data-toggle='tooltip' data-placement='top' title='$rentincomeDesc'>
                            <span class='price-a text-dark text-center'>$cur$formattedrentIncome</span>
                          </div>
                        </div>
                      </div>
                      <div class='row'>
                        <div class='col-md-6 mt-1 text-center' style='font-size:13px'>
                          <p class='my-0'>Return on Capital - $return_on_capital%</p>
                          <p class='my-0'>Price 5 years ago - $cur$formattedprice_5_years_ago</p>
                        </div>
                        <div class='col-md-4 text-right col-6 h-100 ml-auto mt-auto'>
                          <a class='btn mb-0 view-btn' href='property-single.php?propId=$propId'>View Details</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>";
    }
  } else {
    $formattedCapital = "";
    $str .= '<div class="w-100 alert alert-danger" role="alert">
              No Properties Found!
            </div>';
  }
?>

<script type="text/javascript">
  $(document).ready(function(){
    $(".navbar-nav li .active").removeClass("active");
    $(".navbar-nav li .property").addClass("active");

    newPageTitle = 'SEARCH | KEPLER';
    document.title = newPageTitle;
  });

</script>
<style>
  #equity_field {
    margin-right:0;
    background: transparent;
    height:30px;
    width: 90%;
    /* border: none; */
    border: 2px solid #26a356;
    border-top-left-radius: 25px;
    border-bottom-left-radius: 25px;
  }
  #search_button {
    position:absolute;
    top:0;
    right:0;
    width:20%;
    height:30px;
    border-top-right-radius: 25px;
    border-bottom-right-radius: 25px;
  }
  #city_field {
    margin-right:0;
    top: 0;
    background: transparent;
    height:30px;
    width: 90%;
    /* border: none; */
    border: 2px solid #26a356;
    border-top-left-radius: 25px;
    border-bottom-left-radius: 25px;
  }
  #city_search_button {
    position:absolute;
    top:4;
    left: 40%;
    width:20%;
    height:30px;
    border-top-right-radius: 25px;
    border-bottom-right-radius: 25px;
  }


  input:focus {
      outline: none !important;
  }
  #city_search_wrapper {
    display: none;
    max-width: 300px;
  }
  @media (max-width: 625px) {
    #city_search_wrapper{
      font-size: .9rem;
    }
    #city_field{
      font-size: .9rem;
    }
    #city_search_button{
      font-size: .9rem;
    }
  }
  @media (max-width: 768px) {
    .top-section-slide {
      font-size: .9rem;
    }
    #equity_field{
      font-size: .9rem;
    }
    #equity_field{
      font-size: .9rem;
    }
  }
  .top-section-slide {
      font-size: 1rem;
  }
  #equity_field{
    font-size: 1rem;
  }
  #equity_field{
    font-size: 1rem;
  }

  .dot {
    height: 25px;
    width: 25px;
    border-radius: 50%;
    display: inline-block;
  }
  .dot-1{
    background-color: #EB0F0F;
  }
  .dot-1-a{
    border: none;
    border-right: 2px dotted #000;
    font-size: 10px;
  }
  .dot-1-b{
    border: none;
    font-size: 10px;
  }
  .dot-2{
    background-color: #F8D308;
  }
  .dot-2-a{
    border: none;
    border-right: 2px dotted #000;
    font-size: 10px;
  }
  .dot-2-b{
    border: none;
    font-size: 10px;
  }
  .dot-3{
    background-color: #13DA06;
  }
  .dot-3-a{
    border: none;
    font-size: 10px;
  }
  .box-poped-red{
    /* border: none !important; */
    padding: 5px;
    border-radius: 5px;
    border: 2px solid #EB0F0F;
    box-shadow: rgba(235, 15, 15,0.7) 2px 2px 4px;
  }
  .box-poped-yellow{
    /* border: none !important; */
    padding: 5px;
    border-radius: 5px;
    border: 2px solid #F8D308;
    box-shadow: rgba(235, 211, 8,0.7) 2px 2px 4px;
  }
  .box-poped-green{
    /* border: none !important; */
    padding: 5px;
    border-radius: 5px;
    border: 2px solid #13DA06;
    box-shadow: rgba(19, 218, 8,0.7) 2px 2px 4px;
  }
  .owl-arrow .owl-nav .owl-prev,
  .owl-arrow .owl-nav .owl-next {
    padding: .4rem 1rem !important;
    display: inline-block;
    transition: all 0.6s ease-in-out;
    color: #ffffff !important;
    background-color: #2eca6a !important;
    opacity: .9;
  }
  .owl-arrow .owl-nav .owl-next {
    margin-left: 0 !important;
  }

</style>
  <main id="main">
  <!-- ion slider -->
  <!-- calculator -->
  <div class='section-services section-t8'>
    <div class="container top-section-slide">
      <div class="row mb-5">
        <div class="col-md-8 mx-auto text-center">
          Here you can find the appartments you can buy and this calculator represents you transaction details according tou your own Equity
        </div>
        <div class="col-md-5 col-10 mx-auto">
          <div class="row">
            <div class="col-md-7 col-sm-9 mx-auto">
              <form class="form-a" method="GET" action="search.php">
                  <div class="row mt-2">
                      <div class="col-md-11 mx-auto">You have</div>
                      <div class="col-md-11 mx-auto">
                          <div class="form-group" id="search_wrapper">
                              <input type="hidden" name="firstHome" value="<?php echo $firstHome;?>">
                              <input type="text" id="equity_field" name="equity" class="form-control form-control-lg form-control-a" value="<?php echo "$equity";?>" placeholder="What is your equity?" style="text-align:center;">
                              <button type="submit" id="search_button" name="searchProperty" class="btn btn-b-n"><span class="fa fa-search" aria-hidden="true"></span></button>
                          </div>
                      </div>
                  </div>
              </form>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-md-8 mx-auto">
              <input id="range_6" type="text" name="range_6" value="">
            </div>
          </div>
          <div class="row display-sm-none">
            <div class='col-md-4 p-1 col-sm-6'>
              <div class='price-box w-100 d-flex'>
                <span class='price-a text-dark text-center' id='equity_box'><?php echo "$cur$formattedsearchEquity";?></span>
              </div>
              <p class='m-0'>Price</p>
            </div>
            <div class='col-md-4 p-1 col-sm-6'>
              <div class='price-box w-100 d-flex'>
                <span class='price-a text-dark text-center' id='mortgage_box'><?php echo "$cur$formattedMortgageEq";?></span>
              </div>
              <p class='m-0'>Mortgage</p>
            </div>
            <div class='col-md-4 p-1 col-sm-12'>
              <div class='price-box w-100 d-flex'>
                <span class='price-a text-dark text-center' id='rent_inc_box'><?php echo "$cur$formattedrentIncomeEq";?></span>
              </div>
              <p class='m-0'>Rent Income</p>
            </div>
          </div>
        </div>
    </div>
  </div>
  <!-- end ion slider -->

    <!-- ======= Property Grid ======= -->
    <section class="property-grid grid mt-3">
      <div class="mx-5">
        <div class="row my-3">
          <div class="col-6">
            <div class="row">
              <div class="text-left p-1 mr-3">
                <div class="form-group hide" id="city_search_wrapper">
                  <form action="search.php" method="GET">
                    <input type="text" id="city_field" name="city" class="form-control form-control-lg form-control-a" value="" placeholder="Enter City">
                    <button type="submit" id="city_search_button" name="citySearch" value="citySearch" class="btn btn-b-n"><span class="fa fa-search" aria-hidden="true"></span></button>
                    <input type="hidden" name="equity" value="<?php echo $equity;?>">
                    <input type="hidden" name="firstHome" value="<?php echo $firstHome;?>">
                    <a href="" id="close_city"><i class="fa fa-times-circle"></i></a>
                  </form>
                </div>
                <a class='btn mb-0 view-btn text-light' id="city_button" href=''><i class='fa fa-search mr-2'></i>City</a>
              </div>
              <div class="col-7">
                <?php echo $sortBtns; ?>
              </div>
            </div>
          </div>
          <div class="col-6 text-right">
            <div class="row">
              <div class="col-12">
                <div class="grid-option">
                  <a class='btn mb-0 view-btn text-light' href="watchlist.php">
                    <?php
                        if(count($_SESSION['watchlist'])>0){
                            echo  '<span>Watchlist(<span class="watchlist_count">'. count($_SESSION['watchlist']) .'</span>)</span>';
                        } else {
                          echo  '<span>Watchlist(<span class="watchlist_count">'. 0 .'</span>)</span>';
                        }
                    ?>
                    <i class='fa fa-heart mr-1'></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <?php echo $str; ?>
        </div>
        <div class="row">
          <div class="col-sm-12">

          </div>
        </div>
      </div>
    </section>
    <!-- End Property Grid Single-->

  </main><!-- End #main -->
  <script>
    var equity;
    var currency;
    equity = parseInt(equity);
    console.log(equity);

  $(function () {


    $('[data-toggle="tooltip"]').tooltip();

    $("#city_button").on('click', function(e) {
      e.preventDefault();
      console.log(e);
      $("#city_button").hide(500);
      $("#city_search_wrapper").show(1000);
    });
    $("#close_city").on('click', function(e) {
      e.preventDefault();
      console.log(e);
      $("#city_search_wrapper").hide(500);
      $("#city_button").show(500);
    });

    $('#range_6').ionRangeSlider({
      min     : 0,
      max     : 2000000,
      skin    : "round",
      from    : equity,
      type    : 'single',
      step    : 1,
      prefix  : '$',
      prettify: false,
      hasGrid : true,
      onChange: function (e) {
          var new_equity = e.from;

          function getRentincomeEq(new_equity){
            if( 375000 < new_equity && new_equity < 550001){
              rent_inc = 2050;
            }else if (550000 < new_equity && new_equity < 670001) {
              rent_inc = 2550;
            }else if (670000 < new_equity && new_equity < 810001) {
              rent_inc = 3020;
            }else if (810000 < new_equity && new_equity < 1000001) {
              rent_inc = 3550;
            }else if (1000000 < new_equity && new_equity < 1300001) {
              rent_inc = 4020;
            }else if (1300000 < new_equity && new_equity < 1600001) {
              rent_inc = 4550;
            }else if (1600000 < new_equity && new_equity < 1800001) {
              rent_inc = 4800;
            }else if (1800000 < new_equity && new_equity < 2000001) {
              rent_inc = 5500;
            }else if (2000000 < new_equity && new_equity < 2400001) {
              rent_inc = 6420;
            }else if (2400000 < new_equity && new_equity < 2700001) {
              rent_inc = 6900;
            }else if (2700000 < new_equity && new_equity < 3100001) {
              rent_inc = 7300;
            }else if (new_equity > 3100000) {
              rent_inc = 7400;
            }else{
              rent_inc = 2000;
            }

            return rent_inc;
          }

          $("#equity_field").val(new_equity);

          if(firstHome == 'no'){
              new_search_equity = new_equity * 2;
              new_mortgage = ((0.5 * new_search_equity)/100000)*400;
          }else{
              new_search_equity = new_equity * 4;
              new_mortgage = ((0.75 * new_search_equity)/100000)*400;
          }

          console.log(new_mortgage)
          var new_rent_inc = getRentincomeEq(new_search_equity);

          new_search_equity = new Intl.NumberFormat('ja-JP').format(new_search_equity);
          $("#equity_box").html(currency + new_search_equity);

          new_mortgage = new Intl.NumberFormat('ja-JP').format(new_mortgage);
          $("#mortgage_box").html(currency + new_mortgage);

          new_rent_inc = new Intl.NumberFormat('ja-JP').format(new_rent_inc);
          $("#rent_inc_box").html(currency + new_rent_inc);

          console.log(e.from);
          var t = ''
          for (var prop in e) {
            t += prop + ': ' + e[prop] + '\r\n'
          }
          $('#result').html(t)
        },
        onLoad  : function (e) {
          //
        }
    })
  })
</script>
<?php
  include("includes/footer.php");
?>
