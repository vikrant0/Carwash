<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title></title>
  <link rel="stylesheet" type="text/css" href="normalize.css">
  <link rel="stylesheet" type="text/css" href="bootstrap.min.css">
  
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <style >
    table {
    border-collapse: collapse;
    width: 100%;
    /*overflow: auto;*/
    color: #588c7e;
    font-family: monospace;
    font-size: 20px;
    text-align: left;
    }
    th {
    background-color: #588c7e;
    color: white;
    }
    tr:nth-child(even) {background-color: #f2f2f2}
  </style>
  <style>
    body {
      margin: 0;
      font-family: "Lato", sans-serif;
    }

    .sidebar {
      margin: 0;
      padding: 0;
      width: 200px;
      background-color: black;
      position: fixed;
      height: 100%;
      overflow: auto;
      font-size: 20px;
    }

    .sidebar a {
      display: block;
      color: white;
      padding: 16px;
      text-decoration: none;
    }
     
    .sidebar a.active {
      background-color: white;
      color: black;
    }

    .sidebar a:hover:not(.active) {
      background-color: #555;
      color: white;
    }

    div.content {
      margin-left: 200px;
      padding: 1px 16px;
      /*height: 1000px;*/
    }

    @media screen and (max-width: 700px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
      }
      .sidebar a {float: left;}
      div.content {margin-left: 0;}
    }

    @media screen and (max-width: 400px) {
      .sidebar a {
        text-align: center;
        float: none;
      }
    }
  </style>
</head>
<body> 
  
<div class="sidebar">
  <a class="active" href="bookservice.php">Company</a>
  <a href="bookingstatus.php">Investment Status</a>
  <a href="index.php">Sign Out</a>
</div>


<div class="content">
  <section id="adminform" class="section_class">
    <div class="col-sm-12">
      <div class="col-sm-6">
          <!-- //student places -->
          
      
          <div class="admin_tick" style="text-align: left;margin-bottom: 20px;">
            <div class="admin_heading" style="margin-bottom: 20px;">
              <h1 style="text-align: center;">Companies</h1>
            </div>
            <?php
              session_start();
              
              include('connection.php');
              $check=$db->prepare('SELECT * FROM place');
              // $data=array($_SESSION['uid']);
              $check->execute();
              if($check->rowcount()==0){
                echo 'Add some places to see here!!!'; //->> 0 for account does not exist
              }

              else{
                ?>
                <table>
                  <tr>
                  <th>Company Id</th>
                  <th>Company</th>
                  <th>ESG</th>
                  <!-- <th>action</th> -->
                  </tr>

                <?php
                while($datarow=$check->fetch()){
                  ?>
                  
                  <tr>
                      <td><?php echo $datarow['pid'] ?></td>
                      <td><?php echo $datarow['place'] ?></td>
                      <td><?php echo $datarow['city'] ?></td>
                      <!-- <td><button onclick="deleteplace(<?php echo $datarow['pid'] ?>)" 
                        style="text-decoration:none;
                        background: red;
                        border: none;
                        border-radius: 5px;
                        padding: 0px 10px;
                        color: white;
                        margin: 10px;">Delete</button></td> -->
                    </tr>



                  <?php
                }
                echo "</table>";
                
              }

            ?>
          </div>

          <!-- //available services -->
          <div class="admin_tick" style="text-align: left;margin-bottom: 20px;">
            <div class="admin_heading" style="margin-bottom: 20px;">
              <h1 style="text-align: center;">ESG Range</h1>
            </div>
            <?php
              // session_start();
              
              include('connection.php');
              $check=$db->prepare('SELECT * FROM services');
              // $data=array($_SESSION['uid']);
              $check->execute();
              if($check->rowcount()==0){
                echo 'No compaines available!!!'; //->> 0 for account does not exist
              }

              else{
                ?>
                <table>
                  <tr>
                  <th>Id</th>
                  <th>Service Name</th>
                  <!-- <th>action</th> -->
                  </tr>

                <?php
                while($datarow=$check->fetch()){
                  ?>
                  
                  <tr>
                      <td><?php echo $datarow['serviceid'] ?></td>
                      <td><?php echo $datarow['servicename'] ?></td>
                      <!-- <td><button onclick="deleteplace(<?php echo $datarow['pid'] ?>)" 
                        style="text-decoration:none;
                        background: red;
                        border: none;
                        border-radius: 5px;
                        padding: 0px 10px;
                        color: white;
                        margin: 10px;">Delete</button></td> -->
                    </tr>



                  <?php
                }
                echo "</table>";
                
              }

            ?>
          </div>
          
      </div>

      <div class="col-sm-6">
        
          <div class="admin_tick" style="text-align: left;margin-bottom: 20px;">
            <div class="admin_heading" style="margin-bottom: 20px;">
              <h1 style="text-align: center;">Make Investment</h1>
            </div>
            <form id="adminform">
              <!-- <div class="form-group">
                <input type="date" id="date" placeholder="dd-mm-yyyy" class="form-control" required>
              </div> -->
              <div class="form-group">
                <input type="text" id="placeid" placeholder="Company ID" class="form-control" required>
              </div>
             <!--  <div class="form-group">
                <input type="text" id="serviceid" placeholder="ESG Value" class="form-control" required>
              </div> -->
              <div class="form-group">
                <input type="submit" value="Invest" class="btn btn-success btn-block" onclick="savedata();">
              </div>  
            </form>
          </div>
      </div>
      
    </div>
    <div class="col-sm-12">
      <!-- SCREENSHOT IMAGE  -->
      <img src=" " height="1000px" width="1000px"/>
    </div>
  </section>
</div>
<script type="text/javascript">
  function savedata(){
    var date=document.getElementById('date').value;
    var placeid=document.getElementById('placeid').value;
    var serviceid=document.getElementById('serviceid').value;

    if(placeid!="" && serviceid!="" && date!=""){
      
      $.ajax(
      {
        type:"POST",
        url:"ajax/book_service.php",
        data:{date:date,placeid:placeid, serviceid:serviceid},
        success:function(data){

          if(data == 0){
            alert('Invalid details');
          }
          else if(data == 1){
            //successfully added place
            alert('Booking Successfull');
            open("bookservice.php","_self"); //refresh the page

          }
          else if(data == 5){
            alert('Bookings full on that day!! choose another');
          }
          else{
            alert(data);
          }
        }
      }
      );

    }
    else 
    {
      alert("Invalid Input!");
    }
    
  }
</script>
<script type="text/javascript">
    $('form').submit(function(e) {
    e.preventDefault();
});</script>
</body>
</html>