<?php
  include("includes/header.php");
  $str = "";
  $propQuery = $con->prepare("SELECT * FROM property WHERE status = '1' ORDER BY rand() LIMIT 4");
  $propQuery->execute();

  $fullPropQuery = $con->prepare("SELECT * FROM property WHERE status = '1' ORDER BY rand()");
  $fullPropQuery->execute();
  $propertyCount = $fullPropQuery->rowCount();
  // echo $count;

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
    $capital = 0.25 * $propPrice;
    $formattedCapital = number_format($capital);
    $mortgage = (0.75 * $propPrice)/300;
    $formattedMortgage = number_format($mortgage);
    $primeImage = $row['imagePath'];
    $annRet = "<p class='intro-title-top text-light'>$annRet<span>%</span><br>Annual Returns</p>";


    $dots = (strlen($propName) >= 15) ? "..." : "";
    $shortName = str_split($propName, 15);
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

    $str .= "<div class='carousel-item-b'>
              <div class='card-box-a card-shadow' style='height: 25rem;'>
                <div class='img-box-a' style='height: 100%;'>
                  <img src='dashboard/dist/$imagePath' alt='' class='img-a img-fluid' style='height: 100%;'>
                </div>
                <div class='card-overlay'>
                  <div class='card-overlay-a-content'>
                    <div class='card-header-a'>
                      <h3 class='card-title-a'>
                        <a href='#'>$shortName <br>
                          <a/>$location</a>
                      </h3>
                    </div>
                    <div class='card-body-a'>
                      $annRet
                      <div class='price-box d-flex'>
                          <span class='price-a'>  | $cur$formattedpropPrice</span>
                        </div>

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
                          <h4 class='card-info-title'>Sell Price</h4>
                        </li>
                        <li>
                          <h4 class='card-info-title'>Mortgage</h4>
                          <span>$cur$formattedMortgage</span>
                        </li>
                      </ul>
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
    $(".navbar-nav li .home").addClass("active");

    newPageTitle = 'HOME | KEPLER';
    document.title = newPageTitle;
  });
  $(".navbar-brand").hide();

</script>
<style>
    #search_field {
      margin-right:0;
      background: #ffffff;
      height:40px;
      width: 90%;
      border-top-left-radius: 25px;
      border-bottom-left-radius: 25px;
    }

    #search_button {
        position:absolute;
        top:0;
        right:0;
        width:15%;
        height:40px;
        border-top-right-radius: 25px;
        border-bottom-right-radius: 25px;
    }
    input:focus {
        outline: none !important;
    }
</style>

