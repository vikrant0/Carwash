<?php

	include('../connection.php');

	$serviceid = $_POST['serviceid'];

	if(validate()){

		//preparing a query
		//we will be checking both email and password
		
		$check=$db->prepare('SELECT * FROM services WHERE  (serviceid = ?)');
		$data=array($serviceid); //for below 'if' statement

		$check->execute($data);
		if($check->rowcount()==0){
			echo 0; //->> service does not exist
		}
		else{
			
			//delete if the service exist
			$query=$db->prepare('DELETE FROM services WHERE serviceid=?');
			$data=array($serviceid);

			//execute 
			if($query->execute($data)){
				echo 1; //account deleted
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