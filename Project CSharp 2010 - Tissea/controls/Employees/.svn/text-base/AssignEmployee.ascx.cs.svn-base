using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Telerik.Web.UI;
using Connors.Framework.Model;
using Connors.Framework.Language.Properties;

namespace Connors.Erp.Web._common.controls.Employees
{
    public partial class AssignEmployee : System.Web.UI.UserControl
    {
        private const int ItemsPerRequest = 10;

        protected void Page_Load(object sender, EventArgs e)
        {
            if (Session["AssignEmployees.SelectedIds"] != null)
            {
                String[] ids = (String[])Session["AssignEmployees.SelectedIds"];
                litNumSelectedEmployees.Text = String.Format(Resources.YouHaveSelectedXActivities, ids.Length);
            }
        }

        protected void cbxEmployees_ItemsRequested(object o, Telerik.Web.UI.RadComboBoxItemsRequestedEventArgs e)
        {
            Int32 total = EmployeesManager.GetEmployeesCountBySearchCriteria(e.Text);

            Int32 itemOffset = e.NumberOfItems;
            Int32 endOffset = Math.Min(itemOffset + ItemsPerRequest, total);
            e.EndOfItems = endOffset == total;

            if (total > 0)
                Utilities.LoadEmployeesInComboxBySearchCriteria((RadComboBox)o, itemOffset, e.Text);

            e.Message = Utilities.GetStatusMessage(endOffset, total);
        }

        protected void btnSave_Click(object sender, EventArgs e)
        {
            String[] ids = (String[])Session["AssignEmployees.SelectedIds"];
            
            foreach (String id in ids)
            {
                if (ActivitiesManager.AssignEmployeeToActivity(id, cbxEmployees.SelectedValue))
                    TasksManager.AssignEmployeeToTask(id, cbxEmployees.SelectedValue);
            }

            ScriptManager.RegisterStartupScript(this, GetType(), "AssignEmployeeComplete", "CloseWindow();", true);

            Session["AssignEmployees.SelectedIds"] = null;
        }
    }
}