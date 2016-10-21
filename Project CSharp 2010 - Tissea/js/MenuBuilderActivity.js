var currentcust;
var currentmodName;
var currentRowIdnext;
var optimise="";
function showRefSerach(id, idchg,str) {
    displayScrool();
    if(str=="opti")
    optimise = "and PlannedDateTime eq null and PlanningOrder eq null and Planned eq false";
    qbCustomers = new AjaxSys.Data.AdoNetQueryBuilder("Customers");
    var displayId = "#" + id;
    if ($(displayId).is(":hidden") || document.getElementById(id).style.visibility=="hidden") {
        if (currentSearch == "location") {
            document.getElementById("plusLocAdvanced").innerHTML = "[+]";
            while (document.getElementById("tBodyAdvancedLocationSearch").firstChild) {
                document.getElementById('tBodyAdvancedLocationSearch').removeChild(document.getElementById("tBodyAdvancedLocationSearch").firstChild);
            }
            document.getElementById("choiceDisplaySearchLocation").style.visibility = "hidden";
        }
            currentSearch = "activity";
        
        document.getElementById(idchg).innerHTML = "[-]"; //CustomerName
        proxy.query(qbCustomers.toString(), onSuccessSearchAdvanced, onFailure);
        document.getElementById(id).style.visibility = "visible";
        $(displayId).stop(true, true).delay(500).slideDown(100);
        
        
    }
    else {
        document.getElementById(id).style.visibility = "hidden";
        currentSearch = "";
        document.getElementById(idchg).innerHTML = "[+]";
        $(displayId).stop(true, true).delay(50).slideUp(510);
        while (document.getElementById("tBodyAdvancedActSearch").firstChild) {
            document.getElementById('tBodyAdvancedActSearch').removeChild(document.getElementById("tBodyAdvancedActSearch").firstChild);
        }

    }
 
}

function onSuccessSearchAdvanced(result, context, operation) {
    var count = 0;
    var lastRow;
    for (var i in result) {

        var resQuery = result[i];
        if (result[i].Name != "undefined" && result[i].Name != null) {
            count++
            var tbl = document.getElementById('tBodyAdvancedActSearch');
            if (tbl.rows != null)
                lastRow = tbl.rows.length;
            else
                lastRow = 0;

            var iteration = lastRow;
            var row = document.createElement('TR');
            row.id = "cust" + i;
            row.name = result[i].Name;
            tbl.appendChild(row);
            var cellImg = document.createElement('TD');
            cellImg.id = "custom" + i;
            cellImg.name = result[i].Name;
            cellImg.innerHTML = "<img src=\"Resources/icons/tree/plus1.gif\" />";
            cellImg.onclick = function() { ChangeImg(this.id); addOrDelChild("", this.id, this.name, row.id); displayScrool(); };
            var cellName = document.createElement('TD');
            cellName.innerHTML = "<NOBR>"+result[i].Name+"</nobr>";
            cellName.colSpan=5;
            row.appendChild(cellImg);
            row.appendChild(cellName);
        };
    }
    var row = document.createElement('TR');
    row.id = "cust" + count;
    tbl.appendChild(row);
}

function addOrDelChild(str, id, name, rowId) {
    if (document.getElementById(str + "row" + parseInt(id.substr(6)) + "." + 1)) {
        deleteChild(str + "row" + parseInt(id.substr(6)),"tBodyAdvancedActSearch");
    }
    else {
           openTree(id, name);
       }
      
}

function deleteChild(id,tbodyId) {
    var cmpt = 1;
    var cmptProg = 1;
    var cmptCat = 1;
    while (document.getElementById(id + "." + cmpt)) {
        cmptProg = 1;
        while (document.getElementById(id + "." + cmpt + "." + cmptProg)) {
            cmptCat = 1;
            while (document.getElementById(id + "." + cmpt + "." + cmptProg + "." + cmptCat)) {
                document.getElementById(tbodyId).removeChild(document.getElementById(id + "." + cmpt + "." + cmptProg + "." + cmptCat));
                cmptCat++;
            }
            document.getElementById(tbodyId).removeChild(document.getElementById(id + "." + cmpt + "." + cmptProg));
            cmptProg++;
        }
        document.getElementById(tbodyId).removeChild(document.getElementById(id + "." + cmpt));
        cmpt++;
    }
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
    

}

