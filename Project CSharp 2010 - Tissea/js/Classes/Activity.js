function Activity(query) {
    this.customerId = query.CustomerId;
    this.id = query.Id ;
    this.activityId = query.ActivityId ;
    this.name =query.Name ;
    this.workflowState = query.WorkflowState;
    this.moduleName = query.ModuleName  ;
    this.programmeName = query.ProgrammeName  ;
    this.categoryName = query.CategoryName  ;
    this.description =  query.Description ;
    this.planningOrder = query.PlanningOrder  ;
    this.startedDateTime = query.StartedDateTime  ;
    this.locationName = query.LocationNme  ;
    this.latitude = query.Latitude  ;
    this.longitude = query.Longitude;
    this.workflowString = this.workflowToString(this.workflowState);
    var dateYet = new Date().getTime();
    var dueDate = query.DueDateTime.getTime();
    var test = dueDate - dateYet;
    if (test / (1000 * 60 * 60 * 24) <= 1 || dueDate<dateYet || query.Critical)
        this.critical = true;
    else
        this.critical = false;
}

Activity.prototype.workflowToString = function(val) {
    if (val <= 4)
        return "Unplanned";
    if (val == 6)
        return "Planned";
    if (val == 7)
        return "Started";
    return "Default";
}

