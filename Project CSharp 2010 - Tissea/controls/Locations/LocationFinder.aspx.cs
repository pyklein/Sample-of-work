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
    public partial class LocationFinderOld : ErpPage
    {
        String key = System.Configuration.ConfigurationManager.AppSettings.Get("googlemaps.subgurim.net");

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                SetupMap();
                //Load Country data in combo box
                Utilities.LoadCountriesWithoutAllInComboBox(cbxCountries);
                //Because we are in the UK, we select UK as default country
                //TODO: Selection based on User location!
                RadComboBoxItem item = cbxCountries.FindItemByText("United Kingdom");
                item.Selected = true;
            }
        }

        #region Privates Methods
        private void SetupMap()
        {
            GMap1.setCenter(new GLatLng(53.489147, -2.857151), 10);
            //GMap1.mapType = GMapType.GTypes.Hybrid;
            //GMap1.addMapType(GMapType.GTypes.Physical);
            GMap1.addControl(new GControl(GControl.preBuilt.MenuMapTypeControl));
            //GMap1.enableRotation = true;
            GMap1.enableHookMouseWheelToZoom = true;

            //StringBuilder sb = new StringBuilder();
            //sb.Append("function(marker, point) {");
            //GLatLng latlng = new GLatLng("point");
            //GInfoWindow window = new GInfoWindow(latlng, "<div style=\"height:140px;\"><blink>Loading...</blink></div>");
            //sb.Append(window.ToString(GMap1.GMap_Id));
            //sb.Append("}");

            //GMap1.addListener(new GListener(GMap1.GMap_Id, GListener.Event.click, sb.ToString()));

            //StringBuilder sb2 = new StringBuilder();
            //sb2.Append("function goTo(point){");
            //GLatLng point = new GLatLng("point");
            //sb2.AppendFormat("{0}.setZoom(11);", GMap1.GMap_Id);
            //GMove move = new GMove(1, point);
            //sb2.Append(move.ToString(GMap1.GMap_Id));
            //GMarker marker = new GMarker(point);
            //sb2.Append(marker.ToString(GMap1.GMap_Id));
            //sb2.Append("}");
            //GMap1.addCustomJavascript(sb2.ToString());
        }

        private StringBuilder BuildInfoWindow(GeoCode geocode)
        {
            StringBuilder sb = new StringBuilder();
            sb.Append("<div align=\"left\" style=\"font-size: small\">");
            sb.Append("<br />");
            sb.AppendFormat(Resources.PlaceName + ": <i>{0}</i> ", geocode.name);
            //sb.Append("<br />");
            //sb.AppendFormat(Resources.Address + ": <i>{0}</i> ", geocode.Placemark.address);
            sb.Append("<br />");
            sb.AppendFormat(String.Format("{0} & {1}", Resources.Latitude, Resources.Longitude) + ": <i>{0}</i> ", geocode.Placemark.coordinates.ToString());
            sb.Append("</div>");

            return sb;
        }

        private void ShowResultLocateInfoOnMap(GeoCode geocode)
        {
            GMap1.setCenter(geocode.Placemark.coordinates, 18);
            GMarkerOptions options = new GMarkerOptions();
            options.draggable = true;
            GMarker marker = new GMarker(geocode.Placemark.coordinates, options);
            GInfoWindow window = new GInfoWindow(marker, BuildInfoWindow(geocode).ToString(), false, GListener.Event.mouseover);
            GMap1.addInfoWindow(window);

            txtLatLng.Text = geocode.Placemark.coordinates.ToString();

            //Checking whether there is a location with identical lat lng in the database?
            Int32 count = LocationsManager.FindLocationByLatitudeLongitude(geocode.Placemark.coordinates.lat,
                geocode.Placemark.coordinates.lng).Count();

            //If so, we display a message and ask the use whether he/she wants to view them
            if (count > 0)
            {
                lblNbFoundLocations.Visible = true;
                lblNbFoundLocations.ForeColor = Color.Red;
                lblNbFoundLocations.Text = String.Format(Resources.SystemFoundLocationsWithIdenticalLatitudeLongitude, count);
            }
            else
            {
                lblNbFoundLocations.Visible = false;
                lblNbFoundLocations.Text = String.Empty;
            }

            //Set the latitude & longitude
            Session["LocationFinder-CoordinatesFound"] = geocode.Placemark.coordinates;
        }

        private void DrawTileOnMap(Tile tile)
        {
            List<GLatLng> points = new List<GLatLng>();
            points.Add(new GLatLng(tile.LowerLeftY, tile.LowerLeftX));
            points.Add(new GLatLng(tile.UpperLeftY, tile.UpperLeftX));
            points.Add(new GLatLng(tile.UpperRightY, tile.UpperRightX));
            points.Add(new GLatLng(tile.LowerRightY, tile.LowerRightX));

            GPolygon poligon = new GPolygon(points, "000000", 1, 1, "654321", 1);
            GMap1.addPolygon(poligon);
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
            }
        }

        protected string GMap1_Click(object s, GAjaxServerEventArgs e)
        {
            return string.Empty;
            //inverseGeocodingManager igeoManager = new inverseGeocodingManager(e.point, "en");
            //inverseGeocoding iGeos = igeoManager.inverseGeoCodeRequest();
            //geoName geo;
            //if (iGeos.geonames.Count > 0)
            //{
            //    geo = iGeos.geonames[0];

            //    StringBuilder sb = new StringBuilder();
            //    sb.Append("<div align=\"left\">");
            //    sb.Append("<b>Nearest Place </b>");
            //    sb.Append("<br />");
            //    sb.AppendFormat("Place name: <i>{0}</i> ", geo.name);
            //    sb.Append("<br />");
            //    sb.AppendFormat("Point: <i>{0}</i>", geo.nearestPlacePoint.ToString());
            //    sb.Append("<br />");
            //    sb.AppendFormat("Elevation: <i>{0}</i>", geo.nearestPlaceElevation > -9000 ? geo.nearestPlaceElevation.ToString() : "No info");
            //    sb.Append("<br />");
            //    sb.AppendFormat("Country Name (Code): <i>{0} ({1})</i>", geo.countryName, geo.countryCode);
            //    sb.Append("<br />");
            //    sb.AppendFormat("Click point - Nearest Place distance (Km): <i>{0}</i>", Math.Round(geo.distance, 3));
            //    sb.Append("</div>");

            //    sb.Append("<br />");
            //    sb.Append("<div align=\"left\">");
            //    sb.Append("<b>Click point</b>");
            //    sb.Append("<br />");
            //    sb.AppendFormat("Point: <i>{0}</i>", geo.initialPoint.ToString());
            //    sb.Append("<br />");
            //    sb.AppendFormat("Elevation: <i>{0}</i>", geo.initialPointElevation > -9000 ? geo.initialPointElevation.ToString() : "No info");
            //    sb.Append("<br />");
            //    sb.Append("</div>");

            //    GInfoWindow window = new GInfoWindow(e.point, sb.ToString(), true);
            //    return window.ToString(e.map);
            //}
            //else return string.Empty;
        }

        protected void btnCreateLocation_Click(object sender, EventArgs e)
        {
            GLatLng coordinates = (GLatLng)Session["LocationFinder-CoordinatesFound"];

            Tile tile = TilesManager.GetLocationTile(coordinates.lat, coordinates.lng);
            
            lblTileName.Text = tile.Name;

            DrawTileOnMap(tile);
        }
    }
}
