var team_id;
var match__id;
 
var stats = {
  auto_robot: 0,
  auto_tote: 0,
  auto_can: 0,
  auto_stack: 0,
  auto_position: 1,

  scored_gray: 0,
  scored_can_level: 0,
  score_stack: 0,
  carry_stack: 0,
  handle_litter: 0,
  fallen_can: 0,
  noodle_in_can: 0,
  clr_rec_area: 0,
  grab_step_can: 0,

  coop: 0,
  coop_stack: 0,

  fouls: 0,
  
};

var log = new Array();

function increase(statName) {
  //TODO: it should be possible to derive the statName from the
  //name of the object that called this function (i.e. the button)
  // statName = (buttonName - "_btn")
  var badgeName = statName + "_badge"
  var buttonName = statName + "_btn"

  var oldStatVal = stats[statName]

  var badge = document.getElementById(badgeName);
  if (!(badge === null)) {
     badge.innerHTML = oldStatVal + 1;
  }

  stats[statName] = oldStatVal + 1;

  if (oldStatVal == 0) {
    var button = document.getElementById(buttonName)
    button.style.color = 'green'
  }

  log.push(statName);
 }

function undo() {
  if (log.length !== 0) {
    var last_action = log.pop();
    decrease(last_action);
  }
}

function decrease(statName) {
  //TODO: it should be possible to derive the statName from the
  // name of the object that called this function (i.e. the button)
  // statName = (buttonName - "_btn")
  var badgeName = statName + "_badge"
  var buttonName = statName + "_btn"

  var oldStatVal = stats[statName]
  var newStatVal = oldStatVal - 1;

  var badge = document.getElementById(badgeName);
  if (!(badge === null)) {
    badge.innerHTML = newStatVal;
  }

  stats[statName] = newStatVal;

  if (newStatVal == 0) {
    var button = document.getElementById(buttonName)
    button.style.color = 'black'
  }
}

function resetField(statName) {
//TODO: it should be possible to derive the statName from the
// name of the object that called this function (i.e. the button)
// statName = (buttonName - "_btn")
  var badgeName = statName + "_badge"
  var buttonName = statName + "_btn"

  stats[statName] = 0

  var badge = document.getElementById(badgeName)
  if (!(badge === null)) {
    badge.innerHTML = 0;
  }

  var button = document.getElementById(buttonName)
  if (!(button === null)) {
    button.style.color = 'black'
  }
}

function saveAndReset() {
  team_id = document.getElementById("team_id").value;
  saveStat();
  
  //clear
  for (var statName in stats) {
    if (typeof (stats[statName]) !== "undefined") {
      resetField(statName);
    }
  }
  match__id = 0;
  team_id = 0;
  stats['auto_position'] = 1;
  document.getElementById("team_id").value = '';
  document.getElementById("auto_position_badge").innerHTML = 1;

  getCurrentGame();
 
}

