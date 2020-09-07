<?php
require_once("includes/admin_header.php");
if (!isset($_SESSION["user_id"])) {
    $_SESSION["error"] = "You are not logged in!";
    header("Location: ../");
    return;
}
if ($_SESSION["user_role"] !== "admin") {
    $_SESSION["error"] = "You don't have permission to use admin panel!";
    header("Location: ../");
    return;
}
?>
<body>
    <div id="wrapper">
        <?php
        require_once("includes/admin_navigation.php");
        ?>
        <div id="page-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome, <?=$_SESSION["name"]?>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
                <?php
                require_once("includes/admin_widgets.php");
                ?>
                <div class = "row">
                    <script>
                        let act_post_count = <?=$postCount?>;
                        let draft_post_count = <?=$draftPostCount?>;
                        let cat_count = <?=$catCount?>;
                        let user_count = <?=$userCount?>;
                        let sub_User_count = <?=$subUserCount?>;
                        let com_count = <?=$comCount?>;
                        let unapp_com_count = <?=$unappComCount?>;
                    </script>
                    <script src="includes/columnChart.js"></script>
                    <div id="columnchart_material" style="width: auto; height: 500px;"></div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <?php
    require_once("includes/admin_footer.php");
    ?>