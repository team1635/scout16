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

function buildParams() {
  var params = "event_code=" + document.getElementById("event_code").value;
  params += "&match_type=" + document.getElementById("match_type").value;
  return params;
}

function loadMatches() {
  params = buildParams()
  request = new ajaxRequest()
  request.open("POST", "loadMatches.php", true)
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
//  request.setRequestHeader("Content-length", params.length)
//  request.setRequestHeader("Connection", "close")

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
