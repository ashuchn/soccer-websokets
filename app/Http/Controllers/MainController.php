<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
use App\Models\Users;
use App\Models\League;
use App\Models\Team;
use App\Models\Player;
error_reporting(0);

class MainController extends Controller
{
	
	
    //

    public function login(Request $request)
    {
        if( $request->isMethod('get') ) {
            if(session::has('userId')){
                return redirect()->route('dashboard');
            }
            return view('admin.login');
        } else {
            $email = $request->email;
            $password = $request->password;

            $exists = DB::table('users')->where('email', $email)->where('password', $password)->exists();
            if($exists) {
                $sql =DB::table('users')->where('email', $email)->get();
                $userId = $sql[0]->id;
                $request->session()->put('userId', $userId);
                return redirect()->route('dashboard')->with('status', 'Logged in');
            }  else {
                return redirect()->back()->with('status', 'Invalid Credentials');
            }

            

        }
    }


    public function signup(Request $request) 
    {
        if( $request->isMethod('get') ) {
            return view('admin.signup');
        } else {
            $name = $request->name;
            $email = $request->email;
            $password = $request->password;

            $insert = new Users;
            $insert->name = $name;
            $insert->email = $email;
            $insert->password = $password;
            $insert->save();

            if($insert)
            {
                return redirect()->route('login')->with('status', 'User created!');
            } else {
                return redirect()->back()->with('status', 'Some error occured!');
            }

            

        }
    }

    public function dashboard()
    {
        $myLeagues = League::where('userId', session('userId'))->get();
        
        $otherLeagues = League::where('userId', '!=',session('userId'))->get();
        
        return view('admin.dashboard', ["myleague" => $myLeagues , "otherLeague" => $otherLeagues]);

    }

    public function addLeague(Request $request)
    {
        if( $request->isMethod('get') ) {
            return view('admin.league.add');
        } else {

            $leagueName = $request->leagueName;


            $insert = new League;
            $insert->leagueName = $leagueName;
            $insert->userId = session('userId');
            $insert->timer = '10';
            $insert->save();

            if($insert)
            {
                return redirect()->route('dashboard')->with('status', 'League Added!');
            } else {
                return redirect()->back()->with('status', 'Some error occured!');
            }
			
        }
    }

    public function leagueDashboard($leagueId)
    {
        
        $userId = session('userId');
        
        $teams = Team::where('leagueId', $leagueId)->where('userId', $userId)->get();
        $league = League::where('id', $leagueId)->get();
        // return $league[0];
        

        return view('admin.league.teams', ['teams' => $teams, 'league' => $league[0]]);
    }


    public function addTeam( Request $request ,$leagueId = null)
    {
        if( $request->isMethod('get') ) {
            return view('admin.league.addTeam', ['leagueId' => $leagueId]);
        } else { 
            
            $insert = new Team;
            $insert->teamName = $request->teamName;
            $insert->leagueId = $request->leagueId;
            $insert->userId = session('userId');
            $insert->save();

            if($insert)
            {
                 return redirect()->route('leagueDashboard', ['leagueId' => $request->leagueId])->with('status', 'Team Added!');
                // return redirect()->back()->with('status', 'Team Added!');
            } else {
                return redirect()->back()->with('status', 'Some error occured!');
            }


        }

    }


    public function mainDashboard($leagueId, $teamId)
    {
        return view('admin.mainDashboard', [ 'leagueId' => $leagueId, 'teamId' => $teamId ]);
    }


    
    // public function playDraft($leagueId, $teamId)
    // {
    //     $league = League::where('id', $leagueId)->get();
    //     $players = Player::all();
    //     return view('admin.draft.play', ['players' => $players ,  'league' => $league, 'teamId' => $teamId ]);
    // }

