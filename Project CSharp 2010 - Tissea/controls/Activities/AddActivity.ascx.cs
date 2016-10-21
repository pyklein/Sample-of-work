using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
//using Connors.Framework.Business;
using Telerik.Web.UI;
using Connors.Framework.Model;
using Connors.Framework.Language.Properties;

namespace Connors.Erp.Web._common.controls
{
    public partial class AddActivity : System.Web.UI.UserControl
    {
        #region Privates
        String[] clientScriptIds;
        String entityId;
        char[] delimiters = new char[] { '|' };
        private const int ItemsPerRequest = 10;
        #endregion

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                Utilities.LoadCustomersWithoutAllInComboBox(cbxCustomers);

                #region Add RadWindow to RadWindowManager
                RadWindow locationFinderWindow = new RadWindow();
                locationFinderWindow.ID = "AddLocation";
                //locationFinderWindow.NavigateUrl = "~/_common/controls/Locations/LocationFinder.aspx";
                locationFinderWindow.NavigateUrl = "~/_common/wizards/Locations/LocationFinderWizard.aspx";
                locationFinderWindow.Behaviors = WindowBehaviors.Close;
                locationFinderWindow.ReloadOnShow = true;
                locationFinderWindow.Title = Resources.AddANewLocationWithTheLocationFinder;
                locationFinderWindow.OpenerElementID = btnShowLocationFinder.ClientID;
                locationFinderWindow.OnClientClose = "AddAddedLocationToComboBox";
                RadWindowManager1.Windows.Add(locationFinderWindow); 
                #endregion

                //Reset session variable used in insert/edit activity forms/user controls
                Session["ActivityIdCreated"] = null;
                Session["CustomerId"] = null;
                Session["CurrentPriceListId"] = null;
                Session["CurrentProductId"] = null;
            }
        }

        protected void cbxCustomers_ItemsRequested(object o, Telerik.Web.UI.RadComboBoxItemsRequestedEventArgs e)
        {
            Utilities.LoadCustomersWithoutAllInComboBox((RadComboBox)o);
        }

        protected void cbxModules_ItemsRequested(object o, Telerik.Web.UI.RadComboBoxItemsRequestedEventArgs e)
        {
            Utilities.LoadModulesWithoutAllInComboBox((RadComboBox)o);
        }

        protected void cbxProgrammes_ItemsRequested(object o, Telerik.Web.UI.RadComboBoxItemsRequestedEventArgs e)
        {
            clientScriptIds = e.Text.Split(delimiters);
            entityId = clientScriptIds[0].ToString();
            Session["CustomerId"] = clientScriptIds[1].ToString();

            Utilities.LoadCustomerProgrammesInComboBox((RadComboBox)o, entityId, Session["CustomerId"].ToString());
        }

        protected void cbxCategories_ItemsRequested(object o, Telerik.Web.UI.RadComboBoxItemsRequestedEventArgs e)
        {
            Utilities.LoadCustomerCategoriesInComboBox((RadComboBox)o, e.Text, Session["CustomerId"].ToString());
        }

        protected void cbxPriorities_ItemsRequested(object o, Telerik.Web.UI.RadComboBoxItemsRequestedEventArgs e)
        {
            Utilities.LoadCustomerPriorityInComboBox((RadComboBox)o, e.Text);
        }

        protected void cbxPONumbers_ItemsRequested(object o, Telerik.Web.UI.RadComboBoxItemsRequestedEventArgs e)
        {
            Int32 total = PurchaseOrderNumbersManager.GetCustomerPONumbersCountBySearchCriteria(Session["CustomerId"].ToString(),
                e.Text);

            Int32 itemOffset = e.NumberOfItems;
            Int32 endOffset = Math.Min(itemOffset + ItemsPerRequest, total);
            e.EndOfItems = endOffset == total;

            if (total > 0)
                Utilities.LoadCustomerPONumbersInComboBoxBySearchCriteria((RadComboBox)o, Session["CustomerId"].ToString(), itemOffset, e.Text);

            e.Message = Utilities.GetStatusMessage(endOffset, total);
        }

        protected void cbxLocations_ItemsRequested(object o, Telerik.Web.UI.RadComboBoxItemsRequestedEventArgs e)
        {
            Int32 total = LocationsManager.GetCustomerLocationCountBySearchCriteria(Session["CustomerId"].ToString(), e.Text);

            Int32 itemOffset = e.NumberOfItems;
            Int32 endOffset = Math.Min(itemOffset + ItemsPerRequest, total);
            e.EndOfItems = endOffset == total;

            if (total > 0)
                Utilities.LoadCustomerLocationsInComboBoxBySearchCriteria((RadComboBox)o, Session["CustomerId"].ToString(), itemOffset, e.Text);

            e.Message = Utilities.GetStatusMessage(endOffset, total);
        }

        protected void btnSaveOnly_Click(object sender, EventArgs e)
        {
            SaveActivity();
            Response.Redirect(String.Format("{0}Activities/Insert.aspx?ac=Summary&aId={1}", ApplicationUrls.ApplicationBaseUrl, Session["ActivityIdCreated"].ToString()));
        }

        protected void btnSaveAndAddTasks_Click(object sender, EventArgs e)
        {
            SaveActivity();
            Response.Redirect(String.Format("{0}Activities/Insert.aspx?ac=AddTasks&aId={1}", ApplicationUrls.ApplicationBaseUrl, Session["ActivityIdCreated"].ToString()));
        }

        private void SaveActivity()
        {
            Activity activityCreated = ActivitiesManager.AddActivity(cbxCategories.SelectedValue,
                    cbxCustomers.SelectedValue, txtDescription.Content, 0, 0, cbxLocations.SelectedValue,
                    false, cbxModules.SelectedValue, txtName.Text,
                    HttpContext.Current.User.Identity.Name, cbxPONumbers.SelectedValue,
                    cbxPriorities.SelectedValue, cbxProgrammes.SelectedValue);

            Session["ActivityIdCreated"] = activityCreated.ActivityId;
        }
    }
}