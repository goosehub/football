<script>
let base_url = '<?php echo base_url(); ?>';
let is_home_team = <?php echo $is_home_team ? 'true' : 'false'; ?>;
let game_id = <?php echo $game['id']; ?>;
let last_play_id = 0;
let game_started = 0;
let is_run_stuff = 0;
let is_man = 0;
let is_blitz = 0;
let offense_play_key = 0;

// Update auction info
get_game_info_interval = 3 * 1000;
setInterval(function(){
  get_game_info();
}, get_game_info_interval);

detect_offense_play_select();

// Get Last Play
function get_game_info() {
  ajax_get('game/get_game_info/' + game_id + '/' + last_play_id, function(data){
    // console.log('get_game_info');
    // console.log(data);
    if (data.game.away_team_key) {
      $('#awaiting_opponent_to_join').hide();
    }
    if (!data.last_play) {
      show_select_play(data.game);
    }
    else {
      // show_play(data.last_play);
    }
  });
}

function show_select_play(game) {
  $('.message_element, .play_button, #offense_plays_parent, #defense_plays_parent, .message_element').hide();
  // Kickoff
  if (game.is_kickoff) {
    if (is_my_ball(game.is_hometeam_ball)) {
      $('#offense_plays_parent').show();
      $('.play_button[kickoff="1"]').show();
    }
    else {
      $('#waiting_for_kicking_team').show();
    }
  }
  else {
    if (is_my_ball(game.is_hometeam_ball)) {
      $('#offense_plays_parent').show();
      $('.play_button[kickoff="0"]').show();
    }
    else {
      $('#defense_plays_parent').show();
      $('.defense_play_button').show();
    }
  }
}

function detect_offense_play_select() {
  $('.offense_play_button').click(function(){
    let selected_play_id = $(this).attr('play_id');
    ajax_post('game/offense_play_select/' + game_id + '/' + selected_play_id, function(data){
      console.log('marco');
      console.log(data);
    });
  });
}

function is_my_ball(is_hometeam_ball) {
  return is_hometeam_ball == is_home_team;
}

$('.play_button').click(function(){
  $('.play_button').removeClass('btn-action').addClass('btn-default');
  $(this).removeClass('btn-default').addClass('btn-action');
  offense_play_key = $(this).attr('play_id');
});

$('#stuff_defense_button').click(function(){
  is_run_stuff = true;
  $('#pass_defense_button').removeClass('btn-action').addClass('btn-default');
  $(this).removeClass('btn-default').addClass('btn-action');
});
$('#pass_defense_button').click(function(){
  is_run_stuff = false;
  $('#stuff_defense_button').removeClass('btn-action').addClass('btn-default');
  $(this).removeClass('btn-default').addClass('btn-action');
});
$('#man_defense_button').click(function(){
  is_man = true;
  $('#zone_defense_button').removeClass('btn-action').addClass('btn-default');
  $(this).removeClass('btn-default').addClass('btn-action');
});
$('#zone_defense_button').click(function(){
  is_man = false;
  $('#man_defense_button').removeClass('btn-action').addClass('btn-default');
  $(this).removeClass('btn-default').addClass('btn-action');
});
$('#blitz_defense_button').click(function(){
  is_blitz = true;
  $('#four_defense_button').removeClass('btn-action').addClass('btn-default');
  $(this).removeClass('btn-default').addClass('btn-action');
});
$('#four_defense_button').click(function(){
  is_blitz = false;
  $('#blitz_defense_button').removeClass('btn-action').addClass('btn-default');
  $(this).removeClass('btn-default').addClass('btn-action');
});

</script>