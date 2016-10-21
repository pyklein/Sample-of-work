using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Connors.Framework.Language.Properties;

namespace Connors.Erp.Web._common.controls.Activities
{
    public partial class ActivityAdded : System.Web.UI.UserControl
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if(Request.QueryString["aId"] != null)
            {
                litSummary.Text = String.Format(Resources.SuccessfullyAddedActivity, Request.QueryString["aId"].ToString());
            }
        }
    }
}