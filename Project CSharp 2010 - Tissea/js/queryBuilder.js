﻿var qbTasks                 = new AjaxSys.Data.AdoNetQueryBuilder("vwTasks");
var qbWorkTimes             = new AjaxSys.Data.AdoNetQueryBuilder("vwWorkTimes");
var qbMPCSimple             = new AjaxSys.Data.AdoNetQueryBuilder("vwMPCSimple");
var qbLocations             = new AjaxSys.Data.AdoNetQueryBuilder("vwSubstations");
var qbActivities            = new AjaxSys.Data.AdoNetQueryBuilder("vwActivities");
var qbActivityDetails       = new AjaxSys.Data.AdoNetQueryBuilder("vwMPCSimple");


var qbActivityProgrammes    = new AjaxSys.Data.AdoNetQueryBuilder("ActivityProgrammes");
var qbActivityPriorities    = new AjaxSys.Data.AdoNetQueryBuilder("ActivityPriorities");
var qbActivityCategories    = new AjaxSys.Data.AdoNetQueryBuilder("ActivityCategories");
var qbActivityModules       = new AjaxSys.Data.AdoNetQueryBuilder("ActivityModules");
var qbEmployees             = new AjaxSys.Data.AdoNetQueryBuilder("Employees");
var qbCustomers             = new AjaxSys.Data.AdoNetQueryBuilder("Customers");
var qbLocationTypes         = new AjaxSys.Data.AdoNetQueryBuilder("LocationTypes");
var qbCountries             = new AjaxSys.Data.AdoNetQueryBuilder("Countries");
var qbCounties              = new AjaxSys.Data.AdoNetQueryBuilder("Counties");
var qbProjectStatuses       = new AjaxSys.Data.AdoNetQueryBuilder("ProjectStatuses");
var qbWorkingCalendars      = new AjaxSys.Data.AdoNetQueryBuilder("WorkingCalendars");
var qbProjects              = new AjaxSys.Data.AdoNetQueryBuilder("Projects");

//function initSelectFromDB() {
//    initCustomerSlct();
//} 
//    
//function initCustomerSlct() {
//    var customerSelect = document.getElementById("slctLocationAddCustomersId");
//}

//function testGetRoadForAProjectFromDB() {
//    var queryFilter = "Id eq guid'6108030b-8939-4216-a414-214278710fd1'";
//    qbProjects.set_filter(queryFilter);
//    proxy.query(qbProjects.toString(), onSuccessShowRoadFromDB, onFailure);
//}

//function onSuccessShowRoadFromDB(result, context, operation) {
//    var strRoad = result[0].XmlModel;
//    var tabPath = [];
//    while (strRoad.indexOf("|")!=-1) {
//        var lat = strRoad.substr(0, strRoad.indexOf("&"));
//        strRoad = strRoad.substr(strRoad.indexOf("&"),strRoad.length);
//        var lng = strRoad.substr(1, strRoad.indexOf("|")-1);
//        strRoad = strRoad.substr(strRoad.indexOf("|")+1, strRoad.length-1);
//        var latLng = new google.maps.LatLng(lat, lng);
//        tabPath[tabPath.length] = latLng;
//    }
//    var googlePolyline = new google.maps.Polyline({
//        path: tabPath,
//        strokeColor: "red",
//        strokeOpacity: 0.75,
//        strokeWeight: 3
//    });
//    googlePolyline.setMap(map);
//}

function BuildQueryActivities(erpMarker) {
    if (erpMarker.type == 0) {
        var queryFilterActivitieTab = "";
        queryFilterActivitieTab = "ActivityId eq " + erpMarker.object.activityId + " ";
        queryFilterActivitieTab += "and Enabled eq true and Archived eq false and Deleted eq false ";
    }
    return queryFilterActivitieTab;
}

function queryEmployees() {
    qbEmployees.set_orderby("FirstName");
    var queryFilterEmployees = "Enabled eq true and Archived eq false and Deleted eq false";
    qbEmployees.set_filter(queryFilterEmployees);
    proxy.query(qbEmployees.toString(), onSuccessCompleteSelectEmployees, onFailure);    
}

