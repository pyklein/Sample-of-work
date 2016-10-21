<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="Tasks.ascx.cs" Inherits="Connors.Erp.Web._common.controls.Tasks.Tasks" %>
<telerik:RadAjaxPanel ID="RadAjaxPanel1" runat="server" Height="100%" Width="100%">
    <telerik:RadGrid ID="gridTasks" AutoGenerateColumns="False" runat="server" Width="100%"
        Height="100%" GridLines="None" OnNeedDataSource="gridTasks_NeedDataSource" ShowFooter="true">
        <MasterTableView DataKeyNames="Id">
            <Columns>
                <telerik:GridBoundColumn UniqueName="StockCode" DataField="StockCode" SortExpression="StockCode"
                    HeaderText="StockCode" DataType="System.String" ReadOnly="True">
                </telerik:GridBoundColumn>
                <telerik:GridBoundColumn UniqueName="ProductName" DataField="ProductName" SortExpression="ProductName"
                    HeaderText="Name" DataType="System.String" ReadOnly="True">
                </telerik:GridBoundColumn>
                <telerik:GridBoundColumn UniqueName="QuantityOrdered" DataField="QuantityOrdered"
                    SortExpression="QuantityOrdered" HeaderText="Quantity" DataType="System.Int32"
                    ReadOnly="True">
                </telerik:GridBoundColumn>
                <telerik:GridBoundColumn UniqueName="NetAmount" DataField="NetAmount" SortExpression="NetAmount"
                    HeaderText="Net Amount" DataType="System.Int32" ReadOnly="True">
                </telerik:GridBoundColumn>
                <telerik:GridBoundColumn UniqueName="TaxAmount" DataField="TaxAmount" SortExpression="TaxAmount"
                    HeaderText="Tax Amount" DataType="System.Int32" ReadOnly="True">
                </telerik:GridBoundColumn>
            </Columns>
        </MasterTableView>
    </telerik:RadGrid>
</telerik:RadAjaxPanel>
