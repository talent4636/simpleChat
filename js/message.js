var msg = {
	//发送消息
	send:function(){
		var con = $('#in-area').val();
		var msgbox = $('.msg-main .msg-box ul');
        //第一步，更新当前页面
		var name = "myname";
		var myDate = new Date();
		var time = myDate.toLocaleString();
		if(con.length<1){
			return ;
		};
		var content = "<li><em class='name'>"+name+"</em><em class='time'>"+time+"</em><span class='content'>"+con+"</span></li>";
		msg.displayNew(name,time,content);
		msg.cleanBox();//清空输入框
		//第二部，发送到服务器
		/*
		$.ajax({
		   type: "POST",
		   url: "some.php",
		   data: "name=John&location=Boston",
		   success: function(msg){
		     alert( "Data Saved: " + msg );
		   }
		}); */
	},
	
	//获取消息
	get:function(){
		
		
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
	}
	
}











