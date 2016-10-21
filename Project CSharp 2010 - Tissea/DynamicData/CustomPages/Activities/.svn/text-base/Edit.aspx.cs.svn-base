using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Connors.Framework.Model;

namespace Connors.Erp.Web.DynamicData.CustomPages.Activities
{
    public partial class Edit : ErpPage
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (Request.QueryString["Id"] != null)
            {
                if (Request.QueryString["ac"].ToString() == "Edit")
                {
                    //Add Add Tasks control
                    Control userControlToLoad = LoadControl("~/_common/controls/Activities/EditActivity.ascx");
                    UserControlPlaceHolder.Controls.Add(userControlToLoad);
                }
            }
        }
    }
}
