var member = {

	displayMemberList:function(name,id){
		var listBox = $('.friend-list .list ul');
		var item = "<li member-id='"+id+"' class='on'>"+name+"</li>";
		listBox.append(item);
	},

	//获取当前用户名
	currentName:function(){
		var name = cookie.getCookie('chatname');
		return name;
	},

	updateMemberCount:function(num){
		var count = $('.friend-list .status-num strong');
		count.html(num);
	},

	getWithWho:function(){
		var withId = $('.top-title .text .on-chat').attr('with-id');
		return withId;
	},

	//切换聊天对象
	changeChatObj:function(_this){
		var memberId = _this.attr('member-id');
		var memberName = _this.html();
		var nowOnChat = $('.top-title .text .on-chat');
		var nowOnChatName = $('.top-title .text .on-chat strong');
		nowOnChat.attr('with-id',memberId);
		nowOnChatName.html(memberName);
		//初始化一下：
		main.clearAll();
		msg.get();
	},

	logOut:function(){
		//让后台处理，前台只管判断处理结果
		$.ajax({
		   type: "POST",
		   url: "../simpleChat/controller/member.php",
		   dataType:"json",
		   data: "type=logOut",
		   success: function(rmsg){
		   	   if(rmsg=='succ'){
		   	   		top.location='login.html';
			   }
		   }
		}); 
	}

}