<script>
let base_url = '<?php echo base_url(); ?>';
let is_home_team = <?php echo $is_home_team ? 'true' : 'false'; ?>;
let game_id = <?php echo $game['id']; ?>;
let game_started = 0;
let is_run_stuff = 0;
let is_man = 0;
let is_blitz = 0;
let offense_play_key = 0;
let kickoff_defense_sent = false;

$(document).ready(function(){
  // Update game
  get_game_info();
  get_game_info_interval = 3 * 1000;
  setInterval(function(){
    get_game_info();
  }, get_game_info_interval);

  detect_offense_play_select();
});

// Get Last Play
function get_game_info() {
  ajax_get('game/get_game_info/' + game_id, function(data){
    // console.log('get_game_info');
    // console.log(data);
    reset_ui();
    update_scoreboard(data.game);
    if (!data.game.away_team_key) {
      $('#awaiting_opponent_to_join').show();
      return;
    }
    if (!data.last_play) {
      show_select_play(data.game);
    }
    else {
      show_play(data.outcome);
    }
  });
}

function update_scoreboard(game) {
  $('#game_home_score').text(game.home_score);
  $('#game_away_score').text(game.away_score);
  $('#game_home_timeouts').text(game.home_timeouts);
  $('#game_away_timeouts').text(game.away_timeouts);
  $('#game_quarter').text(game.quarter);
  $('#game_time').text(game.time);
  $('#game_down').text(game.down);
  $('#game_ball_on_yard_line').text(game.ball_on_yard_line);
  $('#game_yards_to_first_down').text(game.yards_to_first_down);
  $('#game_is_home_team_ball').text(game.is_home_team_ball);
  $('#game_is_goal_to_go').text(game.is_goal_to_go);
  $('#game_is_kickoff').text(game.is_kickoff);
  $('#game_is_extra_point_attempt').text(game.is_extra_point_attempt);
  $('#game_created').text(game.created);
}

function show_select_play(game) {
  reset_ui();
  // Kickoff
  if (game.is_kickoff) {
    if (is_my_ball(game.is_home_team_ball)) {
      $('#offense_plays_parent').show();
      $('.play_button[kickoff="1"]').show();
    }
    else {
      send_kickoff_defense();
      $('#waiting_for_kicking_team').show();
    }
  }
  else {
    if (is_my_ball(game.is_home_team_ball)) {
      $('#offense_plays_parent').show();
      $('.play_button[kickoff="0"]').show();
    }
    else {
      $('#defense_plays_parent').show();
      $('.defense_play_button').show();
    }
  }
}

function show_play(outcome) {
  $('outcome_parent').show();
  $('outcome_text').show(outcome.announcer_text);
}

function reset_ui() {
  $('.message_element, .play_button, #offense_plays_parent, #defense_plays_parent, .message_element').hide();
}

function detect_offense_play_select() {
  $('.offense_play_button').click(function(){
    let selected_play_id = $(this).attr('play_id');
    send_offense_play_select(selected_play_id);
  });
}

function send_offense_play_select(selected_play_id) {
  ajax_post('game/offense_play_select/' + game_id + '/' + selected_play_id, true, function(data){
    console.log('offense_play_select');
    console.log(data);
  });
}

function send_kickoff_defense() {
  console.log('polo');
  console.log(kickoff_defense_sent);
  if (kickoff_defense_sent) {
    return;
  }
  console.log('bingo');
  ajax_post('game/defense_play_select/' + game_id + '/0/0/0', true, function(data){
    kickoff_defense_sent = true;
    console.log('defense_play_select');
    console.log(data);
  });
}

function is_my_ball(is_home_team_ball) {
  return is_home_team_ball == is_home_team;
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