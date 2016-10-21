<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="AddLocationStep3.ascx.cs" Inherits="Connors.Erp.Web._common.controls.AddLocationStep3" %>



<link href="../../../Resources/css/LocationFinder.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript">
    function pageLoad() {
        var field = document.getElementById("<%= ckbDataProtection.ClientID %>");
        field.focus();
    }
</script>
<table cellpadding="0" cellspacing="0" class="fixedTable">
    <tr>
        <td>
            <asp:Literal ID="Literal1" runat="server" Text="<%$ ErpLanguage:DataProtection %>" />
        </td>
        <td>
            <asp:CheckBox ID="ckbDataProtection" runat="server" AutoPostBack="true" TabIndex="0"/>
        </td>
        <td></td>
    </tr>
    <tr>
        <td>
            <asp:Literal ID="Literal2" runat="server" Text="<%$ ErpLanguage:Customer %>" />
        </td>
        <td colspan="2">
            <telerik:RadComboBox ID="cbxCustomer" runat="server" Enabled="false" TabIndex="1"/>
        </td>
    </tr>
    <tr>
        <td>
            <asp:Literal ID="Literal3" runat="server" Text="<%$ ErpLanguage:StaticMap %>" />
        </td>
        <td colspan="2">
            <asp:StaticGMap ID="locationStaticMap" runat="server" Height="250px" format="png32" maptype="hybrid" />
        </td>
    </tr>
</table>
