<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="LocationFinder.ascx.cs"
    Inherits="Connors.Erp.Web._common.controls.LocationFinder" %>



<link href="../../../Resources/css/LocationFinder.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
    function pageLoad() {
        var street = $find("<%= txtStreet.ClientID %>");
        street.focus();
    }
    
    function ValidateLocationType(sender, args) {
        if (args.Value == '<%= Session["LocationFinder-Resources-SelectALocationType"] %>')
            args.IsValid = false;
        else
            args.IsValid = true;
    }
</script>
<table cellpadding="0" cellspacing="0" class="fixedTable">
    <tr>
        <td class="fixedColumn">
            <table cellpadding="2" cellspacing="0" class="table">
                <tr>
                    <td colspan="2">
                        <asp:Literal ID="Literal5" runat="server" Text="<%$ ErpLanguage:LocateByAddress %>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <asp:Literal ID="Literal1" runat="server" Text="<%$ ErpLanguage:Street %>" />
                    </td>
                    <td>
                        <telerik:RadTextBox ID="txtStreet" runat="server" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <asp:Literal ID="Literal2" runat="server" Text="<%$ ErpLanguage:Town %>" />
                    </td>
                    <td>
                        <telerik:RadTextBox ID="txtTown" runat="server" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <asp:Literal ID="Literal3" runat="server" Text="<%$ ErpLanguage:County %>" />
                    </td>
                    <td>
                        <telerik:RadTextBox ID="txtCounty" runat="server" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <asp:Literal ID="Literal4" runat="server" Text="<%$ ErpLanguage:Postcode %>" />
                    </td>
                    <td>
                        <telerik:RadTextBox ID="txtPostcode" runat="server" /><asp:RequiredFieldValidator
                            ID="RequiredFieldValidator2" runat="server" ErrorMessage="<%$ ErpLanguage:ThisFieldIsRequired %>"
                            Text="*" ControlToValidate="txtPostcode" ValidationGroup="LocateByAddress" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <asp:Literal ID="Literal9" runat="server" Text="<%$ ErpLanguage:Country %>" />
                    </td>
                    <td>
                        <telerik:RadComboBox ID="cbxCountries" runat="server" MarkFirstMatch="true" />
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <asp:Button ID="btnLocateByAddress" runat="server" Text="<%$ ErpLanguage:Locate %>"
                            OnClick="btnLocateByAddress_Click" ValidationGroup="LocateByAddress" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <asp:Literal ID="Literal6" runat="server" Text="<%$ ErpLanguage:LocateByXYCoordinates %>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <asp:Literal ID="Literal7" runat="server" Text="<%$ ErpLanguage:OSGridX %>" />
                    </td>
                    <td>
                        <telerik:RadTextBox ID="txtXOSGrid" runat="server" /><asp:RequiredFieldValidator
                            ID="RequiredFieldValidator3" runat="server" ErrorMessage="<%$ ErpLanguage:ThisFieldIsRequired %>"
                            Text="*" ControlToValidate="txtXOSGrid" ValidationGroup="LocateByOSGrid" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <asp:Literal ID="Literal8" runat="server" Text="<%$ ErpLanguage:OSGridY %>" />
                    </td>
                    <td>
                        <telerik:RadTextBox ID="txtYOSGrid" runat="server" /><asp:RequiredFieldValidator
                            ID="RequiredFieldValidator4" runat="server" ErrorMessage="<%$ ErpLanguage:ThisFieldIsRequired %>"
                            Text="*" ControlToValidate="txtYOSGrid" ValidationGroup="LocateByOSGrid" />
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <asp:Button ID="btnLocateByXYCoordinates" runat="server" Text="<%$ ErpLanguage:Locate %>"
                            OnClick="btnLocateByXYCoordinates_Click" ValidationGroup="LocateByOSGrid" />
                    </td>
                </tr>
            </table>
        </td>
        <td class="fixedColumnRight">
            <asp:GMap ID="GMap1" runat="server" Width="100%" Height="300px" enableServerEvents="true"
                OnServerEvent="GMap1_ServerEvent" />
        </td>
    </tr>
    <tr>
        <td>
            <asp:Label ID="Literal10" runat="server" Text="<%$ ErpLanguage:LocationType %>" ForeColor="Red" />
        </td>
        <td>
            <telerik:RadComboBox ID="cbxLocationType" runat="server" MarkFirstMatch="true" EmptyMessage="<%$ ErpLanguage:SelectALocationType %>"
                Width="140px" /><asp:CustomValidator ID="CustomValidator1" runat="server" 
                Text="*" ErrorMessage="<%$ ErpLanguage:ThisFieldIsRequired %>" 
                ControlToValidate="cbxLocationType" 
                ClientValidationFunction="ValidateLocationType" />
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <asp:Label ID="lblNbFoundLocations" runat="server" Visible="false" />
        </td>
    </tr>
</table>
