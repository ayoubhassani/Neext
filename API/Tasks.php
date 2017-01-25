<?php
include("_inc.php");
$mongoUrl = "mongodb://localhost:27017";
$method = $_SERVER ['REQUEST_METHOD'];

$request = isset( $_SERVER ['PATH_INFO'])? explode ( '/', trim ( $_SERVER ['PATH_INFO'], '/' ) ):null;

$input = json_decode ( file_get_contents ( 'php://input' ), true );
// print_r($input);exit;
$collection = (new MongoHelper ())->getCollection ( "NextDb", "products" );
$data = "";
$inputData =($input=="")?"": preg_replace ( '/[^a-z0-9_]+/i', '', array_keys ( $input ) );
switch ($method) {
	case 'GET' :
		// retreve and return all documents
		$cursor = $collection->find ( [ ] );
		foreach ( $cursor as $document ) {
			$data [] = $document;
		}
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

echo json_encode ( $data );