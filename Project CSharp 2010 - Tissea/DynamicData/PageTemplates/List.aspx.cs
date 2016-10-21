using System;
using System.Web.DynamicData;
using Tissea.DynamicData;
using System.Web.UI.WebControls;
using Telerik.Web.UI;
using System.Web.Security;
using Connors.Framework.Model;
using Connors.Framework.Language.Properties;

namespace Connors.Erp.Web
{
    public partial class List : ErpPage
    {
        #region Privates
        protected MetaTable table;
        DDRadGrid _grid; 
        #endregion

        #region Page Events
        protected void Page_Init(object sender, EventArgs e)
        {
            table = GridDataSource.GetTable();
            BuildDDGrid(table.Name);
            BuildValidator();

            _grid = (DDRadGrid)placeHolderList.FindControl("DDRadGridList");

            DynamicDataManager1.RegisterControl(_grid, true /*setSelectionFromUrl*/);
            _grid.EnablePersistedSelection();

            //DynamicDataFutures.RegisterListDefaults(GridDataSource, InsertHyperLink);
        }

        protected void Page_Load(object sender, EventArgs e)
        {
            Title = table.GetDisplayName();

            // Disable various options if the table is readonly
            if (table.IsReadOnly)
            {
                RadToolBarButton btn = (RadToolBarButton)toolbarList.FindButtonByCommandName("Insert");
                DynamicHyperLink link = (DynamicHyperLink)btn.FindControl("InsertHyperLink");
                link.Enabled = false;
            }

            _grid = (DDRadGrid)placeHolderList.FindControl("DDRadGridList");
            
            //Adding Ajax Manager Setting to the page
            RadAjaxManager1.AjaxSettings.AddAjaxSetting(_grid, _grid);
            RadAjaxManager1.AjaxSettings.AddAjaxSetting(RadAjaxManager1, _grid);
        } 
        #endregion

        protected void RadAjaxManager1_AjaxRequest(object sender, Telerik.Web.UI.AjaxRequestEventArgs e)
        {
            switch (e.Argument.ToString())
            {
                case "ChangePageSize":
                    ChangePageSize();
                    break;

                case "FilterPanelCollapsedExpanded":
                    ChangePageSize();
                    break;
            }
        }

        #region Private Methods
        private void ChangePageSize()
        {
            _grid = (DDRadGrid)placeHolderList.FindControl("DDRadGridList");

            //Calculate the number of rows that fit in the RadPane.
            //In this case 23 is the sum of the height of a single row and its upper border width.
            //Depending on the paticular scenario this value may vary.
            //int rows = (Int32.Parse(this.RadPaneList.Height.Value.ToString()) - 60) / 23;
            int rows = (Int32.Parse(this.RadPaneList.Height.Value.ToString()) - 60) / 34;
            if (rows >= 1)
            {
                _grid.PageSize = rows;

                // Check whether the CurrentPageIndex is correct.
                if (Session["itemsCount"] != null)
                {
                    int itemsCount = (int)Session["itemsCount"];
                    int pageCount = (int)Math.Ceiling(((double)itemsCount / rows));
                    if (_grid.MasterTableView.CurrentPageIndex > pageCount - 1)
                    {
                        _grid.MasterTableView.CurrentPageIndex = pageCount - 1;
                    }
                }

                _grid.Rebind();
            }
        }

        private void BuildValidator()
        {
            ImprovedDynamicValidator validator = new ImprovedDynamicValidator();
            validator.ID = "ImprovedDynamicValidator1";
            validator.ControlToValidate = "DDRadGridList";
            this.placeHolderValidator.Controls.Add(validator);
        }

        private void BuildDDGrid(String tableName)
        {
            DDRadGrid DDRadGridList = new DDRadGrid(PageTemplate.List);
            DDRadGridList.ID = "DDRadGridList";
            DDRadGridList.DataSourceID = "GridDataSource";
            DDRadGridList.Width = System.Web.UI.WebControls.Unit.Percentage(100);
            DDRadGridList.Height = System.Web.UI.WebControls.Unit.Percentage(100);
            DDRadGridList.BorderWidth = System.Web.UI.WebControls.Unit.Pixel(0);
            DDRadGridList.AllowFilteringByColumn = false;
            DDRadGridList.AllowPaging = true;
            DDRadGridList.AllowSorting = true;
            DDRadGridList.AutoGenerateColumns = false;
            DDRadGridList.EnableViewState = true;
            DDRadGridList.GridLines = GridLines.None;
            DDRadGridList.ShowGroupPanel = true;
            DDRadGridList.ShowStatusBar = true;

            DDRadGridList.MasterTableView.TableLayout = GridTableLayout.Fixed;

            //GridButtonColumn btnColumn = new GridButtonColumn();
            //btnColumn.Text = Resources.EDIT;
            //btnColumn.CommandName = "Edit";
            //DDRadGridList.MasterTableView.Columns.Add(btnColumn);

            String[] fields = {"Id"};

            GridHyperLinkColumn hyperlinkEdit = new GridHyperLinkColumn();
            hyperlinkEdit.Text = Resources.Edit;
            hyperlinkEdit.UniqueName = Resources.Edit;
            hyperlinkEdit.DataNavigateUrlFields = fields;
            hyperlinkEdit.DataNavigateUrlFormatString = ApplicationUrls.ApplicationBaseUrl + tableName + "/Edit.aspx?Id={0}";
            DDRadGridList.MasterTableView.Columns.Add(hyperlinkEdit);

            GridHyperLinkColumn hyperlinkDetails = new GridHyperLinkColumn();
            hyperlinkDetails.Text = Resources.Details;
            hyperlinkDetails.UniqueName = Resources.Details;
            hyperlinkDetails.DataNavigateUrlFields = fields;
            hyperlinkDetails.DataNavigateUrlFormatString = ApplicationUrls.ApplicationBaseUrl + tableName + "/Details.aspx?Id={0}";
            DDRadGridList.MasterTableView.Columns.Add(hyperlinkDetails);

            DDRadGridList.PagerStyle.AlwaysVisible = true;
            DDRadGridList.PagerStyle.Mode = GridPagerMode.NextPrevNumericAndAdvanced;
            DDRadGridList.ClientSettings.AllowDragToGroup = true;
            DDRadGridList.ClientSettings.EnableRowHoverStyle = true;
            DDRadGridList.ClientSettings.Scrolling.AllowScroll = true;
            DDRadGridList.ClientSettings.Scrolling.UseStaticHeaders = true;
            DDRadGridList.ClientSettings.Selecting.AllowRowSelect = true;

            this.placeHolderList.Controls.Add(DDRadGridList);
        } 
        #endregion
    }
}
