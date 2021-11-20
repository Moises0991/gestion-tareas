<?php
class Chat{
    private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "";
    private $database  = "data_users";      
    private $chatTable = 'chat';
	private $chatUsersTable = 'managers';
	private $chatLoginDetailsTable = 'chat_login_details';
	private $dbConnect = false;

	// se crea conexion en caso de que $dbConnect sea falso
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }

	
	// se emplea para ejecutar y retornar un array con datos de la consulta ingresada en parametro
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die();
			// die('Error in query: '. mysqli_error($conn));
		}
		$data= array();
		/*while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {*/
		while ($row = mysqli_fetch_assoc ($result)) {
			$data[]=$row;            
		}
		return $data;
	}
	

	// obtiene el numero de filas de una consulta
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die();
			// die('Error in query: '. mysqli_error($conn));
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}

	// se obtienen columnas userid & nickname de los parametros ingresados
	public function loginUsers($nickname, $password){
		$sqlQuery = "
			SELECT userid, nickname 
			FROM ".$this->chatUsersTable." 
			WHERE nickname='".$nickname."' AND pass_user='".$password."'";		
        return  $this->getData($sqlQuery);
	}		

	// se obtienen todas las filas que no tengan el id por parametro (lista de otros usuarios)
	public function chatUsers($userid){
		$sqlQuery = "
			SELECT * FROM ".$this->chatUsersTable." 
			WHERE userid != '$userid'";
		return  $this->getData($sqlQuery);
	}


	public function getTasks($id){
		$sqlQuery = " SELECT * FROM tareas_asignadas WHERE id_usuario = '$id' AND view = 'true' ";
		return  $this->getData($sqlQuery);
	}

	public function modified_tasks($id){
		$sqlQuery = "SELECT * FROM tareas_asignadas where id_usuario = $id and fecha_hora_expira >= now()";
		return  $this->getData($sqlQuery);
	}


	// se obtienen solo la fila que tengan el id por parametro (fila de usuario)
	public function getUserDetails($userid){
		$sqlQuery = "
			SELECT * FROM ".$this->chatUsersTable." 
			WHERE userid = '$userid'";
		return  $this->getData($sqlQuery);
	}


	// retorna el campo avatar de acuerdo al id ingresado por parametro
	public function getUserAvatar($userid){
		$sqlQuery = "
			SELECT avatar 
			FROM ".$this->chatUsersTable." 
			WHERE userid = '$userid'";
		$userResult = $this->getData($sqlQuery);
		$userAvatar = '';
		foreach ($userResult as $user) {
			$userAvatar = $user['avatar'];
		}	
		return $userAvatar;
	}	

	// retorna el campo username de acuerdo al id ingresado por parametro
	public function getUsername($userid){
		$sqlQuery = "
			SELECT username 
			FROM ".$this->chatUsersTable." 
			WHERE userid = '$userid'";
		$userResult = $this->getData($sqlQuery);
		$username = '';
		foreach ($userResult as $user) {
			$username = $user['username'];
		}	
		return $username;
	}	


	// actualiza el campo estatus(al que se le pase) segun el id del usuario pasado por parametro
	public function updateUserOnline($userId, $online) {		
		$sqlUserUpdate = "
			UPDATE ".$this->chatUsersTable." 
			SET online = '".$online."' 
			WHERE userid = '".$userId."'";			
		mysqli_query($this->dbConnect, $sqlUserUpdate);		
	}


	// se inserta una nueva fila en tabla de chat con datos de quien recibe, envia y mensaje (estatus determina se se ha leido)
	public function insertChat($reciever_userid, $user_id, $chat_message) {		
		$sqlInsert = "
			INSERT INTO ".$this->chatTable." 
			(reciever_userid, sender_userid, message, status) 
			VALUES ('".$reciever_userid."', '".$user_id."', '".$chat_message."', '1')";
		$result = mysqli_query($this->dbConnect, $sqlInsert);
		if(!$result){
			// return ('Error in query: '. mysqli_error($conn));
			return ('Error in query: ');
		} else {
			$conversation = $this->getUserChat($user_id, $reciever_userid);
			$data = array(
				"conversation" => $conversation
			);
			echo json_encode($data);	
		}
	}


	// se crea y regresa la conversacion con formato de img, clase, li's y mensaje
	public function getUserChat($from_user_id, $to_user_id) {
		$fromUserAvatar = $this->getUserAvatar($from_user_id);	
		$toUserAvatar = $this->getUserAvatar($to_user_id);			
		$toUsername = $this->getUsername($to_user_id);			
		$sqlQuery = "
			SELECT * FROM ".$this->chatTable." 
			WHERE (sender_userid = '".$from_user_id."' 
			AND reciever_userid = '".$to_user_id."') 
			OR (sender_userid = '".$to_user_id."' 
			AND reciever_userid = '".$from_user_id."') 
			ORDER BY timestamp ASC";
		$userChat = $this->getData($sqlQuery);	
		$conversation= '';
		// <img class="direct-chat-img" src="../pages/examples/view.php?nickname=\''.$fromUserNickname.'\'" >
		foreach($userChat as $chat){
			$user_name = '';
			if($chat["sender_userid"] == $from_user_id) {
				$day = substr($chat["timestamp"], 8, 2);
				$month = substr($chat["timestamp"], 5, 2);
				if ($month == '01'){ $month = 'Ene';
				} else if($month == '02'){ $month = 'Feb';
				} else if($month == '03'){ $month = 'Mar';
				} else if($month == '04'){ $month = 'Abr';
				} else if($month == '05'){ $month = 'May';
				} else if($month == '06'){ $month = 'Jun';
				} else if($month == '07'){ $month = 'Jul';
				} else if($month == '08'){ $month = 'Ago';
				} else if($month == '09'){ $month = 'Sep';
				} else if($month == '10'){ $month = 'Oct';
				} else if($month == '11'){ $month = 'Nov';
				} else if($month == '12'){ $month = 'Dic'; }
				$hour = substr($chat["timestamp"], 11, 5);
				$time = $day . ' ' . $month . ' ' . $hour;
				$conversation .= '
                    <div class="direct-chat-msg right">
						<div class="direct-chat-infos clearfix">
							<span class="direct-chat-timestamp float-left">'.$time.'</span>
						</div>
						<img class="direct-chat-img" src="img/avatars/'.$fromUserAvatar.'" style="width: 40px; height: 40px; object-fit:cover">
						<div class="direct-chat-text">'.$chat["message"].'</div>
					</div>
				';
			} else {
				$day = substr($chat["timestamp"], 8, 2);
				$month = substr($chat["timestamp"], 5, 2);
				if ($month == '01'){ $month = 'Ene';
				} else if($month == '02'){ $month = 'Feb';
				} else if($month == '03'){ $month = 'Mar';
				} else if($month == '04'){ $month = 'Abr';
				} else if($month == '05'){ $month = 'May';
				} else if($month == '06'){ $month = 'Jun';
				} else if($month == '07'){ $month = 'Jul';
				} else if($month == '08'){ $month = 'Ago';
				} else if($month == '09'){ $month = 'Sep';
				} else if($month == '10'){ $month = 'Oct';
				} else if($month == '11'){ $month = 'Nov';
				} else if($month == '12'){ $month = 'Dic'; }
				$hour = substr($chat["timestamp"], 11, 5);
				$time = $day . ' ' . $month . ' ' . $hour;
				$conversation .= '
                    <div class="direct-chat-msg">
						<div class="direct-chat-infos clearfix">
							<span class="direct-chat-timestamp float-right">'.$time.'</span>
						</div>
						<img class="direct-chat-img" src="img/avatars/'.$toUserAvatar.'" style="width: 40px; height: 40px; object-fit:cover">
                      <div class="direct-chat-text">'.$chat["message"].'</div>
                    </div>
				';
			}			
		}		
		return $conversation;
	}


	// se corre la funcion getuserchat con los datos pasado por parametros y se actualizan los valores status(en chat; pasando a cero),
	// current_session(en managers; con id de con quien se conversa) y por ultimo todo ello se imprime json_encode
	public function showUserChat($from_user_id, $to_user_id) {		
		$userDetails = $this->getUserDetails($to_user_id);
		$toUserAvatar = '';
		foreach ($userDetails as $user) {
			$userSection = $user['username'];
		}		
		// get user conversation
		$conversation = $this->getUserChat($from_user_id, $to_user_id);	
		// update chat user read status		
		$sqlUpdate = "
			UPDATE ".$this->chatTable." 
			SET status = '0' 
			WHERE sender_userid = '".$to_user_id."' AND reciever_userid = '".$from_user_id."' AND status = '1'";
		mysqli_query($this->dbConnect, $sqlUpdate);		
		// update users current chat session
		$sqlUserUpdate = "
			UPDATE ".$this->chatUsersTable." 
			SET current_session = '".$to_user_id."' 
			WHERE userid = '".$from_user_id."'";
		mysqli_query($this->dbConnect, $sqlUserUpdate);		
		$data = array(
			"userSection" => $userSection,
			"conversation" => $conversation			
		 );
		 echo json_encode($data);		
	}	


	// se retorna el numero de mensajes con estatus en 1(NO LEIDOS) entre dos personas
	public function getUnreadMessageCount($senderUserid, $recieverUserid) {
		$sqlQuery = "
			SELECT * FROM ".$this->chatTable."  
			WHERE sender_userid = '$senderUserid' AND reciever_userid = '$recieverUserid' AND status = '1'";
		$numRows = $this->getNumRows($sqlQuery);
		$output = '';
		if($numRows > 0){
			$output = $numRows;
		}
		return $output;
	}	


	public function updateTasksList($id, $userId) {
		$sqlUpdateTask = "
			UPDATE tareas_asignadas 
			SET view = 'false' 
			WHERE id = '".$id."'";			
		mysqli_query($this->dbConnect, $sqlUpdateTask);		

		$sqlQuery = "
			SELECT * FROM tareas_asignadas  
			WHERE id = '$id' AND view = 'false' ";
		// $task = mysqli_query($this->dbConnect, $sqlQuery);
		// $row = mysqli_fetch_assoc ($task);
		// if ($row['view'] == 'false') {
		// 	return 'false';
		// } else {
		// 	return 'true';
		// }
	}	

	public function showTaskList($userId) {

		$sqlQuery = " SELECT * FROM tareas_asignadas WHERE id_usuario = '$userId' AND view = 'true' ";
		// $tasks = mysqli_query($this->dbConnect, $sqlQuery);
		$tasks = $this->getData($sqlQuery);	

		$number = 0;
		$importance = '';
		$style = '';
		$list = '';

		foreach ($tasks as $task) {

			if (!($task['estado_tarea'] == 'Terminada' || $task['estado_tarea'] == 'Expirada')) {

				switch ($task['importancia_tarea']) {
				case "Baja": $style = "badge bg-purple"; $importance = 'baja'; break;
				case "Normal": $style = "badge bg-success"; $importance = 'nomal'; break;
				case "Alta": $style = "badge bg-warning"; $importance = 'alta'; break;
				case "Urgente": $style = "badge bg-orange"; $importance = 'urgente'; break;
				case "Inmediata": $style = "badge bg-danger"; $importance = 'inmediata'; break;
				}

				$number++;

				$list .= '
				<li class="tasks id'.$task['id'].'">
					<!-- drag handle -->
					<span class="handle">
					<i class="fas fa-ellipsis-v"></i>
					<i class="fas fa-ellipsis-v"></i>
					</span>
					<!-- checkbox -->
					<div  class="icheck-primary d-inline ml-2">
					<input type="checkbox" value="'.$task['id'].'" name="todo'.$number.'" id="todoCheck'.$number.'">
					<input type="hidden" class="userId" value="'.$task['id_usuario'].'">
					<label for="todoCheck'.$number.'"></label>
					</div>
					<!-- todo text -->
					<span class="text">'.$task['nombre_tarea'].'</span>
					<!-- Emphasis label -->
					<small class="'.$style.'" style="text-transform:capitalize"><i class="far fa-clock"></i> '.$importance.'</small>
					<!-- General tools such as edit or delete-->
					<div class="tools">
					<i class="fas fa-edit"></i>
					<i class="fas fa-trash-o"></i>
					</div>
				</li>
				';

			} else {
			}
		}
		if ($number == 0){
			return 'No se tienen tareas por hacer';
		} else {
			return $list;
		}
	}	
	
	// retorna el ultimo mensaje de una conversacion
	public function getLatestMessage($senderUserid, $recieverUserid, $type) {
		$sqlQuery = "
		SELECT * FROM ".$this->chatTable." WHERE sender_userid = '$senderUserid' AND reciever_userid = '$recieverUserid'
		OR reciever_userid = '$senderUserid' AND sender_userid = '$recieverUserid' ORDER BY timestamp DESC LIMIT 1";

		$message = mysqli_query($this->dbConnect, $sqlQuery);
		$row = mysqli_fetch_assoc ($message);
		if ($type == 'message'){
			if (!($row['message'] == '')) {
				return $row['message'];
			} else {
				return '-------no se tiene conversacion---------';
			}
		} else if ($type == 'date') {
			if (!($row['timestamp'] == '')) {
				$day = substr($row["timestamp"], 8, 2);
				$month = substr($row["timestamp"], 5, 2);
				if ($month == '01'){ $month = 'Ene';
				} else if($month == '02'){ $month = 'Feb';
				} else if($month == '03'){ $month = 'Mar';
				} else if($month == '04'){ $month = 'Abr';
				} else if($month == '05'){ $month = 'May';
				} else if($month == '06'){ $month = 'Jun';
				} else if($month == '07'){ $month = 'Jul';
				} else if($month == '08'){ $month = 'Ago';
				} else if($month == '09'){ $month = 'Sep';
				} else if($month == '10'){ $month = 'Oct';
				} else if($month == '11'){ $month = 'Nov';
				} else if($month == '12'){ $month = 'Dic'; }
				$hour = substr($row["timestamp"], 11, 5);
				$time = $day . '/' . $month . '/' . $hour;
				return $time;
			} else {
				return '--/--/--';
			}
		}
	}	


	// se actualiza el campo is_type de acuerdo al parametro que se le pase y al id de quien este logueado
	public function updateTypingStatus($is_type, $loginDetailsId) {		
		$sqlUpdate = "
			UPDATE ".$this->chatLoginDetailsTable." 
			SET is_typing = '".$is_type."' 
			WHERE id = '".$loginDetailsId."'";
		mysqli_query($this->dbConnect, $sqlUpdate);
	}		


	// se evalua si el campo is_typing (del user con id por parametro) es cierto y en caso de verdadero se retorna etiqueta smal con :is typing 
	public function fetchIsTypeStatus($userId){
		$sqlQuery = "
		SELECT is_typing FROM ".$this->chatLoginDetailsTable." 
		WHERE userid = '".$userId."' ORDER BY last_activity DESC LIMIT 1"; 
		$result =  $this->getData($sqlQuery);
		$output = '';
		foreach($result as $row) {
			if($row["is_typing"] == 'yes'){
				$output = ' - <small><em>Escribiendo...</em></small>';
			}
		}
		return $output;
	}		


	// se inserta en insertUserLoginDetails el campo userid con el valor pasado por parametro (lo demas se ingresa de forma automatica)
	// se retorna tambien el id de la tabla
	public function insertUserLoginDetails($userId) {		
		$sqlInsert = "
			INSERT INTO ".$this->chatLoginDetailsTable."(userid) 
			VALUES ('".$userId."')";
		mysqli_query($this->dbConnect, $sqlInsert);
		$lastInsertId = mysqli_insert_id($this->dbConnect);
        return $lastInsertId;		
	}	


	// se actualiza el campo last_activity a now de la tabla chat_login_details donde el id de la tabla sea igual al ingresado por parametro
	public function updateLastActivity($loginDetailsId) {		
		$sqlUpdate = "
			UPDATE ".$this->chatLoginDetailsTable." 
			SET last_activity = now() 
			WHERE id = '".$loginDetailsId."'";
		mysqli_query($this->dbConnect, $sqlUpdate);
	}	


	// se retorna el valor del campo last_activity del userid ingresado
	public function getUserLastActivity($userId) {
		$sqlQuery = "
			SELECT last_activity FROM ".$this->chatLoginDetailsTable." 
			WHERE userid = '$userId' ORDER BY last_activity DESC LIMIT 1";
		$result =  $this->getData($sqlQuery);
		foreach($result as $row) {
			return $row['last_activity'];
		}
	}	
}
?>