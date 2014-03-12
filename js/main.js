$(document).ready(function(){
	main.addEvent();
	main.clearAll();
});

var main = {
	
	
	addEvent:function(){
		var sendBtn = $('.send-btn input');
		sendBtn.live("click",function(){
			//发送
			msg.send();
		});
		//获取信息
		msg.get();
		
	},
	
	clearAll:function(){
		var inputArea = $('#in-area');
		inputArea.html('');
		
	}
	
	
}
