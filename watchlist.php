<?php
  include("includes/header.php");
  include("pagination/function.php");

  if(count($_SESSION['watchlist'])>0){
    $str = "";
     foreach($_SESSION['watchlist'] as $arrayId=>$value){
       $sortBtns = "<div class='row'>
                       <div class='col-6 p-1'>
                         <form class='' method='GET' action='watchlist.php'>
                           <input type='hidden' name='sorting' value='plth'>
                           <button type='submit' name='sort' value='Sort' class='view-btn-o btn text-dark text-center' style='font-size: 13px'>
                                 Price: <span class='small'>Low to High</span>
                           </button>
                         </form>
                       </div>
                       <div class='col-6 p-1'>
                         <form class='' method='GET' action='watchlist.php'>
                           <input type='hidden' name='sorting' value='rhtl'>
                           <button type='submit' name='sort' value='Sort' class='view-btn-o btn text-dark text-center' style='font-size: 13px'>
                               Annual: <span class='small'>High to Low</span>
                           </button>
                         </form>
                       </div>
                     </div>";
       if (isset($_GET['sort'])){
         $sorting = $_GET['sorting'];
         if($sorting == 'plth'){
           $sortBtns = "<div class='row'>
                           <div class='col-6 p-1'>
                             <form class='' method='GET' action='watchlist.php'>
                              <input type='hidden' name='sorting' value='plth'>
                               <button type='submit' name='sort' value='Sort' class='view-btn btn text-dark text-center' style='font-size: 13px'>
                                     Price: <span class='small'>Low to High</span>
                               </button>
                             </form>
                           </div>
                           <div class='col-6 p-1'>
                             <form class='' method='GET' action='watchlist.php'>
                               <input type='hidden' name='sorting' value='rhtl'>
                               <button type='submit' name='sort' value='Sort' class='view-btn-o btn text-dark text-center' style='font-size: 13px'>
                                     Annual: <span class='small'>High to Low</span>
                               </button>
                             </form>
                           </div>
                         </div>";
           $propSql = "SELECT * FROM property WHERE id = :id ORDER BY propPrice ASC";
           $propQuery = $con->prepare($propSql);
           $propQuery->bindParam(":id", $arrayId);

         }
         if($sorting == 'rhtl'){
           $sortBtns = "<div class='row'>
                           <div class='col-6 p-1'>
                             <form class='' method='GET' action='watchlist.php'>
                              <input type='hidden' name='sorting' value='plth'>
                               <button type='submit' name='sort' value='Sort' class='view-btn-o btn text-dark text-center' style='font-size: 13px'>
                                     Price: <span class='small'>Low to High</span>
                               </button>
                             </form>
                           </div>
                           <div class='col-6 p-1'>
                             <form class='' method='GET' action='watchlist.php'>
                               <input type='hidden' name='sorting' value='rhtl'>
                               <button type='submit' name='sort' value='Sort' class='view-btn btn text-dark text-center' style='font-size: 13px'>
                                     Annual: <span class='small'>High to Low</span>
                               </button>
                             </form>
                           </div>
                         </div>";
           $propSql = "SELECT * FROM property WHERE id = :id ORDER BY annualReturns DESC";
           $propQuery = $con->prepare($propSql);
           $propQuery->bindParam(":id", $arrayId);

         }
       }else{
         $propSql = "SELECT * FROM property WHERE id = :id";
         $propQuery = $con->prepare($propSql);
         $propQuery->bindParam(":id", $arrayId);
       }
       $propQuery->execute();
       $count = $propQuery->rowCount();
       // echo $count;

           $row = $propQuery->fetch(PDO::FETCH_ASSOC);
           $propId = $row['id'];
           $propName = $row['propName'];
           $propDesc = $row['propDescription'];
           $propPrice = $row['propPrice'];
           $formattedpropPrice = number_format($propPrice);
           $annRet = $row['annualReturns'];
           $annRet = round($annRet, 2);
           $propType = $row['propertyType'];
           $status = $row['status'];
           $capital = 0.25 * $propPrice;
           $mortgage = ((0.75 * $propPrice)/100000)*400;
           $formattedCapital = number_format($capital);
           $formattedMortgage = number_format($mortgage);
           $primeImage = $row['imagePath'];
           $rentIncome = $row['rent_income'];
           $formattedrentIncome = number_format($rentIncome);
           $price_5_years_ago = $row['old_price'];
           $formattedprice_5_years_ago = number_format($price_5_years_ago);
           $return_on_capital = (((12 * $rentIncome)/$propPrice)*100);
           $return_on_capital = round($return_on_capital, 2);
           $propCondition = $row['propCondition'];

           $dots = (strlen($propName) >= 15) ? "..." : "";
           $shortName = str_split($propName, 15);
           $shortName = $shortName[0] . $dots;

           // setting condion
           $condion_raised = '';
           if($propCondition == 'red'){
             $conditions_viewed = "<div class='col-11 mx-auto mb-sm-2'>
                                     <div class='row'>
                                       <div class='col-4 text-center dot-1-a box-poped-red'>
                                         <span class='dot dot-1'></span>
                                         <p>Requires Renovation<p>
                                       </div>
                                       <div class='col-4 text-center dot-2-a'>
                                         <span class='dot dot-2'></span>
                                         <p>Good Condition<p>
                                       </div>
                                       <div class='col-4 text-center dot-3-a'>
                                         <span class='dot dot-3'></span>
                                         <p>Fully Renovated<p>
                                       </div>
                                     </div>
                                   </div>";
           }elseif ($propCondition == 'yellow') {
             $conditions_viewed = "<div class='col-11 mx-auto mb-sm-2'>
                                     <div class='row'>
                                       <div class='col-4 text-center dot-1-a'>
                                         <span class='dot dot-1'></span>
                                         <p>Requires Renovation<p>
                                       </div>
                                       <div class='col-4 text-center dot-2-a box-poped-yellow'>
                                         <span class='dot dot-2'></span>
                                         <p>Good Condition<p>
                                       </div>
                                       <div class='col-4 text-center dot-3-a'>
                                         <span class='dot dot-3'></span>
                                         <p>Fully Renovated<p>
                                       </div>
                                     </div>
                                   </div>";
           }elseif ($propCondition == 'green') {
             $conditions_viewed = "<div class='col-11 mx-auto mb-sm-2'>
                                     <div class='row'>
                                       <div class='col-4 text-center dot-1-a'>
                                         <span class='dot dot-1'></span>
                                         <p>Requires Renovation<p>
                                       </div>
                                       <div class='col-4 text-center dot-2-a'>
                                         <span class='dot dot-2'></span>
                                         <p>Good Condition<p>
                                       </div>
                                       <div class='col-4 text-center dot-3-a box-poped-green'>
                                         <span class='dot dot-3'></span>
                                         <p>Fully Renovated<p>
                                       </div>
                                     </div>
                                   </div>";
           }else{
             $conditions_viewed = "<div class='col-11 mx-auto mb-sm-2'>
                                     <div class='row'>
                                       <div class='col-4 text-center dot-1-a'>
                                         <span class='dot dot-1'></span>
                                         <p>Requires Renovation<p>
                                       </div>
                                       <div class='col-4 text-center dot-2-a'>
                                         <span class='dot dot-2'></span>
                                         <p>Good Condition<p>
                                       </div>
                                       <div class='col-4 text-center dot-3-a'>
                                         <span class='dot dot-3'></span>
                                         <p>Fully Renovated<p>
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



           $str .= "<div class='col-md-6 col-11 mx-auto my-2'>
                     <div class='row full-prop-card p-3'>
                       <div class='col-lg-5 p-0'>
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
                                     <span>$area m
                                       <sup>2</sup>
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
                       <div class='col-lg-7'>
                         <div class='prop-card-side'>
                           <div class='row'>
                             <div class='col-md-10 mt-1'>
                               <h3>
                                 <a href='property-single.php?propId=$propId' class='h5'>$location</a>
                               </h3>
                             </div>
                             <div class='col-md-2'>
                               <a href='remove_from_watchlist.php?code={$arrayId}'>
                                  <i style='color: #EB0F0F;' id='watchlistHeart$propId' class='fa fa-trash fa-2x'></i>
                               </a>
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
                             <div class='col-md-6 col-sm-12 p-1'>
                               <p class='m-0'>Annual Returns</p>
                               <div class='price-box w-100 d-flex' data-toggle='tooltip' data-placement='top' title='input description!'>
                                 <span class='price-a text-dark text-center'> $annRet%</span>
                               </div>
                             </div>
                             <div class='col-md-6 col-sm-12 p-1'>
                               <p class='m-0'>Needed Equity</p>
                               <div class='price-box w-100 d-flex' data-toggle='tooltip' data-placement='top' title='input description!'>
                                 <span class='price-a text-dark text-center'>$cur$formattedCapital</span>
                               </div>
                             </div>
                             <div class='col-md-6 col-sm-12 p-1'>
                               <p class='m-0'>Mortgage</p>
                               <div class='price-box w-100 d-flex' data-toggle='tooltip' data-placement='top' title='input description!'>
                                 <span class='price-a text-dark text-center'>$cur$formattedMortgage</span>
                               </div>
                             </div>
                             <div class='col-md-6 col-sm-12 p-1'>
                               <p class='m-0'>Rent Income</p>
                               <div class='price-box w-100 d-flex' data-toggle='tooltip' data-placement='top' title='input description!'>
                                 <span class='price-a text-dark text-center'>$cur$formattedrentIncome</span>
                               </div>
                             </div>
                           </div>
                           <div class='row'>
                             <div class='col-md-9 col-6 mt-1'>
                               <p>Return on Capital - $return_on_capital%</p>
                               <p>Price 5 years ago - $cur $formattedprice_5_years_ago</p>
                             </div>
                             <div class='col-md-3 col-6 text-right h-100'>
                               <a class='btn mb-0 view-btn' href='property-single.php?propId=$propId'>View Details</a>
                             </div>
                           </div>
                         </div>
                       </div>
                     </div>
                   </div>";
     }
   }else {
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

    newPageTitle = 'WATCHLIST | KEPLER';
    document.title = newPageTitle;
  });

