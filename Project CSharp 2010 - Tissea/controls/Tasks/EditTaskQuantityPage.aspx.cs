using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace Connors.Erp.Web._common.controls.Tasks
{
    public partial class EditTaskQuantityPage : System.Web.UI.Page
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (Request.QueryString["i"] != null)
            {
                EditTaskQuantity1.TaskId = Request.QueryString["i"].ToString();
            }
        }
    }
}
