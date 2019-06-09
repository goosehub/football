<script>
let base_url = '<?php echo base_url(); ?>';
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

// Get Last Play
function get_game_info() {
  ajax_get('game/get_game_info/<?php echo $game['id']; ?>/' + last_play_id, function(data){
    console.log('get_game_info');
    console.log(data);
    if (data.game.away_team_key) {
      $('#awaiting_opponent_to_join').hide();
    }
    if (!data.last_play) {
      // show_select_play();
    }
    else {
      // show_play(last_play);
    }
  });
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