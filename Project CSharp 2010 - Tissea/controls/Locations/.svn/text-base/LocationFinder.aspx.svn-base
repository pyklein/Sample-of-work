<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="LocationFinder.aspx.cs"
    Inherits="Connors.Erp.Web._common.controls.LocationFinderOld" %>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head runat="server">
    <title></title>
    <style type="text/css">
        .table
        {
            width: 100%;
        }
        
        .fixedTable
        {
        	width: 600px;
        }
        
        .fixedTable .fixedColumn 
        {
        	width: 250px;
        	height: 400px;
        	vertical-align: top;
        }
        
        .fixedTable .fixedColumnRight
        {
        	width: 350px;
        	height: 400px;
        }
    </style>
</head>
<body style="height: 100%; margin: 0; padding: 0; overflow: hidden;">
    <form id="form1" runat="server">
    <telerik:RadScriptManager ID="RadScriptManager1" runat="server" />
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
                            <telerik:RadTextBox ID="txtPostcode" runat="server" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <asp:Literal ID="Literal9" runat="server" Text="<%$ ErpLanguage:Country %>" />
                        </td>
                        <td>
                            <telerik:RadComboBox ID="cbxCountries" runat="server" 
                                MarkFirstMatch="true" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <asp:Button ID="btnLocateByAddress" runat="server" Text="<%$ ErpLanguage:Locate %>"
                                OnClick="btnLocateByAddress_Click" />
                        </td>
                        <td>
                            <asp:TextBox ID="txtLatLng" runat="server" />
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
                            <telerik:RadTextBox ID="txtXOSGrid" runat="server" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <asp:Literal ID="Literal8" runat="server" Text="<%$ ErpLanguage:OSGridY %>" />
                        </td>
                        <td>
                            <telerik:RadTextBox ID="txtYOSGrid" runat="server" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <asp:Button ID="btnLocateByXYCoordinates" runat="server" Text="<%$ ErpLanguage:Locate %>"
                                OnClick="btnLocateByXYCoordinates_Click" />
                        </td>
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <asp:Label ID="lblNbFoundLocations" runat="server" Visible="false" />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <asp:Button ID="btnCreateLocation" runat="server" 
                                Text="<%$ ErpLanguage:CreateLocation %>" 
                                onclick="btnCreateLocation_Click" />
                                
                            <asp:Label ID="lblTileName" runat="server" />
                        </td>
                    </tr>
                    <%--<tr>
                        <td colspan="2">
                            <asp:Literal ID="Literal9" runat="server" Text="<%$ ErpLanguage:LocateByLatLng %>" />
                        </td>
                    </tr>
                    <tr>
                        <td><asp:Literal ID="Literal10" runat="server" Text="<%$ ErpLanguage:Latitude %>" /></td>
                        <td>
                            <telerik:RadTextBox ID="txtLatitude" runat="server" />
                        </td>
                    </tr>
                    <tr>
                        <td><asp:Literal ID="Literal11" runat="server" Text="<%$ ErpLanguage:Longitude %>" /></td>
                        <td>
                            <telerik:RadTextBox ID="txtLongitude" runat="server" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <asp:Button ID="btnLocateByLatLng" runat="server" Text="<%$ ErpLanguage:Locate %>" />
                        </td>
                        <td></td>
                    </tr>--%>
                </table>
            </td>
            <td class="fixedColumnRight">
                <asp:GMap ID="GMap1" runat="server" Width="100%" Height="100%" 
                    enableServerEvents="true"
                    OnClick="GMap1_Click" />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