    /** draft 2nd page */
    public function playDraft($leagueId, $draftId)
        {
            
            // return $leagueId;
            
            // return [
            //     "leagueid" => $leagueId,
            //     "teamId" => $teamId,
            //     "userId" => Auth::id()
            // ];

                $team = DB::table('teams')->where('leagueId', $leagueId)->where('userId', session('userId'))->get(); 
                $teamCount = DB::table('teams')->where('leagueId', $leagueId)->where('userId', session('userId'))->count();
                $league = DB::table('leagues')->where('id', $leagueId)->get(); 
                // exit($league);
                $players = DB::table('players')->where('active', 0)->get();


                /**my team players */

                // $goalKeeper = DB::table('draft_player_selection as selection')
                //                 ->join('players', 'players.id','=','selection.playerId')
                //                 ->where('leagueId','=',$leagueId)
                //                 ->where('teamId','=',$teamId)
                //                 ->where('userId','=', Auth::id() )
                //                 ->where('position','=','Goalkeeper')
                //                 ->get('players.playerName');


                // $defender = DB::table('draft_player_selection as selection')
                //                 ->join('players', 'players.id','=','selection.playerId')
                //                 ->where('leagueId','=',$leagueId)
                //                 ->where('teamId','=',$teamId)
                //                 ->where('userId','=', Auth::id() )
                //                 ->where('players.position','=','Defender')
                //                 ->get('players.playerName');


                // $midfielder = DB::table('draft_player_selection as selection')
                //                 ->join('players', 'players.id','=','selection.playerId')
                //                 ->where('leagueId','=',$leagueId)
                //                 ->where('teamId','=',$teamId)
                //                 ->where('userId','=', Auth::id() )
                //                 ->where('players.position','=','Midfielder')
                //                 ->get('players.playerName');


                // $forward = DB::table('draft_player_selection as selection')
                //                 ->join('players', 'players.id','=','selection.playerId')
                //                 ->where('leagueId','=',$leagueId)
                //                 ->where('teamId','=',$teamId)
                //                 ->where('userId','=', Auth::id() )
                //                 ->where('players.position','=','forward')
                //                 ->get('players.playerName');
                
                
                                // return $defender;

                                $darft_list = DB::table('draft_league')->where('league_id', $leagueId)->where('user_id', session('userId'))->get();

                                $draft_player = DB::table('draft_player_selection')->orderBy('id','asc')->where('leagueId', $leagueId)->get();
                                // $draft_player = DB::table('draft_player_selection')->orderBy('id','asc')->where('leagueId', $leagueId)->where('userId', session('userId'))->get();

                return view('admin.draft.play', [
                    "players" => $players,
                    "draft_list" => $darft_list,
                    "draft_player" => $draft_player,
                    "league" => $league,
                    "userId" => session('userId'),
                    "draftId"=> $draftId,
                    "leagueId" => $leagueId
                ]);

        }

    




    /** total90 code */

    /** draft 1st page */
    function draft($leagueId, $teamId)
        {
            
            
            /**
             * find league admin
             * match in draft_league on league id and user id
             * if not found, redirect to same page
             */
            $loggedInUser = session('userId');
            $leagueAdmin = DB::table('leagues')->where('id', $leagueId)->pluck('userId');
            if($loggedInUser != $leagueAdmin[0]) {
                $checkLeagueAdmin = DB::table('draft_league')->where('league_id', $leagueId)
                ->where('user_id', $leagueAdmin[0])
                ->exists();

                if(!$checkLeagueAdmin){
                session()->put('error', 'League Admin is yet to join draft');
                return redirect()->back();
                } 
            }
            
            /** user id who is drafting draft */
            $length = 50;
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			$randomString;
            $userId = session('userId');


            $userinfo2 = DB::table('draft_league')->where('user_id',$userId)->where('league_id',$leagueId)->exists();
            if($userinfo2){
                    $draftId = DB::table('draft_league')
            ->where('user_id',$userId)->where('league_id',$leagueId)->where('team_id',$teamId)->pluck('draft_id');
            
            /** returns the league details */
            $league = DB::table('leagues')->where('id', $leagueId)->get(); 
            

            /** returns teams in a league */
            $teamCount = DB::table('draft_league')->where('league_id', $leagueId)->count(); 
            
            event(new \App\Events\resetTimer());
            return view('admin.draft.dashboard',[
                // 'userId' => $userId,
                'teamId' => $teamId,
                'league' => $league,
                'teamCount' => $teamCount,
                'draftId' => $draftId
            ]);

            }


            $userinfo = DB::table('draft_league')->where('user_id',$userId)->where('league_id',$leagueId)->where('team_id',$teamId)->exists();
            if($userinfo){
            echo 'none';
            }else{
                $id = DB::table('draft_league')-> insertGetId(array(
                    'user_id'=>$userId,
                    'league_id'=>$leagueId,
                    'team_id'=>$teamId,
                    'choose_status'=>0,
                    'active_status'=>0,
                    'round_val'=>0,
                    'draft_id'=>$randomString
                    ));

                    $draftId = DB::table('draft_league')
            ->where('user_id',$userId)->where('league_id',$leagueId)->where('team_id',$teamId)->pluck('draft_id');
            
            /** returns the league details */
            $league = DB::table('leagues')->where('id', $leagueId)->get(); 
            

            /** returns teams in a league */
            $teamCount = DB::table('teams')->where('leagueId', $leagueId)->count(); 

            return view('admin.draft.dashboard',[
                // 'userId' => $userId,
                'teamId' => $teamId,
                'league' => $league,
                'teamCount' => $teamCount,
                'draftId' => $draftId,
                "leagueId" => $leagueId
            ]);

            }
           
            
        }

