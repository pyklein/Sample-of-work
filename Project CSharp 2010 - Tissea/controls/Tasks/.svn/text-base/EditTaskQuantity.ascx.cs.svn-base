using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
//using Connors.Framework.Business;
using Connors.Framework.Model;

namespace Connors.Erp.Web._common.controls.Tasks
{
    public partial class EditTaskQuantity : System.Web.UI.UserControl
    {
        public String TaskId { get; set; }

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!String.IsNullOrEmpty(TaskId))
            {
                Task task = TasksManager.GetTaskById(TaskId);
                lblProductName.Text = task.Product.Name;
                txtQuantity.Value = task.QuantityOrdered;
            }
        }

        protected void btnSave_Click(object sender, EventArgs e)
        {
            TasksManager.UpdateTaskQuantity(TaskId, (Double)txtQuantity.Value);
        }
    }
}