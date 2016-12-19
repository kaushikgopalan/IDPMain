<html>
    <head>
        <title>Edit File Contents</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="views\css\bootstrap .css"> 
        <link rel="stylesheet" href="views\css\bootstrap.min.css"> 
        <link rel="stylesheet" href="views\css\flat-ui.css"> 
        <link rel="stylesheet" href="views\css\styles.css"> 
        
    </head>
    <body>
        <form action="edit.php" method="post">
           <div class="row">
            <div class="container col-md-8" >
                
                <nav class="navbar navbar-inverse navbar-fixed-top"  role="navigation">

                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-btn" >
                        <div class="col-xs-12 col-sm-4 col-md-3 ">
                            <input type="submit" class="btn btn-primary" id = "mainPageBtn" value = "Main Page" name = "mainPageBtn">
                        </div>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <!-- added and then removed the header thing from here. not needed here-->
                    <!-- /.navbar-collapse -->

                    <!-- /.container -->
                </nav>
            </div>
           </div>
            <div style="height: 70px"></div>
            <div class="container">
            <div class="row">
                <div class="col-md-12 "></div>
            <div class=" col-xs-12 col-sm-4 col-md-8">
                
                <?php
                echo "<textarea name = \"editedData\" rows=\"10\" class=\"form-control input-lg\" style=\"\">" . $fileContents . "</textarea>";
                ?>
            
            
                <div  class=" center-block  tile-image">
                    <input type="submit" id= "back" class="btn btn-primary" value= "Back" name="back">
                    <input type="submit" id= "save" class="btn btn-primary" value= "Save" name="save">
                    <input type="hidden" name="fileType"  class="btn btn-primary" value= "<?php echo $editFileName; ?>">
                </div>
            </div>
           </div>
                </div>
        </form>
    </body>
</html>