        // public function autoPlayerPick($draftId, $leagueId, $userId)
        // {
        //     return [$leagueId,$draftId,$userId];
        //     $chanceDecider = DB::table('draft_league')->where('user_id', $userId)->where('league_id', $leagueId)->get();
        //     $ch_status =  $result_timer[0]->choose_status;
        //     $ac_status =  $result_timer[0]->active_status;

        //     if($ch_status != $ac_status ){
        //         DB::table('draft_league')->where('id',$result1_id)->update(array('active_status'=>'1'));
                    
        //         DB::table('draft_player_selection')->insert([
        //             "leagueId" => $leagueId,
        //             //"teamId" => $teamId,
        //             "teamId" => "1",
        //             "playerId" => $playerId,
        //             "userId" => session('userId')
        //         ]);
    
        //         DB::table('players')->where('id', $playerId)->update([
        //             "active" => 1
        //         ]);
                        
        //         DB::table('draft_league')->where('league_id',$leagueId)->update(
        //         array('choose_status'=>'0','active_status'=>'0'));
        //     }

        // }  

        public function getRandomPlayer()
        {
            $player = DB::table('players')->where('active', 0)->inRandomOrder()->get('id');
            return $player[0]->id;
        }

        public function autoPlayerPick($leagueId,$draftId, $userId)
        {
            // return response()->json([
            //     "draftId" => $draftId,
            //     "leagueId" => $leagueId,
            //     "userId" => $userId
            // ]);
            $chanceDecider = DB::table('draft_league')->where('user_id', $userId)->where('league_id', $leagueId)->get();
            // return $chanceDecider;
            $ch_status =  $chanceDecider[0]->choose_status;
            $ac_status =  $chanceDecider[0]->active_status;

            $count = DB::table('draft_league')->where('league_id',$leagueId)->where('choose_status','0')->count('id');
            $round = DB::table('draft_league')->where('league_id',$leagueId)->get();
            $round_val =  $round[0]->round_val;

            if($ch_status != $ac_status ) {
                // return "inside 1";
                $playerId = $this->getRandomPlayer();
                // return $playerId;
               
                // exit();
                
                if($count == 0) {
                    // return "inside 2";
                        $round = DB::table('draft_league')->where('league_id',$leagueId)->get();
                        $round_val =  $round[0]->round_val;
                        $total_round_val = $round_val + 1;
                        //exit();
    
                        DB::table('draft_league')->where('league_id',$leagueId)->update(
                        array('round_val'=>$total_round_val));
    
                        $round = DB::table('draft_league')->where('league_id',$leagueId)->get();
                        $round_val =  $round[0]->round_val;
                        //exit();
                            
                                
                        $result1 = DB::table('draft_league')->where('draft_id',$draftId)->get();
                        $result1_id =  $result1[0]->id;
                        
                        DB::table('draft_league')->where('id',$result1_id)->update(
                            array('active_status'=>'1'));
                    
                        DB::table('draft_player_selection')->insert([
                            "leagueId" => $leagueId,
                            //"teamId" => $teamId,
                            "teamId" => "1",
                            "playerId" => $playerId,
                            "userId" => $userId
                        ]);
    
                        DB::table('players')->where('id', $playerId)->update([
                            "active" => 1
                        ]);
                        
                        DB::table('draft_league')->where('league_id',$leagueId)->update(
                        array('choose_status'=>'0','active_status'=>'0'));
                            
                            
                        if($round_val % 2 != 0) {
                            $result2 = DB::table('draft_league')->where('league_id',$leagueId)->where('choose_status',0)->orderBy('id','desc')->limit(1)->get();
                        } else {
                            $result2 = DB::table('draft_league')->where('league_id',$leagueId)->where('choose_status',0)->orderBy('id','asc')->limit(1)->get();
                        }
                        
                        $choose_id =  $result2[0]->id;
                        DB::table('draft_league')->where('id',$choose_id)->update(
                            array('choose_status'=>'1'));
                            
                            event(new \App\Events\resetTimer());
                            return "count is zero";
                }
                    // return "inside 3";
                        $result1 = DB::table('draft_league')->where('draft_id',$draftId)->get();
                        $result1_id =  $result1[0]->id;
                    
                        DB::table('draft_league')->where('id',$result1_id)->update(
                            array('active_status'=>'1'));
                    
    
                
                            if($round_val % 2 != 0) {
                                $result2 = DB::table('draft_league')->where('league_id',$leagueId)->where('choose_status',0)->orderBy('id','desc')->limit(1)->get();
                            } else {
                                $result2 = DB::table('draft_league')->where('league_id',$leagueId)->where('choose_status',0)->orderBy('id','asc')->limit(1)->get();
                            }
                    
                            $choose_id =  $result2[0]->id;
    
                            DB::table('draft_league')->where('id',$choose_id)->update(
                                array('choose_status'=>'1'));
                    
                            DB::table('draft_player_selection')->insert([
                                "leagueId" => $leagueId,
                                //"teamId" => $teamId,
                                "teamId" => "1",
                                "playerId" => $playerId,
                                "userId" => $userId
                            ]);
    
                            DB::table('players')->where('id', $playerId)->update([
                                "active" => 1
                            ]);
                            event(new \App\Events\resetTimer());
                return "player added";
            } else {
                return "inside autoPlayerPick controller";
            }
            
            
        }
        
        

        
        public function start_draft( $leagueId,$draftId) 
        {
            // return $draftId;

            event(new \App\Events\resetTimer());

            DB::table('draft_league')->where('draft_id', $draftId)->update([
                "choose_status" => 1
            ]);

            return redirect()->route('playDraft', [
                "leagueId" =>$leagueId,
                "draftId" => $draftId
            ]);

        }

