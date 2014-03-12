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
		msg.displayNew(name,time,con);
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
				if (r.status=='succ'){
					$.each(r.data,function(i,v){
						msg.displayNew(v.name,v.time,v.content);
					});
				}else{
					alert('Warning!');
				}
			}
		});
		
	},
	
	//显示新的聊天记录
	displayNew:function(name,time,con){
		content = msg.changeToCon(name,time,con);
		var msgbox = $('.msg-main .msg-box ul');
		msgbox.append(content);
	},
	
	//清除输入框中的内容
	cleanBox:function(){
		var content = $('#in-area').val(''); 
	},
	
	//获取当前用户名
	currentName:function(){
		//TODO
	},
	
	//发送错误时的处理
	sendError:function(){
		var lastOne = $('.sending');
		var f = $('.sending span');
		f.append("<font class='wrong'>消息发送失败!</font>");
		lastOne.attr('class','failure');
	},
	
	//将内容转化成可以显示的内容并返回
	changeToCon:function(name,time,con){
		var content = "<li class='sending'><em class='name'>"+name+"</em><em class='time'>"+time+"</em><span class='content'>"+con+"</span></li>";
        return content;
		
	}
	
}











