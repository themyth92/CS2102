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

app.ButtonHandle = (function($){
	return{
		searchBtnHandle : function(){
			$('#search-btn').click(function(){
				//call ajax and start to do something here
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