        public function addPlayerToDraft($leagueId, $playerId, $draftId)
        {
            event(new \App\Events\resetTimer());
           session()->put('leagueId', $leagueId);
           session()->put('playerId', $playerId);
           session()->put('draftId', $draftId);


			$count = DB::table('draft_league')->where('league_id',$leagueId)->where('choose_status','0')->count('id');
			//exit();
			$round = DB::table('draft_league')->where('league_id',$leagueId)->get();
			$round_val =  $round[0]->round_val;
			// exit();
            
			if($count == 0){
				
			$round = DB::table('draft_league')->where('league_id',$leagueId)->get();
			echo $round_val =  $round[0]->round_val;
			echo $total_round_val = $round_val + 1;
			//exit();

			DB::table('draft_league')->where('league_id',$leagueId)->update(
			array('round_val'=>$total_round_val));

			$round = DB::table('draft_league')->where('league_id',$leagueId)->get();
			$round_val =  $round[0]->round_val;
			//exit();
				
					
			$result1 = DB::table('draft_league')->where('draft_id',$draftId)->get();
			$result1_id =  $result1[0]->id;
            
            DB::table('draft_league')->where('id',$result1_id)->update(
                array('active_status'=>'1'));
                
                    DB::table('draft_player_selection')->insert([
                        "leagueId" => $leagueId,
                        //"teamId" => $teamId,
                        "teamId" => "1",
                        "playerId" => $playerId,
                        "userId" => session('userId')
                    ]);

                    DB::table('players')->where('id', $playerId)->update([
                        "active" => 1
                    ]);
                    
                        DB::table('draft_league')->where('league_id',$leagueId)->update(
                            array('choose_status'=>'0','active_status'=>'0'));
                        
                        /*DB::table('draft_league')->where('league_id',$leagueId)->update(
                        array('round_val'=>'1'));*/
                        
                        
                            if($round_val % 2 != 0){
                            $result2 = DB::table('draft_league')->where('league_id',$leagueId)->where('choose_status',0)->orderBy('id','desc')->limit(1)->get();
                        }else{
                            $result2 = DB::table('draft_league')->where('league_id',$leagueId)->where('choose_status',0)->orderBy('id','asc')->limit(1)->get();
                        }
                        
                        
                        $choose_id =  $result2[0]->id;
                        //exit();
                        
                        DB::table('draft_league')->where('id',$choose_id)->update(
                        array('choose_status'=>'1'));
		
               
                   
                    return redirect()->route('playDraft', [
                "leagueId" =>$leagueId,
                "draftId" => $draftId,
            ]);
                
            }
           
            
            $result1 = DB::table('draft_league')->where('draft_id',$draftId)->get();
            $result1_id =  $result1[0]->id;
            
            DB::table('draft_league')->where('id',$result1_id)->update(
                array('active_status'=>'1'));
                

           // $result2 = DB::table('draft_league')->where('league_id',$leagueId)->where('choose_status',0)->orderBy('id','asc')->limit(1)->get();
            
			if($round_val % 2 != 0){
					  $result2 = DB::table('draft_league')->where('league_id',$leagueId)->where('choose_status',0)->orderBy('id','desc')->limit(1)->get();
					}else{
					  $result2 = DB::table('draft_league')->where('league_id',$leagueId)->where('choose_status',0)->orderBy('id','asc')->limit(1)->get();
					}
			
			$choose_id =  $result2[0]->id;

                DB::table('draft_league')->where('id',$choose_id)->update(
                    array('choose_status'=>'1'));
           
                DB::table('draft_player_selection')->insert([
                    "leagueId" => $leagueId,
                    //"teamId" => $teamId,
                    "teamId" => "1",
                    "playerId" => $playerId,
                    "userId" => session('userId')
                   ]);

                   DB::table('players')->where('id', $playerId)->update([
                    "active" => 1
                   ]);
			
			// return "player added";
		
				
            return redirect()->route('playDraft', [
                "leagueId" =>$leagueId,
                "draftId" => $draftId
            ]);
        }
        
        
        public function truncate()
        {
            DB::table('draft_league')->truncate();
            DB::table('draft_player_selection')->truncate();
            
            DB::table('players')->update(
            array('active'=>'0'));
            }
			
			
			public function double_players()
        {
            $data['players'] = DB::table('players')->orderBy('id','asc')->get();
			return view('admin.player',$data);
			
        }

