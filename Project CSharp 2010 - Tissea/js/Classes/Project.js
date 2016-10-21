function Project(name,startDateTime,endDateTime,customer) {
    this.Name = name;
    this.Customer = customer;
    this.StartDateTime = startDateTime;
    this.EndDateTime = endDateTime;
    this.activity = [];
}


function createProject() {
    loading("visible");
//    var name = document.getElementById("RadTextBoxProjectName").value;
//    var end = radDatePickerEndDateTime.get_value();
//    var start = radDatePickerStartDateTime.get_value();
//    var customer = document.getElementById("hiddenCustomerProject").value;
//    var project = new Project(name, start, end,customer);
    linkActivitiesToProject();
}

function linkActivitiesToProject() {
    if (currentMarkerType == MarkerType.Activity) {
        var inputHidden = document.getElementById('hiddenActivitiesProject');
        inputHidden.value = "";
        var i = 0;
        while (i < erpMarkerAddCollection.length()) {
            if (erpMarkerAddCollection.arrayErpMarker[i] != "") {
                inputHidden.value += erpMarkerAddCollection.arrayErpMarker[i].object.id + ";";
            }
            i++;
        }
        
        inputHidden.value = inputHidden.value.substr(0, inputHidden.value.length - 1);
        //alert(inputHidden.value);    
    }
    else {
        document.getElementById("logAlert").style.borderColor = "red";
        document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logWarningMessage.png\" alt=\"valid\" width=\"30%\"/></td><td VALIGN:middle style='color:red;'><b>I have to select activities before adding a project</b></td></tr>";
        $("#logAlert").stop(true, true).delay(10).slideDown(250);
        closelogalert();
    }

}

function displayActivityProject() {
    var idProject = document.getElementById('ProjectList').options[document.getElementById('ProjectList').selectedIndex].value;
    getActivityFromProjectId(idProject);
}

function setProject() {
    //
}

function setLisActivityForAProject() {
    linkActivitiesToProject();
}
//get_parent()
//_setChecked(false)
function onClientNodeChecked(sender, args) {
    document.getElementById("hiddenCheckedProjectList").value = "";
    document.getElementById("hiddenActivitiesIdChecked").value = "";
    currentMarkerType = MarkerType.Activity;
    erpMarkerAddCollection.toEmpty();
    erpMarkerCollection.toEmpty();
    refreshList();
    refreshMap();
//    checkChecking(args._node);
    var tabProjectDisplay = [];
    var tabActivityDisplay = [];
    var tabProjectCheckToDispay = new Array('Projects', 'Activities');
    tabProjectCheckToDispay['Projects'] = tabProjectDisplay;
    tabProjectCheckToDispay['Activities'] = tabActivityDisplay;
    var nodeArray = tree.get_allNodes();
    for (var i = 0; i < nodeArray.length; i++) {
        var node = nodeArray[i];
        var value = node.get_value().toString();
//        var parentValue = "";
//        
//        if (node._parent._parent) {
//            parentValue = node._parent.get_value().toString();
//            parentValue = parentValue.substr(4, parentValue.length);
//        }
        type = value.substr(0, 4);
        var value = value.substr(4, value.length);
        if (node.get_checked()) {
            if (type == "proj") {
                tabProjectCheckToDispay['Projects'][tabProjectCheckToDispay['Projects'].length] = value;
            }
            if (type == "acti") {
                document.getElementById("hiddenActivitiesIdChecked").value = value+";";
            }            
        }
    }
    displayProject(tabProjectCheckToDispay);   
}

//function checkChecking(node) {
//    if (node._children._array.length == 0)
//        ;
//    else {
//        var countNode=0;
//        var boolAllChildNodeCheck=true;
//        while (node._children._array[countNode]) {
//            if (!node._children._array[countNode].get_checked())
//                boolAllChildNodeCheck = false;
//            countNode++;
//        }
//        if(
//    }
//}

function displayProject(tabProjectCheckToDispay) {
   
    var i=0;
    while (tabProjectCheckToDispay['Projects'].length - i) {
        if (tabProjectCheckToDispay['Projects'][i] != "")
            document.getElementById("hiddenCheckedProjectList").value += tabProjectCheckToDispay['Projects'][i]+";";
            //getActivityFromProjectId(tabProjectCheckToDispay['Projects'][i]);
        i++;
    }
    //getAllChildProject();
}

function getChildProjectCallback(result) {
    var val =document.getElementById("hiddenActivitiesIdChecked").value;
    var tabActivitiesIdChecked = val.split(';');
    var i = 0;
    var l = tabActivitiesIdChecked.length;
    var queryFilter = "";
    while (l - i) {
        queryFilter += " or Id eq guid'" + tabActivitiesIdChecked[i] + "'";
        i++;
    }
    queryFilter = queryFilter.substr(15, queryFilter.length);
    var query = "Id eq guid'" + queryFilter;

    var tabProjectIdChecked = result.split(';');
    i = 0;
    l = tabActivitiesIdChecked.length;
    queryFilter = "";
    while (l - i) {
        queryFilter += " or ProjectId eq guid'" + tabActivitiesIdChecked[i] + "'";
        i++;
    }
    query += queryFilter;
    qbActivities.set_filter(query);
    proxy.query(qbActivities.toString(), onSuccess, onFailure);
}

function refreshDisplayProject() {
    tabProjectDisplay = [];
    tabActivityDisplay = [];
    
    tabProjectCheckToDispay = new Array('Projects', 'Activities');
    tabProjectCheckToDispay['Projects'] = tabProjectDisplay;
    tabProjectCheckToDispay['Activities'] = tabActivityDisplay;
}

