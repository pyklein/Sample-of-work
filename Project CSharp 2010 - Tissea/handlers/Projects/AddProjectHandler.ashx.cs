using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Services;
using Connors.Framework.Model;

namespace Connors.Erp.Web._common.handlers.Projects
{
    /// <summary>
    /// Summary description for $codebehindclassname$
    /// </summary>
    //[WebService(Namespace = "http://tempuri.org/")]
    //[WebServiceBinding(ConformsTo = WsiProfiles.BasicProfile1_1)]
    public class AddProjectHandler : IHttpHandler
    {
        MainDataContext dc = new MainDataContext();

        public void ProcessRequest(HttpContext context)
        {
            context.Response.ContentType = "text/plain";
            var name = context.Request["radTextBoxProjectName"];
            var dateStart =context.Request["RadDatePickerStartDateTime"].ToString();
            DateTime ds = Convert.ToDateTime(dateStart);       
            var endDate =context.Request["RadDatePickerEndDateTime"];
            DateTime ed = Convert.ToDateTime(endDate);     
            var customerId = context.Request["hiddenCustomerProject"].ToString();
            var customer = new Guid(customerId);
            var projectId = context.Request.Params["ProjectStatusHidden"].ToString();
            var projectStatus = new Guid(projectId);
            var workingCalendar = new Guid(context.Request.Params["ProjectCalendar"].ToString());
            Project p = ProjectsManager.AddProject(projectStatus,customer,workingCalendar,name,ds,ed);

            String[] ids = context.Request["hiddenActivitiesProject"].Split(";".ToCharArray());
            var count = 0;
            var countSucess = 0;
            //context.Response.Write();
            Boolean b;
            foreach (String id in ids)
            {
                var guidId = new Guid(id);
                count++;
                b = ActivitiesManager.SetProjectId(guidId, p.Id);
                ActivitiesManager.PlanActivityAndTasks(id, ds, ed);
                 if (b)
                     countSucess++;
            }
            context.Response.Write(countSucess + "/"+count+" activities to the project " + p.Name);
            
           
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
