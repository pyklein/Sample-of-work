using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Telerik.Web.UI;
using Connors.Framework.Model;

namespace Connors.Erp.Web.DynamicData.CustomPages.Locations
{
    public partial class List : ErpPage
    {
        #region Privates
        MainDataContext dc = new MainDataContext();
        String searchCriteria;
        char[] delimiters = new char[] { '|' };
        char[] delimitersSearch = new char[] { '^' };
        String[] ajaxRequestParameters;
        String ajaxRequestType;
        String ajaxRequestValue;
        String customerId;
        String regionId;
        String countyId;
        String locationTypeId;
        Boolean showArchived;
        private const int ItemsPerRequest = 10;
        RadComboBox cbxCustomers;
        RadComboBox cbxRegions;
        RadComboBox cbxCounties;
        RadComboBox cbxLocationTypes;
        #endregion

        #region Page Events
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                cbxCustomers = (RadComboBox)toolbarLocations.FindItemByValue("Filters").FindControl("cbxCustomers");
                Utilities.LoadCustomersInComboBox(cbxCustomers);

                cbxRegions = (RadComboBox)toolbarLocations.FindItemByValue("Filters").FindControl("cbxRegions");
                Utilities.LoadRegionsInComboBox(cbxRegions);

                cbxCounties = (RadComboBox)toolbarLocations.FindItemByValue("Filters").FindControl("cbxCounties");
                Utilities.LoadCountiesInComboBox(cbxCounties);

                cbxLocationTypes = (RadComboBox)toolbarLocations.FindItemByValue("Filters").FindControl("cbxLocationTypes");
                Utilities.LoadLocationTypesInComboBox(cbxLocationTypes);

                //SearchCriteria Session Variables
                Session["Search.SearchCriteria"] = null;
                Session["Search.CustomerId"] = null;
                Session["Search.RegionId"] = null;
                Session["Search.CountyId"] = null;
                Session["Search.LocationTypeId"] = null;
                Session["Search.ShowArchived"] = null;
            }
        }

        protected override void Render(HtmlTextWriter writer)
        {
            base.Render(writer);
            Global.Profile.MyGrid = new GridProfile();
            Global.Profile.MyGrid.SaveGridSettings(gridLocations, "LocationsGrid");
        }

        protected void Page_Init(object sender, EventArgs e)
        {
            if (Global.Profile.MyGrid.Names.Count > 0)
            {
                if (Global.Profile.MyGrid.Names.ContainsKey("LocationsGrid"))
                {
                    GridSettings settings = new GridSettings(gridLocations);
                    settings.LoadSettings(Global.Profile.MyGrid.Names["LocationsGrid"].ToString());
                }
            }
        } 
        #endregion

        #region Private Methods
        private void ChangePageSize()
        {
            int rows = (Int32.Parse(this.PaneGrid.Height.Value.ToString()) - 60) / 34;
            if (rows >= 1)
            {
                gridLocations.PageSize = rows;

                // Check whether the CurrentPageIndex is correct.
                if (Session["itemsCount"] != null)
                {
                    int itemsCount = (int)Session["itemsCount"];
                    int pageCount = (int)Math.Ceiling(((double)itemsCount / rows));
                    if (gridLocations.MasterTableView.CurrentPageIndex > pageCount - 1)
                    {
                        gridLocations.MasterTableView.CurrentPageIndex = pageCount - 1;
                    }
                }
                gridLocations.Rebind();
            }
        } 
        #endregion

        #region Ajax
        protected void RadAjaxManager1_AjaxRequest(object sender, AjaxRequestEventArgs e)
        {
            ajaxRequestParameters = e.Argument.Split(delimiters);
            ajaxRequestType = ajaxRequestParameters[0];
            ajaxRequestValue = ajaxRequestParameters[1];

            switch (ajaxRequestType)
            {
                case "Clear":
                    Session["Search.SearchCriteria"] = null;
                    Session["Search.CustomerId"] = null;
                    Session["Search.RegionId"] = null;
                    Session["Search.CountyId"] = null;
                    Session["Search.LocationTypeId"] = null;
                    Session["Search.ShowArchived"] = null;
                    gridLocations.Rebind();
                    break;
                case "Search":
                    String[] criterion = ajaxRequestValue.Split(delimitersSearch);

                    if (criterion[0] != "null")
                        searchCriteria = criterion[0];
                    else
                        searchCriteria = String.Empty;

                    if (criterion[1] != "null")
                        customerId = criterion[1];
                    else
                        customerId = String.Empty;

                    if (criterion[2] != "null")
                        regionId = criterion[2];
                    else
                        regionId = String.Empty;

                    if (criterion[3] != "null")
                        countyId = criterion[3];
                    else
                        countyId = String.Empty;

                    if (criterion[4] != "null")
                        locationTypeId = criterion[4];
                    else
                        locationTypeId = String.Empty;

                    showArchived = Convert.ToBoolean(criterion[5]);

                    Session["Search.SearchCriteria"] = searchCriteria;
                    Session["Search.CustomerId"] = customerId;
                    Session["Search.RegionId"] = regionId;
                    Session["Search.CountyId"] = countyId;
                    Session["Search.LocationTypeId"] = locationTypeId;
                    Session["Search.ShowArchived"] = showArchived;

                    gridLocations.Rebind();
                    break;
                default:
                    break;
            }
        } 
        #endregion

        protected void vwLocationsDS_Selecting(object sender, LinqDataSourceSelectEventArgs e)
        {
            if (Session["Search.SearchCriteria"] != null)
                searchCriteria = Session["Search.SearchCriteria"].ToString();
            if (Session["Search.CustomerId"] != null)
                customerId = Session["Search.CustomerId"].ToString();
            if (Session["Search.RegionId"] != null)
                regionId = Session["Search.RegionId"].ToString();
            if (Session["Search.CountyId"] != null)
                countyId = Session["Search.CountyId"].ToString();
            if (Session["Search.LocationTypeId"] != null)
                locationTypeId = Session["Search.LocationTypeId"].ToString();
            if (Session["Search.ShowArchived"] != null)
                showArchived = Convert.ToBoolean(Session["Search.ShowArchived"]);

            IQueryable<vwLocation> query = LocationsManager.GetEnabledLocationsFromView();

            if (!String.IsNullOrEmpty(searchCriteria))
            {
                query = query.Where(l => l.Name.ToLower().Contains(searchCriteria)
                    || l.Comment1.Contains(searchCriteria)
                    || l.Comment2.Contains(searchCriteria)
                    || l.Comment3.Contains(searchCriteria)
                    || l.Line1.ToLower().Contains(searchCriteria)
                    || l.Line2.ToLower().Contains(searchCriteria)
                    || l.Line3.ToLower().Contains(searchCriteria)
                    || l.Line4.ToLower().Contains(searchCriteria)
                    || l.Postcode.ToLower().Contains(searchCriteria));
            }

            if (!String.IsNullOrEmpty(customerId))
                query = query.Where(l => l.CustomerId == new Guid(customerId));

            if (!String.IsNullOrEmpty(regionId))
                query = query.Where(l => l.RegionId == new Guid(regionId));

            if (!String.IsNullOrEmpty(countyId))
                query = query.Where(l => l.CountyId == new Guid(countyId));

            if (!String.IsNullOrEmpty(locationTypeId))
                query = query.Where(l => l.LocationTypeId == new Guid(locationTypeId));

            if (!showArchived)
                query = query.Where(l => l.Archived == false);

            IEnumerable<vwLocation> result = query.Select(l => l);

            e.Result = result;
        }
    }
}
