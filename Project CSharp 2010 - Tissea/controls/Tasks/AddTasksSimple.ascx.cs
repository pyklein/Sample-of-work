using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Telerik.Web.UI;
using Connors.Framework.Model;
using System.Collections;

namespace Connors.Erp.Web._common.controls
{
    public partial class AddTasksSimple : System.Web.UI.UserControl
    {
        #region Privates
        private const int ItemsPerRequest = 10; 
        #endregion

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!IsPostBack)
            {
                Utilities.LoadCustomerPriceListsInComboBox(cbxPriceLists, Session["CustomerId"].ToString());
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

        protected void btnAddTask_Click(object sender, EventArgs e)
        {
            TasksManager.AddTaskAsProduct(Session["ActivityIdCreated"].ToString(),
                cbxProducts.SelectedValue, (Double)txtUnitPrice.Value, (Double)txtQuantity.Value); 

            gridTasks.Rebind();
        }

        protected void gridTasks_NeedDataSource(object source, Telerik.Web.UI.GridNeedDataSourceEventArgs e)
        {
            gridTasks.DataSource = TasksManager.GetActivityTasksFromView(Session["ActivityIdCreated"].ToString());
        }

        protected void gridTasks_UpdateCommand(object source, GridCommandEventArgs e)
        {
            GridDataItem dataItem = (GridDataItem)e.Item;
            Hashtable NewValues = new Hashtable();
            e.Item.OwnerTableView.ExtractValuesFromItem(NewValues, (GridEditableItem)e.Item);

            if (NewValues.Count != 0)
            {
                foreach (DictionaryEntry Entry in NewValues)
                {
                    if (Entry.Key.ToString() == "QuantityOrdered")
                    {
                        TasksManager.UpdateTaskQuantity(e.Item.OwnerTableView.DataKeyValues[e.Item.ItemIndex]["Id"].ToString(), Convert.ToDouble(Entry.Value));
                    }
                }
            }
            gridTasks.Rebind();
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
    }
}