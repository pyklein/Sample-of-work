using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Telerik.Web.UI;
using Connors.Framework.Model;
using System.Drawing;
using Connors.Framework.Language.Properties;

namespace Connors.Erp.Web.DynamicData.CustomPages.Audits
{
    public partial class List : ErpPage
    {
        #region Privates
        MainDataContext dc = new MainDataContext();
        String[] ajaxRequestParameters;
        String ajaxRequestType;
        String ajaxRequestValue;
        char[] delimiters = new char[] { '|' };
        char[] delimitersSearch = new char[] { '^' };
        String searchCriteria;
        Boolean showArchived;
        #endregion

        #region Page Events
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                Session["AuditGuid"] = String.Empty;
            }
        } 
        #endregion

        #region Private Methods
        private void UpdateMediaToolTip(String elementID, UpdatePanel panel)
        {
            Control ctrl = Page.LoadControl("~/_common/controls/Medias/ViewMedia.ascx");
            panel.ContentTemplateContainer.Controls.Add(ctrl);
            ViewMedia mediaDetail = (ViewMedia)ctrl;
            mediaDetail.ElementId = elementID;
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
                case "RebindRelatedGrids":
                    String[] rebindCriterion = ajaxRequestValue.Split(delimitersSearch);
                    RebindRelatedGrids(rebindCriterion[0]);
                    break;
                default:
                    break;
            }
        }

        private void RebindRelatedGrids(String auditGuid)
        {
            Session["AuditGuid"] = auditGuid;

            if (PaneRelatedItems.Height.Value > 1)
            {
                //Here we clear the collection of target control in tooltip manager
                //in order to add new tooltips that apply to selected activity
                RadToolTipManager1.TargetControls.Clear();

                gridMedias.Rebind();
                gridNotes.Rebind();
            }
        }

        protected void MediaAjaxUpdate(object sender, ToolTipUpdateEventArgs args)
        {
            this.UpdateMediaToolTip(args.Value, args.UpdatePanel);
        } 
        #endregion

        #region Audits
        protected void gridAudits_ItemDataBound(object sender, GridItemEventArgs e)
        {
            //Is it a GridDataItem
            if (e.Item is GridDataItem)
            {
                GridDataItem dataBoundItem = (GridDataItem)e.Item;
                vwAuditActivity dataItem = (vwAuditActivity)dataBoundItem.DataItem;

                #region Audited
                //Find the image control in the AuditedImage template control
                TableCell cellAudited = dataBoundItem["AuditedImage"];
                System.Web.UI.WebControls.Image auditedImage = (System.Web.UI.WebControls.Image)cellAudited.FindControl("imgPinAudited");
                //Retrieve Audited value
                Boolean audited = Convert.ToBoolean(dataItem.Audited);

                if (audited)
                {
                    auditedImage.ImageUrl = "~/Resources/icons/flagCompleted.gif";
                    auditedImage.AlternateText = Resources.Audited;
                }
                else if (!audited)
                {
                    auditedImage.ImageUrl = "~/Resources/icons/flagWhite.gif";
                    auditedImage.AlternateText = Resources.NotAudited;
                }
                else
                {
                    auditedImage.ImageUrl = "~/Resources/icons/normalImportance.gif";
                }
                #endregion

                #region IsPrivate
                //Find the image control in the IsPrivateImage template control
                TableCell cellIsPrivate = dataBoundItem["IsPrivateImage"];
                System.Web.UI.WebControls.Image isPrivateImage = (System.Web.UI.WebControls.Image)cellIsPrivate.FindControl("imgPinIsPrivate");
                //Retrieve IsPrivate value
                Boolean isPrivate = Convert.ToBoolean(dataItem.IsPrivate);

                if (isPrivate)
                {
                    isPrivateImage.ImageUrl = "~/Resources/icons/flagCompleted.gif";
                    isPrivateImage.AlternateText = Resources.IsPrivate;
                }
                else if (!isPrivate)
                {
                    isPrivateImage.ImageUrl = "~/Resources/icons/flagRed.gif";
                    isPrivateImage.AlternateText = Resources.IsNotPrivate;
                }
                else
                {
                    isPrivateImage.ImageUrl = "~/Resources/icons/normalImportance.gif";
                }
                #endregion

                #region Uploaded On Mobile Device
                //Find the image control in the UploadedOnMobileDeviceImage template control
                TableCell cellUploadedOnMobileDevice = dataBoundItem["UploadedOnMobileDeviceImage"];
                System.Web.UI.WebControls.Image uploadedOnMobileDeviceImage = (System.Web.UI.WebControls.Image)cellUploadedOnMobileDevice.FindControl("imgPinUploadedOnMobileDevice");
                //Retrieve UploadedOnMobileDevice value
                Boolean uploadedOnMobileDevice = Convert.ToBoolean(dataItem.UploadedOnMobileDevice);

                if (uploadedOnMobileDevice)
                {
                    uploadedOnMobileDeviceImage.ImageUrl = "~/Resources/icons/flagGreen.gif";
                    uploadedOnMobileDeviceImage.AlternateText = String.Format(Resources.UploadedOnMobileDeviceByX, dataItem.UploadedOnMobileDeviceBy);
                }
                else if (!uploadedOnMobileDevice)
                {
                    uploadedOnMobileDeviceImage.ImageUrl = "~/Resources/icons/flagRed.gif";
                    uploadedOnMobileDeviceImage.AlternateText = Resources.NotUploadedOnMobileDevice;
                }
                else
                {
                    uploadedOnMobileDeviceImage.Visible = false;
                }
                #endregion

                #region Passed
                //Find the image control in the PassedImage template control
                TableCell cellPassed = dataBoundItem["PassedImage"];
                System.Web.UI.WebControls.Image passedImage = (System.Web.UI.WebControls.Image)cellPassed.FindControl("imgPinPassed");
                //Retrieve Passed value
                Boolean passed = Convert.ToBoolean(dataItem.Passed);

                //Only show the real value of Passed if the Audit is Audited
                if (passed && audited)
                {
                    passedImage.ImageUrl = "~/Resources/icons/flagGreen.gif";
                    passedImage.AlternateText = Resources.Passed;
                }
                else if (!passed && audited)
                {
                    passedImage.ImageUrl = "~/Resources/icons/close.png";
                    passedImage.AlternateText = Resources.Failed;
                }
                else
                {
                    passedImage.ImageUrl = "~/Resources/icons/normalImportance.gif";
                }
                #endregion

                #region Archived
                if (dataItem.Archived.HasValue)
                {
                    if (dataItem.Archived.Value)
                        e.Item.ForeColor = Color.Gray;
                }
                #endregion
            }
        }

        protected void vwAuditActivitiesDS_Selecting(object sender, LinqDataSourceSelectEventArgs e)
        {
            IQueryable<vwAuditActivity> query = dc.vwAuditActivities;

            query = query.Where(a => a.Deleted == false);

            IEnumerable<vwAuditActivity> result = query.Select(a => a);

            e.Result = result;
        } 
        #endregion

        #region Medias Grid
        protected void gridMedias_NeedDataSource(object source, GridNeedDataSourceEventArgs e)
        {
            gridMedias.DataSource = MediaManager.GetAuditActivityMedias(Session["AuditGuid"].ToString()).OrderBy(m => m.CreatedDateTime);
        }

        protected void gridMedias_ItemDataBound(object sender, GridItemEventArgs e)
        {
            if (e.Item.ItemType == GridItemType.Item || e.Item.ItemType == GridItemType.AlternatingItem)
            {
                Control target = e.Item.FindControl("targetControl");
                if (!Object.Equals(target, null))
                {
                    if (!Object.Equals(this.RadToolTipManager1, null))
                    {
                        //Add the button (target) id to the tooltip manager
                        RadToolTipManager1.TargetControls.Add(target.ClientID, (e.Item as GridDataItem).GetDataKeyValue("Id").ToString(), true);
                    }
                }
            }
        }

        protected void gridMedias_ItemCommand(object source, GridCommandEventArgs e)
        {
            if (e.CommandName == "Sort" || e.CommandName == "Page")
            {
                RadToolTipManager1.TargetControls.Clear();
            }
        }
        #endregion

        #region Notes Grid
        protected void gridNotes_NeedDataSource(object source, GridNeedDataSourceEventArgs e)
        {
            gridNotes.DataSource = AuditNotesManager.GetAuditAuditNotes(Session["AuditGuid"].ToString());
        }
        #endregion
    }
}
