﻿function ContinueGoogleAlgo(indexArrival,i,tmp) {
    var count = 0;
    var erpMarkerCollectionWayPoint = new ErpMarkerCollection();
    while (count < i) {
            erpMarkerCollectionWayPoint.add(erpMarkerAddCollection.arrayErpMarker[count]);
        count++;
    }
    googlGo(erpMarkerCollectionWayPoint, 0,1,'',tmp,'');
    //----------------  
}



function googlGo(erpMarkerCollectionForRoad, indexStart, nthGoThrough, GoogleTemp, arrivalTemp, departureTemp) {
    var waypoints = [];
        

        var GooglTemp = new Array('Polyline', 'Distance');
        GooglTemp['Polyline'] = GoogleTemp['Polyline'];
        GooglTemp['Distance'] = GoogleTemp['Distance'];
        var origin = arrayStartStop['Departure'].getPosition();
        var destination = arrayStartStop['Arrival'].getPosition();
        var length = erpMarkerCollectionForRoad.length();
        var i = 0;
        while (length - i) {
            if(destination!=erpMarkerCollectionForRoad.arrayErpMarker[i].getCoordinateObject())
                waypoints.push({ location: erpMarkerCollectionForRoad.arrayErpMarker[i].getCoordinateObject(), stopover: true });
            i++;
        }
        var request = {
            destination: destination,
            origin: origin,
            waypoints: waypoints,
            optimizeWaypoints: true,
            travelMode: google.maps.DirectionsTravelMode.DRIVING
        };
        directionService.route(request, function(response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            
                if (polylineArray['Google'])
                    polylineArray['Google'].setMap(null);
                var googlePolyline = new google.maps.Polyline({
                    path: response.routes[0].overview_path,
                    strokeColor: "red",
                    strokeOpacity: 0.75,
                    strokeWeight: 3
                });
                polylineArray['Google'] = googlePolyline;

                var distance = 0;
                var j = 0;
                while (response.routes[0].legs[j]) {
                    distance += response.routes[0].legs[j].distance.value;
                    j++;
                }
                polylineArray['DistanceGoogle'] = distance;
                j = 0;
                while (response.routes[0].waypoint_order.length - j) {
                    var showTest = response.routes[0].waypoint_order[j];
                    if (indexStart)
                        document.getElementById("input." + (response.routes[0].waypoint_order[j] + indexStart)).value = j + 1 + indexStart;

                    else
                        document.getElementById("input." + response.routes[0].waypoint_order[j]).value = j + 1;



                    j++;
                }
                setOrder();
                if (nthGoThrough == 1) {
                    var GoogleTemp = new Array('Polyline', 'Distance');
                    GoogleTemp['Polyline'] = polylineArray['Google'];
                    GoogleTemp['Distance'] = polylineArray['DistanceGoogle'];

                    erpMarkerCollectionWayPoint = new ErpMarkerCollection();

                    var tmpDeparture = arrayStartStop['Departure'];

                    arrayStartStop['Departure'] = arrayStartStop['Arrival'];

                    arrayStartStop['Arrival'] = arrivalTemp;

                    j = i;
                    while (j != erpMarkerAddCollection.length()) {
                        erpMarkerCollectionWayPoint.add(erpMarkerAddCollection.arrayErpMarker[j]);
                        j++;
                    }
                    googlGo(erpMarkerCollectionWayPoint, i , 2, GoogleTemp, arrivalTemp, tmpDeparture);


                }
                if (nthGoThrough == 2) {
                    polylineArray['Google'].setMap(null);
                    var pathPolyline = GooglTemp['Polyline'].getPath();
                    var latLngTab = polylineArray['Google'].getPath().b;
                    var cmpt = 0;
                    var len = latLngTab.length;
                    while (len - cmpt) {
                        pathPolyline.push(latLngTab[cmpt]);
                        cmpt++;
                    }
                    var googlePolyline = new google.maps.Polyline({
                        path: pathPolyline,
                        strokeColor: "red",
                        strokeOpacity: 0.75,
                        strokeWeight: 3
                    });

                    polylineArray['Google'] = googlePolyline;

                    polylineArray['DistanceGoogle'] += GooglTemp['Distance'];

                    arrayStartStop['Departure'] = departureTemp;

                    document.getElementById("Distance").innerHTML = Math.round((polylineArray['DistanceGoogle'] / 1000) / 1.609344) + " miles";

                    polylineArray['ListChangeGoogle'] = false;
                    polylineArray['Google'].setMap(map);
                    var counter = 0;
                    var str = "";
                    var l = googlePolyline.latLngs.b[0].length;
                    var latlng = googlePolyline.latLngs.b[0];
                    while (l - counter) {
                        var ltde = latlng.b[counter].b;
                        var lgtde = latlng.b[counter].c;
                        str += ltde + "&" + lgtde + "|";
                        counter++;
                    }
                    //alert(str);
                    //alert(str.length);
                }
                if (nthGoThrough == 3) {
                    

                    polylineArray['Google'].setMap(map);
                    document.getElementById("Distance").innerHTML = Math.round((polylineArray['DistanceGoogle'] / 1000) / 1.609344) + " miles";
//                    polylineArray['DistanceGoogle'] = distance;
//                    j = 0;
//                    setOrder();
//                    var counter = 0;
//                    var str = "";
//                    var l = googlePolyline.latLngs.b[0].length;
//                    var latlng = googlePolyline.latLngs.b[0];
//                    while (l - counter) {
//                        var ltde = latlng.b[counter].b;
//                        var lgtde = latlng.b[counter].c;
//                        str += ltde + "&" + lgtde + "|";
//                        counter++;
//                    }
//                    alert(str);
//                    alert(str.length);
                }
            }
        });
    }


//function testGoogleAlgo() {
//        var origin = arrayStartStop['Departure'].getPosition();
//        var destination = arrayStartStop['Arrival'].getPosition();
//        var length = erpMarkerAddCollection.length();
//        var i = 0;
//        var waypoints = [];
//        while (length - i) {
//            waypoints.push({ location: erpMarkerAddCollection.arrayErpMarker[i].getCoordinateObject(), stopover: true });
//            i++;
//        }
//        var request = {
//            destination: destination,
//            origin: origin,
//            waypoints: waypoints,
//            optimizeWaypoints: true,
//            travelMode: google.maps.DirectionsTravelMode.DRIVING
//        };
//        directionService.route(request, function(response, status) {
//            if (status == google.maps.DirectionsStatus.OK) {
//                directionsDisplay.setDirections(response);
//                directionsDisplay.setMap(map);
//                var googlePolyline = new google.maps.Polyline({
//                    path: response.routes[0].overview_path,
//                    strokeColor: "red",
//                    strokeOpacity: 1,
//                    strokeWeight: 5
//                });
//                googlePolyline.setMap(map);
//                var j = 0;
//                while (response.routes[0].waypoint_order.length - j) {
//                    var showTest = response.routes[0].waypoint_order[j];
//                    document.getElementById("input." + response.routes[0].waypoint_order[j]).value = j + 1;
//                    j++;
//                }
//                setOrder();
//            }
//        });
//}