using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Connors.Framework.Model;

namespace Connors.Erp.Web
{
    public partial class ViewLocation : System.Web.UI.UserControl
    {
        public String ElementId { get; set; }

        protected void Page_Load(object sender, EventArgs e)
        {
            Activity a = ActivitiesManager.GetActivity(new Guid(ElementId));
            lblLine1.Text = a.Location.Line1;
            lblLine2.Text = a.Location.Line3;
            lblLine3.Text = a.Location.Line4;
            lblLine4.Text = a.Location.Line4;
            lblPostcode.Text = a.Location.Postcode;
            lblLatitude.Text = a.Location.Latitude.ToString();
            lblLongitude.Text = a.Location.Longitude.ToString();
            if (a.Location.SubstationDetails.Count > 0)
            {
                lblOldReference.Text = a.Location.SubstationDetails.First().OldReference;
            }
            else
            {
                lblOldReference.Text = String.Empty;
            }
        }
    }
}