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
    public class SetPlanningOrderHandler : IHttpHandler
    {

        public void ProcessRequest(HttpContext context)
        {
            context.Response.ContentType = "text/plain";
            String[] ids = context.Request["hiddenActivitiesProject"].Split(";".ToCharArray());
            var count = 0;
            var countSucess = 0;
            //context.Response.Write();
            Boolean b;
            foreach (String id in ids)
            {
                var guidId = new Guid(id);
                count++;
                b = ActivitiesManager.SetPlanningOrder(guidId, count);
                if (b)
                    countSucess++;
            }
            context.Response.Write(countSucess + "/" + count + " planning order ");
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
