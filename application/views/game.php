<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">

      <h1 class="text-center"><?php echo $page_title; ?></h1>

      <!-- Messages -->
      <div class="messages_parent">
        <span class="message_element" id="awaiting_opponent_to_join">
          <p class="lead text-center">
            Awaiting Opponent To Join
          </p>
        </span>
        <span class="message_element" id="waiting_for_kicking_team">
          <p class="lead text-center">
            Waiting For Kicking Team
          </p>
        </span>
      </div>


      <!-- Offense Plays -->
      <div id="offense_plays_parent" class="row">
        <h2 class="text-center">Select Play</h2>
        <?php foreach ($offense_plays as $play) {?>
          <div class="play_button_parent col-md-4">
            <div class="play_button offense_play_button btn btn-default form-control" id="<?php echo $play['name']; ?>_button" play_id="<?php echo $play['id']; ?>" kickoff="<?php echo $play['is_kickoff']; ?>">
              <?php echo $play['name']; ?>
            </div>
            <br><br>
          </div>
        <?php } ?>
      </div>

      <!-- Defense Plays -->
      <div id="defense_plays_parent" class="row text-center">
        <div class="col-md-5">
          <div id="stuff_defense_button" class="play_button defense_play_button btn btn-default form-control">Stuff the Run</div> 
        </div>
        <div class="col-md-2">
          or 
        </div>
        <div class="col-md-5">
          <div id="pass_defense_button" class="play_button defense_play_button btn btn-default form-control">Play The Pass</div>
          <br><br>
        </div>
        <div class="col-md-5">
          <div id="man_defense_button" class="play_button defense_play_button btn btn-default form-control">Man</div> 
        </div>
        <div class="col-md-2">
          or 
        </div>
        <div class="col-md-5">
          <div id="zone_defense_button" class="play_button defense_play_button btn btn-default form-control">Zone</div>
          <br><br>
        </div>
        <div class="col-md-5">
          <div id="blitz_defense_button" class="play_button defense_play_button btn btn-default form-control">Blitz</div> 
        </div>
        <div class="col-md-2">
          or 
        </div>
        <div class="col-md-5">
          <div id="four_defense_button" class="btn btn-default form-control">Send Four</div>
          <br><br>
        </div>
      </div>

      <!-- Debug -->
      <p>
        <hr>
        <hr>
        <hr>
        <?php // var_dump($offense_plays); ?>
        <?php var_dump($game); ?>
        <?php var_dump($last_play); ?>
        <?php var_dump($home_team); ?>
        <?php var_dump($away_team); ?>
        <?php // var_dump($is_home_team); ?>
      </p>
    </div>
  </div>
</div>