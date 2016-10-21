<%@ Page Language="C#" MasterPageFile="~/App_Master/Site1.Master"
    AutoEventWireup="true" CodeBehind="List.aspx.cs" Inherits="Connors.Erp.Web.DynamicData.CustomPages.Audits.List" %>

<%@ Import Namespace="Connors.Framework.Model" %>

<asp:Content ContentPlaceHolderID="COMPONENTS" ID="Main" runat="server">
    <style type="text/css">
        .NestedViewTable
        {
            width: 100%;
        }
        .NestedViewTable tr td span
        {
            text-decoration: underline;
            font-weight: bold;
        }
    </style>
    <telerik:RadAjaxLoadingPanel ID="RadAjaxLoadingPanel1" runat="server" />
    <telerik:RadAjaxManager ID="RadAjaxManager1" runat="server" OnAjaxRequest="RadAjaxManager1_AjaxRequest">
        <AjaxSettings>
            <telerik:AjaxSetting AjaxControlID="RadAjaxManager1">
                <UpdatedControls>
                    <telerik:AjaxUpdatedControl ControlID="gridAudits" />
                    <telerik:AjaxUpdatedControl ControlID="gridMedias" LoadingPanelID="RadAjaxLoadingPanel1" />
                    <telerik:AjaxUpdatedControl ControlID="gridNotes" LoadingPanelID="RadAjaxLoadingPanel1" />
                </UpdatedControls>
            </telerik:AjaxSetting>
        </AjaxSettings>
    </telerik:RadAjaxManager>
    <telerik:RadScriptBlock ID="RadScriptBlock1" runat="server">
        <script type="text/javascript">
            var ajaxManager, grid;
            var rowIndex;

            function pageLoad() {
                ajaxManager = $find("<%=RadAjaxManager1.ClientID %>");
                grid = $find("<%=gridAudits.ClientID %>");
            }

            function RebindRelatedGrids(eventArgs) {
                if (grid.get_masterTableView().get_selectedItems().length = 1) {

                    sb = new StringBuilder();

                    sb.append("RebindRelatedGrids|");
                    sb.append(eventArgs.getDataKeyValue("AuditGuid") + "^");
                    sb.append(eventArgs.getDataKeyValue("ActivityGuid") + "^");
                    sb.append(eventArgs.getDataKeyValue("LocationId"));

                    ajaxManager.ajaxRequest(sb.toString());
                }
            }

            function RebindEmptyRelatedGrids() {
                ajaxManager.ajaxRequest("RebindRelatedGrids|^^");
            }

            function gridAudits_RowClick(sender, eventArgs) {
                rowIndex = eventArgs.get_itemIndexHierarchical();
                RebindRelatedGrids(eventArgs);
            }
        </script>
    </telerik:RadScriptBlock>
    <telerik:RadWindowManager ID="RadWindowManager1" runat="server" />
    <telerik:RadSplitter ID="RadSplitter1" runat="server" Width="100%" Height="100%"
        Orientation="Horizontal" BorderStyle="None">
        <%--<telerik:RadPane ID="PaneToolbar" runat="server" Scrolling="None" Height="32px" EnableViewState="false">
            <telerik:RadToolBar ID="toolbarAudits" runat="server" Width="100%">
            </telerik:RadToolBar>
        </telerik:RadPane>--%>
        <telerik:RadPane ID="PaneGrid" runat="server" Scrolling="None">
            <telerik:RadGrid ID="gridAudits" runat="server" DataSourceID="vwAuditActivitiesDS"
                AutoGenerateColumns="False"  GridLines="None" ShowGroupPanel="true" AllowPaging="true"
                AllowSorting="true" Width="100%" Height="100%" ShowFooter="true" ShowStatusBar="true"
                AllowMultiRowSelection="false"
                OnItemDataBound="gridAudits_ItemDataBound">
                <MasterTableView DataSourceID="vwAuditActivitiesDS" GroupLoadMode="Client" ShowGroupFooter="true"
                    DataKeyNames="AuditGuid,AuditId,ActivityGuid,ActivityId,LocationId"
                    ClientDataKeyNames="AuditGuid,AuditId,ActivityGuid,ActivityId,LocationId">
                    <Columns>
                        <telerik:GridTemplateColumn HeaderText="" UniqueName="AuditedImage" GroupByExpression="Audited Audited Group By Audited">
                            <ItemStyle HorizontalAlign="Center" />
                            <ItemTemplate>
                                <asp:Image ID="imgPinAudited" runat="server" />
                            </ItemTemplate>
                            <HeaderStyle Width="10px" />
                        </telerik:GridTemplateColumn>
                        <telerik:GridTemplateColumn HeaderText="" UniqueName="IsPrivateImage" GroupByExpression="IsPrivate IsPrivate Group By IsPrivate">
                            <ItemStyle HorizontalAlign="Center" />
                            <ItemTemplate>
                                <asp:Image ID="imgPinIsPrivate" runat="server" />
                            </ItemTemplate>
                            <HeaderStyle Width="10px" />
                        </telerik:GridTemplateColumn>
                        <telerik:GridTemplateColumn HeaderText="" UniqueName="UploadedOnMobileDeviceImage" GroupByExpression="UploadedOnMobileDevice UploadedOnMobileDevice Group By UploadedOnMobileDevice">
                            <ItemStyle HorizontalAlign="Center" />
                            <ItemTemplate>
                                <asp:Image ID="imgPinUploadedOnMobileDevice" runat="server" />
                            </ItemTemplate>
                            <HeaderStyle Width="10px" />
                        </telerik:GridTemplateColumn>
                        <telerik:GridTemplateColumn HeaderText="" UniqueName="PassedImage" GroupByExpression="Passed Passed Group By Passed">
                            <ItemStyle HorizontalAlign="Center" />
                            <ItemTemplate>
                                <asp:Image ID="imgPinPassed" runat="server" />
                            </ItemTemplate>
                            <HeaderStyle Width="10px" />
                        </telerik:GridTemplateColumn>
                        <telerik:GridBoundColumn DataField="AuditId" DataType="System.Int32" 
                            HeaderText="AuditId" SortExpression="AuditId" UniqueName="AuditId">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="ActivityId" DataType="System.Int32" 
                            HeaderText="ActivityId" SortExpression="ActivityId" UniqueName="ActivityId">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="AuditType" DataType="System.Int32" 
                            HeaderText="AuditType" SortExpression="AuditType" UniqueName="AuditType">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="AuditPlace" DataType="System.Int32" 
                            HeaderText="AuditPlace" SortExpression="AuditPlace" UniqueName="AuditPlace">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="DueDateTime" DataType="System.DateTime" 
                            HeaderText="DueDateTime" SortExpression="DueDateTime" UniqueName="DueDateTime">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="CompletedDateTime" 
                            DataType="System.DateTime" HeaderText="CompletedDateTime" 
                            SortExpression="CompletedDateTime" UniqueName="CompletedDateTime">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="AuditedBy" HeaderText="AuditedBy" 
                            SortExpression="AuditedBy" UniqueName="AuditedBy">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="AuditedDateTime" DataType="System.DateTime" 
                            HeaderText="AuditedDateTime" SortExpression="AuditedDateTime" 
                            UniqueName="AuditedDateTime">
                        </telerik:GridBoundColumn>
                    </Columns>
                    <NestedViewTemplate>
                        <table class="NestedViewTable">
                            <tr>
                                <td>
                                    <span>
                                    <asp:Literal ID="Literal1" runat="server" Text="<%$ ErpLanguage:Location %>" />
                                        : </span>
                                </td>
                                <td>
                                    <%#Eval("LocationName")%>
                                </td>
                                <td>
                                    <span>
                                    <asp:Literal ID="Literal2" runat="server" Text="<%$ ErpLanguage:Line1 %>" />
                                        : </span>
                                </td>
                                <td>
                                    <%#Eval("Line1")%>
                                </td>
                                <td>
                                    <span>
                                    <asp:Literal ID="Literal3" runat="server" Text="<%$ ErpLanguage:Line2 %>" />
                                        : </span>
                                </td>
                                <td>
                                    <%#Eval("Line2")%>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>
                                    <asp:Literal ID="Literal6" runat="server" Text="<%$ ErpLanguage:Line3 %>" />
                                        : </span>
                                </td>
                                <td>
                                    <%#Eval("Line3")%>
                                </td>
                                <td>
                                    <span>
                                    <asp:Literal ID="Literal7" runat="server" Text="<%$ ErpLanguage:Line4 %>" />
                                        : </span>
                                </td>
                                <td>
                                    <%#Eval("Line4")%>
                                </td>
                                <td>
                                    <span>
                                    <asp:Literal ID="Literal8" runat="server" Text="<%$ ErpLanguage:Postcode %>" />
                                        : </span>
                                </td>
                                <td>
                                    <%#Eval("Postcode")%>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <span>
                                    <asp:Literal ID="Literal5" runat="server" Text="<%$ ErpLanguage:ActionsRequired %>" />
                                        : </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" valign="top">
                                    <%#Eval("ActionsRequired")%>
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="6">
                                    <span>
                                    <asp:Literal ID="Literal4" runat="server" Text="<%$ ErpLanguage:Description %>" />
                                        : </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" valign="top">
                                    <%#Eval("Description")%>
                                </td>
                            </tr>
                        </table>
                    </NestedViewTemplate>
                    <PagerStyle AlwaysVisible="true" Mode="NextPrevNumericAndAdvanced" />
                </MasterTableView>
                <ClientSettings AllowDragToGroup="true" EnableRowHoverStyle="true">
                    <Selecting AllowRowSelect="true" EnableDragToSelectRows="true" />
                    <Scrolling AllowScroll="true" UseStaticHeaders="true" />
                    <ClientEvents 
                        OnRowClick="gridAudits_RowClick"
                        />
                </ClientSettings>
            </telerik:RadGrid>
            <asp:LinqDataSource ID="vwAuditActivitiesDS" runat="server" ContextTypeName="Connors.Framework.Model.MainDataContext"
                OrderBy="AuditId desc" TableName="vwAuditActivities" OnSelecting="vwAuditActivitiesDS_Selecting">
            </asp:LinqDataSource>
            <telerik:RadContextMenu ID="AuditsGridContextMenu" runat="server">
                <Items>
                    <telerik:RadMenuItem Value="Edit" Text="<%$ ErpLanguage:Edit %>" />
                    <telerik:RadMenuItem Value="Refresh" Text="<%$ ErpLanguage:Refresh %>" />
                    <telerik:RadMenuItem Value="SelectAll" Text="<%$ ErpLanguage:SelectAll %>" />
                    <telerik:RadMenuItem IsSeparator="true" />
                    <telerik:RadMenuItem Value="Reports" Text="<%$ ErpLanguage:Reports %>" />
                </Items>
            </telerik:RadContextMenu>
        </telerik:RadPane>
        <telerik:RadSplitBar runat="server" ID="RadSplitBar1" CollapseMode="Backward" />
        <telerik:RadPane ID="PaneRelatedItems" runat="server" Scrolling="None" Height="250px">
            <telerik:RadTabStrip runat="server" ID="TabStrip1" MultiPageID="RadMultiPageAudit"
                SelectedIndex="0">
                <Tabs>
                    <telerik:RadTab runat="server" Text="<%$ ErpLanguage:Medias %>" />
                    <telerik:RadTab runat="server" Text="<%$ ErpLanguage:Notes %>" />
                    <telerik:RadTab runat="server" Text="<%$ ErpLanguage:ToDoTasks %>" Enabled="false" />
                </Tabs>
            </telerik:RadTabStrip>
            <telerik:RadMultiPage ID="RadMultiPageAudit" runat="server" SelectedIndex="0"
                RenderSelectedPageOnly="false">
                <telerik:RadPageView ID="pageMedias" runat="server">    
                    <telerik:RadGrid ID="gridMedias" runat="server" GridLines="None" OnNeedDataSource="gridMedias_NeedDataSource"
                        OnItemCommand="gridMedias_ItemCommand" OnItemDataBound="gridMedias_ItemDataBound">
                        <MasterTableView AutoGenerateColumns="False" DataKeyNames="Id" ClientDataKeyNames="Id">
                            <Columns>
                                <telerik:GridTemplateColumn HeaderText="Name" SortExpression="Name">
                                    <ItemTemplate>
                                        <asp:HyperLink ID="targetControl" runat="server" NavigateUrl="" Text='<%#Eval("Name")%>'></asp:HyperLink>
                                    </ItemTemplate>
                                </telerik:GridTemplateColumn>
                                <telerik:GridBoundColumn DataField="CreatedDateTime" DataType="System.DateTime" HeaderText="CreatedDateTime"
                                    SortExpression="CreatedDateTime" UniqueName="CreatedDateTime">
                                </telerik:GridBoundColumn>
                                <telerik:GridBoundColumn DataField="ModifiedDateTime" DataType="System.DateTime"
                                    HeaderText="ModifiedDateTime" SortExpression="ModifiedDateTime" UniqueName="ModifiedDateTime">
                                </telerik:GridBoundColumn>
                                <telerik:GridBinaryImageColumn DataField="Data" HeaderText="Image" UniqueName="Data"
                                    ImageAlign="NotSet" ImageHeight="80px" ImageWidth="80px" ResizeMode="Fit" DataAlternateTextField="Name"
                                    DataAlternateTextFormatString="Image of {0}">
                                </telerik:GridBinaryImageColumn>
                            </Columns>
                        </MasterTableView>
                    </telerik:RadGrid>
                </telerik:RadPageView>
                <telerik:RadPageView ID="pageNotes" runat="server">
                    <telerik:RadGrid ID="gridNotes" runat="server" GridLines="None" OnNeedDataSource="gridNotes_NeedDataSource">
                        <MasterTableView AutoGenerateColumns="False" DataKeyNames="Id">
                            <Columns>
                                <telerik:GridBoundColumn UniqueName="Note" HeaderText="<%$ ErpLanguage:Notes %>" DataField="Note"
                                    ReadOnly="true" DataType="System.String" />
                                <telerik:GridBoundColumn UniqueName="IsPrivate" HeaderText="Is Private" DataField="IsPrivate"
                                    ReadOnly="true" DataType="System.Boolean" />
                            </Columns>
                        </MasterTableView>
                    </telerik:RadGrid>
                </telerik:RadPageView>
                <telerik:RadPageView ID="pageToDoTasks" runat="server">
                </telerik:RadPageView>
            </telerik:RadMultiPage>
        </telerik:RadPane>
    </telerik:RadSplitter>
    <telerik:RadToolTipManager ID="RadToolTipManager1" OffsetY="-1" HideEvent="ManualClose"
        Width="380" Height="400" runat="server" OnAjaxUpdate="MediaAjaxUpdate" RelativeTo="Element"
        Position="MiddleRight">
    </telerik:RadToolTipManager>
</asp:Content>