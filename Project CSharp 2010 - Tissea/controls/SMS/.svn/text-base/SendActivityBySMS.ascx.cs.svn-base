using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using AXmsCtrl;
using Connors.Framework.Model;
using System.Text;

namespace Connors.Erp.Web._common.controls
{
    public partial class SendActivityBySMS : System.Web.UI.UserControl
    {
        private SmsProtocolSmpp objSmppProtocol = new SmsProtocolSmpp();
        private SmsMessage objSmsMessage = new SmsMessage();
        private SmsConstants objConstants = new SmsConstants();
        MainDataContext dc = new MainDataContext();
        
        public String ActivityId { get; set; }

        protected void Page_Load(object sender, EventArgs e)
        {
            txtMessage.Text = BuildMessageToSend();
        }

        private String BuildMessageToSend()
        {
            StringBuilder sb = new StringBuilder();
            try
            {
                Activity activity = (from a in dc.Activities
                                     where a.Id.ToString() == ActivityId
                                     select a).SingleOrDefault();
                sb.AppendFormat("Id {0} ", activity.ActivityId);
                sb.AppendFormat("Lat-Lng {0} {1}", activity.Location.Latitude, activity.Location.Longitude);
            }
            catch (Exception ex)
            {
                throw ex;
            }
            return sb.ToString();
        }

        protected void btnSend_Click(object sender, EventArgs e)
        {
            object obj;
            SmsDeliveryStatus objDeliveryStatus;
            string strMessageRef;

            lblResult.Text = "";

            objSmsMessage.Recipient = txtRecipient.Text;
            objSmsMessage.Data = txtMessage.Text;
            objSmsMessage.Format = objConstants.asMESSAGEFORMAT_TEXT;
            objSmsMessage.RequestDeliveryStatus = 0;

            objSmppProtocol.Clear();
            objSmppProtocol.Server = "smpp.world-text.com";
            objSmppProtocol.ServerPort = 8010;
            objSmppProtocol.SystemID = "sm6179";
            objSmppProtocol.SystemPassword = "123456";
            objSmppProtocol.SystemType = "SMPP";
            objSmppProtocol.SystemSourceAddress = "SMSAlert";
            objSmppProtocol.SystemMode = objConstants.asSMPPMODE_TRANSMITTER;

            // Connect
            objSmppProtocol.Connect();
            UpdateResult(objSmppProtocol.LastError);

            if (objSmppProtocol.LastError != 0L)
                return;

            obj = objSmsMessage;
            strMessageRef = objSmppProtocol.Send(ref obj);
            UpdateResult(objSmppProtocol.LastError);
            
            if (objSmppProtocol.LastError == 0L)
            {
                System.Threading.Thread.Sleep(2000); // Give some time to allow provider to get back with status info. Two secs in usually sufficient to obtain first status info
                if ((objDeliveryStatus = (SmsDeliveryStatus)objSmppProtocol.QueryStatus(strMessageRef, -1)) == null)
                    lblResult.Text = "Failed to check delivery.";
                else
                    lblResult.Text = objDeliveryStatus.Status.ToString() + " (" + objDeliveryStatus.StatusDescription + ")";
            }

            objSmppProtocol.Disconnect();
        }

        private void UpdateResult(Int32 numResult)
        {
            lblResult.Text = numResult.ToString() + ": " + objSmppProtocol.GetErrorDescription(numResult);
        }
    }
}