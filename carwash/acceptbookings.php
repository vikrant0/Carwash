
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
  <a href="admin.php">View Bookings</a>
  <a href="addplaces.php">Add Places</a>
  <a href="addservices.php">Add Services</a>
  <a class="active" href="acceptbookings.php">Accept Bookings</a>
  <a href="index.php">Sign Out</a>
</div>

<div class="content">
<h1>
  <?php
    session_start();
    include('connection.php');
    $check=$db->prepare('SELECT * FROM bookings where accepted=?');
    $data=array(0);
    $check->execute($data);
    if($check->rowcount()==0){
      //No bookings yet

  ?>
  <section id="adminform" class="section_class">
    <div class="col-sm-12" style="margin-top: 30px;">
      <div class="col-sm-3"></div>
    <div class="col-sm-6">
        
          <!-- Add a new activity -->
        <div class="add_club_coordinator" style="margin-bottom: 20px;">
          <div class="admin_heading">
            <h1 style="text-align: center;">No Bookings to Accept!!!</h1>
          </div>
          <!-- <form id="activityform">
            <div class="form-group">
              <input type="text" id="club_name" placeholder="Club Name" class="form-control" required>
            </div>
            <div class="form-group">
              <textarea id="description" placeholder="Description" class="form-control" required rows="4"></textarea>
            </div>
            <div class="form-group">
              <input type="submit" value="Submit" class="btn btn-success btn-block" onclick="savedata();">
            </div>  
          </form> -->
        </div>

      </div>
    <div class="col-sm-3"></div>
      
    </div>
  </section>

  <?php
    }
    else{

  ?>

      <div class="col-sm-12">
      <!-- All Activities -->
      <div class="admin_tick" style="text-align: left;margin-bottom: 20px;">
        <div class="admin_heading" style="margin-bottom: 20px;">
          <h1 style="text-align: center;">Accept Bookings of Customers</h1>
          <h5 style="text-align: center;">You can also Cancel the Accepted bookings from the <B> VIEW BOOKINGS TAB</B>!!!</h5>
        </div>
        <!-- //create php  -->
        <!-- <h4 style="text-align: center;">Remove Club coordinator</h4> -->
      
        <!-- </table> -->
        <?php
          // session_start();
          
          include('connection.php');
          $check=$db->prepare('SELECT * FROM bookings where accepted=?');
          $data=array(0);
          $check->execute($data);
          if($check->rowcount()==0){
            echo 'Empty Table'; //->> 0 for account does not exist
          }

          else{
            ?>
            <table>
              <tr>
              <th>Bookin Id</th>
              <th>User Name</th>

              <th>Date</th>
              <th>Place</th>
              <th>Service</th>
              <th>Action</th>
              </tr>

            <?php
            while($datarow=$check->fetch()){
              ?>
              
              <tr>
                  <td><?php echo $datarow['bid'] ?></td>
                  <td><?php echo $datarow['uid'] ?></td>
                  <td><?php echo $datarow['date'] ?></td>
                  <td><?php echo $datarow['place'] ?></td>
                  <td><?php echo $datarow['service'] ?></td>
                  <td>
                    <button onclick="acceptbooking(<?php echo $datarow['bid'] ?>)" 
                    style="text-decoration:none;
                    background: green;
                    border: none;
                    border-radius: 5px;
                    padding: 0px 10px;
                    color: white;
                    margin: 10px;">Accept</button>
                    <button onclick="cancelbooking(<?php echo $datarow['bid'] ?>)" 
                      style="text-decoration:none;
                      background: red;
                      border: none;
                      border-radius: 5px;
                      padding: 0px 10px;
                      color: white;
                      margin: 10px;">Cancel</button>
                  </td>
                </tr>



              <?php
            }
            echo "</table>";
            
          }

        ?>

      </div>

  <?php
    }
  ?>
</h1>
</div>


<script type="text/javascript">
  
  function acceptbooking(bid){
    // =document.getElementById('delete_id').value;
    // alert(uid);
    // alert(uid+" "+email);
    if(bid!=""){
      
      //sending data to backend
      //using ajax post
      // alert('sending data');
      $.ajax(
      {
        type:"POST",
        url:"ajax/accept_booking.php",
        data:{bid:bid},
        success:function(data){
          if(data==0){
            alert('Activity Does not exist!!!');
          }
          else if(data == 1){
            //account created
            alert('Successfully accepted booking!!!');
            open("acceptbookings.php","_self"); //refresh the page

          }
          else if(data == 2){
            alert('Some problem encountered!');
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

  function cancelbooking(bid){
    // =document.getElementById('delete_id').value;
    // alert(uid);
    // alert(uid+" "+email);
    if(bid!=""){
      
      //sending data to backend
      //using ajax post
      // alert('sending data');
      $.ajax(
      {
        type:"POST",
        url:"ajax/cancel_booking.php",
        data:{bid:bid},
        success:function(data){
          if(data==0){
            alert('booking Does not exist!!!');
          }
          else if(data == 1){
            //account created
            alert('Successfully cancelled booking!!!');
            open("acceptbookings.php","_self"); //refresh the page

          }
          else if(data == 2){
            alert('Some problem encountered!');
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
</body>
</html>