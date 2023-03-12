<?php

	include('../connection.php');
	
	session_start();

	$date = $_POST['date'];
	$placeid = $_POST['placeid'];
	$serviceid = $_POST['serviceid'];

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
		}

		$check2=$db->prepare('SELECT * FROM services WHERE  (serviceid = ?)');
		$data2=array($serviceid);
		$check2->execute($data2);

		if($check2->rowcount()==0){
			echo 0;
		}else{
			$datarow=$check2->fetch();
			$service=$datarow['servicename']; 
		}

		$check3=$db->prepare('SELECT count(*) as counttotal FROM bookings WHERE  (date = ? && place = ? && accepted<>?)');
		$data3=array($date,$place,-1); //for below 'if' statement
		$check3->execute($data3);

		$count=$check3->fetch();

		if($count['counttotal']<5){
			//booking can happen
			$query=$db->prepare("INSERT INTO bookings(uid,date,place,service) VALUES (?,?,?,?)");
			$data=array($_SESSION['uid'],$date,$place,$service);

			if($query->execute($data)){
				//successfully added booking
				echo 1;
			}
			else echo 2;
		}

		else{
			//booking cannot happen
			echo 5;
			//specified date - bookings are full
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