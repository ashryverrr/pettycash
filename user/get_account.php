<?php
	require '../config/connection.php';

	if($_POST['id']){
	 $id = $_POST['id'];	  
	 $stmt = $pdo ->prepare("SELECT client_account FROM clients WHERE concat(clients.client_name,' ',clients.client_branch) LIKE(:client_name) ");
	 //$stmt = $pdo ->prepare("SELECT client_account FROM clients WHERE client_id = :id");
	 $stmt->execute(array(':client_name' => $id));
	 $row = $stmt -> fetch();
	 $client_account = $row['client_account'];
	 echo "
	 	   <input type='text' class='form-control accountClient' id='other_account' name='other_account' value='$client_account'>   
	 ";
	} 
?>