<?php 
 
	
    if(isset($_POST["query_type"]) && $_POST["query_type"] == "login") 	{

        session_start();
        include("classes/connect.php");
        include("classes/login.php");
     
        $email = "";
        $password = "";
        


		$login = new Login();
		$result = $login->evaluate($_POST);
		
		if($result != "")
		{

			echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
			echo "<br>The following errors occured:<br><br>";
			echo $result;
			echo "</div>";
		}else
		{

			header("Location:" .ROOT. "profile");
			die;
		}
 

		$email = $_POST['email'];
		$password = $_POST['password'];
		
	}

 

	if(isset($_POST["query_type"]) && $_POST["query_type"] == "signup") 
	{
        include("classes/connect.php");

        include("classes/signup.php");

        $first_name = "";
        $last_name = "";
        $gender = "";
        $email = "";


		$signup = new Signup();
		$result = $signup->evaluate($_POST);
		
		if($result != "")
		{

			echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
			echo "<br>The following errors occured:<br><br>";
			echo $result;
			echo "</div>";
		}else
		{    session_start();
            include("classes/login.php");
         
            $login = new Login();
            $result = $login->evaluate($_POST);
            
            if($result != "")
            {
    
                echo "<div style='text-align:center;font-size:12px;color:white;background-color:grey;'>";
                echo "<br>The following errors occured:<br><br>";
                echo $result;
                echo "</div>";
            }else
            {
    
                header("Location:" .ROOT. "profile");
                die;
            }

		}
 

		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$gender = $_POST['gender'];
		$email = $_POST['email'];

	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUT family || Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    

</head>
<style>
@font-face {
    font-family: 'Capture';
    src: url('/fonts/Capture.ttf');
    }
#bar{
        height:100px;
        background-color: #ffb308;
        color: white;
        padding: 4px;
        text-align:center;
        box-shadow: 5px 20px 20px #000;

    }

#bar2{
        background-color: white;
        width: 500px;
        height:auto;
        margin:auto;
        padding:10px;
        padding-top: 50px;
        text-align: center;
        font-weight: bold;
        margin-top:50px;
        border-radius:20px;
    }
    input{
        width: 60%;
        height: 10px;
        background: #e0dede;

        display:flex;
        margin:auto;
        padding: 10px;
        border: none;
        border-radius: 10px;
        margin-top:10px;
        margin-bottom:-20px;
    }
    select{
        width: 30%;
        height: 10px;
        background: #e0dede;
        display:flex;
        margin:auto;
        padding: 10px;
        border: none;
        border-radius: 10px;
        margin-top:10px;
        margin-bottom:-20px;
    }
    #chk{
	display: none;
}
    #chk:checked ~ .login{
	transform: translateY(-400px);
    }
    #chk:checked ~ .login label{
        transform: scale(1.2);	
    }
    #chk:checked ~ .signup label{
        transform: scale(.6);
    }
    .login{
	height: 600px;
	background: #eee;
	border-radius: 60% / 10%;
	transform: translateY(-100px);
	transition: .8s ease-in-out;
}
.login label{
	color: #573b8a;
	transform: scale(0.75);
}
label{
	color: #fff;
	font-size: 2.3em;
	justify-content: center;
	display: flex;
	margin: 60px;
	font-weight: bold;
	cursor: pointer;
	transition: .5s ease-in-out;
    margin-bottom:20px;
    margin-top:20px;
}
.signup{
	position: relative;
	width:100%;
	height: 100%;
    padding-top:-20px;
}
body{
    font-family: tahoma;
    background: rgb(46,46,46);
    background: linear-gradient(0deg, rgba(46,46,46,1) 0%, rgba(74,72,72,0.9528186274509804) 48%, rgba(46,46,46,1) 100%);
    height:100%;
    width:100%;
    margin:0px;
    padding:0px;
    
}
button{
	width: 60%;
	height: 40px;
	margin: 10px auto;
	justify-content: center;
	display: block;
	color: #fff;
	background:  #ffa102;
	font-size: 1em;
	font-weight: bold;
	margin-top: 20px;
	outline: none;
	border: none;
	border-radius: 5px;
	transition: .2s ease-in;
	cursor: pointer;
}
button:hover{
	background: #ffb308;
}
.main{
	width: 350px;
	height: 440px;
	overflow: hidden;
	border-radius: 20px;
	box-shadow: 5px 20px 50px #000;
    margin:auto;
    margin-top:30px;
}
#but{
    
    margin-top:30px;
    float:left;
    height:400px;
}
.But_fam{
    font-family: 'Capture';
    font-size:100px;
    color:black;
    margin:auto;
    margin-top:-10px;
    float:left;
}
p{
    color:white;
    text-align:center;
    font-size:24px;
}
#block1{
    flex:2

}
#block2{
    flex:1;
    margin-left:10px;
    align-items:flex-start;
    flex-direction: column;
    flex-wrap:wrap;
}
#content{
    display:flex;
    width:100%;
}
#header{
    margin:auto;
    width:60%;
}
#logo{
    height:110px;
    margin-top:-5px;
    float:left;
}
@media only screen and (max-width:1050px){
    #bar{
        height:100px;
        background-color: #ffb308;
        color: white;
        padding: 4px;
        text-align:center;
        justify-content: center;
        box-shadow: 5px 20px 20px #000;
        flex-wrap:nowrap;
        align-items:flex-start;

    }
    .But_fam{
    font-family: 'Capture';
    font-size:6em;
    color:black;
    margin:auto;
    margin-top:-10px;
    float:left;
}
#header{
    margin:auto;
    width:70%;
}
}
@media only screen and (max-width:1000px){
    .But_fam{
    font-family: 'Capture';
    font-size:auto;
    width:80%;
    color:black;
    margin:auto;
    margin-top:-10px;
    float:left;
}
#header{
    margin:auto;
    width:100%;
}
}
@media only screen and (max-width:850px){
    #bar{
        height:100px;
        background-color: #ffb308;
        color: white;
        padding: 4px;
        text-align:center;
        justify-content: center;
        box-shadow: 5px 20px 20px #000;
        flex-wrap:nowrap;
        align-items:flex-start;

    }
    #content{
        flex-wrap: wrap;
    }
}
@media only screen and (max-width:830px){
    #block2{
        flex:1;
        margin-left:10px;
        justify-content:center;
        margin:auto;
        flex-direction: column;
        flex-wrap:wrap;
}
}
@media only screen and (max-width:650px){
    .But_fam{
    font-family: 'Capture';
    font-size:85px;
    width:80%;
    color:black;
    margin:auto;
    margin-top:-10px;
    float:left;
}
#logo{
    height:90px;
    margin-top:-5px;
    float:left;
}
#bar{
        height:80px;
        background-color: #ffb308;
        color: white;
        padding: 4px;
        text-align:center;
        justify-content: center;
        box-shadow: 5px 20px 20px #000;
        flex-wrap:nowrap;
        align-items:flex-start;

    }


}
@media only screen and (max-width:580px){
    .But_fam{
    font-family: 'Capture';
    font-size:70px;
    width:80%;
    color:black;
    margin:auto;
    margin-top:-10px;
    float:left;
  
}
#logo{
    height:90px;
    margin-top:-5px;
    float:left;
}
#bar{
    height:80px;
    background-color: #ffb308;
    color: white;
    padding: 4px;
    text-align:center;
    justify-content: center;
    box-shadow: 5px 20px 20px #000;
    flex-wrap:nowrap;
   

    }
    #but{
    
    margin-top:30px;
    float:left;
    height:350px;
}


}
@media only screen and (max-width:480px){
    .But_fam{
    font-family: 'Capture';
    font-size:60px;
    width:80%;
    color:black;
    margin:auto;
    margin-top:-10px;
    float:left;
  
}

}

