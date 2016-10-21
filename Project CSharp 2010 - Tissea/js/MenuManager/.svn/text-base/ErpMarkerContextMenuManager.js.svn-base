function ErpMarkerContextMenuManager(sender, eventArgs) {
    closeTab();
    var item = eventArgs.get_item();
    var value = item.get_value();
    //alert("item =" + value);
    if (value != null) {
        value += "Eval()";
        eval(value);
    }
}

function addEval(){
    var idMarker = document.getElementById("markerClickId").value;
    var str = erpMarkerCollection.arrayErpMarker[idMarker].inList;
    if (!str)
        addOrDelToList(idMarker, '');

}

function delEval() {
    var idMarker = document.getElementById("markerClickId").value;
    var str = erpMarkerCollection.arrayErpMarker[idMarker].inList;
    if (str)
        addOrDelToList(idMarker, '');
}