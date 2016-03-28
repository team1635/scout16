function buildScheduleParams() {
  var params = "event_code=" + document.getElementById("event_code").value;
  params += "&match_type=" + document.getElementById("match_type").value;
  return params;
}

function loadSchedule() {
  params = buildScheduleParams()
  request = new ajaxRequest()
  request.open("POST", "loadMatches.php", true)
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
