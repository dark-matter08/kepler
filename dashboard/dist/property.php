<?php
    include("includes/header.php");
?>
<script type="text/javascript">
  $(document).ready(function(){

    newPageTitle = 'Dashboard | Properties';
    document.title = newPageTitle;
  });

</script>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Property</h1>
        <ol class="breadcrumb mb-4" style='min-width: 18rem;'>
            <li class="breadcrumb-item active">
                Property List |
                <span class = "ml-2">
                    <form class="m-0" action="property.php" method="post">
                        <button type="submit" class=" text-primary addpropbtn" name="addnew" value="">
                            <span class="my-auto text-primary" >
                                <i class="fas fa-plus"></i>
                            </span>
                            Add Property
                        </button>
                    </form>
                </span>
            </li>
            <?php
                if(isset($_POST['addnew'])){
                    $propName = "New Property";
                    $propDesc = "";
                    $imagePath = "uploads/propertyPhotos/placeholderimage.jpg";
                    $date = date("Y-m-d");
                    $status = "0";
                    $query = $con->prepare("INSERT INTO property(propName, propDescription, imagePath, dateAdded, status, uploaded_by)
                                                    VALUES(:propName, :propDescription, :imagePath, :date, :status, :uploaded_by)");


                    $query->bindParam(":propName", $propName);
                    $query->bindParam(":propDescription", $propDesc);
                    $query->bindParam(":imagePath", $imagePath);
                    $query->bindParam(":date", $date);
                    $query->bindParam(":status", $status);
                    $query->bindParam(":uploaded_by", $username);

                    if ($query->execute()) {
                        $propId =  $con->lastInsertId();

                        $query2 = $con->prepare("INSERT INTO descfeatures(propertyId) VALUES(:propertyId)");
                        $query2->bindParam(":propertyId", $propId);

                        $query3 = $con->prepare("INSERT INTO propertycity(propertyId) VALUES(:propertyId)");
                        $query3->bindParam(":propertyId", $propId);

                        $query4 = $con->prepare("INSERT INTO propertyextraexpenses(propertyId) VALUES(:propertyId)");
                        $query4->bindParam(":propertyId", $propId);

                        $query5 = $con->prepare("INSERT INTO propertyamenities(propertyId) VALUES(:propertyId)");
                        $query5->bindParam(":propertyId", $propId);

                        $query6 = $con->prepare("INSERT INTO propertyseller(propertyId) VALUES(:propertyId)");
                        $query6->bindParam(":propertyId", $propId);

                        // echo $propId;

                        if ($query2->execute()
                        && $query3->execute()
                        && $query4->execute()
                        && $query5->execute()
                        && $query6->execute()
                      ) {
                            header("location: propertyEdit.php?id=$propId&&type=new");
                        } else {
                            echo "Error: In Query<br>" . mysqli_error($con);
                        }

                    }else {
                        echo "Error: In Query<br>" . mysqli_error($con);
                    }
                }
            ?>
        </ol>
        <div class="column px-0" style='min-width: 18rem;'>
            <div class="row mx-0">
                <?php
                    $str = "";
                    $propSql = "SELECT * FROM property";
                    $propQuery = $con->prepare($propSql);
                    $propQuery->execute();



                    while ($row = $propQuery->fetch(PDO::FETCH_ASSOC)){
                        $id = $row['id'];
                        $propName = $row['propName'];
                        $status = $row['status'];
                        $date = $row['dateAdded'];
                        $propDesc = $row['propDescription'];
                        $uploaded_by = $row['uploaded_by'];



                        if ($propName == 'placeholder') {
                            $type = 'new';
                        } else{
                            $type = 'edit';
                        }

                        if($status == 0){
                            $stat = 'Drafts';
                        } else {
                            $stat = 'Published';
                        }

                        $propPhotoSql = "SELECT * FROM propertyphoto WHERE propId = $id AND selected = 1";
                        $propPhotoQuery = $con->prepare($propPhotoSql);
                        $propPhotoQuery->execute();
                        $row2 = $propPhotoQuery->fetch(PDO::FETCH_ASSOC);
                        if($row2){
                            $imagePath = $row2['imgPath'];
                        }else{
                            $imagePath = $row['imagePath'];
                        }

                        $locQuery = $con->prepare("SELECT * FROM propertycity WHERE propertyId = :propId");
                        $locQuery->bindParam(":propId", $id);
                        $locQuery->execute();
                        $row = $locQuery->fetch(PDO::FETCH_ASSOC);
                        $cities = $row['cityName'];
                        $country = $row['countryName'];
                        $strt = $row['street'];
                        $neighbourhood = $row['neighbourhood'];
                        $lng = $row['lng'];
                        $lat = $row['lat'];

                        $location = "$strt, $cities";

                        $dots = (strlen($location) >= 15) ? "..." : "";
                        $shortName = str_split($location, 15);
                        $shortName = $shortName[0] . $dots;



                        if($uploaded_by == $username){
                            $delete_button = "<span class='delete_prod btn'><i class='fa fa-times-circle text-danger' data-toggle='modal' data-target='#prop$id'></i></span>";
                            $edit_button = "<a href='propertyEdit.php?id=".$id."&&type=".$type."'>
                                                <div class='card-footer d-flex align-items-center justify-content-between'>
                                                    <span class='small text-dark'>Edit</span>
                                                    <div class='small text-dark'><i class='fas fa-angle-right'></i></div>
                                                </div>
                                            </a>";
                        }else{
                            if($uploaded_by == "kepler123"){
                                $delete_button = "<span class='delete_prod btn'><i class='fa fa-times-circle text-danger' data-toggle='modal' data-target='#prop$id'></i></span>";
                                $edit_button = "<a href='propertyEdit.php?id=".$id."&&type=".$type."'>
                                                <div class='card-footer d-flex align-items-center justify-content-between'>
                                                    <span class='small text-dark'>Edit</span>
                                                    <div class='small text-dark'><i class='fas fa-angle-right'></i></div>
                                                </div>
                                            </a>";
                            }
                            $delete_button = "<span class='delete_prod btn'><i class='fa fa-circle text-primary'></i></span>";
                            $edit_button = "<a href='#'>
                                                <div class='card-footer d-flex align-items-center justify-content-between'>
                                                    <span class='small text-dark'>---</span>
                                                    <div class='small text-dark'><i class='fas fa-angle-right'></i></div>
                                                </div>
                                            </a>";
                        }


                        $str .= "<div class='col-xl-3 col-lg-4 col-md-6  mb-3'>
                                    <div class='card' style='width: 100%;'>
                                        <img class='card-img-top listImage' src='$imagePath' alt='HouseImage'>
                                        <div class='card-body'>
                                            <h5 class='card-title text-center'>$shortName</h5>
                                            <p class='small text-center'>$stat &nbsp&nbsp       &middot;   &nbsp&nbsp   $delete_button</p>
                                            <p class='small text-center'>Uploaded By: $uploaded_by</p>
                                        </div>
                                        $edit_button
                                    </div>
                                </div>";
                ?>
                <!-- delete modal -->
                    <div class="modal fade" id="prop<?php echo $id;?>" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                        Are you sure you want to delete this Property?
                                    <button type="button" class="close" data-dismiss="modal">
                                        &times;
                                    </button>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Cancel
                                    </button>
                                    <a href="includes/handlers/delete.php?propId=<?php echo $id;?>&for=property" class="btn btn-danger text-light">
                                        OK
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- end of delete modal -->
                <?php
                    }
                    echo $str;
                ?>
            </div>
        </div>
    </div>
</main>
<?php
    include("includes/footer.php");
?>
