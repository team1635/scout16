var xmlHttpObj;

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

function getXmlHttp() {
  var xmlhttp = null;
  if (window.XMLHttpRequest) {
     xmlhttp = new XMLHttpRequest();
  } else {
    try {
      xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
      } catch (e) {
        return null;
      }
    }
  }
  return xmlhttp;
}

function catchEvent(eventObj, event, eventHandler) {
  if (eventObj.addEventListener) {
    eventObj.addEventListener(event, eventHandler,false);
  } else if (eventObj.attachEvent) {
    event = "on" + event;
    eventObj.attachEvent(event, eventHandler);
  }
}