function onSuccessCompleteSelectEmployees(result, context, operation) {
    var hiddenInputSlct = document.getElementById("slctOptimazePoint").value;
    document.getElementById("slctEmployees" + hiddenInputSlct).innerHTML="";
    
    var select = document.getElementById("slctEmployees" + hiddenInputSlct);
    for (var i in result) {
        var resQuery = result[i];
        
            var option = document.createElement('option');
            option.value = resQuery.Postcode;
            option.innerHTML = resQuery.FirstName + " " + resQuery.LastName + "-" + resQuery.Number;
            if (resQuery.Postcode == "NULL" || resQuery.Postcode == null || resQuery.Postcode == "") {
                //option.setAttribute('style', 'background-color: gray;');
                //option.disabled ="disabled";
                option.value = "none";
            }
            select.appendChild(option);
        }
        var str = 'tdEmployees' + hiddenInputSlct;
        document.getElementById(str).style.visibility = "visible";
        $("#"+str).stop(true, true).delay(1).slideDown(100);
        document.getElementById('tdEmployees' + hiddenInputSlct).style.visibility = "visible";
        
}

function BuildFilters() {
    document.getElementById("createAudit").style.visibility = "hidden";
    refreshMap();
    queryFilter = "";
    currentMarkerType = MarkerType.none;
    requestGetLocation();
    requestGetActivities();
    if (queryFilter == "")
        search = true;
    if (!search) {
        disabled(queryFilter);
    }

    if (queryFilter == "") {
        disabled(queryFilter);
        currentMarkerType = MarkerType.Activity;
        loading("hidden");
        document.body.style.cursor = 'default';
        queryFilter = "ModuleName eq 'REACTIVE' and Enabled eq false and Archived eq false and Deleted eq false and Completed eq false ";
    }
}

function getActivityFromProjectId(projectId) {
    currentMarkerType = MarkerType.Activity;
    var queryFilterAcitivityFromProjectId = "ProjectId eq guid'"+projectId+"'";
    qbActivities.set_filter(queryFilterAcitivityFromProjectId);
    qbActivities.set_orderby("PlanningOrder");
    proxy.query(qbActivities.toString(), onSuccessGetActivityForProjectId, onFailure);
}

function onSuccessGetActivityForProjectId(result, context, operation) {
    refreshMap();
    erpMarkerCollection.toEmpty();
    erpMarkerCollection.type = MarkerType.Activity;
    currentMarkerType = MarkerType.Activity;
    var j = 0;
    for (var i in result) {
        var resQuery = result[i];
        if (resQuery.Latitude != null && resQuery.Longitude != null) {
            var erpGMarker = new ErpMarker(map, currentMarkerType, resQuery, i);
            j = 0;
            erpMarkerCollection.add(erpGMarker);
            erpMarkerAddCollection.addMarker(erpGMarker);
        }
    }
    var mcOptions = { gridSize: 70, maxZoom: 13 };
    markerClusterer = new MarkerClusterer(map, erpMarkerCollection.arrayErpMarker, mcOptions);
    //markerClusterer = new MarkerClusterer(map, erpMarkerCollection.arrayErpMarker, mcOptions);
    //markerClusterer.getMarkers();
    refreshList();
    loading("hidden");
}


function completeProjectSelect() {
    //proxy.query(qbProjectStatuses.toString(), onSuccessCompleteGetProjectStatuses, onFailure);
    proxy.query(qbWorkingCalendars.toString(), onSuccessCompleteGetCalendar, onFailure);
    //qbProjects.set_orderby("Name");
    //proxy.query(qbProjects.toString(), onSuccessCompleteGetProject, onFailure);
}

function onSuccessCompleteGetProject(result, context, operation) {
    var select = document.getElementById("ProjectList");
    for (var i in result) {
        var resQuery = result[i];
        var option = document.createElement('option');
        option.value = resQuery.Id;
        option.innerHTML = resQuery.Name;
        select.appendChild(option);
    }
}

