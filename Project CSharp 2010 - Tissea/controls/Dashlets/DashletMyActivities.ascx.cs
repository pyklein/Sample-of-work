using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Connors.Framework.Model;
using Telerik.Web.UI;

namespace Connors.Erp.Web._common.controls.Dashlets
{
    public partial class DashletMyActivities : System.Web.UI.UserControl
    {
        protected void Page_Load(object sender, EventArgs e)
        {

        }

        protected void gridActivities_NeedDataSource(object source, Telerik.Web.UI.GridNeedDataSourceEventArgs e)
        {
            gridActivities.DataSource = ActivitiesManager.GetUserActivities(
                HttpContext.Current.User.Identity.Name).OrderBy(a => a.ActivityId);
        }

        protected void gridActivities_ItemDataBound(object sender, GridItemEventArgs e)
        {
            //Is it a GridDataItem
            if (e.Item is GridDataItem)
            {
                GridDataItem dataBoundItem = (GridDataItem)e.Item;
                vwActivity dataItem = (vwActivity)dataBoundItem.DataItem;

                #region Completed
                //Find the image control in the InProgressImage template control
                TableCell cellCompleted = dataBoundItem["CompletedImage"];
                System.Web.UI.WebControls.Image completedImage = (System.Web.UI.WebControls.Image)cellCompleted.FindControl("imgPinCompleted");
                //Retrieve InProgress value
                Boolean completed = Convert.ToBoolean(dataItem.Completed);

                if (completed)
                {
                    completedImage.ImageUrl = "~/Resources/icons/flagCompleted.gif";
                    completedImage.AlternateText = "Completed";
                }
                else if (!completed)
                {
                    completedImage.ImageUrl = "~/Resources/icons/flagWhite.gif";
                    completedImage.AlternateText = "Not Completed";
                }
                else
                {
                    completedImage.Visible = false;
                }
                #endregion

                #region Planned
                //Find the image control in the PlannedImage template control
                TableCell cellPlanned = dataBoundItem["PlannedImage"];
                System.Web.UI.WebControls.Image plannedImage = (System.Web.UI.WebControls.Image)cellPlanned.FindControl("imgPinPlanned");
                Boolean planned = Convert.ToBoolean(dataItem.Planned);

                if (planned)
                {
                    plannedImage.ImageUrl = "~/Resources/icons/flagGreen.gif";
                    plannedImage.AlternateText = "Planned";
                }
                else if (!planned)
                {
                    plannedImage.ImageUrl = "~/Resources/icons/flagRed.gif";
                    plannedImage.AlternateText = "Not Planned";
                }
                else
                {
                    plannedImage.Visible = false;
                }
                #endregion

                #region In Progress
                //Find the image control in the InProgressImage template control
                TableCell cellInProgress = dataBoundItem["InProgressImage"];
                System.Web.UI.WebControls.Image inProgressImage = (System.Web.UI.WebControls.Image)cellInProgress.FindControl("imgPinInProgress");
                //Retrieve InProgress value
                Boolean inProgress = Convert.ToBoolean(dataItem.InProgress);

                if (inProgress)
                {
                    inProgressImage.ImageUrl = "~/Resources/icons/flagGreen.gif";
                    inProgressImage.AlternateText = "In Progress";
                }
                else if (!inProgress)
                {
                    inProgressImage.ImageUrl = "~/Resources/icons/flagRed.gif";
                    inProgressImage.AlternateText = "Not In Progress";
                }
                else
                {
                    inProgressImage.Visible = false;
                }
                #endregion

                #region Has Document Attached
                //Find the image control in the InProgressImage template control
                TableCell cellHasDocumentsAttached = dataBoundItem["HasDocumentsAttachedImage"];
                System.Web.UI.WebControls.Image hasDocumentsAttachedImage = (System.Web.UI.WebControls.Image)cellHasDocumentsAttached.FindControl("imgPinHasDocumentsAttached");
                //Retrieve InProgress value
                Boolean hasDocumentsAttached = MediaManager.ActivityHasMedia(dataItem.Id.ToString());

                if (hasDocumentsAttached)
                {
                    hasDocumentsAttachedImage.ImageUrl = "~/Resources/icons/document.gif";
                    hasDocumentsAttachedImage.AlternateText = "Has Medias";
                }
                else
                {
                    hasDocumentsAttachedImage.Visible = false;
                }
                #endregion
            }
        }
    }
}