</style>
<body>
    <div id="bar">
        <div id="header">
            <img src="/icons/logo.png" id="logo">
            <div class="But_fam"> BUT family</div>
        </div>
    </div>
    <div id="content">

    <div id="block2">
        <img src="/icons/123.png" id="but"><br>
        <p>Станьте частью семьи Bucheon!</p>
    </div>
    <div id="block1" >
        <div class="main"> 	
        <input type="checkbox" id="chk" aria-hidden="true">

        <!--SIGN UP FORM-->
        <div class="signup">
       
            <form method="post">
            <input type="hidden" name="query_type" value="signup">
            <label for="chk" aria-hidden="true" style="color:#ffb308">Sign up</label>
                <div style="padding-left:9%;padding-right:9%">
                    <input style="width:39%;white-space: nowrap;float:left;" value="<?php echo $first_name ?>" required="" name="first_name" type="text" id="text" placeholder="First name"> &nbsp
                    <input style="width:39%;white-space: nowrap;float:left;margin-left:4%" value="<?php echo $last_name ?>" required="" name="last_name" type="text" id="text" placeholder="Last name"><br><br>
                </div>
                    <span style="margin-top:5px;margin-bottom:5px;text-align:center;justify-content:center;display:flex;color:white">Gender:</span>
                    <select name="gender" style="margin:auto; display:flex;">
                        <option><?php echo $gender ?></option>
                        <option>Male</option>
                        <option>Female</option>
                    </select>
            
                    <input style="margin:auto;margin-top:10px;" value="<?php echo $email ?>" name="email" required="" type="text" id="text" placeholder="Email"><br>
                    
                    <input style="margin:auto;margin-top:-10px;" name="password" type="password" id="text" required=""  placeholder="Password"><br>
                    <input style="margin:auto;margin-top:-10px;" name="password2" type="password" id="text" required="" placeholder="Retype Password">

                    <button type="submit" id="button1" value="Sign up"> Sign up</button>
                    <br>

            </form>

        </div>


            

        <!--Login form-->

                <div class ="login">
                    
                    <form method="post" style="padding-top:5px;">
                    <input type="hidden" name="query_type" value="login">
                    <label for="chk" aria-hidden="true" style="color:#2e2e2e;">Login</label><br>

                        <input style="margin:auto;" name="email" value="<?php echo $email ?>" type="text" id="text" placeholder="Email" required=""><br><br>
                        <input style="margin:auto;margin-top:-10px;" name="password" required="" value="<?php echo $password ?>" type="password" id="text" placeholder="Password"><br>

                        <button type="submit" id="button2" value="Log in">Login</button>
                        <br><br><br>

                    </form>
                </div>
            </div>


    </div>
    </div>
</div>
</body>
</html>

