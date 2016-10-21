using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;

namespace Connors.Erp.Web._common.controls.ActivityNotes
{
    public partial class List_Insert : System.Web.UI.UserControl
    {
        protected void Page_Load(object sender, EventArgs e)
        {

        }

        protected void AddNote_Click(object sender, EventArgs e)
        {
            GridView1.Visible = false;
            DetailsView1.Visible = true;
            AddNote.Visible = false;
            lblHeader.Text = "Add a Note";
        }

        protected void DetailsView1_ItemInserted(object sender, FormViewInsertedEventArgs e)
        {
            GridView1.Visible = true;
            DetailsView1.Visible = false;
            AddNote.Visible = true;
            GridView1.DataBind();
            DetailsView1.DataBind();
            lblHeader.Text = "Notes";
        }

        protected void DetailsView1_ItemCommand(object sender, FormViewCommandEventArgs e)
        {
            if (e.CommandName == "Cancel")
            {
                GridView1.Visible = true;
                DetailsView1.Visible = false;
                AddNote.Visible = true;
                GridView1.DataBind();
                DetailsView1.DataBind();
                lblHeader.Text = "Notes";
            }
        }
    }
}