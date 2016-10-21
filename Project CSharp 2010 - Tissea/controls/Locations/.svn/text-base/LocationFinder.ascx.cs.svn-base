using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Drawing;
using Subgurim.Controles;
using System.Text;
using Telerik.Web.UI;
using Connors.Framework.Model;
using Connors.Framework.Language.Properties;

namespace Connors.Erp.Web._common.controls
{
    public partial class LocationFinder : System.Web.UI.UserControl
    {
        String key = System.Configuration.ConfigurationManager.AppSettings.Get("googlemaps.subgurim.net");

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                Session["LocationFinder-Resources-SelectALocationType"] = Resources.SelectALocationType;
                SetupMap();
                //Load Country data in combo box
                Utilities.LoadCountriesWithoutAllInComboBox(cbxCountries);
                //Because we are in the UK, we select UK as default country
                //TODO: Selection based on User location!
                RadComboBoxItem item = cbxCountries.FindItemByText("United Kingdom");
                item.Selected = true;

                Utilities.LoadLocationTypesWithoutAllInComboBox(cbxLocationType);

                #region Initialise Session variables
                //Session["LocationFinder-LocationName"] = String.Empty;
                //Session["LocationFinder-LatitudeFound"] = null;
                //Session["LocationFinder-LongitudeFound"] = null;
                //Session["LocationFinder-Line1"] = String.Empty;
                //Session["LocationFinder-Line2"] = String.Empty;
                //Session["LocationFinder-Line3"] = String.Empty;
                //Session["LocationFinder-Line4"] = String.Empty;
                //Session["LocationFinder-Country"] = String.Empty;
                //Session["LocationFinder-County"] = String.Empty;
                //Session["LocationFinder-PostCode"] = String.Empty;
                //Session["LocationFinder-OSGridX"] = null;
                //Session["LocationFinder-OSGridY"] = null;
                //Session["LocationFinder-StaticMapUrl"] = String.Empty;
                //Session["LocationFinder-TileName"] = String.Empty;
                Session["LocationFinder-LocationType"] = String.Empty; 
                #endregion

                if (Session["LocationFinder-LocationToAdd"] == null)
                    Session["LocationFinder-LocationToAdd"] = new Connors.Framework.Model.Location();
            }

