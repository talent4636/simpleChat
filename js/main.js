var main = {

	getMemberList:function(){
		//ajax获取到当前的用户列表，并显示出来。
		main.listShowLoading("show");
		$.ajax({
		   type: "POST",
		   url: "../simpleChat/controller/member.php",
		   dataType:"json",
		   data: "type=getMemberList",
		   success: function(rmsg){
		   	   if(rmsg.status=='succ'){
		   	   		$.each(rmsg.data,function(i,v){
		   	   			if(v.name != member.currentName()){
		   	   				member.displayMemberList(v.name,v.id);
		   	   			}
					});
		   	        var memCount = rmsg.data.length-1;
		   	        member.updateMemberCount(memCount);
			   }else{
			       alert(rmsg.data);
				   top.location='login.html';
			   }
			   main.listShowLoading("hide");
			   main.textShowLoading("hide");
		   }
		}); 
	},

	//检测登陆状态，如果未登陆，跳转到登陆，如果已登录，直接进入聊天页面
	checkLogin:function(){
		var name = cookie.getCookie('chatname');
		if (name) {
			// top.location='index.html';
		}else {
			// top.location='login.html';
		}
	},
	
	addEvent:function(){
		var sendBtn = $('.send-btn input');
		var list = $('.friend-list .list ul li');
		var logoutBtn = $('.top-title .text .logout-btn');
		sendBtn.live("click",function(){
			//发送
			msg.send();
		});
		list.live("click",function(){
			member.changeChatObj($(this));
		});
		logoutBtn.live("click",function(){
			if (confirm('确定退出？')){
				member.logOut();
			}else {
				return false;
			}
		});
		//获取信息
		msg.get();
	},
	
	//初始化：1.清空输入框  2.清空聊天记录
	clearAll:function(){
		var inputArea = $('#in-area');
		var chatList = $('.msg-main .msg-box ul');
		inputArea.html('');
		chatList.html('');
	},
	
	//ajax获取数据过程中样式变化
	//type =  list/ text
	listShowLoading:function(changeto){
		if(!changeto) return false;
		var list = $('.loading-friend-list');
		if(changeto=="show")list.show();
		else list.hide();
	},
	
	textShowLoading:function(changeto){
		if(!changeto) return false;
		var text = $('.loading-chat-history');
		if(changeto=="show")text.show();
        else text.hide();
	},
	
	//发送消息成功之后，loading取消
	msgLoading:function(id){
		var item = $('#'+id);
		item.hide();
	}
	
	
}
