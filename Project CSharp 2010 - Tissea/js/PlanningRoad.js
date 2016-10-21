function initRoad() {
    var departure = document.getElementById('slctDeparture').options[document.getElementById('slctDeparture').selectedIndex].value;
    var arrival = document.getElementById('slctArrival').options[document.getElementById('slctArrival').selectedIndex].value;
    createMarkerRoad("Departure"); //arrival
    createMarkerRoad("Arrival");
}

function ChangeSlct(slct) {
    //alert("plop");
    loading("visible");
    var val="";
    if (slct.substr(0,9) == "Employees") {
        val = document.getElementById('slct' + slct).options[document.getElementById('slct' + slct).selectedIndex].value;
        if (val == "none") {
            document.getElementById("logAlert").style.borderColor = "blue";
            document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logInfoMessage.jpg\" alt=\"info\" width=\"30%\"/></td><td VALIGN='middle' style='color:blue;'><b color:blue>&nbsp; The employee " + slct + " haven't any postcode</b></td></tr>";
            $("#logAlert").stop(true, true).delay(5).slideDown(250);
            closelogalert();
        }
        else {
            //alert("type for employee = " + slct.substr(9, slct.length));
            //alert("val = " + val);
            var tmp = val;
            getLatLngForGeocode(val,slct);           
        }
    }
    else {
        val = document.getElementById('slct' + slct).options[document.getElementById('slct' + slct).selectedIndex].value;
        if (val == "Company's HQ") {
            $('#tdEmployees' + slct).stop(true, true).delay(10).slideUp(10);
            setMarkerPosition(slct, val);
            changeLabel(arrayStartStop[slct].getPosition(), slct);
        }
        if (val == "Employee's house") {
            document.getElementById("slctOptimazePoint").value = slct;
            queryEmployees();
        }
    }
    loading("hidden");
    
}


function setMarkerPosition(slct, val) {
    var latLng=val;
    var intForVisibility = 0;
    if (slct == "Departure") {
        intForVisibility = 0.001;
    }
    if (val == "Company's HQ")
        latLng = new google.maps.LatLng(53.4878477 + intForVisibility, -2.8570325 + intForVisibility);
    arrayStartStop[slct].setPosition(latLng);
}

function diplayOptimize() {
    
    show('OptimiseRoad', '');
    if (document.getElementById("ckbOptimize").checked) {
        
        //create Marker
        initRoad();
        //alert("create marker");
    }
    else {

        //alert("del marker");
        
    }
}


function removeStartEndMarker() {
    if(arrayStartStop['Departure'])
        arrayStartStop['Departure'].setMap(null);
    if (arrayStartStop['Arrival'])
        arrayStartStop['Arrival'].setMap(null);
    arrayStartStop = new Array('Departure', 'Arrival');
}

function createMarkerRoad(slctType) {
    //alert("createMarkerRoad(a,b)");
    var intForVisibility = 0;
    if (slctType == "Departure") {
        intForVisibility = 0.001;
        image = "Resources/icons/start.png";
    }
    else{
        image = "Resources/icons/arrival.png";
    }
    
    var latLng =  new google.maps.LatLng(53.4878477 + intForVisibility, -2.8570325 + intForVisibility);
    var marker = new google.maps.Marker({
        position: latLng,
        clickable: false,
        map: map,
        draggable: true,
        icon: image,
        title: slctType,
        zIndex: 10000,
        visible:true
    });
    //alert("marker title =" + marker.title);
    //alert("latlng = " + latLng);
//    google.maps.event.addListener(marker, 'drag', function() {
//        $('#tdEmployees' + slctType).stop(true, true).delay(1).slideUp(10);
//        changeLabel(this.getPosition(), slctType);
//        document.getElementById('slct' + slctType).selectedIndex = 1;
//        $('tdEmployees' + slctType).stop(true, true).delay(1).slideUp(10);
//        polylineArray['ListChangeGoogle'] = true;
//        polylineArray['ListChangeClosest'] = true;
//        polylineArray['ListChangeFurthest'] = true;
//        polylineArray['ListChangeCustom'] = true;
//        changeLabel(this.getPosition(), slctType);
//    });
    google.maps.event.addListener(marker, 'dragend', function() {
        $('#tdEmployees' + slctType).stop(true, true).delay(1).slideUp(10);
        changeLabel(this.getPosition(), slctType);
        document.getElementById('slct' + slctType).selectedIndex = 1;
        $('tdEmployees' + slctType).stop(true, true).delay(1).slideUp(10);
        polylineArray['ListChangeGoogle'] = true;
        polylineArray['ListChangeClosest'] = true;
        polylineArray['ListChangeFurthest'] = true;
        polylineArray['ListChangeCustom'] = true;
        changeLabel(this.getPosition(), slctType);
    });
    arrayStartStop[slctType] = marker;   
    
}

function changeLabel(latlng, slctType) {
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'latLng': latlng }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                document.getElementById("lblCoordinate" + slctType).innerHTML = results[1].formatted_address;
            }
            
        }      
    });
}


function getLatLngForGeocode(address,slct) {
    var latLng = address; ;
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'address': address }, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                var val = results[0].geometry.location;
                setMarkerPosition(slct.substr(9, slct.length), val);
                changeLabel(arrayStartStop[slct.substr(9, slct.length)].getPosition(), slct.substr(9, slct.length));
            }
        }
        else {
            alert("Geocoder failed due to: " + status);
        }

    });
    return latLng;
}

function selectedCriticalInFirst() {
    var i =0;
    var count=0;
    while (erpMarkerAddCollection.arrayErpMarker[i]) {
        if (erpMarkerAddCollection.arrayErpMarker[i].object.critical) {
            document.getElementById("input." + i).value = 1;
            count++;
        }
        i++;
    }
    setOrder();
    return count;
}