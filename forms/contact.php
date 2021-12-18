<?php
  include("../dashboard/dist/includes/config.php");
  $msg = "";
  $query = "SELECT value FROM randomvalues WHERE name = 'email'";
  $emailQuery = $con->prepare($query);
  $emailQuery->execute();

  $row = $emailQuery->fetch(PDO::FETCH_ASSOC);
  $email = $row['value'];

  $receiving_email_address = $email;

  
  $to = $receiving_email_address;
  $from_name = $_POST['name'];
  $from_email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  $headers = ['From' => $from_email, 'Reply-To' => $from_email, 'Content-type' => 'text/html; charset=iso-8859-1'];

  $bodyParagraphs = ["Name: {$from_name}", "Email: {$from_name}", "Message:", $message];
  $body = join(PHP_EOL, $bodyParagraphs);

  if (mail($to, $subject, $body, $headers)) {
      $msg .= "OK";
  } else {
     $msg = 'Form submission failed';
  }

  echo $msg;

?>
