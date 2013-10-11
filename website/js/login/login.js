var App = App || {};
App.login = (function($){

	var button = {
		signIn   : 'loginBtn',
		register : 'registerBtn',
	};

	var input = {
		email    : 'username',
		password : 'password',
	};

	var action = {
		login    : 'login',
		register : 'register',
	};

	var callBack = {
		success : '200',
		error : '100',
	}

	var email 	 = null;
	var password = null;

	function start(){
		buttonHandle();
	};

	function buttonHandle(){
		var message;

		$('#' + button.signIn).on('click', function(e){
			console.log('jher');
			e.preventDefault();
			getUserInput();

			$('#preloader').removeClass('inactive');
			message = email + '_' + password;
			
			App.ajax.callAjax(action.login, message, successCallBack, errorCallBack);

			return false;
		});

		$('#' + button.register).on('click', function(e){

			e.preventDefault();
			getUserInput();

			$('#preloader').removeClass('inactive');
			message = email + '_' + password;
			
			App.ajax.callAjax(action.register, message, successCallBack, errorCallBack);

			return false;
		});
	};

	function successCallBack(act, data){

		$('#preloader').addClass('inactive');

		if(typeof data !== undefined){

			if(typeof data.status === undefined)
				return false;
			else{
				if(data.status.code == callBack.success){
					$('#error-msg').addClass('inactive');
					$('#success-msg').removeClass('inactive');

					if(act == action.login){
						window.location.replace("http://themyth92.com/CS2102/website/main.php");
					}
				}
				else
					if(data.status.code == callBack.error){
						$('#success-msg').addClass('inactive');
						$('#error-msg').removeClass('inactive');	
				}
			}
		}
	};

	function errorCallBack(action, error){
		
		$('#preloader').addClass('inactive');
		$('#error-msg').addClass('inactive');
		$('#success-msg').addClass('inactive');

		console.log('action : ' + action + '__________ error : ' + error);
	};

	function getUserInput(){
		email    = $('#' + input.email).val();
		password = $('#' + input.password).val();
	}

	return {
		initialize : function(){
			start();
		}
	}

}(jQuery))

$(document).ready(function(){
	App.login.initialize();
})
