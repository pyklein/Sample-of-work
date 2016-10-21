using System;
using System.Web.UI;

namespace Connors.Erp.Web
{
    public partial class EmailAddress : System.Web.DynamicData.FieldTemplateUserControl
    {

        protected override void OnDataBinding(EventArgs e)
        {
            string url = FieldValueString;
            if (!url.StartsWith("mailto:", StringComparison.OrdinalIgnoreCase))
            {
                url = "mailto:" + url;
            }
            HyperLinkEmailAddress.NavigateUrl = url;
        }

        public override Control DataControl
        {
            get
            {
                return HyperLinkEmailAddress;
            }
        }
    }
}
