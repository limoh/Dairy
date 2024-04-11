<!DOCTYPE html>
        <html>
            <head>
                <meta charset="utf-8" />
                <script type="text/javascript" src="<?php Page_Url() ?>js/jquery-1.8.2.js"></script>
                <script type="text/javascript" src="<?php Page_Url() ?>js/bootstrap.js"></script>
                <script type="text/javascript" src="<?php Page_Url() ?>js/bootstrap-datetimepicker.min.js"></script>

                <link type="text/css" rel="stylesheet" href="<?php Page_Url() ?>css/bootstrap.css" /> 
                <link type="text/css" rel="stylesheet"	href="<?php Page_Url() ?>css/bootstrap-responsive.css" />
                <link type="text/css" rel="stylesheet" href="<?php Page_Url() ?>css/main.css" />
                <link type="text/css" rel="stylesheet" href="<?php Page_Url() ?>css/bootstrap-datetimepicker.min.css" />
                <title> A Model To Predict Milk Production For Dairy Farmers - Login</title>
            </head>
            <body >
                <div id="top" class="page-header">
                    <a href="<?php Page_Url(); ?>"><img src="<?php Page_Url() ?>img/logo1.png"/ alt="logo" id="logo"></a>

                    <div id="navigation" class="navbar ">
                        <h2 id="title" > A Model To Predict Milk Production For Dairy Farmers</h2>
                    </div>
                </div>
               
<div class = "container">
	<div class="wrapper">
		<form name="<?php echo $formname; ?>" method="post" class="form-signin form-horizontal <?php echo $formclass ?>" enctype="application/x-www-form-urlencoded" action="<?php echo $formaction ?>">       
		    <h3 class="form-signin-heading">Login</h3>
			  <hr class="colorgraph"><br>
			  
			  <input type="text" class="form-control input-xlarge input-block-level" name="username" placeholder="Username/Email" required="" autofocus="" /> 
			  <input style="margin-top: 20px;" type="password" class="form-control input-xlarge input-block-level input" name="password" placeholder="Password" required=""/>     		  
			  <input name="action" id="action" value="login" type="hidden">
			  <input class="btn btn-lg btn-primary btn-block"  name="Submit" value="Login" type="Submit"> 

		</form>	
<a class="btn btn-small btn-success" href="register.php">Farmer Registration</a><br/><br/> 
	</div>
</div>

               <!--  <div class="">
                    <form name="<?php echo $formname; ?>" method="post" id="<?php echo $formname; ?>" class="form-horizontal <?php echo $formclass ?>" enctype="application/x-www-form-urlencoded" action="<?php echo $formaction ?>">
                        <div class="control-group"><label  class="control-label" for="username">Username</label>
                            <div class="controls">
                                <input  class=""  name="username" id="username" type="text">
                            </div>
                        </div>
                        <div class="control-group"><label class="control-label" for="password">Password</label>
                            <div class="controls">
                                <input  class="input-xlarge" name="password" id="password" type="password">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <input name="action" id="action" value="login" type="hidden">
                                <input class="btn btn-large btn-inverse" name="submit" id="submit" value="Login" type="submit">
                            </div>
                        </div>
                        <div>

                    </form>
                </div> -->

                <?php
                  include __DIR__ . "/../incl/footer.incl.php"
                ?>