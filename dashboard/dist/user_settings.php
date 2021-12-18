<?php
    include("includes/header.php");
    
    $query = "SELECT * FROM users WHERE username = :username";
    $userQuery = $con->prepare($query);
    $userQuery->bindParam(":username", $username);
    $userQuery->execute();

    $row = $userQuery->fetch(PDO::FETCH_ASSOC);
    $userImg = $row['profilePic'];
    $f_name = $row['firstName'];
    $l_name = $row['lastName'];
    $user_email = $row['email'];
    $user_tel = $row['user_tel'];
    $user_about = $row['user_about'];
    
    $userImgStr = "<span class='userSpan'><img src='$userImg'  class='userImage' class='mb-2'></span>";
?>
<script type="text/javascript">
  $(document).ready(function(){

    newPageTitle = 'Dashboard | User Settings';
    document.title = newPageTitle;
  });

</script>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Settings</h1>
        <ol class="breadcrumb mb-4" style='min-width: 18rem;'>
            <li class="breadcrumb-item active">
                User Settings | 
                <!-- <span class="ml-1 text-primary" >
                    <i class="fas fa-plus"></i> 
                </span> -->
                <span class = "ml-2">Update User Settings</span>
            </li>
        </ol>
        <div class="column">
            <div class="logoDiv">
                <h5>Set Logo</h5>
                <form method="POST" id="agentForm">
                    <input type='hidden' name='username' id='userImageUsername' value='<?php echo $username; ?>'>
                    <div class="row mt-5">
                        <div class="col-md-7 mx-auto text-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="">
                                        <div id='logoHere'><?php echo $userImgStr; ?></div>
                                        <input type="file" size="60" name="logoPhoto" class="logoPhoto" id="photoInput" multiple="multiple"/>
                                    </label>
                                    <p id="photoValue"></p>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" name="logoPhoto" class="btn btn-primary" id="logoPhoto">Upload</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <hr>
            <hr>
            <form action="includes/handlers/userSettingsHandler.php" method='POST'>
                <input type='hidden' name='username' value='<?php echo $username; ?>'>
                <div class="siteName">
                    <div class="form-group">
                        <label for="firstName">Frist Name*</label>
                        <input type='text' class='form-control input d-block' id="firstname" name='firstname' value='<?php echo $f_name; ?>' placeholder='First Name' width="100%" required>
                    </div>
                </div>
                <div class="siteName">
                    <div class="form-group">
                        <label for="lastName">Last Name*</label>
                        <input type='text' class='form-control input d-block' id="lastname" name='lastname' value='<?php echo $l_name; ?>' placeholder='Last Name' width="100%" required>
                    </div>
                </div>
                <hr>
                <div class="siteEmail">
                    <div class="form-group">
                        <label for="agentEmail">Email*</label>
                        <input type='text' class='form-control input d-block' id="agentEmail" name='agentEmail' value='<?php echo $user_email; ?>' placeholder='Agent Email' width="100%" required>
                    </div>
                </div>
                <hr>
                <div class="phoneNumber">
                    <div class="form-group">
                        <label for="agentNumber">Agent Tel Number*</label>
                        <input type='text' class='form-control input d-block' id="agentNumber" name='agentNumber' value='<?php echo $user_tel; ?>' placeholder='Tel: +' width="100%" required>
                    </div>
                </div>
                <hr>
                <div class="currency">
                    <div class="form-group">
                        <label for="agentAbout">Agent Description*</label>
                        <textarea type='text' class='form-control input d-block' id="agentAbout" name='agentAbout' placeholder='Short Description of you' width="100%" required><?php echo $user_about; ?></textarea>
                    </div>
                </div>
                <hr>
                <input type="submit" class='btn btn-block btn-Success' value='Update' name='submitAgentSettings' width="100%">
            </form>
        </div>
    </div>
</main>

<?php
    include("includes/footer.php");
?>
