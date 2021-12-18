
<link href="assets/vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


<style media="screen">
@import url('https://fonts.googleapis.com/css?family=Roboto');

body{
  height:100vh;
  display:flex;
  flex-direction:column;
  justify-content:center;
  align-items:center;
  font-family: 'Roboto', sans-serif;
}

h2{
  margin:0px;
  text-transform: uppercase;
}

h6{
  margin:0px;
  color:#777;
}

.wrapper{
  text-align:center;
  margin:50px auto;
}

.tabs-nav{
  margin-top: 50px;
  font-size: 15px;
  padding: 0px;
  list-style: none;
  background: #fff;
  box-shadow: 0px 5px 20px rgba(0,0,0,0.1);
  border-radius: 50px;
  position: relative;
}
.tabs-nav a{
  text-decoration: none;
  color: #777;
  text-transform: uppercase;
  padding: 10px 20px;
  display: inline-block;
  position: relative;
  z-index: 1;
  transition-duration: 0.6s;
}

.tabs-nav a.active{
  color: #fff;
}

.tabs-nav a i {
  margin-right: 5px;
}

.tabs-nav .selector{
  height: 100%;
  display: inline-block;
  position: absolute;
  left: 0px;
  top: 0px;
  z-index: 1;
  border-radius: 50px;
  transition-duration: 0.6s;
  transition-timing-function: cubic-bezier(0.68, -0.55, 0.265, 1.55);
  background: #05abe0;
  background: -moz-linear-gradient(45deg, #05abe0, 0%, #8200f4, 100%);
  background: -webkit-linear-gradient(45deg, #05abe0, 0%, #8200f4, 100%);
  background: linear-gradient(45deg, #05abe0, 0%, #8200f4, 100%);
  filter: progid:DXImageTransform.Microsoft.gradient(starColorstr='#05abe0', endColourstr='#8200f4', GradienType=1);
}

</style>
<div class="wrapper">
  <h2>Elastic Tabs</h2>
  <h6>Click on tabs to see them in action</h6>
  <nav class="tabs-nav">
    <div class="selector"></div>
    <ul  class="nav nav-tabs" role="tablist">
      <li  role="presentation" id="Section11" class="nav-list">
        <a href="#Section1" aria-controls="home" role="tab" data-toggle="tab" class="active">
          <i class="fab fa-superpowers"></i>Avengers
        </a>
      </li>
      <li  role="presentation" id="Section22" class="nav-list">
        <a href="#Section2" aria-controls="home" role="tab" data-toggle="tab" class="">
          <i class="fas fa-hand-rock"></i>Hulk
        </a>
      </li>
      <li  role="presentation" id="Section33" class="nav-list">
        <a href="#Section3" aria-controls="home" role="tab" data-toggle="tab" class="">
          <i class="fas fa-bolt"></i>Thor
        </a>
      </li>
      <li  role="presentation" id="Section44" class="nav-list">
        <a href="#Section4" aria-controls="home" role="tab" data-toggle="tab" class="">
          <i class="fas fa-burn"></i>Marvel
        </a>
      </li>
    </ul>
  </nav>
  <div class="tab-content tabs" style="min-height:100px; max-height:100px;">
    <div role="tabpanel" class="tab-pane fade in show active" id="Section1">
      tab1
    </div>
    <div role="tabpanel" class="tab-pane fade" id="Section2">
      tab2
    </div>
    <div role="tabpanel" class="tab-pane fade" id="Section3">
      tab3
    </div>
    <div role="tabpanel" class="tab-pane fade" id="Section4">
      tab4
    </div>
  </div>
</div>

<script type="text/javascript">
  var tabs = $('.tabs-nav');
  var selector = $('.tabs-nav').find('a').length;
  //var selector = $(".tabs").find(".selector");
  var activeItem = tabs.find('.active');
  var activeWidth = activeItem.innerWidth();
  $(".selector").css({
  "left": activeItem.position.left + "px",
  "width": activeWidth + "px"
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

</script>
