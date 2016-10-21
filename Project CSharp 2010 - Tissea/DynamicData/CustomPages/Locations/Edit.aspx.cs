using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.DynamicData;

namespace Connors.Erp.Web.DynamicData.CustomPages.Locations
{
    public partial class Edit : System.Web.UI.Page
    {
        protected MetaTable table;

        protected void Page_Init(object sender, EventArgs e)
        {
            DynamicDataManager1.RegisterControl(DetailsView1);
            table = EditDataSource.GetTable();
        }

        protected void Page_Load(object sender, EventArgs e)
        {
            Title = EditDataSource.GetTable().DisplayName;
        }

        protected void DetailsView1_ItemCommand(object sender, FormViewCommandEventArgs e)
        {
            if (e.CommandName == DataControlCommands.CancelCommandName)
            {
                Response.Redirect(table.ListActionPath);
            }

        }

        protected void DetailsView1_ItemUpdated(object sender, FormViewUpdatedEventArgs e)
        {
            if (e.Exception == null || e.ExceptionHandled)
            {
                Response.Redirect(table.ListActionPath);
            }

        }
    }
}
