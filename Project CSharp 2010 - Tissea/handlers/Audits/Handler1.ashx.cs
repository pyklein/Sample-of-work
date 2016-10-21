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
    public class Handler1 : IHttpHandler
    {        
        MainDataContext dc = new MainDataContext();

        #region IHttpHandler Members

        public void ProcessRequest(HttpContext context)
        {
            context.Response.ContentType = "text/plain";
            int inputSize = Convert.ToInt32(context.Request["inputSize"]);
            String[] ids = context.Request["hiddenInputAudit"].Split(";".ToCharArray());
            var auditPlace = context.Request["auditPlacehidden"];
            var auditedBy = context.Request["auditedBy"];
            var countAuditCreate=0;
            Audit audit;
            AuditActivity auditActivity;

            foreach (String id in ids)
            {
                Activity activity = dc.Activities.SingleOrDefault(a => a.Id.ToString() == id);
                AuditActivity auditAct = dc.AuditActivities.SingleOrDefault(aA => aA.ActivityGuid.ToString() == id);
                if (!Object.Equals(activity, null) && Object.Equals(auditAct, null) && id!=""){
                        countAuditCreate++;
                        audit = new Audit();
                        audit.AuditId = AuditsManager.GetNextAuditId();
                        audit.Id = Guid.NewGuid();
                        audit.Passed = false;
                        audit.IsPrivate = true;
                        audit.AuditType = AuditType.Activity;
                        audit.AuditPlace = (AuditPlace)Enum.ToObject(typeof(AuditPlace), Convert.ToInt32(auditPlace));
                        //Retrieve number of days from Application Settings
                        audit.DueDateTime = DateTime.Now.AddDays(30);
                        audit.Audited = false;
                        audit.AuditedBy = auditedBy;

                        dc.Audits.InsertOnSubmit(audit);
                        dc.SubmitChanges();

                        auditActivity = new AuditActivity();
                        auditActivity.Id = Guid.NewGuid();
                        auditActivity.ActivityGuid = activity.Id;
                        auditActivity.AuditGuid = audit.Id;

                        dc.AuditActivities.InsertOnSubmit(auditActivity);
                        dc.SubmitChanges();
                    
                }
            }           

            // Return success  
            //context.Response.Write(countAuditCreate + activityAlreadyAdd);auditPlace 
            context.Response.Write(countAuditCreate+" audits");
        }

        #endregion
        
        public bool IsReusable
        {
            get{
                return false;
            }
        }
    }
}