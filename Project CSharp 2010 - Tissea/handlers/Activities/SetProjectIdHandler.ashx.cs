using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Services;
using Connors.Framework.Model;

namespace Connors.Erp.Web._common.handlers.Activities
{
    /// <summary>
    /// Summary description for $codebehindclassname$
    /// </summary>
    //[WebService(Namespace = "http://tempuri.org/")]
    //[WebServiceBinding(ConformsTo = WsiProfiles.BasicProfile1_1)]
    public class SetProjectIdHandler : IHttpHandler
    {
        MainDataContext dc = new MainDataContext();

        public void ProcessRequest(HttpContext context)
        {
            context.Response.ContentType = "text/plain";

            var currentProjectId = context.Request["hiddenCurrentProjectId"].ToString();
            var guidEmpty= Guid.Empty;
            var currentProjectGuidId = new Guid(currentProjectId);
            if (!String.IsNullOrEmpty(currentProjectId))
            {
                
                IQueryable<vwActivity> query = dc.vwActivities;
                query = from a in query
                        where a.ProjectId == currentProjectGuidId
                        select a;
                IEnumerable<vwActivity> result = query.Select(a => a);
                foreach (vwActivity a in result)
                {

                   // ActivitiesManager.SetProjectId(a.Id, );
                    int? nul = null;
                    ActivitiesManager.SetPlanningOrder(a.Id, nul);
                }
                String[] ids = context.Request["hiddenActivitiesProject"].Split(";".ToCharArray());
                var count=0;
                foreach (String id in ids)
                {
                    
                    var guidId = new Guid(id);
                    ActivitiesManager.SetProjectId(guidId, currentProjectGuidId);
                    ActivitiesManager.SetPlanningOrder(guidId,count);
                    count++;
                }
                context.Response.Write("OK");
            }
            else
            {

                context.Response.Write("KO");

            }
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
