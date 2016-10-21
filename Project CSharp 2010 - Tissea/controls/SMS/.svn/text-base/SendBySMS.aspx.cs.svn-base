using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Connors.Framework.Model;

namespace Connors.Erp.Web._common.controls
{
    public partial class SendBySMS : ErpPage
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if(!String.IsNullOrEmpty(Request.QueryString["i"].ToString()))
                SendActivityBySMS1.ActivityId = Request.QueryString["i"].ToString();
        }
    }
}
