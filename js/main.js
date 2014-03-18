$(document).ready(function(){
	main.checkLogin();
	main.getMemberList();
	main.addEvent();
	main.clearAll();
});

var main = {

	getMemberList:function(){
		//ajax获取到当前的用户列表，并显示出来。
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
			       alert('获取聊天记录失败，请刷新！');
			   }
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
		logoutBtn.click = function(){
			member.logOut();
		};
		//获取信息
		msg.get();
	},
	
	//初始化：1.清空输入框  2.清空聊天记录
	clearAll:function(){
		var inputArea = $('#in-area');
		var chatList = $('.msg-main .msg-box ul');
		inputArea.html('');
		chatList.html('');
	}
	
	
}