            if (Session["LocationFinder-LocationToAdd"] != null)
            {
                Connors.Framework.Model.Location newLocation =
                    (Connors.Framework.Model.Location)Session["LocationFinder-LocationToAdd"];

                if (!String.IsNullOrEmpty(cbxLocationType.SelectedValue))
                    newLocation.LocationTypeId = new Guid(cbxLocationType.SelectedValue);

                if (cbxLocationType.SelectedItem != null)
                    Session["LocationFinder-LocationType"] = cbxLocationType.SelectedItem.Text;
            }
        }

        #region Privates Methods
        private void SetupMap()
        {
            GMap1.setCenter(new GLatLng(53.489147, -2.857151), 10, GMapType.GTypes.Hybrid);
            GMap1.addControl(new GControl(GControl.preBuilt.MenuMapTypeControl));
            GMap1.addControl(new GControl(GControl.preBuilt.LargeMapControl));
            GMap1.ajaxUpdateProgressMessage = Resources.UpdatingMapPleaseWait;
        }

        //private StringBuilder BuildInfoWindow(GeoCode geocode)
        //{
        //    StringBuilder sb = new StringBuilder();
        //    sb.Append("<div align=\"left\">");
        //    sb.Append("<br />");
        //    sb.AppendFormat(Resources.PlaceName + ": <i>{0}</i> ", geocode.name);
        //    sb.Append("<br />");
        //    sb.AppendFormat(Resources.Address + ": <i>{0}</i> ", geocode.Placemark.address);
        //    sb.Append("<br />");
        //    sb.AppendFormat(String.Format("{0} & {1}", Resources.Latitude, Resources.Longitude) + ": <i>{0}</i> ", geocode.Placemark.coordinates.ToString());
        //    sb.Append("</div>");

        //    return sb;
        //}

        private void ShowResultLocateInfoOnMap(GeoCode geocode)
        {
            GMap1.resetMarkers();
            GMap1.resetListeners();

            GMap1.setCenter(geocode.Placemark.coordinates, 18);
            GMarker markerDraggable = new GMarker(geocode.Placemark.coordinates);
            GMarkerOptions mOpts = new GMarkerOptions();
            mOpts.draggable = true;
            markerDraggable.options = mOpts;

            String jsEnd = String.Format(@"
               function(point)
               {{
                  var ev = new serverEvent('PointerMove', {0});
                  ev.addArg(point.lat());
                  ev.addArg(point.lng());
                  ev.send();
               }}
               ", GMap1.GMap_Id);

            GMap1.Add(new GListener(markerDraggable.ID, GListener.Event.dragend, jsEnd));

            GMap1.addGMarker(markerDraggable);

            CheckForSimilarLocations(geocode.Placemark.coordinates);

            //Set the latitude & longitude
            Session["LocationFinder-LatitudeFound"] = geocode.Placemark.coordinates.lat;
            Session["LocationFinder-LongitudeFound"] = geocode.Placemark.coordinates.lng;

            UpdateLocationDetails(geocode.Placemark.coordinates);
        }

        private void CheckForSimilarLocations(GLatLng point)
        {
            var locationsFound = LocationsManager.FindLocationByLatitudeLongitude(point.lat,point.lng);

            if (locationsFound != null)
            {
                //Define the Location found at similar coordinates
                Session["LocationFinder-LocationFoundAtSameCoordinates"] = locationsFound;
                Session["LocationFinder-LocationFoundAtSameCoordinatesCount"] = locationsFound.Count();

                //If so, we display a message and ask the use whether he/she wants to view them
                if (locationsFound.Count() > 0)
                {
                    lblNbFoundLocations.Visible = true;
                    lblNbFoundLocations.ForeColor = Color.Red;
                    lblNbFoundLocations.Text = String.Format(Resources.SystemFoundLocationsWithSimilarLatitudeLongitude, locationsFound.Count());
                }
                else
                {
                    lblNbFoundLocations.Visible = false;
                    lblNbFoundLocations.Text = String.Empty;
                }
            }
        }

        private void UpdateLocationDetails(GLatLng point)
        {
            //Adding Lat/Lng coordinates to Location object
            if (Session["LocationFinder-LocationToAdd"] != null)
            {
                Connors.Framework.Model.Location newLocation =
                    (Connors.Framework.Model.Location)Session["LocationFinder-LocationToAdd"];

                newLocation.Latitude = point.lat;
                newLocation.Longitude = point.lng;

                Tile locTile = TilesManager.GetLocationTile(newLocation.Latitude.Value, newLocation.Longitude.Value);
                newLocation.TileId = locTile.Id;
            }
        }
        #endregion

        protected void btnLocateByAddress_Click(object sender, EventArgs e)
        {
            if (!String.IsNullOrEmpty(txtPostcode.Text))
            {
                StringBuilder sb = new StringBuilder();

                if (!String.IsNullOrEmpty(txtStreet.Text))
                    sb.AppendFormat("{0}, ", txtStreet.Text);

                if (!String.IsNullOrEmpty(txtTown.Text))
                    sb.AppendFormat("{0}, ", txtTown.Text);

                if (!String.IsNullOrEmpty(txtCounty.Text))
                    sb.AppendFormat("{0}, ", txtCounty.Text);

                if (!String.IsNullOrEmpty(txtPostcode.Text))
                    sb.AppendFormat("{0}, ", txtPostcode.Text);

                if (!String.IsNullOrEmpty(cbxCountries.Text))
                    sb.AppendFormat("{0}", cbxCountries.Text);

                GeoCode geocode = GMap.geoCodeRequest(sb.ToString(), key);
                ShowResultLocateInfoOnMap(geocode);

                //Define address details
                Session["LocationFinder-Line1"] = txtStreet.Text;
                Session["LocationFinder-Line2"] = txtTown.Text;
                Session["LocationFinder-PostCode"] = txtPostcode.Text;
                Session["LocationFinder-County"] = txtCounty.Text;
                Session["LocationFinder-Country"] = cbxCountries.SelectedItem.Text;
            }
        }

        protected void btnLocateByXYCoordinates_Click(object sender, EventArgs e)
        {
            if (!String.IsNullOrEmpty(txtXOSGrid.Text) && !String.IsNullOrEmpty(txtYOSGrid.Text))
            {
                //Get the Coordinates from Streemap
                GLatLng coordinates = StreetmapGeocoder.GetLatLngFromOSXY(txtXOSGrid.Text, txtYOSGrid.Text);
                //Get the Geocode info from Google
                GeoCode geocode = GMap.geoCodeRequest(coordinates, key);
                //Redefine Lat & Lng because the geocoder is not as accurate as Streetmap lat\lng
                geocode.Placemark.coordinates.lat = coordinates.lat;
                geocode.Placemark.coordinates.lng = coordinates.lng;

                ShowResultLocateInfoOnMap(geocode);

                //Define OS Grid coordinates
                Session["LocationFinder-OSGridX"] = txtXOSGrid.Text;
                Session["LocationFinder-OSGridY"] = txtYOSGrid.Text;

                //Adding OS Grid coordinates to Location object
                if (Session["LocationFinder-LocationToAdd"] != null)
                {
                    Connors.Framework.Model.Location newLocation =
                        (Connors.Framework.Model.Location)Session["LocationFinder-LocationToAdd"];

                    newLocation.OSGridX = Convert.ToDouble(txtXOSGrid.Text);
                    newLocation.OSGridY = Convert.ToDouble(txtYOSGrid.Text);
                }
            }
        }

        protected string GMap1_ServerEvent(object s, GAjaxServerEventOtherArgs e)
        {
            string js = string.Empty;
            switch (e.eventName)
            {
                case "PointerMove":
                    GLatLng point = new GLatLng(Convert.ToDouble(e.eventArgs[0]), Convert.ToDouble(e.eventArgs[1]));
                    //GInfoWindow window = new GInfoWindow(point, String.Format("Coordinates: {0}/{1}", point.lat, point.lng));
                    //js = window.ToString(e.who);

                    //Set new the latitude & longitude when marker is moved
                    Session["LocationFinder-LatitudeFound"] = point.lat;
                    Session["LocationFinder-LongitudeFound"] = point.lng;

                    CheckForSimilarLocations(e.point);
                    UpdateLocationDetails(e.point);
                    break;
            }
            return js;
        }
    }
}