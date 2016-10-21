function ErpMarker(map, type, resQuery, index) {
    //alert("repMarker");
    this.gMap = map;
    this.type = type;
    this.object = this.createObject(resQuery);
    this.gMarker = this.createGMarker();
    this.tab = new ContentTabInfo(type);
    //Global index
    this.index = index;
    //Index when in List
    this.listIndex = null;
    this.id = this.object.id;
    this.inList = false;
    this.addEvents();
    this.name = "";
    this.setName();
    //this.arrayIndexInAlgo = new Array('Custom', 'Google', 'Closest', 'Furthest');
}

ErpMarker.prototype.createObject = function(resQuery) {
    var obj;
    if (this.type == MarkerType.Activity) {
        obj = new Activity(resQuery);
    }
    else {
        obj = new Location(resQuery);
    }
    return obj;
}

ErpMarker.prototype.setName= function(){
    if(this.type==MarkerType.Activity){
        this.name= this.object.activityId;
    
    }
    else 
        if(this.type==MarkerType.Location){
            this.name= this.object.name;    
    }
}

ErpMarker.prototype.addEvents = function() {
    var erpMarker = this;

    google.maps.event.addListener(this.gMarker, 'click', function(event) {
    //alert(event);
        
        erpMarker.detailTab();
        var sv = new google.maps.StreetViewService();
        sv.getPanoramaByLocation(this.getPosition(), 50, this.processSVData);
        
    });

    google.maps.event.addListener(this.gMarker, 'dblclick', function(event) {
        erpMarkerContextMenu.showAt(event.x, event.y);
        document.getElementById("markerClickId").value = this.__gm_id - 31;
    });
}

google.maps.Marker.prototype.processSVData = function(data, status) {

    if (status == google.maps.StreetViewStatus.OK) {
        var panoramaOptions = {
            position: data.location.latLng,
            pov: {
                heading: 34,
                pitch: 10,
                zoom: 1
            }
        };
        $find("SPaneStreetView").setContent("<div  id='Pano' style='width: 400px; height: 300px;'></div>");
        var panorama = new google.maps.StreetViewPanorama(document.getElementById("Pano"), panoramaOptions);
        document.getElementById("Pano").style.zIndex = '100000';
        map.setStreetView(panorama);
    } else {
        $find("SPaneStreetView").setContent("<i>Street View not found</i>");
    }
}


ErpMarker.prototype.createGMarker = function() {
    var ico = this.choiceIcons();
    var iconimage = new google.maps.MarkerImage(ico, new google.maps.Size(30, 30), new google.maps.Point(0, 0), new google.maps.Point(5, 5), new google.maps.Size(30, 30));
   
    var googleMarker = new google.maps.Marker({
        position: this.getCoordinateObject(),
        map: map,
        icon: iconimage,
        zIndex: 100
    });
    var i = 0;
    return googleMarker;
}

ErpMarker.prototype.choiceIcons = function() {
    var image = "Resources/icons/reactive.png";
    var strCritical = "";
    if (this.type == MarkerType.Activity) {
        if (this.object.critical)
            strCritical = "Critical";
        switch (this.object.moduleName) {
            case "REACTIVE":
                image = "Resources/icons/reactive"+strCritical+".png";
                if (this.object.workflowState <= 4)
                    image = "Resources/icons/reactiveRed" + strCritical + ".png";
                if (this.object.workflowState == 6)
                    image = "Resources/icons/reactiveOrange" + strCritical + ".png";
                if (this.object.workflowState == 7)
                    image = "Resources/icons/reactiveGreen" + strCritical + ".png";
                break;
            case "RECURRENT":
                image = "Resources/icons/recurrent.png";
                break;
            case "QUOTE":
                image = "Resources/icons/quote.png";
                break;
        }
    } else if (this.type == MarkerType.Location) {
        switch (this.object.substationTypeName) {
            case ckb11.value:
                image = "Resources/icons/11Kv.png";
                break;
            case ckb33.value:
                image = "Resources/icons/33Kv.png";
                break;
            case ckb132.value:
                image = "Resources/icons/132Kv.png";
                break;
        }
    }
    return image;
}

ErpMarker.prototype.getCoordinateObject = function() {
    return new google.maps.LatLng(this.object.latitude, this.object.longitude);
}

ErpMarker.prototype.getCoordinate = function() {
    return this.gMarker.getPosition();
}

ErpMarker.prototype.getLatitude = function() {
    var latlng = this.getCoordinate();
    return latlng.lat();
}

ErpMarker.prototype.getLng = function() {
    var latlng = this.getCoordinate();
    return latlng.lng();
}

