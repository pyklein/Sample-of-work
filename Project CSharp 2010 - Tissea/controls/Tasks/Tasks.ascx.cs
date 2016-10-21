using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
//using Connors.Framework.Business;
using Telerik.Web.UI;
using Connors.Framework.Model;

namespace Connors.Erp.Web._common.controls.Tasks
{
    public partial class Tasks : System.Web.UI.UserControl
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            gridTasks.Rebind();
        }

        protected void gridTasks_NeedDataSource(object source, GridNeedDataSourceEventArgs e)
        {
            gridTasks.DataSource = TasksManager.GetActivityTasksFromView(Session["ActivityId"].ToString());
        }
    }
}