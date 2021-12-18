<?php
	include("includes/config_log.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");
	$account = new Account($con);
	include("includes/handlers/db_handler.php");

	function getInputValue($name){
		if(isset($_POST[$name])){
			echo $_POST[$name];
		}
    }
    $query = "SELECT value FROM randomvalues WHERE name = 'logoPath'";
    $logoQuery = mysqli_query($con, $query);
  
    $row = mysqli_fetch_array($logoQuery);
    $logo = $row['value'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Kepler | Dashboard Login</title>
        <link href="<?php echo $logo; ?>" rel="icon">
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
    <?php
		if(isset($_POST['registerButton'])){
			echo '
				<script type="text/javascript">
				$(document).ready(function(){
					$("#loginForm").hide();
					$("#registerForm").show();
				});
				</script>';
		}else {
			echo '
				<script type="text/javascript">
				$(document).ready(function(){
					$("#loginForm").show();
					$("#registerForm").hide();
				});
				</script>';
		}
	 ?>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Login</h3>
                                        <div class="text-center text-danger"><?php echo $account->getError(Constants::$loginFailed); ?></div>
                                    </div>
                                    <div class="card-body">
                                        <form id="loginForm" action="login.php" method="post">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Username</label>
                                                <!-- <input type="text" id="loginUsername"  placeholder="e.g. Nde Lucien"> -->
                                                <input class="form-control py-4" name="loginUsername" id="inputEmailAddress" type="text" placeholder="Enter username" value="<?php getInputValue('loginUsername'); ?>" required/>
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input class="form-control py-4" id="inputPassword" type="password" name="loginPassword" placeholder="Enter password" />
                                                <!-- <input type="password" id="loginPassword"  placeholder="Enter password" value="" required> -->
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.html">Forgot Password?</a>
                                                <!-- <a class="btn btn-primary" href="index.php">Login</a> -->
                                                <button class="btn btn-primary" type="submit" name="loginButton">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small">
                                            <a href="register.php">Need an account? Sign up!</a>
                                            <a href="../../index.php" target="_blanc">Kepler</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Kepler 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
