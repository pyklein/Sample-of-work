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
    public class GetProjectHandler : IHttpHandler
    {
        MainDataContext dc = new MainDataContext();

        public void ProcessRequest(HttpContext context)
        {
            context.Response.ContentType = "text/plain";
            var searchCriteria = context.Request["hiddenSearchMap"].ToString();
            Int32 rInt32;
            Double rDouble;
            String[] ids;

            IQueryable<vwActivity> query = dc.vwActivities;

            if (!String.IsNullOrEmpty(searchCriteria))
            {
                if (searchCriteria.Contains(";"))
                {
                    ids = searchCriteria.Split(";".ToCharArray());
                    query = from a in query
                            where ids.ToList().Contains(a.ActivityId.ToString())
                            select a;
                }
                else if (Int32.TryParse(searchCriteria, out rInt32))
                {
                    query = from a in query
                            join l in dc.vwLocations on a.LocationId equals l.Id into locations
                            from l in locations.DefaultIfEmpty()
                            where a.Name.ToLower().Contains(searchCriteria)
                            || a.ActivityId == rInt32
                            || a.Description.ToLower().Contains(searchCriteria)
                            || a.LocationName.ToLower().Contains(searchCriteria)
                            || a.NetAmount.ToString().ToLower().Contains(searchCriteria)
                            || l.Line1.ToLower().Contains(searchCriteria)
                            || l.Line2.ToLower().Contains(searchCriteria)
                            || l.Line3.ToLower().Contains(searchCriteria)
                            || l.Line4.ToLower().Contains(searchCriteria)
                            || l.Postcode.ToLower().Contains(searchCriteria)
                            select a;
                }
                else if (Double.TryParse(searchCriteria, out rDouble))
                {
                    query = from a in query
                            join l in dc.vwLocations on a.LocationId equals l.Id into locations
                            from l in locations.DefaultIfEmpty()
                            where a.NetAmount == rDouble
                            || l.Latitude == rDouble
                            || l.Longitude == rDouble
                            select a;
                }
                else
                {
                    query = from a in query
                            join l in dc.vwLocations on a.LocationId equals l.Id into locations
                            from l in locations.DefaultIfEmpty()
                            where a.Name.ToLower().Contains(searchCriteria)
                            || a.Description.ToLower().Contains(searchCriteria)
                            || a.Coordinator.ToLower().Contains(searchCriteria)
                            || a.CreatedDateTime.ToString().ToLower().Contains(searchCriteria)
                            || a.CompletedDateTime.ToString().ToLower().Contains(searchCriteria)
                            || a.DueDateTime.ToString().ToLower().Contains(searchCriteria)
                            || a.LocationName.ToLower().Contains(searchCriteria)
                            || a.Owner.ToLower().Contains(searchCriteria)
                            || a.PoNumber.ToLower().Contains(searchCriteria)
                            || l.Line1.ToLower().Contains(searchCriteria)
                            || l.Line2.ToLower().Contains(searchCriteria)
                            || l.Line3.ToLower().Contains(searchCriteria)
                            || l.Line4.ToLower().Contains(searchCriteria)
                            || l.Postcode.ToLower().Contains(searchCriteria)
                            select a;
                }
            }

            //if (!showArchived)
            query = query.Where(a => a.Archived == false);

            query = query.Where(a => a.Deleted == false);
            StringBuilder stringBuilder = new StringBuilder();
            IEnumerable<vwActivity> result = query.Select(a => a);
            var count = 0;
            foreach (vwActivity a in result)
            {

                //stringBuilder.AppendFormat("testGetAct('{0}','{1}','{2}','{3}','{4}','{5}','{6}','{7}','{8}','{9}','{10}','{11}','{12}')^|@", a.Id, a.ActivityId, a.Name, a.WorkflowState, a.ModuleName, a.ProgrammeName, a.CategoryName, a.Description, a.PlanningOrder, a.StartedDateTime, a.LocationName, a.Latitude, a.Longitude);
                if (count <= 1000)
                    stringBuilder.AppendFormat("{0}|", a.ActivityId);
                count++;
            }
            stringBuilder.AppendFormat("@{0}", count);
            context.Response.Write(stringBuilder.ToString());
            
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
