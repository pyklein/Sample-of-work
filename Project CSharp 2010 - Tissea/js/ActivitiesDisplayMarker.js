/*
* @author : Klein Pierre-yves
* File Name : ActivitiesDisplayMarker
* This file contains the functions who could be used in order to
* display marker and MaxContentTabs for the Activities.
* The function who are used for AtivitiesDisplayMarker and LocationsDiaplayMarker
* are in Default
* File calls from Default
*/
 
//Database views who are used


//Content all the informations for the ActivityTabs
var htmlTasks, smallInfo, summary, htmlDetails, htmlWorkTimes;
var markerTemp;
var query;
var panoClient;
var test;
/*
* Function requestGetActivities()
* No argument
* This function modify queryFilter depending what check box is checked
*/
function requestGetActivities() {
    //    if (ckbFinished.checked)
    //        filter = "and Completed eq false";

    searchMap_text.value = "";


    if (ckbReact.checked) {
        goLocation = false;
        lookup();

        if (queryFilter != "") {
            queryFilter += " or ";
        }
        queryFilter += "ModuleName eq 'REACTIVE' and Enabled eq true and Archived eq false and Deleted eq false and Completed eq false";
        currentMarkerType = MarkerType.Activity;
    }

    if (ckbRecurrent.checked) {
        goLocation = false;
        lookup();

        if (queryFilter != "") {
            queryFilter += " or ";
        }
        queryFilter += "ModuleName eq 'RECURRENT' and Enabled eq true and Archived eq false and Deleted eq false and Completed eq false ";
        currentMarkerType = MarkerType.Activity;
    }
    if (ckbQuote.checked) {
        goLocation = false;
        lookup();

        if (queryFilter != "") {
            queryFilter += " or ";
        }
        queryFilter += "ModuleName eq 'QUOTE' and Enabled eq true and Archived eq false and Deleted eq false and Completed eq false ";
        currentMarkerType = MarkerType.Activity;
    }
}



/*
* Function ckbReact_onclick()
* No argument
* This function is used when the checkbox ckbReact is clicked
*/
function ckbReact_onclick() {
    currentMarkerType = MarkerType.Activity;
    closeAdvancedSearch();
    ExecuteQuery();
    //selectAzBooks();
  }

/*
* Function ckbRecurrent_onclick()
* No argument
* This function is used when the checkbox ckbRecurrent is clicked
*/        
function ckbRecurrent_onclick() {
    closeAdvancedSearch();
    ExecuteQuery();
    //selectAzBooks();
}
 
/*
* Function ckbQuote_onclick()
* No argument
* This function is used when the checkbox ckbQuote is clicked
*/
function ckbQuote_onclick() {
    currentMarkerType = MarkerType.Activity;
    closeAdvancedSearch();
    ExecuteQuery();
    //selectAzBooks();
}


function onFailureActivities(error, context, operation) {
    htmlTasks += "<tr><td colspan=5 style='text-align: center;'>Query Problem - Could not retrieve Tasks for this Activity</td><td>";
    htmlTasks += "</table>";
    htmlTaskDone = true;
}

function GoActivity() {
    if (activitySearch.get_value() != "Activity Id") {
        closeAdvancedSearch();
        //searchMap_text.value = "";
        lookup();
        refreshMap();
        closeTab();
        search = true;
        goLocation = false;
        currentMarkerType = MarkerType.Activity;
        queryFilter = "";
        var actId = activitySearch.get_value().toString() + ";";
        if (actId.indexOf(",")) {
            queryFilter += "ActivityId eq " + actId.substring(0, actId.indexOf(";")) + " ";
            actId = actId.substring(actId.indexOf(";") + 1, actId.length);
            goAct = true;
        }
        while (actId.length > 1) {
            goAct = false;
            queryFilter += "or ActivityId eq " + actId.substring(0, actId.indexOf(";")) + " ";
            actId = actId.substring(actId.indexOf(";") + 1, actId.length);

        }

        qbActivities.set_filter(queryFilter);
        qbActivities.set_orderby('Latitude');
        proxy.query(qbActivities.toString(), onSuccess, onFailure);
        activitySearch.set_value("Activity Id");
        searchMap_text.value = "Location name";
        disabled(queryFilter);
        search = false;
    }
}

