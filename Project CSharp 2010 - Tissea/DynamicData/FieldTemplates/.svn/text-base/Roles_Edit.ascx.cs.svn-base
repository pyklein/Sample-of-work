using System;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.UI.WebControls.WebParts;
using System.Web.UI.HtmlControls;
using Connors.Framework.Model;

namespace Connors.Erp.Web
{
    public partial class Roles_EditField : System.Web.DynamicData.FieldTemplateUserControl
    {
        protected override void OnDataBinding(EventArgs e)
        {
            base.OnDataBinding(e);

            // get all the roles from the aspnet_Roles table and
            // populate the CheckBoxList
            //var DC = new AttributesDataContext();
            var DC = new MembershipDataContext();
            var allRoles = from r in DC.aspnet_Roles
                           select r.RoleName;
            CheckBoxList1.DataSource = allRoles;
            CheckBoxList1.DataBind();
        }

        protected override void ExtractValues(IOrderedDictionary dictionary)
        {
            String value = "";
            for (int i = 0; i < CheckBoxList1.Items.Count; i++)
            {
                // append all the boxes that are checked
                if (CheckBoxList1.Items[i].Selected == true)
                    value += CheckBoxList1.Items[i].Text + ",";
            }
            if (String.IsNullOrEmpty(value))
            {
                dictionary[Column.Name] = value;
            }
            else
            {
                dictionary[Column.Name] = value.Substring(0, value.Length - 1);
            }
        }

        public override Control DataControl
        {
            get
            {
                return CheckBoxList1;
            }
        }

        protected void CheckBoxList1_DataBound(object sender, EventArgs e)
        {
            if (FieldValue != null)
            {
                String[] selectRoles = ((String)FieldValue).Split((char)',');
                for (int i = 0; i < CheckBoxList1.Items.Count; i++)
                {
                    // select all check boxes that are in the array 
                    if (selectRoles.Contains(CheckBoxList1.Items[i].Value))
                    {
                        CheckBoxList1.Items[i].Selected = true;
                    }
                }
            }
        }
    }
}