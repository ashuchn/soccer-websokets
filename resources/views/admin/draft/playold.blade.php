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
           
           $result_draht_league = DB::table('leagues')->where('id', $draft_league_id)->get();
            $draft_league_user_id =  $result_draht_league[0]->userId;
            $main_user_id = session('userId');
            
            
            $result_timer = DB::table('draft_league')->where('user_id', session('userId'))->where('league_id', $draft_league_id)->get();
            $ch_status =  $result_timer[0]->choose_status;
            $ac_status =  $result_timer[0]->active_status;
            
            
            ?>
            </h1>
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
            <a href="{{ route('start-draft', ['draftId' => $draftId , 'leagueId' => $league[0]->id ]) }}">
              <button type="button" class="btn btn-outline-primary">Start</button>
            </a>
            
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12" style="<?php if($ch_status == $ac_status){echo 'display:none;';} ?>" >
            <div class="input-group date timepicker1" id="start_dt_1" data-target-input="nearest">
                <h3>Time per pick</h3>
                <input type="text" class="form-control datetimepicker-input datetimepicker" data-target="#start_dt_1" name="start_time[]" placeholder="00:00"/>
                <span class="input-group-addon" data-target="#start_dt_1" data-toggle="datetimepicker">
                <span class="fa fa-calendar"></span>
            </span>
            </div>
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
</body>
<script>
  (function( $ ) {
$.fn.timer = function( callback ) {
	callback = callback || function() {};
	return this.each(function() {
		var $timer = $( this ),
			$minutesEl = $timer.find( '.minutes' ),
			$secondsEl = $timer.find( '.seconds' ),
			interval = 1000,
			timer = null,
			start = 60,
			minutesText = $minutesEl.text(),
			minutes = ( minutesText[0] == '0' ) ? minutesText[1] : minutesText[0],
			m = Number( minutes );
			
			timer = setInterval(function() {
				start--;
				if( start == 0 ) {
					start = 60;
					
					$secondsEl.text( '00' );
					
					m--;
					
					if( m == 0 ) {
						clearInterval( timer );
						$minutesEl.text( '00' );
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
<script>
    $(document).ready(function() {
  var buttonAdd = $("#add-button");
  var buttonRemove = $("#remove-button");
  var className = ".dynamic-field";
  var count = 0;
  var field = "";
  var maxFields = 5;

  function initDT() {
    $('.timepicker1').datetimepicker({
      format: 'LT'
    });
  };
  
  function totalFields() {
    return $(className).length;
  }

  function addNewField() {
    count = totalFields() + 1;
    field = $("#dynamic-field-1").clone();
    field.attr("id", "dynamic-field-" + count);
    field.children("label").text("Field " + count);
    
    field.find("input").val("");
    field.find("#start_dt_1").attr("id", "start_dt_" + count);
    field.find("input[name^='start_time']").attr("data-target", "#start_dt_" + count);
    field.find("span[data-target^='#start']").attr("data-target", "#start_dt_" + count);

    field.find("#end_dt_1").val("");
    field.find("#end_dt_1").attr("id", "end_dt_" + count);
    field.find("input[name^='end_time']").attr("data-target", "#end_dt_" + count);
    field.find("span[data-target^='#end']").attr("data-target", "#end_dt_" + count);
  
    $(className + ":last").after($(field));

    initDT();
  }

  function removeLastField() {
    if (totalFields() > 1) {
      $(className + ":last").remove();
    }
  }

  function enableButtonRemove() {
    if (totalFields() === 2) {
      buttonRemove.removeAttr("disabled");
      buttonRemove.addClass("shadow-sm");
    }
  }

  function disableButtonRemove() {
    if (totalFields() === 1) {
      buttonRemove.attr("disabled", "disabled");
      buttonRemove.removeClass("shadow-sm");
    }
  }

  function disableButtonAdd() {
    if (totalFields() === maxFields) {
      buttonAdd.attr("disabled", "disabled");
      buttonAdd.removeClass("shadow-sm");
    }
  }

  function enableButtonAdd() {
    if (totalFields() === (maxFields - 1)) {
      buttonAdd.removeAttr("disabled");
      buttonAdd.addClass("shadow-sm");
    }
  }

  buttonAdd.click(function() {
    addNewField();
    enableButtonRemove();
    disableButtonAdd();
  });

  buttonRemove.click(function() {
    removeLastField();
    disableButtonRemove();
    enableButtonAdd();
  });
  
  initDT();
});
</script>


<script>
    $(document).ready(function() {
  var buttonAdd = $("#add-button");
  var buttonRemove = $("#remove-button");
  var className = ".dynamic-field";
  var count = 0;
  var field = "";
  var maxFields = 5;

  function initDT() {
    $('.timepicker1').datetimepicker({
      format: 'LT'
    });
  };
  
  function totalFields() {
    return $(className).length;
  }

  function addNewField() {
    count = totalFields() + 1;
    field = $("#dynamic-field-1").clone();
    field.attr("id", "dynamic-field-" + count);
    field.children("label").text("Field " + count);
    
    field.find("input").val("");
    field.find("#start_dt_2").attr("id", "start_dt_" + count);
    field.find("input[name^='start_time']").attr("data-target", "#start_dt_" + count);
    field.find("span[data-target^='#start']").attr("data-target", "#start_dt_" + count);

    field.find("#end_dt_1").val("");
    field.find("#end_dt_1").attr("id", "end_dt_" + count);
    field.find("input[name^='end_time']").attr("data-target", "#end_dt_" + count);
    field.find("span[data-target^='#end']").attr("data-target", "#end_dt_" + count);
  
    $(className + ":last").after($(field));

    initDT();
  }

  function removeLastField() {
    if (totalFields() > 1) {
      $(className + ":last").remove();
    }
  }

  function enableButtonRemove() {
    if (totalFields() === 2) {
      buttonRemove.removeAttr("disabled");
      buttonRemove.addClass("shadow-sm");
    }
  }

  function disableButtonRemove() {
    if (totalFields() === 1) {
      buttonRemove.attr("disabled", "disabled");
      buttonRemove.removeClass("shadow-sm");
    }
  }

  function disableButtonAdd() {
    if (totalFields() === maxFields) {
      buttonAdd.attr("disabled", "disabled");
      buttonAdd.removeClass("shadow-sm");
    }
  }

  function enableButtonAdd() {
    if (totalFields() === (maxFields - 1)) {
      buttonAdd.removeAttr("disabled");
      buttonAdd.addClass("shadow-sm");
    }
  }

  buttonAdd.click(function() {
    addNewField();
    enableButtonRemove();
    disableButtonAdd();
  });

  buttonRemove.click(function() {
    removeLastField();
    disableButtonRemove();
    enableButtonAdd();
  });
  
  initDT();
});
</script>
<script>
    function copy() {
  var copyText = document.getElementById("copyClipboard");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  document.execCommand("copy");
  
  $('#copied-success').fadeIn(800);
  $('#copied-success').fadeOut(800);
}
</script>
</html>

<script>
  // $leagueId, $playerId, $draftId
    // var receiverId = $('#receiverId').val();
    var auto_refresh = setInterval(
        function(){
            $('#main-draft-board').load('{{ url('play_partial') }}'+ '/'+ '{{ $leagueId }}' + '/' + '{{ $draftId }}' ).fadeIn('slow');
        }
        , 1000);

</script>
