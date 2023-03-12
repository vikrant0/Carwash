<?php

	include('../connection.php');

	session_start();

	//-->> trim all the data using a trim function
	$uname = $_POST['username'];
	$pass = $_POST['password'];
	// echo $uname.' '.$pass.' ';
	// $_SESSION['sid']=0;
	//-->> validate email and username `



	if(validate()){

		//preparing a query
		$check=$db->prepare('SELECT * FROM signup WHERE uid = ? or email = ?');

		$data=array($uname,$uname);
		//execute the query by combining data in the check table
		$check->execute($data);
		if($check->rowcount()==0){ //count will always be 0 or 1
			echo 0;
			// >> 0 for account does not exist
		}
		else{
			
			//fetch the data from database
			$datarow=$check->fetch();

			$_SESSION['uid']=$datarow['uid'];
			// $_SESSION['tid']=$datarow['tid'];

			if($pass==$datarow['password']){
				//valid details
				if($datarow['uid']=="admin"){
					echo 11; // go to admin portal
				}
				else{
					echo 12; //go to user portal
				}
			}
			else {
				echo 2; //invalid details
			}

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