using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Connors.Framework.Model;

namespace Connors.Erp.Web._common.controls.ActivityWorkTimes
{
    public partial class List_Insert : System.Web.UI.UserControl
    {
        protected void Page_Load(object sender, EventArgs e)
        {

        }

        protected void AddWorkTime_Click(object sender, EventArgs e)
        {
            GridView1.Visible = false;
            DetailsView1.Visible = true;
            AddWorkTime.Visible = false;
            lblHeader.Text = "Add a Work Time";
        }

        protected void DetailsView1_ItemInserted(object sender, FormViewInsertedEventArgs e)
        {
            GridView1.Visible = true;
            DetailsView1.Visible = false;
            AddWorkTime.Visible = true;
            GridView1.DataBind();
            DetailsView1.DataBind();
            lblHeader.Text = "Work Times";
        }

        protected void DetailsView1_ItemCommand(object sender, FormViewCommandEventArgs e)
        {
            if (e.CommandName == "Cancel")
            {
                GridView1.Visible = true;
                DetailsView1.Visible = false;
                AddWorkTime.Visible = true;
                GridView1.DataBind();
                DetailsView1.DataBind();
                lblHeader.Text = "Work Times";
            }
        }

        protected void GridDataSource_Selecting(object sender, LinqDataSourceSelectEventArgs e)
        {
            if (Session["ActivityGuid"] != null)
            {
                if (!String.IsNullOrEmpty(Session["ActivityGuid"].ToString()))
                {
                    MainDataContext dc = new MainDataContext();
                    e.Result = from w in dc.ActivityWorkTimes
                               where w.ActivityGuid == new Guid(Session["ActivityGuid"].ToString())
                               select w;
                }
            }
        }
    }
}