function onSuccessCompleteGetProjectStatuses(result, context, operation) {
    var select = document.getElementById("ProjectStatus");
    for (var i in result) {
        var resQuery = result[i];
        var option = document.createElement('option');
        option.value = resQuery.Id;
        option.innerHTML = resQuery.Reference;
        select.appendChild(option);
    }
}

function onSuccessCompleteGetCalendar(result, context, operation) {
    var select = document.getElementById("ProjectCalendar");
    for (var i in result) {
        var resQuery = result[i];
        var option = document.createElement('option');
        option.value = resQuery.Id;
        option.innerHTML = resQuery.Name;
        select.appendChild(option);
    }
}

//ActivityAddModuleId

function completeSelectForAddActivity(filter) {

    qbActivityDetails.set_filter(filter);
    //qbActivityDetails.set_orderby("Name");
    proxy.query(qbActivityDetails.toString(), onSuccessCompleteSelectAddActivity, onFailure);
}

function CategorieSelect(filter) {
    qbActivityDetails.set_filter(filter);
    qbActivityDetails.set_orderby("CategoryName");
    proxy.query(qbActivityDetails.toString(), onSuccessCompleteSelectAddActivityCategorie, onFailure);
}

function ProgrammeSelect(filter) {
//    qbActivityDetails.set_filter(filter);
//    qbActivityDetails.set_orderby("ProgrammeName");
//    proxy.query(qbActivityDetails.toString(), onSuccessProgrammeSelect, onFailure);
}

function onSuccessCompleteSelectAddActivityCategorie(result, context, operation) {
    var select = document.getElementById("slctAddActivityCategoriesId");
    //alert("success categorie");
    var j = 0;
    var bool = false;
    var resNameBefore = "";
    for (var i in result) {
        var resQuery = result[i];
        if (i == 0 && resQuery.CategoryName) {
            var option = document.createElement('option');
            option.value = resQuery.CategoryId;
            option.innerHTML = resQuery.CategoryName;
            select.appendChild(option);
        }
        if (resQuery.CategoryName != resNameBefore && i >= 1 && resQuery.CategoryName) {
            var option = document.createElement('option');
            option.value = resQuery.CategoryId;
            option.innerHTML = resQuery.CategoryName;
            select.appendChild(option);
        }
        resNameBefore = resQuery.CategoryName;
    }
    select.selectedIndex = 0;
}

function loadProgramme(sender, eventArgs) {
    
    if (slctAddActivityModulesId.get_value() && slctAddCustomersId.get_value())
        slctAddActivityProgrammesId.requestItems(slctAddActivityModulesId.get_value() + "|" + slctAddCustomersId.get_value(), false);
    else{
        slctAddActivityProgrammesId.set_text(" ");
        slctAddActivityProgrammesId.clearItems(); 
    }
}

function loadCategory(sender, eventArgs) {
    slctAddActivityCategoriesId.requestItems(slctAddActivityProgrammesId.get_value() + "|" + slctAddCustomersId.get_value(), false);
}

function loadPriority(sender, eventArgs) {
    slctAddActivityPrioritiesId.requestItems(slctAddCustomersId.get_value(), false);
}

function PrioritiesSelect(result, context, operation) {
    var select = document.getElementById("slctAddActivityPrioritiesId");
    var j = 0;
    var resNameBefore = "";
    var bool = false;var option;
    for (var i in result) {
        var resQuery = result[i];
        if (i == 0 && resQuery.Name) {
            option = document.createElement('option');
            option.value = resQuery.Id;
            option.innerHTML = resQuery.Name;
            select.appendChild(option);           
        }
        if (resQuery.Name != resNameBefore && i >= 1 && resQuery.Name) {
             option = document.createElement('option');
            option.value = resQuery.Id;
            option.innerHTML = resQuery.Name;
            select.appendChild(option);
        }
        //alert(option.innerHtml);
        resNameBefore = resQuery.Name;
    }
    select.selectedIndex = 0;
}

