using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.DynamicData;

namespace Connors.Erp.Web.DynamicData.CustomPages.Locations
{
    public partial class Details : System.Web.UI.Page
    {
        protected MetaTable table;

        protected void Page_Init(object sender, EventArgs e)
        {
            DynamicDataManager1.RegisterControl(DetailsView1);
            table = DetailsDataSource.GetTable();
            //DetailsView1.RowsGenerator = new HideColumnFieldsManager(table, PageTemplate.Details);
        }

        protected void Page_Load(object sender, EventArgs e)
        {
            table = DetailsDataSource.GetTable();
            Title = table.DisplayName;

            ListHyperLink.NavigateUrl = table.ListActionPath;
        }
    }
}
