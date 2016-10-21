<%@ Page Language="C#" MasterPageFile="~/App_Master/Site1.Master" CodeBehind="Insert.aspx.cs" Inherits="Connors.Erp.Web.Insert" %>


<asp:Content ID="Content1" ContentPlaceHolderID="COMPONENTS" Runat="Server">
    <asp:DynamicDataManager ID="DynamicDataManager1" runat="server" AutoLoadForeignKeys="true" />
    <telerik:RadSplitter ID="RadSplitterInsertView" runat="server" Orientation="Horizontal"
        FullScreenMode="true" PanesBorderSize="0" ResizeWithBrowserWindow="true" SplitBarsSize="0"
        VisibleDuringInit="false">
        <telerik:RadPane ID="RadPaneInsertView" runat="server" Scrolling="Y">
            <asp:ValidationSummary ID="ValidationSummary1" runat="server" EnableClientScript="true"
                HeaderText="List of validation errors" />
            <asp:DynamicValidator runat="server" ID="DetailsViewValidator" ControlToValidate="DetailsView1" Display="None" />
            
            Add new entry to table <%= table.DisplayName %>
            
            <asp:DetailsView ID="DetailsView1" runat="server" DataSourceID="DetailsDataSource" DefaultMode="Insert"
                AutoGenerateInsertButton="True" OnItemCommand="DetailsView1_ItemCommand" OnItemInserted="DetailsView1_ItemInserted"
                CssClass="detailstable" FieldHeaderStyle-CssClass="bold">
            </asp:DetailsView>

            <asp:LinqDataSource ID="DetailsDataSource" runat="server" EnableInsert="true">
            </asp:LinqDataSource>
        </telerik:RadPane>    
    </telerik:RadSplitter>
</asp:Content>
