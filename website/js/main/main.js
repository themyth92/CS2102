var app = app || {};

app.Markup  = (function($){
	function markupList(list){
		var html ='';
		if(!list){
			html += 'None';
		}
		else
			if(feature instanceof Array){
				for(var i = 0 ; i < list.length ; i++){
					if( i == list.length - 1){
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

	return {

		hotelList : function(id, name, feature, roomType, address, phone, postalCode){
			
			var html = '';
			
			if(!id && !name)
				return ;
			else{
				html += "<div id = 'element-" + id + "' class = 'element well'>";
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
		}
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
			$('.book-btn').click(function(e){
				var id = e.target.attr('data-id');
				if(!id)
					return false;
				else{
					var name = $('#element-' + id + ' h4').html();

				}
			})
		},
	};
}(jQuery))

$(document).ready(function(){
	$('#book-popup').on('show', function(){
		$(this).attr('data-id', '4');
	});
//	$('#startDate').datepicker();
//    $('#endDate').datepicker();
    var nowTemp = new Date();
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
	}).data('datepicker');
})