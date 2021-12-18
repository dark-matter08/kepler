<?php
    include("includes/header.php");
?>
<script type="text/javascript">
  $(document).ready(function(){

    newPageTitle = 'Dashboard | Homepage';
    document.title = newPageTitle;
  });

</script>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Home</h1>
        <ol class="breadcrumb mb-4" style='min-width: 18rem;'>
            <li class="breadcrumb-item active">
                Home Page | 
                <!-- <span class="ml-1 text-primary" >
                    <i class="fas fa-plus"></i> 
                </span> -->
                <span class = "ml-2">Editing <?php echo $webName; ?> Home</span>
            </li>
        </ol>
        <div class="alert alert-danger alert-dismissible fade hidden" id="dangerAlert"role="alert">
            <strong>Error!!!</strong><span id="errorMessage">   </span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="alert alert-success alert-dismissible fade hidden" id="successAlert" role="alert">
            <strong id="status">Success!!!</strong><span id="successMessage">   </span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="column">
            <div class="card card-common">
                <div class="card-header">
                    <h5>Service Section</h5>
                </div>
                <div class="card-body">
                    <?php
                        $str = "";
                        $str .= "<div class='row'>";
                        $homeServiceSql = "SELECT * FROM services ORDER BY id ASC";
                        $homeServiceQuery = $con->prepare($homeServiceSql);
                        $homeServiceQuery->execute();
                        $count = $homeServiceQuery->rowCount();
                        // echo $count;
                        if($count == 0){
                            $str .= "<span class='w-100 text-danger text-center'>No Service Added yet</span>";
                        }

                        while ($row = $homeServiceQuery->fetch(PDO::FETCH_ASSOC)){
                            $serviceId = $row['id'];
                            $description = $row['description'];
                            $title = $row['title'];

                            $dots = (strlen($description) >= 143) ? "..." : "";
                            $shortDesc = str_split($description, 143);
                            $shortDesc = $shortDesc[0] . $dots;

                           $delete_button = "<span class='delete_prod btn'><i class='fa fa-times-circle text-danger' data-toggle='modal' data-target='#serv$serviceId'></i></span>";



                            $str .= "<div class='col-xl-3 col-md-6'>
                                        <div class='card bg-white text-dark mb-4'>
                                            <div class='card-body'>$shortDesc</div>
                                            <div class='card-footer d-flex align-items-center justify-content-between'>
                                                <span class='small text-success' >$title</span>
                                                $delete_button
                                            </div>
                                        </div>
                                    </div>";

                        ?>
                        <!-- delete modal -->
                            <div class="modal fade" id="serv<?php echo $serviceId;?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                                Are you sure you want to delete this Service?
                                            <button type="button" class="close" data-dismiss="modal">
                                                &times;
                                            </button>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Cancel
                                            </button>
                                            <a href="includes/handlers/delete.php?servId=<?php echo $serviceId;?>&for=service" class="btn btn-danger text-light"> OK</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- end of delete modal -->

                        <?php
                        }
                        $str .= "</div>";
                        echo $str;
                    ?>
                    
                        
                    
                </div>
                <div class="card-footer text-dark">
                    <form action="includes/handlers/serviceHandler.php" method="POST">
                        <label for="">Service Name*</label>
                        <input type='text' class='form-control input d-block' name='serviceName' placeholder='Service Name'>
                        <div class="form-group">
                            <label for="">Icon Name*</label>
                            <input type='text' class='form-control input d-block' name='iconfont' placeholder='Icon Name' value='bxl-dribbble'>
                        </div>
                        <label for="">Service Description</label><br>
                        <textarea class="w-100 border-secondary form-control" name="serviceDescription" rows="4"></textarea><br>
                        <button class="btn btn-info btn-block" type="submit" name="addService">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
    include("includes/footer.php");
?>