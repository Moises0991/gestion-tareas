$(document).ready(function(){


	// se establece intervalo de llamado a funciones para actualizar lista de usuarios y mensajes no leidos
	setInterval(function(){
		updateUserList();	
		updateUnreadMessageCount();	
	}, 20000);	



	// se establece intervalo de llamado a funciones para actualizar estatus de typing y chat del usuario
	setInterval(function(){
		showTypingStatus();
		updateUserChat();			
	}, 2000);



	$(".messages").animate({ 
		scrollTop: $(document).height() 
	}, "fast");



	$(document).on("click", '#profile-img', function(event) { 	
		$("#status-options").toggleClass("online");
	});



	$(document).on("click", '.expand-button', function(event) { 	
		$("#profile").toggleClass("expanded");
		$("#contacts").toggleClass("expanded");
	});	



	$(document).on("click", '#status-options ul li', function(event) { 	
		$("#profile-img").removeClass();
		$("#status-online").removeClass("active");
		$("#status-away").removeClass("active");
		$("#status-busy").removeClass("active");
		$("#status-offline").removeClass("active");
		$(this).addClass("active");
		if($("#status-online").hasClass("active")) {
			$("#profile-img").addClass("online");
		} else if ($("#status-away").hasClass("active")) {
			$("#profile-img").addClass("away");
		} else if ($("#status-busy").hasClass("active")) {
			$("#profile-img").addClass("busy");
		} else if ($("#status-offline").hasClass("active")) {
			$("#profile-img").addClass("offline");
		} else {
			$("#profile-img").removeClass();
		};
		$("#status-options").removeClass("active");
	});	



	$(document).on('click', '.contact', function(){		
		$('.contact').removeClass('active');
		$(this).addClass('active');
		var to_user_id = $(this).data('touserid');
		showUserChat(to_user_id);
		$(".chatMessage").attr('id', 'chatMessage'+to_user_id);
		$(".chatButton").attr('id', 'chatButton'+to_user_id);
	});	


	// se envia mensaje al dar click en el elemento que tenga la clase submit
	$(document).on("click", '.submit', function(event) { 
		var to_user_id = $(this).attr('id');
		to_user_id = to_user_id.replace(/chatButton/g, "");
		sendMessage(to_user_id);
	});


	// se envia formulario al dar click en el elemento que tenga la clase save
	$(document).on("click", '.save', function(event) { 

		var selected;    
		var userId;    
		userId = $('.userId').val();

		$('li.tasks input[type=checkbox]').each(function(){
			if (this.checked) {
				selected = $(this).val();
				console.log(userId);
				$.ajax({
					url:"chat/chat_action.php",
					method:"POST",
					data:{taskId:selected, userId:userId, action:'update_tasks'},
					dataType: "json",
					success:function(response){		
						if(response.selected) {
							if (response.selected == 'false'){
								// $('li.tasks input[type=checkbox]').html(response.se);	
								// $('.id'+selected).css('display', 'none');
								// $('.id'+selected).html(response.selected);	
								// alert(selected);
							}
						} 
					}
				});
			}
		});

		$.ajax({
			url:"chat/chat_action.php",
			method:"POST",
			data:{userId:userId, action:'show_tasks'},
			dataType: "json",
			success:function(response){		
			console.log(userId);
				if(response.list) {
					$('ul.todo-list').html(response.list);	
				} 
			}
		});
	});


	// se actualiza el is_type si se gana el foco
	$(document).on('focus', '.message-input', function(){
		var is_type = 'yes';
		$.ajax({
			url:"chat/chat_action.php",
			method:"POST",
			data:{is_type:is_type, action:'update_typing_status'},
			success:function(){
			}
		});
	}); 


	// se actualiza el is_type si se pierde el foco
	$(document).on('blur', '.message-input', function(){
		var is_type = 'no';
		$.ajax({
			url:"chat/chat_action.php",
			method:"POST",
			data:{is_type:is_type, action:'update_typing_status'},
			success:function() {
			}
		});
	}); 		
}); 



function updateUserList() {
	$.ajax({
		url:"chat/chat_action.php",
		method:"POST",
		dataType: "json",
		data:{action:'update_user_list'},
		success:function(response){		
			var obj = response.profileHTML;
			Object.keys(obj).forEach(function(key) {
				// update user online/offline status
				if($("#"+obj[key].userid).length) {
					if(obj[key].online == 1 && !$("#status_"+obj[key].userid).hasClass('online')) {
						$("#status_"+obj[key].userid).addClass('online');
					} else if(obj[key].online == 0){
						$("#status_"+obj[key].userid).removeClass('online');
					}
				}				
			});			
		}
	});
}


