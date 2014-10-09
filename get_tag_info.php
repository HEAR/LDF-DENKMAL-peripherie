<?php

include_once('config.php');
include_once('fonctions.php');

$json = new stdClass();

if(isset( $_GET['tag'] ) ){

	$json->ok = true;

	$file = LOCAL_PATH . '/keywords/'.$_GET['tag'].'.json';

	$info = json_decode( file_get_contents( $file ) );

	$json->keyword      = $info->mot;
	$json->identifiant  = $info->identifiant;

	$listeThumbs = array();

	if( count( $info->images ) > 0 )
	{
		//$listeThumbs[] = $identifiant;
		

		foreach ($info->images as $file) {

			$filePath = LOCAL_PATH . "/data/{$file}/thumbs/";
			$fileURL  = URL. "/data/{$file}/thumbs/";
					
			foreach( glob( "{" . $filePath ."{$info->identifiant}*.jpg}", GLOB_BRACE ) as $vignette )
			{

				$retour = new stdClass();

				$fileName = str_replace($filePath, "", $vignette);
				$fileInfo = getCoordFromName($fileName);
				$fileURL  = str_replace($filePath, $fileURL, $vignette);

				$retour->url = $fileURL;
				$retour->x  = $fileInfo->x;
				$retour->y  = $fileInfo->y;
				$retour->target = URL. "/image/{$file}/";

				$listeThumbs[] = $retour;

				/*$info = json_decode(file_get_contents($file));

				$keyword      = $info->mot;
				$identifiant  = $info->identifiant;

				if( count( $info->images ) > 0 )
				{
					echo "<li><a href='".URL."/tag/$identifiant/'>$keyword</a></li>";

					$listeTags[] = $identifiant;
				}*/
			} 
		}	
	}

	$json->listeThumbs = $listeThumbs;


	echo json_encode($json);

}else{

	$json->ok = false;

	echo json_encode($json);	

}