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

    <h2>Create Team</h2>

    <form action="create_team" method="post">
      <label>Team Name</label>
      <input class="input" id="teamNameInputId" type="text" name="team_name"/>

      <div class="row">
        <div class="col-md-6">
          <label>OLine</label>
          <input class="input" id="olineInputId" type="range" value="0" min="0" max="10" name="oline" oninput="olineOutputId.value = olineInputId.value"/>
          <output name="olineOutputName" id="olineOutputId">0</output>
          <br>
          <label>QB</label>
          <input class="input" id="qbInputId" type="range" value="0" min="0" max="10" name="qb" oninput="qbOutputId.value = qbInputId.value"/>
          <output name="qbOutputName" id="qbOutputId">0</output>
          <br>
          <label>RB</label>
          <input class="input" id="rbInputId" type="range" value="0" min="0" max="10" name="rb" oninput="rbOutputId.value = rbInputId.value"/>
          <output name="rbOutputName" id="rbOutputId">0</output>
          <br>
          <label>WRs</label>
          <input class="input" id="wrInputId" type="range" value="0" min="0" max="10" name="wr" oninput="wrOutputId.value = wrInputId.value"/>
          <output name="wrOutputName" id="wrOutputId">0</output>
          <br>
          <label>TE</label>
          <input class="input" id="teInputId" type="range" value="0" min="0" max="10" name="te" oninput="teOutputId.value = teInputId.value"/>
          <output name="teOutputName" id="teOutputId">0</output>
          <br>
        </div>
        <div class="col-md-6">
          <label>DLine</label>
          <input class="input" id="dlineInputId" type="range" value="0" min="0" max="10" name="dline" oninput="dlineOutputId.value = dlineInputId.value"/>
          <output name="dlineOutputName" id="dlineOutputId">0</output>
          <br>
          <label>LBs</label>
          <input class="input" id="lbInputId" type="range" value="0" min="0" max="10" name="lb" oninput="lbOutputId.value = lbInputId.value"/>
          <output name="lbOutputName" id="lbOutputId">0</output>
          <br>
          <label>DBs</label>
          <input class="input" id="dbInputId" type="range" value="0" min="0" max="10" name="db" oninput="dbOutputId.value = dbInputId.value"/>
          <output name="dbOutputName" id="dbOutputId">0</output>
          <br>
          <label>Kicker</label>
          <input class="input" id="kickerInputId" type="range" value="0" min="0" max="10" name="kicker" oninput="kickerOutputId.value = kickerInputId.value"/>
          <output name="kickerOutputName" id="kickerOutputId">0</output>
          <br>
          <label>SpecialTeams</label>
          <input class="input" id="specialInputId" type="range" value="0" min="0" max="10" name="special" oninput="specialOutputId.value = specialInputId.value"/>
          <output name="specialOutputName" id="specialOutputId">0</output>
          <br>
        </div>
      </div>
      <button>Join Game</button>
    </form>
</div>