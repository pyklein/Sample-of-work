using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Services;
using Connors.Framework.Model;

namespace Connors.Erp.Web._common.handlers.Tasks
{
    /// <summary>
    /// Summary description for $codebehindclassname$
    /// </summary>
    //[WebService(Namespace = "http://tempuri.org/")]
    //[WebServiceBinding(ConformsTo = WsiProfiles.BasicProfile1_1)]
    public class SetTaskHandler : IHttpHandler
    {

        public void ProcessRequest(HttpContext context)
        {
            context.Response.ContentType = "text/plain";
            var id = context.Request["hiddenTaskId"].ToString();
            //var startDate = context.Request["RadDatePickerStartTask"].ToString();
            //DateTime sd = Convert.ToDateTime(dateStart); 

            //var endDate = context.Request["RadDatePickerEndTask"].ToString();
            //DateTime ed = Convert.ToDateTime(endDate);
 
            //var coordinator = context.Request.Params["RadComboBoxCoordinator"].ToString();
            //TasksManager.AssignEmployeeToTask(id,coordinator);
            //TasksManager.SetTaskStartDateTime(id, sd);
            //TasksManager.SetTaskEndDateTime(id, ed);

            context.Response.Write(" success");
        }

        public bool IsReusable
        {
            get
            {
                return false;
            }
        }
    }
}
