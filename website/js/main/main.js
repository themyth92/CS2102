
String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g, "");
};

var app = app || {};

app.Markup  = (function($){
	
	function markupList(list){
		var html ='';
		if(!list){
			html += 'None';
		}
		else
			if(list instanceof Array){
				for(var i = 0 ; i < list.length ; i++){
					if( i == list.length - 1){
						//change the list to receive number instead of string
						html += list[i];
					}
					else{
						html += list[i] + ',';						
					}
				}
			}
		else
			html += 'None';

		return html;

	}

	function markupValue(value){
		var html = '';
		if(!value){
			html += 'None';
		}
		else
			html += value;

		return html;
	}

	function markupFeature(feature){
		var html = '';
		if(feature instanceof Array){
			if(feature.length == 2){

				if(feature[0] == '1')
					html += 'Swimming Pool, ';
				
				if(feature[1] == '1')
					html += 'Fitness Club';

				if(feature[0] == '0' && feature[1] == '0')
					html += 'None';

				return html;
			}
		}

		return false;
	}

	function markupAttrRoomType(roomType){
		var html = '';
		if(roomType instanceof Array){
			if(roomType.length == 4){
				html += "ss =  '" + roomType[0] + "'";
				html += "sd =  '" + roomType[1] + "'";
				html += "sts = '" + roomType[2] + "'";
				html += "std = '" + roomType[3] + "'";

				return html;
			}
		}
		return false;
	}

	function markupPopupRoomtype(id){
		var ss = $('#element-' + id).attr('ss');
		var sd = $('#element-' + id).attr('sd'); 
		var std = $('#element-' + id).attr('std');
		var sts = $('#element-' + id).attr('sts');

		if(ss == '0'){
			$('#ssroom').attr('disabled', '');
			$('#ssroom').attr('value', '0');
		}	
		if(sd == '0'){
			$('#sdroom').attr('disabled', '');
			$('#sdroom').attr('value', '0');
		}
			
		if(sts == '0'){
			$('#stsroom').attr('disabled', '');
			$('#stsroom').attr('value', '0');
		}
			
		if(std == '0'){
			$('#stdroom').attr('disabled', '');
			$('#stdroom').attr('value', '0');
		}		
	}

	function markupRoomType(roomType){
		var html = '';
		if(roomType instanceof Array){
			if(roomType.length == 4){
				if(roomType[0] == '1')
					html += 'Superior Single, ';
				if(roomType[1] == '1')
					html += 'Superior Double, ';
				if(roomType[2] == '1')
					html += 'Standard Single, ';
				if(roomType[3] == '1')
					html += 'Standard Double, '; 
				return html;
			}
		}
		return false;
	}

	return {

		hotelList : function(id, name, feature, roomType, address, phone, postalCode){
			
			var html = '';
			var room;
			if(!(room = markupAttrRoomType(roomType)))
				return false;
			if(!id && !name)
				return false;
			else{
				html += "<div id = 'element-" + id + "' " + room + " class = 'element well'>";
				html += "<h4 class = 'hotel-name text-info text-center'>" + name + "</h4>";
				html += "<div class = 'hotel-description'>";
				html += "<dl class='dl-horizontal'>";
				html += "<dt>Feature : </dt>";
				html += "<dd>" + markupFeature(feature) + "</dd>";
				html += "<dt>Roomtypes : </dt>";
				html += "<dd>" + markupRoomType(roomType) + "</dd>";
				html += "<dt>Address : </dt>";
				html += "<dd>" + markupValue(address) + "</dd>";
				html += "<dt>Telephone : </dt>";
				html += "<dd>" + markupValue(phone) + "</dd>";
				html += "<dt>Postal code : </dt>";
				html += "<dd>" + markupValue(postalCode) + "</dd>";

				html += "<div class = 'align-center'>";
				html +=	"<input class='btn btn-primary book-btn' type='submit' data-id = '" + id + "' value = 'Book now!'>";
				html +=	"</div></div>";
				return html;	
			}
		},

		changeBookingPopup : function(id){
			if(!id)
				return false;
			else{
				var name = $('#element-' + id + ' h4').text();
				$('#model-name').text(name);
				$('#book-popup').attr('data-id', id);

				markupPopupRoomtype(id);
			}
		},
	}
}(jQuery)); 

