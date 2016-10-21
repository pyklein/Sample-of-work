using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using Telerik.Web.UI;
using Connors.Framework.Model;

namespace Connors.Erp.Web._common.controls.ActivityWorkTimes
{
    public partial class InsertEdit : System.Web.UI.UserControl
    {
        private object _dataItem = null;
        private const int ItemsPerRequest = 10;

        public object DataItem
        {
            get
            {
                return this._dataItem;
            }
            set
            {
                this._dataItem = value;
            }
        }

        protected void Page_Load(object sender, EventArgs e)
        {
            if (!(DataItem is GridInsertionObject))
            {
                //If not Insertion >> i.e. Edit mode
                vwWorkTime wt = (vwWorkTime)DataItem;

                if (wt != null)
                {
                    //cbxEmployee.SelectedValue = wt.EmployeeId.ToString();
                    //cbxEmployee.Text = String.Format("{0} {1} - {3}", wt.FirstName, wt.LastName, wt.Number); 
                    txtDateTime.SelectedDate = wt.DateTime;
                    txtTimeSpent.Value = wt.TimeSpent;
                    if (wt.IsPrivate.HasValue)
                        ckbIsPrivate.Checked = wt.IsPrivate.Value;
                }
            }
        }

        protected void cbxEmployee_ItemsRequested(object o, RadComboBoxItemsRequestedEventArgs e)
        {
            Int32 total = EmployeesManager.GetEmployeesCountBySearchCriteria(e.Text);

            Int32 itemOffset = e.NumberOfItems;
            Int32 endOffset = Math.Min(itemOffset + ItemsPerRequest, total);
            e.EndOfItems = endOffset == total;

            if (total > 0)
                Utilities.LoadEmployeesInComboxBySearchCriteria((RadComboBox)o, itemOffset, e.Text);

            e.Message = Utilities.GetStatusMessage(endOffset, total);
        }
    }
}