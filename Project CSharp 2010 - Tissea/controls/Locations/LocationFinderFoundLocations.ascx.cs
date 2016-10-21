using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Connors.Framework.Model;

namespace Connors.Erp.Web._common.controls
{
    public partial class LocationFinderFoundLocations : System.Web.UI.UserControl
    {
        protected void Page_Load(object sender, EventArgs e)
        {
        }

        protected void gridLocationsFound_NeedDataSource(object source, Telerik.Web.UI.GridNeedDataSourceEventArgs e)
        {
            if (Session["LocationFinder-LocationFoundAtSameCoordinates"] != null)
                gridLocationsFound.DataSource = (IQueryable<Location>)Session["LocationFinder-LocationFoundAtSameCoordinates"];
        }
    }
}