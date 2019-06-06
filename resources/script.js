$(document).ready(function(){
	console.log(
		'%c Hello World! If you would like to contribute to this project, or find any bugs or vulnerabilities, please look for the project in https://github.com/goosehub or contact me at goosepostbox@gmail.com',
		'font-size: 1.2em; font-weight: bold; color: #6666cc;'
	);

	// Init functions
	rating_points_ui();
	join_game_validation();
});

// Init values
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