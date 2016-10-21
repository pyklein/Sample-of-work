var map;
var MarkerType = { "Activity": 0, "Location": 1, "None": 3 };
var dblClick = false;
var proxy, qbLocations, qbAzBooks, queryFilter, qbActivities;

var azBooks = [];
var erpMarkerCollection = new ErpMarkerCollection();
var markerClusterer;
var ckb132, ckb33, ckb11, ckbShowDirections, ckbReact, ckbRecurrent, ckbQuote;
var cbxLocations;
var searchMap_text;

var mapContainer;
var currentMarkerType = MarkerType.none;
var geocoder;
var search = true;
var currentZoom = 0;
var arrayPolygon = new Array();
var arrayImageMarker = new Array();
var arrayListActAdd = new Array();
var goAct = false;
var goLocation = false;
var applicationBaseUrl = "<%= ApplicationUrls.ApplicationBaseUrl %>";
var displayGrid = false;
var gEventMoveEnd;
var resQueryAct = new Array();

var erpMapMenu;

var directionsDisplay;

//----------------- Calendar day color ----------------------//
var weekDayColor = "white";
var weekDayOverColor = "#CCCCCC";
var weekEndDayColor = "red";
var weekEndDayOverColor = "blue";


//----------------- Search Menu -----------------------------//
var activitySearch;
var txtActivity;
var adressSearch;

//----------------- Audit Menu -----------------------------//
var dateFrom;
var dateTo;
var cbxAuditedBy;
var auditPlace;


var arrayStartStop = new Array('Departure', 'Arrival');

var markerLocationAdd = new google.maps.Marker({
        position: new google.maps.LatLng(0, 0),
        clickable: false,
        map: map,
        draggable: true,
        icon: "",
        zIndex: 10000,
        visible: false
    });


//----------------sliding Zone---------------------//
var detailsSlide ;
var tasksSlide;
var worktimesSlide;

//---------------- Project -------------------------//
var radDatePickerEndDateTime;
var radDatePickerStartDateTime;
var radTextBoxProjectName;
var radTree;
var ckbToDisplay;
var radComboBoxProjectStatus;
//var tabProjectDisplay = [];
//var tabActivityDisplay = [];
//var tabProjectCheckToDispay = new Array('Projects', 'Activities');
//tabProjectCheckToDispay['Projects'] = tabProjectDisplay; 
//tabProjectCheckToDispay['Activities'] = tabActivityDisplay;
var tree;



var erpMarkerAddCollection = new ErpMarkerCollection(); // must be global
var traffic; // must be global
var infowindow = "";
var y = 0;
var progListSearch = new Array();
var typeListSearch = new Array();
var customerListSearch = new Array();
var currentSearch = "";
var test = false;
var auditVisibility = "hidden";
var htmlWorkTimesG = "";
var htmlTasksG = "";
var htmlDetailsG = "";
var currentErpMarker = "";
var currentSelectAddActivity = ""; // must me globale for onSuccessCompleteSelectAddActivity()
var arrayLabel = new Array(); // must me global

//---------------- Context Menu ---------------------//
var erpMapContextMenu;
var erpMarkerContextMenu;

//---------------- AJAX Manager ---------------------//
var ajaxmgr;


//--------------- select auto generate ---------------//
var slctAddCustomersId;
var slctLocationAddCustomersId;
var slctAddActivityModulesId;
var slctAddActivityProgrammesId;
var slctAddActivityPrioritiesId;
var slctAddActivityCategoriesId;

//-------------- taks menu ---------------------------//
var radDatePickerStartTask;