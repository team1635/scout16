
function buildParams() {
  var params = "match_nr=" + document.getElementById("match_nr").value;
  return params;
}

function runReport() {
  params = buildParams()
  request = new ajaxRequest()
  request.open("POST", "getReport.php", true)
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")

  request.onreadystatechange = function() {
    if (this.readyState == 4) {
      if (this.status == 200) {
        if (this.responseText != null) {
          try {
            eval("var rpt = (" + this.responseText + ")");
            document.getElementById('red1_tab').innerHtml = rpt.red_team1_id;
            document.getElementById('red1_team').innerHtml = "Team " + rpt.red_team1_id;
            document.getElementById('info').innerHTML = rpt.red_team1_id;
          } catch (e) {
            alert(e.message);
          }
        } else
          alert("Ajax error: No data received")
      } else
        alert("Ajax error: " + this.statusText)
    }
  }
  request.send(params)
}

function ajaxRequest() {
  try {
    var request = new XMLHttpRequest()
  } catch (e1) {
    try {
      request = new ActiveXObject("Msxml2.XMLHTTP")
    } catch (e2) {
      try {
        request = new ActiveXObject("Microsoft.XMLHTTP")
      } catch (e3) {
        request = false
      }
    }
  }
  return request
}
