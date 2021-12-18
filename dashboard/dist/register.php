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
        <title>Kepler | Agent Register</title>
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
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">Create Account</h3>
                                        <!-- <div class="text-center text-danger"><?php echo $account->getError(Constants::$loginFailed); ?></div> -->
                                    </div>
                                    <div class="card-body">
                                        <form id="loginForm" action="register.php" method="post">
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="text-center text-danger"><?php echo $account->getError(Constants::$error_fn); ?></div>
                                                        <label class="small mb-1" for="firstName">First Name</label>
                                                        <input class="form-control py-4" name="firstName" type="text" value="<?php getInputValue('firstName'); ?>" placeholder="Enter first name" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div class="text-center text-danger"><?php echo $account->getError(Constants::$error_ln); ?></div>
                                                        <label class="small mb-1" for="lastName">Last Name</label>
                                                        <input class="form-control py-4" name="lastName" type="text" value="<?php getInputValue('lastName'); ?>" placeholder="Enter last name" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="text-center text-danger"><?php echo $account->getError(Constants::$error_un1); ?></div>
                                                <div class="text-center text-danger"><?php echo $account->getError(Constants::$error_un2); ?></div>
                                                <label class="small mb-1" for="username">Username</label>
                                                <input class="form-control py-4" name="username" type="text" value="<?php getInputValue('username'); ?>" placeholder="Enter Username" />
                                            </div>
                                            <div class="text-center text-danger"><?php echo $account->getError(Constants::$error_em1); ?></div>
                                            <div class="text-center text-danger"><?php echo $account->getError(Constants::$error_em2); ?></div>
                                            <div class="text-center text-danger"><?php echo $account->getError(Constants::$error_em3); ?></div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="email">Email</label>
                                                        <input class="form-control py-4" name="email" type="email" aria-describedby="emailHelp" value="<?php getInputValue('email'); ?>" placeholder="Enter email address" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="email2">Confirm Email</label>
                                                        <input class="form-control py-4" name="email2" type="email" aria-describedby="emailHelp" value="<?php getInputValue('email2'); ?>" placeholder="Enter email address" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center text-danger"><?php echo $account->getError(Constants::$error_pw1); ?></div>
                                            <div class="text-center text-danger"><?php echo $account->getError(Constants::$error_pw2); ?></div>
                                            <div class="text-center text-danger"><?php echo $account->getError(Constants::$error_pw3); ?></div>
                                            <div class="form-row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="password">Password</label>
                                                        <input class="form-control py-4" name="password" type="password" value="" placeholder="Enter password" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="small mb-1" for="password2">Confirm Password</label>
                                                        <input class="form-control py-4" name="password2" type="password" value="" placeholder="Confirm password" />
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="form-group mt-4 mb-0"><a class="btn btn-primary btn-block" href="login.html">Create Account</a></div> -->
                                            <button class="btn btn-primary" type="submit" name="registerButton">Create Account</button>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small">
                                            <a href="login.php">Have an account? Go to login</a>
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
