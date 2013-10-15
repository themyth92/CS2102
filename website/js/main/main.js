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

	function markupRoomType(feature){
		var html = '';
		if(feature instanceof Array){
			if(feature.length == 4){
				html += 'ss =  ' + feature[0];
				html += 'sd =  ' + feature[1];
				html += 'sts = ' +feature[2];
				html += 'std = ' + feature[3];
			}
			else{
				return false;
			}
		}
		else{
		}
		return false;
	}

	function markupPopupRoomtype(id){
		var ss = $('#element-' + id).attr('ss');
		var sd = $('#element-' + id).attr('sd'); 
		var std = $('#element-' + id).attr('std');
		var sts = $('#element-' + id).attr('sts');
		console.log(ss);
		if(ss == '0')
			$('#ssroom').attr('disabled', '');
		if(sd == '0')
			$('#sdroom').attr('disabled', '');
		if(sts == '0')
			$('#stsroom').attr('disabled', '');
		if(std == '0')
			$('#stdroom').attr('disabled', '');
	}

	return {

		hotelList : function(id, name, feature, roomType, address, phone, postalCode){
			
			var html = '';
			var roomType;
			if(!roomType = markupRoomType(roomType))
				return false;
			if(!id && !name)
				return ;
			else{
				html += "<div id = 'element-" + id + roomType + "' class = 'element well'>";
				html += "<h4 class = 'hotel-name text-info text-center'>" + name + "</h4>";
				html += "<div class = 'hotel-description'>";
				html += "<dl class='dl-horizontal'>";
				html += "<dt>Feature : </dt>";
				html += "<dd>" + markupList(feature) + "</dd>";
				html += "<dt>Roomtypes : </dt>";
				html += "<dd>" + markupList(roomType) + "</dd>";
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
		}
	}
}(jQuery));

app.ajaxHandle = (function($){
	
	var api = {
		ACTION : {
			search : 'search',
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

	function searchSuccessHandle(action, data){
		app.uiHandle.hideFullPageLoading();
		//solve data success callback
	};

	function searchErrorHandle(action, error){
		app.uiHandle.hideFullPageLoading();
		console.log(action + ' is ' + error);
	}

	return {

		ajaxCallSearch : function(){
			app.uiHandle.searchReturnNormalState();

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
			console.log(postParam['feature1']);
			app.Ajax.ajaxCall(action, postParam, searchSuccessHandle, searchErrorHandle);
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

		bookBtnHandle : function(){
			$('.book-btn').on('click', function(e){
				
				var id = $(e.target).attr('data-id');
				
				app.Markup.changeBookingPopup(id);
			})
		},
	};
}(jQuery))

$(document).ready(function(){

	app.ButtonHandle.searchBtnHandle();
//	$('#startDate').datepicker();
//    $('#endDate').datepicker();
/*    var nowTemp = new Date();
	var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
	 
	var checkin = $('#startDate').datepicker({
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
	  $('#endDate')[0].focus();
	}).data('datepicker');
	var checkout = $('#endDate').datepicker({
	  onRender: function(date) {
	    return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
	  }
	}).on('changeDate', function(ev) {
	  checkout.hide();
	}).data('datepicker');*/
	app.ButtonHandle.bookBtnHandle();
})