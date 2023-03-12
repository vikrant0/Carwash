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
  <a class="active"  href="addplaces.php">Add Places</a>
  <a href="addservices.php">Add Services</a>
  <a href="acceptbookings.php">Accept Bookings</a>
  <a href="index.php">Sign Out</a>
</div>



<div class="content">
  <section id="adminform" class="section_class">
		<div class="col-sm-12">
			<div class="col-sm-6">
					<!-- //student coordinators -->
					
			
					<div class="admin_tick" style="text-align: left;margin-bottom: 20px;">
						<div class="admin_heading" style="margin-bottom: 20px;">
							<h1 style="text-align: center;">Available Places</h1>
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
									<th>Id</th>
									<th>Place</th>
									<th>City</th>
									<th>action</th>
									</tr>

								<?php
								while($datarow=$check->fetch()){
									?>
									
									<tr>
											<td><?php echo $datarow['pid'] ?></td>
											<td><?php echo $datarow['place'] ?></td>
											<td><?php echo $datarow['city'] ?></td>
											<td><button onclick="deleteplace(<?php echo $datarow['pid'] ?>)" 
												style="text-decoration:none;
												background: red;
												border: none;
												border-radius: 5px;
												padding: 0px 10px;
												color: white;
												margin: 10px;">Delete</button></td>
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
							<h1 style="text-align: center;">Add Places</h1>
						</div>
						<form id="adminform">
							<div class="form-group">
								<input type="text" id="place" placeholder="Place" class="form-control" required>
							</div>
							<div class="form-group">
								<input type="text" id="city" placeholder="City" class="form-control" required>
							</div>
							<div class="form-group">
								<input type="submit" value="Submit" class="btn btn-success btn-block" onclick="savedata();">
							</div>	
						</form>
					</div>
			</div>
			
		</div>
	</section>
</div>
<script type="text/javascript">
	function savedata(){
		var place=document.getElementById('place').value;
		var city=document.getElementById('city').value;

		if(place!="" && city!=""){
			
			$.ajax(
			{
				type:"POST",
				url:"ajax/add_place.php",
				data:{place:place, city:city},
				success:function(data){

					if(data == 0){
						alert('Place already exists!');
					}
					else if(data == 1){
						//successfully added place
						open("addplaces.php","_self"); //refresh the page

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
	function deleteplace(pid){
		// =document.getElementById('delete_id').value;
		// alert(uid);
		// alert(uid+" "+email);
		if(pid!=""){
			
			//sending data to backend
			//using ajax post
			// alert('sending data');
			$.ajax(
			{
				type:"POST",
				url:"ajax/delete_place.php",
				data:{pid:pid},
				success:function(data){
					if(data==0){
						//place does not exist
					}
					else if(data == 1){
						//delete place successfully
						open("addplaces.php","_self"); //refresh the page

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
<script type="text/javascript">
    $('form').submit(function(e) {
    e.preventDefault();
});</script>
</body>
</html>