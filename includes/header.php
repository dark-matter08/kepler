<?php
  include("dashboard/dist/includes/config.php");
  // include("includes/handlers/watch_config.php");
  // $_SESSION['watchlist'] = isset($_SESSION['watchlist']) ? $_SESSION['watchlist'] : array();

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
  echo "<script>currency = '$cur';</script>";
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


  $cityStr = "";

  // ==================================== Descriptive Features query ========================================

  $descFeatQuery = $con->prepare("SELECT * FROM descfeatures");
  $descFeatQuery->bindParam(":propId", $propId);
  $descFeatQuery->execute();
  while ($row = $descFeatQuery->fetch(PDO::FETCH_ASSOC)){
    $area = $row['area'];
    $bedrooms = $row['bedrooms'];
  }

// ================================ Location Query ================================================

  $locQuery = $con->prepare("SELECT DISTINCT(cityName) FROM propertycity ORDER BY cityName ASC");
  $locQuery->execute();
  $count = $locQuery->rowCount();
  // echo $count;
  $cityStr .= "<select class='form-control form-control-lg form-control-a' id='city' name='city'>
                <option value='all'>All City</option>";
  while ($row = $locQuery->fetch(PDO::FETCH_ASSOC)){
    $cities = $row['cityName'];

    $cityStr .= "<option value='$cities'>$cities</option>";
  }

  $cityStr .= "</select>";


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $webName; ?></title>
  <meta content="" name="descriptison">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="dashboard/dist/<?php echo $logo; ?>" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
  <link href="assets/vendor/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
   <!-- Ion Slider -->
   <link rel="stylesheet" href="assets/vendor/ion-rangeslider/css/ion.rangeSlider.css">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <!-- jquery -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>


  <!-- GTranslate: https://gtranslate.io/ -->

        <style type="text/css">
        a.gflag {vertical-align:middle;font-size:24px;padding:1px 0;background-repeat:no-repeat;background-image:url(//gtranslate.net/flags/32.png);}
        a.gflag img {border:0;}
        a.gflag:hover {background-image:url(//gtranslate.net/flags/32a.png);}
        #goog-gt-tt {display:none !important;}
        .goog-te-banner-frame {display:none !important;}
        .goog-te-menu-value:hover {text-decoration:none !important;}
        body {top:0 !important;}
        #google_translate_element2 {display:none!important;}
        </style>

        <script type="text/javascript">
        function googleTranslateElementInit2() {new google.translate.TranslateElement({pageLanguage: 'en',autoDisplay: false}, 'google_translate_element2');}
        </script><script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit2"></script>


        <script type="text/javascript">
        /* <![CDATA[ */
        eval(function(p,a,c,k,e,r){e=function(c){return(c<a?'':e(parseInt(c/a)))+((c=c%a)>35?String.fromCharCode(c+29):c.toString(36))};if(!''.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return'\\w+'};c=1};while(c--)if(k[c])p=p.replace(new RegExp('\\b'+e(c)+'\\b','g'),k[c]);return p}('6 7(a,b){n{4(2.9){3 c=2.9("o");c.p(b,f,f);a.q(c)}g{3 c=2.r();a.s(\'t\'+b,c)}}u(e){}}6 h(a){4(a.8)a=a.8;4(a==\'\')v;3 b=a.w(\'|\')[1];3 c;3 d=2.x(\'y\');z(3 i=0;i<d.5;i++)4(d[i].A==\'B-C-D\')c=d[i];4(2.j(\'k\')==E||2.j(\'k\').l.5==0||c.5==0||c.l.5==0){F(6(){h(a)},G)}g{c.8=b;7(c,\'m\');7(c,\'m\')}}',43,43,'||document|var|if|length|function|GTranslateFireEvent|value|createEvent||||||true|else|doGTranslate||getElementById|google_translate_element2|innerHTML|change|try|HTMLEvents|initEvent|dispatchEvent|createEventObject|fireEvent|on|catch|return|split|getElementsByTagName|select|for|className|goog|te|combo|null|setTimeout|500'.split('|'),0,{}))
        /* ]]> */
        </script>
</head>

<body>

  <!-- ======= Property Search Section ======= -->
  <div class="click-closed"></div>
  <!--/ Form Search Star /-->
  <div class="box-collapse">
    <div class="title-box-d">
      <h3 class="title-d">Search Property</h3>
    </div>
    <span class="close-box-collapse right-boxed ion-ios-close"></span>
    <div class="box-collapse-wrap form">
      <form class="form-a" method="GET" action="search.php">
        <div class="row">
          <div class="col-md-12 mb-2">
            <div class="form-group">
              <label for="Type">Equity</label>
              <input type="text" name="equity" class="form-control form-control-lg form-control-a" placeholder="What is your equity?">
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group">
              <label for="Type">Type</label>
              <select class="form-control form-control-lg form-control-a" name='type' id="Type">
                <option value='all'>All Type</option>
                <option value='Rent'>For Rent</option>
                <option value='Sale'>For Sale</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <div class="form-group">
              <label for="city">City</label>
              <?php echo $cityStr; ?>
            </div>
          </div>
          <div class="col-md-12">
            <button type="submit" name="searchProperty" class="btn btn-b">Search Property</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- End Property Search Section -->

  <!-- ======= Header/Navbar ======= -->
  <nav class="navbar navbar-default navbar-trans navbar-expand-lg fixed-top">
    <div class="container">
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarDefault" aria-controls="navbarDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <a class="navbar-brand text-brand" href="index.php">Kep<span class="color-b">ler.</span></a>
      <!-- <button type="button" class="btn btn-link nav-search navbar-toggle-box-collapse d-md-none" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-expanded="false">
        <span class="fa fa-search" aria-hidden="true"></span>
      </button> -->
      <div class="navbar-collapse collapse justify-content-center" id="navbarDefault">
        <ul class="navbar-nav">
          <li class="nav-item">
            <!-- <a class="navbar-brand text-brand brand-b" href="index.php">Kep<span class="color-b">ler.</span></a> -->
            <!-- <a class="nav-link active home" href="index.php">Home</a> -->
          </li>
        </ul>
      </div>
      <div type="button" class="" style="width: 370px;">
        <a href="about.php" class='btn view-btn-2 text-light'>Why Kepler?</a>
        <a href="#"  onclick="doGTranslate('en|ar');return false;" title="Arabic" class="gflag nturl my-auto" style="background-position:-100px -0px;">
            <img src="//gtranslate.net/flags/blank.png" height="32" width="30" alt="Arabic" />
            <i class="fa fa-caret-down" style="font-size: 15px;"></i>
        </a>
        <a href="#" onclick="doGTranslate('en|en');return false;" title="English" class="gflag nturl" style="background-position:-0px -0px;">
            <img src="//gtranslate.net/flags/blank.png" height="32" width="30" alt="English" />
            <i class="fa fa-caret-down" style="font-size: 15px;"></i>
        </a>
        <a href="#" onclick="doGTranslate('en|iw');return false;" title="Hebrew" class="gflag nturl" style="background-position:-200px -300px;">
            <img src="//gtranslate.net/flags/blank.png" height="32" width="30" alt="Hebrew" />
            <i class="fa fa-caret-down" style="font-size: 15px;"></i>
        </a>
        <br>
        <!-- <select class="languge-select" onchange="doGTranslate(this);">
          <option value="">Select Language</option>
          <option value="en|en">English</option>
          <option value="en|ar">Arabic</option>
          <option value="en|iw">Hebrew</option>
        </select> -->
        <div id="google_translate_element2"></div>
      </div>
    </div>

  </nav><!-- End Header/Navbar -->
