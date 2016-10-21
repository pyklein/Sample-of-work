using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Connors.Framework.Model;
using Telerik.Web.UI;

namespace Connors.Erp.Web._common.controls.Activities
{
    public partial class EditActivity : System.Web.UI.UserControl
    {
        #region Privates
        private const int ItemsPerRequest = 10;
        Guid activityGuid;
        Activity currentActivity; 
        #endregion

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                //Reset session variable used in insert/edit activity forms/user controls
                Session["CurrentActivity"] = null;
                Session["CurrentCustomerId"] = null;

                if (Request.QueryString["Id"] != null)
                {
                    activityGuid = new Guid(Request.QueryString["Id"]);
                    currentActivity = ActivitiesManager.GetActivity(activityGuid);
                    Session["CurrentActivity"] = currentActivity;
                    Session["CurrentCustomerId"] = currentActivity.CustomerId;

                    if(currentActivity.ActivityModule != null)
                        lblModuleValue.Text = currentActivity.ActivityModule.Name;
                    if(currentActivity.ActivityProgramme != null)
                        lblProgrammeValue.Text = currentActivity.ActivityProgramme.Name;
                    if(currentActivity.ActivityCategory != null)
                        lblCategoryValue.Text = currentActivity.ActivityCategory.Name;
                    if(currentActivity.ActivityPriority != null)
                        lblPriorityValue.Text = currentActivity.ActivityPriority.Name;

                    txtName.Text = currentActivity.Name;
                    txtDescription.Content = currentActivity.Description;
                    
                    if (currentActivity.PurchaseOrderNumber != null)
                    {
                        cbxPONumbers.SelectedValue = currentActivity.PurchaseOrderNumber.Id.ToString();
                        cbxPONumbers.Text = currentActivity.PurchaseOrderNumber.Description;
                    }

                    if (currentActivity.Location != null)
                    {
                        cbxLocations.SelectedValue = currentActivity.Location.Id.ToString();
                        cbxLocations.Text = currentActivity.Location.Name;
                    }
                }
            }
        }

        protected void cbxPONumbers_ItemsRequested(object o, Telerik.Web.UI.RadComboBoxItemsRequestedEventArgs e)
        {
            Int32 total = PurchaseOrderNumbersManager.GetCustomerPONumbersCountBySearchCriteria(Session["CurrentCustomerId"].ToString(), e.Text);

            Int32 itemOffset = e.NumberOfItems;
            Int32 endOffset = Math.Min(itemOffset + ItemsPerRequest, total);
            e.EndOfItems = endOffset == total;

            if (total > 0)
                Utilities.LoadCustomerPONumbersInComboBoxBySearchCriteria((RadComboBox)o, Session["CurrentCustomerId"].ToString(), itemOffset, e.Text);

            e.Message = Utilities.GetStatusMessage(endOffset, total);
        }

        protected void cbxLocations_ItemsRequested(object o, Telerik.Web.UI.RadComboBoxItemsRequestedEventArgs e)
        {
            Int32 total = LocationsManager.GetCustomerLocationCountBySearchCriteria(Session["CurrentCustomerId"].ToString(), e.Text);

            Int32 itemOffset = e.NumberOfItems;
            Int32 endOffset = Math.Min(itemOffset + ItemsPerRequest, total);
            e.EndOfItems = endOffset == total;

            if (total > 0)
                Utilities.LoadCustomerLocationsInComboBoxBySearchCriteria((RadComboBox)o, Session["CurrentCustomerId"].ToString(), itemOffset, e.Text);

            e.Message = Utilities.GetStatusMessage(endOffset, total);
        }

        protected void btnSave_Click(object sender, EventArgs e)
        {
            currentActivity = (Activity)Session["CurrentActivity"];

            if (ActivitiesManager.UpdateActivity(currentActivity.Id.ToString(), cbxPONumbers.SelectedValue, txtName.Text,
                cbxLocations.SelectedValue, txtDescription.Content))
            {
                Response.Redirect(String.Format("{0}Activities/Edit.aspx?ac=EditDone", ApplicationUrls.ApplicationBaseUrl));
            }
        }
    }
}