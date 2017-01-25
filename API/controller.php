<?php
// inclusion dee la bibliotheque
include ("_inc.php");
// recuperation des infos de la request
$method = $_SERVER ['REQUEST_METHOD'];
$request = isset ( $_SERVER ['PATH_INFO'] ) ? explode ( '/', trim ( $_SERVER ['PATH_INFO'], '/' ) ) : null;
$input = json_decode ( file_get_contents ( 'php://input' ), true );

// aquisition de le collection des Produits MongoDB
$collection = (new MongoHelper ())->getCollection ( "NextDb", "products" );

$response = [ ];
switch ($method) {
	case 'GET' :
		if ($request == null) {
			// retreve and return all documents
			// Design initial table header
			$data = '<table class="table table-bordered table-striped">
						<tr>
							<th>Id</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Email Address</th>
							<th>Update</th>
							<th>Delete</th>
						</tr>';
			$cursor = $collection->find ( [ ] );
			foreach ( $cursor as $document ) {
				$id = $document ['_id'];
				$data .= '<tr>
				<td>' . $id . '</td>
				<td>' . $document ['username'] . '</td>
				<td>' . $document ['name'] . '</td>
				<td>' . $document ['email'] . '</td>
				<td>
					<button onclick="GetUserDetails(\'' . $id . '\');" class="btn btn-warning">Modiffier</button>
				</td>
				<td>
					<button onclick="DeleteUser(\'' . $id . '\');" class="btn btn-danger">Supprimer</button>
				</td>
    		</tr>';
			}
			$data .= '</table>';
			
			echo $data;
		} else {
			// lecture d'un selee enregistrement
			$cursor = $collection->find ( [ 
					'_id' => new MongoDB\BSON\ObjectID ( $request [0] ) 
			] );
			foreach ( $cursor as $document ) {
				echo json_encode ( $document );
				break;
			}
		}
		break;
	case 'PUT' :
		$id = $request [0];
		
		// print_r($input);
		
		// exit;
		// $firstname=$_REQUEST['first_name'];
		// $name=$_REQUEST['last_name'];
		// $email=$_REQUEST['email'];
		$update = $collection->updateOne ( [ 
				"_id" => new MongoDB\BSON\ObjectID ( $id ) 
		], [ 
				'$set' => [ 
						'username' => $input ["first_name"],
						'name' => $input ["last_name"],
						'email' => $input ["email"] 
				] 
		] );
		// update a document['username'=>$firstname,'name'=>$name, 'email'=>$email]
		// $sql = "update `$table` set $set where id=$key";
		$result = [ ];
		$result ['success'] = true;
		$result ['message'] = "Matched " . $update->getMatchedCount () . " document(s)   Modified " . $update->getModifiedCount () . " document(s)";
		echo json_encode ( $result );
		break;
	case 'POST' :
		// insert a document
		$insertOneResult = $collection->insertOne ( [ 
						'username' => $input ["first_name"],
						'name' => $input ["last_name"],
						'email' => $input ["email"] 
				]  );
		
// 		echo $insertOneResult->getInsertedCount () . " document(s) Inserted \n";
		$result = [ ];
		$result ['success'] = true;
		$result ['message'] = $insertOneResult->getInsertedCount () . " document(s) Inserted \n";
		echo json_encode ( $result );
		break;
	case 'DELETE' :
		// delete a document
		$deleteResult = $collection->deleteOne ( [ 
				'_id' => new MongoDB\BSON\ObjectID ( $request [0] ) 
		] );
		$result = [ ];
		$result ['success'] = true;
		$result ['message'] = "Deleted ".$deleteResult->getDeletedCount ()." document(s)\n";
		echo json_encode ( $result );
		break;
}
