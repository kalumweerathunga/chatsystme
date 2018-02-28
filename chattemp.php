<?php
	include('conn.php');
	session_start();
	if (!isset($_SESSION['userid']) ||(trim ($_SESSION['userid']) == '')) {
	header('location:index.php');
    exit();
	}
	$uquery=mysqli_query($conn,"select * from `user` where userid='".$_SESSION['userid']."'");
	$urow=mysqli_fetch_assoc($uquery);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Responsive Chat Template | PrepBootstrap</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="style.css" rel="stylesheet" id="bootstrap-css">
    <script src="style.js"></script>
</head>
<body>

  <div class="container">
    <div class="row chat-window col-xs-5 col-md-3" id="chat_window_1" style="margin-left:10px;">
        <div class="col-xs-12 col-md-12">
        	<div class="panel panel-default">
                <div class="panel-heading top-bar">
                    <div class="col-md-8 col-xs-8">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat - <?php echo $urow['your_name']; ?></h3>
                    </div>
                    <div class="col-md-4 col-xs-4" style="text-align: right;">
                        <a href="#"><span id="minim_chat_window" class="glyphicon glyphicon-minus icon_minim"></span></a>
                    </div>
                </div>
            <?php
              $query=mysqli_query($conn,"select * from `chat_room`");
              while($row=mysqli_fetch_array($query)){
                ?>
                <div class="panel-body msg_container_base">
                    <div class="row msg_container base_sent">
                        <div class="col-md-10 col-xs-10">
                          <div class="messages msg_sent" id="result">
                             <p>that mongodb thing looks good, huh?tiny master db, and huge document store</p>
                             <time datetime="2009-11-13T20:00">Timothy • 51 min</time>
                         </div>
                        </div>
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                        </div>
                    </div>

                    <div class="row msg_container base_sent">
                        <div class="col-md-10 col-xs-10">
                          <div class="messages msg_sent">
                             <p>that mongodb thing looks good, huh?tiny master db, and huge document store</p>
                             <time datetime="2009-11-13T20:00">Timothy • 51 min</time>
                         </div>
                        </div>
                        <div class="col-md-2 col-xs-2 avatar">
                            <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="input-group">
                      <form>
                        <input id="msg" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />
                        <input type="hidden" value="<?php echo $row['chat_room_id']; ?>" id="id">
                        <span class="input-group-btn">
                        <button class="btn btn-primary btn-sm" id="send_msg">Send</button>
                        </span>
                      </form>
                    </div>
                </div>
                <?php
          		} ?>
    		</div>
        </div>
    </div>

</div>

<script src = "jquery-3.1.1.js"></script>
<script type = "text/javascript">

	$(document).ready(function(){
	displayResult();
	/* Send Message	*/

		$('#send_msg').on('click', function(){
			if($('#msg').val() == ""){
				alert('Please write message first');
			}else{
				$msg = $('#msg').val();
				$id = $('#id').val();
				$.ajax({
					type: "POST",
					url: "send_message.php",
					data: {

						id: $id,
					},
					success: function(){
						displayResult();
					}
				});
			}
		});
	});

	function displayResult(){
		$id = $('#id').val();
    $msg = $('#msg').val();
		$.ajax({
			url: 'send_message.php',
			type: 'POST',
			async: false,
			data:{
				id: $id,
        msg: $msg,
				res: 1,
			},
			success: function(response){
				$('#result').html(response);
			}
		});
	}

</script>

</body>
</html>
