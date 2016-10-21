using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Subgurim.Controles;
using System.Text;
using Connors.Framework.Model;

namespace Connors.Erp.Web._common.controls
{
    public partial class AddLocationStep3 : System.Web.UI.UserControl
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                Utilities.LoadCustomersWithoutAllInComboBox(cbxCustomer);
            }

            if (Session["LocationFinder-LatitudeFound"] != null && Session["LocationFinder-LongitudeFound"] != null)
            {
                Double lat = Convert.ToDouble(Session["LocationFinder-LatitudeFound"]);
                Double lng = Convert.ToDouble(Session["LocationFinder-LongitudeFound"]);
                GLatLng coords = new GLatLng(lat,lng);

                StaticGMarker sMarker = new StaticGMarker(coords);

                StringBuilder sb = new StringBuilder();
                sb.Append("http://maps.google.com/maps/api/staticmap?sensor=false&");
                sb.AppendFormat("center={0},{1}&", lat, lng);
                sb.Append("size=500x250&zoom=19&format=png32&maptype=hybrid&");
                sb.AppendFormat("markers={0},{1}", lat, lng);

                Session["LocationFinder-StaticMapUrl"] = sb.ToString();

                locationStaticMap.addStaticGMarker(sMarker);
                locationStaticMap.setCenter(coords, 19);
            }

            //Adding Other geo location info to Location object
            if (Session["LocationFinder-LocationToAdd"] != null)
            {
                Connors.Framework.Model.Location newLocation =
                    (Connors.Framework.Model.Location)Session["LocationFinder-LocationToAdd"];

                newLocation.DataProtectionEnabled = ckbDataProtection.Checked;

                if (ckbDataProtection.Checked)
                {
                    cbxCustomer.Enabled = true;

                    if (!String.IsNullOrEmpty(cbxCustomer.SelectedValue))
                    {
                        newLocation.CustomerId = new Guid(cbxCustomer.SelectedValue);
                    }
                }
            }
        }
    }
}