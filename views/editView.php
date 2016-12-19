<html>
    <head>
        <tile>Edit View Page</tile>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--  <link rel="stylesheet" href="views\css\bootstrap\theme.min.css">
        commented for testing flat ui -->
        <link rel="stylesheet" href="views\css\bootstrap .css"> 
        <link rel="stylesheet" href="views\css\bootstrap.min.css"> 
        <link rel="stylesheet" href="views\css\flat-ui.css"> 
        <link rel="stylesheet" href="views\css\styles.css"> 
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        -->
    </head>

    <body>
        
          <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                    <a class="navbar-brand" href="main.php">IDP</a>
                    <ul class="nav navbar-nav">
                    </ul>
                </div>
            </nav>
        <form action="edit.php" method="post">
            <div class="wrap">

           
<div style="height: 70px"></div>
            
            <div class="container" style="border:80px">

                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-3 ">
                        <div class="tile">
                            <p class="tile-hot">Edit Configuration File</p>
                            <input type="submit" id = "configBtn" class="btn btn-primary" value = "Edit" name = "configBtn">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-3 ">
                        <div class="tile ">                    
                            <p class="tile-hot">Edit Filter File</p>
                            <input type="submit" id = "filterBtn" class="btn btn-primary" value = "Edit" name = "filterBtn">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-3 ">
                        <div class="tile">                    <p class="tile-hot">Edit Company List</p>
                            <input type="submit" id = "companyBtn" class="btn btn-primary"  value = "Edit" name = "companyBtn">
                        </div>
                    </div>
                </div>

        </div>
            </div>
    </form>

</body>
</html>