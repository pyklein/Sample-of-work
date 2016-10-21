<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="LocationFinderFoundLocations.ascx.cs"
    Inherits="Connors.Erp.Web._common.controls.LocationFinderFoundLocations" %>



<link href="../../../Resources/css/LocationFinder.css" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript">
    function btnClearSelection_ClientClick() {
        var grid = $find("<%= gridLocationsFound.ClientID %>");
        grid.get_masterTableView().clearSelectedItems();
    }

    function gridLocationsFound_RowSelecting(sender, args) {
        var text = "";
        text += "Row with index: " + args.get_itemIndexHierarchical() + " was selected";
        document.getElementById("OutPut").innerHTML = text;
    }
</script>
<table cellpadding="0" cellspacing="0" class="fixedTable">
    <tr>
        <td colspan="3">
            <asp:Literal runat="server" ID="litExisitingLocations" Text="<%$ ErpLanguage:ListOfExistingLocationwithSimilarCoordinates %>" />
        </td>
    </tr>
    <tr valign="top">
        <td colspan="3">
            <telerik:RadGrid ID="gridLocationsFound" runat="server" Width="100%" Height="200px"
                AutoGenerateColumns="false" 
                OnNeedDataSource="gridLocationsFound_NeedDataSource">
                <MasterTableView DataKeyNames="Id">
                    <Columns>
                        <telerik:GridClientSelectColumn UniqueName="ClientSelectColumn" />
                        <telerik:GridBoundColumn DataField="Name" HeaderText="Name" SortExpression="Name"
                            UniqueName="Name">
                            <HeaderStyle Width="200px" />
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="Latitude" DataType="System.Double" HeaderText="Latitude"
                            SortExpression="Latitude" UniqueName="Latitude">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="Longitude" DataType="System.Double" HeaderText="Longitude"
                            SortExpression="Longitude" UniqueName="Longitude">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="Line1" HeaderText="Line 1" SortExpression="Line1"
                            UniqueName="Line1">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="Postcode" HeaderText="Postcode" SortExpression="Postcode"
                            UniqueName="Postcode">
                        </telerik:GridBoundColumn>
                    </Columns>
                </MasterTableView>
                <ClientSettings EnableRowHoverStyle="true" EnablePostBackOnRowClick="true">
                    <Selecting AllowRowSelect="true" />
                    <ClientEvents OnRowSelecting="gridLocationsFound_RowSelecting" />
                </ClientSettings>
            </telerik:RadGrid>
        </td>
    </tr>
    <tr>
        <td>
            <asp:Button runat="server" ID="btnClearSelection" Text="<%$ ErpLanguage:ClearSelection %>"
                OnClientClick="btnClearSelection_ClientClick(); return false;" />
        </td>
        <td colspan="2">
            <div class="module" style="height: 20px; width: 350px;">
                <span style="font-weight: bold;">Last event: </span><span id="OutPut" style="font-weight: bold;
                    color: navy;"></span>
            </div>
        </td>
    </tr>
</table>
