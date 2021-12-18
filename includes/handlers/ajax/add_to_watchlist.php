<?php
  require_once("../../../dashboard/dist/includes/config.php");

  $response = array(
    'status' => 0,
    'message' => 'Failed to Upload data Please try again'
	);
  if(isset($_POST['propId'])){
    $propId = $_POST['propId'];


    // add new item on array
    $watchlist_item = array(
      'propId' => $propId
    );
    // $ids_arr = implode(', ', $watchlist_item);
    // echo $ids_arr;

    /*
    * check if the 'watchlist' session array was created
    * if it is NOT, create the 'watchlist' session array
    */
    if(!isset($_SESSION['watchlist'])){
      $_SESSION['watchlist'] = array();
    }

    // check if the item is in the array, if it is, do not add
    if(array_key_exists($propId, $_SESSION['watchlist'])){
      // redirect to product list and tell the user it was added to cart
      $response['status'] = 0;
      $response['message'] = 'Property is already in watch list';

    }else{

      $_SESSION['watchlist'][$propId] = $watchlist_item;

      $response['status'] = 1;
      $response['message'] = 'Property has been successfully added to watchlist';

    }

    // session_destroy();

  }
  echo json_encode($response);



?>
