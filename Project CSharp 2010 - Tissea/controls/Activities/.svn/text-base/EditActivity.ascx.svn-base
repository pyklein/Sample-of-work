<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="EditActivity.ascx.cs"
    Inherits="Connors.Erp.Web._common.controls.Activities.EditActivity" %>

<%@ Import Namespace="Connors.Framework.Model" %>


<style type="text/css">
    .style1
    {
        width: 100%;
    }
    .style1 .column
    {
        width: 160px;
    }
    .invisibleTextBox
    {
        visibility: hidden;
    }
</style>
<telerik:RadScriptBlock ID="RadScriptBlock1" runat="server">

    <script type="text/javascript">
        //global variables for the programmes and categories comboboxes
        var cbxPONumbers, cbxLocations, btnShowLocationFinder;
        var customerId = '<%=Session["CurrentCustomerId"] %>';

        //Action performed before the page is unloaded
        window.onbeforeunload = onBeforeCloseTasks;

        function onBeforeCloseTasks() {
            window.opener.RebindGrid();
        }
        
        function pageLoad() {
            cbxPONumbers = $find("<%= cbxPONumbers.ClientID %>");
            cbxLocations = $find("<%= cbxLocations.ClientID %>");
            btnShowLocationFinder = document.getElementById("<%= btnShowLocationFinder.ClientID %>");
        }

        function onLocationsRequested(sender, eventArgs) {

            if (sender.get_items().get_count() == 0) {
                btnShowLocationFinder.style.visibility = 'visible';
            }
            else {
                btnShowLocationFinder.style.visibility = 'hidden';
            }
        }

        function btnShowLocationFinder_ClientClick() {
            window.open("<%= ApplicationUrls.ApplicationBaseUrl %>_common/wizards/Locations/LocationFinderWizard.aspx", "AddLocationWithLocationFinder", "menubar=0,resizable=0,width=700,height=400", true);
        }

        function AddAddedLocationToComboBox(eventArgs) {
            if (eventArgs) {
                cbxLocations.set_text(eventArgs.LocationName);
                cbxLocations.set_value(eventArgs.LocationId);
            }
        }
    </script>

</telerik:RadScriptBlock>
<div style="width: 700px;">
    <table class="style1" cellpadding="5" cellspacing="0">
        <tr>
            <td class="column">
                <asp:Label ID="lblModules" runat="server" Text="<%$ ErpLanguage:Module %>"
                    AssociatedControlID="lblModuleValue" />
            </td>
            <td class="column">
                <asp:Label ID="lblProgrammes" runat="server" Text="<%$ ErpLanguage:Programme %>"
                    AssociatedControlID="lblProgrammeValue" />
            </td>
            <td class="column">
                <asp:Label ID="lblCategory" runat="server" Text="<%$ ErpLanguage:Category %>"
                    AssociatedControlID="lblCategoryValue" />
            </td>
            <td>
                <asp:Label ID="lblPriority" runat="server" Text="<%$ ErpLanguage:Priority %>"
                    AssociatedControlID="lblPriorityValue" />
            </td>
        </tr>
        <tr>
            <td>
                <asp:Label runat="server" ID="lblModuleValue" />
            </td>
            <td>
                <asp:Label runat="server" ID="lblProgrammeValue" />
            </td>
            <td>
                <asp:Label runat="server" ID="lblCategoryValue" />
            </td>
            <td>
                <asp:Label runat="server" ID="lblPriorityValue" />
            </td>
        </tr>
    </table>
    <table class="style1" cellpadding="5" cellspacing="0">
        <tr>
            <td class="column">
                <asp:Label ID="lblPurchaseOrderNumber" runat="server" Text="PO Number" AssociatedControlID="cbxPONumbers" />
            </td>
            <td colspan="3">
                <telerik:RadComboBox ID="cbxPONumbers" runat="server" Height="100px" Width="250px"
                    EmptyMessage="<%$ ErpLanguage:SelectAPONumber %>" EnableLoadOnDemand="true"
                    ShowMoreResultsBox="true" DropDownWidth="450px" OnItemsRequested="cbxPONumbers_ItemsRequested">
                </telerik:RadComboBox>
            </td>
        </tr>
        <tr>
            <td>
                <asp:Label ID="lblName" runat="server" Text="Name" AssociatedControlID="txtName" />
            </td>
            <td colspan="3">
                <telerik:RadTextBox ID="txtName" runat="server" Width="250px" />
                <asp:RequiredFieldValidator ID="RequiredFieldValidator6" runat="server" ErrorMessage="<%$ ErpLanguage:ThisFieldIsRequired %>"
                    Text="*" ControlToValidate="txtName" />
            </td>
        </tr>
        <tr>
            <td>
                <asp:Label ID="lblLocation" runat="server" Text="Location" AssociatedControlID="cbxLocations" />
            </td>
            <td colspan="2">
                <telerik:RadComboBox ID="cbxLocations" runat="server" Width="300px" Height="100px"
                    EmptyMessage="<%$ ErpLanguage:SelectALocation %>" EnableLoadOnDemand="true"
                    ShowMoreResultsBox="true" EnableVirtualScrolling="true" OnItemsRequested="cbxLocations_ItemsRequested"
                    OnClientItemsRequested="onLocationsRequested">
                </telerik:RadComboBox>
                <asp:RequiredFieldValidator ID="RequiredFieldValidator7" runat="server" ErrorMessage="<%$ ErpLanguage:ThisFieldIsRequired %>"
                    Text="*" ControlToValidate="cbxLocations" />
            </td>
            <td>
                <asp:Button ID="btnShowLocationFinder" runat="server" Text="<%$ ErpLanguage:CreateALocation %>"
                    CssClass="invisibleTextBox" OnClientClick="btnShowLocationFinder_ClientClick(); return false;" />
            </td>
        </tr>
        <tr>
            <td valign="top">
                <asp:Literal ID="Literal2" runat="server" Text="<%$ ErpLanguage:Description %>" />
            </td>
            <td colspan="3">
                <telerik:RadEditor ID="txtDescription" runat="server" Height="200px" Width="100%">
                    <Tools>
                        <telerik:EditorToolGroup>
                            <telerik:EditorTool Name="Bold" />
                            <telerik:EditorTool Name="Italic" />
                            <telerik:EditorTool Name="Underline" />
                            <telerik:EditorTool Name="Cut" />
                            <telerik:EditorTool Name="Copy" />
                            <telerik:EditorTool Name="Paste" />
                            <telerik:EditorTool Name="FontName" />
                            <telerik:EditorTool Name="RealFontSize" />
                            <telerik:EditorTool Name="ForeColor" />
                            <telerik:EditorTool Name="BackColor" />
                        </telerik:EditorToolGroup>
                        <telerik:EditorToolGroup>
                            <telerik:EditorTool Name="InsertTable" />
                            <telerik:EditorTool Name="InsertImage" />
                            <telerik:EditorTool Name="LinkManager" />
                            <telerik:EditorTool Name="Unlink" />
                            <telerik:EditorTool Name="InsertOrderedList" />
                            <telerik:EditorTool Name="InsertUnorderedList" />
                        </telerik:EditorToolGroup>
                    </Tools>
                    <Content></Content>
                </telerik:RadEditor>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <asp:Button ID="btnSave" runat="server" Text="<%$ ErpLanguage:Save %>" OnClick="btnSave_Click" />
            </td>
        </tr>
    </table>
</div>
