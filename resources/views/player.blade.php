<?php
@foreach($players as $key => $orderDetails)

    $id = DB::table('players')-> insertGetId(array(
		'playerName' => $orderDetails->playerName,
		'team' => $orderDetails->team,
		'position' => $orderDetails->position,
		'age' => $orderDetails->age,
		'score' => $orderDetails->score,
		'active' => $orderDetails->active,
		'profile_url' => $orderDetails->profile_url
		));
											
	@endforeach	
?>