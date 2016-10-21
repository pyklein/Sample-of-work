function Task(query) {
    this.activityGuid = query.ActivityGuid;
    this.activityId = query.ActivityId ;  
    this.productId = query.ProductId ;  
    this.productName = query.ProductName ;  
    this.stockCode = query.StockCode ;  
    this.quantityOrdered = query.QuantityOrdered ;  
    this.unitPrice = query.UnitPrice ;  
    this.netAmount = query.NetAmount ; 
    this.description = query.Description;
    this.comment1= query.Comment1;
    this.comment2= query.Comment2;      
}
function setTask(id, coordinatorUsername, startDateTime, endDateTime, activityId) {
    //DivSetTask
    $("#grise").stop(true, true).delay(1).slideDown(1);
    document.getElementById("hiddenTaskId").value = id;
    document.getElementById("grise").style.visibility = "visible";
    document.getElementById("lblActivityId").innerHTML = activityId;
    if (startDateTime) {

        startDateTime = new Date(startDateTime);
        radDatePickerStartTask._setInputDate(startDateTime);
    }
    if (endDateTime) {
        endDateTime = new Date(endDateTime);
        radDatePickerEndTask._setInputDate(endDateTime);
    }
    document.getElementById("DivSetTask").style.visibility = "visible";
    $("#DivSetTask").stop(true, true).delay(10).slideDown(250);
    //radComboBoxCoordinator.set_selectedItem(b);    
}


function closeSetTask() {

    $("#grise").stop(true, true).delay(1).slideUp(1);
    $("#DivSetTask").stop(true, true).delay(10).slideUp(250);
}


function saveTask() {
    if (document.getElementById("hiddenTaskId").value)
        $.post("/_common/handlers/Tasks/SetTaskHandler.ashx", $("form").serialize(),setTaskCallback);
    else {
        closeSetTask();
        document.getElementById("logAlert").style.borderColor = "red";
        document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logWarningMessage.png\" alt=\"valid\" width=\"30%\"/></td><td VALIGN:middle style='color:red;'><b>&nbsp; Error try later</b></td></tr>";
        document.getElementById("logAlert").style.visibility = "visible";
        $("#logAlert").stop(true, true).delay(1).slideDown(250);
        closelogalert();

    }
}
function setTaskCallback(result) {
    closeSetTask();
    closeTab();
    if (result == " success") {
        document.getElementById("logAlert").style.borderColor = "green";
        document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logValidMessage.png\" alt=\"valid\" width=\"30%\"/></td><td VALIGN:middle style='color:green;'><b>&nbsp;You have successfully task update</b></td></tr>";
        document.getElementById("logAlert").style.visibility = "visible";
        $("#logAlert").stop(true, true).delay(10).slideDown(250);
        closelogalert();
        
    }
}