//ge datetime
function searchActiveProject(date) {
    document.getElementById("hiddenDateChoose").value = date;
    ajaxmgr.ajaxRequest("searchActiveProject"+'|'+date);
    $("#tree").stop(true, true).delay(1).slideDown(250);
    //show("DivProjectTree", '');
}

 function onSuccessProgrammeSelect(result, context, operation) {
    var select = document.getElementById("slctAddActivityProgrammesId");
    var j = 0;
    var bool = false;
    var resNameBefore = "";
    for (var i in result) {
        var resQuery = result[i];
        if (i == 0 && resQuery.ProgrammeName) {
            var option = document.createElement('option');
            option.value = resQuery.ProgrammeId;
            option.innerHTML = resQuery.ProgrammeName;
            select.appendChild(option);
        }
        if (resQuery.ProgrammeName != resNameBefore && i >= 1 && resQuery.ProgrammeName) {
            var option = document.createElement('option');
            option.value = resQuery.ProgrammeId;
            option.innerHTML = resQuery.ProgrammeName;
            select.appendChild(option);
        }
        resNameBefore = resQuery.ProgrammeName;
    }
    select.selectedIndex = 0;
}

//

function ModulesSelect(result, context, operation) {
    var select = document.getElementById("slctAddActivityModulesId");
    var j = 0;
    //alert("success");
    var resNameBefore = "";
    var bool = false;
    for (var i in result) {
        var resQuery = result[i];
        
        if (i == 0 && resQuery.ModuleName) {
            var option = document.createElement('option');
            option.value = resQuery.ModuleId;
            option.innerHTML = resQuery.ModuleName;
            select.appendChild(option);
        }
        if (resQuery.ModuleName != resNameBefore && i >= 1 && resQuery.ModuleName) {
            var option = document.createElement('option');
            option.value = resQuery.ModuleId;
            option.innerHTML = resQuery.ModuleName;
            select.appendChild(option);
        }
        resNameBefore = resQuery.ModuleName;
    }
    select.selectedIndex = 0;
}

function CustomerSelect(result, context, operation) {

    var select = document.getElementById("slctAddCustomersId");
    var j = 0;
    var bool = false;
    var resNameBefore = "";
    while (select.firstChild) {
        select.removeChild(select.firstChild);
    }
    for (var i in result) {
        var resQuery = result[i];
        if (i == 0 && resQuery.Name) {
            var option = document.createElement('option');
            option.value = resQuery.Id;
            option.innerHTML = resQuery.Name;
            select.appendChild(option);
        }
        if (resQuery.Name != resNameBefore && i >= 1 && resQuery.Name) {
            var option = document.createElement('option');
            option.value = resQuery.Id;
            option.innerHTML = resQuery.Name;
            select.appendChild(option);
        }
        resNameBefore = resQuery.Name;
    }
    select.selectedIndex = 0;
}

function getIdCountry(name) {
    var filterName = "Name eq '"+name+"'";
    qbCountries.set_filter(filterName);
    proxy.query(qbCountries.toString(), onSuccessGetIdCountry, onFailure);
}

function onSuccessGetIdCountry(result, context, operation) {
    if (result[0]) {
        document.getElementById("hiddenCountry").value = result[0].Id;
        getCounties();
    }
    
}

function getCounties() {
    var countryId = document.getElementById("hiddenCountry").value.toString();
    //Countries(guid'51463111-ba69-d54f-836c-a036ea3270e6')/Counties
    //    var filterName = "CountryId eq guid'" + countryId + "'";
    //    qbCounties.set_filter(filterName);
    //    proxy.query(qbCounties.toString(), onSuccessGetCounties, onFailure);
    proxy.query("Countries(guid'" + countryId + "')/Counties", onSuccessGetCounties, onFailure);
}

function onSuccessGetCounties(result, context, operation) {
    var select = document.getElementById("slctCounty");
    var j = 0;
    var bool = false;
    var resNameBefore = "";
//    while (select.firstChild) {
//        select.removeChild(select.firstChild);
    //    }

//    var option = document.createElement('option');
//    option.value = null;
//    option.innerHTML = "Select County";
//    select.appendChild(option);
    
    for (var i in result) {
        var resQuery = result[i];
        if (i == 0 && resQuery.Name) {
            var option = document.createElement('option');
            option.value = resQuery.Id;
            option.innerHTML = resQuery.Name;
            select.appendChild(option);
        }
        if (resQuery.Name != resNameBefore && i >= 1 && resQuery.Name) {
            var option = document.createElement('option');
            option.value = resQuery.Id;
            option.innerHTML = resQuery.Name;
            select.appendChild(option);
        }
        resNameBefore = resQuery.Name;
    }
    select.selectedIndex = 0;
}


