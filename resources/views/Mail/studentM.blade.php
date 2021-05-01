<!DOCTYPE html>
<html>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
body {font-family: "Times New Roman", Georgia, Serif;}
h1, h2, h3, h4, h5, h6 {
  font-family: "Playfair Display";
  /*letter-spacing: 5px;*/
}
</style>
<body>

<!-- Navbar (sit on top) -->


<!-- Header -->
    <div style="background-color:black;width: 100%;padding: 10px;" >
      <div style="text-align:center">
      <a target="_blank" href="http://f1inschoolsindia.timeofsports.com/"><img style="width:300px;  align:middle; hspace:20;"   src="http://f1inschoolsindia.timeofsports.com/public/Tosimage/tos.png"></a>
    </div>
</div>

<!-- Page content -->
<div class="w3-content" style="max-width:1100px">


  <!-- Menu Section -->
  <div class="w3-row w3-padding-64" id="menu">
    <div class="w3-col l6 w3-padding-large">
      <h4>Dear {{$name}}</h4>
      <p class="w3-text-grey">
       Greetings from Time of Sports!
       Welcome aboard the world’s largest STEM based challenge for school students- F1 in Schools™ . Your username and password to login is here{{url('studentpasswordreset').'?email='.urlencode($email)}}"> click here </a>
      </p>
    
       
      <p>
         Kind Regards
       </p>
       <p>
        Competition Management Desk
      </p>
    

    </div>
    


    <div class="w3-col l6 w3-padding-large text-center">
     <a href="#" target="_blank" style="color:#999999; text-decoration:underline;">PRIVACY STATEMENT</a> | <a href="#" target="_blank" style="color:#999999; text-decoration:underline;">TERMS OF SERVICE</a> | <a href="#" target="_blank" style="color:#999999; text-decoration:underline;">RETURNS</a><br>
                  © 2019 Timesofsport. All Rights Reserved.<br>
                  If you do not wish to receive any further emails from us, please <a href="#" target="_blank" style="text-decoration:none; color:#999999;">unsubscribe</a>
    </div>
  </div>

  <hr>


<!-- End page content -->
</div>

<!-- Footer -->
<footer class="w3-center w3-padding-32" style="background-color:red" >
    <!-- <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-text-green"> -->
      <!-- <img style="width:300px"   src="http://f1inschoolsindia.timeofsports.com/public/Tosimage/Stretch_India_White.png"> -->
<!-- </a> -->
</footer>

</body>
</html>