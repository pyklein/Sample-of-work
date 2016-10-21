// globale variable for road //
var testj = 0;
var testi = 0;
var indiceIDistanceMax = 0;
var indiceJDistanceMax = 0;
var durationMax = 0;
var directionService = new google.maps.DirectionsService();
var polylineArray = new Array('Google','DistanceGoogle', 'Closest', 'Furthest', 'Custom', 'DisplayGoogle', 'ListChangeGoogle', 'ListChangeClosest', 'ListChangeFurthest', 'ListChangeCustom');
polylineArray['ListChangeGoogle'] = false;
polylineArray['ListChangeClosest'] = false;
polylineArray['ListChangeFurthest'] = false;
polylineArray['ListChangeCustom'] = false;
//--------------------------------------------//

function goOptimise() {
    
    var algoSelect = document.getElementById("slctOptimize").options[document.getElementById("slctOptimize").selectedIndex].value;
    if (algoSelect == "closest") {
        if (polylineArray['ListChangeClosest']) {
            calculRoadClosest();
            polylineArray['ListChangeClosest'] = false;
        }
        else {//Closest
            polylineArray['Closest'].setMap(map);
        }
    }
    if (algoSelect == "furthest") {
        if (polylineArray['ListChangeFurthest']) {
            calculRoadFurthest();
            polylineArray['ListChangeFurthest'] = false;
        }
        else {//Closest
            polylineArray['Furthest'].setMap(map);
        }
    }
    if (algoSelect == "google") {
        if (polylineArray['ListChangeGoogle']) {
            var i = selectedCriticalInFirst();
            if (erpMarkerAddCollection.length()-i > 8 || i > 8) {
                document.getElementById("logAlert").style.borderColor = "blue";
                document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logInfoMessage.jpg\" alt=\"info\" width=\"30%\"/></td><td VALIGN='middle' style='color:blue;'><b color:blue>&nbsp; to use this sort you must have a maximum of eight activities (currently " + (erpMarkerAddCollection.length()+2) + ") </b></td></tr>";
                $("#logAlert").stop(true, true).delay(5).slideDown(250);
                closelogalert();
            }
            else {
                var count = 0;
                var dist = "";
                var GoogleTemp = new Array('Distance', 'Polyline');
                var tmp=arrayStartStop['Arrival'];
                var indexArrival;
                var test = 0;
                if (count < i) {
                    while (count < i) {
                        var destination = erpMarkerAddCollection.arrayErpMarker[count].getCoordinateObject();
                        request = {
                            origin: arrayStartStop['Departure'].getPosition(),
                            destination: destination,
                            travelMode: google.maps.DirectionsTravelMode.DRIVING
                        };
                        directionService.route(request, function(result, status) {
                            
                            if (status == google.maps.DirectionsStatus.OK) {
                                if (dist == "" || dist < result.routes[0].legs[0].distance.value) {
                                    arrayStartStop['Arrival'] = erpMarkerAddCollection.arrayErpMarker[test].gMarker;
                                    //Be able to choose between Duration & Distance!!!
                                    //dist = result.routes[0].legs[0].duration.value;
                                    dist = result.routes[0].legs[0].distance.value;
                                    indexArrival = test;
                                }
                            }
                            if (test == i-1)
                                ContinueGoogleAlgo(indexArrival, i, tmp);
                            test++;
                        });
                        count++;
                    }
                }
                else {
                    //alert(arrayStartStop['Departure'].getPosition().lat());
                    //alert(arrayStartStop['Arrival'].getPosition().lat());
                    
                    googlGo(erpMarkerAddCollection, null, 3, '', arrayStartStop['Arrival'], arrayStartStop['Departure'])

                }
                       
            }            
        }
        else{
            polylineArray['Google'].setMap(map);
        }
    }
}




function optimiseRoad() {
    directionsDisplay = new google.maps.DirectionsRenderer();
    var i = 0;
    var request;
    var origin;
    var destination;

    var distance = new Array();
    while (i < erpMarkerAddCollection.length()) {
        distance[i] = new Array();
        i++;
    }
    i = 0;
    while (erpMarkerAddCollection.arrayErpMarker[i]) {
        var j = 0;
        origin = erpMarkerAddCollection.arrayErpMarker[i].getCoordinateObject();

        while (j < i) {

            destination = erpMarkerAddCollection.arrayErpMarker[j].getCoordinateObject();
            request = {
                origin: origin,
                destination: destination,
                travelMode: google.maps.DirectionsTravelMode.DRIVING
            };
            directionsService.route(request, function(result, status) {
                if (status == google.maps.DirectionsStatus.OK) {
                    if (testj >= testi - 1) {
                        testi++;
                        testj = 0;
                    }
                    else {
                        testj++;
                    }
                    distance[testi][testj] = result.routes[0].legs[0].duration.value;
                    if (distance[testi][testj] > durationMax) {
                        durationMax = distance[testi][testj];
                        indiceIDistanceMax = testi;
                        indiceJDistanceMax = testj;
                    }

                }
            });
            j++;
        }
        i++;
    }
    setTimeout("var j= 2", 1000);
    execAfterAsynchronousService(distance);
}

function execAfterAsynchronousService(distance, indiceIDistanceMax, indiceJDistanceMax) {

    var check = setInterval(function() {
        if (distance[erpMarkerAddCollection.length() - 1][erpMarkerAddCollection.length() - 2]) {
            clearInterval(check);
            calculRoadFurthest(distance);
            //calculRoadClosest(distance);
        }
    }
            , 10);
}
