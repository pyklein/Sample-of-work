<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="PlanActivityAndTasks.ascx.cs"
    Inherits="Connors.Erp.Web._common.controls.Activities.PlanActivityAndTasks" %>



<script language="javascript" type="text/javascript">
    function CloseWindow() {
        window.opener.PerformSearch();
        window.close();
    }
</script>
<telerik:RadScriptManager ID="RadScriptManager1" runat="server" />
<div style="width: 300px; height: 250px">
<table style="width: 100%">
    <tr>
        <td colspan="2">
            <asp:Literal ID="litNumberSelectActivity" runat="server" />
        </td>
    </tr>
    <tr>
        <td style="width: 200px">
            <asp:Literal ID="Literal2" runat="server" Text="<%$ ErpLanguage:ExpectedStartDate %>"/>
        </td>
        <td>
            <telerik:RadDatePicker ID="txtStartDateTime" runat="server" />
        </td>
    </tr>
    <tr>
        <td>
            <asp:Literal ID="Literal3" runat="server" Text="<%$ ErpLanguage:ExpectedEndDate %>" />
        </td>
        <td>
            <telerik:RadDatePicker ID="txtEndDateTime" runat="server" />
        </td>
    </tr>
    <tr>
        <td>
            <asp:Button ID="btnSave" runat="server" Text="<%$ ErpLanguage:Save %>" OnClick="btnSave_Click" />
        </td>
        <td>
        </td>
    </tr>
</table>
</div>