function displayScrool() {
    if (document.getElementById("tBodyAdvancedActSearch").children.length >= 15) {
        document.getElementById('treeDiv1').style.overflow = "auto";
        document.getElementById('treeDiv1').style.height = "400px";
    }
    else {
        document.getElementById('treeDiv1').style.height = "auto";
    }
}

function openTree(id, nameCust) {
    createTrTypaAct(id, 1, "Reactive", nameCust);
    createTrTypaAct(id, 2, "Recurrent", nameCust);
    createTrTypaAct(id, 3, "Quote", nameCust);
}


function addOrDelChildAct(id, custId, modName) {
    if (document.getElementById(id + "." + 1)) {
        deleteChild(id, "tBodyAdvancedActSearch");
    }
    else {
        openLastBranch(id, custId, modName);
    }
    displayScrool();  
}




function createTrTypaAct(id, i, type, nameCust) {
    var placeInTab = parseInt(id.substr(6));
    var row = document.createElement('TR');
    row.id = "row" + placeInTab + "." + i;
    row.name = type;
    var tbl = document.getElementById('tBodyAdvancedActSearch');
    var cellEmpty = document.createElement('TD');
    cellEmpty.innerHTML = "<img src=\"Resources/icons/tree/empty.gif\" />";
    var cellPlus = document.createElement('TD');
    cellPlus.id = type + placeInTab + "." + i;
    cellPlus.name = nameCust;
    cellPlus.innerHTML = "<img src=\"Resources/icons/tree/plus1.gif\" />";
    cellPlus.onclick = function() { ChangeImg(this.id); addOrDelChildAct(row.id, this.name, row.name);displayScrool(); };
    var cellCkb = document.createElement('TD');
    var idCkb = placeInTab + '.' + i;
    cellCkb.innerHTML = '<input value="' + row.name + '" id="ckbSearch' + placeInTab + '.' + i + '" type="checkbox" onclick="typeListSearchFunc(\'' + idCkb + '\');displayScrool(); " />';
    var cellName = document.createElement('TD');
    cellName.innerHTML = "<NOBR>"+type+"</NOBR>";
    cellName.colSpan=3;
    row.appendChild(cellEmpty);
    row.appendChild(cellPlus);
    row.appendChild(cellCkb);
    row.appendChild(cellName);
    placeInTab++;
    if (document.getElementById("cust" + placeInTab))
        tbl.insertBefore(row, document.getElementById("cust" + placeInTab));
    else {
        tbl.parentNode.insertBefore(row, document.getElementById("cust" + placeInTab));
    }
    
}



/**--------------------------------------------**/
function openLastBranch(id, custId, modName) {
    currentRowId = id;
    currentcust = custId;
    currentmodName = modName;
    qbMPCSimple = new AjaxSys.Data.AdoNetQueryBuilder("vwMPCSimple");
    queryFilter = "CustomerName eq '" + custId + "' and ModuleName eq '" + modName + "'";
    qbMPCSimple.set_orderby("ProgrammeName");
    qbMPCSimple.set_filter(queryFilter);
    proxy.query(qbMPCSimple.toString(), onSuccessSearchAdvancedProgrammeName, onFailure);
}


function onSuccessSearchAdvancedProgrammeName(result, context, operation) {
    var i = 0;
    var count = 1;
    var resProgNameBefore = "";
    for (var i in result) {
        var resQuery = result[i];

        if (i == 0 && resQuery.ProgrammeName) {
            addProg(resQuery.ProgrammeName, count);
            count++;
        }
        if (result[i].ProgrammeName != resProgNameBefore && i >= 1 && resQuery.ProgrammeName) {
            addProg(resQuery.ProgrammeName, count);
            count++;
        }

        resProgNameBefore = result[i].ProgrammeName;
    }
   displayScrool();
}


