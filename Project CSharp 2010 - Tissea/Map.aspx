<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="Map.aspx.cs" Inherits="Connors.Erp.Web.Map" %>

<!--[if IE]>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">  
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- [end if]-->
<%@ Import Namespace="Connors.Framework.Model" %>
<html>
<head runat="server">
    <title>Connor's ERP Map</title>
    <link href="Resources/css/GMap.css" rel="stylesheet" type="text/css" />
    <!--[if lt IE 8]>
    <link href="Resources/css/GMapE7.css" rel="stylesheet" type="text/css" /> 
    <![endif]-->

    <script src="http://maps.google.com/maps/api/js?v=3.2&sensor=false" type="text/javascript"></script>

    <script src="Resources/js/Ajax/MicrosoftAjax.js" type="text/javascript"></script>

    <script src="Resources/js/Ajax/MicrosoftAjaxTemplates.js" type="text/javascript"></script>

    <script src="Resources/js/Ajax/MicrosoftAjaxAdoNet.js" type="text/javascript"></script>

    <script src="Resources/js/Ajax/jquery-1.4.2.js" type="text/javascript"></script>

    <script src="Resources/js/Classes/ErpMarker.js" type="text/javascript"></script>

    <script src="Resources/js/Classes/ErpMarkerCollection.js" type="text/javascript"></script>

    <script src="Resources/js/Classes/Location.js" type="text/javascript"></script>

    <script src="Resources/js/Classes/ContentTabInfo.js" type="text/javascript"></script>

    <script src="Resources/js/Classes/Activity.js" type="text/javascript"></script>

    <script src="Resources/js/Classes/Task.js" type="text/javascript"></script>
    
    <script src="Resources/js/Classes/QueryClass.js" type="text/javascript"></script>
    
    <script src="Resources/js/Classes/Project.js" type="text/javascript"></script>

    <script src="Resources/js/Utilities/markerclusterer.js" type="text/javascript"></script>

    <script src="Resources/js/Utilities/GridMap.js" type="text/javascript"></script>
    
    <script src="Resources/js/Utilities/keydragzoom.js" type="text/javascript"></script>

    <script src="Resources/js/Utilities/Loading.js" type="text/javascript"></script>

    <script src="Resources/js/VarGlobal.js" type="text/javascript"></script>

    <script src="Resources/js/MenuManager/ErpMapMenuManager.js" type="text/javascript"></script>

    <script src="Resources/js/MenuManager/ErpMarkerContextMenuManager.js" type="text/javascript"></script>

    <script src="Resources/js/MenuManager/ErpMapContextMenuManager.js" type="text/javascript"></script>

    <script src="Resources/js/MenuManager/ErpProjectContextMenu.js" type="text/javascript"></script>
    
    <script src="Resources/js/ActivitiesDisplayMarker.js" type="text/javascript"></script>

    <script src="Resources/js/LocationDisplayMarker.js" type="text/javascript"></script>

    <script src="Resources/js/QueryBuilder.js" type="text/javascript"></script>

    <script src="Resources/js/PlanningRoad.js" type="text/javascript"></script>

    <script src="Resources/js/MenuBuilderActivity.js" type="text/javascript"></script>

    <script src="Resources/js/MenuBuilderLocation.js" type="text/javascript"></script>

    <script src="Resources/js/RouteManager.js" type="text/javascript"></script>

    <script src="Resources/js/Algorithms/Google.js" type="text/javascript"></script>

    <script src="Resources/js/Algorithms/Furthest.js" type="text/javascript"></script>


