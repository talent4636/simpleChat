var msg = {
	//发送消息
	send:function(){
		var con = $('#in-area').val();
		var msgbox = $('.msg-main .msg-box ul');
        
		//第一步，更新当前页面
		var name = "myname";//TODO
		var myDate = new Date();
		var time = myDate.toLocaleString();
		if(con.length<1){
			return ;
		};
		var content = "<li class='sending'><em class='name'>"+name+"</em><em class='time'>"+time+"</em><span class='content'>"+con+"</span></li>";
		msg.displayNew(name,time,content);
		msg.cleanBox();//清空输入框
		
		//第二部，发送到服务器
		$.ajax({
		   type: "POST",
		   url: "../simpleChat/controller/mainController.php",
		   dataType:"json",
		   data: "type=send&name="+name+"&time="+time+"&content="+con,
		   success: function(rmsg){
		   	   if(rmsg.status=='succ'){
		   	       //发送成功，不做改变
			   }else{
			       msg.sendError();
			   }
		   }
		}); 
		
	},
	
	//获取消息
	get:function(){
		var name = '123';
		$.ajax({
			type:"POST",
			url:"../simpleChat/controller/mainController.php",
			dataType:"json",
			data: "type=get&name="+name,
			success: function(r){
//				if (r.status=='succ'){
//					alert(r);
//				}else{
					alert(r);
//				}
			}
		});
		
	},
	
	displayNew:function(name,time,content){
		var msgbox = $('.msg-main .msg-box ul');
		msgbox.append(content);
	},
	
	cleanBox:function(){
		var content = $('#in-area').val(''); 
	},
	
	currentName:function(){
		
		//todo
//		var name = 
	},
	
	sendError:function(){
		var lastOne = $('.sending');
		var f = $('.sending span');
		f.append("<font class='wrong'>消息发送失败!</font>");
		lastOne.attr('class','failure');
	}
	
}











