// window.location.replace("https://getshifter.io");

var redirectJSON = '../../../wp-content/uploads/wp-sls-redirects/redirects.json';
var xhr = new XMLHttpRequest();
xhr.open('GET', redirectJSON, true);

var iterateRedirects = function(data) {
  for (var key in data) {
    if (data.hasOwnProperty(key)) {

      var redirect = data[key];
      
      if ( redirect.url == window.location.pathname ) {
        window.location.replace(redirect.action_data.url);
      }

    }
  }
};

xhr.onload = function() {
    if (xhr.status === 200) {
      var rArray = JSON.parse(this.responseText);
      iterateRedirects(rArray.redirects);
    }
    else {
      console.log('Request failed.  Returned status of ' + xhr.status);
    }
};

xhr.send();