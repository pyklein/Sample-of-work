<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="AddActivity.ascx.cs" Inherits="Connors.Erp.Web._common.controls.AddActivity" %>



<style type="text/css">
    .style1
    {
        width: 850px;
    }
    .style1 .column
    {
        width: 160px;
    }
    .container
    {
        width: 850px; /*height: 600px;*/
    }
    .invisibleTextBox
    {
        visibility: hidden;
    }
</style>
<telerik:RadScriptBlock ID="RadScriptBlock1" runat="server">

    <script type="text/javascript">
        //global variables for the programmes and categories comboboxes
        var cbxModules, cbxProgrammes, cbxCategories, cbxCustomers, cbxPriorities;
        var cbxPONumbers, cbxLocations, btnShowLocationFinder;
        var customerId;

        function pageLoad() {
            cbxCustomers = $find("<%= cbxCustomers.ClientID %>");
            cbxModules = $find("<%= cbxModules.ClientID %>");
            cbxProgrammes = $find("<%= cbxProgrammes.ClientID %>");
            cbxCategories = $find("<%= cbxCategories.ClientID %>");
            cbxPriorities = $find("<%= cbxPriorities.ClientID %>");
            cbxPONumbers = $find("<%= cbxPONumbers.ClientID %>");
            cbxLocations = $find("<%= cbxLocations.ClientID %>");
            btnShowLocationFinder = document.getElementById("<%= btnShowLocationFinder.ClientID %>");

            cbxCustomers.showDropDown();
        }

        function OnClientSelected(sender, eventArgs) {
            var item = eventArgs.get_item();

            //Set Loading text
            cbxModules.set_text("Loading...");
            cbxPriorities.set_text("Loading...");

            customerId = item.get_value();

            //Clear cbx selections
            cbxProgrammes.clearSelection();
            cbxPriorities.clearSelection();

            //If a customer is selected
            if (item.get_index() > 0) {
                //Load Module, Priorities and Po Number cbx
                cbxModules.requestItems("", false);
                cbxPriorities.requestItems(item.get_value(), false);
            }
            else {

                //Else Empty all cbx
                cbxModules.set_text(" ");
                cbxModules.clearItems();

                cbxProgrammes.set_text(" ");
                cbxProgrammes.clearItems();

                cbxCategories.set_text(" ");
                cbxCategories.clearItems();

                cbxPriorities.set_text(" ");
                cbxPriorities.clearItems();
            }
        }

        function LoadProgrammes(combo, eventArgs) {
            var item = eventArgs.get_item();
            cbxProgrammes.set_text("Loading...");
            cbxCategories.clearSelection();

            // if a module is selected
            if (item.get_value() != null) {
                // this will fire the ItemsRequested event of the
                // programmes combobox passing the module id as a parameter
                cbxProgrammes.requestItems(item.get_value() + "|" + customerId, false);
            }
            else {
                // the -Select a Module - item was chosen
                cbxProgrammes.set_text(" ");
                cbxProgrammes.clearItems();

                cbxCategories.set_text(" ");
                cbxCategories.clearItems();
            }
        }

        function LoadCategories(combo, eventArgs) {
            var item = eventArgs.get_item();

            if (item.get_value() != "") {
                cbxCategories.set_text("Loading...");
                // this will fire the ItemsRequested event of the
                // categories combobox passing the programme id as a parameter
                //cbxCategories.requestItems(item.get_value() + "|" + customerId, false);
                cbxCategories.requestItems(item.get_value(), false);
            }
        }

        function ItemsLoaded(combo, eventArgs) {
            if (combo.get_items().get_count() > 0) {
                // pre-select the first item
                combo.set_text(combo.get_items().getItem(0).get_text());
                combo.get_items().getItem(0).highlight();
            }
            combo.showDropDown();
        }

        function onCbxClientFocus(sender, eventArgs) {
            sender.showDropDown();
        }

        function onLocationsRequested(sender, eventArgs) {

            if (sender.get_items().get_count() == 0) {
                btnShowLocationFinder.style.visibility = 'visible';
            }
            else {
                btnShowLocationFinder.style.visibility = 'hidden';
            }
        }

        function AddAddedLocationToComboBox(sender, eventArgs) {
            var arg = eventArgs.get_argument();
            if (arg) {
                cbxLocations.set_text(arg.LocationName);
                cbxLocations.set_value(arg.LocationId);
            }
        }
    </script>

