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
}

function blue2_btn() {
  document.getElementById('team_id').value = 
    document.getElementById('blue2_btn').innerHTML;
}

function blue3_btn() {
  document.getElementById('team_id').value = 
    document.getElementById('blue3_btn').innerHTML;
}

function red1_btn() {
  //TODO: Clean spaces from the button string
  document.getElementById('team_id').value = 
    document.getElementById('red1_btn').innerHTML;
}

function red2_btn() {
  document.getElementById('team_id').value = 
    document.getElementById('red2_btn').innerHTML;
}

function red3_btn() {
  document.getElementById('team_id').value = 
    document.getElementById('red3_btn').innerHTML;
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
