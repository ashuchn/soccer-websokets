<section class="draft-board" id="draft-board">
<div class="container">
  team id is {{ $teamId }}
 
  <div class="row">
    @foreach($draft_list as $key => $orderDetails)
        <div class="col-new">
            <div class="container">
            <p>
                <?php 
                    $result = DB::table('teams')->where('id',$orderDetails->team_id)->get();
                    echo  $result[0]->teamName." ";
                ?>
            </p>
                    <ul class="list-group">
                        <?php 	
                            $draft_player = DB::table('draft_player_selection')->where('leagueId', $orderDetails->league_id)->where('userId',$orderDetails->user_id)->get();
                        ?>
                        @foreach($draft_player as $key => $orderDetails)
                            <?php 
                                $result = DB::table('players')->where('id',$orderDetails->playerId)->get();
                                $position = $result[0]->position;
                            ?>
                            <?php
                                if($position ==  'Goalkeeper'){$background = 'red';$color = 'white';}
                                if($position ==  'Forward'){$background = 'blue';$color = 'white';}
                                if($position ==  'Midfielder'){$background = 'yellow';$color = 'black';}
                                if($position ==  'Defender'){$background = 'green';$color = 'white';}
                            ?>
                                <li style="background:<?php echo $background; ?>;color:<?php echo $color; ?>">
                                    <?php echo  $result[0]->playerName; ?><br><?php echo  $result[0]->position; ?><br>            
                                </li>
                        @endforeach
                    </ul>

            </div>
        </div>
        @endforeach	
  </div>
  
  
  
  
  
</div>
</section>


<?php $result = DB::table('draft_league')->where('user_id', session('userId'))->where('draft_id',$draftId)->get();
      $choose_status =  $result[0]->choose_status;
      $active_status =  $result[0]->active_status;
      ?>  

<?php $result2 = DB::table('draft_league')->where('user_id', session('userId'))->where('league_id',$league[0]->id)->orderBy('id','asc')->limit(1)->get();
      if($choose_id =  $result2[0]->id)
      // // $choose_id =  $result2[0]->id;
      // echo $result2;
      ?>  
<section class="all-player" style="display:<?php if($choose_status == $active_status ){ echo 'none'; }else{ echo 'block'; } ?>">
    <div class="container">
        <div class="row">
            
            <div class="col-lg-9 col-md-9 col-sm-12">
                <div class="all-player-box">
                <ul>
                    <li>All Players</li>
                    <li>Player Watchlist</li>
                    <li>Waiver Request <span>(0)</span></li>
                </ul>
                <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Sr.No</th>
                          <th>Name</th>
                          <th>Rating</th>
                          <th>Position</th>
                          <th>Age</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $i=1; ?>
                        @foreach($players as $rows)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $rows->playerName }}.' '.{{ $teamId }}</td>
                                <td>{{ $rows->score }}</td>
                                <td>{{ $rows->position }}</td>
                                <td>{{ $rows->age }}</td>
                                <td>
                                    {{--<a href="{{ route('addPlayerToDraft', ['leagueId' => $league[0]->id, 'playerId'=>$rows->id, 'draftId' => $draftId ]) }}">
                                    </a>--}}
                                    <button type="button" class="btn btn-outline-primary" onclick="return player_select('{{ $draftId }}','{{ $rows->id }}', '{{ $league[0]->id }}', '{{ $teamId }}')">Unpicked</button>
                                </td>    
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="all-box">
                    <p></p>
                    <div class="selected-player">
                        <p>Goal Keepers</p>
                            {{--@forelse($goalkeeper as $goal)
                                <h4><img src="{{ url('image/circle-img.png') }}" alt="">{{ $goal->playerName }}</h4>
                                @empty
                                <h4>No Goalkeepers</h4>
                            @endforelse --}}
                       
                    </div>
                    <div class="selected-player">
                        <p>Midfielders</p>
                        {{--@forelse($midfielder as $mid)
                                <h4><img src="{{ url('image/circle-img.png') }}" alt="">{{ $mid->playerName }}</h4>
                                @empty
                                <h4>No Midfielders</h4>
                            @endforelse --}}
                    </div>
                    <div class="selected-player">
                        <p>Defenders</p>
                        {{--  @forelse($defender as $dev)
                                <h4><img src="{{ url('image/circle-img.png') }}" alt="">{{ $dev->playerName }}</h4>
                                @empty
                                <h4>No Defenders</h4>
                            @endforelse--}}
                    </div>
                    <div class="selected-player">
                        <p>Forward</p>
                        {{--    @forelse($forward as $for)
                                <h4><img src="{{ url('image/circle-img.png') }}" alt="">{{ $for->playerName }}</h4>
                                @empty
                                <h4>No Forwards</h4>
                            @endforelse--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>