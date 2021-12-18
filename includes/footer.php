<!-- ======= Footer ======= -->
<section class="section-footer">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 col-md-4">
          <div class="widget-a">
            <div class="w-header-a">
              <div type="button" class=" " >
                <a href="index.php">
                  <!-- <img src="dashboard/dist/<?php echo $logo; ?>" width='70px' height='65px' alt=""> -->
                  <a class="navbar-brand text-brand" href="index.php">Kep<span class="color-b">ler.</span></a>
                </a>
              </div>
            </div>
            <div class="w-body-a">
              <?php
                  $aboutSql = "SELECT * FROM homepage WHERE sectionName = 'aboutSection' ORDER BY id ASC";
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

                  $dots = (strlen($description) >= 135) ? "..." : "";
                  $shortName = str_split($description, 135);
                  $shortName = $shortName[0] . $dots;
                  
            ?>
              <p class="w-text-a color-text-a">
              <?php echo nl2br($shortName);?> 
              <a class='link-c link-icon' href='about.php'>Read more
                  <span class='ion-ios-arrow-forward'></span>
              </a>
              </p>
            </div>
            <!-- <div class="w-footer-a">
              <ul class="list-unstyled">
                <li class="color-a">
                  <span class="color-text-a">Phone .</span> contact@example.com</li>
                <li class="color-a">
                  <span class="color-text-a">Email .</span> +54 356 945234</li>
              </ul>
            </div> -->
          </div>
        </div>
        <div class="col-sm-12 col-md-4 section-md-t3">
          <div class="widget-a">
            <div class="w-header-a">
              <h3 class="w-title-a text-brand">The Company</h3>
            </div>
            <div class="w-body-a">
              <div class="w-body-a">
                <ul class="list-unstyled">
                  <li class="item-list-a">
                    <i class="fa fa-angle-right"></i> <a href="#">Site Map</a>
                  </li>
                  <li class="item-list-a">
                    <i class="fa fa-angle-right"></i> <a href="#">Legal</a>
                  </li>
                  <li class="item-list-a">
                    <i class="fa fa-angle-right"></i> <a href="privacy_policy.php">Privacy Policy</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-4 section-md-t3">
          <div class="widget-a">
            <div class="w-header-a">
              <h3 class="w-title-a text-brand">Contact Us</h3>
            </div>
            <div class="w-body-a">
              <ul class="list-unstyled">
                <li class="item-list-a">
                  <i class="fa fa-envelope"></i> <a href="#"><?php echo $email;?></a>
                </li>
                <li class="item-list-a">
                  <i class="fa fa-phone"></i> <a href="#"><?php echo $tel;?></a>
                </li>
                <li class="item-list-a">
                  <i class="fa fa-map-marker"></i> <a href="#">Location, Street, Chicago, Illinois</a>
                </li>
                <!-- <li class="item-list-a">
                  <i class="fa fa-angle-right"></i> <a href="#">Argentina</a>
                </li>
                <li class="item-list-a">
                  <i class="fa fa-angle-right"></i> <a href="#">Singapore</a>
                </li>
                <li class="item-list-a">
                  <i class="fa fa-angle-right"></i> <a href="#">Philippines</a>
                </li> -->
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <nav class="nav-footer">
            <ul class="list-inline">
              <li class="list-inline-item">
                <a href="index.php">Home</a>
              </li>
              <li class="list-inline-item">
                <a href="about.php">About</a>
              </li>
              <li class="list-inline-item">
                <a href="property.php">Property</a>
              </li>
              <li class="list-inline-item">
                <a href="contact.php">Contact</a>
              </li>
            </ul>
          </nav>
          <div class="socials-a">
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
          </div>
          <div class="copyright-footer">
            <p class="copyright color-text-a">
              &copy; Copyright
              <span class="color-a"><?php echo $webName; ?></span> All Rights Reserved.
            </p>
          </div>
          <div class="credits">
            <!--
            All the links in the footer should remain intact.
            You can delete the links only if you purchased the pro version.
            Licensing information: https://bootstrapmade.com/license/
            Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=EstateAgency
          -->
            powered by <a href="https://kepler.com/">Kepler</a>
          </div>
        </div>
      </div>
    </div>
  </footer><!-- End  Footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="assets/vendor/counterup/counterup.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="assets/vendor/scrollreveal/scrollreveal.min.js"></script>
  <!-- Ion Slider -->
  <script src="assets/vendor/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
  <!--map js-->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCkf-jwvZ1V0EwSg_SZkJBku4-woyzeLO4&v=3.exp"></script>
  <script src="assets/js/jquery.ui.map.full.min.js"></script><!-- google maps -->
  <script src="assets/js/map.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>