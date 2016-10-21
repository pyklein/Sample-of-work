<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="InsertEdit.ascx.cs"
    Inherits="Connors.Erp.Web._common.controls.Tasks.InsertEdit" %>



<table width="450px">
    <tr>
        <td style="width: 150px">
            <asp:Literal runat="server" ID="litPriceListLabel" Text="<%$ ErpLanguage:PriceList %>" />
        </td>
        <td>
            <telerik:RadComboBox ID="cbxPriceLists" runat="server" DropDownWidth="200px" 
                EnableLoadOnDemand="true"
                OnItemsRequested="cbxPriceLists_ItemsRequested"
                AutoPostBack="true"
                EmptyMessage="<%$ ErpLanguage:SelectAPriceList %>"
                OnSelectedIndexChanged="cbxPriceLists_SelectedIndexChanged" />
            <asp:RequiredFieldValidator ID="RequiredFieldValidator1" runat="server" 
                ErrorMessage="RequiredFieldValidator" Text="*" ControlToValidate="cbxPriceLists" ValidationGroup="Insert" />
        </td>
    </tr>
    <tr>
        <td>
            <asp:Literal runat="server" ID="Literal1" Text="<%$ ErpLanguage:Product %>" />
        </td>
        <td>
            <telerik:RadComboBox ID="cbxProducts" runat="server" Width="300px" Height="100px"
                EmptyMessage="<%$ ErpLanguage:SelectAProduct %>" EnableLoadOnDemand="true" ShowMoreResultsBox="true"
                EnableVirtualScrolling="true" OnItemsRequested="cbxProducts_ItemsRequested" AutoPostBack="true"
                OnSelectedIndexChanged="cbxProducts_SelectedIndexChanged" />
            <asp:RequiredFieldValidator ID="RequiredFieldValidator2" runat="server" 
                ErrorMessage="RequiredFieldValidator" Text="*" ControlToValidate="cbxProducts" ValidationGroup="Insert" />
            <asp:Literal runat="server" ID="litProduct" Visible="false" />
        </td>
    </tr>
    <tr>
        <td>
            <asp:Literal runat="server" ID="Literal3" Text="<%$ ErpLanguage:Quantity %>" />
        </td>
        <td>
            <telerik:RadNumericTextBox ID="txtQuantity" runat="server" />
            <asp:RequiredFieldValidator ID="RequiredFieldValidator3" runat="server" 
                ErrorMessage="RequiredFieldValidator" Text="*" ControlToValidate="txtQuantity" ValidationGroup="Update" />
            <asp:RequiredFieldValidator ID="RequiredFieldValidator4" runat="server" 
                ErrorMessage="RequiredFieldValidator" Text="*" ControlToValidate="txtQuantity" ValidationGroup="Insert" />
        </td>
    </tr>
    <tr>
        <td>
            <asp:Literal runat="server" ID="Literal4" Text="<%$ ErpLanguage:Price %>" />
        </td>
        <td>
            <telerik:RadNumericTextBox ID="txtUnitPrice" runat="server" Enabled="false" />
        </td>
    </tr>
    <tr>
        <td align="right" colspan="2">
            <asp:Button ID="btnUpdate" Text="Update" runat="server" CommandName="Update" ValidationGroup="Update"
            Visible='<%# !(DataItem is Telerik.Web.UI.GridInsertionObject) %>' />
            <asp:Button ID="btnInsert" Text="Insert" runat="server" CommandName="PerformInsert" ValidationGroup="Insert"
                Visible='<%# DataItem is Telerik.Web.UI.GridInsertionObject %>' />
            &nbsp;
            <asp:Button ID="btnCancel" Text="Cancel" runat="server" CausesValidation="False"
                CommandName="Cancel" />
        </td>
    </tr>
</table>
