using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Services;
using Connors.Framework.Model;

namespace Connors.Erp.Web._common.handlers.Locations
{
    /// <summary>
    /// Summary description for $codebehindclassname$
    /// </summary>
    //[WebService(Namespace = "http://tempuri.org/")]
    //[WebServiceBinding(ConformsTo = WsiProfiles.BasicProfile1_1)]
    public class AddLocationHandler : IHttpHandler
    {
        MainDataContext dc = new MainDataContext();

        public void ProcessRequest(HttpContext context)
        {
            context.Response.ContentType = "text/plain";
            Location l          = new Location();
            var type            = context.Request.Params["slctLocationAddTypesId"].ToString().ToUpper();
            l.LocationTypeId    = new Guid(type);
            l.CountryId         = new Guid(context.Request["hiddenCountry"]); 
            l.Line1             = context.Request["txtLine1"];
            l.Line2             = context.Request["txtLine2"];
            l.Line3             = context.Request["txtLine3"];
            l.Line4             = context.Request["txtLine4"];
            l.Postcode          = context.Request["txtPostCode"];
            double lat          = double.Parse(context.Request["txtLatitudeLocation"]);
            double lng          = double.Parse(context.Request["txtLongitudeLocation"]);
            l.Latitude          = lat;
            l.Longitude         = lng;
            l.LocationTypeId    = new Guid(type);
            
       
            if(!String.IsNullOrEmpty(context.Request.Params["slctCounty"].ToString()))
                l.CountyId = new Guid(context.Request.Params["slctCounty"]);

            l.Comment1 = context.Request["txtComment1"];
            l.Comment2 = context.Request["txtComment2"];
            l.Comment3 = context.Request["txtComment3"];

            if (!String.IsNullOrEmpty(context.Request["txtOSgridX"]))
                l.OSGridX = double.Parse(context.Request["txtOSgridX"]);

            if (!String.IsNullOrEmpty(context.Request["txtOSgridY"]))
                l.OSGridY = double.Parse(context.Request["txtOSgridY"]);

            l.LandrangerGridReference = context.Request["txtLandrangerGridReference"];


            l.TileId = TilesManager.GetLocationTile(lat, lng).Id;
            var tileName = TilesManager.GetLocationTile(lat, lng).Name;
            
            if (type.ToLower() == "1BB08D21-22D8-45B9-A87A-C7096972F950".ToLower())
            {
                if (!String.IsNullOrEmpty(tileName))
                {
                    String name = String.Format("MC-{0}", tileName);
                    Int32 number = LocationsManager.GetNextCustomLocationNameNumberInTile(name);
                    l.Name = String.Format("{0}/{1}", name, number);
                }
                else
                    l.Name = "Meter Cupboard To Define";
            }
            else
            {
                l.Name = context.Request["txtLocationAddName"];
            }



            Guid testIdAdd = new Guid(); 
            testIdAdd =LocationsManager.AddLocation(l);

            if (testIdAdd != null)
                context.Response.Write("ok");
            else
                context.Response.Write("ko");
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