function TypeLocationSelect(result, context, operation) {
    var select = document.getElementById("slctLocationAddTypesId");
    var j = 0;
    var bool = false;
    var resNameBefore = "";
    while (select.firstChild) {
        select.removeChild(select.firstChild);
    }
    for (var i in result) {
        var resQuery = result[i];
        if (i == 0 && resQuery.Name) {
            var option = document.createElement('option');
            option.value = resQuery.Id;
            option.innerHTML = resQuery.Name;
            select.appendChild(option);
        }
        if (resQuery.Name != resNameBefore && i >= 1 && resQuery.Name) {
            var option = document.createElement('option');
            option.value = resQuery.Id;
            option.innerHTML = resQuery.Name;
            select.appendChild(option);
        }
        resNameBefore = resQuery.Name;
    }
    select.selectedIndex = 0;
    loading("hidden");
    document.getElementById("trTypeLocation").style.visibility = "visible";
    $("#trTypeLocation").stop(true, true).delay(1).slideDown(1);
    document.getElementById('trTypeLocation').style.visibility = "visible";
}

function completeSelectLocationCustomersForLocation() {
    if (document.getElementById("ckbDataProtection").checked) {
        //var filterAddLocation = "";
        //qbCustomers.set_filter("");
        //proxy.query(qbCustomers.toString(), completeLocationCustomer, onFailure);
        document.getElementById("trCustomerLocation").style.visibility = "visible";
        $("#trCustomerLocation").stop(true, true).delay(100).slideDown(100);
    }
    else {
        document.getElementById("trCustomerLocation").style.visibility = "hidden";
        $("#trCustomerLocation").stop(true, true).delay(100).slideUp(100);
    }
}

function completeLocationCustomer(result, context, operation) {
    var select = document.getElementById("slctLocationAddCustomersId");
    var j = 0;
    var bool = false;
    var resNameBefore = "";
    while (select.firstChild) {
        select.removeChild(select.firstChild);
    }
    for (var i in result) {
        var resQuery = result[i];
        if (i == 0 && resQuery.Name) {
            var option = document.createElement('option');
            option.value = resQuery.Id;
            option.innerHTML = resQuery.Name;
            select.appendChild(option);
        }
        if (resQuery.Name != resNameBefore && i >= 1 && resQuery.Name) {
            var option = document.createElement('option');
            option.value = resQuery.Id;
            option.innerHTML = resQuery.Name;
            select.appendChild(option);
        }
        resNameBefore = resQuery.Name;
    }
    select.selectedIndex = 0;
    document.getElementById("trCustomerLocation").style.visibility = "visible";
    $("#trCustomerLocation").stop(true, true).delay(100).slideDown(100);
    document.getElementById('trCustomerLocation').style.visibility = "visible";
}

function getProjectFromName(name) {
    var filterName = "Name eq '" + name + "'";
    qbProjects.set_filter(filterName);
    proxy.query(qbProjects.toString(), onSuccessGetProjectFromName, onFailure);
}

function onSuccessGetProjectFromName(result, context, operation) {
    var resQuery = result[0];
    document.getElementById("hiddenCurrentProjectId").value = resQuery.Id;
    document.getElementById("getNameProject").innerHTML = resQuery.Name;
    var startDate = new Date(resQuery.StartDateTime);
    startDate = startDate.getFullYear() + "-" + (startDate.getMonth()+1) + "-" + startDate.getDate();
    document.getElementById("getStartDateTimeProject").innerHTML = startDate;
    var endDate = new Date(resQuery.EndDateTime);
    endDate = endDate.getFullYear() + "-" + (endDate.getMonth() + 1) + "-" + endDate.getDate();
    document.getElementById("getEndDateTimeProject").innerHTML = endDate;
    getActivityFromProjectId(resQuery.Id);   
}