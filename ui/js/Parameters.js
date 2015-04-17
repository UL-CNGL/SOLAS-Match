var userHash = null;    // Bearer value for Authorization Header

var userLangDoc = null; // Strings for user's language preference
var defaultLangDoc;     // Strings for default language

function Parameters(functionOnSuccess)
{
  var deferredGetUserHash = $.Deferred();
  var deferredGetUserLangDoc = $.Deferred();
  var deferredGetDefaultLangDoc = $.Deferred();

  $.when(deferredGetUserHash, deferredGetUserLangDoc, deferredGetDefaultLangDoc).done(functionOnSuccess);

  this.getUserHash(deferredGetUserHash);
  this.getUserLangDoc(deferredGetUserLangDoc);
  this.getDefaultLangDoc(deferredGetDefaultLangDoc);
}

Parameters.prototype.getTranslation = function(key)
{
  var element;
  var data = "";

  if (userLangDoc != null) {
    element = userLangDoc.querySelector("[name = " + key + "]");
    if (element != null) {
      data = element.innerHTML;
    }
  }

  if (data == "") {
    element = defaultLangDoc.querySelector("[name = " + key + "]");
    if (element != null) {
      data = element.innerHTML;
    } else {
      print("Unable to find string with name " + key);
    }
  }
  return data;
}

Parameters.prototype.getUserHash = function(deferred)
{
  if (userHash == null) {
    $.ajax(
      {
        url: siteLocation + "static/getUserHash/",
        method: "GET",
        dataType: "text",
        xhrFields: {
          withCredentials: true
        }
      }
    )
    .done(
      function(data) {
        if (data != "") {
          userHash = data;
          deferred.resolve();
        }
      }
    );
  } else {
    deferred.resolve();
  }
}

Parameters.prototype.getUserLangDoc = function(deferred)
{
  $.ajax(
    {
      url: siteLocation + "static/getUserStrings/",
      method: "GET",
      dataType: "text"
    }
  )
  .done(
    function(data) {
      if (data != "") {
        var parser = new DOMParser();
        userLangDoc = parser.parseFromString(data, "text/xml");
      }
      deferred.resolve();
    }
  );
}

Parameters.prototype.getDefaultLangDoc = function(deferred)
{
  $.ajax(
    {
      url: siteLocation + "static/getDefaultStrings/",
      method: "GET",
      dataType: "text"
    }
  )
  .done(
    function(data) {
      if (data != "") {
        var parser = new DOMParser();
        defaultLangDoc = parser.parseFromString(data, "text/xml");
        deferred.resolve();
      }
    }
  );
}