app.uiHandle = (function($){
	return {
		errorInputHandle: function (object){
			object.addClass('error');
		},

		inputReturnNormalState : function(object){
			object.removeClass('error');
		},

		searchReturnNormalState : function(){
			this.inputReturnNormalState($('#location-search').closest('.control-group'));
			this.inputReturnNormalState($('#price-from').closest('.control-group'));
			this.inputReturnNormalState($('#price-to').closest('.control-group'));
		},

		showFullPageLoading : function(){
			$('#app').showLoading();
		},

		hideFullPageLoading : function(){
			$('#app').hideLoading();
		},

		showErrorMsgSearch : function(){
			$('#main-panel-msg').removeClass('inactive');
		},

		hideErrorMsgSearch : function(){
			$('#main-panel-msg').addClass('inactive');
		},

		showSearchResult : function(html){
			$('#main-panel').append(html);
		},

		hideSearchResult : function(){
			$('#main-panel').empty();	
		},

		datePickerHandle : function(){

			var nowTemp = new Date();
			var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

			var checkin = $('#startDate').datepicker({
			 
			  	onRender: function(date) {
			    	return date.valueOf() <= now.valueOf() ? 'disabled' : '';
			  	}
			
			}).on('changeDate', function(ev) {
				
				if (ev.date.valueOf() >= checkout.date.valueOf()) {
				    	
				    	var newDate = new Date(ev.date)
				    	newDate.setDate(newDate.getDate() + 1);
				    	checkout.setValue(newDate);
				}
			  	
			  	checkin.hide();
			  	$('#endDate')[0].focus();
			
			}).data('datepicker');
			
			var checkout = $('#endDate').datepicker({
			  	
			  	onRender: function(date) {
			    	return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
			  	}
			
			}).on('changeDate', function(ev) {
			  
				checkout.hide();

			}).data('datepicker');
		},

		showBookingMsg : function(success){
			if(success)
				$('#book-success-msg').removeClass('inactive');
			else
				$('#book-error-msg').removeClass('inactive');
		},

		hideBookingMsg : function(){
			$('#book-success-msg').addClass('inactive');
			$('#book-error-msg').addClass('inactive');
		}
	}
}(jQuery));

