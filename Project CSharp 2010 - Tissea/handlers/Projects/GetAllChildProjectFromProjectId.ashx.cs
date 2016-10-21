using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Services;
using Connors.Framework.Model;
using System.Text;
namespace Connors.Erp.Web._common.handlers.Projects
{
    /// <summary>
    /// Summary description for $codebehindclassname$
    /// </summary>
    //[WebService(Namespace = "http://tempuri.org/")]
    //[WebServiceBinding(ConformsTo = WsiProfiles.BasicProfile1_1)]
    public class GetAllChildProjectFromProjectId : IHttpHandler
    {
        MainDataContext dc = new MainDataContext();

        public void ProcessRequest(HttpContext context)
        {
            context.Response.ContentType = "text/plain";
            String[] ids = context.Request["hiddenCheckedProjectList"].Split(";".ToCharArray());
            List<Guid> l = new List<Guid>();
            List<Guid> listGuidProjectChecked = new List<Guid>();
            List<Guid> listGuidResultProject = new List<Guid>();
            foreach (String id in ids)
            {
                Guid g = new Guid(id);               
                l.Add(g);
            }
            foreach (Guid g in l)
            {
                listGuidProjectChecked = new List<Guid>();
                foreach (Guid guidProjectChecked in l)
                {
                    if(g.ToString()!=guidProjectChecked.ToString())
                        listGuidResultProject.Add(guidProjectChecked);
                }

                foreach (Guid guidProjectAlreadyInFinalList in listGuidResultProject)
                {
                    if (g.ToString() != guidProjectAlreadyInFinalList.ToString())
                        listGuidResultProject.Add(guidProjectAlreadyInFinalList);
                }

                IEnumerable<Project> projects;//GetAllChildProjectIdWithoutList(g, guidProjectChecked);
                //foreach (Project p in projects)
                //{
                //    listGuidResultProject.Add(p.Id);
                //}
            }
            String response="";
            foreach (Guid pListGuid in listGuidResultProject)
            {
                response += pListGuid.ToString() + ";";
            }
            context.Response.Write(response);
            //GetAllChildProjectIdWithoutList
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
