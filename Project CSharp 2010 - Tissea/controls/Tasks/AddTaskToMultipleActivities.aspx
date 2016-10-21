<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="AddTaskToMultipleActivities.aspx.cs"
    Inherits="Connors.Erp.Web._common.controls.Tasks.AddTaskToMultipleActivities" %>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head runat="server">
    <title></title>
    <script  type="text/javascript">
    function CloseWindow() {
        window.opener.PerformSearch();
        window.close();
    }
</script>
</head>
<body style="margin:0; padding:0; height: 100%; overflow:hidden;">
    <form id="form1" runat="server">
    <telerik:RadScriptManager ID="RadScriptManager1" runat="server" />
    <table width="450px">
        <tr>
            <td style="width: 100px">
                <asp:Literal runat="server" ID="litPriceListLabel" Text="<%$ ErpLanguage:PriceList %>" />
            </td>
            <td style="width: 10px">
                <asp:RequiredFieldValidator ID="RequiredFieldValidator1" runat="server" ErrorMessage="RequiredFieldValidator"
                    Text="*" ControlToValidate="cbxPriceLists" ValidationGroup="Insert" />
            </td>
            <td>
                <telerik:RadComboBox ID="cbxPriceLists" runat="server" DropDownWidth="200px" EnableLoadOnDemand="true"
                    OnItemsRequested="cbxPriceLists_ItemsRequested" AutoPostBack="true" EmptyMessage="<%$ ErpLanguage:SelectAPriceList %>"
                    OnSelectedIndexChanged="cbxPriceLists_SelectedIndexChanged" />
            </td>
        </tr>
        <tr>
            <td>
                <asp:Literal runat="server" ID="Literal1" Text="<%$ ErpLanguage:Product %>" />
            </td>
            <td>
                <asp:RequiredFieldValidator ID="RequiredFieldValidator2" runat="server" ErrorMessage="RequiredFieldValidator"
                    Text="*" ControlToValidate="cbxProducts" ValidationGroup="Insert" />
            </td>
            <td>
                <telerik:RadComboBox ID="cbxProducts" runat="server" Width="300px" Height="100px"
                    EmptyMessage="<%$ ErpLanguage:SelectAProduct %>" EnableLoadOnDemand="true"
                    ShowMoreResultsBox="true" EnableVirtualScrolling="true" OnItemsRequested="cbxProducts_ItemsRequested"
                    AutoPostBack="true" OnSelectedIndexChanged="cbxProducts_SelectedIndexChanged" />
            </td>
        </tr>
        <tr>
            <td>
                <asp:Literal runat="server" ID="Literal3" Text="<%$ ErpLanguage:Quantity %>" />
            </td>
            <td>
                <asp:RequiredFieldValidator ID="RequiredFieldValidator3" runat="server" ErrorMessage="RequiredFieldValidator"
                    Text="*" ControlToValidate="txtQuantity" ValidationGroup="Insert"/>
            </td>
            <td>
                <telerik:RadNumericTextBox ID="txtQuantity" runat="server" />
            </td>
        </tr>
        <tr>
            <td>
                <asp:Literal runat="server" ID="Literal4" Text="<%$ ErpLanguage:Price %>" />
            </td>
            <td></td>
            <td>
                <telerik:RadNumericTextBox ID="txtUnitPrice" runat="server" Enabled="false" ValidationGroup="Insert" />
            </td>
        </tr>
        <tr>
            <td align="right" colspan="3">
                <asp:Button ID="btnInsert" Text="Insert" runat="server" 
                    ValidationGroup="Insert" onclick="btnInsert_Click"/>
            </td>
        </tr>
    </table>
    </form>
</body>
</html>
