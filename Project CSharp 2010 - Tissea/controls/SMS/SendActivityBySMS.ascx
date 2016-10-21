<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="SendActivityBySMS.ascx.cs" Inherits="Connors.Erp.Web._common.controls.SendActivityBySMS" %>
<style type="text/css">
.table
{
	width: 300px;
}
</style>
<table cellpadding="2" cellspacing="0" class="table">
    <tr>
        <td>
            Recipient:
        </td>
        <td>
            <asp:TextBox ID="txtRecipient" runat="server" />
        </td>
    </tr>
    <tr>
        <td>
            SMS:
        </td>
        <td>
            <asp:TextBox ID="txtMessage" runat="server" />
        </td>
    </tr>
</table>
<asp:Button ID="btnSend" runat="server" Text="Send" onclick="btnSend_Click" />
<asp:Label ID="lblResult" runat="server" ForeColor="Red" />