using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Connors.Framework.Model;
using Telerik.Web.UI;

namespace Connors.Erp.Web._common.controls.Tasks
{
    public partial class AddTaskToMultipleActivities : System.Web.UI.Page
    {
        #region Privates
        private const int ItemsPerRequest = 10;
        #endregion

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                if (Session["AddMultipleTasks.SelectedIds"] != null)
                {
                    String[] ids = (String[])Session["AddMultipleTasks.SelectedIds"];
                }
            }
        }

        protected void cbxPriceLists_ItemsRequested(object o, Telerik.Web.UI.RadComboBoxItemsRequestedEventArgs e)
        {
            Utilities.LoadCustomerPriceListsInComboBox(cbxPriceLists, Session["CustomerId"].ToString());
        }

        protected void cbxProducts_ItemsRequested(object o, Telerik.Web.UI.RadComboBoxItemsRequestedEventArgs e)
        {
            Int32 total = ProductsManager.GetProductCountBySearchCriteria(e.Text);

            Int32 itemOffset = e.NumberOfItems;
            Int32 endOffset = Math.Min(itemOffset + ItemsPerRequest, total);
            e.EndOfItems = endOffset == total;

            if (total > 0)
                Utilities.LoadProductsInComboBoxBySearchCriteria((RadComboBox)o, itemOffset, e.Text);

            e.Message = Utilities.GetStatusMessage(endOffset, total);
        }

        protected void cbxPriceLists_SelectedIndexChanged(object o, RadComboBoxSelectedIndexChangedEventArgs e)
        {
            ChangePrice(e.Value, cbxProducts.SelectedValue);
        }

        protected void cbxProducts_SelectedIndexChanged(object o, RadComboBoxSelectedIndexChangedEventArgs e)
        {
            ChangePrice(cbxPriceLists.SelectedValue, e.Value);
        }

        private void ChangePrice(String plId, String pId)
        {
            if (!String.IsNullOrEmpty(plId) && !String.IsNullOrEmpty(pId))
            {
                txtUnitPrice.Value = ProductsManager.GetCustomerProductBestPrice(
                    Session["CustomerId"].ToString(),
                    plId,
                    pId);

                Session["CurrentPriceListId"] = plId;
                Session["CurrentProductId"] = pId;
            }
            else
            {
                txtUnitPrice.Text = String.Empty;
            }
        }

        protected void btnInsert_Click(object sender, EventArgs e)
        {
            String[] ids = (String[])Session["AddMultipleTasks.SelectedIds"];

            if (TasksManager.AddTaskToMultipleActivities(ids.ToList(), cbxProducts.SelectedValue, txtUnitPrice.Value.Value,
                txtQuantity.Value.Value))
            {
                //Close the window if success
                ScriptManager.RegisterStartupScript(this, GetType(), "AddMultipleTasksComplete", "CloseWindow();", true);
            }

            Session["AddMultipleTasks.SelectedIds"] = null;
        }
    }
}
