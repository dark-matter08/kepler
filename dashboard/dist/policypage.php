<?php
    include("includes/header.php");
?>
<script type="text/javascript">
  $(document).ready(function(){

    newPageTitle = 'Dashboard | Policy';
    document.title = newPageTitle;
  });

</script>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Privacy Policy</h1>
        <ol class="breadcrumb mb-4" style='min-width: 18rem;'>
            <li class="breadcrumb-item active">
                Privacy Policy Page | 
                <!-- <span class="ml-1 text-primary" >
                    <i class="fas fa-plus"></i> 
                </span> -->
                <span class = "ml-2">Editing <?php echo $webName; ?> Privacy Policy</span>
            </li>
        </ol>
        <div class="column">
            <div class="card card-common">
                <div class="card-header">
                    <h5>Privacy Policy Section</h5>
                </div>
                <div class="card-body">
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
    
                                $dots = (strlen($description) >= 143) ? "..." : "";
                                $shortDesc = str_split($description, 143);
                                $shortDesc = $shortDesc[0] . $dots;
    
                            }
                        }
                        
                    ?>
                    <form action="includes/handlers/policyHandler.php" method="POST">
                        <label for="">Company Privacy Policy</label><br>
                        <textarea class="w-100 border-secondary form-control" name="aboutText" rows="4"><?php echo $description; ?></textarea><br>
                        <button class="btn btn-info btn-block" type="submit" name="addAbout">Submit</button>
                    </form>
                </div>
                <div class="card-footer text-dark"></div>
            </div>
        </div>
    </div>
</main>
<?php
    include("includes/footer.php");
?>