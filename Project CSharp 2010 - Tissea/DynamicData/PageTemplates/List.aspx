<%@ Page Language="C#" MasterPageFile="~/App_Master/Site1.Master" CodeBehind="List.aspx.cs"
    Inherits="Connors.Erp.Web.List" %>



<asp:Content ID="Content1" ContentPlaceHolderID="COMPONENTS" runat="Server">
    <asp:DynamicDataManager ID="DynamicDataManager1" runat="server" AutoLoadForeignKeys="true" />
    <asp:ValidationSummary ID="ValidationSummary1" runat="server" EnableClientScript="true"
        HeaderText="List of validation errors" />
    <asp:PlaceHolder ID="placeHolderValidator" runat="server" />
    <telerik:RadAjaxManager ID="RadAjaxManager1" runat="server" OnAjaxRequest="RadAjaxManager1_AjaxRequest" />
    <telerik:RadScriptBlock ID="RadScriptBlock1" runat="server">

        <script type="text/javascript">
            var grid;
            var ajaxManager;
            
            function pageLoad() {
                grid = $find("ctl00_COMPONENTS_DDRadGridList")
                grid.repaint();
                ajaxManager = $find("<%= RadAjaxManager1.ClientID %>");
            }
                       
            function ClientResized(sender, eventArgs) {
                ajaxManager.ajaxRequest('ChangePageSize');
            }

            function ClientCollapseExpanded(sender, eventArgs) {
                ajaxManager.ajaxRequest('FilterPanelCollapsedExpanded');
            }
        </script>

    </telerik:RadScriptBlock>
    <telerik:RadSplitter ID="RadSplitterList" runat="server" Orientation="Horizontal"
        FullScreenMode="true" PanesBorderSize="0" ResizeWithBrowserWindow="true" SplitBarsSize="0"
        VisibleDuringInit="false">
        <telerik:RadPane ID="RadPaneToolbar" runat="server" Scrolling="None" Width="100%" Height="25px">
            <telerik:RadToolBar ID="toolbarList" runat="server" Height="25px">
                <Items>
                    <telerik:RadToolBarButton>
                        <ItemTemplate>
                            <div style="color: White;">
                                <%= table.DisplayName%>
                            </div>
                        </ItemTemplate>
                    </telerik:RadToolBarButton>
                    <telerik:RadToolBarButton CommandName="Insert">
                        <ItemTemplate>
                            <asp:DynamicHyperLink ID="InsertHyperLink" runat="server" Action="Insert" Text="<%$ ErpLanguage:Add %>" />
                        </ItemTemplate>
                    </telerik:RadToolBarButton>
                </Items>
            </telerik:RadToolBar>
        </telerik:RadPane>
        <telerik:RadPane ID="RadPaneFilters" runat="server" Scrolling="Y" Height="100px" Collapsed="true"
            OnClientCollapsed="ClientCollapseExpanded" OnClientExpanded="ClientCollapseExpanded">
            <asp:AdvancedFilterRepeater ID="AdvancedFilterRepeater" runat="server">
                <HeaderTemplate>
                    <table>
                </HeaderTemplate>
                <ItemTemplate>
                    <tr>
                        <td valign="top">
                            <%# Eval("DisplayName") %>:
                        </td>
                        <td>
                            <asp:DelegatingFilter runat="server" ID="DynamicFilter"/>
                        </td>
                    </tr>
                </ItemTemplate>
                <FooterTemplate>
                    </table>
                </FooterTemplate>
            </asp:AdvancedFilterRepeater>
        </telerik:RadPane>
        <telerik:RadSplitBar ID="RadSplitBarList" runat="server" CollapseMode="Forward" EnableResize="True" />
        <telerik:RadPane ID="RadPaneList" runat="server" Scrolling="None" OnClientResized="ClientResized" Height="100%" Width="100%">
            <!-- This Placeholder will hold the Dynamic Table -->
            <asp:PlaceHolder ID="placeHolderList" runat="server" />
        </telerik:RadPane>
    </telerik:RadSplitter>
    <asp:LinqDataSource ID="GridDataSource" runat="server" EnableDelete="true">
        <WhereParameters>
            <asp:DynamicControlParameter ControlId="AdvancedFilterRepeater" />
        </WhereParameters>
    </asp:LinqDataSource>
</asp:Content>