var app = app || {};

app.Markup = (function($){

	function checkRoomType(roomType){

		var html = '';

		if(roomType instanceof Array){
			if(roomType.length == 4){
				for( var i = 0 ; i < roomType.length; i++){
					if(roomType[i] != 0){
						html += "<td>" + roomType[i] + "</td>";
						return html; 
					}
				}
			}
		}
	}

	return {
		bookingListMarkup : function(id, bookingID, hotel, roomType, checkIn, checkOut, bookingDate){
			
			var html = '';
			html += "<tr id = 'row-'" + id + ">";
			html += "<td id = 'bookingID-" + id + " '>" + bookingID + "</td>";
			html += "<td>" + hotel + "</td>";
			html += checkRoomType(roomType);
			html += "<td>";
			html += "<div id = 'start-date-' " + id + " class = 'input-append date' data-date data-date-format='dd-mm-yyyy'>";
			html += 	"<input class='span1' type='text' value>";
			html += 	"<span class = 'add-on'><i class = 'icon-calendar'></i></span>";
			html += "</div></td><td>";
			html += "<div class = 'input-append date' id ='end-date-' " + id + " data-date data-date-format='dd-mm-yyyy'>";
			html += "<input class='span1' type='text' value>";
			html += "<span class='add-on'><i class = 'icon-calendar'></i></span>";
			html +=	"</div></td>";
			html += "<td>" + bookingDate + "</td>";
			html += "<td><button class = 'btn btn-primary' data-id = '" + id + "'>Save</button></td>";
			html += "<td><button class = 'btn btn-danger' data-id = '" + id + "'>Delete</button></td>";

			return html;
		}	
	}
}(jQuery))

app.uiHandle = (function($){
	return {

		showFullPageLoading : function(){
			$('#app').showLoading();
		},

		hideFullPageLoading : function(){
			$('#app').hideLoading();
		}
	}
}(jQuery))

app.ajaxHandle = (function($){
	
	var api = {
		ACTION:{
			manage : 'manage',
			save : 'save',
			remove : 'delete',
		}
	}

	function retrieveBookingSuccessCallBack(action, data){
		app.uiHandle.hideFullPageLoading();
		//update the ui here
	}

	function retrieveBookingErrorCallBack(action, error){
		app.uiHandle.hideFullPageLoading();
		console.log(action + ' is ' + error);	
	}

	return{
		retrieveUserBooking : function(){
			
			app.uiHandle.showFullPageLoading();

			var postParam = {};
			postParam['action'] = api.ACTION.manage;
			app.Ajax.ajaxCall(api.ACTION.manage, postParam, retrieveBookingSuccessCallBack, retrieveBookingErrorCallBack);
		},
	}
}(jQuery))

app.buttonHandle = (function($){
	return{

	}
}(jQuery))

$(document).ready(function(){
	app.ajaxHandle.retrieveUserBooking();
})