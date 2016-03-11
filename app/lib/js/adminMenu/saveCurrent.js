function buildCurParams() {
  var params = "cur_event_cd=" + document.getElementById("cur_event_cd").value;
  params += "&cur_match_type=" + document.getElementById("cur_match_type").value;
  params += "&cur_match_nr=" + document.getElementById("cur_match_nr").value;
  params += "&def2=" + document.getElementById("def2").value;
  params += "&def3=" + document.getElementById("def3").value;
  params += "&def4=" + document.getElementById("def4").value;
  params += "&def5=" + document.getElementById("def5").value;
  return params;
}

function saveCurrent() {
  params = buildCurParams()
  request = new ajaxRequest()
  request.open("POST", "saveCurrent.php", true)
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")

  request.onreadystatechange = function() {
    if (this.readyState == 4) {
      if (this.status == 200) {
        if (this.responseText != null) {
          document.getElementById('info').innerHTML = this.responseText
        } else
          alert("saveCurrent(): error: No data received")
      } else
        alert("saveCurrent(): error: " + this.statusText)
    }
  }

  request.send(params)
}
