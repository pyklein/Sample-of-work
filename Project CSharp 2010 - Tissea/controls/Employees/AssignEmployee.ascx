<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="AssignEmployee.ascx.cs"
    Inherits="Connors.Erp.Web._common.controls.Employees.AssignEmployee" %>



<script language="javascript" type="text/javascript">
        function CloseWindow() {
            window.opener.PerformSearch();
            window.close();
        }
    
</script>

<div style="width: 300px; height: 200px">
    <telerik:RadScriptManager ID="RadScriptManager1" runat="server" />
    <asp:Literal runat="server" ID="litNumSelectedEmployees" Text="" /><br />
    <asp:Literal runat="server" ID="Literal1" Text="<%$ ErpLanguage:YourAreAboutToAssignEmployeeToSelectedActivitesAndTasks %>" />
    <br />
    <telerik:RadComboBox ID="cbxEmployees" runat="server" Height="100px" Width="250px"
        EmptyMessage="Select an Employee" EnableLoadOnDemand="true" ShowMoreResultsBox="true"
        DropDownWidth="250px" OnItemsRequested="cbxEmployees_ItemsRequested">
    </telerik:RadComboBox>
    <br />
    <asp:Button ID="btnSave" runat="server" Text="<%$ ErpLanguage:Save %>" OnClick="btnSave_Click" />
</div>