</script>
<style>

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
  .dot-2{
    background-color: #F8D308;
  }
  .dot-2-a{
    border: none;
    border-right: 2px dotted #000;
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
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #EB0F0F;
    box-shadow: rgba(235, 15, 15,0.7) 2px 2px 4px;
  }
  .box-poped-yellow{
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #F8D308;
    box-shadow: rgba(235, 211, 8,0.7) 2px 2px 4px;
  }
  .box-poped-green{
    padding: 5px;
    border-radius: 5px;
    border: 1px solid #13DA06;
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
  <!-- ======= Intro Single ======= -->
  <section class="intro-single">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-lg-8">
          <div class="title-single-box">
            <h1 class="title-single">Your Watchlist</h1>
          </div>
        </div>
        <div class="col-md-12 col-lg-4">
          <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
            <ol class="breadcrumb">
              <li class="breadcrumb-item">
                <a href="index.php">Home</a>
              </li>
              <li class="breadcrumb-item active" aria-current="page">
                Watchlist
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </section><!-- End Intro Single-->

    <!-- ======= Property Grid ======= -->
    <section class="property-grid grid mt-3">
      <div class="container">
        <div class="row my-3">
          <div class="col-6">
            <div class="row">
              <div class="col-7">
                <?php echo $sortBtns; ?>
              </div>
            </div>
          </div>
          <div class="col-6 text-right">
            <div class="row">
              <div class="col-12">
                <div class="grid-option">
                  <a class='btn mb-0 view-btn text-light' href="javascript:void(0);">
                    <?php
                        if(count($_SESSION['watchlist'])>0){
                            echo  '<span>Watchlist('. count($_SESSION['watchlist']) .')</span>';
                        } else {
                          echo  '<span>Watchlist('. 0 .')</span>';
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

    $(function () {

      $('[data-toggle="tooltip"]').tooltip();

    })
</script>
<?php
  include("includes/footer.php");
?>
