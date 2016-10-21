using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Services;
using Connors.Framework.Model;

namespace Connors.Erp.Web
{
    /// <summary>
    /// Summary description for $codebehindclassname$
    /// </summary>
    //[WebService(Namespace = "http://tempuri.org/")]
    //[WebServiceBinding(ConformsTo = WsiProfiles.BasicProfile1_1)]
    public class AddActivityHandler : IHttpHandler
    {
        MainDataContext dc = new MainDataContext();

        #region IHttpHandler Members

        public void ProcessRequest(HttpContext context)
        {
            context.Response.ContentType = "text/plain";

            var name = context.Request["txtActivityAddName"].ToString();
            var customer = context.Request.Params["slctAddCustomersIdhidden"].ToString();
            var description = context.Request["txtDescriptionAddName"].ToString();
            var module = context.Request.Params["slctAddActivityModulesIdhidden"].ToString();
            var priority = context.Request.Params["slctAddActivityPrioritiesIdhidden"].ToString();
            var programme = context.Request.Params["slctAddActivityProgrammesIdhidden"].ToString();
            var categorie = context.Request.Params["slctAddActivityCategoriesIdhidden"].ToString();

            String[] ids = context.Request["hiddenInputActivity"].Split(";".ToCharArray());
            var owner = HttpContext.Current.User.Identity.Name;
            var count = 0;
            //context.Response.Write();
            foreach (String id in ids)
            {
                count++;
                ActivitiesManager.AddActivity(customer, module, programme, categorie, id, name, description, owner, null, priority,
                    "1", 0, 0, false);
            }

            context.Response.Write(count+" Activities");
        }

        #endregion

        public bool IsReusable
        {
            get
            {
                return false;
            }
        }
    }
}
