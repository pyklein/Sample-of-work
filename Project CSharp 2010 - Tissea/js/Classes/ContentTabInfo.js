﻿function ContentTabInfo(type) {
    this.htmlTasks = "";
    this.htmlDetails = "";
    this.summary = "";
    this.smallInfo = "";
    this.type = type;
    this.tabs = [];
    this.htmlWorkTimes = "";
}

ContentTabInfo.prototype.init = function(erpMarker) {
    erpMarker.tab.completeHtmlDetails(erpMarker.object);
    if (erpMarker.type == 0) {
        this.summary = '<i>Id : ' + erpMarker.object.activityId + '</i>';
        this.completeSmallInfo(erpMarker);
        var queryFilterActivitieTab = BuildQueryActivities(erpMarker);
        this.ExecuteQueryForTab(queryFilterActivitieTab, erpMarker);
    }
    else {
        if (this.type == 1) {
            this.summary = erpMarker.object.name;
            this.smallInfo = erpMarker.object.name;
            this.completeHtmlDetails(erpMarker.object);
            htmlWorkTimesG = "<i> Undefined for Location</i>";
            htmlTasksG = "<i> Undefined for Location</i>";
        }
    }
}

ContentTabInfo.prototype.completeSmallInfo = function(erpMarker) {
    this.smallInfo = ' ' + erpMarker.object.activityId + '<br />';
    this.smallInfo += ' ' + erpMarker.object.name + '<br />';
    this.smallInfo += ' ' + erpMarker.object.workflowString + '<br />';
    this.smallInfo += '<span style=\'color:red;\' > ' + erpMarker.object.moduleName + '</span><br />';
    this.smallInfo += '<span style=\'color:green;\'> ' + erpMarker.object.programmeName + '</span><br />';
    this.smallInfo += '<span style=\'color:blue;\' > ' + erpMarker.object.categoryName + '</span><br /> ';
    var check = "";
    if (erpMarker.inList)
        check = "CHECKED";
    this.smallInfo += "</table><span style=\"font-style:italic;\" >Add to the list <input id='" + erpMarker.id + "' type='checkbox' onclick='addOrDelToList(" + erpMarker.index + ",\"\");'   value='Grid' " + check + "/></span>";
}

ContentTabInfo.prototype.completeHtmlDetails = function(object) {
    var htmlDetail;
    if (this.type == 0) {
        htmlDetail = '<table width=\'100%\' cellpadding=\'2\' cellspacing=\'0\'>';
        htmlDetail += '<tr><td>Name:</td><td>' + object.name + '</td></tr>';
        htmlDetail += '<tr><td>Module:</td><td>' + object.moduleName + '</td></tr>';
        htmlDetail += '<tr><td>Description:</td><td>' + object.description + '</td></tr>';
        htmlDetail += '<tr><td>Planning order:</td><td>' + object.planningOrder + '</td></tr>';
        htmlDetail += '<tr><td>Started date time:</td><td>' + object.startedDateTime + '</td></tr>';
        htmlDetail += '<tr><td>Location name:</td><td>' + object.locationName + '</td></tr>';
        htmlDetail += '<tr><td>Status:</td><td>' + object.workflowString + '</td></tr>';
        htmlDetail += '</table>';
    }
    if (this.type == 1) {
        htmlDetail = '<table width=\'100%\' cellpadding=\'2\' cellspacing=\'0\'>';
        htmlDetail += '<tr><td>X Grid:</td><td>' + object.xGridNumber + '</td></tr>';
        htmlDetail += '<tr><td>Y Grid:</td><td>' + object.yGridNumber + '</td></tr>';
        htmlDetail += '<tr><td>Longitude:</td><td>' + object.longitude + '</td></tr>';
        htmlDetail += '<tr><td>Latitude:</td><td>' + object.latitude + '</td></tr>';
        htmlDetail += '<tr><td>Line 1:</td><td>' + object.line1 + '</td></tr>';
        htmlDetail += '<tr><td>Line 2:</td><td>' + object.line2 + '</td></tr>';
        htmlDetail += '<tr><td>Line 3:</td><td>' + object.line3 + '</td></tr>';
        htmlDetail += '<tr><td>Line 4:</td><td>' + object.line4 + '</td></tr>';
        htmlDetail += '<tr><td>Postcode:</td><td>' + object.postcode + '</td></tr>';
        htmlDetail += '<tr><td><strong>CR Number</strong>:</td><td>' + object.cRNumber + '</td></tr>';
        htmlDetail += '</table>';
    }
    htmlDetailsG = htmlDetail;
    this.htmlDetails = htmlDetail;
}

