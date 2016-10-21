function calculRoadClosest(tabDistance,bool) {
    var indexAdd = new Array();
    var finalRoad = new Array();
    finalRoad[0] = erpMarkerAddCollection.arrayErpMarker[indiceIDistanceMax].getCoordinateObject();
    indexAdd[0] = erpMarkerAddCollection.arrayErpMarker[indiceJDistanceMax].listIndex;
    var current = indiceJDistanceMax;
    var cmpt = 1;
    while (cmpt != erpMarkerAddCollection.length() - 1) {
        var indiceShorterMaxDistance = getMaxDistance(tabDistance, current);
        indexAdd[cmpt] = erpMarkerAddCollection.arrayErpMarker[indiceShorterMaxDistance].listIndex;
        finalRoad[cmpt] = erpMarkerAddCollection.arrayErpMarker[indiceShorterMaxDistance].getCoordinateObject();
        tabDistance = clearCurrent(tabDistance, current);
        current = indiceShorterMaxDistance;
        cmpt++;
    }
    cmpt = addLast(indexAdd);
    finalRoad[finalRoad.length] = erpMarkerAddCollection.arrayErpMarker[cmpt].getCoordinateObject();
    indexAdd[indexAdd.length] = erpMarkerAddCollection.arrayErpMarker[cmpt].listIndex;
}