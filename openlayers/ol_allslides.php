<?php
// Programmed by Timo Strube, updated 24.05.2015

// include all the sub functions
require_once '../include/include.php';

// query quakes
$query = mysqliInitSelect('all_slides', array('*'));
$earthquakes = mysqliGetMultiple($query);
mysqliDeleteQuery($query);

// loop quakes, generate result
foreach ($all_slides as $allslides) {
	$geometry = array('type' => 'Point',
			   'coordinates' => array((double)$allslides['lon'],
			   						  (double)$allslides['lat']));

	$feature = array('type' => 'Feature',
					   'id' => $allslides['id'],
			   'properties' => array(	  'name' => $allslides['name'],
										  'time' => $allslides['time'],
								   'reference' => $allslides['reference'],
									  'download' => $allslides['download']),
				 'geometry' => $geometry);

	$result[] = $feature;
}

mysqliCloseConnection();

$json = array('type' => 'FeatureCollection',
		  'features' => $result);

echo json_encode($json);
?>
