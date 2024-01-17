<?php
// Programmed by Timo Strube, updated 24.05.2015

// include all the sub functions
require_once '../include/include.php';

// query quakes
$query = mysqliInitSelect('quat_slip', array('*'));
$quat_slips = mysqliGetMultiple($query);
mysqliDeleteQuery($query);

// loop quakes, generate result
foreach ($quat_slips as $slip) {
	$geometry = array('type' => 'Point',
			   'coordinates' => array((double)$slip['lon'],
			   						  (double)$slip['lat']));

	$feature = array('type' => 'Feature',
					   'id' => $slip['id'],
			   'properties' => array( 'fault_id' => $slip['fault_id'],
				 					'fault_name' => $slip['fault_name'],
								   'q_slip_rate' => $slip['q_slip_rate'],
										'method' => $slip['method'],
									 'reference' => $slip['reference']),
				 'geometry' => $geometry);

	$result[] = $feature;
}

mysqliCloseConnection();

$json = array('type' => 'FeatureCollection',
		  'features' => $result);

echo json_encode($json);
?>