        public function play_partial($leagueId, $draftId)
        {

                $team = DB::table('teams')->where('leagueId', $leagueId)->where('userId', session('userId'))->get(); 
                $teamCount = DB::table('teams')->where('leagueId', $leagueId)->where('userId', session('userId'))->count();
                $league = DB::table('leagues')->where('id', $leagueId)->get(); 
                // exit($league);
                $players = DB::table('players')->where('active', 0)->get();

                $darft_list = DB::table('draft_league')->where('league_id', $leagueId)->get();

                $draft_player = DB::table('draft_player_selection')->orderBy('id','asc')->where('leagueId', $leagueId)->get();

                return view('admin.draft.play_partial', [
                    "players" => $players,
                    "draft_list" => $darft_list,
                    "draft_player" => $draft_player,
                    "league" => $league,
                    "userId" => session('userId'),
                    "draftId"=> $draftId,
                    "leagueId"=> $leagueId
                ]);

        
        }
        
        public function timer_refresh($leagueId, $draftId) 
        {
            $league = DB::table('leagues')->where('id', $leagueId)->get();

            return view('admin.draft.timer_partial', [
                "league" => $league,
                "draftId"=> $draftId,
            ]);
        }
		
		public function timer_partial($leagueId) 
        {
            $league = DB::table('leagues')->where('id', $leagueId)->get();

            return view('admin.draft.timer_partial_copy', [
                "league" => $leagueId,
            ]);
        }
		
		
		public function update_time_start(Request $request) 
        {
            $timer = $request->timer;
           $leagueID = $request->leagueID;
		   
		    DB::table('leagues')->where('id',$leagueID)->update(
		array('timer'=>10));
		
		$result = DB::table('leagues')->where('id',$leagueID)->get();
		  echo $timer_updated = $result[0]->timer;
		
		   
        }
		
		public function update_timer(Request $request) 
        {
           $timer = $request->timer;
           $leagueID = $request->leagueID;
		   
		    DB::table('leagues')->where('id',$leagueID)->update(
		array('timer'=>$timer));
		
		$result = DB::table('leagues')->where('id',$leagueID)->get();
		  echo $timer_updated = $result[0]->timer;
		
		   
        }
		
		public function update_timer_value(Request $request) 
        {
          
           $leagueID = $request->leagueID;
		
		$result = DB::table('leagues')->where('id',$leagueID)->get();
		  echo $timer_updated = $result[0]->timer;
		
		   
        }

        public function update_league_timer(Request $request)
        {
            if(empty($request->timer)) {
                return redirect()->back()->with('error', 'Timer value is required');
            }
            
            $update = DB::table('leagues')->where('id', $request->leagueId)->update([
                timer => $request->timer
            ]);
            if($update) {
                return redirect('timer-partial/'.$request-> leagueId)->with('success', 'Timer Updated!!');
            } else {
                return redirect('timer-partial/'.$request-> leagueId)->with('error', 'Some error occured');
            }

           
        }
		
		
		
		
		
        
        public function logout()
	{
	Auth::logout();
	Session::flush();
	return redirect(url('login'));
	}

}
