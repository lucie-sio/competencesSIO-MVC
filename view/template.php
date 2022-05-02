<!DOCTYPE html>
<html>

    <head>   
        <meta charset="UTF-8">
        <link rel="icon" type="image/x-icon" href="./public/img/favicon.ico">
        <title>Compétences SIO | <?= $title ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- BootStrap -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="./public/css/styles.css">
    </head>

    <body>
        <?php if($navbar === true): ?>
        <nav class="navbar navbar-expand-lg sticky-top navbar-dark bg-secondary customShadow">
            <div class="navbar-nav mr-auto">
                <div class="navbar-brand">
                    <img src="./public/img/logo-certa-background.png" height="30">
                </div>
            </div>

            <div class="navbar-nav ml-auto">  
                <a href="./index.php?action=logout" class="btn btn-light float-right">Se déconnecter</a>  
            </div>
        </nav>    
        <?php endif; ?>
        <?= $content ?>
        <!-- JQuery & Bootstrap -->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
    
</html>