<div class="intro">
  <div class="carousel-item-a intro-item bg-image" style="background-image: url(assets/img/slide-1.jpg)">
    <div class="overlay overlay-a"></div>
    <div class="intro-content display-table">
      <div class="table-cell">
        <div class="container">
          <div class="row">
            <div class="col-md-12 text-center">
              <a class="title-logo text-light" href="index.php">Kep<span class="color-b">ler.</span></a>
              <p class="title-logo-b">How much & Where & How</p>
            </div>
            <div class="col-lg-12 text-center">
              <div class="intro-body">
                <div class="intro-title">
                  <div class="container">
                    <div class="column2 mt-1">
                      <div class='row'>
                        <div class="col-md-12 text-center">
                          <form class="form-a text-center" method="GET" action="search.php">
                            <div class="row">
                                <div class="col-md-5 mx-auto">
                                    <div class="form-group" id="search_wrapper">
                                        <input type="text" id="search_field" name="equity" class="form-control form-control-lg form-control-a" placeholder="What is your equity?">
                                        <button type="submit" id="search_button" name="searchProperty" class="btn btn-b-n" id='searchBtn'><span class="fa fa-search" aria-hidden="true"></span></button>
                                    </div>
                                    <p class='text-center'>
                                      <span class='mr-4'>Your first home? </span>
                                      <span class='mr-4'>
                                        <input class="form-check-input" type="radio" checked name="firstHome" id="yes" value="yes">
                                        <label class="form-check-label" for="yes">
                                          Yes
                                        </label>
                                      </span>
                                      <span class=''>
                                        <input class="form-check-input" type="radio" name="firstHome" id="no" value="no">
                                        <label class="form-check-label" for="no">
                                          No
                                        </label>
                                      </span>
                                    </p>
                                </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <!-- ======= Intro Section ======= -->
  <!-- <div class="intro intro-carousel">
    <div id="carousel" class="owl-carousel owl-theme">
      <div class="carousel-item-a intro-item bg-image" style="background-image: url(assets/img/slide-1.jpg)">
        <div class="overlay overlay-a"></div>
        <div class="intro-content display-table">
          <div class="table-cell">
            <div class="container">
              <div class="row">
                <div class="col-lg-8">
                  <div class="intro-body">
                    <br><br>
                    <div class="column intro-title text-dark">
                      <p class="">
                        <sup><i class='fa fa-quote-left fa-2x'></i></sup>
                        Sed porttitor lectus nibh. Cras ultricies ligula
                        sed magna dictum porta. Praesent sapien massa,
                        convallis a pellentesque nec, egestas non nisi.
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item-a intro-item bg-image" style="background-image: url(assets/img/slide-2.jpg)">
        <div class="overlay overlay-a"></div>
        <div class="intro-content display-table">
          <div class="table-cell">
            <div class="container">
              <div class="row">
                <div class="col-lg-8">
                  <div class="intro-body">
                    <br><br>
                    <div class="column intro-title text-dark">
                      <p class="">
                        <sup><i class='fa fa-quote-left fa-2x'></i></sup>
                          Sed porttitor lectus nibh. Cras ultricies ligula
                          sed magna dictum porta. Praesent sapien massa,
                          convallis a pellentesque nec, egestas non nisi.
                        </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item-a intro-item bg-image" style="background-image: url(assets/img/slide-3.jpg)">
        <div class="overlay overlay-a"></div>
        <div class="intro-content display-table">
          <div class="table-cell">
            <div class="container">
              <div class="row">
                <div class="col-lg-8">
                  <div class="intro-body">
                    <br><br>
                    <div class="column intro-title text-dark">
                      <p class="">
                        <sup><i class='fa fa-quote-left fa-2x'></i></sup>
                          Sed porttitor lectus nibh. Cras ultricies ligula
                          sed magna dictum porta. Praesent sapien massa,
                          convallis a pellentesque nec, egestas non nisi.
                        </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <!-- End Intro Section -->

  <main id="main">
    <!-- ======= Search Box Section ============ -->
    <?php
    // include("includes/searchbox.php");
    ?>
    <!-- End of Search Box Section -->

    <!-- ======= Count up Section ============ -->
    <!-- <section class="counts section-t8">
      <div class="container">

        <div class="row no-gutters">

          <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <i class="icofont-simple-smile"></i>
              <span data-toggle="counter-up">232</span>
              <p><strong>Happy Clients</strong> consequuntur quae qui deca rode</p>
              <a href="blog-grid.php">Find out more »</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <i class="icofont-home"></i>
              <span data-toggle="counter-up"><?php echo $propertyCount; ?></span>
              <p><strong>Properties</strong> adipisci atque cum quia aut numquam delectus</p>
              <a href="property.php">Find out more »</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <i class="icofont-blogger"></i>
              <span data-toggle="counter-up">1,463</span>
              <p><strong>Blog Posts</strong> aut commodi quaerat. Aliquam ratione</p>
              <a href="blog-grid.php">Find out more »</a>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 d-md-flex align-items-md-stretch">
            <div class="count-box">
              <i class="icofont-users-alt-5"></i>
              <span data-toggle="counter-up">15</span>
              <p><strong>Agents</strong> rerum asperiores dolor molestiae doloribu</p>
              <a href="agents-grid.php">Find out more »</a>
            </div>
          </div>

        </div>

      </div>
    </section> -->
    <!-- End of Count up Section -->

    <!-- ======= Our Services Section ======= -->
    <?php
      $str1 = "";
      $homeServiceSql = "SELECT * FROM services ORDER BY id ASC";
      $homeServiceQuery = $con->prepare($homeServiceSql);
      $homeServiceQuery->execute();
      $count = $homeServiceQuery->rowCount();
      // echo $count;

      while ($row = $homeServiceQuery->fetch(PDO::FETCH_ASSOC)){
          $serviceId = $row['id'];
          $description = $row['description'];
          $title = $row['title'];
          $iconfont = $row['iconfont'];

          $dots = (strlen($description) >= 75) ? "..." : "";
          $shortDesc = str_split($description, 73);
          $shortDesc = $shortDesc[0] . $dots;

          echo "<script>descId = '$serviceId';</script>";

          $str1 .= "<div class='col-md-6 col-lg-3 d-flex align-items-stretch mx-auto mb-5 mb-lg-0'>
                      <div class='icon-box'>
                          <div class='icon'>
                              <i class='bx $iconfont'></i>
                          </div>
                          <h4 class='title'>
                              <a href=''>$title</a>
                          </h4>
                          <p class='description' id='shortDescId$serviceId'>
                            $shortDesc
                          </p>
                          <p class='description hidden' id='fullDescId$serviceId'>
                            $description
                          </p>
                          <a class='link-c link-icon' onclick='learnMore(shortDescId$serviceId, fullDescId$serviceId, this)' id='learnMoreId$serviceId'>Read more
                              <span class='ion-ios-arrow-forward'></span>
                          </a>
                      </div>
                  </div>";

        }
    ?>
    <section id="services" class="services section-t8">
      <div class="container">
      <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">Our Services</h2>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <?php echo $str1;?>
        </div>

      </div>
    </section>
    <!-- End Our Services Section -->

    <!-- ======= Latest Properties Section ======= -->
    <!-- <section class="section-property section-t8">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">Latest Properties</h2>
              </div>
              <div class="title-link">
                <a href="property.php">All Property
                  <span class="ion-ios-arrow-forward"></span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div id="property-carousel" class="owl-carousel owl-theme">
          <?php echo $str; ?>
        </div>
      </div>
    </section> -->
    <!-- End Latest Properties Section -->

    <!-- ======= Cta Section ======= -->
    <!-- <div class='section-t8'></div>
    <section class="cta">
      <div class="container">

        <div class="text-center">
          <h3>Call To Action</h3>
          <p> Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          <a class="cta-btn" href="dashboard/dist/register.php">Become an Agent</a>
        </div>

      </div>
    </section> -->
    <!-- End Cta Section -->

    <!-- ======= Agents Section ======= -->
    <!-- <section class="section-agents section-t8">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">Best Agents</h2>
              </div>
              <div class="title-link">
                <a href="agents-grid.php">All Agents
                  <span class="ion-ios-arrow-forward"></span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="card-box-d">
              <div class="card-img-d">
                <img src="assets/img/agent-4.jpg" alt="" class="img-d img-fluid">
              </div>
              <div class="card-overlay card-overlay-hover">
                <div class="card-header-d">
                  <div class="card-title-d align-self-center">
                    <h3 class="title-d">
                      <a href="agent-single.php" class="link-two">Margaret Sotillo
                        <br> Escala</a>
                    </h3>
                  </div>
                </div>
                <div class="card-body-d">
                  <p class="content-d color-text-a">
                    Sed porttitor lectus nibh, Cras ultricies ligula sed magna dictum porta two.
                  </p>
                  <div class="info-agents color-a">
                    <p>
                      <strong>Phone: </strong> +54 356 945234</p>
                    <p>
                      <strong>Email: </strong> agents@example.com</p>
                  </div>
                </div>
                <div class="card-footer-d">
                  <div class="socials-footer d-flex justify-content-center">
                    <ul class="list-inline">
                      <li class="list-inline-item">
                        <a href="#" class="link-one">
                          <i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="#" class="link-one">
                          <i class="fa fa-twitter" aria-hidden="true"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="#" class="link-one">
                          <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="#" class="link-one">
                          <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="#" class="link-one">
                          <i class="fa fa-dribbble" aria-hidden="true"></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card-box-d">
              <div class="card-img-d">
                <img src="assets/img/agent-1.jpg" alt="" class="img-d img-fluid">
              </div>
              <div class="card-overlay card-overlay-hover">
                <div class="card-header-d">
                  <div class="card-title-d align-self-center">
                    <h3 class="title-d">
                      <a href="agent-single.php" class="link-two">Stiven Spilver
                        <br> Darw</a>
                    </h3>
                  </div>
                </div>
                <div class="card-body-d">
                  <p class="content-d color-text-a">
                    Sed porttitor lectus nibh, Cras ultricies ligula sed magna dictum porta two.
                  </p>
                  <div class="info-agents color-a">
                    <p>
                      <strong>Phone: </strong> +54 356 945234</p>
                    <p>
                      <strong>Email: </strong> agents@example.com</p>
                  </div>
                </div>
                <div class="card-footer-d">
                  <div class="socials-footer d-flex justify-content-center">
                    <ul class="list-inline">
                      <li class="list-inline-item">
                        <a href="#" class="link-one">
                          <i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="#" class="link-one">
                          <i class="fa fa-twitter" aria-hidden="true"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="#" class="link-one">
                          <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="#" class="link-one">
                          <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="#" class="link-one">
                          <i class="fa fa-dribbble" aria-hidden="true"></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card-box-d">
              <div class="card-img-d">
                <img src="assets/img/agent-5.jpg" alt="" class="img-d img-fluid">
              </div>
              <div class="card-overlay card-overlay-hover">
                <div class="card-header-d">
                  <div class="card-title-d align-self-center">
                    <h3 class="title-d">
                      <a href="agent-single.php" class="link-two">Emma Toledo
                        <br> Cascada</a>
                    </h3>
                  </div>
                </div>
                <div class="card-body-d">
                  <p class="content-d color-text-a">
                    Sed porttitor lectus nibh, Cras ultricies ligula sed magna dictum porta two.
                  </p>
                  <div class="info-agents color-a">
                    <p>
                      <strong>Phone: </strong> +54 356 945234</p>
                    <p>
                      <strong>Email: </strong> agents@example.com</p>
                  </div>
                </div>
                <div class="card-footer-d">
                  <div class="socials-footer d-flex justify-content-center">
                    <ul class="list-inline">
                      <li class="list-inline-item">
                        <a href="#" class="link-one">
                          <i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="#" class="link-one">
                          <i class="fa fa-twitter" aria-hidden="true"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="#" class="link-one">
                          <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="#" class="link-one">
                          <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                        </a>
                      </li>
                      <li class="list-inline-item">
                        <a href="#" class="link-one">
                          <i class="fa fa-dribbble" aria-hidden="true"></i>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->
    <!-- End Agents Section -->

    <!-- ======= Latest News Section ======= -->
    <!-- <section class="section-news section-t8">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">Latest News</h2>
              </div>
              <div class="title-link">
                <a href="blog-grid.php">All News
                  <span class="ion-ios-arrow-forward"></span>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div id="new-carousel" class="owl-carousel owl-theme">
          <div class="carousel-item-c">
            <div class="card-box-b card-shadow news-box">
              <div class="img-box-b">
                <img src="assets/img/post-2.jpg" alt="" class="img-b img-fluid">
              </div>
              <div class="card-overlay">
                <div class="card-header-b">
                  <div class="card-category-b">
                    <a href="#" class="category-b">House</a>
                  </div>
                  <div class="card-title-b">
                    <h2 class="title-2">
                      <a href="blog-single.php">House is comming
                        <br> new</a>
                    </h2>
                  </div>
                  <div class="card-date">
                    <span class="date-b">18 Sep. 2017</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item-c">
            <div class="card-box-b card-shadow news-box">
              <div class="img-box-b">
                <img src="assets/img/post-5.jpg" alt="" class="img-b img-fluid">
              </div>
              <div class="card-overlay">
                <div class="card-header-b">
                  <div class="card-category-b">
                    <a href="#" class="category-b">Travel</a>
                  </div>
                  <div class="card-title-b">
                    <h2 class="title-2">
                      <a href="blog-single.php">Travel is comming
                        <br> new</a>
                    </h2>
                  </div>
                  <div class="card-date">
                    <span class="date-b">18 Sep. 2017</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item-c">
            <div class="card-box-b card-shadow news-box">
              <div class="img-box-b">
                <img src="assets/img/post-7.jpg" alt="" class="img-b img-fluid">
              </div>
              <div class="card-overlay">
                <div class="card-header-b">
                  <div class="card-category-b">
                    <a href="#" class="category-b">Park</a>
                  </div>
                  <div class="card-title-b">
                    <h2 class="title-2">
                      <a href="blog-single.php">Park is comming
                        <br> new</a>
                    </h2>
                  </div>
                  <div class="card-date">
                    <span class="date-b">18 Sep. 2017</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item-c">
            <div class="card-box-b card-shadow news-box">
              <div class="img-box-b">
                <img src="assets/img/post-3.jpg" alt="" class="img-b img-fluid">
              </div>
              <div class="card-overlay">
                <div class="card-header-b">
                  <div class="card-category-b">
                    <a href="#" class="category-b">Travel</a>
                  </div>
                  <div class="card-title-b">
                    <h2 class="title-2">
                      <a href="#">Travel is comming
                        <br> new</a>
                    </h2>
                  </div>
                  <div class="card-date">
                    <span class="date-b">18 Sep. 2017</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->
    <!-- End Latest News Section -->

    <!-- ======= Testimonials Section ======= -->
    <!-- <section class="section-testimonials section-t8 nav-arrow-a">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="title-wrap d-flex justify-content-between">
              <div class="title-box">
                <h2 class="title-a">Testimonials</h2>
              </div>
            </div>
          </div>
        </div>
        <div id="testimonial-carousel" class="owl-carousel owl-arrow">
          <div class="carousel-item-a">
            <div class="testimonials-box">
              <div class="row">
                <div class="col-sm-12 col-md-6">
                  <div class="testimonial-img">
                    <img src="assets/img/testimonial-1.jpg" alt="" class="img-fluid">
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="testimonial-ico">
                    <span class="ion-ios-quote"></span>
                  </div>
                  <div class="testimonials-content">
                    <p class="testimonial-text">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis, cupiditate ea nam praesentium
                      debitis hic ber quibusdam
                      voluptatibus officia expedita corpori.
                    </p>
                  </div>
                  <div class="testimonial-author-box">
                    <img src="assets/img/mini-testimonial-1.jpg" alt="" class="testimonial-avatar">
                    <h5 class="testimonial-author">Albert & Erika</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item-a">
            <div class="testimonials-box">
              <div class="row">
                <div class="col-sm-12 col-md-6">
                  <div class="testimonial-img">
                    <img src="assets/img/testimonial-2.jpg" alt="" class="img-fluid">
                  </div>
                </div>
                <div class="col-sm-12 col-md-6">
                  <div class="testimonial-ico">
                    <span class="ion-ios-quote"></span>
                  </div>
                  <div class="testimonials-content">
                    <p class="testimonial-text">
                      Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis, cupiditate ea nam praesentium
                      debitis hic ber quibusdam
                      voluptatibus officia expedita corpori.
                    </p>
                  </div>
                  <div class="testimonial-author-box">
                    <img src="assets/img/mini-testimonial-2.jpg" alt="" class="testimonial-avatar">
                    <h5 class="testimonial-author">Pablo & Emma</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->
    <!-- End Testimonials Section -->

  </main><!-- End #main -->

  <?php
    include("includes/footer.php");
  ?>
