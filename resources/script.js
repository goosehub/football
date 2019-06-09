// 
// Utilties functions
// 

// Abstract simple ajax calls
function ajax_post(url, data, callback) {
	$.ajax({
		url: base_url + url,
		type: 'POST',
		data: JSON.stringify(data),
		dataType: 'json',
		success: function(data) {
			// Handle errors
			// console.log(url);
			// console.log(data);
			if (data['error']) {
				alert(data['error_message']);
				return false;
			}

			// Do callback if provided
			if (callback && typeof(callback) === 'function') {
				callback(data);
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.error(xhr.status);
			console.error(thrownError);
		}
	});
}

// Abstract simple ajax calls
function ajax_get(url, callback) {
	$.ajax({
		url: base_url + url,
		type: 'GET',
		dataType: 'json',
		success: function(data) {
			// Handle errors
			// console.log(url);
			// console.log(data);
			if (data['error']) {
				alert(data['error_message']);
				return false;
			}

			// Do callback if provided
			if (callback && typeof(callback) === 'function') {
				callback(data);
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.error(xhr.status);
			console.error(thrownError);
		}
	});
}

// 
// Rating UI
// 

let rating_points_allowed = 50;
let rating_points_left = 0;

function rating_points_ui() {
	$('.rating_input').change(function(){
		let sum_rating_points = 0
		$('.rating_input').each(function(){
			sum_rating_points += +$(this).val();
		});
		rating_points_left = rating_points_allowed - sum_rating_points; 
		$('#rating_points_left').text(rating_points_left);
		$('#rating_points_left').removeClass('text-success').removeClass('text-danger');
		$('#rating_points_left').addClass(rating_points_left >= 0 ? 'text-success' : 'text-danger');
	});
}

function join_game_validation() {
	if (rating_points_left < 0) {
		alert('You are using too many rating points');
		return false;
	}
	$('join_game_button').click(function(event){
	});
}

// 
// Easter Egg
// 

$(document).ready(function(){
	console.log(
		'%c Hello World! If you would like to contribute to this project, or find any bugs or vulnerabilities, please look for the project in https://github.com/goosehub or contact me at goosepostbox@gmail.com',
		'font-size: 1.2em; font-weight: bold; color: #6666cc;'
	);

	// Init functions
	rating_points_ui();
	join_game_validation();
});