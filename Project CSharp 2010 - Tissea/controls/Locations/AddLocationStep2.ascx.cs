using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Connors.Framework.Model;

namespace Connors.Erp.Web._common.controls
{
    public partial class AddLocationStep2 : System.Web.UI.UserControl
    {
        Tile currentTile;
        protected void Page_Load(object sender, EventArgs e)
        {
            if (Session["LocationFinder-LatitudeFound"] != null)
                txtLatitude.Text = Session["LocationFinder-LatitudeFound"].ToString();

            if (Session["LocationFinder-LongitudeFound"] != null)
                txtLongitude.Text = Session["LocationFinder-LongitudeFound"].ToString();

            if (Session["LocationFinder-OSGridX"] != null)
                txtOSGridX.Text = Session["LocationFinder-OSGridX"].ToString();

            if (Session["LocationFinder-OSGridY"] != null)
                txtOSGridY.Text = Session["LocationFinder-OSGridY"].ToString();

            //Adding Other geo location info to Location object
            if (Session["LocationFinder-LocationToAdd"] != null)
            {
                Connors.Framework.Model.Location newLocation =
                    (Connors.Framework.Model.Location)Session["LocationFinder-LocationToAdd"];

                #region Tile
                if (!newLocation.TileId.Equals(Guid.Empty))
                {
                    if (currentTile != null)
                    {
                        if (!newLocation.TileId.Equals(currentTile.Id))
                        {
                            currentTile = TilesManager.GetTile(newLocation.TileId);
                        }
                    }
                    else
                    {
                        currentTile = TilesManager.GetTile(newLocation.TileId);
                    }
                }

                if (currentTile != null)
                    txtTile.Text = currentTile.Name;
                #endregion

                newLocation.Comment1 = txtComment1.Text;
                newLocation.Comment2 = txtComment2.Text;
                newLocation.Comment3 = txtComment3.Text;
                newLocation.InClearance = ckbInClearance.Checked;
                newLocation.LandrangerGridReference = txtLandrangerGridReference.Text;

                if (Session["LocationFinder-LocationType"].ToString().ToLower() == "substation")
                    ckbInClearance.Checked = true;
            }
        }
    }
}