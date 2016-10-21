<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="ChangeActivityStatus.ascx.cs" Inherits="Connors.Erp.Web._common.controls.Activities.ChangeActivityStatus" %>



<script  type="text/javascript">
    function CloseWindow() {
        window.opener.PerformSearch();
        window.close();
    }
</script>
<table cellpadding="5" cellspacing="0" style="width: 250px">
    <tr>
        <td colspan="2">
            <asp:Literal runat="server" ID="litTitle" />
        </td>
    </tr>
    <tr>
        <td>
            <asp:Literal runat="server" ID="Literal1" Text="<%$ ErpLanguage:ChangeStatus %>" />:
        </td>
        <td>
            <asp:DropDownList runat="server" ID="ddStatuses" />
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <asp:Button runat="server" ID="btnSave" Text="<%$ ErpLanguage:Save %>" 
                OnClick="btnSave_Click" /><br />
            <asp:Literal runat="server" ID="litMessage" />
        </td>
    </tr>
</table>