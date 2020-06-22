<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HomeControl</title>
        <link rel="stylesheet" type="text/css" href="myStyle.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
<?php
    if(!isset($_COOKIE["returningUser"])) {
        //check if post request or show login form
        //echo "Cookie named '" . $cookie_name . "' is not set!";
       if(isset($_POST["submit"])) //we received a post request; 
        {
            //check if credentials are correct
            $user = $_POST["user"];
            $pass = $_POST["pass"];
            
            if($user=="admin" AND $pass==123) //if correcty- display page
            {
                setcookie("returningUser", "yes", time() + (86400 * 30), "/");
                header( "Location:/" );
                exit;
            }
            else //wrong credentials
            {
                echo "Wrong credentials. <a href=\"/\">Try again</a>";
            }
        }
        else //new user- show signin page
        {
        ?>
        <div class="form">
            <form action="/" method="POST">
               Name:  <input type="text" name="user"><br>
               Password:  <input type="password" name="pass"><br><br>
                <input type="submit" name="submit">
            </form>
        </div>
        <?php
        }
    } else {
        // cookie set
         ?>
        <h1>Home Control</h1>
        <button type="button" class="collapsible">Master Bedroom</button>
        <div id="room1" class="content">

            <table>
                <tr>
                    <th>Device</th>
                    <th>Switch</th>
                </tr>
                <tr>
                    <td>Fan</td>
                    <td><label class="switch">
                        <input type="checkbox" class="mySwitch" id="14" onclick="myFunction(14)">
                        <span class="slider round"></span> <!--or just slider-->
                        </label></td>
                </tr>
                <tr>
                    <td>Light</td>
                    <td><label class="switch">
                        <input type="checkbox" class="mySwitch" id="15" onclick="myFunction(15)">
                        <span class="slider round"></span>
                        </label></td>
                </tr>
                <tr>
                    <td>Bedlamp</td>
                    <td><label class="switch">
                        <input type="checkbox" class="mySwitch" id="18" onclick="myFunction(18)">
                        <span class="slider round"></span>
                        </label></td>
                </tr>
                <tr>
                    <td>AC</td>
                    <td><label class="switch">
                        <input type="checkbox" class="mySwitch" id="23" onclick="myFunction(23)">
                        <span class="slider round"></span>
                        </label></td>
                </tr>
            </table>
        </div>
        <br><br>

        <button type="button" class="collapsible">Side Bedroom</button>
        <div id="room2" class="content">

            <table>
                <tr>
                    <th>Device</th>
                    <th>Switch</th>
                </tr>
                <tr>
                    <td>Fan</td>
                    <td><label class="switch">
                        <input type="checkbox" id="24">
                        <span class="slider round"></span> <!--or just slider-->
                        </label></td>
                </tr>
                <tr>
                    <td>Light</td>
                    <td><label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                        </label></td>
                </tr>
                <tr>
                    <td>Bedlamp</td>
                    <td><label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                        </label></td>
                </tr>
                <tr>
                    <td>AC</td>
                    <td><label class="switch">
                        <input type="checkbox">
                        <span class="slider round"></span>
                        </label></td>
                </tr>
            </table>
        </div>
        <script>
            //collapse the switches
            var coll = $(".collapsible");
            var i;
            for (i = 0; i < coll.length; i++) {
                coll[i].addEventListener("click", function() {
                    this.classList.toggle("active");
                    var content = this.nextElementSibling;
                    if (content.style.display === "block") {
                        content.style.display = "none";
                    } else {
                        content.style.display = "block";
                    }
                });
            }
            
            //set the values of switches
            $(".mySwitch").each(function(){
                var thisID= $(this).attr('id');             
                 $.get("/read.php?pin="+ thisID,function(data){
                     if (data != 0)
                     $("#"+thisID).prop("checked", true);
                     })
                });
            
            //detect switch change
            function myFunction(pin) {
                var checkBox = document.getElementById(pin);
                if (checkBox.checked == true){
                   $.ajax({
                            type: "GET",
                            url: "/on.php?pin="+pin
                        });
                } else {
                    $.ajax({
                            type: "GET",
                            url: "/off.php?pin="+pin
                        });
                }
            }
        </script>
    <?php
    }
    ?>
    </body>
</html>
