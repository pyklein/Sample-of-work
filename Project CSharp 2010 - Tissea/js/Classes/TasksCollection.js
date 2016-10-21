function TasksCollection() {
    this.arrayTaks = new Array();
}

TasksCollection.prototype.length = function() {
    return this.arrayTaks.length;
}

TasksCollection.prototype.toEmpty = function() {
    this.arrayTaks = new Array();
}