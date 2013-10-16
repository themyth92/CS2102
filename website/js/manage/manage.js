var app = app || {};

app.Markup = (function($){

	function changeRoomTypeLabel(index){
		
		var html = '';
		switch(index){
			case 0:
				html = '<td>Superior Double</td>';
				break;
			case 1:
				html = '<td>Superior Double</td>';
				break;
			case 2:
				html = '<td>Standard Single</td>';
				break;
			case 3:
				html = '<td>Standard Double</td>';
				break;
		}

		return html;
	}

	function checkCheckinDate(checkin){
		
		var dateSplit = checkin.split('-');
		if(dateSplit.length == 3){

			parseInt(dateSplit[1]);
			dateSplit[1] = dateSplit[1] - 1;

			var checkInDate = new Date(dateSplit[0], dateSplit[1], dateSplit[2], 0, 0, 0, 0);

			var nowTemp = new Date();
			var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

			if(checkInDate <= now)
				return false;
			else
				return true;
		}
	}

	function checkRoomType(roomType){

		var html = '';

		if(roomType instanceof Array){
			if(roomType.length == 4){
				for( var i = 0 ; i < roomType.length; i++){
					if(roomType[i] != 0){
						html += changeRoomTypeLabel(i);
						html += "<td>" + roomType[i] + "</td>";
						return html; 
					}
				}
			}
		}
	}

	return {
		bookingListMarkup : function(id, bookingID, hotel, username, roomType, checkIn, checkOut, bookingDate){
			
			var html = '';
			html += "<tr id = 'row-" + id + "'>";
			html += "<td id = 'bookingID-" + id + "'>" + bookingID + "</td>";
			html += "<td>" + hotel + "</td>";
			html += "<td>" + username + "</td>";
			html += checkRoomType(roomType);
			html += "<td>";
			html += "<div id = 'start-date-" + id + "' class = 'input-append date' data-date = '" + checkIn + "' data-date-format='yyyy-mm-dd'>";
			html += 	"<input class='span2' type='text' readonly value = ' " + checkIn + " '>";
			html += 	"<span class = 'add-on'><i class = 'icon-calendar'></i></span>";
			html += "</div></td><td>";
			html += "<div class = 'input-append date' id ='end-date-" + id + "' data-date = '" + checkOut + "' data-date-format='yyyy-mm-dd'>";
			html += "<input class='span2' type='text' readonly value = '" + checkOut + "'>";
			html += "<span class='add-on'><i class = 'icon-calendar'></i></span>";
			html +=	"</div></td>";
			html += "<td>" + bookingDate + "</td>";

			if(checkCheckinDate(checkIn)){
				html += "<td><button class = 'btn btn-primary btn-save' data-id = '" + id + "'>Save</button></td>";
				html += "<td><button class = 'btn btn-danger btn-delete' data-id = '" + id + "'>Delete</button></td>";
			}
			else{
				html += "<td><button class = 'btn btn-disabled' disabled>Save</button></td>";
				html += "<td><button class = 'btn btn-disabled' disabled>Delete</button></td>";
			}

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
		},

		showManageErrorRetrieve : function(){
			//show the none here
			console.log('none!');
		},

		datePickerHandle : function(index){
			
			var nowTemp = new Date();
			var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
			 
			var checkin = $('#start-date-' + index).datepicker({
			 
			  	onRender: function(date) {
			    	return date.valueOf() < now.valueOf() ? 'disabled' : '';
			  	}
			
			}).on('changeDate', function(ev) {
				
				if (ev.date.valueOf() > checkout.date.valueOf()) {
				    	
				    	var newDate = new Date(ev.date)
				    	newDate.setDate(newDate.getDate() + 1);
				    	checkout.setValue(newDate);
				}
			  	
			  	checkin.hide();
			  	$('#end-date-' + index)[0].focus();
			
			}).data('datepicker');
			
			var checkout = $('#end-date-' + index).datepicker({
			  	
			  	onRender: function(date) {
			    	return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
			  	}
			
			}).on('changeDate', function(ev) {
			  
				checkout.hide();

			}).data('datepicker');
		}
	}
}(jQuery))

app.ajaxHandle = (function($){
	
	var api = {
		ACTION:{
			manage : 'manage',
			save : 'save',
			remove : 'remove',
		},
		CODE:{
			success : '200',
			error : '100',
		}
	}

	function retrieveBookingSuccessCallBack(action, data){

		$('#main-table').empty();
		app.uiHandle.hideFullPageLoading();
		
		var html = '';

		//update the ui here
		if(data){
			if(typeof data.status != "undefined"){
				if(data.status.code == api.CODE.success){
					if(typeof data.data != "undefined"){
						if(data.data instanceof Array){
							for(var i = 0 ; i < data.data.length ; i++){

								html = app.Markup.bookingListMarkup(i, data.data[i].bookingID, data.data[i].hotel, data.data[i].email, data.data[i].roomType, data.data[i].startDate, data.data[i].endDate, data.data[i].bookingDate);
								$('#main-table').append(html);
								app.uiHandle.datePickerHandle(i);
							}

							return true;
						}
					}
				}
			}
		}

		app.uiHandle.showManageErrorRetrieve();
		return false;
	}

	function errorCallBack(action, error){
		app.uiHandle.hideFullPageLoading();
		console.log(action + ' is ' + error);	
	}

	return{
		removeBookingSuccessCallBack : function(){
			app.uiHandle.hideFullPageLoading();
			app.ajaxHandle.retrieveUserBooking();
		},
		
		retrieveUserBooking : function(){
			
			app.uiHandle.showFullPageLoading();

			var postParam = {};
			postParam['action'] = api.ACTION.manage;
			app.Ajax.ajaxCall(api.ACTION.manage, postParam, retrieveBookingSuccessCallBack, errorCallBack);
		},
	}
}(jQuery))

app.buttonHandle = (function($){
	return{
		removeButtonHandle : function(){
			$(document).on('click', '.btn-delete' , function(e){

				app.uiHandle.showFullPageLoading();

				var id = $(e.target).attr('data-id');

				var bookingID = $('#bookingID-' + id).html();
				var postParam = {};

				postParam['action'] = 'remove';
				postParam['bookingID'] = bookingID;
				app.Ajax.ajaxCall('remove', postParam, app.ajaxHandle.removeBookingSuccessCallBack, app.ajaxHandle.errorCallBack);
			})
		}

	}
}(jQuery))

$(document).ready(function(){
	app.ajaxHandle.retrieveUserBooking();
	app.buttonHandle.removeButtonHandle();

})