function addProg(progName, count) {
    var row = document.createElement('TR');
    row.id = currentRowId + "." + count;
    row.name = progName;
    var tbl = document.getElementById('tBodyAdvancedActSearch');
    var cellEmpty = document.createElement('TD');
    cellEmpty.innerHTML = "<img src=\"Resources/icons/tree/empty.gif\" />";
    var cellEmptyBis = document.createElement('TD');
    var cellPlus = document.createElement('TD');
    cellPlus.id = currentRowId + "." + progName + "." + count;
    cellPlus.innerHTML = "<img src=\"Resources/icons/tree/plus1.gif\" />";
    cellPlus.onclick = function() { ChangeImg(cellPlus.id); addOrDelChildCat(row.id, row.name);displayScrool(); };
    var cellCkb = document.createElement('TD');
    var check = "";
    if (document.getElementById("ckbSearch" + currentRowId.substr(3)).checked) {
        check = "checked";
    }
    var idckb = row.id;
    cellCkb.innerHTML = '<input value="' + row.name + '" type="checkbox" id="ckbSearch' + row.id.substr(3) + '" onclick="progListSearchFunc(\'' + idckb + '\');displayScrool(); " ' + check + '/>';
    var cellName = document.createElement('TD');
    cellName.colSpan = 2;
    cellName.innerHTML = "<NOBR>"+progName+"</NOBR>";
    row.appendChild(cellEmpty);
    row.appendChild(cellEmptyBis);
    row.appendChild(cellPlus);
    row.appendChild(cellCkb);
    row.appendChild(cellName);
    $(row).insertAfter(document.getElementById(currentRowId));
}

function addOrDelChildCat(id, progName) {
    if (document.getElementById(id + "." + 1)) {
        deleteChild(id, "tBodyAdvancedActSearch");
    }
    else {
        openBranchCat(id, progName);
    }
}


function openBranchCat(id, progName) {
    var idCust = id.substr(3, id.lastIndexOf('.'));
    idCust = idCust.substr(0, idCust.lastIndexOf('.'));
    currentmodName = document.getElementById("ckbSearch" + idCust).value;
    currentRowIdnext = id;
    qbMPCSimple = new AjaxSys.Data.AdoNetQueryBuilder("vwMPCSimple");
    queryFilter = "CustomerName eq '" + currentcust + "' and ModuleName eq '" + currentmodName + "' and ProgrammeName eq '" + progName + "'";
    qbMPCSimple.set_orderby("CategoryName");
    qbMPCSimple.set_filter(queryFilter);
    proxy.query(qbMPCSimple.toString(), onSuccessSearchAdvancedCategorieName, onFailure);
}



function onSuccessSearchAdvancedCategorieName(result, context, operation) {
    var i = 0;
    var count = 1;
    var resCategoryNameBefore = "";
    for (var i in result) {
        var resQuery = result[i];
        if (i == 0 && resQuery.CategoryName) {
            addCat(resQuery.CategoryName, count);
            count++;
        }
        if (resQuery.CategoryName != resCategoryNameBefore && i >= 1 && resQuery.CategoryName) {
            addCat(resQuery.CategoryName, count);
            count++;
        }
        resCategoryNameBefore = result[i].CategoryName;
    }
   displayScrool();
}


function addCat(CategoryName, count) {
    var row = document.createElement('TR');
    row.id = currentRowIdnext + "." + count;
    var tbl = document.getElementById('tBodyAdvancedActSearch');
    var cellEmpty = document.createElement('TD');
    var cellEmptyBis = document.createElement('TD');
    var cellEmptyBisBis = document.createElement('TD');
    cellEmpty.innerHTML = "<img src=\"Resources/icons/tree/empty.gif\" />";
    cellEmptyBis.innerHTML = "<img src=\"Resources/icons/tree/empty.gif\" />";
    cellEmptyBisBis.innerHTML = "<img src=\"Resources/icons/tree/empty.gif\" />";
    var cellPlus = document.createElement('TD');
    cellPlus.Id = "plop" + CategoryName + "." + count.toString();
    cellPlus.innerHTML = "<img src=\"Resources/icons/tree/line2.gif\" />";
    var cellCkb = document.createElement('TD');
    var check = "";
    if (document.getElementById("ckbSearch" + currentRowIdnext.substr(3)).checked) {
        check = "checked";
    }
    var idckb = row.id.substr(3);
    cellCkb.innerHTML = '<input value="' + CategoryName + '" type="checkbox" id="ckbSearch' + idckb + '" onclick="catListSearchFunc(\'' + idckb + '\');displayScrool(); " ' + check + '/>';
    var cellName = document.createElement('TD');
    cellName.innerHTML = "<NOBR>"+CategoryName+"</NOBR>";
    row.appendChild(cellEmpty);
    row.appendChild(cellEmptyBis);
    row.appendChild(cellEmptyBisBis);
    row.appendChild(cellPlus);
    row.appendChild(cellCkb);
    row.appendChild(cellName);
    $(row).insertAfter(document.getElementById(currentRowIdnext));
   
}

