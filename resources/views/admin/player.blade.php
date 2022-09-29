	
	<?php foreach($players as $row){ 
	
	echo $id = $row->playerName;
	
	$id = DB::table('players')-> insertGetId(array(
		'playerName' => $row->playerName,
		
		'team' => $row->team,
		'position' => $row->position,
		'age' => $row->age,
		'score' => $row->score,
		'active' => $row->active,
		'profile_url' => $row->profile_url
		));
	}
	?>