</telerik:RadScriptBlock>
<telerik:RadWindowManager ID="RadWindowManager1" runat="server" VisibleStatusbar="false" AutoSize="true"/>
<div class="container">
    <table class="style1" cellpadding="5" cellspacing="0">
        <tr>
            <td class="column">
                <asp:Label ID="lblCustomer" runat="server" Text="Customer" AssociatedControlID="cbxCustomers" />
            </td>
            <td colspan="3">
                <telerik:RadComboBox ID="cbxCustomers" runat="server" OnClientSelectedIndexChanging="OnClientSelected"
                    OnItemsRequested="cbxCustomers_ItemsRequested" Width="250px" />
                <asp:RequiredFieldValidator ID="RequiredFieldValidator1" runat="server" 
                    ErrorMessage="<%$ ErpLanguage:ThisFieldIsRequired %>"
                    Text="*"
                    ControlToValidate="cbxCustomers" />
            </td>
        </tr>
    </table>
    <table class="style1" cellpadding="5" cellspacing="0">
        <tr>
            <td class="column">
                <asp:Label ID="lblModules" runat="server" Text="Modules" AssociatedControlID="cbxModules" />
            </td>
            <td class="column">
                <asp:Label ID="lblProgrammes" runat="server" Text="Programmes" AssociatedControlID="cbxProgrammes" />
            </td>
            <td class="column">
                <asp:Label ID="lblCategory" runat="server" Text="Categories" AssociatedControlID="cbxCategories" />
            </td>
            <td>
                <asp:Label ID="lblPriority" runat="server" Text="Priority" AssociatedControlID="cbxPriorities" />
            </td>
        </tr>
        <tr>
            <td>
                <telerik:RadComboBox ID="cbxModules" runat="server" OnClientSelectedIndexChanging="LoadProgrammes"
                    OnClientItemsRequested="ItemsLoaded" OnItemsRequested="cbxModules_ItemsRequested"
                    DropDownWidth="200px" />
                <br />
                <asp:RequiredFieldValidator ID="RequiredFieldValidator2" runat="server" 
                    ErrorMessage="<%$ ErpLanguage:ThisFieldIsRequired %>"
                    Text="*"
                    ControlToValidate="cbxModules" />
            </td>
            <td>
                <telerik:RadComboBox ID="cbxProgrammes" runat="server" OnClientSelectedIndexChanging="LoadCategories"
                    OnClientItemsRequested="ItemsLoaded" OnItemsRequested="cbxProgrammes_ItemsRequested"
                    DropDownWidth="200px" />
                <br />
                <asp:RequiredFieldValidator ID="RequiredFieldValidator3" runat="server" 
                    ErrorMessage="<%$ ErpLanguage:ThisFieldIsRequired %>"
                    Text="*"
                    ControlToValidate="cbxProgrammes" />
            </td>
            <td>
                <telerik:RadComboBox ID="cbxCategories" runat="server" OnClientItemsRequested="ItemsLoaded"
                    OnItemsRequested="cbxCategories_ItemsRequested" DropDownWidth="300px" />
                <br />
                <asp:RequiredFieldValidator ID="RequiredFieldValidator4" runat="server" 
                    ErrorMessage="<%$ ErpLanguage:ThisFieldIsRequired %>"
                    Text="*"
                    ControlToValidate="cbxCategories" />
            </td>
            <td>
                <telerik:RadComboBox ID="cbxPriorities" runat="server" HighlightTemplatedItems="true"
                    MarkFirstMatch="true" Height="100px" DropDownWidth="320px" CloseDropDownOnBlur="true"
                    OnItemsRequested="cbxPriorities_ItemsRequested" OnClientFocus="onCbxClientFocus">
                    <HeaderTemplate>
                        <ul>
                            <li class="col1Priority">
                                <asp:Literal ID="Literal1" runat="server" Text="<%$ ErpLanguage:Name %>" />
                            </li>
                            <li class="col2Priority">
                                <asp:Literal ID="Literal2" runat="server" Text="<%$ ErpLanguage:Due_In %>" />
                            </li>
                            <li class="col3Priority">
                                <asp:Literal ID="Literal3" runat="server" Text="<%$ ErpLanguage:Unit %>" />
                            </li>
                        </ul>
                    </HeaderTemplate>
                    <ItemTemplate>
                        <ul>
                            <li class="col1Priority">
                                <%# DataBinder.Eval(Container.DataItem, "Name")%></li>
                            <li class="col2Priority">
                                <%# DataBinder.Eval(Container.DataItem, "DueDuration")%></li>
                            <li class="col3Priority">
                                <%# DataBinder.Eval(Container.DataItem, "DueDurationUnitName")%></li>
                        </ul>
                    </ItemTemplate>
                </telerik:RadComboBox>
                <br />
                <asp:RequiredFieldValidator ID="RequiredFieldValidator5" runat="server" 
                    ErrorMessage="<%$ ErpLanguage:ThisFieldIsRequired %>"
                    Text="*"
                    ControlToValidate="cbxPriorities" />
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
                    EmptyMessage="Select PO Number" EnableLoadOnDemand="true" ShowMoreResultsBox="true"
                    DropDownWidth="450px" OnItemsRequested="cbxPONumbers_ItemsRequested">
                </telerik:RadComboBox>
            </td>
        </tr>
        <tr>
            <td>
                <asp:Label ID="lblName" runat="server" Text="Name" AssociatedControlID="txtName" />
            </td>
            <td colspan="3">
                <telerik:RadTextBox ID="txtName" runat="server" Width="250px" />
                <asp:RequiredFieldValidator ID="RequiredFieldValidator6" runat="server" 
                    ErrorMessage="<%$ ErpLanguage:ThisFieldIsRequired %>"
                    Text="*"
                    ControlToValidate="txtName" />
            </td>
        </tr>
        <tr>
            <td>
                <asp:Label ID="lblLocation" runat="server" Text="Location" AssociatedControlID="cbxLocations" />
            </td>
            <td colspan="2">
                <telerik:RadComboBox ID="cbxLocations" runat="server" Width="300px" Height="100px"
                    EmptyMessage="Select a Location" EnableLoadOnDemand="true" ShowMoreResultsBox="true"
                    EnableVirtualScrolling="true" OnItemsRequested="cbxLocations_ItemsRequested"
                    OnClientItemsRequested="onLocationsRequested">
                </telerik:RadComboBox>
                <asp:RequiredFieldValidator ID="RequiredFieldValidator7" runat="server" 
                    ErrorMessage="<%$ ErpLanguage:ThisFieldIsRequired %>"
                    Text="*"
                    ControlToValidate="cbxLocations" />
            </td>
            <td>
                <asp:Button ID="btnShowLocationFinder" runat="server" Text="Add Location..." CssClass="invisibleTextBox" />
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
            <td colspan="2">
                <asp:Button ID="btnSaveOnly" runat="server" Text="<%$ ErpLanguage:Save %>" OnClick="btnSaveOnly_Click" />
            </td>
            <td colspan="2">
                <asp:Button ID="btnSaveAndAddTasks" runat="server" Text="<%$ ErpLanguage:SaveAndAddTasks %>" OnClick="btnSaveAndAddTasks_Click" />
            </td>
        </tr>
    </table>
</div>
