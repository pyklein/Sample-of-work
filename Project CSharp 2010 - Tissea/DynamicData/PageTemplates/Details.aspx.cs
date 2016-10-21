using System;
using System.Data;
using System.Configuration;
using System.Collections;
using System.Linq;
using System.Web;
using System.Web.Security;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.UI.WebControls.WebParts;
using System.Web.UI.HtmlControls;
using System.Xml.Linq;
using System.Web.DynamicData;
using Tissea.DynamicData;
using Connors.Framework.Model;

namespace Connors.Erp.Web
{
    public partial class Details : ErpPage
    {
        protected MetaTable table;

        protected void Page_Init(object sender, EventArgs e)
        {
            table = DetailsDataSource.GetTable();
            DynamicDataManager1.RegisterControl(DetailsView1);
            DetailsView1.RowsGenerator = new AdvancedFieldGenerator(table, false);
        }

        protected void Page_Load(object sender, EventArgs e)
        {
            Title = table.GetDisplayName();
        }

        protected void DetailsView1_ItemDeleted(object sender, DetailsViewDeletedEventArgs e)
        {
            if (e.Exception == null || e.ExceptionHandled)
            {
                Response.Redirect(table.ListActionPath);
            }
        }
    }
}
