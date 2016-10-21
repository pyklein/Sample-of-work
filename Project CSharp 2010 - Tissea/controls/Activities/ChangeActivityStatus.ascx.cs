using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Connors.Framework.Model;
using Connors.Framework.Language.Properties;

namespace Connors.Erp.Web._common.controls.Activities
{
    public partial class ChangeActivityStatus : System.Web.UI.UserControl
    {
        String _activityGuid;
        Activity a;

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                if (Session["ChangeActivityStatus.SelectedIds"] != null)
                {
                    String[] ids = (String[])Session["ChangeActivityStatus.SelectedIds"];

                    if (ids[0] != "undefined")
                    {
                        _activityGuid = ids[0];
                        a = ActivitiesManager.GetAllActivities().SingleOrDefault(ac => ac.Id.ToString() == _activityGuid);
                        Utilities.LoadNextValidStatusesInDropDown(ddStatuses, a.WorkflowState, a.ActivityModule.Name);

                        if (ids.Length > 1)
                        {
                            litTitle.Text = String.Format(Resources.YouHaveSelectedXActivities, ids.Length);
                        }
                        else
                        {
                            if (a != null)
                            {
                                litTitle.Text = String.Format(Resources.ActivityIdX, a.ActivityId);
                            }
                        }
                    }
                }
            }
        }

        protected void btnSave_Click(object sender, EventArgs e)
        {
            String[] ids = (String[])Session["ChangeActivityStatus.SelectedIds"];

            if (ConnorsErpActivityWorkflow.SetMultipleStatus(ids.ToList(),
                (WorkflowStatus)Enum.ToObject(typeof(WorkflowStatus), Convert.ToInt32(ddStatuses.SelectedValue))))
            {
                //Close the window if success
                ScriptManager.RegisterStartupScript(this, GetType(), "ChangeStatusComplete", "CloseWindow();", true);
            }
            else
            {
                litMessage.Text = Resources.CouldNotChangeActivityStatus;
            }

            Session["ChangeActivityStatus.SelectedIds"] = null;
        }
    }
}