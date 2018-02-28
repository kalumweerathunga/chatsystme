<?php
	include ('conn.php');
	session_start();
	if(isset($_POST['msg'])){
		$msg = addslashes($_POST['msg']);
		$id = $_POST['id'];

		if($msg){
			mysqli_query($conn,"insert into `chat` (chat_room_id, chat_msg, userid, chat_date) values ('$id', '$msg' , '".$_SESSION['userid']."', NOW())") or die(mysqli_error());
		}
	}
	$user_id=$_SESSION['userid'];
?>
<?php
	if(isset($_POST['res'])){
		$id = $_POST['id'];
		$msg = $_POST['msg'];
		echo $msg;

		if(!$msg=null){
			?>
			<?php
				$query=mysqli_query($conn,"select * from `chat` left join `user` on user.userid=chat.userid where chat_room_id='$id' and chat.userid='$user_id' order by chat_date asc") or die(mysqli_error());
				while($row=mysqli_fetch_array($query)){
			?>
				<div>
					<?php echo date('h:i A',strtotime($row['chat_date'])); ?><br>
					<?php echo $row['your_name']; ?>: <?php echo $row['chat_msg']; ?><br>

				</div>
				<br>
			<?php
					$keywords = "hello world";
					$keyword_tokens = explode(' ', $msg);
					foreach($keyword_tokens  as $keyword) {
						$sql = mysqli_query($conn,"SELECT * FROM chat WHERE chat_msg LIKE'%$keyword%'");
						while($row=mysqli_fetch_array($sql)){
							echo "Hospital:" .$row['chat_msg'];
						}
					}
				}
			}
		}
?>
