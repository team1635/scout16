var team_id;
var match__id;
 
var stats = {
  auto_position: 1,
  auto_reach: 0,
  auto_cross: 0,
  auto_low: 0,
  auto_high: 0,

  cross_low_bar: 0,
  cross_def2: 0,
  cross_def3: 0,
  cross_def4: 0,
  cross_def5: 0,
  open_def2: 0,
  open_def3: 0,
  open_def4: 0,
  open_def5: 0,
  pick_ball: 0,
  pass_ball: 0,
  
  score_low: 0,
  score_high: 0,
  reach_twr: 0,
  climb_twr: 0,

  defense: 0,
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

