<script>
let base_url = '<?php echo base_url(); ?>';
last_play_id = 0;
game_started = 0;

// Update auction info
get_game_info_interval = 3 * 1000;
setInterval(function(){
  get_game_info();
}, get_game_info_interval);

// Get Last Play
function get_game_info() {
  ajax_get('game/get_game_info/<?php echo $game['id']; ?>/' + last_play_id, function(data){
    console.log('marco');
    console.log(data);
    if (data.game.away_team_key) {
      $('#awaiting_opponent_to_join').hide();
    }
    if (!last_play) {
      // show_select_play();
    }
    else {
      // show_play(last_play);
    }
  });
}

</script>