<?php

	include('../connection.php');

	$pid = $_POST['pid'];

	if(validate()){

		//preparing a query
		//we will be checking both email and password
		
		$check=$db->prepare('SELECT * FROM place WHERE  (pid = ?)');
		$data=array($pid); //for below 'if' statement

		$check->execute($data);
		if($check->rowcount()==0){
			echo 0; //->> place does not exist
		}
		else{
			
			//delete if the place exist
			$query=$db->prepare('DELETE FROM place WHERE pid=?');
			$data=array($pid);

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