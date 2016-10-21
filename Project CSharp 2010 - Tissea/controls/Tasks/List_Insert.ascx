<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="List_Insert.ascx.cs" Inherits="Connors.Erp.Web._common.controls.Tasks.List_Insert" %>
<%@ Register Src="~/DynamicData/Content/GridViewPager.ascx" TagName="GridViewPager"
    TagPrefix="asp" %>
<%@ Register Src="~/DynamicData/Content/FilterUserControl.ascx" TagName="DynamicFilter"
    TagPrefix="asp" %>
    


<asp:DynamicDataManager ID="DynamicDataManager1" runat="server" />
<asp:ScriptManagerProxy ID="ScriptManagerProxy1" runat="server" />

<asp:UpdatePanel ID="UpdatePanel1" runat="server">
    <ContentTemplate>
        <asp:DynamicValidator runat="server" ID="GridViewValidator" ControlToValidate="GridView1"
            Display="None" />
        <asp:LinqDataSource ID="GridDataSource" runat="server" ContextTypeName="Connors.Framework.Model.MainDataContext"
            TableName="Tasks" Where="ActivityGuid == @ActivityGuid">
            <WhereParameters>
                <asp:QueryStringParameter DbType="Guid" Name="ActivityGuid" QueryStringField="Id" />
            </WhereParameters>
        </asp:LinqDataSource>
        <asp:Label ID="lblHeader" runat="server" Text="Tasks\Products" />
        <div style="clear: both">
            <asp:GridView ID="GridView1" runat="server" DataSourceID="GridDataSource" AllowPaging="True"
                AllowSorting="True" AutoGenerateColumns="False" Width="100%">
                <Columns>
                    <asp:DynamicField DataField="Product" HeaderText="Product" />
                    <asp:DynamicField DataField="QuantityInitial" HeaderText="Initial Qty" />
                    <asp:DynamicField DataField="QuantityInternal" HeaderText="Internal Qty" />
                    <asp:DynamicField DataField="QuantityOrdered" HeaderText="Ordered Qty" />
                    <asp:DynamicField DataField="UnitPriceInitial" HeaderText="Initial Unit Price" />
                    <asp:DynamicField DataField="UnitPrice" HeaderText="Unit Price" />
                    <asp:DynamicField DataField="NetAmount" HeaderText="Net Amount" />
                    <asp:DynamicField DataField="TaxAmount" HeaderText="Tax Amount" />
                    <asp:DynamicField DataField="CreatedDateTime" HeaderText="Created On" />
                </Columns>
                <PagerTemplate>
                    <asp:GridViewPager ID="GridViewPager1" runat="server" />
                </PagerTemplate>
                <EmptyDataTemplate>
                    There are currently no items in this table.
                </EmptyDataTemplate>
            </asp:GridView>
        </div>
        <div>
            <asp:LinkButton runat="server" ID="AddTask" OnClick="AddTask_Click" CausesValidation="false" Text="<%$ ErpLanguage:Add %>" />
        </div>
        <asp:ValidationSummary ID="ValidationSummary1" runat="server" EnableClientScript="true"
            HeaderText="List of validation errors" />
    </ContentTemplate>
</asp:UpdatePanel>
