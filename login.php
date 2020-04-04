<?php
//This script will handle login
session_start();

// check if the user is already logged in
require_once "config.php";

$username = $password = "";
$err = "";

// if request method is post
if ($_SERVER['REQUEST_METHOD'] == "POST"){
    if(empty(trim($_POST['username'])) || empty(trim($_POST['password'])))
    {
        $err = "Please enter username + password";
    }
    else{
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }


if(empty($err))
{
    $sql = "SELECT id, username, password FROM sysusers WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;
    
    
    // Try to execute this statement
    if(mysqli_stmt_execute($stmt)){
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt))
                    {
                        if(password_verify($password, $hashed_password))
                        {
                            // this means the password is corrct. Allow user to login
                            session_start();
                            $_SESSION["username"] = $username;
                            $_SESSION["id"] = $id;
                            $_SESSION["loggedin"] = true;

                            //Redirect user to welcome page
                            header("location: index.html");
                            
                        }
                    }

                }

    }
}    


}


?>

<html>
<head>
<title></title>
<link href="c.css" rel="stylesheet" type="text/css"></link>
</head>
<body>
<div class="log-box">
<img class="usrimg" src="usr.png" >
<h2>Log In</h2>
<form id="theForm" action="" method="post">
<label>Username</label><br />
<input  name="username" placeholder="Enter Name" type="text" />
<label>Password</label><br />
<input name="password" placeholder="Enter Password" type="Password" />
<input name="" onclick="hello()" type="submit" value="Log In" />
<br/> 
&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <br />
<br />
<a href="https://www.facebook.com">Facebook</a>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp <a href="register.php">Sign up</a>
</form>
</div>
<script type="text/javascript">
    var h="Welcome to Naukri.com";
   function hello() {
       alert(h);
   }
</script>
</body>
</html>