ErpMarker.prototype.detailTab = function() {
    //loading("visible");
    closeTab();
    htmlWorkTimesG = "";
    this.tab.init(this);
    //this.openContentTab();
    setTimeout("var j=0;j+= 2", 1000);
    execAfterCompletedSlidingZone(this);
}
function execAfterCompletedSlidingZone(erpMarker) {
    var check = setInterval(function() {
    if (htmlWorkTimesG != "") {
            clearInterval(check);
            erpMarker.openContentTab();
            //calculRoadClosest(distance);
        }
    }
    ,1000);
}
ErpMarker.prototype.getIcon = function() {
    return this.gMarker.icon.$a;
}
ErpMarker.prototype.changeIconErpMarker = function(indexInt, strNameImg) {
    var str = this.gMarker.icon.$a;
    var len = str.length;
    var indPoint = str.indexOf('.') - indexInt;
    this.changeIcon(str.substr(0, indPoint) + strNameImg); //lat,lng,index,marker
}
ErpMarker.prototype.changeIcon = function(newIconPath) {
if (this.inList && this.type == erpMarkerAddCollection.type == MarkerType.Activity && this.object.planningOrder!=null)
        addIconAtMap(this.object.latitude, this.object.longitude, this.listIndex, this.gMarker);
    var iconSize = new google.maps.Size(30, 30);
    var iconAnchor = this.gMarker.getIcon().anchor;
    var iconOrigin = this.gMarker.getIcon().origin;
    var iconimage = new google.maps.MarkerImage(newIconPath, iconSize, iconOrigin, iconAnchor, iconSize);
    this.gMarker.setIcon(iconimage);
}

function addOrDelToList(index, erpMarkerId) {
    if (erpMarkerId == "" && !erpMarkerCollection.arrayErpMarker[index].inList) {
        erpMarkerCollection.arrayErpMarker[index].changeIconErpMarker(0, "InList.png");
        erpMarkerAddCollection.add(erpMarkerCollection.arrayErpMarker[index]);
        erpMarkerCollection.arrayErpMarker[index].inList = true;
    }
    else {
        var i = '';
        if (erpMarkerId != "") {
            var i = 0;
            var j = 0;
            var length = erpMarkerCollection.length();
            var boolBreak = false;
            while (length - i && !boolBreak) {
                if (erpMarkerCollection.arrayErpMarker[i].id == erpMarkerId) {
                    boolBreak = true;
                    i--;
                }
                i++;
            }
            index = i;
            erpMarkerCollection.arrayErpMarker[index].changeIconErpMarker(6, ".png");
            erpMarkerCollection.arrayErpMarker[index].inList = false;
        
            erpMarkerAddCollection = erpMarkerAddCollection.deleteInList(erpMarkerCollection.arrayErpMarker[index].index);
        }
        else {
            erpMarkerCollection.arrayErpMarker[index].changeIconErpMarker(6, ".png");
            erpMarkerCollection.arrayErpMarker[index].inList = false;
            erpMarkerAddCollection = erpMarkerAddCollection.deleteInList(erpMarkerCollection.arrayErpMarker[index].index);
        }
    }
    
    if (document.getElementById(erpMarkerCollection.arrayErpMarker[index].id) != null) {
        document.getElementById(erpMarkerCollection.arrayErpMarker[index].id).disabled = true;
    }
    query = "";
    refreshList();
}

ErpMarker.prototype.openContentTab = function() {
    
    closeTab();
    detailsSlide.setContent(this.tab.htmlDetails);
    tasksSlide.setContent(htmlTasksG);
    worktimesSlide.setContent(htmlWorkTimesG);
//    var fenway = this.getCoordinateObject();
//    var panoramaOptions = {
//        position: fenway,
//        pov: {
//            heading: 34,
//            pitch: 10,
//            zoom: 1
//        }
//    };
//    $find("SPaneStreetView").setContent("<div  id='Pano' style='width: 400px; height: 300px;'></div>");
//    var panorama = new google.maps.StreetViewPanorama(document.getElementById("Pano"), panoramaOptions);
//    document.getElementById("Pano").style.zIndex = '100000';
//    map.setStreetView(panorama);

    infowindow = new google.maps.InfoWindow({
        content: this.tab.smallInfo
    });
    infowindow.open(map, this.gMarker);
    document.getElementById("ContentInfo").innerHTML = this.tab.htmlDetails;
    openSlidingZone();

    //    this.gMarker.openMaxContentTabsHtml(map, this.tab.smallInfo, this.tab.summary, this.tab.tabs, {
    //        maxTitle: this.tab.summary
    //    });
    loading("hidden");
}


function openSlidingZone() {
    detailsSlide.setContent(htmlDetailsG);
    tasksSlide.setContent(htmlTasksG);
    worktimesSlide.setContent(htmlWorkTimesG);

    $find("SlidingZoneInformation").expandPane('SPaneDetails');
}


//function openMaxContent(htmlDetails, htmlTasks, htmlWorkTimes) {
//    document.getElementById("maxTab").style.visibility = "visible";
//    document.getElementById("maxTab").style.display = "block";
//    $("#maxTab").stop(true, true).delay(10).slideDown(10);
//    y = 0;
//    document.getElementById("maxTab").style.bottom = "-200px";
//    movethediv();
//    //$("#maxTab").stop(true, true).delay(1000).slideUp(10);
//}

//function movethediv() {
//    for(i=1;i<5000;i++){
//        setTimeout("doMove()",500);
//    }
//}
//function doMove(){
//    y=y+0.002;
//    // Assignation des nouvelles coordonnées au div
//    document.getElementById("maxTab").style.bottom=y+"px";
//}
