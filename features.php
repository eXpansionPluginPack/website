
<!DOCTYPE html>
<html lang="en-gb" dir="ltr">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">		
        <title>eXpansion PluginPack</title>
        <link rel="stylesheet" href="css/uikit.min.css">				
        <link rel="stylesheet" href="css/uikit.gradient.min.css">				
        <link rel="stylesheet" href="css/style.css">
        <script src="js/jquery.js"></script>
        <script src="js/uikit.min.js"></script>
    </head>

    <body>



        <div class="uk-container uk-container-center uk-margin-top uk-margin-large-bottom">
            <div class="uk-width-medium-1-1 uk-text-center">
                <img src="img/logo.png" id="logo"/>	
            </div>	

            <nav class="uk-navbar uk-margin-large-bottom">
                <ul class="uk-navbar-nav uk-hidden-small">
                    <?php include("pages/menu.php"); ?>
                </ul>
                <a href="#offcanvas" class="uk-navbar-toggle uk-visible-small" data-uk-offcanvas></a>
                <div class="uk-navbar-brand uk-navbar-center uk-visible-small">Server Add-on</div>
            </nav>

            <!-- content -->

            <?php
            include("pages/features.php");
            ?>				
        </div>

        <div id="offcanvas" class="uk-offcanvas">
            <div class="uk-offcanvas-bar">
                <ul class="uk-nav uk-nav-offcanvas">
                    <?php include("pages/menu.php"); ?>
                </ul>
            </div>
        </div>

    </body>
</html>