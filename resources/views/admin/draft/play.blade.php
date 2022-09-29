<?php error_reporting(0); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{url('public/css/style.css')}}">
  <link rel="stylesheet" href="{{url('public/css/responsive.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel='stylesheet' href='https://rawgit.com/tempusdominus/bootstrap-4/master/build/css/tempusdominus-bootstrap-4.css'>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div id="rfrsh">
<section class="top">

</section>

<section class="top-heading Draft-room">
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1>Draft room</h1>
          <h1> Hi! 
            <?php $result = DB::table('users')->where('id', session('userId'))->get();
            echo $result[0]->name;
           $draft_league_id =  $league[0]->id;
		   
		   $result_timer = DB::table('leagues')->where('id',$draft_league_id)->get();
		   $timer = $result_timer[0]->timer;
           
           $result_draht_league = DB::table('leagues')->where('id', $draft_league_id)->get();
            $draft_league_user_id =  $result_draht_league[0]->userId;
            $main_user_id = session('userId');
            
            
            $result_timer = DB::table('draft_league')->where('user_id', session('userId'))->where('league_id', $draft_league_id)->get();
            $ch_status =  $result_timer[0]->choose_status;
            $ac_status =  $result_timer[0]->active_status;
            
            
            ?>
            </h1>
            <div id="timer"></span>
        </div>
    </div>
</div>
</section>

<section class="league-name-box">  
<div class="container">
    <div class="row">
        <div class="col-lg-7 col-md-7 col-sm-12">
            <h2>{{ $league[0]->leagueName }}</h2>
            <span><span class="round"></span> Teams</span>
            <span><span class="round">(0)</span> Rounds</span>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-12 text-right" style="<?php if($draft_league_user_id == $main_user_id){echo 'display:block;';}else{echo 'display:none;';} ?>">
            <!-- <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#myModalshare">Share</button> -->
            {{--<a href="{{ route('start-draft', ['draftId' => $draftId , 'leagueId' => $league[0]->id ]) }}">
            </a>--}}
            <button type="button" class="btn btn-outline-primary" onclick="return startDraft('{{$draftId}}', '{{ $league[0]->id }}')">Start</button>
            
        </div>
     <!-- <div id="timer_div">
          
      </div> -->
	  
	  <input type="hidden" id="tsr" value="<?php echo $timer; ?>">
	<input type="hidden" id="leagueID" value="<?php echo $draft_league_id; ?>">
	
	
	  
	  <div class="col-lg-3 col-md-3 col-sm-12" id="" style="<?php if($ch_status == $ac_status){echo 'display:none;';} ?>" >
              <div class="input-group" id="">
                      <!--<h3>Time per pick</h3>-->
                      <div class="timer">
                       <span class="seconds" id="countdown"><?php echo $timer; ?></span>
                      </div>
                      <audio id="timer-beep">
                        <source src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/41203/beep.mp3"/>
                        <source src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/41203/beep.ogg" />
                      </audio>
                  </span>
                  </div>
              </div>
        
</div>
</section>



<div id="main-draft-board">


</div>


<div id="selection"></div>
  
  <!-- The Modal -->
  <div class="modal fade" id="myModalshare">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title text-center">Copy Link</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body text-center">
            <div class="clipboard">
                <input onclick="copy()" class="copy-input" value="https://www.bugra.work" id="copyClipboard" readonly>
                <button class="copy-btn" id="copyButton" onclick="copy()"><i class="fa fa-clipboard" aria-hidden="true"></i>
                </button>
            </div>
            <div id="copied-success" class="copied">
                <span>Copied!</span>
            </div>
        </div>
        
        
      </div>
    </div>
  </div>
  <!-- The Modal -->
  <div class="modal fade dashboard-modal" id="myModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body text-center">
           <img src="image/player-img.png" alt="">
           <h5>John</h5>
           <div class="other-detail">
            
                <ul>
                  <li>Role : <span>Owner</span></li>
                  <li>Position : <span>Goal Keepers</span></li>
                  <li>Weight : <span>50</span></li>
                </ul>
         
           </div>
        </div>
        
        
      </div>
    </div>
  </div>
  <script src='https://code.jquery.com/jquery-3.2.1.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js'></script>
  <script src='https://cdn.jsdelivr.net/momentjs/2.18.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js'></script>
<script src="//js.pusher.com/3.1/pusher.min.js"></script>
<script src="{{ url('public/jquery.countdown360.js') }}"></script>


</div>
</div>
<!-- </body> -->
<script>
    // var auto_refresh = setInterval(
        function playPartial(){
            $('#main-draft-board').load('{{ url('play_partial') }}'+ '/'+ '{{ $leagueId }}' + '/' + '{{ $draftId }}' );           
        }
        playPartial();
    //     , 1000);
</script>

<?php 

$random_player = DB::table('players')->where('active', 0)->limit(1)->get('id');
$loggedInUser = session('userId');
?>

<script>
function player_select(draftId, playerId, leagueId) {
    $.ajax({
        url: "{{ url('addPlayerToDraft') }}" +"/league/" + leagueId + "/player/" + playerId + "/draftId/" + draftId ,
        dataType: "json",
        type: "GET",
        
        data: { leagueId : leagueId, playerId : playerId, draftId : draftId},
        success: function (result) {
          playPartial();
          timer();
        }
    }); 
  }

  function startDraft(draftId, leagueId)
  {
    $.ajax({
        url: "{{ url('start-draft/') }}" +"/league/" + leagueId + "/draft/" + draftId ,
        dataType: "json",
        type: "GET",
        //data: { leagueId : leagueId, playerId : playerId, draftId : draftId},
        success: function (result) {
          //let started = true;
          playPartial();
          timer();
        }
    }); 
  }

</script>




<script>
  function timer() {
      var countdown = $("#timer").countdown360({
      radius      : 60,
      seconds     : 10,
      fontColor   : '#FFFFFF',
      autostart   : false,
      onComplete  : function () {  
            /*<?php if($ch_status == $ac_status) { ?>
              timer();
            <?php }else { ?>
              player_select('{{ $draftId }}', '{{ $random_player[0]->id }}', '{{ $draft_league_id }}') 
            <?php } ?>*/
        }
  });
    countdown.start();
  }
  // if(started == true){
    // timer();
  // }

</script>



<script type="text/javascript">

  var pusher = new Pusher('2aa961ec7946f358e8e8', {
    cluster: 'ap2',
    encrypted: true
  });
  Pusher.logToConsole = true;
  // Subscribe to the channel we specified in our Laravel Event
  // var channel = pusher.subscribe('timer-reset{{ $draft_league_id }}');
  var channel = pusher.subscribe('timer-reset');

  //use dispatch
  // Bind a function to a Event (the full Laravel class)
  channel.bind('App\\Events\\resetTimer', (data) => {
    console.log(data);
    playPartial();
    timer();
  });

//   channel.bind('pusher:subscription_succeeded', function(members) {
//     // alert('successfully subscribed!');
//  });



</script>

</html>