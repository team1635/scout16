var curMatch;

catchEvent(window,"load", function() {
  getCurrentGame();
});

function getCurrentGame() {
   // if xmlHttpObj not set
   if (!xmlHttpObj)
      xmlHttpObj = getXmlHttp();
   if (!xmlHttpObj) return;

   xmlHttpObj.open('GET', "getMatch.php", true);
   xmlHttpObj.onreadystatechange = processCurrentMatch;
   xmlHttpObj.send(null);
}

function processCurrentMatch() {

  if(xmlHttpObj.readyState == 4 && xmlHttpObj.status == 200) {
    try {

      // evaluate JSON
      eval("var match = ("+ xmlHttpObj.responseText+")");
      //document.getElementById('match__id').value = match.id;
      curMatch = match;
      match__id = match.id;
      document.getElementById('number_').value = match.number_;
      document.getElementById('event_name').innerHTML = match.event_name;
      document.getElementById('match_type').innerHTML = match.match_type 
        + ' match';
      document.getElementById('red1_btn').innerHTML = match.red_team1_id;
      document.getElementById('red2_btn').innerHTML = match.red_team2_id;
      document.getElementById('red3_btn').innerHTML = match.red_team3_id;
      document.getElementById('blue1_btn').innerHTML = match.blue_team1_id;
      document.getElementById('blue2_btn').innerHTML = match.blue_team2_id;
      document.getElementById('blue3_btn').innerHTML = match.blue_team3_id;
    } catch (e) {
      alert(e.message);
    }
  } else if (xmlHttpObj.readyState == 4 && xmlHttpObj.status != 200) {
    document.getElementById('info').innerHTML = 'Error: No current match!';
  }
}

function buildParams() {
  var params = "team_id=" + team_id + '&';
  params += "match__id=" + match__id + '&';

  for (var statName in stats) {
    params = params + statName + "=" + stats[statName] + '&';
  }

  params = params.substring(0, params.length);

  return params;
}

function blue1_btn() {
  //TODO: Clean spaces from the button string
  document.getElementById('team_id').value = 
    document.getElementById('blue1_btn').innerHTML;
  setDefenses("Blue");
}

function blue2_btn() {
  document.getElementById('team_id').value = 
    document.getElementById('blue2_btn').innerHTML;
  setDefenses("Blue");
}

function blue3_btn() {
  document.getElementById('team_id').value = 
    document.getElementById('blue3_btn').innerHTML;
  setDefenses("Blue");
}

function red1_btn() {
  //TODO: Clean spaces from the button string
  document.getElementById('team_id').value = 
    document.getElementById('red1_btn').innerHTML;
  setDefenses("Red");
}

function red2_btn() {
  document.getElementById('team_id').value = 
    document.getElementById('red2_btn').innerHTML;
  setDefenses("Red");
}

function red3_btn() {
  document.getElementById('team_id').value = 
    document.getElementById('red3_btn').innerHTML;
  setDefenses("Red");
}

function saveStat() {
  params = buildParams()
  request = new ajaxRequest()
  request.open("POST", "saveStat.php", true)
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")

  request.onreadystatechange = function() {
    if (this.readyState == 4) {
      if (this.status == 200) {
        if (this.responseText != null) {
          document.getElementById('info').innerHTML = this.responseText
        } else
          alert("Ajax error: No data received")
      } else
        alert("Ajax error: " + this.statusText)
    }
  }

  request.send(params)
}

function setDefenses(allianceColor) {
  if (allianceColor == "Red") {
    changeButtonLabel('def2_btn', 'red_def2');
    changeButtonLabel('def3_btn', 'red_def3');
    changeButtonLabel('def4_btn', 'red_def4');
    changeButtonLabel('def5_btn', 'red_def5');
  } else {
    changeButtonLabel('def2_btn', 'blue_def2');
    changeButtonLabel('def3_btn', 'blue_def3');
    changeButtonLabel('def4_btn', 'blue_def4');
    changeButtonLabel('def5_btn', 'blue_def5');
  }
}

function changeButtonLabel(defButton, defPropName) {
  if (curMatch[defPropName] != null) {
    var newLabel = curMatch[defPropName];
    var buttonId = 'cross_' + defButton;
    var btn = document.getElementById(buttonId);
    var existingLabel = btn.innerHTML;
    btn.innerHTML = existingLabel.replace(/Def\s[2-5]/, newLabel);
    
    var openButtonId = 'open_' + defButton;
    var openBtn = document.getElementById(openButtonId);
    var existingOpenLabel = openBtn.innerHTML;
    if ((newLabel == 'A_Portcullis') || (newLabel == 'C_SallyPort')
        || (newLabel == 'C_Drawbridge')) {
      openBtn.disabled = false;
      openBtn.innerHTML = existingLabel.replace(/Def\s[2-5]/, newLabel);
    } else {
      openBtn.disabled = true;
    }
  }
}