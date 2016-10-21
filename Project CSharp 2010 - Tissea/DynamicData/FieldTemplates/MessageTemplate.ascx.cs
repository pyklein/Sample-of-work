using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.DynamicData;

namespace Connors.Erp.Web.DynamicData.FieldTemplates
{
    public partial class MessageTemplate : FieldTemplateUserControl
    {
        public override Control DataControl
        {
            get
            {
                return litHtml;
            }
        }

        protected override void OnDataBinding(EventArgs e)
        {
            base.OnDataBinding(e);

            litHtml.Text = FieldValue.ToString();
        }
    }
}