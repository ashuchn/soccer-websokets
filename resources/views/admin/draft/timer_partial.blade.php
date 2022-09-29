<?php
           $draft_league_id =  $league[0]->id;
           
           $result_draht_league = DB::table('leagues')->where('id', $draft_league_id)->get();
            $draft_league_user_id =  $result_draht_league[0]->userId;
            $main_user_id = session('userId');
            
            
            $result_timer = DB::table('draft_league')->where('user_id', session('userId'))->where('league_id', $draft_league_id)->get();
             $ch_status =  $result_timer[0]->choose_status;
             $ac_status =  $result_timer[0]->active_status;
            
            
?>

<div class="col-lg-3 col-md-3 col-sm-12" id="" style="<?php if($ch_status == $ac_status){echo 'display:block;';} ?>" >
              <div class="input-group" id="">
                      <!--<h3>Time per pick</h3>-->
                      <div class="timer">
                       <span class="seconds">0</span>
                      </div>
                      <audio id="timer-beep">
                        <source src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/41203/beep.mp3"/>
                        <source src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/41203/beep.ogg" />
                      </audio>
                  </span>
                  </div>
              </div>
			  
			  
            </div>

            <?php 

$random_player = DB::table('players')->where('active', 0)->limit(1)->get('id');
// echo $random_player;
?>
<script>
  
    // console.log("{{$random_player[0]->id}}");

  
  
function player_select(draftId, playerId, leagueId) {
    $.ajax({
        url: "{{ url('addPlayerToDraft') }}" +"/league/" + leagueId + "/player/" + playerId + "/draftId/" + draftId ,
        dataType: "json",
        type: "GET",
        
        data: { leagueId : leagueId, playerId : playerId, draftId : draftId},
        success: function (result) {
          console.log(result);
          console.log("player selected");
          //window.location.reload();          
        }
    }); 
  }

</script>



            <?php 

if($ch_status != $ac_status) { ?>

<script>
  console.log("inside function");
  (function( $ ) {
$.fn.timer = function( callback ) {
	callback = callback || function() {};
	return this.each(function() {
		var $timer = $( this ),
			$minutesEl = $timer.find( '.minutes' ),
			$secondsEl = $timer.find( '.seconds' ),
			interval = 1000,
			timer = null,
			start = 10,
			minutesText = $minutesEl.text(),
			minutes = ( minutesText[0] == '0' ) ? minutesText[1] : minutesText[0],
			m = Number( minutes );
			
			timer = setInterval(function() {
				start--;
				if( start == 0 ) {
					start = 10;
					
					$secondsEl.text( '00' );
					
					m--;
					
					if( m == 0 ) {
						clearInterval( timer );
						$minutesEl.text( '00' );
            console.log("timer endedd");
            //alert("timer ended");
            //refreshPage();
            var playerId = "{{ $random_player[0]->id }}"; //returns random player id
            var draftId = "{{ $draftId }}"; //returns draft id
            var leagueId = "{{  $league[0]->id }}"; //returns league id
            player_select(draftId, playerId, leagueId);
            window.location.reload();
						callback();

						
					}
				} else {
				
					if( start >= 10 ) {
				
						$secondsEl.text( start.toString() );
				
					} else {
				
						$secondsEl.text( '0' + start.toString() );
					
				
					}
					if( minutes.length == 2 ) {
						$minutesEl.text( m.toString() );
					} else {
						if( m == 1 ) {
							$minutesEl.text( '00' );	
						} else {
							$minutesEl.text( '0' + m.toString() );
						}
					}
				
				}
			
			}, interval);
	
	});

};

$(function() {
	$( '.timer' ).timer(function() {
		document.getElementById( 'timer-beep' ).play();
	});

});
  
})( jQuery );
</script>

<?php } ?>
	
	
	