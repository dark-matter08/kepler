<?php
    include("includes/header.php");

?>
<script type="text/javascript">
  $(document).ready(function(){

    newPageTitle = 'Dashboard | Site Settings';
    document.title = newPageTitle;
  });

</script>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Settings</h1>
        <ol class="breadcrumb mb-4" style='min-width: 18rem;'>
            <li class="breadcrumb-item active">
                Site Settings |
                <!-- <span class="ml-1 text-primary" >
                    <i class="fas fa-plus"></i>
                </span> -->
                <span class = "ml-2">Website Details</span>
            </li>
        </ol>
        <div class="column">
            <div class="logoDiv">
                <h5>Set Logo</h5>
                <form method="POST" id="logoForm">
                    <div class="row mt-5">
                        <div class="col-md-7 mx-auto text-center">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="">
                                        <div id='logoHere'><?php echo $logoStr; ?></div>
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
            <form action="includes/handlers/siteSettingsHandler.php" method='POST'>
                <div class="siteName">
                    <div class="form-group">
                        <label for="siteName">Site Name*</label>
                        <input type='text' class='form-control input d-block' id="siteName" name='siteName' value='<?php echo $webName; ?>' placeholder='Site Name' width="100%" required>
                    </div>
                </div>
                <hr>
                <div class="siteEmail">
                    <div class="form-group">
                        <label for="siteEmail">Email*</label>
                        <input type='text' class='form-control input d-block' id="siteEmail" name='siteEmail' value='<?php echo $email; ?>' placeholder='Site Email' width="100%" required>
                    </div>
                </div>
                <hr>
                <div class="phoneNumber">
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number*</label>
                        <input type='text' class='form-control input d-block' id="phoneNumber" name='phoneNumber' value='<?php echo $tel; ?>' placeholder='Tel: +' width="100%" required>
                    </div>
                </div>
                <hr>
                <div class="currency">
                    <div class="form-group">
                        <label for="currency">Currency*</label>
                        <input type='text' class='form-control input d-block' id="currency" name='currency' value='<?php echo $cur; ?>' placeholder='Currency .e.g. $' width="100%" required>
                    </div>
                </div>

                <div style="border: none; border-top: 2px solid #000" class="my-4"></div>

                <h4>Property Tooltip Description</h4>
                <div class="form-group">
                    <label for="currency">Annual Return</label>
                    <textarea type='text' class='form-control' rows=3 id="annnret" name='annret'><?php echo $annualreturnDesc; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="currency">Needed Equity</label>
                    <textarea type='text' class='form-control' rows=3 id="nedeq" name='nedeq'><?php echo $neededequityDesc; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="currency">Mortgage</label>
                    <textarea type='text' class='form-control' rows=3 id="mort" name='mort'><?php echo $mortgageDesc; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="currency">Rent Income</label>
                    <textarea type='text' class='form-control' rows=3 id="renint" name='renint'><?php echo $rentincomeDesc; ?></textarea>
                </div>

                <div style="border: none; border-top: 2px solid #000" class="my-4"></div>

                <input type="submit" class='btn btn-block btn-Success' value='Save' name='submitSiteSettings' width="100%">
            </form>
        </div>
    </div>
</main>
<?php
    include("includes/footer.php");
?>
