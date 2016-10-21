<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="InsertEdit.ascx.cs"
    Inherits="Connors.Erp.Web._common.controls.ActivityWorkTimes.InsertEdit" %>
<table width="400px">
    <tr>
        <td style="width: 150px">
            Employee:
        </td>
        <td>
            <telerik:RadComboBox ID="cbxEmployee" runat="server" OnItemsRequested="cbxEmployee_ItemsRequested"
                Height="100px" Width="250px" EmptyMessage="Select an Employee" EnableLoadOnDemand="true"
                ShowMoreResultsBox="true" DropDownWidth="250px" />
            <asp:RequiredFieldValidator ID="RequiredFieldValidator1" runat="server" ErrorMessage="RequiredFieldValidator"
                Text="*" ControlToValidate="cbxEmployee" />
        </td>
    </tr>
    <tr>
        <td>
            Date of Work Time:
        </td>
        <td>
            <telerik:RadDatePicker ID="txtDateTime" runat="server" />
            <asp:RequiredFieldValidator ID="RequiredFieldValidator2" runat="server" ErrorMessage="RequiredFieldValidator"
                Text="*" ControlToValidate="txtDateTime" />
        </td>
    </tr>
    <tr>
        <td>
            Time Spent:
        </td>
        <td>
            <telerik:RadNumericTextBox ID="txtTimeSpent" runat="server" NumberFormat-DecimalDigits="0" />
            <asp:RequiredFieldValidator ID="RequiredFieldValidator3" runat="server" ErrorMessage="RequiredFieldValidator"
                Text="*" ControlToValidate="txtTimeSpent" />
        </td>
    </tr>
    <tr>
        <td>
            Is Private:
        </td>
        <td>
            <asp:CheckBox ID="ckbIsPrivate" runat="server" />
        </td>
    </tr>
    <tr>
        <td align="right" colspan="2">
            <asp:Button ID="btnUpdate" Text="Update" runat="server" CommandName="Update" Visible='<%# !(DataItem is Telerik.Web.UI.GridInsertionObject) %>' />
            <asp:Button ID="btnInsert" Text="Insert" runat="server" CommandName="PerformInsert"
                Visible='<%# DataItem is Telerik.Web.UI.GridInsertionObject %>' />
            &nbsp;
            <asp:Button ID="btnCancel" Text="Cancel" runat="server" CausesValidation="False"
                CommandName="Cancel" />
        </td>
    </tr>
</table>
