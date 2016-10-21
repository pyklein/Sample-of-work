function ErpMarkerCollection() {
    this.arrayErpMarker = new Array();
    this.type = MarkerType.None;
}

ErpMarkerCollection.prototype.add = function(erpMarker) {
    if (this.type != MarkerType.None && this.type != erpMarker.type) {
        document.getElementById("logAlert").style.borderColor = "red";
        document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logWarningMessage.jpg\" alt=\"info\" width=\"30%\"/></td><td VALIGN='middle' style='color:blue;'><b color:red>&nbsp; Non conforme type</b></td></tr>";
        $("#logAlert").stop(true, true).delay(10).slideDown(250);
        closelogalert();
    }
    else {
        this.type = erpMarker.type;
        this.arrayErpMarker.push(erpMarker);
    }
}

ErpMarkerCollection.prototype.addAtIndex = function(index, erpMarker) {
    if (!this.arrayErpMarker[index]) {
        this.arrayErpMarker[index] = erpMarker;
    }
    else {
        var tmpErpMarker = this.arrayErpMarker[index];
        var tmpErpMarker2;
        this.arrayErpMarker[index] = erpMarker;
        var length = this.length();
        while (index < length) {
            tmpErpMarker2 = this.arrayErpMarker[parseInt(index) + 1];
            this.arrayErpMarker[parseInt(index) + 1] = tmpErpMarker;
            tmpErpMarker = tmpErpMarker2;
            index++;
        }
    }
}

ErpMarkerCollection.prototype.cleanCollection = function() {
    var i = 0;
    var j = 0;
    var length = this.length();
    var cleanErpMarkerCollection = new ErpMarkerCollection();
    while (length - i) {
        if (this.arrayErpMarker[i]) {
            cleanErpMarkerCollection.arrayErpMarker[j] = this.arrayErpMarker[i];
            j++;
        }
        i++;
    }
    return cleanErpMarkerCollection;
}

ErpMarkerCollection.prototype.addMarker = function(ErpMarker) {
    ErpMarker.changeIconErpMarker(0, "InList.png");
    this.add(ErpMarker);
}

ErpMarkerCollection.prototype.length = function() {
    return this.arrayErpMarker.length;
}

ErpMarkerCollection.prototype.toEmpty = function() {
    this.type = MarkerType.None;
    this.setToDefaultIconGMarkerList();
    this.arrayErpMarker = new Array();
}

ErpMarkerCollection.prototype.setToDefaultIconGMarkerList = function() {
    var i = 0;
    var length = this.length();
    while (length - i) {
        this.arrayErpMarker[i].inList = false;
        this.arrayErpMarker[i].changeIconErpMarker(6, ".png");
        i++
    }
}


//ErpMarkerCollection.prototype.joinErpMarkerCollection = function(erpCollectionToAdd) {

//    if (this.type == erpCollectionToAdd.type) {
//        this.arrayErpMarker.concat(erpCollectionToAdd.arrayErpMarker);
//    }
//    else {
//        document.getElementById("logAlert").style.borderColor = "red";
//        document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logWarningMessage.png\" alt=\"valid\" width=\"30%\"/></td><td VALIGN:middle style='color:red;'><b>Unable to make a list of "+erpCollectionToAdd.type+" and "+this.type+" </b></td></tr>";
//        $("#logAlert").stop(true, true).delay(10).slideDown(250);
//        closelogalert();
//    }
//}


ErpMarkerCollection.prototype.deleteInList = function(index) {
    var i = 0;
    var j = 0;
    var length = this.length();
    var cleanErpMarkerCollection = new ErpMarkerCollection();
    while (length - i) {
        if (this.arrayErpMarker[i].index == index) {
        }
        else {
            cleanErpMarkerCollection.arrayErpMarker[j] = this.arrayErpMarker[i];
            j++;
        }
        i++;
    }
    return cleanErpMarkerCollection;
}

ErpMarkerCollection.prototype.inBound = function(sw, ne) {
    loading("visible");
    var latSw = sw.lat();
    var lngSw = sw.lng();
    var latNe = ne.lat();
    var lngNe = ne.lng();
    for (var i = 0; i < this.length(); i++) {
        var erpMarker = this.arrayErpMarker[i];

        if (erpMarker != null) {
            var erpLng = erpMarker.getLng();
            var erpLat = erpMarker.getLatitude();
            if (erpLng > lngSw && erpLng < lngNe && erpLat > latSw && erpLat < latNe) {
                var boolInList = false;
                for (var j = 0; j < erpMarkerAddCollection.length(); j++) {
                    if (erpMarkerAddCollection.arrayErpMarker[j].id == erpMarker.id)
                        boolInList = true;

                }
                if (!boolInList) {
                    erpMarkerAddCollection.add(erpMarker);
                    erpMarker.inList = true;
                    erpMarker.changeIconErpMarker(0, "InList.png");
                }
            }
        }
    }

    refreshList();
    $("#DivList").stop(true, true).delay(10).slideDown(250);
}