app.ajaxHandle = (function($){
	
	var api = {
		ACTION : {
			search : 'search',
			book : 'book',
		},

		SEARCH : {
			location  : null,
			priceFrom : null,
			priceTo   : null,
			feature1  : null, 	//swimming pool
			feature2  : null, 	//fitness club
			roomType1 : null,	//sup single
			roomType2 : null,	//sup double
			roomType3 : null,	//standard single
			roomType4 : null, 	//standard double
		},
		BOOK:{
			id : null,
			startDate : null,
			endDate : null,
			ss  : 0,
			sd  : 0,
			sts : 0,
			std : 0,
			bookingDate : null,
		},
	};

	function retrieveSearchParams(){
		api.SEARCH.location = $('#location-search').val();

		if(!api.SEARCH.location){

			app.uiHandle.errorInputHandle($('#location-search').closest('.control-group'));
			return false;
		}

		api.SEARCH.priceFrom = $('#price-from').val();
		api.SEARCH.priceTo   = $('#price-to').val();

		if(!$.isNumeric(api.SEARCH.priceFrom)){
			$('#price-from').val(0);
			app.uiHandle.errorInputHandle($('#price-from').closest('.control-group'));
			return false;
		}
		else 
			if(!$.isNumeric(api.SEARCH.priceTo)){
				$('#price-to').val(0);
				app.uiHandle.errorInputHandle($('#price-to').closest('.control-group'));
				return false;
			}

		$('#feature-1').is(':checked') ? api.SEARCH.feature1 = 1 : api.SEARCH.feature1 = 0;
		$('#feature-2').is(':checked') ? api.SEARCH.feature2 = 1 : api.SEARCH.feature2 = 0;
		$('#room-type-1').is(':checked') ? api.SEARCH.roomType1 = 1 : api.SEARCH.roomType1 = 0;
		$('#room-type-2').is(':checked') ? api.SEARCH.roomType2 = 1 : api.SEARCH.roomType2 = 0;
		$('#room-type-3').is(':checked') ? api.SEARCH.roomType3 = 1 : api.SEARCH.roomType3 = 0;
		$('#room-type-4').is(':checked') ? api.SEARCH.roomType4 = 1 : api.SEARCH.roomType4 = 0;

		return true;
	};

	function retrieveBookParams(){

 		api.BOOK.id        = $('#book-popup').attr('data-id');
 		api.BOOK.startDate = $('#startDate input').val();
 	    api.BOOK.endDate   = $('#endDate input').val();
 	    api.BOOK.ss        = $('#ssroom').val();
 	    api.BOOK.sd        = $('#sdroom').val();
 	    api.BOOK.sts       = $('#stsroom').val();
 	    api.BOOK.std       = $('#stdroom').val();

 	    if(api.BOOK.startDate == null || api.BOOK.endDate == null)
 	    	return false;

 	    if(!$.isNumeric(api.BOOK.ss))
 	    	api.BOOK.ss = 0;
 	    if(!$.isNumeric(api.BOOK.sd))
 	    	api.BOOK.sd = 0;
 	    if(!$.isNumeric(api.BOOK.sts))
 	    	api.BOOK.sts = 0;
 	    if(!$.isNumeric(api.BOOK.std))
 	    	api.BOOK.std = 0;

 	    if(api.BOOK.ss == 0 && api.BOOK.sd == 0 && api.BOOK.sts ==0 && api.BOOK.std == 0)
 	    	return false;

 	    var nowTemp = new Date();
		api.BOOK.bookingDate = nowTemp.getFullYear() + "-" + nowTemp.getMonth() + "-" + nowTemp.getDate() + "-";  

		return true;
	};

	function searchSuccessHandle(action, data){
		app.uiHandle.hideFullPageLoading();
		//solve data success callback
		if(typeof data.status != 'undefined'){
			if(data.status.code == '100'){
				app.uiHandle.showErrorMsgSearch();
			}
			else{
				if(data.status.code == '200'){
					if(data.data){
						var feature  = Array();
						var hotel    = Array();
						var roomType = Array();
						var html ;
						for(var i = 0 ; i < data.data.length ; i++){
							feature  = data.data[i].feature;
							hotel    = data.data[i].hotel;
							roomType = data.data[i].roomType;
							html     = app.Markup.hotelList(hotel[0], hotel[1], feature, roomType, hotel[2], hotel[3], hotel[4]);

							app.uiHandle.showSearchResult(html);
						}

						return true;
					}
				}
			}
		}

		return false;
	};

	function searchErrorHandle(action, error){
		app.uiHandle.hideFullPageLoading();
		console.log(action + ' is ' + error);
	}

	function bookSuccessHandle(action, data){
		app.uiHandle.hideFullPageLoading();

		if(typeof data.status != 'undefined')
			if(data.status.code == '200')
				app.uiHandle.showBookingMsg(true);
			else
				app.uiHandle.showBookingMsg(false);

		return true;
	}

	return {

		ajaxCallSearch : function(){
			app.uiHandle.searchReturnNormalState();
			app.uiHandle.hideErrorMsgSearch();
			app.uiHandle.hideSearchResult();

			if(!retrieveSearchParams())
				return false;

			app.uiHandle.showFullPageLoading();

			var action = api.ACTION.search;

			var postParam = {};
			postParam['location']  = api.SEARCH.location;
			postParam['priceFrom'] = api.SEARCH.priceFrom;
			postParam['priceTo']   = api.SEARCH.priceTo;
			postParam['feature1']  = api.SEARCH.feature1;
			postParam['feature2']  = api.SEARCH.feature2;
			postParam['roomType1'] = api.SEARCH.roomType1;
			postParam['roomType2'] = api.SEARCH.roomType2;
			postParam['roomType3'] = api.SEARCH.roomType3;
			postParam['roomType4'] = api.SEARCH.roomType4;

			app.Ajax.ajaxCall(action, postParam, searchSuccessHandle, searchErrorHandle);
 		},

 		ajaxCallBook : function(){

 			if(!retrieveBookParams())
 				return false;

 			app.uiHandle.showFullPageLoading();
 			app.uiHandle.hideBookingMsg();

			var action = api.ACTION.book;

			var postParam = {};

			postParam['bookingID']  = api.BOOK.id;
			postParam['startDate'] = api.BOOK.startDate;
			postParam['endDate']   = api.BOOK.endDate;
			postParam['roomType1']  = api.BOOK.ss;
			postParam['roomType2']  = api.BOOK.sd;
			postParam['roomType3'] = api.BOOK.sts;
			postParam['roomType4'] = api.BOOK.std;
			postParam['bookingDate'] = api.BOOK.bookingDate;

			app.Ajax.ajaxCall(action, postParam, bookSuccessHandle, searchErrorHandle);	
 		}
	}

}(jQuery))

app.ButtonHandle = (function($){
	return{
		searchBtnHandle : function(){
			$('#search-btn').click(function(){
				app.ajaxHandle.ajaxCallSearch();
			})
		},

		booknowBtnHandle : function(){
			$(document).on('click','.book-btn', function(e){

				var id = $(e.target).attr('data-id');
				$('#book-popup').modal();
				app.Markup.changeBookingPopup(id);
				app.uiHandle.hideBookingMsg();
			})
		},

		bookBtnHandle: function(){
			$(document).on('click','.book', function(){
				app.ajaxHandle.ajaxCallBook();
			})
		}
	};
}(jQuery))

$(document).ready(function(){

	app.ButtonHandle.searchBtnHandle();
	app.ButtonHandle.booknowBtnHandle();
	app.ButtonHandle.bookBtnHandle();

	app.uiHandle.datePickerHandle();
})