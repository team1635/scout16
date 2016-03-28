<html>
  <head>
    <title>Scout 16: Admin menu</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link rel="stylesheet" href="lib/css/bootstrap.min.css" />
    <link rel="stylesheet" href="lib/css/main.css" /> 
  </head>
  <?php
    $def_opt_str = 
      "<option>A_Portcullis</option>\n"
      . "<option>A_ChevalDeFrise</option>\n"
      . "<option>B_Ramparts</option>\n"
      . "<option>B_Moat</option>\n"
      . "<option>C_SallyPort</option>\n"
      . "<option>C_Drawbridge</option>\n"
      . "<option>D_RockWall</option>\n"
      . "<option>D_RoughTerrain</option>\n";
      
    $event_code_opt = 
      "<option>NYLI</option>\n"
	  . "<option>NYNY</option>\n"
      . "<option>NYTR</option>\n"
      . "<option>WAAMV</option>\n"
      . "<option>SCMB</option>\n";
  ?>

  <body>
    <div id="container">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs" id="adminTab">
        <li class="active">
          <a href="#setcurrent" data-toggle="tab">Set Current</a>
        </li>
        <li>
          <a href="#setdefenses" data-toggle="tab">Set Defenses</a>
        </li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div class="tab-pane active" id="setcurrent">
          <div id="side">
            <!--input id="cur_event_cd" type="text" class="form-control" placeholder="Event code"-->
            <div class="form-group">
              <label for="cur_event_cd">Event Code</label>
              <select id="cur_event_cd" class="form-control">
                <?php echo $event_code_opt; ?>
              </select>
            </div> <!--event code form group-->
            
          </div> <!--left column setcurrent tab-pane -->
          <div id="center">
            <!--input id="cur_match_type" type="text" class="form-control" placeholder="Match type">
            <p>
              Types of matches: qualifications, practice
            </p-->
            <!--TODO: fix the fact that this lookup has qualificat and others have qualifications-->
            <div class="form-group">
              <label for="cur_match_type">Match Type</label>
              <select id="cur_match_type" class="form-control"> <!--placeholder doesn't work for select-->
                <option>qualificat</option>
                <option>practice</option>
              </select>
          </div> <!--match type form group-->

          </div> <!--center column setcurrent tab-pane -->
          <div id="side">
            <div class="input-group">
              <button type="button" id="cur_prev" class="btn btn-default btn-lg btn-block" onclick="cur_prev()">
                Previous
              </button>
              
              <!--TODO: the min and the max should be set from an event object-->
              <!--input id="cur_match_nr" type="number" class="form-control" min="1" max="65" placeholder="Match #"-->
              <input id="cur_match_nr" type="number" class="form-control" placeholder="Match #">
              
              <button type="button" id="cur_next" class="btn btn-default btn-lg btn-block" onclick="cur_next()">
                Next
              </button>
            </div> <!-- end current match number input-group -->

            <button type="button" id="cur_save" class="btn btn-danger btn-lg btn-block" onclick="saveCurrent()">
              Save
            </button>
          </div> <!--right column setcurrent tab-pane -->
        </div> <!--setcurrent tab-pane -->
        <div class="tab-pane" id="setdefenses">
          <div id="side">
            <div class="panel panel-danger">
              <div class="panel-heading">Red</div>
              <div class="panel-body">
                <div class="form-group">
                  <label for="red_def5">Defense 5</label>
                  <select class="form-control" id="red_def5">
                    <?php echo $def_opt_str; ?>
                  </select>
                </div> <!--red_def5 form-group-->
                <div class="form-group">
                  <label for="red_def4">Defense 4</label>
                  <select class="form-control" id="red_def4">
                    <?php echo $def_opt_str; ?>
                  </select>
                </div> <!--red_def4 form-group-->
                <div class="form-group">
                  <label for="red_def3">Defense 3</label>
                  <select class="form-control" id="red_def3">
                    <?php echo $def_opt_str; ?>
                  </select>
                </div> <!--red_def3 form-group-->
                <div class="form-group">
                  <label for="red_def2">Defense 2</label>
                  <select class="form-control" id="red_def2">
                    <?php echo $def_opt_str; ?>
                  </select>
                </div> <!--red_def2 form-group-->
                <label>Low Bar</label>
              </div> <!-- end red panel body-->
            </div> <!-- end red panel -->
          </div> <!--left column setdefenses tab-pane -->
          <div id="center">
              <input id="match_nr_lbl" type="number" class="form-control" 
                placeholder="Match #" disabled="true">
              <input id="event_cd_lbl" class="form-control" 
                placeholder="Event Code" disabled="true">
              <input id="match_type_lbl" class="form-control" 
                placeholder="Match Type" disabled="true">
              <button type="button" id="cur_save" class="btn btn-danger btn-lg btn-block" 
                onclick="updateDefenses()">
              Update Defenses
            </button>

          </div> <!--center column setdefenses tab-pane -->
          <div id="side">
            <div class="panel panel-info">
              <div class="panel-heading">Blue</div>
              <div class="panel-body">
                <label>Low Bar</label>
                <div class="form-group">
                  <label for="blue_def2">Blue Def 2</label>
                  <select class="form-control" id="blue_def2">
                    <?php echo $def_opt_str; ?>
                  </select>
                </div> <!--blue_def2 form-group-->
                <div class="form-group">
                  <label for="blue_def3">Blue Def 3</label>
                  <select class="form-control" id="blue_def3">
                    <?php echo $def_opt_str; ?>
                  </select>
                </div> <!--blue_def3 form-group-->
                <div class="form-group">
                  <label for="blue_def4">Blue Def 4</label>
                  <select class="form-control" id="blue_def4">
                    <?php echo $def_opt_str; ?>
                  </select>
                </div> <!--blue_def4 form-group-->
                <div class="form-group">
                  <label for="blue_def5">Blue Def 5</label>
                  <select class="form-control" id="blue_def5">
                    <?php echo $def_opt_str; ?>
                  </select>
                </div> <!--blue def5 form-group-->
              </div> <!-- end blue panel body-->
            </div> <!-- end blue (panel-info) panel -->
          </div> <!--left column setdefenses tab-pane -->
        </div> <!--setdefenses tab-pane-->  
      <div> <!--tab-content-->
      <div id="info" class="panel panel-default"></div>
      </div> <!--info panel at bottom-->
    </div> <!--container-->

    <script src="lib/js/jquery-1.10.1.js"></script>
    <script src="lib/js/bootstrap.min.js"></script>
    <script src="lib/js/scout.js"></script>
    <script src="lib/js/adminMenu/adminMenu.js"></script>
    <script src="lib/js/adminMenu/saveCurrent.js"></script>
  </body>
</html>