function progListSearchFunc(idckb) {//
    if (idckb.substr(0, 3) == "row")
        idckb = idckb.substr(3);
    var customerCurrent = idckb.substr(0, idckb.indexOf('.'));
    idckbbis = idckb.substr(idckb.indexOf('.') + 1);
    var moduleCurrent = idckbbis.substr(0, idckbbis.indexOf('.'));
    var programmeCurrent = idckbbis.substr(idckbbis.indexOf('.') + 1);

    var cmptCust = 1;
    var cmptMod = 1;
    var cmptProg = 1;
    var boolCheck = true;
    var boolModCheck = true;
    cmptProg = 1;
    while (document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent + "." + cmptProg) && boolCheck) {
        if (document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent + "." + cmptProg).checked) {
        }
        else {
            boolCheck = false;
            document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent).checked = false;
        }
        cmptProg++;
    }
    if (boolCheck) {
        document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent).checked = true;
    }

    cmptCust = 1;
    cmptMod = 1;
    cmptProg = 1;
    var cmptCat = 1;
    var boolCheck = false;
    if (document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent + "." + programmeCurrent).checked) {
        boolCheck = true;
    }
    else {
        boolCheck = false;
    }
    while (document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent + "." + programmeCurrent + "." + cmptCat)) {
        document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent + "." + programmeCurrent + "." + cmptCat).checked = boolCheck;
        cmptCat++;
    }

}

function catListSearchFunc(idckb) {
    var idckbbis = idckb;
    if (idckb.substr(0, 3) == "row")
        idckbbis = idckb.substr(3);

    var customerCurrent = idckbbis.substr(0, idckbbis.indexOf('.'));
    idckbbis = idckbbis.substr(idckbbis.indexOf('.') + 1);
    var moduleCurrent = idckbbis.substr(0, idckbbis.indexOf('.'));
    idckbbis = idckbbis.substr(idckbbis.indexOf('.') + 1);
    var programmeCurrent = idckbbis.substr(0, idckbbis.indexOf('.'));

    var cmptCust = 1;
    var cmptMod = 1;
    var cmptProg = 1;
    var boolCheck = true;
    var boolModCheck = true;
    cmptProg = 1;
    while (document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent + "." + programmeCurrent + "." + cmptProg) && boolCheck) {
        if (document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent + "." + programmeCurrent + "." + cmptProg).checked) {
        }
        else {
            boolCheck = false;
            document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent + "." + programmeCurrent).checked = false;
        }
        cmptProg++;
    }
    if (boolCheck) {
        document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent + "." + programmeCurrent).checked = true;
    }


    var cmptCat = 1;
    var cmptMod = 1;
    var cmptProg = 1;
    var boolCheck = true;
    var boolModCheck = true;
    cmptProg = 1;
    while (document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent + "." + programmeCurrent + "." + cmptCat) && boolCheck) {
        if (document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent + "." + programmeCurrent + "." + cmptCat).checked) {
        }
        else {
            boolCheck = false;
            document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent + "." + programmeCurrent).checked = false;
        }
        cmptCat++;
    }
    if (boolCheck) {
        document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent + "." + programmeCurrent).checked = true;
    }
}


function childIsCheck() {
    var fatherId = currentRowId.substr(3).substr(0, 1);
    var bool = false;
    var cmpt = 1;
    while (document.getElementById("ckbSearch" + fatherId + "." + cmpt) && !bool) {
        if (document.getElementById("ckbSearch" + fatherId + "." + cmpt).checked)
            bool = true;
        cmpt++;
    }
    if (document.getElementById("tBodyAdvancedActSearch").children.length >= 15) {
        document.getElementById('treeDiv1').style.overflow = "auto";
        document.getElementById('treeDiv1').style.height = "400px";
    }
    else {
        document.getElementById('treeDiv1').style.height = "auto";
    }
    return bool;
}

function customerListSearchFunc(name) {
}


function typeListSearchFunc(name) {
    var customerCurrent = name.substr(0, name.indexOf('.'));
    name = name.substr(name.indexOf('.') + 1);
    var moduleCurrent = name;
    var cmptCust = 1;
    var cmptMod = 1;
    var cmptProg = 1;
    var cmptCat = 1;
    var boolCheck;

    if (document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent).checked) {
        boolCheck = true;
    }
    else {
        boolCheck = false;
    }
    while (document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent + "." + cmptProg)) {
        document.getElementById("ckbSearch" + customerCurrent + "." + moduleCurrent + "." + cmptProg).checked = boolCheck;
        cmptProg++;
    }
}

