<%@ Page Language="C#" MasterPageFile="~/App_Master/Site1.Master" AutoEventWireup="true"
    CodeBehind="List.aspx.cs" Inherits="Connors.Erp.Web.DynamicData.CustomPages.Locations.List" %>

<%@ Import Namespace="Connors.Framework.Model" %>


<asp:Content ContentPlaceHolderID="COMPONENTS" ID="Main" runat="server">
    <telerik:RadAjaxLoadingPanel ID="RadAjaxLoadingPanel1" runat="server" />
    <telerik:RadAjaxManager ID="RadAjaxManager1" runat="server" OnAjaxRequest="RadAjaxManager1_AjaxRequest">
        <AjaxSettings>
            <telerik:AjaxSetting AjaxControlID="RadAjaxManager1">
                <UpdatedControls>
                    <telerik:AjaxUpdatedControl ControlID="gridLocations" LoadingPanelID="RadAjaxLoadingPanel1" />
                </UpdatedControls>
            </telerik:AjaxSetting>
        </AjaxSettings>
    </telerik:RadAjaxManager>
    <telerik:RadScriptBlock ID="RadScriptBlock1" runat="server">
        <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<%=Session["Global.GoogleMapKey"]%>" type="text/javascript"></script>
        <script language="javascript" type="text/javascript">
            // Initializes a new instance of the StringBuilder class
            // and appends the given value if supplied
            function StringBuilder(value) {
                this.strings = new Array("");
                this.append(value);
            }

            // Appends the given value to the end of this instance.
            StringBuilder.prototype.append = function(value) {
                if (value) {
                    this.strings.push(value);
                }
            }

            // Clears the string buffer
            StringBuilder.prototype.clear = function() {
                this.strings.length = 1;
            }

            // Converts this instance to a String.
            StringBuilder.prototype.toString = function() {
                return this.strings.join("");
            }
            
            var ajaxManager;
            var cbxCustomers, cbxRegions, cbxCounties, cbxLocationTypes;
            var customerId, regionId, countyId, locationTypeId;
            var txtLocationSearch, ckbArchived;

            function OnClientFocus(sender, eventArgs) {
                if (sender.get_items().get_count() > 0) {
                    // pre-select the first item
                    sender.set_text(sender.get_items().getItem(0).get_text());
                    sender.get_items().getItem(0).highlight();
                }
                
                sender.showDropDown();
            }

            function pageLoad() {
                ajaxManager = $find("<%=RadAjaxManager1.ClientID %>");
                grid = $find("<%=gridLocations.ClientID %>");
                txtLocationSearch = $find("ctl00_COMPONENTS_toolbarLocations_i2_txtLocationSearch");
                cbxCustomers = $find("ctl00_COMPONENTS_toolbarLocations_i4_cbxCustomers");
                cbxRegions = $find("ctl00_COMPONENTS_toolbarLocations_i4_cbxRegions");
                cbxCounties = $find("ctl00_COMPONENTS_toolbarLocations_i4_cbxCounties");
                cbxLocationTypes = $find("ctl00_COMPONENTS_toolbarLocations_i4_cbxLocationTypes");
                ckbArchived = document.getElementById("ctl00_COMPONENTS_toolbarLocations_i5_ckbArchived");
            }

            function OnKeyPress(sender, eventArgs) {
                if (eventArgs.get_keyCode() == 13) {
                    eventArgs.get_domEvent().stopPropagation();
                    eventArgs.get_domEvent().preventDefault();
                    PerformSearch();
                    return;
                }
            }

            function PerformSearch(clear) {
                var sb = new StringBuilder();

                if (clear) {
                    sb.append("Clear|null");
                } else {
                    sb.append("Search|");

                    if (txtLocationSearch) {
                        sb.append(txtLocationSearch.get_value() + "^");
                    } else {
                        sb.append("null^")
                    }

                    if (customerId) {
                        sb.append(customerId + "^");
                    } else {
                        sb.append("null^");
                    }

                    if (regionId) {
                        sb.append(regionId + "^");
                    } else {
                        sb.append("null^")
                    }

                    if (countyId) {
                        sb.append(countyId + "^");
                    } else {
                        sb.append("null^")
                    }

                    if (locationTypeId) {
                        sb.append(locationTypeId + "^");
                    } else {
                        sb.append("null^")
                    }

                    if (ckbArchived.checked)
                        sb.append("true");
                    else
                        sb.append("false");
                }

                ajaxManager.ajaxRequest(sb.toString());
            }

            function ClearAllFields() {
                cbxCustomersItems = cbxCustomers.get_items();
                var customerItem = cbxCustomersItems.getItem(0);
                customerItem.select();

                cbxRegionsItems = cbxRegions.get_items();
                var regionItem = cbxRegionsItems.getItem(0);
                regionItem.select();

                cbxCountiesItems = cbxCounties.get_items();
                var countyItem = cbxCountiesItems.getItem(0);
                countyItem.select();

                cbxLocationTypesItems = cbxLocationTypes.get_items();
                var locationTypeItem = cbxLocationTypesItems.getItem(0);
                locationTypeItem.select();

                txtLocationSearch.clear();

                ckbArchived.checked = false;
            }

            function RebindGrid() {
                ClearAllFields();
                PerformSearch(true);
            }

            function toolbarLocations_ClientButtonClicked(sender, eventArgs) {
                var commandName = eventArgs.get_item().get_commandName();

                if (commandName == "doNew") {
                }
                else if (commandName == "doEdit") {
                }
                else if (commandName == "doSearch") {
                    PerformSearch();
                }
                else if (commandName == "doClear") {
                    RebindGrid();
                }
            }

            function PaneRelatedItems_ClientResized(sender, eventArgs) {
                ajaxManager.ajaxRequest("null|null");
            }

            function PaneRelatedItems_ClientCollapseExpanded(sender, eventArgs) {
                ajaxManager.ajaxRequest("null|null");
            }
            
            function cbxCustomers_ClientSelectedIndexChanging(sender, eventArgs) {
                var item = eventArgs.get_item();
                //Define Customer Id
                customerId = item.get_value();
            }

            function cbxRegions_ClientSelectedIndexChanged(sender, eventArgs) {
                var item = eventArgs.get_item();
                regionId = item.get_value();
            }

            function cbxCounties_ClientSelectedIndexChanged(sender, eventArgs) {
                var item = eventArgs.get_item();
                countyId = item.get_value();
            }

            function cbxLocationTypes_ClientSelectedIndexChanged(sender, eventArgs) {
                var item = eventArgs.get_item();
                locationTypeId = item.get_value();
            }
        </script>
    </telerik:RadScriptBlock>
    <telerik:RadSplitter ID="RadSplitter1" runat="server" Width="100%" Height="100%"
        Orientation="Horizontal" BorderStyle="None">
        <telerik:RadPane ID="PaneToolbar" runat="server" Scrolling="None" Height="32px" EnableViewState="false">
            <telerik:RadToolBar ID="toolbarLocations" runat="server" Width="100%" OnClientButtonClicked="toolbarLocations_ClientButtonClicked">
                <Items>
                    <telerik:RadToolBarButton CommandName="doNew" Text="<%$ ErpLanguage:Add %>"
                        AccessKey="N" ToolTip="Alt + N" />
                    <telerik:RadToolBarButton IsSeparator="true" />
                    <telerik:RadToolBarButton>
                        <ItemTemplate>
                            <telerik:RadTextBox runat="server" ID="txtLocationSearch" EmptyMessage="Search Location"
                                Width="200px" AutoPostBack="false" AccessKey="S" ClientEvents-OnKeyPress="OnKeyPress"
                                ToolTip="Alt + S" />
                        </ItemTemplate>
                    </telerik:RadToolBarButton>
                    <telerik:RadToolBarButton IsSeparator="true" />
                    <telerik:RadToolBarButton Value="Filters">
                        <ItemTemplate>
                            <telerik:RadComboBox ID="cbxCustomers" runat="server"
                                DropDownWidth="250px" AccessKey="C"
                                ToolTip="Alt + C" OnClientFocus="OnClientFocus" 
                                OnClientSelectedIndexChanging="cbxCustomers_ClientSelectedIndexChanging" />
                            &nbsp;&nbsp;
                            <telerik:RadComboBox ID="cbxRegions" runat="server" 
                                OnClientFocus="OnClientFocus" 
                                DropDownWidth="200px" 
                                AccessKey="R"
                                ToolTip="Alt + R"
                                OnClientSelectedIndexChanged="cbxRegions_ClientSelectedIndexChanged">
                            </telerik:RadComboBox>
                            &nbsp;&nbsp;
                            <telerik:RadComboBox ID="cbxCounties" runat="server" 
                                DropDownWidth="200px"
                                AccessKey="O"
                                ToolTip="Alt + O"
                                OnClientSelectedIndexChanged="cbxCounties_ClientSelectedIndexChanged"/>
                            <telerik:RadComboBox ID="cbxLocationTypes" runat="server"
                                AccessKey="L"
                                ToolTip="Alt + L" 
                                OnClientSelectedIndexChanged="cbxLocationTypes_ClientSelectedIndexChanged"/>
                        </ItemTemplate>
                    </telerik:RadToolBarButton>
                    <telerik:RadToolBarButton Value="Archived">
                        <ItemTemplate>
                            <asp:CheckBox ID="ckbArchived" runat="server" Checked="false" ToolTip="<%$ ErpLanguage:ShowAlsoArchivedActivities %>" />
                        </ItemTemplate>
                    </telerik:RadToolBarButton>
                    <telerik:RadToolBarButton Value="search" CommandName="doSearch" Text="<%$ ErpLanguage:Search %>"
                        PostBack="false" AccessKey="F" ToolTip="Alt + F" />
                    <telerik:RadToolBarButton Value="clear" CommandName="doClear" Text="<%$ ErpLanguage:Clear %>"
                        PostBack="false" AccessKey="X" ToolTip="Atl + X" />
                </Items>
            </telerik:RadToolBar>
        </telerik:RadPane>
        <telerik:RadPane ID="PaneGrid" runat="server" Scrolling="None">
            <telerik:RadGrid ID="gridLocations" runat="server"
                GridLines="None" AllowPaging="True" AllowSorting="True" Width="100%" 
                Height="100%" AutoGenerateColumns="False" DataSourceID="vwLocationsDS">
                <MasterTableView DataSourceID="vwLocationsDS" 
                    DataKeyNames="Id,CustomerId,CountryId,RegionId,CountyId,LocationTypeId,PageId,TileId">
                    <Columns>
                        <telerik:GridHyperLinkColumn UniqueName="ViewDetails" Text="<%$ ErpLanguage:Details %>"
                            DataNavigateUrlFields="Id" 
                            DataNavigateUrlFormatString="~/Locations/Details.aspx?Id={0}"
                            HeaderText="<%$ ErpLanguage:Details %>">
                        </telerik:GridHyperLinkColumn>
                        <telerik:GridHyperLinkColumn UniqueName="StreetMap" Text="Show Map"
                            DataNavigateUrlFields="OSGridX,OSGridY" 
                            DataNavigateUrlFormatString="http://www.streetmap.co.uk/oldmap.srf?x={0}&y={1}&z=0&sv={0},{1}&st=4&mapp=oldmap.srf&searchp=oldsearch.srf"
                            HeaderText="Steet Map"
                            Target="_blank">
                        </telerik:GridHyperLinkColumn>
                        <telerik:GridBoundColumn DataField="Name" HeaderText="Name" 
                            SortExpression="Name" UniqueName="Name">
                            <HeaderStyle Width="250px" />
                        </telerik:GridBoundColumn>
                        <telerik:GridCheckBoxColumn DataField="InClearance" DataType="System.Boolean" 
                            HeaderText="InClearance" SortExpression="InClearance" UniqueName="InClearance">
                        </telerik:GridCheckBoxColumn>
                        <telerik:GridBoundColumn DataField="OSGridX" DataType="System.Double" 
                            HeaderText="OSGridX" SortExpression="OSGridX" UniqueName="OSGridX">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="OSGridY" DataType="System.Double" 
                            HeaderText="OSGridY" SortExpression="OSGridY" UniqueName="OSGridY">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="Latitude" DataType="System.Double" 
                            HeaderText="Latitude" SortExpression="Latitude" UniqueName="Latitude">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="Longitude" DataType="System.Double" 
                            HeaderText="Longitude" SortExpression="Longitude" UniqueName="Longitude">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="Postcode" HeaderText="Postcode" 
                            SortExpression="Postcode" UniqueName="Postcode">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="CustomerName" HeaderText="CustomerName" 
                            SortExpression="CustomerName" UniqueName="CustomerName">
                            <HeaderStyle Width="150px" />
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="CountryCode" HeaderText="CountryCode" 
                            SortExpression="CountryCode" UniqueName="CountryCode">
                        </telerik:GridBoundColumn>
                        <%--<telerik:GridBoundColumn DataField="RegionShortName" 
                            HeaderText="RegionShortName" SortExpression="RegionShortName" 
                            UniqueName="RegionShortName">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="CountyName" HeaderText="CountyName" 
                            SortExpression="CountyName" UniqueName="CountyName">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="LocationTypeName" 
                            HeaderText="LocationTypeName" SortExpression="LocationTypeName" 
                            UniqueName="LocationTypeName">
                        </telerik:GridBoundColumn>--%>
                    </Columns>
                </MasterTableView>
                <ClientSettings AllowDragToGroup="true" EnableRowHoverStyle="true" EnablePostBackOnRowClick="false">
                    <Selecting AllowRowSelect="true" />
                    <Scrolling AllowScroll="true" UseStaticHeaders="true" />
                </ClientSettings>
            </telerik:RadGrid>
            <asp:LinqDataSource ID="vwLocationsDS" runat="server" ContextTypeName="Connors.Framework.Model.MainDataContext"
                OrderBy="Name asc" TableName="vwLocations" OnSelecting="vwLocationsDS_Selecting">
            </asp:LinqDataSource>
        </telerik:RadPane>
        <%--<telerik:RadSplitBar ID="RadSplitBar1" runat="server" CollapseMode="Backward" />
        <telerik:RadPane ID="PaneRelatedItems" runat="server" Scrolling="None" Height="250px" 
            OnClientCollapsed="PaneRelatedItems_ClientCollapseExpanded" 
            OnClientExpanded="PaneRelatedItems_ClientCollapseExpanded"
            OnClientResized="PaneRelatedItems_ClientResized">
        </telerik:RadPane>--%>
    </telerik:RadSplitter>
</asp:Content>