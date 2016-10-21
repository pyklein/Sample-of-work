<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="ViewMedia.ascx.cs" Inherits="Connors.Erp.Web.ViewMedia" %>
<table runat="server" style="width: 100%" id="ProductWrapper" border="0" cellpadding="2"
    cellspacing="0">
    <tr>
        <td style="text-align: center;">
            <asp:FormView ID="FormViewMediaDetails" runat="server" DataKeyNames="Id">
                <ItemTemplate>
                    <table cellpadding="5" cellspacing="0" width="100%" style="text-align: left;">
                        <tr>
                            <td>
                                Name:
                            </td>
                            <td>
                                <asp:Label ID="NameLabel" runat="server" Text='<%# Bind("Name") %>' />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Created Date & Time:
                            </td>
                            <td>
                                <asp:Label ID="CreatedDateTimeLabel" runat="server" Text='<%# Bind("CreatedDateTime") %>' />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Modified Date & Time:
                            </td>
                            <td>
                                <asp:Label ID="ModifiedDateTimeLabel" runat="server" Text='<%# Bind("ModifiedDateTime") %>' />
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Image:
                                <br />
                                <telerik:RadBinaryImage runat="server" ID="RadBinaryImage1" DataValue='<%#Eval("Data") %>'
                                    AutoAdjustImageControlSize="false" Width="350px" ToolTip='<%#Eval("Name", "Image of {0}") %>'
                                    AlternateText='<%#Eval("Name", "Image of {0}") %>' />
                            </td>
                        </tr>
                    </table>
                </ItemTemplate>
            </asp:FormView>
        </td>
    </tr>
</table>
