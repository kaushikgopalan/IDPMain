<html>
    <head>
        <title>Main Page</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--  <link rel="stylesheet" href="views\css\bootstrap\theme.min.css">
        commented for testing flat ui -->
        <link rel="stylesheet" href="views/css/bootstrap .css"> 
        <link rel="stylesheet" href="views/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="views/css/flat-ui.css"> 
        <link rel="stylesheet" href="views/css/styles.css"> 
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->


<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        -->
    </head>

    <body>
        <div class="wrap">

            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="container">
                    <a class="navbar-brand" href="main.php">IDP</a>
                    <ul class="nav navbar-nav">
                    </ul>
                </div>
            </nav>
            <div style="height: 70px"></div>
            <div class="container" >

                <form action="main.php" method="post">
                    <div class="row">
                        <div class=" col-md-4">
                            <!-- <div class="bg-primary" -->
                            <div class="tile">
                                <p class="tile-hot">Get company data from API</p>
                                <input type="submit" title="Use Glassdoor API to fetch all data from companies provided in configuration files." id="apiBtn" class="btn btn-primary" value="Fetch" name="apiBtn">
                            </div>
                        </div>
                        <div class=" col-md-4">
                            <div class="tile">
                                <p class="tile-hot">  Goto Edit Files</p>
                                <input type="submit" id="editPageBtn" title="Configure keys and set companies list."  class="btn btn-primary " value="Go" name="editPageBtn">
                            </div>
                        </div>
                        <div class=" col-md-4 ">
                            <div class="tile">
                                <p class="tile-hot">Download API Output</p>
                                <input type="submit" id="downloadAPIBtn" title="Download API data." value="Download" class="btn btn-primary" name="downloadAPIBtn">
                            </div>
                        </div>
                        <div class=" col-md-4 ">
                            <div class="tile">
                                <p class="tile-hot">Download API Response Status</p>
                                <input type="submit" id="downloadAPIResponseBtn" value="Download" class="btn btn-primary "  name="downloadAPIResponseBtn">
                            </div>
                        </div>
                    
                        <div class=" col-md-4 ">
                            <div  class="tile">
                                <p class="tile-hot">Download API Filter Format</p>
                                <input type="submit" id="downloadFilterFormatBtn" value="Download" class="btn btn-primary" name="downloadFilterFormatBtn">
                            </div>
                        </div>
                    
<!--                        <div class=" col-md-4 ">
                            <div  class="tile">
                                <p class="tile-hot">Download Webpages using Selenium</p>
                                <input type="submit" id="downloadSeleniumBtn" value="Download" class="btn btn-primary" name="downloadSeleniumBtn">
                            </div>
                        </div>
                         commented because the selenium thing is not working. Glassdoor have implemented
                         systems that keep a track on web crawling and that is not allowing us to do this.
                         
-->
                        <div class=" col-md-4 ">
                            <div  class="tile" >
                                <p class="tile-hot">Parse Glassdoor Webpages</p>
                                <input type="submit"  title="" id="parseGlassdoorOutput" value="Parse Glassdoor Output" class="btn btn-primary" name="parseGlassdoorOutput">
                            </div>
                        </div>
                        <div class=" col-md-4 ">
                            <div  class="tile">
                                <p class="tile-hot">Download Glassdoor Output</p>
                                <input type="submit" id="downloadGlassdoorOutput" value="Download Glassdoor Output" class="btn btn-primary" name="downloadGlassdoorOutput">
                            </div>
                        </div>
                        <div class=" col-md-4 ">
                            <div class="tile">
                                <p class="tile-hot">Call Crunchbase</p>
                                <input type="submit" id="callCrunchbase" value="Call Crunchbase" class="btn btn-primary" name="callCrunchbase">
                            </div>
                        </div>
                        
                   
                        <div class=" col-md-4 ">
                            <div class="tile">
                                <p class="tile-hot">Download Crunchbase Acquisitions</p>
                                <input type="submit" id="downloadCrunchbaseAcquisitions" value="Download Acquisitions" class="btn btn-primary" name="downloadCrunchbaseAcquisitions">
                            </div>
                        </div>
                        
                        <div class=" col-md-4 ">
                            <div class="tile">
                                <p class="tile-hot">Download Crunchbase Funding Rounds</p>
                                <input type="submit" id="downloadCrunchbaseFundingRounds" value="Download Funding Rounds" class="btn btn-primary" name="downloadCrunchbaseFundingRounds">
                            </div>
                        </div>
                        
                        <div class=" col-md-4 ">
                            <div class="tile">
                                <p class="tile-hot">Download Crunchbase Funds</p>
                                <input type="submit" id="downloadCrunchbaseFunds" value="Download Funds" class="btn btn-primary" name="downloadCrunchbaseFunds">
                            </div>
                        </div>
                    
                        <div class=" col-md-4 ">
                            <div class="tile">
                                <p class="tile-hot">Download Crunchbase Investments</p>
                                <input type="submit" id="downloadCrunchbaseInvestments" value="Download Investments" class="btn btn-primary" name="downloadCrunchbaseInvestments">
                            </div>
                        </div>
                        
                        <div class=" col-md-4 ">
                            <div class="tile">
                                <p class="tile-hot">Download Crunchbase IPO</p>
                                <input type="submit" id="downloadCrunchbaseIPO" value="Download IPO" class="btn btn-primary" name="downloadCrunchbaseIPO">
                            </div>
                        </div>
                        
                        <div class=" col-md-4 ">
                            <div class="tile">
                                <p class="tile-hot">Download Crunchbase Organization Data</p>
                                <input type="submit" id="downloadCrunchbaseOrganizationData" value="Download Organization Data" class="btn btn-primary" name="downloadCrunchbaseOrganizationData">
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </body>
</html>