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
      document.getElementById('cur_match_nr').value = match.number_;
      document.getElementById('cur_event_cd').value = match.event_code;
      document.getElementById('cur_match_type').value = match.match_type;
      document.getElementById('match_nr_lbl').value = match.number_;
      document.getElementById('event_cd_lbl').value = match.event_code;
      document.getElementById('match_type_lbl').value = match.match_type;      
      document.getElementById('red_def2').value = match.red_def2;
      document.getElementById('red_def3').value = match.red_def3;
      document.getElementById('red_def4').value = match.red_def4;
      document.getElementById('red_def5').value = match.red_def5;
      document.getElementById('blue_def2').value = match.blue_def2;
      document.getElementById('blue_def3').value = match.blue_def3;
      document.getElementById('blue_def4').value = match.blue_def4;
      document.getElementById('blue_def5').value = match.blue_def5;
    } catch (e) {
      alert(e.message);
    }
  } else if (xmlHttpObj.readyState == 4 && xmlHttpObj.status != 200) {
    document.getElementById('info').innerHTML = 'Error: No current match!';
  }
}

function cur_next() {
  var current_match = Number(document.getElementById("cur_match_nr").value);
  current_match += 1;
  document.getElementById("cur_match_nr").value = current_match;
}

function cur_prev() {
  var current_match = Number(document.getElementById("cur_match_nr").value);
  current_match -= 1;
  document.getElementById("cur_match_nr").value = current_match;
}