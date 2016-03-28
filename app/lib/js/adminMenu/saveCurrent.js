function buildCurParams() {
  var params = "cur_event_cd=" + document.getElementById("cur_event_cd").value;
  params += "&cur_match_type=" + document.getElementById("cur_match_type").value;
  params += "&cur_match_nr=" + document.getElementById("cur_match_nr").value;
  params += "&red_def2=" + document.getElementById("red_def2").value;
  params += "&red_def3=" + document.getElementById("red_def3").value;
  params += "&red_def4=" + document.getElementById("red_def4").value;
  params += "&red_def5=" + document.getElementById("red_def5").value;
  params += "&blue_def2=" + document.getElementById("blue_def2").value;
  params += "&blue_def3=" + document.getElementById("blue_def3").value;
  params += "&blue_def4=" + document.getElementById("blue_def4").value;
  params += "&blue_def5=" + document.getElementById("blue_def5").value;
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

function buildDefParams() {
  var params = "cur_event_cd=" + document.getElementById("cur_event_cd").value;
  params += "&cur_match_type=" + document.getElementById("cur_match_type").value;
  params += "&cur_match_nr=" + document.getElementById("cur_match_nr").value;
  params += "&red_def2=" + document.getElementById("red_def2").value;
  params += "&red_def3=" + document.getElementById("red_def3").value;
  params += "&red_def4=" + document.getElementById("red_def4").value;
  params += "&red_def5=" + document.getElementById("red_def5").value;
  params += "&blue_def2=" + document.getElementById("blue_def2").value;
  params += "&blue_def3=" + document.getElementById("blue_def3").value;
  params += "&blue_def4=" + document.getElementById("blue_def4").value;
  params += "&blue_def5=" + document.getElementById("blue_def5").value;
  return params;
}

function updateDefenses() {
  params = buildDefParams()
  request = new ajaxRequest()
  request.open("POST", "saveCurrentDefenses.php", true)
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
