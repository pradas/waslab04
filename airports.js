var baseURI = "http://localhost:8080/waslab04";

function showAirports () {
   var country = document.getElementById("countryName").value;

   	var uri = baseURI + "/airport_names.php";
   	req = new XMLHttpRequest();
	req.open('GET', uri + "?country=" + country, /*async*/true);
	req.onreadystatechange = function() {
		if (req.readyState == 4 && req.status == 200) {
	    var airports = JSON.parse(this.responseText);
	    var leftInnerHTML = '<ul>';
	    for (var i = 0; i < airports.length; ++i) {
	        leftInnerHTML += '<a href="#" onclick="showAirportInfo(\'' + airports[i]["code"] + '\')">' + 
	          airports[i]["name"] + ' (' + airports[i]["code"] + ')</a></br><br>';  
	    }
	    leftInnerHTML += "</ul";
	    document.getElementById("left").innerHTML = leftInnerHTML;
		}
	};
	req.send(/*no params*/null);
};


function showAirportInfo (code) {

   var uri = baseURI + "/airport_info.php";
   req = new XMLHttpRequest();
   req.open("GET", uri + "?code=" + code, true);
   req.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
	    var info = JSON.parse(this.responseText);
	    var infoInnerHTML = '<h2> Airport of ' + info["CityOrAirportName"] + ' (' + info["AirportCode"] + ')</h2>';
	    infoInnerHTML += '<ul>';
	    infoInnerHTML += '<li>Runway Length: ' + info["RunwayLengthFeet"] + ' feet</li>';
	    infoInnerHTML += '<li>Runway Elevation: ' + info["RunwayElevationFeet"] + ' feet</li>';
	    infoInnerHTML += '<li>Coordenates: ' + info["LatitudeDegree"] + 'o' + info["LatitudeMinute"] + "'" + 
	      info["LatitudeSecond"] + '" ' + info["LatitudeNpeerS"] + ', ' + info["LongitudeDegree"] + 'o' + 
	      info["LongitudeMinute"] + "'" + info["LongitudeSeconds"] + '" ' + info["LongitudeEperW"] + ' </li>';
	    infoInnerHTML += '</ul>';
	    document.getElementById("right").innerHTML = infoInnerHTML;
      }
   }
   req.send(/*no params*/null);   
}

window.onload = showAirports();
