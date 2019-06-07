<div class="container">
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <h1 class="text-center"><?php echo $page_title; ?></h1>
      <?php if (!$away_team) { ?>
        Awaiting Opponent
      <?php } ?>
      <p>
        <?php var_dump($home_team); ?>
        <?php var_dump($away_team); ?>
        <?php var_dump($is_home_team); ?>
      </p>
    </div>
  </div>
</div>