using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.DynamicData;
using System.Collections.Specialized;

namespace Connors.Erp.Web.DynamicData.FieldTemplates
{
    public partial class ActivityGuid_Edit : FieldTemplateUserControl
    {
        protected void Page_Load(object sender, EventArgs e)
        {
            String id = String.Empty;

            if (Request.QueryString["Id"] != null)
            {
                id = Request.QueryString["Id"].ToString();
            }
            else if(Session["ActivityGuid"] != null)
            {
                id = Session["ActivityGuid"].ToString();
            }

            Label1.Text = id;
        }

        protected override void ExtractValues(IOrderedDictionary dictionary)
        {
            dictionary[Column.Name] = ConvertEditedValue(Label1.Text);
        }

        public override Control DataControl
        {
            get
            {
                return Label1;
            }
        }
    }
}