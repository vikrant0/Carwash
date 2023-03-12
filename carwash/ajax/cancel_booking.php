<?php

	include('../connection.php');

	$bid = $_POST['bid'];

	if(validate()){

		//preparing a query
		//we will be checking both email and password
		
		$check=$db->prepare('SELECT * FROM bookings WHERE  (bid = ?)');
		$data=array($bid); //for below 'if' statement

		$check->execute($data);
		if($check->rowcount()==0){
			echo 0; //->> account does not exist
		}
		else{
			
			//delete if account exist
			$query=$db->prepare('UPDATE bookings SET accepted=? WHERE bid=?');
			$data=array(-1,$bid);

			//execute 
			if($query->execute($data)){
				echo 1; //booking canceled
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