function sendMessage(to_user_id) {
	message = $(".message-input input").val();
	$('.message-input input').val('');
	if($.trim(message) == '') {
		return false;
	}
	// evaluaciones para formato de fecha
	var now = new Date();
	var month = (now.getMonth()+1);
	var day = now.getDate();
	var hour = now.getHours();
	var minutes = now.getMinutes();
	// day
	if (day < 10){ day = "0" + day; }
	// hour
	if (hour < 10){ hour = "0" + hour; }
	// minutes
	if (minutes < 10){ minutes = "0" + minutes; }
	// month
	if (month == '01'){ $month = 'Ene';
	} else if(month == '2'){ month = 'Feb';
	} else if(month == '3'){ month = 'Mar';
	} else if(month == '4'){ month = 'Abr';
	} else if(month == '5'){ month = 'May';
	} else if(month == '6'){ month = 'Jun';
	} else if(month == '7'){ month = 'Jul';
	} else if(month == '8'){ month = 'Ago';
	} else if(month == '9'){ month = 'Sep';
	} else if(month == '10'){ month = 'Oct';
	} else if(month == '11'){ month = 'Nov';
	} else if(month == '12'){ month = 'Dic'; }

	var date = day + "/" + month + "/" + hour + ":" + minutes;

	// fin de evaluaciones

	$('#contact-message_'+to_user_id).html(message);	
	$('#contact-date_'+to_user_id).html(date);	

	$.ajax({
		url:"chat/chat_action.php",
		method:"POST",
		data:{to_user_id:to_user_id, chat_message:message, action:'insert_chat'},
		dataType: "json",
		success:function(response) {
			var resp = $.parseJSON(response);			
			$('#conversation').html(resp.conversation);				
			$(".messages").animate({ scrollTop: $('.messages').height() }, "fast");
		}
	});	
}



function showUserChat(to_user_id){
	$.ajax({
		url:"chat/chat_action.php",
		method:"POST",
		data:{to_user_id:to_user_id, action:'show_chat'},
		dataType: "json",
		success:function(response){
			$('#userSection').html(response.userSection);
			$('#conversation').html(response.conversation);	
			$('#unread_'+to_user_id).html('');
			$('#unread_'+to_user_id).css('background', '#163f6900');
			$('#contact-name_'+to_user_id).css('color', 'white');	
		}
	});
}



function updateUserChat() {
	$('li.contact.active').each(function(){
		var to_user_id = $(this).attr('data-touserid');
		$.ajax({
			url:"chat/chat_action.php",
			method:"POST",
			data:{to_user_id:to_user_id, action:'update_user_chat'},
			dataType: "json",
			success:function(response){				
				$('#conversation').html(response.conversation);			
			}
		});
	});
}



function updateUnreadMessageCount() {
	$('li.contact').each(function(){
		if(!$(this).hasClass('active')) {
			var to_user_id = $(this).attr('data-touserid');
			$.ajax({
				url:"chat/chat_action.php",
				method:"POST",
				data:{to_user_id:to_user_id, action:'update_unread_message'},
				dataType: "json",
				success:function(response){		
					if(response.count) {
						$('#unread_'+to_user_id).html(response.count);	
						$('#unread_'+to_user_id).css('background', '#163f69');
						$('#unread_'+to_user_id).css('color', '#10ff00');
						$('#unread_'+to_user_id).css('width', '20px');
						$('#unread_'+to_user_id).css('height', '20px');
						$('#unread_'+to_user_id).css('display', 'inline-flex');
						$('#unread_'+to_user_id).css('justify-content', 'center');
						$('#unread_'+to_user_id).css('align-items', 'center');
						$('#unread_'+to_user_id).css('text-align', '#center');
						$('#unread_'+to_user_id).css('border-radius', '50%');
						$('#unread_'+to_user_id).css('position', 'absolute');
						$('#unread_'+to_user_id).css('top', '-4px');
						$('#unread_'+to_user_id).css('left', '27px');
						$('#contact-name_'+to_user_id).css('color', '#8bc34a');	
					} 
					$('#contact-message_'+to_user_id).html(response.message);	
					$('#contact-date_'+to_user_id).html(response.date);	
				}
			});
		}
	});
}



function showTypingStatus() {
	$('li.contact.active').each(function(){
		var to_user_id = $(this).attr('data-touserid');
		$.ajax({
			url:"chat/chat_action.php",
			method:"POST",
			data:{to_user_id:to_user_id, action:'show_typing_status'},
			dataType: "json",
			success:function(response){				
				$('#isTyping_'+to_user_id).html(response.message);			
			}
		});
	});
}