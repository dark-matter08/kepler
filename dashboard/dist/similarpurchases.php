<?php
    include("includes/header.php");
?>
<script type="text/javascript">
  $(document).ready(function(){

    newPageTitle = 'Dashboard | Similar Purchases';
    document.title = newPageTitle;
  });

</script>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Similar Purchases</h1>
        <ol class="breadcrumb mb-4" style='min-width: 18rem;'>
            <li class="breadcrumb-item active">
            Similar Purchases |
                <!-- <span class="ml-1 text-primary" >
                    <i class="fas fa-plus"></i>
                </span> -->
                <span class = "ml-2">Adding <?php echo $webName; ?> Similar Purchases</span>
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
                    <h5>Similar Purchases</h5>
                </div>
                <div class="card-body">
                    <?php
                        $str = "<table style='width:100%'>
                                    <thead class='text-center'>
                                    <tr>
                                        <th>ID</th>
                                        <th>Address</th>
                                        <th>Rooms</th>
                                        <th>Price</th>
                                        <th>Date</th>
                                        <th>Building Year</th>
                                        <th>Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>";
                        $str .= "<div class='row'>";
                        $homeServiceSql = "SELECT * FROM similarpurchases ORDER BY RAND LIMIT 5";
                        $homeServiceQuery = $con->prepare($homeServiceSql);
                        $homeServiceQuery->execute();
                        $count = $homeServiceQuery->rowCount();
                        // echo $count;
                        if($count == 0){
                            $str .= "<tr class='text-danger text-center my-3'>
                                        <td colspan='7'>No Similar purchases available</td>
                                    </tr>";
                        }

                        while ($row = $homeServiceQuery->fetch(PDO::FETCH_ASSOC)){
                            $id = $row['id'];
                            $address = $row['address'];
                            $rooms = $row['rooms'];
                            $price = $row['price'];
                            $price = number_format($price);
                            $date = $row['date'];
                            $building_year = $row['building_year'];

                           $delete_button = "<span class='delete_prod btn'><i class='fa fa-times-circle text-danger' data-toggle='modal' data-target='#serv$id'></i></span>";

                            $str .= "<tr class='text-center'>
                                        <td>$id</td>
                                        <td>$address</td>
                                        <td>$rooms</td>
                                        <td>$cur $price</td>
                                        <td>$date</td>
                                        <td>$building_year</td>
                                        <td>$delete_button</td>
                                    </tr>";

                        ?>

                        <!-- delete modal -->
                            <div class="modal fade" id="serv<?php echo $id;?>" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                                Are you sure you want to delete this purchase?
                                            <button type="button" class="close" data-dismiss="modal">
                                                &times;
                                            </button>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Cancel
                                            </button>
                                            <a href="includes/handlers/delete.php?simpurch=<?php echo $id;?>&for=similarpurchase" class="btn btn-danger text-light"> OK</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        <!-- end of delete modal -->

                        <?php
                        }
                        $str .= "</tbody>
                            </table>";
                        echo $str;
                    ?>
                </div>
                <div class="card-footer text-dark">
                    <form action="includes/handlers/simpurchaseHandler.php" method="POST">
                        <div class="form-row">
                            <div class="col-6">
                                <label for="">Address*</label>
                                <input type='text' class='form-control input d-block' name='address' placeholder='Address'>
                            </div>
                            <div class="col-6">
                                <label for="">rooms*</label>
                                <input type='number' class='form-control input d-block' name='rooms' placeholder='rooms'>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-6">
                                <label for="">Price*</label>
                                <input type='number' class='form-control input d-block' name='price' placeholder='Price'>
                            </div>
                            <div class="col-6">
                                <label for="">Date*</label>
                                <input type='date' class='form-control input d-block' name='date_prop' placeholder='Date'>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Building Year*</label>
                            <input type='text' class='form-control input d-block' name='build_year' placeholder='Building Year'>
                        </div>
                        <button class="btn btn-info btn-block" type="submit" name="add_sim_purchase">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
    include("includes/footer.php");
?>