<%--    <script src="http://jqueryui.com/ui/jquery.ui.core.js" type="text/javascript"></script>
    
    <script src="http://jqueryui.com/ui/jquery.ui.widget.js" type="text/javascript"></script>
    
    <script src="http://jqueryui.com/ui/jquery.ui.mouse.js" type="text/javascript"></script>
    
    <script src="http://jqueryui.com/ui/jquery.ui.draggable.js" type="text/javascript"></script>--%>
    
    <script type="text/javascript" language="javascript">
        /*
        * Main script
        * Create Gmap, and the htmlFrom
        * @author: Julien Pierre, Klein Pierre-yves
        *
        */
       
        function init() {
            loading("hidden");
            document.getElementById("createAudit").style.visibility = "hidden";

            proxy = new AjaxSys.Data.AdoNetServiceProxy("WorkPlanning/MapService.svc");


            queryFilter = "and Enabled eq true and Archived eq false and Deleted eq false and Completed eq false ";
            var a = qbActivities.get_resourcePath();
            ckb11 = document.getElementById("ckb11");
            ckb33 = document.getElementById("ckb33");
            ckb132 = document.getElementById("ckb132");
            ckbShowDirections = document.getElementById("ckbShowDirections");
            ckbReact = document.getElementById("ckbReact");
            ckbRecurrent = document.getElementById("ckbRecurrent");
            ckbQuote = document.getElementById("ckbQuote");

            var size = thisWindowSize();

            mapContainer = document.getElementById("map_canvas");
            mapContainer.style.width = size[0];
            mapContainer.style.height = size[1] - 55;

            var myOptions = {
                mapTypeControl: false,
                zoom: 7,
                center: new google.maps.LatLng(52.980512, -2.706833),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            }
            map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
            map.enableKeyDragZoom();

            // pane Style

            currentZoom = map.getZoom();

            //ExecuteQuery();
            if (displayGrid) {
                CreateGrid(applicationBaseUrl);
                google.maps.event.addListener(map, 'moveend', function() {
                    CreateGrid(applicationBaseUrl);
                    currentZoom = map.getZoom();
                });

            }
            google.maps.event.addListener(map, 'click', function() {
                closeTab();
                if (displayGrid) {
                    if (currentZoom != map.getZoom()) {
                        CreateGrid(applicationBaseUrl);
                        currentZoom = map.getZoom();
                    }
                }
            });

            document.getElementById("choiceDisplaySearchActivity").style.visibility == "hidden";
            document.getElementById("choiceDisplaySearchLocation").style.visibility == "hidden";


            google.maps.event.addListener(map, 'rightclick', function(event) {
                document.getElementById("latRightClickMap").value = event.latLng.lat();
                document.getElementById("lngRightClickMap").value = event.latLng.lng();
                erpMapContextMenu.showAt(event.pixel.x, event.pixel.y);
            });
            initDateTab();
            directionsDisplay = new google.maps.DirectionsRenderer();
            //completeSelectActivityModulesForAddActivity();
        }

        function initDateTab() {
            var nbrOfDay = 21;
            var currentDate = new Date();
            var currentDateDisplay = currentDate.getFullYear() + "-" + (currentDate.getMonth() + 1) + "-" + currentDate.getDate();
            document.getElementById("dayChoose").innerHTML = currentDateDisplay;
            var tabl = document.getElementById("tableForChooseDay");
            var row = document.createElement('TR');
            tabl.appendChild(row);
            var i = 0;
            while (i < nbrOfDay) {
                var cellDate = document.createElement('TD');
                var timeAdd = i * 86400000;
                var value = currentDate.getTime() + timeAdd;
                var dateSelected = new Date(value);
                var color = weekDayColor;
                var colorOver = weekDayOverColor;
                if (dateSelected.getDay() == 0 || dateSelected.getDay() == 6) {
                    color = weekEndDayColor;
                    colorOver = weekEndDayOverColor;
                }
                dateSelected = dateSelected.getFullYear() + "-" + (dateSelected.getMonth() + 1) + "-" + dateSelected.getDate();
                cellDate.value = dateSelected;
                cellDate.style.backgroundColor = color;
                cellDate.style.display = "block";
                cellDate.innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;";
                cellDate.id = dateSelected;
                cellDate.name = color;
                cellDate.onmouseover = function() { if (this.name == weekEndDayColor) { this.style.backgroundColor = weekEndDayOverColor } else { this.style.backgroundColor = weekDayOverColor }; document.getElementById("dayChoose").innerHTML = this.value; };
                cellDate.onmouseout = function() { this.style.backgroundColor = this.name; };
                cellDate.onclick = function() { refreshDisplayProject(); refreshMap(); delAllnode(); searchActiveProject(this.id); };
                row.appendChild(cellDate);
                i++;
            }
            tabl.appendChild(row);
            //$("#DisplayDay").draggable(); 
        }

        function pageLoad() {
            ajaxmgr = $find("RadAjaxManager1");
            erpMapContextMenu = $find("ErpMapContextMenu");
            erpMapMenu = $find("ErpMapMenu");
            erpMarkerContextMenu = $find("ErpMarkerContextMenu");
            cbxLocations = $find("cbxLocations");
            slctAddCustomersId = $find("slctAddCustomersId");
            searchMap_text = $find("ErpMapMenu_i0_txtSearchMap"); //ErpMapMenu_i0_txtSearchMap_text
            //var test = searchMap_text.get_value();
            detailsSlide = $find("SPaneDetails");
            tasksSlide = $find("SPaneTasks");
            worktimesSlide = $find("SPaneWorkTimes");
            activitySearch = $find("txtActivity");
            adressSearch = $find("txtAddress");
            dateFrom = $find("dateFrom"); ;
            dateTo = $find("dateTo");
            radDatePickerEndDateTime = $find("RadDatePickerEndDateTime");
            radDatePickerStartDateTime = $find("RadDatePickerStartDateTime");
            radTree = $find("treeViewProjects");
            radTextBoxProjectName = $find("RadTextBoxProjectName");
            ckbToDisplay = $find("nodesServerside");
            slctLocationAddCustomersId = $find("slctLocationAddCustomersId");
            slctAddActivityModulesId = $find("slctAddActivityModulesId");
            slctAddActivityProgrammesId = $find("slctAddActivityProgrammesId");
            slctAddActivityPrioritiesId = $find("slctAddActivityPrioritiesId");
            slctAddActivityCategoriesId = $find("slctAddActivityCategoriesId");
            radDatePickerStartTask = $find("RadDatePickerStartTask");
            radDatePickerEndTask = $find("RadDatePickerEndTask");
            radComboBoxCoordinator = $find("RadComboBoxCoordinator");
            tree = $find("treeViewProjects");
            cbxAuditedBy = $find("cbxAuditedBy");
            auditPlace = $find("auditPlace");
            radComboBoxProjectStatus = $find("RadComboBoxProjectStatus");
            if (searchMap_text)
                goUrl();
        }
    
         function delAllnode() {
             var allNodes = radTree.get_allNodes();
             var i = 0;
             var length = allNodes.length;
            // radTree.initialize();
             
             while (i<length) {
                radTree.trackChanges();
                var selectNode = allNodes[i];
                var parent = selectNode.get_parent();
                parent.get_nodes().remove(selectNode);
                radTree.commitChanges();
                i++;
             }
//while(radTree.
             radTree.commitChanges();
               
         }

        function clearSelect(index, type) {
            if (index == 4) {
                if (type == "Activity") {
                    while (document.getElementById("slctAddActivityCategoriesId").firstChild) {
                        document.getElementById('slctAddActivityCategoriesId').removeChild(document.getElementById("slctAddActivityCategoriesId").firstChild);
                    }
                }
            }
            if (index == 3) {
                if (type == "Activity") {
                    while (document.getElementById("slctAddActivityCategoriesId").firstChild) {
                        document.getElementById('slctAddActivityCategoriesId').removeChild(document.getElementById("slctAddActivityCategoriesId").firstChild);
                    }
                    while (document.getElementById("slctAddActivityProgrammesId").firstChild) {
                        document.getElementById('slctAddActivityProgrammesId').removeChild(document.getElementById("slctAddActivityProgrammesId").firstChild);
                    }
                }
            }
            if (index == 2) {
                if (type == "Activity") {
                    while (document.getElementById("slctAddActivityCategoriesId").firstChild) {
                        document.getElementById('slctAddActivityCategoriesId').removeChild(document.getElementById("slctAddActivityCategoriesId").firstChild);
                    }
                    while (document.getElementById("slctAddActivityProgrammesId").firstChild) {
                        document.getElementById('slctAddActivityProgrammesId').removeChild(document.getElementById("slctAddActivityProgrammesId").firstChild);
                    }
                    while (document.getElementById("slctAddActivityPrioritiesId").firstChild) {
                        document.getElementById('slctAddActivityPrioritiesId').removeChild(document.getElementById("slctAddActivityPrioritiesId").firstChild);
                    }

                }
            }
            if (index == 1) {
                if (type == "Activity") {
                    while (document.getElementById("slctAddActivityCategoriesId").firstChild) {
                        document.getElementById('slctAddActivityCategoriesId').removeChild(document.getElementById("slctAddActivityCategoriesId").firstChild);
                    }
                    while (document.getElementById("slctAddActivityProgrammesId").firstChild) {
                        document.getElementById('slctAddActivityProgrammesId').removeChild(document.getElementById("slctAddActivityProgrammesId").firstChild);
                    }
                    while (document.getElementById("slctAddActivityPrioritiesId").firstChild) {
                        document.getElementById('slctAddActivityPrioritiesId').removeChild(document.getElementById("slctAddActivityPrioritiesId").firstChild);
                    }
                    while (document.getElementById("slctAddActivityModulesId").firstChild) {
                        document.getElementById('slctAddActivityModulesId').removeChild(document.getElementById("slctAddActivityModulesId").firstChild);
                    }
                }
                if (type == "Location") {//slctLocationAddTypesId
                    while (document.getElementById("slctLocationAddTypesId").firstChild) {
                        document.getElementById('slctLocationAddTypesId').removeChild(document.getElementById("slctLocationAddTypesId").firstChild);
                    }
                }
            }
        }

        function setOrder() {
            var erpMarkerChangedCollection = new ErpMarkerCollection();
            var erpMarkerFinalCollection = new ErpMarkerCollection();
            var i = 0;
            var length = erpMarkerAddCollection.length();
            while ((length - i) > 0) {
                if (document.getElementById("input." + i)) {
                    var newIndex = (document.getElementById("input." + i).value)-1;
                    if (i != newIndex) {
                        erpMarkerAddCollection.arrayErpMarker[i].listIndex = newIndex;
                        erpMarkerChangedCollection.add(erpMarkerAddCollection.arrayErpMarker[i]);
                    }
                    else {
                        erpMarkerFinalCollection.add(erpMarkerAddCollection.arrayErpMarker[i]);
                    }
                }
                i++;
            }
            erpMarkerAddCollection = erpMarkerFinalCollection;
            var erpMarkerChangedSortedCollection = new ErpMarkerCollection();
            erpMarkerChangedSortedCollection.arrayErpMarker = erpMarkerChangedCollection.arrayErpMarker.sort(function(a, b) { return a.listIndex - b.listIndex });
            var i = 0;
            var length = erpMarkerChangedSortedCollection.length();
            while ((length - i) > 0) {
                if (i > 0 && erpMarkerChangedSortedCollection.arrayErpMarker[parseInt(i) - 1].listIndex >= erpMarkerChangedSortedCollection.arrayErpMarker[i].listIndex)
                    erpMarkerChangedSortedCollection.arrayErpMarker[i].listIndex = parseInt(erpMarkerChangedSortedCollection.arrayErpMarker[parseInt(i) - 1].listIndex) + 1;
                erpMarkerAddCollection.addAtIndex(erpMarkerChangedSortedCollection.arrayErpMarker[i].listIndex, erpMarkerChangedSortedCollection.arrayErpMarker[i]);
                i++;
            }
            erpMarkerAddCollection = erpMarkerAddCollection.cleanCollection();
            refreshList();
        }

        //----------------------doit etre changer pour la v3--------------------//
        function addIconAtMap(labelValue, refMarker) {
            var image = "/_common/MapTileName.aspx?iconLabel=" + labelValue;
            var iconSize = new google.maps.Size(40, 20);
            var iconAnchor = new google.maps.Point(refMarker.icon.anchor.x - 30, refMarker.icon.anchor.y);
            var iconimage = new google.maps.MarkerImage(image, iconSize, new google.maps.Point(0, 0), iconAnchor, iconSize);
            var testMarkTemp = new google.maps.Marker({
                position: refMarker.getPosition(),
                map: map,
                icon: iconimage,
                zIndex: 100
            });
            arrayLabel[arrayLabel.length] = testMarkTemp;
        }

        function refreshList() {
            polylineArray['ListChangeGoogle'] = true;
            polylineArray['ListChangeClosest'] = true;
            polylineArray['ListChangeFurthest'] = true;
            polylineArray['ListChangeCustom'] = true;
            erpMarkerAddCollection.type = MarkerType.None;
            var i = 0;
            while (i < arrayLabel.length) {
                arrayLabel[i].setMap(null);
                i++;
            }
            arrayLabel = new Array();
            while (document.getElementById("list").firstChild) {
                document.getElementById('list').removeChild(document.getElementById("list").firstChild);
            }
            var w = 0;
            var length = erpMarkerAddCollection.length();
            while ((length - w) > 0) {
                erpMarkerAddCollection.type = erpMarkerAddCollection.arrayErpMarker[w].type;
                var inc = w + 1;
                //erpMarkerAddCollection.arrayErpMarker[i].index = w;
                var lat = erpMarkerAddCollection.arrayErpMarker[w].object.latitude;
                var lng = erpMarkerAddCollection.arrayErpMarker[w].object.longitude;
                if (erpMarkerAddCollection.arrayErpMarker[w].object.planningOrder!=null && erpMarkerAddCollection.type == MarkerType.Activity)
                    addIconAtMap(erpMarkerAddCollection.arrayErpMarker[w].object.planningOrder, erpMarkerAddCollection.arrayErpMarker[w].gMarker);
                else {
                }
                var tbl = document.getElementById('list');
                if (tbl.rows != null)
                    var lastRow = tbl.rows.length;
                else
                    lastRow = 0;
                var iteration = lastRow;
                var row = document.createElement('TR');
                row.name = erpMarkerAddCollection.arrayErpMarker[w];

                tbl.appendChild(row);

                //var row = tbl.insertRow(lastRow);
                row.id = w;
                row.className = "trList";
                row.onmouseover = function() { this.className = "hov"; };
                row.onmouseout = function() { this.className = "trList"; };
                // left cell
                var cellInput = document.createElement('TD');
                cellInput.innerHTML = "<input value='" + inc + "' id='input." + row.id + "' size='4' style='font-size:15px; width:30px; height:15px;'></input>";
                row.appendChild(cellInput);
                var cellLeft = document.createElement('TD');
                erpMarkerAddCollection.arrayErpMarker[w].listIndex = w;
                cellLeft.name = erpMarkerAddCollection.arrayErpMarker[w];
                //var textNode = document.createTextNode(query.ActivityId);
                cellLeft.innerHTML = erpMarkerAddCollection.arrayErpMarker[w].name;

                row.appendChild(cellLeft);
                cellLeft.onclick = function() { map.setCenter(this.name.getCoordinate()); map.setZoom(13); this.name.detailTab(); };
                // right cell
                var oImg = document.createElement("img");
                oImg.setAttribute('src', 'Resources/icons/close.png');
                oImg.setAttribute('border', '0');
                oImg.setAttribute('class', "imgList");
                var cellRight = document.createElement('TD');
                row.appendChild(cellRight);
                cellRight.setAttribute('class', 'right');
                oImg.id = w;
                oImg.name = erpMarkerAddCollection.arrayErpMarker[w].id;
                oImg.onclick = function() { addOrDelToList("", this.name); };
                cellRight.appendChild(oImg);
                
                
                w++;
            }
            if (erpMarkerAddCollection.type == MarkerType.Activity)
                document.getElementById("hiddenCustomerProject").value = erpMarkerAddCollection.arrayErpMarker[0].object.customerId;
            //optimazeRoad();
            //testDistance();
            if (length > 10) {
                document.getElementById('addToActList').style.overflow = "auto";
                document.getElementById('addToActList').style.height = "220px";
            }
            else {
                document.getElementById('addToActList').style.height = "auto";
            }
            var timeToWait = erpMarkerAddCollection.length() * 20;
            setTimeout(function() { loading("hidden") }, timeToWait);
        }

        function addProject() {
            document.getElementById("ProjectStatusHidden").value = radComboBoxProjectStatus.get_value();
            var start = parseInt(radDatePickerStartDateTime.get_dateInput()._element.value.toString().substr(0, 10).replace('-', '').replace('-', ''));
            var end = parseInt(radDatePickerEndDateTime.get_dateInput()._element.value.toString().substr(0, 10).replace('-', '').replace('-', ''));
            if (start > end) {
                document.getElementById("logAlert").style.borderColor = "blue";
                document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logInfoMessage.jpg\" alt=\"info\" width=\"30%\"/></td><td VALIGN='middle' style='color:blue;'><b color:blue>&nbsp; To lower than From</b></td></tr>";
                $("#logAlert").stop(true, true).delay(5).slideDown(250);
                closelogalert();

            }
            else {
                if (!erpMarkerAddCollection.length()) {
                    document.getElementById("logAlert").style.borderColor = "red";
                    document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logWarningMessage.png\" alt=\"info\" width=\"30%\"/></td><td VALIGN='middle' style='color:red;'><b color:red>&nbsp; The list is empty</b></td></tr>";
                    $("#logAlert").stop(true, true).delay(5).slideDown(250);
                    closelogalert();
                } else {
                    if (start == "" || end == "") {
                        document.getElementById("logAlert").style.borderColor = "blue";
                        document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logInfoMessage.jpg\" alt=\"info\" width=\"30%\"/></td><td  VALIGN='middle' style='color:blue;'><b>&nbsp; Empty !</b></td></tr>";
                        document.getElementById("logAlert").style.visibility = "visible";
                        $("#logAlert").stop(true, true).delay(5).slideDown(250);
                        closelogalert();
                    }
                    else {
                        createProject();
                        $.post("/_common/handlers/Projects/AddProjectHandler.ashx", $("form").serialize(), insertCallback);
                    }
                }
            }
        }
        
        function setPlanningOrder() {
            linkActivitiesToProject();
            $.post("/_common/handlers/Activities/SetPlanningOrderHandler.ashx", $("form").serialize(), insertCallback);
        }

        function setPlanningOrderForAProject() {
            linkActivitiesToProject();
            $.post("/_common/handlers/Activities/SetProjectIdHandler.ashx", $("form").serialize(), insertCallbacksetTest);
        }



        //===================== A MODIDIFIER avec les logalert =========================//
        function insertCallbacksetTest(result) {
            //alert(result);
        }

        function getAllChildProject() {
            $.post("/_common/handlers/Activities/GetAllChildProjectFromProjectId.ashx", $("form").serialize(), getChildProjectCallback);
        }

        function getProject() {
            linkActivitiesToProject();
            $.post("/_common/handlers/Activities/GetProjectHandler.ashx", $("form").serialize(), insertCallback);
        }

        //        function testDistance() {
        //            request = {
        //            origin: erpMarkerAddCollection.arrayErpMarker[0].getCoordinateObject(),
        //            destination: erpMarkerAddCollection.arrayErpMarker[1].getCoordinateObject(),
        //                travelMode: google.maps.DirectionsTravelMode.DRIVING
        //            };
        //            directionsService.route(request, function(result, status) {
        //                if (status == google.maps.DirectionsStatus.OK) {
        //                    alert(result.routes[0].legs[0].duration.value);
        //                }
        //            });
        //        }


        function goUrl() {
            var t = location.search.substring(1).split('=');
            var i = 0;
            if (t[0] != "") {
                activitySearch.set_value(t[1].toString());
                GoActivity();                
            }
        }

        //        function selectAzBooks() {
        //            proxy.query(qbAzBooks.toString(), selectAzBooksOnSuccess, selectAzBooksOnFailure);
        //        }

        //        function selectAzBooksOnSuccess(result, context, operation) {
        //            for (var i in result) {
        //                var azBook = result[i];
        //                if (azBook.PageNumbers != null && azBook.PageNumbers.match(/[;1-9]+[;][;1-9]+/)) {
        //                    azBooks.push(azBook);
        //                }
        //            }
        //            ExecuteQuery();
        //        }

        //        function selectAzBooksOnFailure(error, context, operation) {
        //            //

        //            (error.get_message());
        //        }

        //        function S4() {
        //            return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
        //        }
        //        function guid() {
        //            return (S4() + S4() + "-" + S4() + "-" + S4() + "-" + S4() + "-" + S4() + S4() + S4());
        //        }




        /*
        * Function disabled()
        * Disable the activities ckb if one of the localiation ckb is checked and enable the others
        * and vise versa
        */
        function disabled(queryFilter) {
//            if (currentMarkerType == MarkerType.Activity && !search) {

//            }
//            else {
//                if (!search) {
//                    ckbQuote.disabled = true;
//                    ckbReact.disabled = true;
//                    ckbRecurrent.disabled = true;
//                }

//            }
//            if (queryFilter == "" || search) {
//                ckbQuote.disabled = false;
//                ckbReact.disabled = false;
//                ckbRecurrent.disabled = false;
//                ckb11.disabled = false;
//                ckb132.disabled = false;
//                ckb33.disabled = false;
//                ckbQuote.checked = false;
//                ckbReact.checked = false;
//                ckbRecurrent.checked = false;
//                ckb11.checked = false;
//                ckb132.checked = false;
//                ckb33.checked = false;

//            }
//            search = false;
        }



        function ExecuteQuery() {
            document.getElementById("createAudit").style.visibility = "hidden";
            closeTab();
            loading("visible");
            BuildFilters();
            refreshMap();
            if (currentMarkerType == MarkerType.Activity) {
                queryFilter += " and Latitude ne null and Longitude ne null";
                qbActivities.set_filter(queryFilter);
                qbActivities.set_orderby("Latitude");
                proxy.query(qbActivities.toString(), onSuccess, onFailure);
            }
            if (currentMarkerType == MarkerType.Location) {
                qbLocations = new AjaxSys.Data.AdoNetQueryBuilder("vwSubstations");
                qbLocations.set_filter(queryFilter);
                qbLocations.set_orderby("Latitude");
                proxy.query(qbLocations.toString(), onSuccess, onFailure);
            }
        }


        function onSuccess(result, context, operation) {

            var j = 0;
            var bool = false;
            for (var i in result) {
                var resQuery = result[i];
                if (resQuery.Latitude != null && resQuery.Longitude != null) {

                    var erpGMarker = new ErpMarker(map, currentMarkerType, resQuery, i);

                    j = 0;
                    bool = false;
                    while (j < erpMarkerAddCollection.length() && !bool) {
                        if (erpMarkerAddCollection.arrayErpMarker[j].object.id == resQuery.Id) {
                            var str = erpGMarker.getIcon();
                            var len = str.length;
                            erpGMarker.listIndex = j;
                            erpGMarker.inList = true;
                            var indPoint = str.lastIndexOf('.');
                            erpGMarker.changeIcon(str.substr(0, indPoint) + "InList.png");
                            bool = true;
                        }
                        j++;
                    }

                    erpMarkerCollection.add(erpGMarker);
                    if (goAct || goLocation) {
                        map.setCenter(new google.maps.LatLng(resQuery.Latitude, resQuery.Longitude), 10);
                    }
                }
                if ((goAct || goLocation) && (resQuery.Latitude == null || resQuery.Longitude == null))
                    alert("No Latitude or longitude");
            }
            if (goLocation)
                currentMarkerType = MarkerType.Location;
            goAct = false;
            //MarkerClustererOptions();
            var mcOptions = { gridSize: 70, maxZoom: 13 };
            markerClusterer = new MarkerClusterer(map, erpMarkerCollection.arrayErpMarker, mcOptions);


            //markerClusterer = new MarkerClusterer(map, erpMarkerCollection.arrayErpMarker, mcOptions);
            //markerClusterer.getMarkers();
            loading("hidden");
        }

        /*
        * Function choiceIcons()
        * No argument
        * This function chooses between diferents icon, 
        * depending on what type of check box is chosen
        */

        function onFailure(error, context, operation) {
            alert(error.get_message());
        }

        function refreshMap() {
            erpMarkerCollection.toEmpty();
            var i = 0;
            if (arrayLabel) {
                while (i < arrayLabel.length) {
                    arrayLabel[i].setMap(null);
                    i++;
                }
            }
            arrayLabel = new Array();
            if (markerClusterer != null) {
                markerClusterer.clearMarkers();
            }
        }

        function thisWindowSize() {
            var wSize = [];

            var myWidth = 0, myHeight = 0;
            if (typeof (window.innerWidth) == 'number') {
                //Non-IE
                myWidth = window.innerWidth;
                myHeight = window.innerHeight;
            } else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
                //IE 6+ in 'standards compliant mode'
                myWidth = document.documentElement.clientWidth;
                myHeight = document.documentElement.clientHeight;
            } else if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
                //IE 4 compatible
                myWidth = document.body.clientWidth;
                myHeight = document.body.clientHeight;
            }

            wSize.push(myWidth);
            wSize.push(myHeight);

            return wSize;
        }

        function addStr(str) {
            document.getElementById("slctchoice").options[document.getElementById("slctchoice").length] = str;
        }

        function onSuccessDisplay(result, context, operation) {
            var count = 0;
            for (var i in result) {
                str = "";
                var resQuery = result[i];
                str = resQuery.Name;
                if (str.indexOf(document.getElementById("slctchoice")) >= 0 && count < 20) {
                    count++;
                    addStr(str);
                }
            }
        }

        function show(id, idchg) {

            var displayId = "#" + id;
            if ($(displayId).is(":hidden")) {
                if (idchg)
                    document.getElementById(idchg).innerHTML = "[-]";
                $(displayId).stop(true, true).delay(10).slideDown(250);

            }
            else {
                if (idchg)
                    document.getElementById(idchg).innerHTML = "[+]";
                $(displayId).stop(true, true).delay(0).slideUp(510);

            }
        }


        /*
        * 
        *
        *
        */
        function closeAll(str) {
            if ($("#showAudit").is(":hidden")) {
                if (str != 'activitiesSlide')
                    close('activitiesSlide', 'plusAct');
                if (str != 'locationSlide')
                    close('locationSlide', 'plusLoc');
                if (str != 'searchSlide')
                    close('searchSlide', 'plusSearch');
                if (str != 'addToActList')
                    close('addToActList', 'plusList');
                if (str != 'legendDisplay')
                    close('legendDisplay', 'plusLe');
                if (str != 'adact') {
                    close('adact', 'plusAddAct'); //
                    close('addToActListButtons', "");
                }
            }
        }
        
        function close(id, idPlus) {
            if ($("#" + id).is(":hidden")) {
            }
            else {
                show(id, idPlus);
            }
        }

        function GoAddress() {
            closeTab();
            var address = document.getElementById("txtAddress").value;
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'address': address }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                }
            });
            document.getElementById("txtActivity").value = "Activity Id";
            searchMap_text.value = "Location name";
        }




        function createFile() {
            if (erpMarkerAddCollection.type == MarkerType.Activity) {
                var i = 0;
                var str = "";
                str += "<table width='100%' cellpadding='5' cellspacing='0' border =1>";
                str += "<tr bgcolor=#D1D8EF><td>ActivityId </td><td>ProgrammeName</td><td>Category Name</td><td>Name</td><td>ModuleName</td></tr>";
                while (i < erpMarkerAddCollection.length()) {
                    var object = erpMarkerAddCollection.arrayErpMarker[i].object;
                    str += "<tr><td>" + object.activityId + " </td><td>" + object.programmeName + "</td><td>" + object.categoryName + "</td><td>" + object.name + "</td><td>" + object.moduleName + "</td></tr>";
                    i++;
                }
                str += "</table>";
                var wind = document.open("", "mywindow1", "");
                wind.document.write(str);
            }
            else
                if (erpMarkerAddCollection.type == MarkerType.Location) {
                var i = 0;
                var str = "";
                str += "<table width='100%' cellpadding='5' cellspacing='0' border =1>";
                str += "<tr bgcolor=#D1D8EF><td>Name </td><td>type</td><td>line 1</td><td>line 2</td><td>line 3</td><td>line 4 <td>postcode</td></td></tr>";
                while (i < erpMarkerAddCollection.length()) {
                    var object = erpMarkerAddCollection.arrayErpMarker[i].object;
                    str += "<tr><td>" + object.name + " </td><td>" + object.substationTypeName + "</td><td>" + object.line1 + "</td><td>" + object.line2 + "</td><td>" + object.line3 + "</td><td>" + object.line4 + "</td><td>" + object.postcode + "</td></tr>";
                    i++;
                }
                str += "</table>";
                var wind = document.open("", "mywindow1", "");
                wind.document.write(str);
               }
        }

        function lookup() {
            if (searchMap_text.get_value().length == 0) {
                // Hide the suggestion box.
                $('#txtShow').hide();
            }
            else {
//                document.getElementById("createAudit").style.visibility = "hidden";
//                var strActId = searchMap_text.value.toString();
//                qbLocations.set_orderby("Name");
//                qbLocations.set_top(10);
//                qbLocations.set_filter("Name ge '" + strActId + "'");
//                proxy.query(qbLocations.toString(), onSuccessLook, onFailure);
//                document.getElementById("txtShow").style.visibility = "visible";
//                $("#txtShow").stop(true, true).delay(1).slideDown(1);
            }
        }

        function onSuccessLook(result, context, operation) {
//            var count = 0;
//            document.getElementById("txtShow").innerHTML = "";
//            document.getElementById("txtShow").innerHTML += "<ul style='border:0;'>";
//            for (var i in result) {
//                str = "";
//                count++;
//                var resQuery = result[i];
//                str = resQuery.Name.toString();
//                document.getElementById("txtShow").innerHTML += "<li id=" + str + " onclick='document.getElementById(\"txtLocation\").value=\"" + str + "\";' class='suggestionListli' onmouseout='this.className=\"suggestionListli\";' onmouseover='this.className=\"suggestionListOn\";' value=" + str + ">" + str + "</li>";
//            }
//            if (count == 0) {
//                document.getElementById("txtShow").innerHTML = "<ul>Not found";
//            }
//            document.getElementById("txtShow").innerHTML += "</ul>";

        }
        $(document).ready(function() {

        });


        function closeTab() {
            if (infowindow)
                infowindow.close();
            $find("SlidingZoneInformation").collapsePane('SPaneDetails');
            $find("SlidingZoneInformation").collapsePane('SPaneTasks');
            $find("SlidingZoneInformation").collapsePane('SPaneWorkTimes');
            $find("SlidingZoneInformation").collapsePane('SPaneStreetView');

        }

        function changeDisplayGrid() {
            //            if (document.getElementById("ckbGrid").checked) {
            //                CreateGrid(applicationBaseUrl);
            //                if (!displayGrid) {
            //                    gEventMoveEnd = google.maps.event.addListener(map, 'moveend', function() {
            //                        CreateGrid(applicationBaseUrl);
            //                        currentZoom = map.getZoom();
            //                    });
            //                    gEventClick = google.maps.event.addListener(map, 'click', function() {
            //                        if (currentZoom != map.getZoom()) {
            //                            CreateGrid(applicationBaseUrl);
            //                            currentZoom = map.getZoom();
            //                        }

            //                    });
            //                }
            //                displayGrid = true;
            //            }
            //            else {
            //                google.maps.event.removeListener(gEventMoveEnd);
            //                google.maps.eEvent.clearListeners(gEventMoveEnd);
            //                google.maps.eEvent.removeListener(gEventClick);
            //                google.maps.eEvent.clearListeners(gEventClick);
            //                displayGrid = false;
            //                var i = 0;
            //                while (i < arrayPolygon.length) {
            //                    arrayPolygon[i].remove();
            //                    i++;
            //                }
            //                i = 0;
            //                while (i < arrayImageMarker.length) {
            //                    arrayImageMarker[i].remove();
            //                    i++;
            //                }


            //            }



        }


        function radioChangeMap(value) {
            if (value == "Satellite")
                map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
            if (value == "Terrain")
                map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
            if (value == "Map")
                map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
            if (value == "Hybrid")
                map.setMapTypeId(google.maps.MapTypeId.HYBRID);
            if (document.getElementById("ckbTraffic").checked) {
                traffic = new google.maps.TrafficLayer();
                traffic.setMap(map);

            }
            else {
                if (traffic)
                    traffic.setMap(null);
            }
        }

        function closeAdvancedSearch() {
            if (currentSearch == "activity") {
                document.getElementById("plusActAdvanced").innerHTML = "[+]";
                while (document.getElementById("tBodyAdvancedActSearch").firstChild) {
                    document.getElementById('tBodyAdvancedActSearch').removeChild(document.getElementById("tBodyAdvancedActSearch").firstChild);
                }
                document.getElementById("choiceDisplaySearchActivity").style.visibility = "hidden";
            }
            if (currentSearch == "location") {
                document.getElementById("plusLocAdvanced").innerHTML = "[+]";
                while (document.getElementById("tBodyAdvancedLocationSearch").firstChild) {
                    document.getElementById('tBodyAdvancedLocationSearch').removeChild(document.getElementById("tBodyAdvancedLocationSearch").firstChild);
                }
                document.getElementById("choiceDisplaySearchLocation").style.visibility = "hidden";
            }
            currentSearch = "";
        }
   
        function requestSearchAdvanced() {
            currentMarkerType = MarkerType.Activity;
            clearAllInput();
            document.getElementById("createAudit").style.visibility = "hidden";
            loading("visible");
            closeTab();
            var cmptCust = 0;
            var cmptMod = 1;
            var cmptProg = 1;
            var cmptCat = 1;
            var boolCat = false;
            var boolProg = false;
            var boolMod = false;
            queryFilter = "";
            var strQuery = "(";
            while (document.getElementById("cust" + cmptCust)) {

                cmptMod = 1;
                var customerValue = document.getElementById("cust" + cmptCust).name;
                while (document.getElementById("ckbSearch" + cmptCust + "." + cmptMod)) {


                    cmptProg = 1;
                    var moduleValue = document.getElementById("ckbSearch" + cmptCust + "." + cmptMod).value;
                    boolProg = false;
                    while (document.getElementById("ckbSearch" + cmptCust + "." + cmptMod + "." + cmptProg)) {

                        cmptCat = 1;
                        boolCat = false;
                        var progVal = document.getElementById("ckbSearch" + cmptCust + "." + cmptMod + "." + cmptProg).value;
                        while (document.getElementById("ckbSearch" + cmptCust + "." + cmptMod + "." + cmptProg + "." + cmptCat)) {

                            if (document.getElementById("ckbSearch" + cmptCust + "." + cmptMod + "." + cmptProg + "." + cmptCat).checked) {
                                boolCat = true;
                                var catVal = document.getElementById("ckbSearch" + cmptCust + "." + cmptMod + "." + cmptProg + "." + cmptCat).value;
                                strQuery += "(ProgrammeName eq '" + progVal + "' and ModuleName eq '" + moduleValue + "' and CustomerName eq '" + customerValue + "' and CategoryName eq '" + catVal + "') or ";
                            }

                            cmptCat++;
                        }
                        if (document.getElementById("ckbSearch" + cmptCust + "." + cmptMod + "." + cmptProg).checked) {
                            boolProg = true;
                            if (!boolCat) {
                                strQuery += "(ProgrammeName eq '" + progVal + "' and ModuleName eq '" + moduleValue + "' and CustomerName eq '" + customerValue + "') or ";
                            }

                        }
                        cmptProg++;
                    }
                    if (document.getElementById("ckbSearch" + cmptCust + "." + cmptMod).checked) {
                        boolMod = true;
                        if (!boolProg) {
                            strQuery += "(ModuleName eq '" + moduleValue + "' and CustomerName eq '" + customerValue + "') or ";
                        }
                    }
                    cmptMod++;
                }
                cmptCust++;
            }
            strQuery = (strQuery.substr(0, (strQuery.length) - 3));
            if (strQuery == "") {
                strQuery = "ModuleName eq 'REACTIVE' and Enabled eq false and Archived eq false and Deleted eq false and Completed eq false";
            }
            else {
                strQuery += ") and Latitude ne null and Longitude ne null and Enabled eq true and Archived eq false and Deleted eq false and Completed eq false "+optimise;
            }
            qbActivities.set_filter(strQuery);
            currentMarkerType = MarkerType.Activity;
            //refreshMap();
            proxy.query(qbActivities.toString(), onSuccess, onFailure);
        }

        function requestSearchAdvancedLoc() {
            document.getElementById("createAudit").style.visibility = "hidden";
            closeTab();
            loading("visible");
            var cmptLocType = 1;
            var cmptLocName = 0;

            queryFilter = "";
            var strQuery = "(";
            while (document.getElementById("counties" + cmptLocName)) {
                cmptLocType = 1;
                var nameValue = document.getElementById("counties" + cmptLocName).name;
                while (document.getElementById("ckbSearchLoc" + cmptLocName + "." + cmptLocType)) {
                    if (document.getElementById("ckbSearchLoc" + cmptLocName + "." + cmptLocType).checked) {
                        var typeVal = document.getElementById("ckbSearchLoc" + cmptLocName + "." + cmptLocType).value;
                        strQuery += "(LocationTypeName eq '" + typeVal + "' and CountyName eq '" + nameValue + "') or ";
                    }
                    cmptLocType++;
                }
                cmptLocName++;
            }

            strQuery = (strQuery.substr(0, (strQuery.length) - 3));
            if (strQuery == "") {
                strQuery = "LocationTypeName eq '' and Enabled eq false and Archived eq false and Deleted eq false ";
            }
            else {
                strQuery += ") and Latitude ne null and Longitude ne null and Enabled eq true and Archived eq false and Deleted eq false";
            }
            qbLocations.set_filter(strQuery);
            currentMarkerType = MarkerType.Location;
            refreshMap();
            proxy.query(qbLocations.toString(), onSuccess, onFailure);
            disabled(queryFilter);
        }

        function searchAudit() {

            document.getElementById("createAudit").style.visibility = "hidden";
            var dateFrom = document.getElementById("dateFrom").value;
            var dateTo = document.getElementById("dateTo").value;
            if (dateFrom > dateTo) {
                document.getElementById("logAlert").style.borderColor = "blue";
                document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logInfoMessage.jpg\" alt=\"info\" width=\"30%\"/></td><td VALIGN='middle' style='color:blue;'><b color:blue>&nbsp; To lower than From</b></td></tr>";
                $("#logAlert").stop(true, true).delay(5).slideDown(250);
                closelogalert();

            }
            else {
                if (dateTo == "" || dateFrom == "" || dateFrom == "error" || dateTo == "error") {
                    document.getElementById("logAlert").style.borderColor = "blue";
                    document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logInfoMessage.jpg\" alt=\"info\" width=\"30%\"/></td><td  VALIGN='middle' style='color:blue;'><b>&nbsp; Empty !</b></td></tr>";
                    document.getElementById("logAlert").style.visibility = "visible";
                    $("#logAlert").stop(true, true).delay(5).slideDown(250);
                    closelogalert();
                }
                else {
                    currentMarkerType = MarkerType.Activiy;
                    erpMarkerAddCollection = new ErpMarkerCollection();
                    refreshMap();
                    loading("visible");
                    var moduleName = document.getElementById('slctModuleAudit').options[document.getElementById('slctModuleAudit').selectedIndex].value
                    var qbUnauditedActivities = new AjaxSys.Data.AdoNetQueryBuilder("vwUnauditedActivities");
                    strQuery = "ModuleName eq '" + moduleName + "' and CompletedDateTime ge datetime'" + dateFrom + "' and CompletedDateTime le datetime'" + dateTo + "'";
                    qbUnauditedActivities.set_filter(strQuery);
                    qbUnauditedActivities.set_orderby("Latitude");
                    currentMarkerType = MarkerType.Activity;
                    proxy.query(qbUnauditedActivities.toString(), onSuccess, onFailure);
                    queryFilter = "";
                    disabled(queryFilter);
                    asynDisplayAddAudit();
                   
                }
            }
        }
        function asynDisplayAddAudit() {
            var check = setInterval(function() {
            if (erpMarkerCollection.length()) {
                    clearInterval(check);
                    document.getElementById("createAudit").style.visibility = "visible";
                }
            }
            , 1000);
        }

        function addAudit() {
            document.getElementById('auditedBy').value = cbxAuditedBy.get_value();

            document.getElementById('auditPlacehidden').value = auditPlace.get_value();
            //alert("test");
            disabled(queryFilter);
            var bool = false;
            if (document.getElementById("auditedBy").value != "") {

                var inputHidden = document.getElementById('hiddenInputAudit');
                inputHidden.value = "";
                var i = 0;
                //alert("addAudit");
                while (i < erpMarkerAddCollection.length()) {
                    if (erpMarkerAddCollection.arrayErpMarker[i] != "") {
                        inputHidden.value += erpMarkerAddCollection.arrayErpMarker[i].object.id + ";";
                    }
                    i++;
                }

                $.post("/_common/handlers/Audits/Handler1.ashx", $("form").serialize(), insertCallback);
                document.getElementById("createAudit").style.visibility = "hidden";
                loading("visible");
                bool = true;
            }
            else {

            }
            return bool;
        }

        function addActivity() {
            //var test =slctAddCustomersId._value;
            document.getElementById("slctAddCustomersIdhidden").value = slctAddCustomersId.get_value();

            
            document.getElementById("slctAddActivityModulesIdhidden").value = slctAddActivityModulesId.get_value();
            document.getElementById("slctAddActivityProgrammesIdhidden").value = slctAddActivityProgrammesId.get_value();
            document.getElementById("slctAddActivityPrioritiesIdhidden").value = slctAddActivityPrioritiesId.get_value();
            document.getElementById("slctAddActivityCategoriesIdhidden").value = slctAddActivityCategoriesId.get_value();
            //alert("currentMarkerType =" + currentMarkerType);
            disabled(queryFilter);
            if (currentMarkerType == MarkerType.Location && erpMarkerAddCollection.length()>0) {
                loading("visible");
                var inputHidden = document.getElementById('hiddenInputActivity');
                inputHidden.value = "";
                var i = 0;
                while (i < erpMarkerAddCollection.length()) {
                    if (erpMarkerAddCollection.arrayErpMarker[i] != "") {
                        inputHidden.value += erpMarkerAddCollection.arrayErpMarker[i].object.id + ";";
                    }
                    i++;
                }
                inputHidden.value = inputHidden.value.substr(0, inputHidden.value.length - 1);
                //alert(inputHidden.value);
                $.post("/_common/handlers/Activities/AddActivityHandler.ashx", $("form").serialize(), insertCallback);
            }
            else {
                document.getElementById("logAlert").style.borderColor = "red";
                document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logWarningMessage.png\" alt=\"valid\" width=\"30%\"/></td><td VALIGN:middle style='color:red;'><b>I have to select a location before adding an activity</b></td></tr>";
                $("#logAlert").stop(true, true).delay(10).slideDown(250);
            }
            closelogalert();
            //document.getElementById("adact").style.visibility = "hidden";
        }

        function insertCallback(result) {

            if (result.substr(0, 1) == "0") {
                document.getElementById("logAlert").style.borderColor = "red";
                document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logWarningMessage.png\" alt=\"valid\" width=\"30%\"/></td><td VALIGN:middle style='color:red;'><b>&nbsp;0 audit add</b></td></tr>";
            }
            else {
                document.getElementById("logAlert").style.borderColor = "green";
                document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logValidMessage.png\" alt=\"valid\" width=\"30%\"/></td><td VALIGN:middle style='color:green;'><b>&nbsp;You have successfully " + result + " </b></td></tr>";

            }
            loading("hidden");
            $("#logAlert").stop(true, true).delay(10).slideDown(250);
            closelogalert();
        }

        function closelogalert() {
            $("#logAlert").delay(3000).slideUp(250);
        }
       
        function changeContent(element) {

            document.getElementById("ContentInfo").innerHTML = document.getElementById("Content" + element).innerHTML;
            document.getElementById("tabDetails").className = "";
            document.getElementById("tabTasks").className = "";
            document.getElementById("tabWorksTimes").className = "";
            document.getElementById("tab" + element).className = "active";
        }

        //        function ErpMapMenu_OnClientItemClick(sender, eventArgs) {



        //        }

        function txtSearchMap_OnKeyPress(sender, eventArgs) {       
            
            if (eventArgs.get_keyCode() == 13) {
                eventArgs.get_domEvent().stopPropagation();
                eventArgs.get_domEvent().preventDefault();
                
                document.getElementById("hiddenSearchMap").value = searchMap_text.get_value();
                loading("visible");
                postGetActivity()
               

                //$.post("/_common/handlers/Activities/AddActivityHandler.ashx", $("form").serialize(), insertCallback);
                return;           
            }
        }

        function postGetActivity() {

            $.post("/_common/handlers/Activities/GetActivitiesHandler.ashx", $("form").serialize(), getActivitiesCallback);

        }

        function getActivitiesCallback(result) {
            var count;
            //loading("hidden");
            if (result.indexOf("|@") != -1) {
                count = result.substr(result.indexOf("@") + 1, result.length);
                result = result.substr(0, result.indexOf("@"));
            }
            var res = [];
            var reg = new RegExp("[a-zA-Z]", "g");
            var boolCheckValidSearch = true;
            var tmp = "";
            while (result.indexOf("|") != -1) {
                var str = result.substr(0, result.indexOf("|"));
                if ((str.length != 5 && str.length != "") || str.search(reg) != -1) {
                    result = "";
                    boolCheckValidSearch = false;
                }
                tmp += str +" or ActivityId eq ";
                result = result.substr(result.indexOf("|") + 1, result.length);
                
            }
            tmp = tmp.substr(0, tmp.length - 17);
            if (tmp && boolCheckValidSearch) {
                clearAllInput();
                closeTab();
                var queryActivitySearch = "ActivityId eq " + tmp + " and Enabled eq true and Archived eq false and Deleted eq false and Completed eq false";
                qbActivities.set_filter(queryActivitySearch);
                currentMarkerType = MarkerType.Activity;
                proxy.query(qbActivities.toString(), onSuccess, onFailure);
                if (count > 1000) {
                    
                    document.getElementById("logAlert").style.borderColor = "blue";
                    document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logInfoMessage.jpg\" alt=\"info\" width=\"30%\"/></td><td  VALIGN='middle' style='color:blue;'><b>&nbsp;1000 makers displayed on " + count + "</b></td></tr>";
                    document.getElementById("logAlert").style.visibility = "visible";
                    $("#logAlert").stop(true, true).delay(6600).slideDown(250);
                    closelogalert();
                }
                else {
                    document.getElementById("logAlert").style.borderColor = "green";
                    document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logValidMessage.png\" alt=\"valid\" width=\"30%\"/></td><td VALIGN:middle style='color:green;'><b>&nbsp;You have successfully " + count + " activities</b></td></tr>";
                    document.getElementById("logAlert").style.visibility = "visible";
                    $("#logAlert").stop(true, true).delay(4000).slideDown(250);
                    closelogalert();
                }
            }
            else {
                document.getElementById("logAlert").style.borderColor = "red";
                document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logWarningMessage.png\" alt=\"valid\" width=\"30%\"/></td><td VALIGN:middle style='color:red;'><b>&nbsp; Activity not find</b></td></tr>";
                document.getElementById("logAlert").style.visibility = "visible";
                $("#logAlert").stop(true, true).delay(1).slideDown(250);
                closelogalert();
            }
            loading("hidden");
        }
        
        function clearAllInput() {
            radDatePickerEndDateTime._setInputDate(0);
            radDatePickerStartDateTime._setInputDate(0);
            document.getElementById("createAudit").style.visibility = "hidden";
            searchMap_text.set_value("");
            cbxLocations.set_value("");
            detailsSlide.setContent("");
            tasksSlide.setContent("");
            worktimesSlide.setContent("");
            activitySearch.set_value("");
            dateFrom._setInputDate(0);
            dateTo._setInputDate(0);
//          radDatePickerEndDateTime.set_value("");
//          radDatePickerStartDateTime.set_value("");
            document.getElementById("RadTextBoxProjectName").value = "";
            adressSearch.set_value(""); 
            document.getElementById("txtActivityAddName").value = "";
            document.getElementById("txtLocationAddName").value = "";
            document.getElementById("txtLine2").value = "";
            document.getElementById("txtLine3").value = "";
            document.getElementById("txtLine4").value = "";
            document.getElementById("txtPostCode").value = "";
            document.getElementById("txtCountry").value = "";
            document.getElementById("txtLandrangerGridReference").value = "";
            document.getElementById("txtOSgridX").value = "";
            document.getElementById("txtOSgridY").value = "";
            ckbQuote.checked = false;
            ckbReact.checked = false;
            ckb132.checked = false;
            ckb33.checked = false;
        }
        
        function testDisplayRoadFromDB() {

            //testGetRoadForAProjectFromDB();
        }
    </script>

