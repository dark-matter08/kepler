<?php
    include("includes/header.php");
?>
<script type="text/javascript">
  $(document).ready(function(){

    newPageTitle = 'Dashboard | Blog';
    document.title = newPageTitle;
  });

</script>
<main>
    <div class="container-fluid">
        <h1 class="mt-4">Blog</h1>
        <ol class="breadcrumb mb-4" style='min-width: 18rem;'>
            <li class="breadcrumb-item active">
                Blog | 
                <!-- <span class="ml-1 text-primary" >
                    <i class="fas fa-plus"></i> 
                </span> -->
                <span class = "ml-2">Editing <?php echo $webName; ?> Blogs</span>
            </li>
        </ol>
        <div class="column">
            <div class="text-center">THIS FUNCTIONALITY NOT AVAILABLE YET</div>
        </div>
    </div>
</main>
<?php
    include("includes/footer.php");
?>