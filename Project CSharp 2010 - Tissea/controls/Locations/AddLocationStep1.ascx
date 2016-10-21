<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="AddLocationStep1.ascx.cs"
    Inherits="Connors.Erp.Web._common.controls.AddLocationStep1" %>



<link href="../../../Resources/css/LocationFinder.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
    function pageLoad() {
        var field = document.getElementById("<%= txtLine1.ClientID %>");
        field.focus();
    }
</script>
<table cellpadding="0" cellspacing="0" class="fixedTable">
    <tr>
        <td>
            <asp:Literal ID="Literal1" runat="server" Text="<%$ ErpLanguage:Name %>" />
        </td>
        <td colspan="3">
            <asp:TextBox runat="server" ID="txtName" TabIndex="0" />
            <asp:RequiredFieldValidator ID="txtNameValidator"
                runat="server" 
                ErrorMessage="<%$ ErpLanguage:ThisFieldIsRequired %>"
                ControlToValidate="txtName" />
        </td>
    </tr>
    <tr>
        <td>
            <asp:Literal ID="Literal2" runat="server" Text="<%$ ErpLanguage:Line1 %>" />
        </td>
        <td>
            <asp:TextBox runat="server" ID="txtLine1" TabIndex="1" />
        </td>
        <td>
            <asp:Literal ID="Literal3" runat="server" Text="<%$ ErpLanguage:Country %>" />
        </td>
        <td>
            <telerik:RadComboBox ID="cbxCountry" runat="server" MarkFirstMatch="true" EmptyMessage="<%$ ErpLanguage:SelectACountry %>" TabIndex="6"/>
        </td>
    </tr>
    <tr>
        <td>
            <asp:Literal ID="Literal4" runat="server" Text="<%$ ErpLanguage:Line2 %>" />
        </td>
        <td>
            <asp:TextBox runat="server" ID="txtLine2" TabIndex="2" />
        </td>
        <td>
            <asp:Literal ID="Literal8" runat="server" Text="<%$ ErpLanguage:Region %>" />
        </td>
        <td>
            <telerik:RadComboBox ID="cbxRegion" runat="server" MarkFirstMatch="true" EmptyMessage="<%$ ErpLanguage:SelectARegion %>" TabIndex="7"/>
        </td>
    </tr>
    <tr>
        <td>
            <asp:Literal ID="Literal5" runat="server" Text="<%$ ErpLanguage:Line3 %>" />
        </td>
        <td>
            <asp:TextBox runat="server" ID="txtLine3" TabIndex="3" />
        </td>
        <td>
            <asp:Literal ID="Literal9" runat="server" Text="<%$ ErpLanguage:County %>" />
        </td>
        <td>
            <telerik:RadComboBox ID="cbxCounty" runat="server" MarkFirstMatch="true" EmptyMessage="<%$ ErpLanguage:SelectACounty %>" TabIndex="8"/>
        </td>
    </tr>
    <tr>
        <td>
            <asp:Literal ID="Literal6" runat="server" Text="<%$ ErpLanguage:Line4 %>" />
        </td>
        <td>
            <asp:TextBox runat="server" ID="txtLine4" TabIndex="4" />
        </td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td>
            <asp:Literal ID="Literal7" runat="server" Text="<%$ ErpLanguage:PostCode %>" />
        </td>
        <td>
            <asp:TextBox runat="server" ID="txtPostCode" TabIndex="5" />
        </td>
        <td>
            &nbsp;</td>
        <td>
            &nbsp;</td>
    </tr>
</table>