</head>
<body onload="init()">
    <%-- <input id="Checkbox1" type="text"  />
       <input id="queryId" type="text"  />  --%>
       <div id="DivDisplayProject"></div>
    <form id="form1" runat="server">
    <%--<a onclick="testGoogleAlgo();">TEST</a>--%>
   <%--<a onclick="testDisplayRoadFromDB()">p</a>--%>
    <input type="hidden" id="ProjectStatusHidden" name="ProjectStatusHidden" value=""/>
    <input type="hidden" id="hiddenActivitiesProject" value ="" name="hiddenActivitiesProject"/>
    <input type="hidden" id="txtDescriptionAddNamehidden" value ="" name="txtDescriptionAddNamehidden"/>
    <input type="hidden" id="slctAddCustomersIdhidden" value ="" name="slctAddCustomersIdhidden"/>
    <input type="hidden" id="slctAddActivityModulesIdhidden" value ="" name="slctAddActivityModulesIdhidden"/>
    <input type="hidden" id="slctAddActivityProgrammesIdhidden" value ="" name="slctAddActivityProgrammesIdhidden"/>
    <input type="hidden" id="slctAddActivityPrioritiesIdhidden" value ="" name="slctAddActivityPrioritiesIdhidden"/>
    <input type="hidden" id="slctAddActivityCategoriesIdhidden" value ="" name="slctAddActivityCategoriesIdhidden"/>
   
    <input type="hidden" id="Hidden6" value ="" name=""/>
    <input type="hidden" id="Hidden7" value ="" name=""/>
    <input type="hidden" id="Hidden2" value ="" name=""/>
    
    <input type="hidden" id="hiddenActivitiesIdChecked" value ="" name="hiddenActivitiesIdChecked"/>
    <input type="hidden" id="hiddenCurrentProjectId" value ="false" name="hiddenCurrentProjectId"/>
    <input type="hidden" id="hiddenCheckedProjectList" value ="" name="hiddenCheckedProjectList"/>
    <input type="hidden" id="hiddenCustomerProject" value ="" name="hiddenCustomerProject"/>
    <input type="hidden" id="markerClickId" value="-1" />
    <input type="hidden" id="hiddenDateChoose" value ="" name="hiddenDateChoose"/>
    <input type="hidden" id="latRightClickMap" value="0" />
    <input type="hidden" id="lngRightClickMap" value="0" />
    <input type="hidden" id="hiddenDataProtection" value="false" />
    <input type="hidden" id="hiddenTaskId" name="hiddenTaskId" value="" />
    <input type="hidden" id="hiddenCountry" value="" name="hiddenCountry" />
    <input type="hidden" id="hiddenSearchMap" value="null" name="hiddenSearchMap" />
    <input type="hidden" id="hiddenInputLocation" value="" name="hiddenInputLocation" />
    <input type="hidden" id="hiddenDisplayDetailsAddLocation" value="false" name="hiddenDisplayDetailsAddLocation" />

    
    <telerik:RadScriptManager ID="RadScriptManager1" runat="server" />
    
    <telerik:RadAjaxManager ID="RadAjaxManager1" runat="server" OnAjaxRequest="RadAjaxManager1_AjaxRequest">
        <AjaxSettings>
            <telerik:AjaxSetting AjaxControlID="RadAjaxManager1">
                <UpdatedControls>
                    <telerik:AjaxUpdatedControl ControlID="treeViewProjects" />
                </UpdatedControls>
            </telerik:AjaxSetting>
        </AjaxSettings>
    </telerik:RadAjaxManager>
    
    <telerik:RadSplitter ID="RadSplitter1" runat="server" Width="100%" Height="100%"
        Orientation="Horizontal">
        <telerik:RadPane ID="PaneMenu" runat="server" Height="30px" Scrolling="None">
            <telerik:RadMenu runat="server" ID="ErpMapMenu" Width="100%" OnClientItemClicked="ErpMapMenu_OnClientItemClickController">
                <Items>
                    <telerik:RadMenuItem>
                        <ItemTemplate>
                            <div style="margin: 3px 0px 0px 3px;">
                                <telerik:RadTextBox ID="txtSearchMap" runat="server" EmptyMessage="Input text to search">
                                    <ClientEvents OnKeyPress="txtSearchMap_OnKeyPress" />
                                </telerik:RadTextBox>
                            </div>
                        </ItemTemplate>
                    </telerik:RadMenuItem>
                    <telerik:RadMenuItem IsSeparator="true" />
                  <%--  <telerik:RadMenuItem>
                        <ItemTemplate>
                            <div style="margin: 0px 0px 0px 0px;">
                                <input type="checkbox" id="ckbGrid_TEST" onclick="changeDisplayGrid()" value="Grid" />Display
                                Grid
                            </div>
                        </ItemTemplate>
                    </telerik:RadMenuItem>--%>
                    <telerik:RadMenuItem>
                        <ItemTemplate>
                            <div style="margin: 0px 0px 0px 0px;">
                                <input type="checkbox" id="ckbTraffic" name="ckbTraffic" value="Traffic" onclick="radioChangeMap(this.value)" />Traffic
                            </div>
                        </ItemTemplate>
                    </telerik:RadMenuItem>
        <%--            <telerik:RadMenuItem Text="Map Types">
                        <Items>
                            <telerik:RadMenuItem Text="Map" Value="Map" />
                            <telerik:RadMenuItem Text="Terrain" Value="Terrain" />
                            <telerik:RadMenuItem Text="Satellite" Value="Satellite" />
                            <telerik:RadMenuItem Text="Hybrid" Value="Hybrid" />
                        </Items>
                    </telerik:RadMenuItem>--%>
                    <telerik:RadMenuItem IsSeparator="true" />
                    <telerik:RadMenuItem Text="Location" Value="Location" />
                    <telerik:RadMenuItem IsSeparator="true" />
                    <telerik:RadMenuItem Text="Activity" Value="Activity" />
                    <telerik:RadMenuItem IsSeparator="true" />
                    <telerik:RadMenuItem Text="Search" Value="Search" />
                    <telerik:RadMenuItem IsSeparator="true" />
                    <telerik:RadMenuItem Text="Planning and Optimise " Value="PlanningAndOptimise" />
                    <telerik:RadMenuItem IsSeparator="true" />
                    <telerik:RadMenuItem Text="Audit" Value="Audit" />
                    <telerik:RadMenuItem IsSeparator="true" />
                    <telerik:RadMenuItem Text="Legend" Value="Legend" />
                    <telerik:RadMenuItem IsSeparator="true" />
                </Items>
            </telerik:RadMenu>
        </telerik:RadPane>
        <telerik:RadPane ID="PaneMap" runat="server" Scrolling="None" Height="100%">
            <input id="slctOptimazePoint" type="hidden" value="" />
            <div id="grise" style="display: none;">
            </div>
            <div id="maxTab" style="display: none;">
                <ul id="tabnav">
                    <li class="active" id="tabDetails"><a href="#" onclick="changeContent('Details');">Details</a></li>
                    <li class="" id="tabTasks"><a href="#" onclick="changeContent('Tasks');">Tasks</a></li>
                    <li class="" id="tabWorksTimes"><a href="#" onclick="changeContent('WorksTimes');">Works
                        Times</a></li>
                </ul>
                <div class="contentTab">
                    <div style="padding-top: 3px; padding-right: 3px; text-align: right;">
                        <img onclick='$("#maxTab").stop(true, true).delay(10).slideUp(10);' alt="" src="http://maps.gstatic.com/intl/en_gb/mapfiles/iw_close.gif" /></div>
                    <div id="ContentInfo">
                    </div>
                </div>
            </div>
            <div class="contentTab" id="ContentDetails" style="display: none;">
            </div>
            <div class="contentTab" id="ContentTasks" style="display: none;">
            </div>
            <div class="contentTab" id="ContentWorksTimes" style="display: none;">
            </div>
            <div id="logAlert" style="display: none;">
            </div>
            <div id="loading">
                <img src="Resources/icons/ajax-loader.gif" alt="loading..." />
            </div>
            <div id="DivSetTask" style="display:none;">
                <div class="bottomIE7">
                    <div class="topIE7">
                        <div class="top"></div>
                            <table>
                                <tr>
                                    <td>
                                        Activity:
                                    </td>
                                    <td>
                                        <label id="lblActivityId"></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Coordinator:
                                    </td>
                                    <td>
                                        <telerik:RadComboBox ID="RadComboBox1" runat="server" Height="100px" Width="130px"
                                        EmptyMessage="Select an Employee" EnableLoadOnDemand="true" ShowMoreResultsBox="true"
                                        DropDownWidth="150px" OnItemsRequested="cbxEmployees_ItemsRequested">
                                        </telerik:RadComboBox>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Start Date:
                                    </td>
                                    <td>
                                        <telerik:RadDatePicker ID="RadDatePickerStartTask" runat="server" Width="140px"
                                                    DateInput-EmptyMessage="Start" MinDate="01/01/1000" MaxDate="01/01/3000" DateInput-Enabled="false" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        End Date:
                                    </td>
                                    <td>
                                        <telerik:RadDatePicker ID="RadDatePickerEndTask" runat="server" Width="140px"
                                                    DateInput-EmptyMessage="End" MinDate="01/01/1000" MaxDate="01/01/3000" DateInput-Enabled="false" />
                                    </td>
                                </tr>
                            
                            </table>
                            <asp:Button CssClass="buttonSmaller" runat="server" ID="Button12"
                                OnClientClick="closeSetTask();return false;" Text="Cancel" Width="80px" />
                            <asp:Button CssClass="buttonSmaller" runat="server" ID="Button13"
                                OnClientClick="saveTask();return false;" Text="Save" Width="80px" />
                            <div class="bottom">
                            </div>
                        </div>
                    </div>
             
            </div>
            <div id="choiceDisplaySearchActivity" style="display: none;">
                <div class="bottomIE7">
                    <div class="topIE7">
                        <div class="top">
                        </div>
                        <div class="menu_search">
                            <div id="treeDiv1">
                                <table width="100%" id="tableact">
                                    <tbody id="tBodyAdvancedActSearch">
                                    </tbody>
                                </table>
                            </div>
                            <asp:Button onmouseout="this.blur();" CssClass="buttonSmaller" runat="server" ID="Button9"
                                OnClientClick="refreshMap();requestSearchAdvanced(); return false;" Text="Search" Width="80px" />
                        </div>
                        <div class="bottom">
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="tree" style="display: none;">
            <div class="bottomIE7">
                    <div class="topIE7">
                <div class="top"></div>

                            <div class="menu_search">
                                <a onclick='$("#tree").stop(true, true).delay(1).slideUp(250);'>close</a>
                                <ul>
                                    <li>
                                        <telerik:RadTreeView CssClass="tree" ID="treeViewProjects" OnClientContextMenuItemClicking="onClientContextMenuItemClicking" CheckBoxes="True" runat="server" OnNodeExpand="treeViewProjects_NodeExpand"
                                            OnClientNodeChecked="onClientNodeChecked" Width="100%" Height="240px" CheckChildNodes="true" >
                                            <ContextMenus>
                                                <telerik:RadTreeViewContextMenu ID="ProjectContextMenu" runat="server">
                                                    <Items>
                                                        <telerik:RadMenuItem Value="Set" Text="Set project">
                                                        </telerik:RadMenuItem>                                                       
                                                    </Items>
                                                </telerik:RadTreeViewContextMenu>
                                            </ContextMenus>                                            
                                        </telerik:RadTreeView>
                                    </li>
                                </ul>
                            </div>
                    <div class="bottom">
                    </div>
                   </div>
                   </div>
            </div>
                 
            <div id="choiceDisplaySearchLocation" style="display: none;">
             <div class="top"></div>
                <div class="bottomIE7">
                    <div class="topIE7">

                        <div class="menu_search">
                            <div id="plusLocationAdvanced">
                                <table width="100%">
                                    <tbody id="tBodyAdvancedLocationSearch">
                                    </tbody>
                                </table>
                            </div>
                            <asp:Button CssClass="buttonSmaller" ID="Button2" Text="search" runat="server" OnClientClick="refreshMap();requestSearchAdvancedLoc();return false;"
                                Width="80px" />
                        </div>
                        <div class="bottom">
                        </div>
                    </div>
                </div>
            </div>
        
            <div id="choiceDisplay">
                <div id="DisplayDay" class="DisplayDay" style="display: none; margin-top: 10px;margin-bottom: 10px;">
                    <div id="dayChoose"></div>
                    <table style="border-bottom:2px solid #CCCCCC">
                        <tbody id="tableForChooseDay"></tbody>      
                    </table>       
                </div>
                
               
                <div id="DivActivity" class="decale" style="display: none; margin-top: 10px;margin-bottom: 10px;">
                 <div class="top"></div>
                    <div class="bottomIE7">
                        <div class="topIE7" id="top">
                            <div class="element_menu">
                                <div onclick="show('activitiesSlide','plusAct');closeAll('activitiesSlide');">
                                    <table width="100%">
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                <b>Activities</b>
                                            </td>
                                            <td align="right" style="float: right; padding-right: 10px;">
                                                <b id="plusAct">[-]</b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="activitiesSlide">
                                    <ul>
                                        <li>
                                            <input id="ckbReact" type="checkbox" onclick="return ckbReact_onclick()" value="REACTIVE"
                                                accesskey="R" /><u>R</u>eactive</li>
                                        <li style="display: none;">
                                            <input id="ckbRecurrent" type="checkbox" onclick="return ckbRecurrent_onclick()"
                                                value="RECURRENT" accesskey="t" />Recurren<u>t</u></li>
                                        <li>
                                            <input id="ckbQuote" type="checkbox" onclick="return ckbQuote_onclick()" value="QUOTE"
                                                accesskey="q" /><u>Q</u>uote</li>
                                    </ul>
                                </div>
                                <div onclick="showRefSerach('choiceDisplaySearchActivity','plusActAdvanced','')">
                                    <table width="100%">
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                <b>Advanced search</b>
                                            </td>
                                            <td align="right" style="float: right; padding-right: 10px;">
                                                <b id="plusActAdvanced">[+]</b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="bottom">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="DivLocation" class="decale" style="display: none; margin-top: 10px;margin-bottom: 10px;">
                 <div class="top"></div>
                    <div class="bottomIE7">
                        <div class="topIE7">
                            <div class="element_menu">
                                <div onclick="show('locationSlide','plusLoc');closeAll('locationSlide');">
                                    <table width="100%">
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                <b>Locations</b>
                                            </td>
                                            <td align="right" style="padding-right: 10px;">
                                                <b id="plusLoc">[+]</b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="locationSlide" style="display: none; margin: 0px;">
                                    <ul>
                                        <li>
                                            <input id="ckb132" type="checkbox" onclick="return ckb132_onclick()" value="Grid"
                                                accesskey="g" /><u>G</u>rid (132 Kv)</li>
                                        <li>
                                            <input id="ckb33" type="checkbox" onclick="return ckb33_onclick()" value="Primary"
                                                accesskey="p" /><u>P</u>rimary (33 Kv)</li>
                                        <li style="display: none;">
                                            <input id="ckb11" type="checkbox" onclick="return ckb11_onclick()" value="Secondary"
                                                accesskey="s" /><u>S</u>econdary (11 Kv)</li>
                                    </ul>
                                </div>
                                <div onclick="showRefSerachLocation('choiceDisplaySearchLocation','plusLocAdvanced')">
                                    <table width="100%">
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                <b>Advanced search</b>
                                            </td>
                                            <td align="right" style="float: right; padding-right: 10px;">
                                                <b id="plusLocAdvanced">[+]</b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="bottom">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="DivSearch" class="decale" style="display: none; margin-top: 10px;margin-bottom: 10px;">
                <div class="top"></div>
                    <div class="bottomIE7">
                        <div class="topIE7">
                            <div class="element_menu">
                                <div onclick="show('searchSlide','plusSearch');closeAll('searchSlide');">
                                    <table width="100%">
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                <b>Search</b>
                                            </td>
                                            <td align="right" style="float: right; padding-right: 10px;">
                                                <b id="plusSearch">[+]</b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="searchSlide" style="display: none;">
                                    <ul style="margin-bottom: -3px;">
                                        <li>
                                            <telerik:RadTextBox ID="txtAddress" runat="server" EmptyMessage="Place" OnClientClick="this.select()" />
                                            <asp:Button CssClass="buttonSmallest" ID="Button3" Text="Go" runat="server" OnClientClick="GoAddress();return false;"
                                                Width="57px" />
                                        </li>
                                        <li>
                                            <telerik:RadTextBox ID="txtActivity" runat="server" EmptyMessage="Activity Id" />
                                            <asp:Button CssClass="buttonSmallest" ID="Button4" Text="Go" runat="server" OnClientClick="GoActivity();return false;"
                                                Width="57px" />
                                                </li>
                                            <li>
                                                <%--<input id="txtLocation" name="txtLocation" type="text" value="Location Name" onclick="this.select()"
                                        class="selectSub" onkeyup="lookup()" style="margin-bottom: -5px;" />
                                    <input type="button" value="Go" onclick="GoLocation()" />--%>
                                                <telerik:RadComboBox ID="cbxLocations" runat="server" Width="130px" Height="100px"
                                                    EmptyMessage="Search a Location" EnableLoadOnDemand="true" ShowMoreResultsBox="true"
                                                    EnableVirtualScrolling="true" OnItemsRequested="cbxLocations_ItemsRequested">
                                                </telerik:RadComboBox>
                                                <asp:Button CssClass="buttonSmallest" ID="Button7" Text="Go" runat="server" OnClientClick="GoLocation();return false;"
                                                    Width="57px" />
                                            </li>
                                    </ul>
                                    <div id="txtShow" style="padding: 0; overflow: scroll; width: 157px; height: 150px;
                                        list-style-type: none; margin: 0; margin-left: 10px; display: none; z-index: 9999;
                                        border: 1px solid black; background-color: White;">
                                    </div>
                                </div>
                            </div>
                            <div class="bottom">
                            </div>
                        </div>
                    </div>
                </div>

                  <div id="DivSearchAdvancedOptimise" class="decale" style="display: none; margin-top: 10px;margin-bottom: 10px;">
                    <div class="top">
                    </div>
                    <div class="bottomIE7">
                        <div class="topIE7">
                        <div class="element_menu">
                            <div onclick="showRefSerach('choiceDisplaySearchActivity','plusActAdvancedOpti','opti')">
                                <table width="100%">
                                    <tr>
                                        <td style="padding-left: 7px;">
                                            <b>Search</b>
                                        </td>
                                        <td align="right" style="float: right; padding-right: 10px;">
                                            <b id="plusActAdvancedOpti">[+]</b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            </div>
                            <div class="bottom">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="DivList" class="decale" style="display:none; margin-top:10px;margin-bottom: 10px;">
                <div class="top"></div>
                    <div class="bottomIE7">
                        <div class="topIE7">
                            <div class="element_menu">
                                <div>
                                    <div id='Liste'>
                                        <table width="100%" onclick="show('addToActList','plusList'); show('addToActListButtons','');closeAll('addToActList');">
                                            <tr>
                                                <td style="padding-left: 7px;">
                                                    <b>Add list</b>
                                                </td>
                                                <td align="right" style="float: right; padding-right: 10px;">
                                                    <b id="plusList">[+]</b>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div id="addToActList" style="display: none;">
                                        <table id="tablelist" class="list" width="90%">
                                            <tbody id="list">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="addToActListButtons" style="display: none;">
                                        <table>
                                            <tr>
                                                <td>
                                                    <asp:Button onmouseout="this.blur();" CssClass="buttonSmaller" ID="Button1" Text="Create File"
                                                        runat="server" OnClientClick="createFile();return false;" Width="80px" />
                                                </td>
                                                <td>
                                                    <asp:Button onmouseout="this.blur();" CssClass="button" runat="server" ID="btnClearAll"
                                                        OnClientClick="erpMarkerAddCollection.toEmpty();refreshList(); return false;"
                                                        Text="Delete List" Width="105px" />
                                                </td>
                                                <td>
                                                    <img alt="refresh" src="Resources/icons/refresh.png" width="30px" onclick="setOrder();" />
                                                </td>
                                                <%-- <td>
                                                        <asp:Button runat="server" ID="btnShow" OnClientClick="showActSelect(); return false;"
                                                            Text="Show" />
                                                    </td>--%>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="bottom">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="DivProject" class="decale" style="display: none; margin-top: 10px; margin-bottom: 10px;">
                    <div class="top">
                    </div>
                    <div class="bottomIE7">
                        <div class="topIE7">
                            <div class="element_menu">
                                <div onclick="show('DivAddProject','plusProject')">
                                    <table width="100%">
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                <b>Add Project</b>
                                            </td>
                                            <td align="right" style="float: right; padding-right: 10px;">
                                                <b id="plusProject">[+]</b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="DivAddProject" style="display:none">
                                    <table>
                                        <tr>
                                            <td>
                                                Name :
                                            </td>
                                            <td>
                                                <telerik:RadTextBox ID="RadTextBoxProjectName" runat="server" EmptyMessage="Project Name" Width="140px"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Start Date Time :
                                            </td>
                                            <td>
                                                <telerik:RadDatePicker ID="RadDatePickerStartDateTime" runat="server" Width="140px"
                                                    DateInput-EmptyMessage="From" MinDate="01/01/1000" MaxDate="01/01/3000" DateInput-Enabled="false" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                End Date Time :
                                            </td>
                                            <td>
                                                <telerik:RadDatePicker ID="RadDatePickerEndDateTime" runat="server" Width="140px"
                                                    DateInput-EmptyMessage="To" MinDate="01/01/1000" MaxDate="01/01/3000" DateInput-Enabled="false" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Status :
                                            </td>
                                            
                                                <td>
                                                
                                                <telerik:RadComboBox ID="RadComboBoxProjectStatus" runat="server" Width="130px"/>
                                                
                                                <%--<select id="ProjectStatut" name="ProjectStatut">
                                                </select>--%>
                                               
                                            </td>
                                        </tr>
                                        <tr>
                                              <td>
                                                Calendar :
                                            </td>
                                            
                                                <td>
                                                <select id="ProjectCalendar" name="ProjectCalendar">
                                                </select>                                               
                                            </td>
                                        </tr>
                                      
                                    </table>
                                      <asp:Button CssClass="buttonSmallest" ID="Button10" Text="Add" runat="server" OnClientClick="addProject();return false;"
                                            Width="57px" />
                                        <asp:Button CssClass="buttonSmaller" ID="Button11" Text="Planning" runat="server"
                                                    OnClientClick="setPlanningOrder();return false;" Width="80px" />
                                </div>
                            </div>
                            <div class="bottom">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="DivGetProject" class="decale" style="display: none; margin-top: 10px;margin-bottom: 10px;">
                    <div class="top">
                    </div>
                    <div class="bottomIE7">
                        <div class="topIE7">
                        <div class="element_menu">
                            <div onclick="show('GetProject','plusGetProject');">
                                <table width="100%">
                                    <tr>
                                        <td style="padding-left: 7px;">
                                            <b>Current Project</b>
                                        </td>
                                        <td align="right" style="float: right; padding-right: 10px;">
                                            <b id="plusGetProject">[+]</b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div id="GetProject" style="display:none">
                                <table>
                                     <tr>
                                        <td>
                                            Name :
                                        </td>
                                        <td>
                                            <label id="getNameProject"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Start Date Time :
                                        </td>
                                        <td>
                                            <label id="getStartDateTimeProject"></label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            End Date Time :
                                        </td>
                                        <td>
                                           <label id="getEndDateTimeProject"></label>
                                        </td>
                                    </tr>
                                   
                                </table>
                                <asp:Button CssClass="buttonSmaller" ID="Button15" Text="Update" runat="server"
                                OnClientClick="setPlanningOrderForAProject();return false;" Width="80px" />
                            </div>
                            
                            </div>
                            
                            <div class="bottom">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="DivPlanningAndOptimise" class="decale" style="display: none;margin-bottom: 10px;">
                <div class="top"></div>
                    <div class="bottomIE7">
                        <div class="topIE7">
                            <div class="element_menu">
                                <table width="100%">
                                    <tr>
                                        <td style="padding-left: 7px;">
                                            <b>Optimize Road</b>
                                        </td>
                                        <td align="right" style="float: right; padding-right: 10px;">
                                            <input id="ckbOptimize" type="checkbox" onclick="diplayOptimize();" />
                                        </td>
                                    </tr>
                                </table>
                                <div id="OptimiseRoad" style="display: none;">
                                    <table>
                                        <tr>
                                            <td>
                                                Departure
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select onchange="ChangeSlct('Departure');" id="slctDeparture">
                                                    <option value="Company's HQ" selected="selected">Company's HQ</option>
                                                    <option value="Custom">Custom</option>
                                                    <option value="Employee's house">Employee's house</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <div id="tdEmployeesDeparture" style="display: none;">
                                        <select onchange="ChangeSlct('EmployeesDeparture');" id="slctEmployeesDeparture">
                                        </select>
                                    </div>
                                    <table>
                                        <tr>
                                            <td>
                                                Arrival
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <select onchange="ChangeSlct('Arrival');" id="slctArrival">
                                                    <option value="Company's HQ" selected="selected">Company's HQ</option>
                                                    <option value="Custom">Custom</option>
                                                    <option value="Employee's house">Employee's house</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <div id="tdEmployeesArrival" style="display: none;">
                                        <select onchange="ChangeSlct('EmployeesArrival');" id="slctEmployeesArrival">
                                        </select>
                                    </div>
                                    <table>
                                        <tr>
                                            <td>
                                                <select id="slctOptimize">
                                                    <option value="google" id="optGoogle" selected="selected">Google</option>
                                                    <option value="closest" disabled="disabled">Closest</option>
                                                    <option value="furthest" disabled="disabled">Furthest</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <asp:Button CssClass="buttonSmaller" ID="btnOptimize" Text="Calculate" runat="server"
                                                    OnClientClick="goOptimise();return false;" Width="80px" />
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                        
                                            <td>
                                                <b>Depature :</b>
                                                <label id="lblCoordinateDeparture">
                                                    Marl Road, Kirkby Knowsley Industrial Park, Liverpool, Merseyside L33 7UH</label>
                                               
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                        
                                            <td>
                                                <b>Arrival :</b>
                                                <label id="lblCoordinateArrival">
                                                    Marl Road, Kirkby Knowsley Industrial Park, Liverpool, Merseyside L33 7UH</label>
                                            </td>
                                        </tr>
                                    </table>
                                    <hr />
                                    <table>
                                        <tr>                                      
                                            <td>
                                                <b>Distance :</b>
                                                <label id="Distance"></label>
                                            </td>
                                        </tr>                                
                                    </table>
                                </div>
                            </div>
                            <div class="bottom">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="DivLegend" class="decale" style="display: none; margin-top: 10px;margin-bottom: 10px;">
                <div class="top"></div>
                    <div class="bottomIE7">
                        <div class="topIE7">
                            <div class="element_menu">
                                <div onclick="show('legendDisplay','plusLe');closeAll('legendDisplay');">
                                    <div id='Legend'>
                                        <table width="100%">
                                            <tr>
                                                <td style="padding-left: 7px;">
                                                    <b>Legend</b>
                                                </td>
                                                <td align="right" style="float: right; padding-right: 10px;">
                                                    <b id="plusLe">[+]</b>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div id="legendDisplay" style="display: none;" class="elementnu">
                                    <b style="padding-left: 5px; padding-right: 5px;">Activities </b>
                                    <table>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Reactive defaut :
                                            </td>
                                            <td align="right" width="40%">
                                                <img src="Resources/icons/reactive.png" width="25%" alt="reactive" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Reactive unplanned:
                                            </td>
                                            <td align="right" width="40%">
                                                <img src="Resources/icons/reactiveRed.png" width="25%" alt="reactive" style="float: right;" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Reactive planned:
                                            </td>
                                            <td align="right" width="40%">
                                                <img src="Resources/icons/reactiveOrange.png" width="25%" alt="reactive" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Reactive started:
                                            </td>
                                            <td align="right" width="40%">
                                                <img src="Resources/icons/reactiveGreen.png" width="25%" alt="reactive" style="float: right;" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Recurrent :
                                            </td>
                                            <td align="right" width="40%">
                                                <img src="Resources/icons/recurrent.png" width="25%" alt="recurrent" style="float: right;" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Quote :
                                            </td>
                                            <td align="right" width="40%">
                                                <img src="Resources/icons/quote.png" width="25%" alt="quote" style="float: right;" />
                                            </td>
                                        </tr>
                                    </table>
                                    <b style="padding-left: 5px;">Location</b>
                                    <table>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Secondary 11Kv
                                            </td>
                                            <td align="right" width="49%">
                                                <img src="Resources/icons/11Kv.png" width="20%" alt="Secondary" align="right" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Primary 33Kv
                                            </td>
                                            <td align="right" width="49%">
                                                <img src="Resources/icons/33Kv.png" width="20%" alt="Primary" align="right" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Grid 132Kv
                                            </td>
                                            <td align="right" width="49%">
                                                <img src="Resources/icons/132Kv.png" width="20%" alt="Grid" align="right" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="bottom">
                            </div>
                        </div>
                    </div>
                </div>
                <%--        <div class="bottomIE7">
                <div class="topIE7">
                    <div class="top">
                    </div>
                    <div class="element_menu">
                        <div onclick="show('mapOption','plusOp');closeAll('mapOption');">
                            <table width="100%">
                                <tr>
                                    <td style="padding-left: 7px;">
                                        <b>Map options</b>
                                    </td>
                                    <td align="right" style="float: right; padding-right: 10px;">
                                        <b id="plusOp">[+]</b>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div id="mapOption" style="display: none;">
                            <ul>
                                <li>
                                    <input id="ckbGrid" type="checkbox" onclick="changeDisplayGrid()" value="Grid" />Display
                                    Grid</li>
                                <li>
                                    <input type="checkbox" id="ckbTraffic" name="ckbTraffic" value="Traffic" onclick="radioChangeMap(this.value)" />
                                    Traffic<br />
                                </li>
                                <li>
                                    <input type="radio" name="groupRadioForMap" value="Terrain" onclick="radioChangeMap(this.value)" />
                                    Terrain<br />
                                </li>
                                <li>
                                    <input type="radio" name="groupRadioForMap" value="Satellite" onclick="radioChangeMap(this.value)" />
                                    Satellite<br />
                                </li>
                                <li>
                                    <input type="radio" name="groupRadioForMap" value="Hybride" onclick="radioChangeMap(this.value)" />
                                    Hybride<br />
                                </li>
                                <li>
                                    <input type="radio" name="groupRadioForMap" value="Map" onclick="radioChangeMap(this.value)"
                                        checked="checked" />
                                    Map<br />
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="bottom">
                    </div>
                </div>
            </div>--%>
                <div id="DivAddActivities" class="decale" style="display: none; margin-top: 10px;margin-bottom: 10px;">
                <div class="top"></div>
                    <div class="bottomIE7">
                        <div class="topIE7">
                            <div class="element_menu">
                                <div onclick="show('adact','plusAddAct');closeAll('adact');">
                                    <table width="100%">
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                <b>Add Activities</b>
                                            </td>
                                            <td align="right" style="float: right; padding-right: 10px;">
                                                <b id="plusAddAct">[+]</b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="adact" style="display: none;">
                                    <table id="tableAddActivity">
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Name :
                                            </td>
                                            <td>
                                                <input name="txtActivityAddName" size="18" id="txtActivityAddName" type="text" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Description :
                                            </td>
                                            <td>
                                                <textarea name="txtDescriptionAddName" id="txtDescriptionAddName" rows="3" cols="15"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Customer :
                                            </td>
                                            <td>
                                                <telerik:RadComboBox ID="slctAddCustomersId" runat="server" Width="150px"
                                                MarkFirstMatch="true" ChangeTextOnKeyBoardNavigation="false" OnClientSelectedIndexChanged="loadPriority">
                                                </telerik:RadComboBox>
                                                <%--<select name="slctAddCustomersId" id="slctAddCustomersId" onclick='completeSelectActivityModulesForAddActivity();'>
                                                </select>--%>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Module :
                                            </td>
                                            <td>
                                                <telerik:RadComboBox ID="slctAddActivityModulesId" runat="server" Width="150px"
                                                MarkFirstMatch="true" ChangeTextOnKeyBoardNavigation="false" OnClientSelectedIndexChanged="loadProgramme">
                                                </telerik:RadComboBox>
                                                <%--<select name="slctAddActivityModulesId" id="slctAddActivityModulesId" onclick='completeSelectActivityPrioritiesForAddActivity();'>
                                                </select>--%>
                                            </td>
                                        </tr>
                                       
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Programme :
                                            </td>
                                            <td>
                                                <telerik:RadComboBox ID="slctAddActivityProgrammesId" runat="server" Width="150px"
                                                MarkFirstMatch="true" OnItemsRequested="slctProgrammes_ItemsRequested" OnClientSelectedIndexChanged="loadCategory">
                                                </telerik:RadComboBox>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Category :
                                            </td>
                                            <td>
                                                <telerik:RadComboBox ID="slctAddActivityCategoriesId" runat="server" Width="150px"
                                                MarkFirstMatch="true" OnItemsRequested="slctCategories_ItemsRequested" >
                                                </telerik:RadComboBox>
                                            </td>
                                        </tr>
                                         <tr>
                                            <td style="padding-left: 7px;">
                                                Priority :
                                            </td>
                                            <td>
                                                <telerik:RadComboBox ID="slctAddActivityPrioritiesId" runat="server" Width="150px"
                                                MarkFirstMatch="true" OnItemsRequested="slctPriority_ItemsRequested" >
                                                </telerik:RadComboBox>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            </td>
                                            <td>
                                                <asp:Button onmouseout="this.blur();" CssClass="button" runat="server" ID="Button5"
                                                    OnClientClick="var answer = confirm('You really want to create the activities?');
                                                if(answer){
                                                    if(addActivity()){ 
                                                        erpMarkerAddCollection.toEmpty();
                                                        refreshList();
                                                    } 
                                                }
                                                return false;" Text="Add Activities" Width="105px" />
                                                <%-- <input id="btnAddActivity" type="button" value="Add Activities" onclick="" />--%>
                                                <input id="hiddenInputActivity" name="hiddenInputActivity" type="hidden" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="bottom">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="DivAudit" class="decale" style="display: none; margin-top: 10px;margin-bottom: 10px;">
                <div class="top"></div>
                    <div class="bottomIE7">
                        <div class="topIE7">
                            <div class="element_menu">
                                <div onclick="show('showAudit','audit');closeAll('showAudit');">
                                    <table width="100%">
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                <b>Audit</b>
                                            </td>
                                            <td align="right" style="float: right; padding-right: 10px;">
                                                <b id="audit">[+]</b>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="showAudit" style="display: none;">
                                    <div id="selectAudit" style="padding-left: 8px;">
                                        <hr />
                                        <table>
                                            <tr>
                                                <b>Create Audit</b></tr>
                                            <tr>
                                                <td>
                                                    Activity :
                                                </td>
                                                <td>
                                                    <select id="slctModuleAudit">
                                                        <option value="REACTIVE">Reactive</option>
                                                        <option value="RECURRENT">Recurrent</option>
                                                        <option value="QUOTE">Quote</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <%--Test calendar --%>
                                            <tr>
                                                <td>
                                                    From :
                                                </td>
                                                <td>
                                                    <telerik:RadDatePicker ID="dateFrom" runat="server" Width="140px" DateInput-EmptyMessage="From"
                                                        MinDate="01/01/1000" MaxDate="01/01/3000" DateInput-Enabled="false" />
                                                    <%--<input type="text" id="dateFrom" name="dateFrom" value="" size="12" onclick="cal.select(this,'dateFrom','yyyy-MM-dd'); return false;" />--%>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    To :
                                                </td>
                                                <td>
                                                    <telerik:RadDatePicker ID="dateTo" runat="server" Width="140px" DateInput-EmptyMessage="To"
                                                        MinDate="01/01/1000" MaxDate="01/01/3000" DateInput-Enabled="false" />
                                                </td>
                                            </tr>
                                        </table>
                                        <asp:Button onmouseout="this.blur();" CssClass="buttonSmaller" runat="server" ID="Button6"
                                            OnClientClick="searchAudit(); return false;" Text="Search" Width="80px" />
                                    </div>
                                    <div id="createAudit" style="padding-left: 8px;">
                                        <hr>
                                            <table>
                                                <tr>
                                                    <b>Create Audit</b></tr>
                                                <tr>
                                                    <td>
                                                        <label>
                                                            Audited By:</label>
                                                    </td>
                                                    <td>
                                                        <telerik:RadComboBox ID="cbxAuditedBy" runat="server" Height="100px" Width="130px"
                                                        EmptyMessage="Select an Employee" EnableLoadOnDemand="true" ShowMoreResultsBox="true"
                                                        DropDownWidth="150px" OnItemsRequested="cbxEmployees_ItemsRequested">
                                                        </telerik:RadComboBox>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>
                                                            Audit Place:</label>
                                                    </td>
                                                    <td>
                                                        <%--<select name="auditPlace" id="auditPlace">
                                                            <option value="0">Site</option>
                                                            <option value="1">Media</option>
                                                        </select>--%>
                                                        <telerik:RadComboBox ID="auditPlace" runat="server" Width="130px"/>
                                                    </td>
                                                </tr>
                                            </table>
                                        </hr>
                                        <asp:Button onmouseout="this.blur();" CssClass="button" runat="server" ID="Button8"
                                            OnClientClick="var answer = confirm('You really want to create the audit?');
                                                
                                                if(answer){          
                                                    if(addAudit()){
                                                        erpMarkerAddCollection.toEmpty();
                                                        refreshList();
                                                        refreshMap();
                                                        loading('visible');
                                                    } 
                                                    return false;
                                                }
                                                return false;" Text="Add Audit" Width="105px" />
                                        <input id="hiddenInputAudit" name="hiddenInputAudit" type="hidden" />
                                        <input id="auditedBy" name="auditedBy" type="hidden" value="" />
                                        <input id="auditPlacehidden" name="auditPlacehidden" type="hidden" value="" />
                                    </div>
                                </div>
                            </div>
                            <div class="bottom">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="DivAddLocation" class="decale" style="display: none; margin-top: 10px;">
                    <div class="top"></div>
                    <div class="topIE7">
                    <div class="bottomIE7">
                        
                            <div class="element_menuDivAddLocation">
                                <table width="100%">
                                    <tr>
                                        <td style="padding-left: 7px;">
                                            <b>Add Location</b>
                                        </td>
                                    </tr>
                                </table>
                                <div id="addLocation">
                                    <table id="table1">
                                        <tr id="trTypeLocation">
                                            <td style="padding-left: 7px;">
                                                Type :
                                            </td>
                                            <td>
                                              <telerik:RadComboBox ID="slctLocationAddTypesId" runat="server" Height="200px" Width="200px"
                                                MarkFirstMatch="true" ChangeTextOnKeyBoardNavigation="false">
                                                </telerik:RadComboBox>
                                            </td>
                                        </tr>
                                        <tr id="trNameLocation" style="display: none;">
                                            <td style="padding-left: 7px; width: 180px">
                                                Name :
                                            </td>
                                            <td style="width: 180px;">
                                                <input name="txtLocationAddName" size="18" id="txtLocationAddName" type="text" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Data Protection :
                                            </td>
                                            <td>
                                                <input name="ckbDataProtection" id="ckbDataProtection" type="checkbox" onclick='completeSelectLocationCustomersForLocation()' />
                                            </td>
                                        </tr>
                                        <tr id="trCustomerLocation" style="display: none;">
                                            <td style="padding-left: 7px; width: 180px">
                                                Customer :
                                            </td>
                                            <td>
                                                <%--<select name="slctLocationAddCustomersId" id="slctLocationAddCustomersId" onclick='completeSelectActivityModulesForAddActivity();'>
                                                </select>--%>
                                                
                                                <telerik:RadComboBox ID="slctLocationAddCustomersId" runat="server" Height="200px" Width="200px"
                                                MarkFirstMatch="true" ChangeTextOnKeyBoardNavigation="false" >
                                                </telerik:RadComboBox>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Line 1 :
                                            </td>
                                            <td>
                                                <%--<input name="txtLine1" id="txtLine1" type="text" onblur='moveMarker("Line1")' />--%>
                                                <asp:TextBox runat="server" ID="txtLine1" ValidationGroup="LocationInsert" />
                                                <asp:RequiredFieldValidator ID="RequiredFieldValidator1" runat="server" ErrorMessage="Line 1 cannot be empty"
                                                    Text="*" ControlToValidate="txtLine1" ValidationGroup="LocationInsert" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Line 2 :
                                            </td>
                                            <td>
                                                <input name="txtLine2" id="txtLine2" type="text" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Line 3 :
                                            </td>
                                            <td>
                                                <input name="txtLine3" id="txtLine3" type="text" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Line 4 :
                                            </td>
                                            <td>
                                                <input name="txtLine4" id="txtLine4" type="text" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Post Code :
                                            </td>
                                            <td>
                                                <input name="txtPostCode" id="txtPostCode" type="text" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Country :
                                            </td>
                                            <td>
                                                <input name="txtCountry" id="txtCountry" type="text" disabled="disabled" />
                                            </td>
                                        </tr>
                                        <tr style="display: none;">
                                            <td style="padding-left: 7px;">
                                                Latitude :
                                            </td>
                                            <td>
                                                <input name="txtLatitudeLocation" type="hidden" id="txtLatitudeLocation" />
                                            </td>
                                        </tr>
                                        <tr style="display: none;">
                                            <td style="padding-left: 7px;">
                                                Longitude :
                                            </td>
                                            <td>
                                                <input name="txtLongitudeLocation" type="hidden" id="txtLongitudeLocation" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                            </td>
                                            <td align="right" style="float: right; padding-right: 10px;">
                                                <img id="imgClose" src="Resources/icons/closeDetails.png" onclick="showDetailsAddLoc('open')"
                                                    alt="show" />
                                                <img id="imgOpen" src="Resources/icons/openDetails.png" onclick="showDetailsAddLoc('close')"
                                                    alt="show" style="display: none;" />
                                            </td>
                                        </tr>
                                    </table>
                                    <table id="tableDetailsAddLocation" style="display: none;">
                                        <tr>
                                            <td style="padding-left: 7px; width: 180px">
                                                County :
                                            </td>
                                            <td style="width: 180px">
                                             <telerik:RadComboBox ID="slctCounty" runat="server"
                                                MarkFirstMatch="true" ChangeTextOnKeyBoardNavigation="false">
                                                </telerik:RadComboBox>
                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Comment 1 :
                                            </td>
                                            <td>
                                                <textarea name="txtComment1" id="txtComment1" rows="3" cols="17"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Comment 2 :
                                            </td>
                                            <td>
                                                <textarea name="txtComment2" id="txtComment2" rows="3" cols="17"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Comment 3 :
                                            </td>
                                            <td>
                                                <textarea name="txtComment3" id="txtComment3" rows="3" cols="17"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                Landranger Grid Reference :
                                            </td>
                                            <td>
                                                <input type="text" name="txtLandrangerGridReference" id="txtLandrangerGridReference"
                                                    size="5" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                OSgrid x :
                                            </td>
                                            <td>
                                                <input type="text" name="txtOSgridX" id="txtOSgridX" size="5" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="padding-left: 7px;">
                                                OSgrid Y :
                                            </td>
                                            <td>
                                                <input type="text" name="txtOSgridY" id="txtOSgridY" size="5" />
                                            </td>
                                        </tr>
                                    </table>
                                    <table>
                                        <tr>
                                            <td>
                                            </td>
                                            <td>
                                                <%--<input id="btnAddLocation" type="button" value="Add Location" onclick="addLocation()" />--%>
                                                <asp:Button runat="server" ID="btnAddLocation" Text="Add Location" OnClientClick="var answer = confirm('You really want to create the location?');
                                                if(answer)addLocation(); return false;" ValidationGroup="LocationInsert" />
                                                <br />
                                                <asp:ValidationSummary ID="ValidationSummary1" ValidationGroup="LocationInsert" HeaderText="You must enter a value in the following fields:"
                                                    DisplayMode="BulletList" EnableClientScript="true" runat="server" />
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="bottom">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="map_canvas">
            </div>
            <telerik:RadContextMenu ID="ErpMapContextMenu" runat="server" EnableRoundedCorners="true"
                EnableShadows="true" OnClientItemClicked="ErpMapContextMenuManager">
                <Items>
                    <telerik:RadMenuItem Text="Add Location" Value="addLocation" />
                </Items>
            </telerik:RadContextMenu>
            <telerik:RadContextMenu ID="ErpMarkerContextMenu" runat="server" EnableRoundedCorners="true"
                EnableShadows="true" OnClientItemClicked="ErpMarkerContextMenuManager">
                <Items>
                    <telerik:RadMenuItem Text="Add in list" Value="add" />
                    <telerik:RadMenuItem Text="Del in list" Value="del" />
                </Items>
            </telerik:RadContextMenu>
        </telerik:RadPane>
        <telerik:RadPane ID="PaneInformation" runat="server" Height="22px" Scrolling="none">
            <telerik:RadSlidingZone ID="SlidingZoneInformation" runat="server" Height="22px"
                SlideDirection="Top" ClickToOpen="true">
                <telerik:RadSlidingPane ID="SPaneDetails" runat="server" Title="Details" Height="150px">
                </telerik:RadSlidingPane>
                <telerik:RadSlidingPane ID="SPaneTasks" runat="server" Title="Tasks" Height="150px">
                </telerik:RadSlidingPane>
                <telerik:RadSlidingPane ID="SPaneWorkTimes" runat="server" Title="Work times" Height="150px">
                </telerik:RadSlidingPane>
                <telerik:RadSlidingPane ID="SPaneStreetView" runat="server" Title="Street View" Height="350px">
                </telerik:RadSlidingPane>
            </telerik:RadSlidingZone>
        </telerik:RadPane>
    </telerik:RadSplitter>
    </form>
</body>
</html>