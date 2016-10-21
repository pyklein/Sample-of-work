<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="AddTasksSimple.ascx.cs" Inherits="Connors.Erp.Web._common.controls.AddTasksSimple" %>

<%@ Import Namespace="Connors.Framework.Model" %>


<style type="text/css">
    .style1
    {
        width: 100%;
    }
    .style1 .column
    {
        width: 160px;
    }
    .invisibleTextBox
    {
        visibility: hidden;
    }
</style>
<telerik:RadAjaxLoadingPanel ID="RadAjaxLoadingPanel1" runat="server" />
<telerik:RadAjaxManager ID="RadAjaxManager1" runat="server" DefaultLoadingPanelID="RadAjaxLoadingPanel1">
    <AjaxSettings>
        <telerik:AjaxSetting AjaxControlID="btnAddTask">
            <UpdatedControls>
                <telerik:AjaxUpdatedControl ControlID="gridTasks" />
            </UpdatedControls>
        </telerik:AjaxSetting>
        <telerik:AjaxSetting AjaxControlID="cbxPriceLists">
            <UpdatedControls>
                <telerik:AjaxUpdatedControl ControlID="txtUnitPrice" />
            </UpdatedControls>
        </telerik:AjaxSetting>
        <telerik:AjaxSetting AjaxControlID="cbxProducts">
            <UpdatedControls>
                <telerik:AjaxUpdatedControl ControlID="txtUnitPrice" />
            </UpdatedControls>
        </telerik:AjaxSetting>
    </AjaxSettings>
</telerik:RadAjaxManager>
<telerik:RadSplitter ID="RadSplitter1" runat="server" Width="850px" Orientation="Horizontal">
    <telerik:RadPane ID="PaneAddTask" runat="server" Height="50px" Scrolling="None">
        <table class="style1" cellpadding="2" cellspacing="0">
            <tr>
                <td>
                    <asp:Literal runat="server" ID="Literal2" Text="<%$ ErpLanguage:PriceList %>" />
                </td>
                <td>
                    <asp:Literal runat="server" ID="Literal1" Text="<%$ ErpLanguage:Product %>" />
                </td>
                <td>
                    <asp:Literal runat="server" ID="Literal3" Text="<%$ ErpLanguage:Quantity %>" />
                </td>
                <td>
                    <asp:Literal runat="server" ID="Literal4" Text="<%$ ErpLanguage:Price %>" />
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>
                    <telerik:RadComboBox ID="cbxPriceLists" runat="server" DropDownWidth="200px"
                        OnItemsRequested="cbxPriceLists_ItemsRequested" AutoPostBack="true"
                        OnSelectedIndexChanged="cbxPriceLists_SelectedIndexChanged"/>
                </td>
                <td>
                    <telerik:RadComboBox ID="cbxProducts" runat="server" Width="300px" Height="100px"
                        EmptyMessage="Select a Location" EnableLoadOnDemand="true" ShowMoreResultsBox="true"
                        EnableVirtualScrolling="true" OnItemsRequested="cbxProducts_ItemsRequested"
                        AutoPostBack="true" OnSelectedIndexChanged="cbxProducts_SelectedIndexChanged" />
                </td>
                <td>
                    <telerik:RadNumericTextBox ID="txtQuantity" runat="server" />
                </td>
                <td>
                    <telerik:RadNumericTextBox ID="txtUnitPrice" runat="server" Enabled="false" />
                </td>
                <td>
                    <asp:Button ID="btnAddTask" runat="server" Text="<%$ ErpLanguage:Add %>" OnClick="btnAddTask_Click" />
                </td>
            </tr>
        </table>
    </telerik:RadPane>
    <telerik:RadPane ID="PaneGrid" runat="server" Scrolling="None">
        <telerik:RadGrid ID="gridTasks" runat="server" Width="100%" Height="100%" 
            OnNeedDataSource="gridTasks_NeedDataSource" AutoGenerateColumns="false" ShowFooter="true"
            OnUpdateCommand="gridTasks_UpdateCommand">
            <MasterTableView DataKeyNames="Id" ClientDataKeyNames="Id" EditMode="InPlace">
                <Columns>
                    <telerik:GridEditCommandColumn ButtonType="PushButton" 
                        EditText="<%$ ErpLanguage:Edit %>"
                        UniqueName="EditColumn" 
                        CancelText="<%$ ErpLanguage:Cancel %>">
                    </telerik:GridEditCommandColumn>
                    <telerik:GridBoundColumn UniqueName="StockCode" DataField="StockCode" 
                        HeaderText="<%$ ErpLanguage:Code %>" ReadOnly="true" />
                    <telerik:GridBoundColumn UniqueName="ProductName" DataField="ProductName" 
                        HeaderText="<%$ ErpLanguage:Name %>" ReadOnly="true" />
                    <telerik:GridBoundColumn UniqueName="QuantityOrdered" DataField="QuantityOrdered" 
                        HeaderText="<%$ ErpLanguage:Quantity %>" />
                    <telerik:GridBoundColumn UniqueName="UnitPrice" DataField="UnitPrice" 
                        HeaderText="<%$ ErpLanguage:Price %>" ReadOnly="true" />
                    <telerik:GridBoundColumn UniqueName="NetAmount" DataField="NetAmount" 
                        HeaderText="<%$ ErpLanguage:NetAmount %>" Aggregate="Sum" ReadOnly="true" />
                </Columns>
            </MasterTableView>
        </telerik:RadGrid>
    </telerik:RadPane>
</telerik:RadSplitter>