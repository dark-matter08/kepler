<?php
    include_once '../../includes/config.php';
    if(isset($_POST['submitSiteSettings'])){

        $webName = $_POST['siteName'];
        $email = $_POST['siteEmail'];
        $cur = $_POST['currency'];
        $tel = $_POST['phoneNumber'];
        $annret = $_POST['annret'];
        $nedeq = $_POST['nedeq'];
        $mort = $_POST['mort'];
        $renint = $_POST['renint'];

        $query = $con->prepare("UPDATE randomvalues SET value=:siteName WHERE name='webNamme'");
        $query->bindParam(":siteName", $webName);
        $query2 = $con->prepare("UPDATE randomvalues SET value=:email WHERE name='email'");
        $query2->bindParam(":email", $email);
        $query3 = $con->prepare("UPDATE randomvalues SET value=:cur WHERE name='currency'");
        $query3->bindParam(":cur", $cur);
        $query4 = $con->prepare("UPDATE randomvalues SET value=:tel WHERE name='telephone'");
        $query4->bindParam(":tel", $tel);
        $query5 = $con->prepare("UPDATE randomvalues SET value=:annret WHERE name='annret_desc'");
        $query5->bindParam(":annret", $annret);
        $query6 = $con->prepare("UPDATE randomvalues SET value=:nedeq WHERE name='nedeq_desc'");
        $query6->bindParam(":nedeq", $nedeq);
        $query7 = $con->prepare("UPDATE randomvalues SET value=:mort WHERE name='mort_desc'");
        $query7->bindParam(":mort", $mort);
        $query8 = $con->prepare("UPDATE randomvalues SET value=:renint WHERE name='renint_desc'");
        $query8->bindParam(":renint", $renint);

        if (!$query->execute() ||
            !$query2->execute() ||
            !$query3->execute() ||
            !$query4->execute() ||
            !$query5->execute() ||
            !$query6->execute() ||
            !$query7->execute() ||
            !$query8->execute()
          ) {
            echo 'Something went wrong';
        }else{
            header("Location: ../../siteSettings.php");
        }
    }


?>
