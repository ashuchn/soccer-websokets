<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::match(['get', 'post'], 'login', [MainController::class, 'login' ])->name('login');
Route::match(['get', 'post'], 'signup', [MainController::class, 'signup' ])->name('signup');

Route::get('truncate', [MainController::class, 'truncate'])->name('truncate');
	Route::get('double_players',[MainController::class, 'double_players'])->name('double_players');


Route::group(['middleware' => ['checkuser']],function(){

    

    
    
    
    Route::get('dashboard', [MainController::class, 'dashboard'])->name('dashboard');
    
    Route::match(['get','post'],'addLeague', [MainController::class, 'addLeague'])->name('addLeague');

    Route::get('dashboard/league/{leagueId}', [MainController::class, 'leagueDashboard'])->name('leagueDashboard');
    
    Route::match(['get','post'],'addTeam/{leagueId?}', [MainController::class, 'addTeam'])->name('addTeam');
    
    Route::get('dashboard/league/{leagueId}/team/{teamId}', [MainController::class, 'mainDashboard'])->name('mainDashboard');

    Route::get('draftDashboard/league/{leagueId}/team/{teamId}', [MainController::class, 'draft'])->name('draftDashboard');

    Route::get('playDraft/league/{leagueId}/draft/{draftId}', [MainController::class, 'playDraft'])->name('playDraft');

    Route::get('addPlayerToDraft/league/{leagueId}/player/{playerId}/draftId/{draftId}', [MainController::class, 'addPlayerToDraft'])->name('addPlayerToDraft');

    Route::get('start-draft/league/{leagueId}/draft/{draftId}',[MainController::class, 'start_draft'])->name('start-draft');
    
    Route::get('play_partial/{leagueId}/{draftId}', [MainController::class, 'play_partial'])->name('play_partial');

    Route::get('timer-refresh/{leagueId}/{draftId}', [MainController::class, 'timer_refresh'])->name('timer-refresh');
    Route::get('timer-partial/{leagueId}', [MainController::class, 'timer_partial'])->name('timer-partial');
    
    Route::post('update_time_start', [MainController::class, 'update_time_start'])->name('update_time_start');
    Route::post('update_timer', [MainController::class, 'update_timer'])->name('update_timer');
    Route::post('update_timer_value', [MainController::class, 'update_timer_value'])->name('update_timer_value');

    Route::post('update-league-timer', [MainController::class, 'update_league_timer'])->name('update-league-timer');

    Route::get('getUserStatus/userId/{userId}/leagueId/{leagueId}', [MainController::class, 'getUserStatus'])->name('getUserStatus');
});


Route::get('logout', [MainController::class, 'logout'])->name('logout');

Route::get('pusher', function () {
    event(new App\Events\resetTimer('Hi'));
    return "Event has been sent!";
});
