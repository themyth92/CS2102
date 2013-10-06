//singleton
var App = App || {};

App.ajax = (function($){
	
	//private attr
	var constant = {
		ADDRESS : {
			login   : 'http://themyth92.com/CS2102/website/backend/ajax/login.php',
			register: 'http://themyth92.com/CS2102/website/backend/ajax/register.php',
		},
		ACTION : {
			login   : 'login',
			register: 'register',
		},
	};

	function getAddress(action){
		
		switch(action){
			case constant.ACTION.login:
				return constant.ADDRESS.login;
			break;
			case constant.ACTION.register:
				return constant.ADDRESS.register;
			break;
			default:
				return false;
			break;
		}
	}

	//public methods
	return {

		callAjax : function(action, message, successCallBack, errorCallBack){
			
			var addr;
			console.log(message);

			if(!(addr = getAddress(action)))
				return false;

			$.ajax({
		        url      : addr,
		        type     :'POST',
		        dataType :'json',
		        data     : {
		        			'message': message,
		        },
		        
		        //the success call back when all the data are sent to server
		        success: function(data){
		        	
		        	console.log(data);
		        	if(successCallBack){
		        		successCallBack(action, data);
		        	}
		        },
		        //the error call back when we can not connect to server or server down
		        error: function(xhr,err){
		        	
		        	if(errorCallBack){
		        		errorCallBack(action, err);
		        	}
		        }
	        });
		},
	}

}(jQuery));