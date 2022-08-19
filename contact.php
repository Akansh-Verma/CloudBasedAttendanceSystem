<?php
$array = array("firstname" => "", "name" => "", "email" => "", "phone" => "", "message" => "", "firstnameError" => "", "nameError" => "", "phoneError" => "", "messageError" => "","isSuccess" => false);

$emailto = "test@test.com";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $array['firstname'] = verifyInput($_POST['firstname']);
    $array['name'] = verifyInput($_POST['name']);
    $array['email'] = verifyInput($_POST['email']);
    $array['phone'] = verifyInput($_POST['phone']);
    $array['message'] = verifyInput($_POST['message']);
    $array['isSuccess'] = true;
    $emailText = "";
    

    if (empty($array['firstname'])) {
        $array['firstnameError'] = "je veux connaître ton prénom";
        $array['isSuccess'] = false;
    }else{
        $emailText .= "firstname: {$array['firstname']}\n";
    }

    if (empty($array['name'])) {
        $array['nameError'] = "Et même ton nom";
        $array['isSuccess'] = false;
    } else {
        $emailText .= "name: {$array['name']}\n";
    }

    if(!isEmail($array['email'])){
        $array['emailError'] = " Ce n'est pas un email valide !";
        $array['isSuccess'] = false;
    } else {
        $emailText .= "email: {$array['email']}\n";
    }

    if(!isPhone($array['phone'])){
        $array['phoneError'] = " Que des chiffres et des espaces ";
        $array['isSuccess'] = false;
    } else {
        $emailText .= "phone: {$array['phone']}\n";
    }

    if (empty($array['message'])) {
        $array['messageError'] = "Que veux tu me dire ?";
        $array['isSuccess'] = false;
    } else {
        $emailText .= "message: {$array['message']}\n";
    }

    if($array['isSuccess']){
        $headers = "From: {$array['firstname']} {$array['name']} <{$array['email']}>\r\n\Reply-To: {$array['email']}";
        mail($emailto, "un message de votre site",$emailText,$headers);
    }

    echo json_encode($array);

}

function verifyInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

function isEmail($var){
    return filter_var($var, FILTER_VALIDATE_EMAIL);
}

function isPhone ($var){

    // expression régulière
    return preg_match("/^[0-9 ]*$/", $var);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Contact Us !</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<style>
    body{
    font-family: 'Lato', sans-serif;
    margin: 70px 0px;
    background: #0069d6;
}

.divider{
    width: 100px;
    height: 2px;
    background: #ffa500;
    margin: 0 auto;
}

.heading{
    text-align: center;
    margin-bottom: 60px;
}

.heading h2{
    color: white;
    text-transform: uppercase;
    font-weight: bold;
}

#contact-form{
    font-size: 20px;
    background: white;
    padding: 40px;
    border-radius: 10px;
}

.blue{
    color: #0069d6;
}

.form-control{
    height: 50px;
    font-size: 18px;
}

.comments{
    color:#d82c2e;
    font-style: italic;
    font-size:18px;
    height: 25px;
}

#contact-form input[type="submit"]
{
    margin: 10px auto 0;
    display: block;
}

.button1{
    border: 1px solid #ddd;
    background: #ffa500;
    color: #fff;
    width: 100%;
    font-weight: bold;
    text-transform: uppercase;
    padding: 13px;
    border-radius: 5px;
    transition: all 0.3s ease-in 0s;
}

.button1:hover{
 
    background: #333;
    border-color: #ffa500;
}

.thank-you{
    text-align: center;
    margin-top: 15px;
    font-weight: bold;
    font-size: 22px;
}
    </style>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Online Attendance</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right bg-red">
            <li class="active"><a href="index.php">Home</a></li>
            <!-- <li><a href="#about">About</a></li> -->
            <li><a href="contact.php">Contact</a></li>
          
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
        <div class="divider"></div>

        <div class="heading">
            <h2> Contact Us</h2>
        </div>

        <div class="row">
            <div class="col-lg-10 col-lg-offset-1">
                <form id="contact-form" method="post" action=" " role="form">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="firstname">First name <span class="blue">*</span></label>
                            <input required type="text" name="firstname" class="form-control" placeholder="Enter your firstname" id="firstname" value="">
                            <p class="comments">  </p>
                        </div>

                        <div class="col-md-6">
                            <label for="lastname">Last name <span class="blue">*</span></label>
                            <input required type="text" name="name" class="form-control" placeholder="Your Lastname" id="name" value=" ">
                            <p class="comments"> </p>
                        </div>

                        <div class="col-md-6">
                            <label for="email">Email <span class="blue">*</span></label>
                            <input required type="email" name="email" class="form-control" placeholder="Enter email" id="email" value=" ">
                            <p class="comments"> </p>
                        </div>

                        <div class="col-md-6">
                            <label for="phone">Telephone</span></label>
                            <input type="tel" name="phone" class="form-control" placeholder="Enter telephone" id="phone" value=" ">
                            <p class="comments"> </p>
                        </div>

                        <div class="col-md-12">
                            <label for="message">Message <span class="blue">*</span></label>
                            <textarea required name="message" id="message" class="form-control" placeholder="write message" rows="4"> </textarea>
                            <p class="comments">  </p>
                        </div>

                        <div class="col-md-12">
                            <p class="blue"><strong> * This information is required !</strong> </p>
                        </div>

                        <div class="col-md-12">
                            <input type="submit" class="button1" value="Send">
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>
<script>
    $(function(){

$('#contact-form').submit( function(e) {

    e.prevendDefault();
    $('.comments').empty();

    var postData = $('#contact-form').serialize();

    $.ajax({
        type: 'POST',
        url: 'php/contact.php',
        data: postData,
        dataType: 'json',
        success: function(result){

            if(result.isSuccess){
                $('#contact-form').append("<p class='thank-you'> Votre message a bien été envoyé. Merci de m'avoir contacté ! </p>");
                $('#contact-form')[0].reset();
            }
            else{
                $('#firstname + .comments').html(result.firstnameError);
                $('#name + .comments').html(result.nameError);
                $('#email + .comments').html(result.emailError);
                $('#phone + .comments').html(result.phoneError);
                $('#message + .comments').html(result.messageError);
            }
        }
    })
});
});
    </script>
</html>