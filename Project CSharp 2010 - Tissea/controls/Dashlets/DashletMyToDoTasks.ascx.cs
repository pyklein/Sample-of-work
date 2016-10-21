using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Connors.Framework.Model;
using System.Web.Security;
using Telerik.Web.UI;
using System.Drawing;
using Connors.Framework.Language.Properties;

namespace Connors.Erp.Web._common.controls.Dashlets
{
    public partial class DashletMyToDoTasks : System.Web.UI.UserControl
    {
        protected void Page_Load(object sender, EventArgs e)
        {

        }

        protected void gridMyToDoTasks_NeedDataSource(object source, Telerik.Web.UI.GridNeedDataSourceEventArgs e)
        {
            gridMyToDoTasks.DataSource = ToDoTasksManager.GetUserToDoTasks(
                HttpContext.Current.User.Identity.Name,
                Roles.GetRolesForUser());
        }

        protected void gridMyToDoTasks_ItemDataBound(object sender, GridItemEventArgs e)
        {
            //Is it a GridDataItem
            if (e.Item is GridDataItem)
            {
                GridDataItem dataBoundItem = (GridDataItem)e.Item;
                ToDoTask dataItem = (ToDoTask)dataBoundItem.DataItem;

                #region Status
                //Find the image control in the StatusImage template control
                TableCell cellPlanned = dataBoundItem["StatusImage"];
                System.Web.UI.WebControls.Image statusImage = (System.Web.UI.WebControls.Image)cellPlanned.FindControl("imgStatus");
                ToDoTaskStatusType status = dataItem.Status;

                switch (status)
                {
                    case ToDoTaskStatusType.Started:
                        statusImage.ImageUrl = "~/Resources/icons/flagGreen.gif";
                        statusImage.AlternateText = Resources.Started;
                        break;
                    case ToDoTaskStatusType.InProgress:
                        statusImage.ImageUrl = "~/Resources/icons/flagGreen.gif";
                        statusImage.AlternateText = Resources.InProgress;
                        break;
                    case ToDoTaskStatusType.Complete:
                        statusImage.ImageUrl = "~/Resources/icons/flagCompleted.gif";
                        statusImage.AlternateText = Resources.Completed;
                        break;
                    case ToDoTaskStatusType.Waiting:
                        statusImage.ImageUrl = "~/Resources/icons/flagOrange.gif";
                        statusImage.AlternateText = Resources.Waiting;
                        break;
                    case ToDoTaskStatusType.Deferred:
                        statusImage.ImageUrl = "~/Resources/icons/flagPurple.gif";
                        statusImage.AlternateText = Resources.Deferred;
                        break;
                }
                #endregion

                #region Importance
                //Find the image control in the ImportanceImage template control
                TableCell cellInProgress = dataBoundItem["ImportanceImage"];
                System.Web.UI.WebControls.Image importanceImage = (System.Web.UI.WebControls.Image)cellInProgress.FindControl("imgImportance");
                //Retrieve Importance value
                ToDoTaskImportanceType importance = dataItem.Importance;

                switch (importance)
                {
                    case ToDoTaskImportanceType.Low:
                        importanceImage.ImageUrl = "~/Resources/icons/lowImportance.gif";
                        importanceImage.AlternateText = Resources.LowImportance;
                        break;
                    case ToDoTaskImportanceType.Normal:
                        importanceImage.ImageUrl = "~/Resources/icons/normalImportance.gif";
                        importanceImage.AlternateText = Resources.NormalImportance;
                        break;
                    case ToDoTaskImportanceType.Important:
                        importanceImage.ImageUrl = "~/Resources/icons/highImportance.gif";
                        importanceImage.AlternateText = Resources.HighImportance;
                        break;
                }
                #endregion

                #region Due Date condition
                if (Convert.ToDateTime(dataItem.DueDateTime).Date <= DateTime.Now.Date)
                {
                    dataBoundItem.ForeColor = Color.Red;
                }
                #endregion
            }
        }
    }
}