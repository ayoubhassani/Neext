<?php

/*
 * include "./MongoDB/Client.php";
 * include "./MongoDB/Database.php";
 * include "./MongoDB/Collection.php";
 * include "./MongoDB/BulkWriteResult.php";
 * include "./MongoDB/DeleteResult.php";
 * include "./MongoDB/functions.php";
 * include "./MongoDB/Operation/Executable.php";
 * include "./MongoDB/Operation/Find.php";
 * include "./MongoDB/Model/BSONArray.php";
 * include "./MongoDB/Model/BSONDocument.php";
 */













function readDirectory($dirname) {
	$list = scandir ( $dirname, SCANDIR_SORT_NONE );
	for($i = 0; $i <= count ( $list ) - 1; $i ++) {
		if (! in_array ( $list [$i], array (
				'.',
				'..' 
		) )) {
			if (is_dir ( $dirname . "/" . $list [$i] )) {
				// echo "repertoir ".$dirname ."/".$list[$i]. " <br>";
				readDirectory ( $dirname . "/" . $list [$i] );
			} else {
				// echo "fichier ".$dirname."/".$list[$i]. " <br>";
				includeFile ( $dirname . "/" . $list [$i] );
			}
		}
	}
}
function includeFile($fileName) {
	include $fileName;
}

readDirectory ( "./MongoDB" );
class MongoHelper {
	function getClient() {
		return new MongoDB\Client ( "mongodb://localhost:27017" );
	}
	function getCollection($dbName,$collectionName){
		return $this->getClient()->$dbName->$collectionName;
	}
}

?>