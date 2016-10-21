using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.DynamicData;
using Connors.Framework.Common;
using System.Collections.Specialized;

namespace Connors.Erp.Web.DynamicData.FieldTemplates
{
    public partial class MessageTemplate_Edit : FieldTemplateUserControl
    {
        public override Control DataControl
        {
            get
            {
                return RadEditor1;
            }
        }

        protected override void OnDataBinding(EventArgs e)
        {
            base.OnDataBinding(e);

            if (FieldValue != null)
            {
                RadEditor1.Content = FieldValue.ToString();
            }
        }

        protected override void ExtractValues(IOrderedDictionary dictionary)
        {
            dictionary[Column.Name] = RadEditor1.Content;
        }
    }
}