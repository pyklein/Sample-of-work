function Location(query) {
    //alert("location");
    this.id = query.Id;
    this.name = query.Name;
    this.xGridNumber = query.XGridNumber;
    this.yGridNumber = query.YGridNumber ;
    this.longitude = query.Longitude;
    this.latitude = query.Latitude;
    this.line1 = query.Line1;
    this.line2 = query.Line2;
    this.line3 = query.Line3;
    this.line4 = query.Line4;
    this.postcode = query.Postcode;
    this.cRNumber = query.CRNumber;
    this.substationTypeName = query.SubstationTypeName;
}

function diplayAddLocation() {
    if ($("#DivAddLocation").is(":hidden"))
        $("#DivAddLocation").stop(true, true).delay(300).slideDown(250);
}

function completeTypeLocation() {
    clearSelect(1,"Location");
    qbLocationTypes.set_orderby("Name");
    proxy.query(qbLocationTypes.toString(), TypeLocationSelect, onFailure);
}

function addLocation() {
    if (document.getElementById("txtCountry").value && (document.getElementById("txtLocationAddName").value ||
    document.getElementById('slctLocationAddTypesId').options[document.getElementById('slctLocationAddTypesId').selectedIndex].value.toString().toUpperCase() == '1BB08D21-22D8-45B9-A87A-C7096972F950')) {
        loading("visible");
        $.post("/_common/handlers/Locations/AddLocationHandler.ashx", $("form").serialize(), addLocationCallback);
    }
    else {
        if (!(document.getElementById("txtCountry").value)) {
            document.getElementById("logAlert").style.borderColor = "blue";
            document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logInfoMessage.jpg\" alt=\"info\" width=\"30%\"/></td><td VALIGN='middle' style='color:blue;'><b color:blue>&nbsp; Country error</b></td></tr>";
            $("#logAlert").stop(true, true).delay(5).slideDown(250);
            closelogalert();
        }
        if (!(document.getElementById("txtLocationAddName").value ||
    document.getElementById('slctLocationAddTypesId').options[document.getElementById('slctLocationAddTypesId').selectedIndex].value.toString().toUpperCase() == '1BB08D21-22D8-45B9-A87A-C7096972F950')) {
            document.getElementById("logAlert").style.borderColor = "red";
            document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logWarningMessage.png\" alt=\"valid\" width=\"30%\"/></td><td VALIGN:middle style='color:red;'><b>&nbsp;0 Name error</b></td></tr>";
            $("#logAlert").stop(true, true).delay(5).slideDown(250);
            closelogalert();
        }        
    }
}

function addLocationCallback(result) {
    loading("hidden");
    if (result == "ko") {
        document.getElementById("logAlert").style.borderColor = "red";
        document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logWarningMessage.png\" alt=\"valid\" width=\"30%\"/></td><td VALIGN:middle style='color:red;'><b>&nbsp;0 location add</b></td></tr>";
    }
    else {
        document.getElementById("logAlert").style.borderColor = "green";
        document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logValidMessage.png\" alt=\"valid\" width=\"30%\"/></td><td VALIGN:middle style='color:green;'><b>&nbsp;Add location successfully </b></td></tr>";
    }    
    $("#logAlert").stop(true, true).delay(10).slideDown(250);
    closelogalert();

}

function showDetailsAddLoc(action) {
    if (action == 'open') {
        document.getElementById("imgOpen").style.visibility = "visible";
        document.getElementById("imgClose").style.visibility = "hidden";
        $("#imgOpen").stop(true, true).delay(1).slideDown(1);
        $("#imgClose").stop(true, true).delay(1).slideUp(1);
        document.getElementById("tableDetailsAddLocation").style.visibility = "visible";
        $("#tableDetailsAddLocation").stop(true, true).delay(1).slideDown(1);
        document.getElementById("hiddenDisplayDetailsAddLocation").value = true;
    }
    else {
        document.getElementById("imgClose").style.visibility = "visible";
        document.getElementById("imgOpen").style.visibility = "hidden";
        $("#imgClose").stop(true, true).delay(1).slideDown(1);
        $("#imgOpen").stop(true, true).delay(1).slideUp(1);
        document.getElementById("tableDetailsAddLocation").style.visibility = "hidden";
        $("#tableDetailsAddLocation").stop(true, true).delay(1).slideUp(1);
        document.getElementById("hiddenDisplayDetailsAddLocation").value = false;
    }

}
function displayAddLocationName() {
    var test = document.getElementById('slctLocationAddTypesId').options[document.getElementById('slctLocationAddTypesId').selectedIndex].value.toString();
    test = test.toUpperCase();
if (test == '1BB08D21-22D8-45B9-A87A-C7096972F950') {
        $("#trNameLocation").stop(true, true).delay(1).slideUp(1);
        document.getElementById('trNameLocation').visibility = 'hidden';
    }
    else{
        $("#trNameLocation").stop(true, true).delay(1).slideDown(1);
        document.getElementById('trNameLocation').visibility = 'visible';
    }
}