ContentTabInfo.prototype.onSuccessActivitiesTasks = function(result, context, operation) {
    htmlTasksG = '<table width=\'100%\' border=\'1\'>\
                     <tr><td>Set Task</td><td>ActivityId</td><td>Stock Code</td><td>Product</td><td>Qty</td><td>Unit Price</td><td>Net</td></tr>\ ';
    for (var i in result) {
        var resQueryTask = result[i];
        htmlTasksG += "<tr><td><input type='button' onclick='setTask(\"" + resQueryTask.Id + "\",\"" + resQueryTask.CoordinatorUsername + "\",\"" + resQueryTask.StartDateTime + "\",\"" + resQueryTask.EndDateTime + "\",\"" + resQueryTask.ActivityId + "\");' value='Set' /></td><td>" + resQueryTask.ActivityId + "</td><td>" + resQueryTask.StockCode + "</td><td>" + resQueryTask.ProductName + "</td><td>" + resQueryTask.QuantityOrdered + "</td><td>" + resQueryTask.UnitPrice + "</td><td>" + resQueryTask.NetAmount + "</td></tr>";
    }
    htmlTasksG += '</table>';
}

ContentTabInfo.prototype.onSuccessActivitiesWorksTime = function(result, context, operation) {
    htmlWorkTimesG = '<table width=\'100%\' border=\'1\'>\
                     <tr><td>Date Time</td><td>Time Spent</td><td>Qty</td><td>Unit Price</td><td>Net</td></tr>\ ';
    var lineColor;
    for (var i in result) {
        var resQueryWorktimes = result[i];
        if (resQueryWorktimes.Enabled)
            lineColor = '#33CC00';
        else if (resQueryWorktimes.Archived)
            lineColor = '#FF6600';
        else if (resQueryWorktimes.Deleted)
            lineColor = '#FF3300';
        else {
            lineColor = 'white';
        }
        htmlWorkTimesG += '<tr BGCOLOR=' + lineColor + '><td>' + resQueryWorktimes.DateTime + '</td><td>' + resQueryWorktimes.TimeSpend + '</td></tr>';
    }
    htmlWorkTimesG += '</table>';
}

ContentTabInfo.prototype.ExecuteQueryForTab = function(queryFilterActivitieTab, erpMarker) {
    qbTasks.set_filter(queryFilterActivitieTab);
    proxy.query(qbTasks.toString(), this.onSuccessActivitiesTasks, onFailureActivities);
    qbWorkTimes.set_filter(queryFilterActivitieTab);
    proxy.query(qbWorkTimes.toString(), this.onSuccessActivitiesWorksTime, onFailureActivities);
    
}

ContentTabInfo.prototype.completeTab = function() {
    this.htmlWorkTimes = htmlWorkTimesG;
    this.htmlTasks = htmlTasksG;
    this.htmlDetails = htmlDetailsG;
    
    
//    if (this.type == MarkerType.Location) {
//        this.tabs = [
//                    new MaxContentTab('Details', this.htmlDetails)
//                 ];
//    }
//    if (this.type == MarkerType.Activity) {
//        this.tabs = [
//                  new MaxContentTab('Details', this.htmlDetails),
//                  new MaxContentTab('Tasks', this.htmlTasks),
//                  new MaxContentTab('Work Times', this.htmlWorkTimes)
//                ];
//    }
}