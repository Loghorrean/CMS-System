<?php
$categories = CrudCategoriesController::getInstance()->getRows("Select * from category");
$showAdminButton = false;
if (isset($_SESSION["user_id"]) && $_SESSION["user_role"] === "admin") {
    $showAdminButton = true;
}
?>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="./">CMS Front</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php
                    foreach ($categories as $category) {
                        echo "<li><a href = 'categories.php?cat={$category["cat_id"]}'>{$category["cat_title"]}</a></li>";
                    }
                    ?>
                    <?php
                    if ($showAdminButton == true) {
                        echo '<li><a href="admin" style = "font-weight: bold;">Admin</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>