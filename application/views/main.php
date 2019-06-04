<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-center"><?php echo $page_title; ?></h1>
            <a href="<?=base_url()?>foobar">
                <div class="btn btn-action form-control">Hello World</div>
            </a>
        </div>
    </div>

    <hr>

    <!-- Login Block -->
    <?php if (!$user) { ?>
    <div class="row">
        <div id="login_block" class="col-md-6">
            <strong>Login</strong>
            <!-- Validation Errors -->
            <?php if ($failed_form === 'login') { echo $validation_errors; } ?>
            <!-- Form -->
            <?php echo form_open('user/login'); ?>
              <div class="form-group">
                <label for="input_username">Username</label>
                <input type="username" class="form-control" id="login_input_username" name="username" placeholder="Username">
              </div>
              <div class="form-group">
                <label for="input_password">Password</label>
                <input type="password" class="form-control" id="login_input_password" name="password" placeholder="Password">
              </div>
              <button type="submit" class="btn btn-action form-control">Login</button>
            </form>
        </div>

        <!-- Join Block -->
        <div id="register_block" class="col-md-6">
            <strong>Start Playing</strong>
            <!-- Validation Errors -->
            <?php if ($failed_form === 'register') { echo $validation_errors; } ?>
            <!-- Form -->
            <?php echo form_open('user/register'); ?>
              <div class="form-group">
              <input type="hidden" name="ab_test" value="<?php echo $ab_test; ?>"/>
              <input type="hidden" name="bee_movie" value=""/>
                <label for="input_username">Username</label>
                <input type="username" class="form-control" id="register_input_username" name="username" placeholder="Username">
              </div>
              <!-- Only use this line when optional password is enabled -->
              <!-- <p class="text-center">Password only needed to save progress</p> -->
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                        <label for="input_password">
                            Password
                            <small>(Optional)</small>
                        </label>
                        <input type="password" class="form-control" id="register_input_password" name="password" placeholder="Password">
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-group">
                        <label for="input_confirm">
                            Confirm
                        </label>
                        <input type="password" class="form-control" id="register_input_confirm" name="confirm" placeholder="Confirm">
                      </div>
                  </div>
              </div>
              <button type="submit" class="btn btn-action form-control">Start Playing</button>
            </form>
        </div>
    </div>
    <?php } ?>

    <?php if ($user) { ?>
    <a href="<?=base_url()?>user/logout" class="btn btn-danger">Logout</a>
    <?php } ?>

</div>