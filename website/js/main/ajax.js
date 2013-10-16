var app = {} || app;

app.Ajax = (function($){

	var api = {
		
		USER_ACTION:{
			book : 'book',
			search: 'search',
			manage: 'manage',
			remove: 'remove',
		},

		ADDRESS:{
			search : 'http://themyth92.com/CS2102/website/backend/ajax/search.php',
			book : 'http://themyth92.com/CS2102/website/backend/ajax/book.php',
			manage : 'http://themyth92.com/CS2102/website/backend/ajax/manage.php',
		},
	}

	function getAddress(action){
		if(action == api.USER_ACTION.book)
			return api.ADDRESS.book;
		else
			if(action == api.USER_ACTION.manage)
				return api.ADDRESS.manage;
			else
				if(action == api.USER_ACTION.search)
					return api.ADDRESS.search;
				else
					if(action == api.USER_ACTION.remove)
						return api.ADDRESS.manage;

		return false;
	}	

	return {
		ajaxCall : function(action, postParams, successCallBack, errorCallBack){
			
			var addr;
			
			if(!(addr = getAddress(action)))
				return false;

			$.ajax({
		        url      : addr,
		        type     :'POST',
		        dataType :'json',
		        data     : postParams,

		        
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
		}
	}

}(jQuery));