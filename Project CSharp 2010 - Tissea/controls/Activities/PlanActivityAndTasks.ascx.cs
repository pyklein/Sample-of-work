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
    public partial class PlanActivityAndTasks : System.Web.UI.UserControl
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (Session["PlanActivitiesAndTasks.SelectedIds"] != null)
            {
                String[] ids = (String[])Session["PlanActivitiesAndTasks.SelectedIds"];
                litNumberSelectActivity.Text = String.Format(Resources.YouHaveSelectedXActivities, ids.Length);
                txtStartDateTime.SelectedDate = DateTime.Today;
            }
        }

        protected void btnSave_Click(object sender, EventArgs e)
        {
            String[] ids = (String[])Session["PlanActivitiesAndTasks.SelectedIds"];

            foreach (String id in ids)
            {
                ActivitiesManager.PlanActivityAndTasks(id, txtStartDateTime.SelectedDate.Value, txtEndDateTime.SelectedDate.Value);
                ConnorsErpActivityWorkflow.SetStatus(id, WorkflowStatus.Planned);
            }

            ScriptManager.RegisterStartupScript(this, GetType(), "PlanActivityComplete", "CloseWindow();", true);

            Session["PlanActivitiesAndTasks.SelectedIds"] = null;
        }
    }
}