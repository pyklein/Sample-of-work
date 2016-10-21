using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Connors.Framework.Model;

namespace Connors.Erp.Web
{
    public partial class ViewMedia : System.Web.UI.UserControl
    {
        public String ElementId { get; set; }

        protected void Page_Load(object sender, EventArgs e)
        {
            FormViewMediaDetails.DataSource = DocumentsManager.GetDocumentAsIQueryable(ElementId);
            FormViewMediaDetails.DataBind();
        }
    }
}