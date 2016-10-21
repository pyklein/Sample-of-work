using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Telerik.Web.UI;
using Connors.Framework.Model;

namespace Connors.Erp.Web._common.controls
{
    public partial class AddLocationStep1 : System.Web.UI.UserControl
    {
        Tile currentTile;
        protected void Page_Load(object sender, EventArgs e)
        {
            #region Initial load combo box
            if (!IsPostBack)
            {
                Utilities.LoadCountriesWithoutAllInComboBox(cbxCountry);
                Utilities.LoadCountiesWithoutAllInComboBox(cbxCounty);
                Utilities.LoadRegionsWithoutAllInComboBox(cbxRegion);
            } 
            #endregion

            #region Address details
            if (Session["LocationFinder-Country"] != null)
            {
                RadComboBoxItem countrySelected = cbxCountry.FindItemByText(Session["LocationFinder-Country"].ToString());
                if (countrySelected != null)
                    countrySelected.Selected = true;
            }

            if (Session["LocationFinder-Line1"] != null)
                txtLine1.Text = Session["LocationFinder-Line1"].ToString();

            if (Session["LocationFinder-Line2"] != null)
                txtLine2.Text = Session["LocationFinder-Line2"].ToString();

            if (Session["LocationFinder-PostCode"] != null)
                txtPostCode.Text = Session["LocationFinder-PostCode"].ToString(); 
            #endregion

            //Adding location details to Location object
            if (Session["LocationFinder-LocationToAdd"] != null)
            {
                Connors.Framework.Model.Location newLocation =
                    (Connors.Framework.Model.Location)Session["LocationFinder-LocationToAdd"];

                newLocation.Name = txtName.Text;
                newLocation.Line1 = txtLine1.Text;
                newLocation.Line2 = txtLine2.Text;
                newLocation.Line3 = txtLine3.Text;
                newLocation.Line4 = txtLine4.Text;
                newLocation.Postcode = txtPostCode.Text;
                
                if(!String.IsNullOrEmpty(cbxCountry.SelectedValue))
                    newLocation.CountryId = new Guid(cbxCountry.SelectedValue);
                if (!String.IsNullOrEmpty(cbxRegion.SelectedValue))
                    newLocation.RegionId = new Guid(cbxRegion.SelectedValue);
                if (!String.IsNullOrEmpty(cbxCounty.SelectedValue))
                    newLocation.CountyId = new Guid(cbxCounty.SelectedValue);

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

                if (Session["LocationFinder-LocationType"].ToString().ToLower() == "meter cupboard"
                    && currentTile != null)
                {
                    String tileName = currentTile.Name;

                    if (!String.IsNullOrEmpty(tileName))
                    {
                        txtName.Enabled = false;
                        String name = String.Format("MC-{0}", tileName);
                        Int32 number = LocationsManager.GetNextCustomLocationNameNumberInTile(name);
                        txtName.Text = String.Format("{0}/{1}", name, number);
                    }
                } 
                #endregion
            }
        }
    }
}