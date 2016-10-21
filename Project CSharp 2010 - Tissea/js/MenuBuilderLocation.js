var currentCounties;
//var currentmodName;
//var currentRowIdnext;


function showRefSerachLocation(id, idchg) {
   
    qbCounties = new AjaxSys.Data.AdoNetQueryBuilder("Counties");
    qbCounties.set_orderby("Name");
    var displayId = "#" + id;
    if ($(displayId).is(":hidden") || document.getElementById(id).style.visibility == "hidden") {
        //closeAdvancedSerach();
        if (currentSearch == "activity") {
            document.getElementById("plusActAdvanced").innerHTML = "[+]";
            while (document.getElementById("tBodyAdvancedActSearch").firstChild) {
                document.getElementById('tBodyAdvancedActSearch').removeChild(document.getElementById("tBodyAdvancedActSearch").firstChild);
            }
            document.getElementById("choiceDisplaySearchActivity").style.visibility = "hidden";
        }
            currentSearch = "location";
        
        document.getElementById(idchg).innerHTML = "[-]"; //CustomerName
        proxy.query(qbCounties.toString(), onSuccessSearchAdvancedLocation, onFailure);
        document.getElementById(id).style.visibility = "visible";
        $(displayId).stop(true, true).delay(500).slideDown(500);
        
        
    }
    else {
        document.getElementById(id).style.visibility = "hidden";
        currentSearch = "";
        document.getElementById(idchg).innerHTML = "[+]";
        $(displayId).stop(true, true).delay(50).slideUp(510);
        while (document.getElementById("tBodyAdvancedLocationSearch").firstChild) {
            document.getElementById('tBodyAdvancedLocationSearch').removeChild(document.getElementById("tBodyAdvancedLocationSearch").firstChild);
        }

    }
}

function displayScroolLocation() {
    if (document.getElementById("tBodyAdvancedLocationSearch").children.length >= 15) {
        document.getElementById('plusLocationAdvanced').style.overflow = "auto";
        document.getElementById('plusLocationAdvanced').style.height = "400px";
    }
    else {
        document.getElementById('plusLocationAdvanced').style.height = "auto";
    }
}


function onSuccessSearchAdvancedLocation(result, context, operation) {
    var count = 0;
    var lastRow;
    for (var i in result) {

        var resQuery = result[i];
        if (result[i].Name != "undefined" && result[i].Name != null) {
            count++
            var tbl = document.getElementById('tBodyAdvancedLocationSearch');
            if (tbl.rows != null)
                lastRow = tbl.rows.length;
            else
                lastRow = 0;
            var iteration = lastRow;
            var row = document.createElement('TR');
            row.id = "counties" + i;
            row.name = result[i].Name;
            tbl.appendChild(row);
            var cellImg = document.createElement('TD');
            cellImg.id = "loccounties" + i;
            cellImg.name = result[i].Name;
            cellImg.innerHTML = "<img src=\"Resources/icons/tree/plus1.gif\" />";
            cellImg.onclick = function() { currentCounties = this.id; ChangeImg(this.id); ckbAllcheckListSearchFunc(); addOrDelChildLoc("loc", this.id, this.name, row.id);displayScrool() };
            var cellCkb = document.createElement('TD');
            var idCkb = i;
            cellCkb.innerHTML = '<input value="' + row.name + '" id="ckbSearchLoc' + i + '" type="checkbox" onclick="ckbAllcheckListSearchFunc();ckbListSearchFunc(\'' + idCkb + '\');displayScrool()" />';
            var cellName = document.createElement('TD');
            cellName.innerHTML = "<NOBR>"+result[i].Name+"</NOBR>";
            cellName.colSpan=4;
            row.appendChild(cellImg);
            row.appendChild(cellName);
        };
    }
    var row = document.createElement('TR');
    row.id = "counties" + count;
    tbl.appendChild(row);
    displayScroolLocation();
}

function ChangeImg(id) {
    var str = id.toString();
    var strImg = document.getElementById(str).innerHTML;
    if (strImg == "<IMG src=\"Resources/icons/tree/plus1.gif\">") {
        document.getElementById(str).innerHTML = "<img src=\"Resources/icons/tree/minus1.gif\" />";
    }
    else {
        document.getElementById(str).innerHTML = "<img src=\"Resources/icons/tree/plus1.gif\" />";
    }
    if (document.getElementById("tBodyAdvancedLocationSearch").children.length >= 15) {
        document.getElementById('plusLocationAdvanced').style.overflow = "auto";
        document.getElementById('plusLocationAdvanced').style.height = "400px";
    }
    else {
        document.getElementById('plusLocationAdvanced').style.height = "auto";
    }

}

