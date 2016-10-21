using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Telerik.Web.UI;
using Connors.Framework.Model;

namespace Connors.Erp.Web.DynamicData.CustomPages.Activities
{
    public partial class Insert : ErpPage
    {
        Int32 activityId;

        protected void Page_Load(object sender, System.EventArgs e)
        {
            if (Request.QueryString["aId"] != null)
            {
                activityId = Convert.ToInt32(Request.QueryString["aId"]);

                if (Request.QueryString["ac"] != null)
                {
                    if (Request.QueryString["ac"].ToString() == "AddTasks")
                    {
                        //Add Add Tasks control
                        Control userControlToLoad = LoadControl("~/_common/controls/Tasks/AddTasksSimple.ascx");
                        UserControlPlaceHolder.Controls.Add(userControlToLoad);
                    }
                    else if (Request.QueryString["ac"].ToString() == "Summary")
                    {
                        //Add Summary control
                        Control userControlToLoad = LoadControl("~/_common/controls/Activities/ActivityAdded.ascx");
                        UserControlPlaceHolder.Controls.Add(userControlToLoad);
                    }
                }
            }
            else
            {
                //Add the Insert Activity control
                Control userControlToLoad = LoadControl("~/_common/controls/Activities/AddActivity.ascx");
                UserControlPlaceHolder.Controls.Add(userControlToLoad);
            }  
        }
    }
}
