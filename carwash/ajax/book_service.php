<?php

	include('../connection.php');
	
	session_start();

	// $date = $_POST['date'];
	$placeid = $_POST['placeid'];
	// $serviceid = $_POST['serviceid'];
	$today = date("Y-m-d");
	// $place,$service;
	if(validate()){

		//we will prepare 3 queries
		$check1=$db->prepare('SELECT * FROM place WHERE  (pid = ?)');
		$data1=array($placeid);
		$check1->execute($data1);

		if($check1->rowcount()==0){
			echo 0;
		}
		else{

			$datarow=$check1->fetch();
			$place=$datarow['place']; 
			$check2=$db->prepare('SELECT * FROM bookings WHERE (place=?)');
			$data2=array($place);
			$check2->execute($data2);
			if($check2->rowcount()>0){
				echo 5;
			}
			else{
				$query=$db->prepare("INSERT INTO bookings(uid,date,place) VALUES (?,?,?)");
				$data=array($_SESSION['uid'],$today,$place);

				if($query->execute($data)){
					//successfully added booking
					echo 1;
				}
				else echo 2;
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