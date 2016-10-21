using System.Web.UI;
using System;

namespace Connors.Erp.Web
{
    public partial class Url : System.Web.DynamicData.FieldTemplateUserControl
    {

        protected override void OnDataBinding(EventArgs e)
        {
            string url = FieldValueString;
            if (!(url.StartsWith("http://", StringComparison.OrdinalIgnoreCase) || url.StartsWith("https://", StringComparison.OrdinalIgnoreCase)))
            {
                url = "http://" + url;
            }
            HyperLinkUrl.NavigateUrl = url;
        }

        public override Control DataControl
        {
            get
            {
                return HyperLinkUrl;
            }
        }
    }
}
