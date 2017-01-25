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
		break;
	case 'PUT' :
		// update a document
		// $sql = "update `$table` set $set where id=$key";
		break;
	case 'POST' :
		// insert a document
		$insertOneResult = $collection->insertOne ( print_r ( $inputData, true ) );
		
		echo $insertOneResult->getInsertedCount () . " document(s) Inserted \n";
		
		var_dump ( $insertOneResult->getInsertedId () );
		// $sql = "insert into `$table` set $set";
		break;
	case 'DELETE' :
		// delete a document
		// $sql = "delete `$table` where id=$key";
		break;
}
