<?php

	include('../connection.php');
	session_start();
	//-->> trim all the data using a trim function
	$service = $_POST['service'];
	
	if(validate()){

		//preparing a query
		
		$check=$db->prepare('SELECT * FROM services WHERE  servicename = ?');
		$data=array($service); //for below 'if' statement
		//city can be same so i am not including it in data
	

		//execute the query by combining data in the check table
		$check->execute($data);
		if($check->rowcount()==1){
			echo 0; //->> 0 for already existing place
		}
		else{
			
			//creating new service

			//creating a new query
			$query=$db->prepare("INSERT INTO services(servicename) VALUES (?)");
			$data=array($service);

			//execute 
			if($query->execute($data)){	
				echo 1; //place added successfully
			}
			else echo 2;


		}

	}

	//trim function
	function trim_data(){
		//-->> to complete this function
	}

	function validate(){
		//-->> to complete this function
		return true;
	}

?>