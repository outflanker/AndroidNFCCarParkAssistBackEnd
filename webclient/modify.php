<!DOCTYPE html>
<?php
if (!isset($_COOKIE['LOGINUSERNAME']))
    header("Location: index.php");
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Bootbusiness | Short description about company">
        <meta name="author" content="Your name">
        <title>MODIFY</title>
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap responsive -->
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
        <!-- Font awesome - iconic font with IE7 support --> 
        <link href="css/font-awesome.css" rel="stylesheet">
        <link href="css/font-awesome-ie7.css" rel="stylesheet">
        <!-- Bootbusiness theme -->
        <link href="css/boot-business.css" rel="stylesheet">
         <script src="js/jquery.js" ></script>
        <script src="js/jquery.cookie.js" ></script>
        <script src="js/jquery.validate.js" ></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/signout.js"></script>        
        <script>
            var modify = function( text ){
   
               
                $.cookie("MODIFYLAYOUTID",text);
                $.cookie("VIEWLAYOUTID",text);
                window.location = "modify1.php";
                 
            }
            
            var del = function(id,name){
                
                var ans =confirm("Are you sure you want to delete the entire layout : "+name+" ?");
                if(ans==true)
                {
                    $.ajax({
                        url: "deleteLayout.php",
                        type: 'POST',
                        data :"layoutid="+id,
                        datatype :"text",
                        async: false, 
                        cache: false,
                        timeout: 30000,
                        error: function(){
                            return true;
                        },
                        success: function(msg){                        
                            alert(msg);
                                
                            location.reload();
                                           
                         
                           
                        }
                    

                    });
                }
            }
            
            
            
        </script>
    </head>
    <body>
        <!-- Start: HEADER -->
        <header>
            <!-- Start: Navigation wrapper -->
            <div class="navbar navbar-fixed-top">
                <div class="navbar-inner">
                    <div class="container">
                        <a href="index.php" class="brand brand-bootbus">NFC CAR PARK ASSIST ADMIN PAGE</a>
                        <!-- Below button used for responsive navigation -->
                        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <!-- Start: Primary navigation -->
                        <div class="nav-collapse collapse">        
                            <ul class="nav pull-right">

                                <li><a href="monitor.php">Monitor </a></li>
                                <li><a href="view.php" >View </a></li>
                                <li><a href="create.php">Create</a></li>
                                <li><a href="modify.php" class='active-link'>Alter </a></li>


                                <?php
                                if (isset($_COOKIE['LOGINUSERNAME'])) {
                                    print "<li class = 'dropdown'><a href = '#' class = 'dropdown-toggle'";
                                    print "data-toggle = 'dropdown' >" . $_COOKIE['LOGINUSERNAME'] . "<b class = 'caret'></b></a>";
                                    ?>
                                    <ul class = "dropdown-menu">
                                        <li><a id="log_out">Sign Out</a></li>
                                        <li><a href = "changepwd.php">Change Password</a></li>
                                    </ul>
                                    </li>
                                    <?php
                                } else {
                                    print "<li><a href='signup.php'>Sign up</a></li>";
                                    print "<li><a href='signin.php'>Sign in</a></li>";
                                }
                                ?>       



                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End: Navigation wrapper -->   
        </header>
        <!-- End: HEADER -->
        <!-- Start: MAIN CONTENT -->
        <div class="content">
            <div class="container">
                <?php
                $ch = curl_init('http://localhost:8888/parking/FinalYearProject/public/Layout/');
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($ch);
                curl_close($ch);
                $results_arr = json_decode($result, true);
                    $empty = $results_arr['LAYOUTS'];


                    if (!is_null($empty)) {

                ?>
                <table border="1" class="table table-hover">
                    <tr><th>LAYOUTID</th><th>LAYOUTNAME</th><th>NUMBEROFLAYERS</th><th>AREA</th><th>CITY</th>
                        <th>LATITUDE</th>
                        <th>LONGITUDE</th><th>PARKINGRATE</th><th>MODIFY</th><th>DELETE</th>
                    </tr>
                    <?php
                    
                        $results = json_decode($result);
                        $results = json_decode($result);
                        foreach ($results as $key => $jsons) {
                            foreach ($jsons as $key => $value) {
                                ?>
                                <tr>
                                    <?php
                                    foreach ($value as $keys => $values) {
                                        if ($keys == "LAYOUTID") {
                                            ?>
                                            <td>
                                                <?php
                                                $layoutID = $values;
                                                print '<a id="link" onclick="test(\'' . $values . '\')" href="./modifyviewlayout.php?layoutid=' . $layoutID .'">' . $values . '</a>';
                                                ?>
                                            </td>
                                            <?php
                                        } else {
                                            if ($keys == "LAYOUTNAME")
                                                $name = $values;
                                            ?>
                                            <td>
                                                <?php
                                                print $values;
                                            }
                                            ?>

                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning" onclick="modify('<?php echo $layoutID; ?>')">Modify</button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger" onclick="del('<?php echo $layoutID; ?>','<?php echo $name; ?>')">Delete</button>
                                    </td>
                                </tr>


                                <?php
                            }
                        }
                    }
                    else {
                        print "<h2>No layouts to display</h2>";
                    }
                    ?>
                </table>
                </br>
                <center>
                    <form action='view.php'>
                        <button id="done" class="btn btn-success">Done </button>
                    </form>
                </center>
            </div>
        </div>
        <!-- End: MAIN CONTENT -->
         <div class="clear"></div>
        <!-- Start: FOOTER -->
        <footer>
            <hr class="footer-divider">
            <div class="container">
                <p>
                    Developed using twitter bootstrap by Siddharth , Shamyak , Spoorthi and Nitin .
                </p>
            </div>
        </footer>
        <!-- End: FOOTER -->

    </body>
</html>