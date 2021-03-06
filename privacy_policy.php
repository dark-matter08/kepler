<?php
  include("includes/header.php");
  include("pagination/function.php");

?>
<!-- ======= Intro Single ======= -->
<section class="intro-single">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-8">
            <div class="title-single-box">
              <h1 class="title-single">Take a look at our policies</h1>
            </div>
          </div>
          <div class="col-md-12 col-lg-4">
            <nav aria-label="breadcrumb" class="breadcrumb-box d-flex justify-content-lg-end">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="#">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Privacy Policy
                </li>
              </ol>
            </nav>
          </div>
        </div>
      </div>
    </section><!-- End Intro Single-->

    <!-- ======= About Section ======= -->
    <section class="section-about">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="about-img-box">
              <img src="assets/img/slide-about-1.jpg" alt="" class="img-fluid">
            </div>
            <div class="sinse-box">
              <h3 class="sinse-title">Kepler Policies
                <span></span>
                <br> 2020</h3>
              <!-- <p>Art & Creative</p> -->
            </div>
          </div>
          <div class="col-md-12 section-t8">
            <div class="row">
              <div class="col-md-6 col-lg-5">
                <img src="assets/img/about-2.jpg" alt="" class="img-fluid">
              </div>
              <div class="col-lg-2  d-none d-lg-block">
                <div class="title-vertical d-flex justify-content-start">
                  <span>Kepler Exclusive Property</span>
                </div>
              </div>
              <div class="col-md-6 col-lg-5 section-md-t3">
                <div class="title-box-d">
                  <h3 class="title-d">About
                    <span class="color-d">Kepler</span>
                    <!-- <br> nibh.</h3> -->
                </div>
                <?php
                        $aboutSql = "SELECT * FROM homepage WHERE sectionName = 'privacy_policy' ORDER BY id ASC";
                        $aboutQuery = $con->prepare($aboutSql);
                        $aboutQuery->execute();
                        $count = $aboutQuery->rowCount();
                        // echo $count;
                        
                        if($count == 0) {
                            $description = '';
                        } else{
                            while ($row = $aboutQuery->fetch(PDO::FETCH_ASSOC)){
                                $serviceId = $row['id'];
                                $description = $row['value'];
                            }
                        }
                        
                  ?>
                <p class="color-text-a">
                    <?php echo nl2br($description);?>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
<script type="text/javascript">
  $(document).ready(function(){
    $(".navbar-nav li .active").removeClass("active");
    // $(".navbar-nav li .property").addClass("active");

    newPageTitle = 'Privacy Policy | KEPLER';
    document.title = newPageTitle;
  });

</script>

<?php
  include("includes/footer.php");
?>