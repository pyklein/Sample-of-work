/*
* @autor Julien Pierre, Klein Pierre-yves
* File Name : ActivitiesDisplayMarker
* This file contains the functions who could be used in order to
* display marker and MaxContentTabs for the Activities.
* The function who are used for AtivitiesDisplayMarker and LocationsDiaplayMarker
* are in Default
* File calls from Default
*/


/*
* Function requestGetLocation()
* No argument
* This function modify queryFilter depending what check box is checked
*/
function requestGetLocation() {

    closeAdvancedSearch();
    //document.getElementById("txtSearchMap").value = "";
    goLocation = false;
    search = false;
    goAct = false;
    currentMarkerType = "";
    if (ckb132.checked) {
        lookup();
        if (queryFilter != "") {
            queryFilter += " or ";
        }
        queryFilter += "SubstationTypeName eq 'Grid'";
        currentMarkerType = MarkerType.Location;
        
    }

    if (ckb11.checked) {
        lookup();
        if (queryFilter != "") {
            queryFilter += " or ";
        }
        queryFilter += "SubstationTypeName eq 'Secondary'";
        currentMarkerType = MarkerType.Location;
    }

    if (ckb33.checked) {
        lookup();
        if (queryFilter != "") {
            queryFilter += " or ";
        }
        queryFilter += "SubstationTypeName eq 'Primary'";
        currentMarkerType = MarkerType.Location;
    }

}

/*
* Function ckbReact_onclick()
* No argument
* This function is used when the checkbox ckbReact is clicked
* Event Listener for ckb132
*/
function ckb132_onclick() {
    currentMarkerType = MarkerType.Location;
    closeAdvancedSearch();
    ExecuteQuery();
    //selectAzBooks();
}

/*
* Function ckbReact_onclick()
* No argument
* This function is used when the checkbox ckbReact is clicked
* Event Listener for ckb33
*/
function ckb33_onclick() {
    currentMarkerType = MarkerType.Location;
    closeAdvancedSearch();
    ExecuteQuery();
    //selectAzBooks();
}

/*
* Function ckbReact_onclick()
* No argument
* This function is used when the checkbox ckbReact is clicked
* Event Listener for ckb11
*/
function ckb11_onclick() {
    currentMarkerType = MarkerType.Location;
    closeAdvancedSearch();
    ExecuteQuery();
    //selectAzBooks();
}

/*
* detailTabLocation(resQuery)
* Select the diferents characteristics whose have to be displaied
* @param resQuery : response from the Default.aspx request
*/


function GoLocation() {
    currentMarkerType = MarkerType.Location;
    closeAdvancedSearch();
    refreshMap();
    closeTab();
    search = true;
    disabled(queryFilter);
    goLocation = true;
    ckb33.checked = false;
    ckb132.checked = false;
    ckb11.checked = false;
    ckbQuote.checked = false;
    ckbReact.checked = false;
    ckbRecurrent.checked = false;
    queryFilter = "Id eq guid'" + cbxLocations._value + "'";    
    qbLocations.set_filter(queryFilter);
    proxy.query(qbLocations.toString(), onSuccess, onFailure);
}