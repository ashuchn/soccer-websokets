<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
    <title>White Board</title>
    <link rel="icon" href="" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
    </link>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
   
	<?php $result = DB::table('leagues')->where('id',$league)->get();
		  $timer = $result[0]->timer;	
	?>  
	<input type="hidden" id="tsr" value="<?php echo $timer; ?>">
	<input type="text" id="leagueID" value="<?php echo $league; ?>">
    <div class="d-flex justify-content-center">
    @if (\Session::has('error'))
        <div class="alert alert-danger">
            <ul>
                <li>{!! \Session::get('error') !!}</li>
            </ul>
        </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
        <form action =" {{ route('update-league-timer') }} " method = "post">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">Update League Timer</label>
                <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="update-timer" name="timer" placeholder="Update Timer">
                <small id="update-timer" class="form-text text-muted">Enter time in seconds to update timer</small>
                <input type="hidden" name="leagueId" value="<?php echo $league; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
    

    <div class="justify-content-center align-items-center d-flex" style="height: 100vh;">
        <div class="bg-primary justify-content-center align-items-center d-flex" style="height: 400px;width:400px">
            <div class="bg-white justify-content-center d-flex align-items-center"
                style="box-shadow: 0px 0px 2px 1px grey;width:70px;height: 70px;font-size: 30px;border-radius: 10px;">
                <div class="" id="countdown"></div>
            </div>
        </div>
    </div>
	
	 <script>

       // var timeleft = 10;
		var timeleft = $('#tsr').val();
		var leagueID = $('#leagueID').val();
        var downloadTimer = setInterval(function () {
            if (timeleft == 0) {
                clearInterval(downloadTimer);
                
				
				$.ajax({
			url:'{{url("update_time_start")}}',
			method:'POST',
			data:{timer:10,leagueID:leagueID,'_token':"{{csrf_token()}}"},
			success:function(data){
			//alert(data);
			//$('#child_id').html(data);
			//$('#countdown').html(data);
			}
			});
			
			//alert('done');
				
				
            } else {
				
				$.ajax({
			url:'{{url("update_timer")}}',
			method:'POST',
			data:{timer:timeleft,leagueID:leagueID,'_token':"{{csrf_token()}}"},
			success:function(data){
			//alert(data);
			$('#countdown').html(data);
			}
			});
			
			//write refresh code here
				
                $('#countdown').html(timeleft);
            }
            timeleft -= 1;
        }, 1000);
    </script>
</body>

</html>