function openTreeLoca() {
    qbLocationTypes = new AjaxSys.Data.AdoNetQueryBuilder("LocationTypes");
    qbLocationTypes.set_orderby("Name");
    proxy.query(qbLocationTypes.toString(), onSuccessSearchAdvancedLocationTypes, onFailure);
}

function onSuccessSearchAdvancedLocationTypes(result, context, operation) {
    var i = 0;
    var count = 1; 
    var resTypeNameBefore = "";
    for (var i in result) {
        var resQuery = result[i];
        if (i == 0 && resQuery.Name) {
            addType(resQuery.Name, count);
            count++;
        }
        if (result[i].Name != resTypeNameBefore && i >= 1 && resQuery.Name) {
            addType(resQuery.Name, count);
            count++;
        }

        resTypeNameBefore = result[i].Name;
    }
}

function addType(typeName, count) {
    var placeInTab = currentCounties.substr(11);
    var row = document.createElement('TR');
    row.id = "rowLoc" + placeInTab + "." + count;
    row.name = typeName;
    var tbl = document.getElementById('tBodyAdvancedLocationSearch');
    var cellEmpty = document.createElement('TD');
    cellEmpty.innerHTML = "<img src=\"Resources/icons/tree/empty.gif\" />";
    var cellPlus = document.createElement('TD');
    cellPlus.id = typeName + placeInTab + "." + count;
    cellPlus.innerHTML = "<img src=\"Resources/icons/tree/line2.gif\" />";
    var cellCkb = document.createElement('TD');
    var idCkb = placeInTab + '.' + count;
    cellCkb.innerHTML = '<input value="' + row.name + '" id="ckbSearchLoc' + placeInTab + '.' + count + '" type="checkbox" onclick="ckbListSearchFunc(\'' + idCkb + '\');"/>';
    var cellName = document.createElement('TD');
    cellName.innerHTML = "<NOBR>"+typeName+"</NOBR>";
    cellName.colSpan = 3;
    row.appendChild(cellEmpty);
    row.appendChild(cellPlus);
    row.appendChild(cellCkb);
    row.appendChild(cellName);
    placeInTab++;
    $(row).insertAfter(document.getElementById(currentCounties.substr(3)));
//    if (document.getElementById("counties" + placeInTab))
//        tbl.insertBefore(row, document.getElementById(placeInTab.substr(3)));
//    else {
//        tbl.parentNode.insertBefore(row, document.getElementById(placeInTab.substr(3)));
//    }
}


function addOrDelChildLoc(str, id, name, rowId) {
    if (document.getElementById("rowLoc" + parseInt(id.substr(11)) + "." + 1)) {
        deleteChild("rowLoc" + parseInt(id.substr(11)),"tBodyAdvancedLocationSearch");
    }
    else {
          
            openTreeLoca();
    }
}


function ckbAllcheckListSearchFunc() {
 
    var cmptType = 1;
    var cmptCounties = 1;
   
    var boolCheck = true;
    while (document.getElementById("ckbSearchLoc" + cmptType) && boolCheck) {
        cmptCounties=1;
        if (document.getElementById("ckbSearchLoc" + cmptType).checked) {
            while (document.getElementById("ckbSearchLoc" + cmptType + "." + cmptCounties)) {
                document.getElementById("ckbSearchLoc" + cmptType + "." + cmptCounties).checked = true;
            }                
        }
        cmptProg++;
    }
}

function ckbListSearchFunc(idckb) {

    
    var idckbbis = idckb;
    var countyCurrent = idckbbis.substr(0, idckbbis.indexOf('.'));
    idckbbis = idckbbis.substr(idckbbis.indexOf('.') + 1);
    var moduleCurrent = idckbbis.substr(0, idckbbis.indexOf('.'));
    idckbbis = idckbbis.substr(idckbbis.indexOf('.') + 1);
    var typeCurrent = idckbbis.substr(0, idckbbis.indexOf('.'));
    
    var boolCheck = true;

    var cmptType = 1;
    if(document.getElementById("ckbSearchLoc" + countyCurrent)){
        while (document.getElementById("ckbSearchLoc" + countyCurrent + "." + cmptType) && boolCheck) {
            if (document.getElementById("ckbSearchLoc" + countyCurrent + "." + cmptType).checked) {
            }
            else {
                boolCheck = false;
                document.getElementById("ckbSearchLoc" + countyCurrent).checked = false;
            }
            cmptProg++;
        }
        if (boolCheck) {
            document.getElementById("ckbSearchLoc" + countyCurrent).checked = true;
        }
    }
}
    