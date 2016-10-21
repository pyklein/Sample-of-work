<%@ Page Language="C#" AutoEventWireup="true" MasterPageFile="~/App_Master/Site1.Master"
    CodeBehind="List.aspx.cs" Inherits="Connors.Erp.Web.DynamicData.CustomPages.Activities.List" %>

<%@ Import Namespace="Connors.Framework.Model" %>
<%@ Import Namespace="Connors.Framework.Language.Properties" %>

<asp:Content ContentPlaceHolderID="COMPONENTS" ID="Main" runat="server">
    <style type="text/css">
        .NestedViewTable
        {
            width: 100%;
        }
        .NestedViewTable tr td span
        {
            text-decoration: underline;
            font-weight: bold;
        }
        .style1
        {
            width: 100%;
        }
        .style1 .column
        {
            width: 160px;
        }
    </style>
    <telerik:RadAjaxLoadingPanel ID="RadAjaxLoadingPanel1" runat="server" />
    <telerik:RadAjaxManager ID="RadAjaxManager1" runat="server" OnAjaxRequest="RadAjaxManager1_AjaxRequest">
        <AjaxSettings>
            <telerik:AjaxSetting AjaxControlID="RadAjaxManager1">
                <UpdatedControls>
                    <telerik:AjaxUpdatedControl ControlID="gridActivities" />
                    <telerik:AjaxUpdatedControl ControlID="gridTasks" LoadingPanelID="RadAjaxLoadingPanel1" />
                    <telerik:AjaxUpdatedControl ControlID="gridMedias" LoadingPanelID="RadAjaxLoadingPanel1" />
                    <telerik:AjaxUpdatedControl ControlID="RadToolTipManager1" />
                    <telerik:AjaxUpdatedControl ControlID="cbxPriceLists" />
                    <telerik:AjaxUpdatedControl ControlID="TabStrip1" />
                    <telerik:AjaxUpdatedControl ControlID="cfV" LoadingPanelID="RadAjaxLoadingPanel1" />
                    <telerik:AjaxUpdatedControl ControlID="gridWorkTimes" LoadingPanelID="RadAjaxLoadingPanel1" />
                    <telerik:AjaxUpdatedControl ControlID="gridNotes" LoadingPanelID="RadAjaxLoadingPanel1" />
                </UpdatedControls>
            </telerik:AjaxSetting>
            <telerik:AjaxSetting AjaxControlID="gridMedias">
                <UpdatedControls>
                    <telerik:AjaxUpdatedControl ControlID="RadToolTipManager1" />
                </UpdatedControls>
            </telerik:AjaxSetting>
        </AjaxSettings>
    </telerik:RadAjaxManager>
    <telerik:RadScriptBlock ID="RadScriptBlock1" runat="server">

        <script type="text/javascript">
            var grid;
            var txtActivitySearch;
            var cbxModules, cbxProgrammes, cbxCategories;
            var cbxCustomersItems, cbxModulesItems, ckbArchived;
            var cbxCustomers, menu;
            var ajaxManager;
            var customerId, moduleId, programmeId, categoryId;
            var rowIndex;

            function pageLoad() {
                ajaxManager = $find("<%=RadAjaxManager1.ClientID %>");
                grid = $find("<%=gridActivities.ClientID %>");
                txtActivitySearch = $find("ctl00_COMPONENTS_toolbarActivities_i3_txtActivitySearch");
                cbxModules = $find("ctl00_COMPONENTS_toolbarActivities_i5_cbxModules");
                cbxProgrammes = $find("ctl00_COMPONENTS_toolbarActivities_i5_cbxProgrammes");
                cbxCategories = $find("ctl00_COMPONENTS_toolbarActivities_i5_cbxCategories");
                cbxCustomers = $find("ctl00_COMPONENTS_toolbarActivities_i5_cbxCustomers");
                ckbArchived = document.getElementById("ctl00_COMPONENTS_toolbarActivities_i6_ckbArchived");
                menu = $find("<%=ActivitiesGridContextMenu.ClientID %>");
            }

            function OnKeyPress(sender, eventArgs) {
                if (eventArgs.get_keyCode() == 13) {
                    eventArgs.get_domEvent().stopPropagation();
                    eventArgs.get_domEvent().preventDefault();
                    PerformSearch();
                    return;
                }
            }

            function OnClientFocus(sender, eventArgs) {
                sender.showDropDown();
            }

            function ClearAllFields() {
                cbxCustomersItems = cbxCustomers.get_items();
                var customerItem = cbxCustomersItems.getItem(0);
                customerItem.select();

                cbxModulesItems = cbxModules.get_items();
                var moduleItem = cbxModulesItems.getItem(0);
                moduleItem.select();

                cbxProgrammes.clearSelection();
                cbxCategories.clearSelection();

                cbxProgrammes.set_text("");
                cbxProgrammes.clearItems();

                cbxCategories.set_text("");
                cbxCategories.clearItems();

                txtActivitySearch.clear();

                ckbArchived.checked = false;
            }

            function OnClientSelected(sender, eventArgs) {
                var item = eventArgs.get_item();
                //Define Customer Id
                customerId = item.get_value();

                //Clear cbx selections
                cbxProgrammes.clearSelection();
                cbxCategories.clearSelection();

                cbxProgrammes.set_text(" ");
                cbxProgrammes.clearItems();

                cbxCategories.set_text(" ");
                cbxCategories.clearItems();
            }

            function LoadProgrammes(combo, eventArgs) {
                var item = eventArgs.get_item();

                cbxCategories.clearSelection();

                // if a module is selected
                if (item.get_index() > 0) {
                    if (item.get_text() == "All") {
                        cbxProgrammes.set_text("All");
                        cbxProgrammes.clearItems();

                        cbxCategories.set_text("All");
                        cbxCategories.clearItems();
                    }
                    else {
                        cbxProgrammes.set_text("Loading...");
                        if (customerId != null) {
                            //If customer id is defined then we need to filter the programme list
                            cbxProgrammes.requestItems(item.get_value() + "|" + customerId, false);
                        }
                        else {
                            cbxProgrammes.requestItems(item.get_value(), false);
                        }
                    }
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

                if (item.get_text() == "All") {
                    cbxCategories.set_text("All");
                    cbxCategories.clearItems();
                }
                else {
                    cbxCategories.set_text("Loading...");
                    //Customer filtered on Server!!!
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

            function ItemSelectedModules(sender, eventArgs) {
                var item = eventArgs.get_item();
                moduleId = item.get_value();
            }

            function ItemSelectedProgrammes(sender, eventArgs) {
                var item = eventArgs.get_item();
                programmeId = item.get_value();
            }

            function ItemSelectedCategory(sender, eventArgs) {
                var item = eventArgs.get_item();
                categoryId = item.get_value();
            }

            function PerformSearch(clear) {
                var sb = new StringBuilder();

                if (clear) {
                    sb.append("Clear|null");
                } else {
                    sb.append("Search|");

                    if (txtActivitySearch) {
                        sb.append(txtActivitySearch.get_value() + "^");
                    } else {
                        sb.append("null^")
                    }

                    if (customerId) {
                        sb.append(customerId + "^");
                    } else {
                        sb.append("null^");
                    }

                    if (moduleId) {
                        sb.append(moduleId + "^");
                    } else {
                        sb.append("null^")
                    }

                    if (programmeId) {
                        sb.append(programmeId + "^");
                    } else {
                        sb.append("null^")
                    }

                    if (categoryId) {
                        sb.append(categoryId + "^");
                    } else {
                        sb.append("null^")
                    }

                    if (ckbArchived.checked)
                        sb.append("true");
                    else
                        sb.append("false");
                }

                ajaxManager.ajaxRequest(sb.toString());
            }

            function ToolbarButtonClicked(sender, eventArgs) {
                var commandName = eventArgs.get_item().get_commandName();
                var selectedDataItem = grid.get_masterTableView().get_dataItems()[rowIndex];

                if (commandName == "doNew") {
                    window.open("<%= ApplicationUrls.ApplicationBaseUrl %>Activities/Insert.aspx", "AddActivity", "menubar=0,resizable=0,width=850,height=500", true);
                } else if (commandName == "doSearch") {
                    PerformSearch();
                } else if (commandName == "doClear") {
                    RebindGrid();
                } else if (commandName == "sendSMS") {
                    var oWnd = radopen("<%= ApplicationUrls.ApplicationBaseUrl %>_common/controls/SMS/SendBySMS.aspx?i=" + selectedDataItem.getDataKeyValue("Id"), "SendJobBySMS");
                } else if (commandName == "doEdit") {
                    if (grid.get_masterTableView().get_selectedItems().length > 0) {
                        window.open("<%= ApplicationUrls.ApplicationBaseUrl %>Activities/Edit.aspx?ac=Edit&Id=" + selectedDataItem.getDataKeyValue("Id"), "EditActivity", "menubar=0,resizable=0,width=700,height=450", true);
                    } else {
                        radalert('<h4>Select an Activity first!</h4>', 330, 100, 'Connor\'s ERP');
                    }
                }
            }

            function RebindGrid() {
                ClearAllFields();
                PerformSearch(true);
            }

            function OnWindowClose(sender, eventArgs) {
                PerformSearch();
            }

            function RebindRelatedGrids(eventArgs) {
                if (grid.get_masterTableView().get_selectedItems().length = 1) {

                    sb = new StringBuilder();

                    sb.append("RebindRelatedGrids|");
                    sb.append(eventArgs.getDataKeyValue("Id") + "^");
                    sb.append(eventArgs.getDataKeyValue("ActivityId") + "^");
                    sb.append(eventArgs.getDataKeyValue("CustomerId"));

                    ajaxManager.ajaxRequest(sb.toString());
                }
            }
            
            function RebindEmptyRelatedGrids() {
                ajaxManager.ajaxRequest("RebindRelatedGrids|^^");
            }

            function gridActivities_RowClick(sender, eventArgs) {
                rowIndex = eventArgs.get_itemIndexHierarchical();
                RebindRelatedGrids(eventArgs);
            }

            function gridActivities_RowDblClick(sender, eventArgs) {
                rowIndex = eventArgs.get_itemIndexHierarchical();
            }

            function gridActivities_RowContextMenu(sender, eventArgs) {
                var evt = eventArgs.get_domEvent();
                if (evt.target.tagName == "INPUT" || evt.target.tagName == "A") {
                    return;
                }

                rowIndex = eventArgs.get_itemIndexHierarchical();

                if (!evt.shiftKey && !evt.ctrlKey) {
                    grid.get_masterTableView().clearSelectedItems();
                }

                sender.get_masterTableView().selectItem(sender.get_masterTableView().get_dataItems()[rowIndex].get_element(), true);

                menu.show(evt);

                evt.cancelBubble = true;
                evt.returnValue = false;

                if (evt.stopPropagation) {
                    evt.stopPropagation();
                    evt.preventDefault();
                }
            }

            function ActivitiesGridContextMenu_ClientItemClicked(sender, args) {
                var itemValue = args.get_item().get_value();
                var selectedDataItem = grid.get_masterTableView().get_dataItems()[rowIndex];
                var selectedItems = grid.get_masterTableView().get_selectedItems();
                
                //If there are selected ids then we retrieve the guids
                if (selectedItems.length > 0) {
                    var sbIdsSelected = new StringBuilder();
                    var sbActivityIdsSelected = new StringBuilder();

                    for (dataItem in selectedItems) {
                        sbIdsSelected.append(selectedItems[dataItem].getDataKeyValue("Id"));
                        sbIdsSelected.append(",");

                        sbActivityIdsSelected.append(selectedItems[dataItem].getDataKeyValue("ActivityId"));
                        sbActivityIdsSelected.append(",");
                    }
                }

                if (itemValue == "Add") {
                    //Opens the Add Activity Page
                    window.open("<%= ApplicationUrls.ApplicationBaseUrl %>Activities/Insert.aspx", "AddActivity", "menubar=0,resizable=0,width=850,height=500", true);
                } else if (itemValue == "Refresh") {
                    PerformSearch();
                } else if (itemValue == "SendToEmployeeBySMS") {
                    //Opens the Send Activity by SMS page
                    var oWnd = radopen("<%= ApplicationUrls.ApplicationBaseUrl %>_common/controls/SMS/SendBySMS.aspx?i=" + selectedDataItem.getDataKeyValue("Id"), "SendJobBySMS");
                } else if (itemValue == "ChangeStatus") {
                    //If we change multiple activities at the same time
                    //We have to check that selected activities have the same workflow status and the same module
                    if (selectedItems.length > 1) {
                        var wfState = selectedItems[0].getDataKeyValue("WorkflowState");
                        var moduleId = selectedItems[0].getDataKeyValue("ModuleId");

                        for (dataItem in selectedItems) {
                            if (selectedItems[dataItem].getDataKeyValue("WorkflowState") != wfState) {
                                radalert('You can only change multiple activities at the same time, which have the same status', 330, 100, 'Connor\'s ERP');
                                return;
                            }
                        }

                        for (dataItem in selectedItems) {
                            if (selectedItems[dataItem].getDataKeyValue("ModuleId") != moduleId) {
                                radalert('You can only change multiple activities at the same time, which have the same module', 330, 100, 'Connor\'s ERP');
                                return;
                            }
                        }
                    }

                    //Retrieves the Selected Activity Guid and opens the Change Status Page
                    ajaxManager.ajaxRequest("ChangeActivityStatus.SelectedIds|" + sbIdsSelected);

                    if (selectedItems.length == 1) {
                        radconfirm("<%= Resources.ConfirmChangeStatusActivity %>", ChangeStatusCallBack, 330, 100, null, "Connor\'s ERP");
                    } else if (selectedItems.length > 1) {
                        radconfirm("<%= Resources.ConfirmChangeStatusActivities %>", ChangeStatusCallBack, 330, 100, null, "Connor\'s ERP");
                    }

                } else if (itemValue == "AddMultipleTasks") {
                    //If we change multiple activities at the same time
                    //We have to check that selected activities have the same workflow status and the same module
                    if (selectedItems.length > 1) {
                        var customerId = selectedItems[0].getDataKeyValue("CustomerId");

                        for (dataItem in selectedItems) {
                            if (selectedItems[dataItem].getDataKeyValue("CustomerId") != customerId) {
                                radalert('You can only add a Task to multiple Activities, which have the same customer', 330, 100, 'Connor\'s ERP');
                                return;
                            }
                        }
                    }

                    //Retrieves the Selected Activity Guid and opens the Change Status Page
                    ajaxManager.ajaxRequest("AddMultipleTasks.SelectedIds|" + sbIdsSelected);

                    if (selectedItems.length == 1) {
                        radalert('<h4><%= Resources.Select2OrMoreActivities %></h4>', 330, 100, 'Connor\'s ERP');
                    } else if (selectedItems.length > 1) {
                        radconfirm("<%= Resources.ConfirmAddMultipleTasks %>", AddMultipleTasksCallBack, 330, 100, null, "Connor\'s ERP");
                    }

                } else if (itemValue == "Edit") {
                    //Opens the Edit Activity Page
                    window.open("<%= ApplicationUrls.ApplicationBaseUrl %>Activities/Edit.aspx?ac=Edit&Id=" + selectedDataItem.getDataKeyValue("Id"), "EditActivity", "menubar=0,resizable=0,width=700,height=450", true);
                } else if (itemValue == "Reports") {
                    //Opens the Print Work Instruction page
                window.open("<%= ApplicationUrls.ApplicationBaseUrl %>_dev/ReactiveQuoteWorkInstruction.aspx?ids=" + sbActivityIdsSelected, "Report", "menubar=0,resizable=0,width=850,height=500", true);
                } else if (itemValue == "AssignEmployee") {
                    //Retrieves the Selected Activity Guid and opens the Assign Employee Page
                    ajaxManager.ajaxRequest("AssignEmployees.SelectedIds|" + sbIdsSelected);

                    if (selectedItems.length == 1) {
                        radconfirm("<%= Resources.ConfirmAssignEmployeeActivity %>", AssignEmployeeCallBack, 330, 100, null, "Connor\'s ERP");
                    } else if (selectedItems.length > 1) {
                        radconfirm("<%= Resources.ConfirmAssignEmployeeActivities %>", AssignEmployeeCallBack, 330, 100, null, "Connor\'s ERP");
                    }
                } else if (itemValue == "SelectAll") {
                    //Selects all items on the current grid page
                    grid.get_masterTableView().selectAllItems();
                } else if (itemValue == "PlanActivity") {
                    //Retrieves the Selected Activity Guid and opens the Plan Activity Page
                    ajaxManager.ajaxRequest("PlanActivitiesAndTasks.SelectedIds|" + sbIdsSelected);

                    if (selectedItems.length == 1) {
                        radconfirm("<%= Resources.ConfirmPlanActivity %>", PlanActivityCallBack, 330, 100, null, "Connor\'s ERP");
                    } else if (selectedItems.length > 1) {
                        radconfirm("<%= Resources.ConfirmPanActivities %>", PlanActivityCallBack, 330, 100, null, "Connor\'s ERP");
                    }
                } else if (itemValue == "Reset") {
                    radconfirm("<%= Resources.ConfirmResetActivity %> " + selectedDataItem.getDataKeyValue("ActivityId"), ResetActivityCallBack, 330, 100, null, "Connor\'s ERP");
                }
            }

            function ResetActivityCallBack(arg) {
                if (arg) {
                } else {
                }
            }

            function AssignEmployeeCallBack(arg) {
                if (arg) {
                    window.open("<%= ApplicationUrls.ApplicationBaseUrl %>_common/controls/Employees/AssignEmployeeToActivity.aspx", "AssignEmployee", "menubar=0,resizable=0,width=300,height=200", true);
                } else {
                }
            }

            function PlanActivityCallBack(arg) {
                if (arg) {
                    window.open("<%= ApplicationUrls.ApplicationBaseUrl %>_common/controls/Activities/PlanActivityAndTasksPage.aspx", "PlanActivityAndTasks", "menubar=0,resizable=0,width=300,height=255", true);
                } else {  
                }
            }

            function ChangeStatusCallBack(arg) {
                if (arg) {
                    window.open("<%= ApplicationUrls.ApplicationBaseUrl %>_common/controls/Activities/ChangeStatus.aspx", "ChangeActivityStatus", "menubar=0,resizable=0,width=250,height=150", true);
                } else {
                }
            }

            function AddMultipleTasksCallBack(arg) {
                if (arg) {
                    window.open("<%= ApplicationUrls.ApplicationBaseUrl %>_common/controls/Tasks/AddTaskToMultipleActivities.aspx", "AddMultipleTasks", "menubar=0,resizable=0,width=460,height=180", true);
                } else {
                }
            }

            function PaneRelatedItems_ClientResized(sender, eventArgs) {
                ajaxManager.ajaxRequest("null|null");
            }

            function PaneRelatedItems_ClientCollapseExpanded(sender, eventArgs) {
                ajaxManager.ajaxRequest("null|null");
            }
        </script>

    </telerik:RadScriptBlock>
    <telerik:RadWindowManager ID="RadWindowManager1" runat="server" />
    <telerik:RadSplitter ID="RadSplitter1" runat="server" Width="100%" Height="100%"
        Orientation="Horizontal" BorderStyle="None">
        <telerik:RadPane ID="PaneToolbar" runat="server" Scrolling="None" Height="32px" EnableViewState="false">
            <telerik:RadToolBar ID="toolbarActivities" runat="server" Width="100%" OnClientButtonClicked="ToolbarButtonClicked">
                <Items>
                    <telerik:RadToolBarButton CommandName="doNew" Text="<%$ ErpLanguage:Add %>"
                        AccessKey="N" ToolTip="Alt + N" />
                    <telerik:RadToolBarButton CommandName="doEdit" Text="<%$ ErpLanguage:Edit %>"
                        AccessKey="E" ToolTip="Alt + E" />
                    <telerik:RadToolBarButton IsSeparator="true" />
                    <telerik:RadToolBarButton>
                        <ItemTemplate>
                            <telerik:RadTextBox runat="server" ID="txtActivitySearch" EmptyMessage="Search Activity"
                                Width="200px" AutoPostBack="false" AccessKey="S" ClientEvents-OnKeyPress="OnKeyPress"
                                ToolTip="Alt + S" />
                        </ItemTemplate>
                    </telerik:RadToolBarButton>
                    <telerik:RadToolBarButton IsSeparator="true" />
                    <telerik:RadToolBarButton Value="MPC">
                        <ItemTemplate>
                            <telerik:RadComboBox ID="cbxCustomers" runat="server" OnClientSelectedIndexChanging="OnClientSelected"
                                OnItemsRequested="cbxCustomers_ItemsRequested" DropDownWidth="250px" AccessKey="C"
                                ToolTip="Alt + C" OnClientFocus="OnClientFocus" />
                            &nbsp;&nbsp;
                            <telerik:RadComboBox ID="cbxModules" runat="server" OnClientSelectedIndexChanging="LoadProgrammes"
                                OnItemsRequested="cbxModules_ItemsRequested" AccessKey="M" OnClientFocus="OnClientFocus"
                                OnClientSelectedIndexChanged="ItemSelectedModules" DropDownWidth="200px" ToolTip="Alt + M">
                            </telerik:RadComboBox>
                            &nbsp;&nbsp;
                            <telerik:RadComboBox ID="cbxProgrammes" runat="server" OnClientSelectedIndexChanging="LoadCategories"
                                OnClientItemsRequested="ItemsLoaded" OnItemsRequested="cbxProgrammes_ItemsRequested"
                                OnClientSelectedIndexChanged="ItemSelectedProgrammes" DropDownWidth="200px">
                            </telerik:RadComboBox>
                            &nbsp;&nbsp;
                            <telerik:RadComboBox ID="cbxCategories" runat="server" OnClientItemsRequested="ItemsLoaded"
                                OnItemsRequested="cbxCategories_ItemsRequested" OnClientSelectedIndexChanged="ItemSelectedCategory"
                                DropDownWidth="300px">
                            </telerik:RadComboBox>
                        </ItemTemplate>
                    </telerik:RadToolBarButton>
                    <telerik:RadToolBarButton Value="Archived">
                        <ItemTemplate>
                            <asp:CheckBox ID="ckbArchived" runat="server" Checked="false" ToolTip="<%$ ErpLanguage:ShowAlsoArchivedActivities %>" />
                        </ItemTemplate>
                    </telerik:RadToolBarButton>
                    <telerik:RadToolBarButton Value="search" CommandName="doSearch" Text="<%$ ErpLanguage:Search %>"
                        PostBack="false" AccessKey="F" ToolTip="Alt + F" />
                    <telerik:RadToolBarButton Value="clear" CommandName="doClear" Text="<%$ ErpLanguage:Clear %>"
                        PostBack="false" AccessKey="X" ToolTip="Atl + X" />
                </Items>
            </telerik:RadToolBar>
        </telerik:RadPane>
        <telerik:RadPane ID="PaneGrid" runat="server" Scrolling="None">
            <telerik:RadGrid ID="gridActivities" runat="server" DataSourceID="vwActivitiesDS"
                AutoGenerateColumns="False" GridLines="None" ShowGroupPanel="true" AllowPaging="true"
                AllowSorting="true" Width="100%" Height="100%" ShowFooter="true" ShowStatusBar="true"
                OnItemDataBound="gridActivities_ItemDataBound" AllowMultiRowSelection="true">
                <MasterTableView DataSourceID="vwActivitiesDS" DataKeyNames="Id,ActivityId,CustomerId"
                    GroupLoadMode="Client" ShowGroupFooter="true" ClientDataKeyNames="Id,ActivityId,CustomerId,ModuleId,WorkflowState">
                    <Columns>
                        <telerik:GridTemplateColumn HeaderText="" UniqueName="CompletedImage" GroupByExpression="Completed Completed Group By Completed">
                            <ItemStyle HorizontalAlign="Center" />
                            <ItemTemplate>
                                <asp:Image ID="imgPinCompleted" runat="server" />
                            </ItemTemplate>
                            <HeaderStyle Width="10px" />
                        </telerik:GridTemplateColumn>
                        <telerik:GridTemplateColumn HeaderText="" UniqueName="PlannedImage" GroupByExpression="Planned Planned Group By Planned">
                            <ItemStyle HorizontalAlign="Center" />
                            <ItemTemplate>
                                <asp:Image ID="imgPinPlanned" runat="server" />
                            </ItemTemplate>
                            <HeaderStyle Width="10px" />
                        </telerik:GridTemplateColumn>
                        <telerik:GridTemplateColumn HeaderText="" UniqueName="InProgressImage" GroupByExpression="InProgress In-Progress Group By InProgress">
                            <ItemStyle HorizontalAlign="Center" />
                            <ItemTemplate>
                                <asp:Image ID="imgPinInProgress" runat="server" />
                            </ItemTemplate>
                            <HeaderStyle Width="10px" />
                        </telerik:GridTemplateColumn>
                        <telerik:GridTemplateColumn HeaderText="" UniqueName="HasDocumentsAttachedImage"
                            Groupable="false">
                            <ItemStyle HorizontalAlign="Center" />
                            <ItemTemplate>
                                <asp:Image ID="imgPinHasDocumentsAttached" runat="server" />
                            </ItemTemplate>
                            <HeaderStyle Width="10px" />
                        </telerik:GridTemplateColumn>
                        <telerik:GridBoundColumn DataField="ActivityId" DataType="System.Int32" HeaderText="<%$ ErpLanguage:Id %>"
                            SortExpression="ActivityId" UniqueName="ActivityId">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="WorkflowState" HeaderText="<%$ ErpLanguage:Status %>"
                            SortExpression="WorkflowState" UniqueName="WorkflowState">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="Name" HeaderText="<%$ ErpLanguage:Name %>"
                            SortExpression="Name" UniqueName="Name" DataFormatString="<nobr>{0}</nobr>">
                            <HeaderStyle Width="150px" />
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="DueDateTime" HeaderText="<%$ ErpLanguage:DueDate %>"
                            SortExpression="DueDateTime" UniqueName="DueDateTime" DataFormatString="{0:d}">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="CompletedDateTime" HeaderText="<%$ ErpLanguage:CompletedOn %>"
                            SortExpression="CompletedDateTime" UniqueName="CompletedDateTime" DataFormatString="{0:d}">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="Owner" HeaderText="<%$ ErpLanguage:Owner %>"
                            SortExpression="Owner" UniqueName="Owner">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="ProgressRatio" DataType="System.Double" HeaderText="<%$ ErpLanguage:ProgressPercentSign %>"
                            SortExpression="ProgressRatio" UniqueName="ProgressRatio">
                        </telerik:GridBoundColumn>
                        <telerik:GridBoundColumn DataField="PoNumber" HeaderText="<%$ ErpLanguage:PO %>"
                            SortExpression="PoNumber" UniqueName="PoNumber">
                        </telerik:GridBoundColumn>
                        <%--<telerik:GridBoundColumn DataField="LocationName" HeaderText="<%$ ErpLanguage:Location %>"
                            SortExpression="LocationName" UniqueName="LocationName" DataFormatString="<nobr>{0}</nobr>">
                            <HeaderStyle Width="100px" />
                        </telerik:GridBoundColumn>--%>
                        <telerik:GridTemplateColumn HeaderText="LocationName" SortExpression="LocationName" UniqueName="LocationName">
                            <ItemTemplate>
                                <asp:HyperLink ID="lblLocationNameTarget" runat="server" NavigateUrl="" Text='<%# Eval("LocationName") %>' />
                            </ItemTemplate>
                        </telerik:GridTemplateColumn>
                        <telerik:GridBoundColumn DataField="PriorityName" HeaderText="<%$ ErpLanguage:Priority %>"
                            SortExpression="PriorityName" UniqueName="PriorityName">
                        </telerik:GridBoundColumn>
                        <%--<telerik:GridBoundColumn DataField="NetAmount" HeaderText="<%$ ErpLanguage:Net %>"
                            SortExpression="NetAmount" UniqueName="NetAmount">
                        </telerik:GridBoundColumn>--%>
                    </Columns>
                    <NestedViewTemplate>
                        <table class="NestedViewTable">
                            <tr>
                                <td>
                                    <span>
                                    <asp:Literal ID="Literal4" runat="server" Text="<%$ ErpLanguage:Module %>" />
                                        : </span>
                                </td>
                                <td>
                                    <%#Eval("ModuleName") %>
                                </td>
                                <td>
                                    <span>
                                    <asp:Literal ID="Literal3" runat="server" Text="<%$ ErpLanguage:CreatedDate %>" />
                                        : </span>
                                </td>
                                <td>
                                    <%#Eval("CreatedDateTime") %>
                                </td>
                                <td>
                                    <span>
                                    <asp:Literal ID="Literal9" runat="server" Text="<%$ ErpLanguage:PlanningOrder %>" />
                                        : </span>
                                </td>
                                <td>
                                    <%#Eval("PlanningOrder")%>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>
                                    <asp:Literal ID="Literal7" runat="server" Text="<%$ ErpLanguage:Programme %>" />
                                        : </span>
                                </td>
                                <td>
                                    <%#Eval("ProgrammeName") %>
                                </td>
                                <td>
                                    <span>
                                    <asp:Literal ID="Literal5" runat="server" Text="<%$ ErpLanguage:StartedOn %>" />
                                        : </span>
                                </td>
                                <td>
                                    <%#Eval("StartedDateTime")%>
                                </td>
                                <td>
                                    <span>
                                    <asp:Literal ID="Literal6" runat="server" Text="<%$ ErpLanguage:ActualDuration %>" />
                                        : </span>
                                </td>
                                <td>
                                    <asp:Literal ID="litActualDuration" runat="server" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>
                                    <asp:Literal ID="Literal8" runat="server" Text="<%$ ErpLanguage:Category  %>" />
                                        : </span>
                                </td>
                                <td>
                                    <%#Eval("CategoryName")%>
                                </td>
                                <td>
                                    <span>
                                    <asp:Literal ID="Literal2" runat="server" Text="<%$ ErpLanguage:CompletedOn %>" />
                                        : </span>
                                </td>
                                <td>
                                    <%#Eval("CompletedDateTime")%>
                                </td>
                                <td>
                                    <span>
                                    <asp:Literal ID="Literal10" runat="server" Text="<%$ ErpLanguage:LastModifiedBy %>" />
                                        : </span>
                                </td>
                                <td>
                                    <%#Eval("ModifiedBy")%>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <span>
                                    <asp:Literal ID="Literal1" runat="server" Text="<%$ ErpLanguage:Description %>" />
                                        : </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" valign="top">
                                    <%#Eval("Description") %>
                                </td>
                            </tr>
                        </table>
                    </NestedViewTemplate>
                    <PagerStyle AlwaysVisible="true" Mode="NextPrevNumericAndAdvanced" />
                </MasterTableView>
                <ClientSettings AllowDragToGroup="true" EnableRowHoverStyle="true">
                    <ClientEvents 
                        OnRowClick="gridActivities_RowClick"
                        OnRowDblClick="gridActivities_RowDblClick"
                        OnRowContextMenu="gridActivities_RowContextMenu" />
                    <Selecting AllowRowSelect="true" EnableDragToSelectRows="true" />
                    <Scrolling AllowScroll="true" UseStaticHeaders="true" />
                </ClientSettings>
            </telerik:RadGrid>
            <asp:LinqDataSource ID="vwActivitiesDS" runat="server" ContextTypeName="Connors.Framework.Model.MainDataContext"
                OrderBy="ActivityId desc" TableName="vwActivities" OnSelecting="vwActivitiesDS_Selecting">
            </asp:LinqDataSource>
            <telerik:RadContextMenu ID="ActivitiesGridContextMenu" runat="server" OnClientItemClicked="ActivitiesGridContextMenu_ClientItemClicked">
                <Items>
                    <telerik:RadMenuItem Value="Add" Text="<%$ ErpLanguage:Add %>" />
                    <telerik:RadMenuItem Value="Edit" Text="<%$ ErpLanguage:Edit %>" />
                    <telerik:RadMenuItem Value="Refresh" Text="<%$ ErpLanguage:Refresh %>" />
                    <telerik:RadMenuItem Value="SelectAll" Text="<%$ ErpLanguage:SelectAll %>" />
                    <telerik:RadMenuItem IsSeparator="true" />
                    <telerik:RadMenuItem Value="AddMultipleTasks" Text="<%$ ErpLanguage:AddATaskProduct %>" />
                    <telerik:RadMenuItem Value="ChangeStatus" Text="<%$ ErpLanguage:ChangeStatus %>" />
                    <telerik:RadMenuItem Value="Reports" Text="<%$ ErpLanguage:Reports %>" />
                </Items>
            </telerik:RadContextMenu>
        </telerik:RadPane>
        <telerik:RadSplitBar runat="server" ID="RadSplitBar1" CollapseMode="Backward" />
        <telerik:RadPane ID="PaneRelatedItems" runat="server" Scrolling="None" Height="250px"
            OnClientCollapsed="PaneRelatedItems_ClientCollapseExpanded" OnClientExpanded="PaneRelatedItems_ClientCollapseExpanded"
            OnClientResized="PaneRelatedItems_ClientResized">
            <telerik:RadTabStrip runat="server" ID="TabStrip1" MultiPageID="RadMultiPageActivity"
                SelectedIndex="0">
                <Tabs>
                    <telerik:RadTab runat="server" Text="<%$ ErpLanguage:TasksProducts %>" />
                    <telerik:RadTab runat="server" Text="<%$ ErpLanguage:Medias %>" />
                    <telerik:RadTab runat="server" Text="<%$ ErpLanguage:ClearanceForm %>" Enabled="false" />
                    <telerik:RadTab runat="server" Text="<%$ ErpLanguage:WorkTimes %>" />
                    <telerik:RadTab runat="server" Text="<%$ ErpLanguage:Notes %>" />
                </Tabs>
            </telerik:RadTabStrip>
            <telerik:RadMultiPage ID="RadMultiPageActivity" runat="server" SelectedIndex="0"
                RenderSelectedPageOnly="false">
                <telerik:RadPageView ID="pageTasks" runat="server">
                    <telerik:RadGrid ID="gridTasks" AutoGenerateColumns="False" runat="server" Width="100%"
                        Height="100%" GridLines="None" ShowFooter="true" OnNeedDataSource="gridTasks_NeedDataSource"
                        OnUpdateCommand="gridTasks_UpdateCommand" OnInsertCommand="gridTasks_InsertCommand">
                        <MasterTableView CommandItemDisplay="Top" DataKeyNames="Id" EditMode="PopUp">
                            <Columns>
                                <telerik:GridEditCommandColumn UniqueName="EditCommandColumn" EditText="<%$ ErpLanguage:Edit %>" />
                                <telerik:GridBoundColumn UniqueName="Planned" DataField="Planned" SortExpression="Planned"
                                    HeaderText="Planned" DataType="System.Boolean" ReadOnly="True">
                                </telerik:GridBoundColumn>
                                <telerik:GridBoundColumn UniqueName="UploadedOnMobileDevice" DataField="UploadedOnMobileDevice"
                                    SortExpression="UploadedOnMobileDevice" HeaderText="UploadedOnMobileDevice" DataType="System.Boolean"
                                    ReadOnly="True">
                                </telerik:GridBoundColumn>
                                <telerik:GridBoundColumn UniqueName="InProgress" DataField="InProgress" SortExpression="InProgress"
                                    HeaderText="In Progress" DataType="System.Boolean" ReadOnly="True">
                                </telerik:GridBoundColumn>
                                <telerik:GridBoundColumn UniqueName="CompletedOnSite" DataField="CompletedOnSite"
                                    SortExpression="CompletedOnSite" HeaderText="CompletedOnSite" DataType="System.Boolean"
                                    ReadOnly="True">
                                </telerik:GridBoundColumn>
                                <telerik:GridBoundColumn UniqueName="CoordinatorUsername" DataField="CoordinatorUsername"
                                    SortExpression="CoordinatorUsername" HeaderText="<%$ ErpLanguage:EmployeeAssigned %>"
                                    DataType="System.String" ReadOnly="True">
                                </telerik:GridBoundColumn>
                                <telerik:GridBoundColumn UniqueName="StockCode" DataField="StockCode" SortExpression="StockCode"
                                    HeaderText="<%$ ErpLanguage:StockCode %>" DataType="System.String" ReadOnly="True">
                                </telerik:GridBoundColumn>
                                <telerik:GridBoundColumn UniqueName="ProductName" DataField="ProductName" SortExpression="ProductName"
                                    HeaderText="<%$ ErpLanguage:Name %>" DataType="System.String" ReadOnly="True">
                                </telerik:GridBoundColumn>
                                <telerik:GridBoundColumn UniqueName="QuantityOrdered" DataField="QuantityOrdered"
                                    SortExpression="QuantityOrdered" HeaderText="<%$ ErpLanguage:Quantity %>"
                                    DataType="System.Int32">
                                </telerik:GridBoundColumn>
                                <telerik:GridBoundColumn UniqueName="NetAmount" DataField="NetAmount" SortExpression="NetAmount"
                                    HeaderText="<%$ ErpLanguage:NetAmount %>" DataType="System.Int32" ReadOnly="True">
                                </telerik:GridBoundColumn>
                                <telerik:GridBoundColumn UniqueName="TaxAmount" DataField="TaxAmount" SortExpression="TaxAmount"
                                    HeaderText="<%$ ErpLanguage:TaxAmount %>" DataType="System.Int32" ReadOnly="True">
                                </telerik:GridBoundColumn>
                                <telerik:GridBoundColumn UniqueName="InvoiceNumber" DataField="InvoiceNumber" SortExpression="InvoiceNumber"
                                    HeaderText="<%$ ErpLanguage:Invoice %>" DataType="System.Int32" ReadOnly="True">
                                </telerik:GridBoundColumn>
                            </Columns>
                            <EditFormSettings UserControlName="~/_common/controls/Tasks/InsertEdit.ascx" EditFormType="WebUserControl">
                                <PopUpSettings Modal="true" Width="450px" />
                                <EditColumn UniqueName="EditCommandColumn" />
                            </EditFormSettings>
                        </MasterTableView>
                    </telerik:RadGrid>
                </telerik:RadPageView>
                <telerik:RadPageView ID="pageMedias" runat="server">
                    <telerik:RadGrid ID="gridMedias" runat="server" GridLines="None" OnNeedDataSource="gridMedias_NeedDataSource"
                        OnItemCommand="gridMedias_ItemCommand" OnItemDataBound="gridMedias_ItemDataBound">
                        <MasterTableView AutoGenerateColumns="False" DataKeyNames="Id" ClientDataKeyNames="Id">
                            <Columns>
                                <telerik:GridTemplateColumn HeaderText="Name" SortExpression="Name">
                                    <ItemTemplate>
                                        <asp:HyperLink ID="targetControl" runat="server" NavigateUrl="" Text='<%# Eval("Name") %>'></asp:HyperLink>
                                    </ItemTemplate>
                                </telerik:GridTemplateColumn>
                                <telerik:GridBoundColumn DataField="CreatedDateTime" DataType="System.DateTime" HeaderText="CreatedDateTime"
                                    SortExpression="CreatedDateTime" UniqueName="CreatedDateTime">
                                </telerik:GridBoundColumn>
                                <telerik:GridBoundColumn DataField="ModifiedDateTime" DataType="System.DateTime"
                                    HeaderText="ModifiedDateTime" SortExpression="ModifiedDateTime" UniqueName="ModifiedDateTime">
                                </telerik:GridBoundColumn>
                                <%--<telerik:GridBinaryImageColumn DataField="Data" HeaderText="Image" UniqueName="Data"
                                    ImageAlign="NotSet" ImageHeight="80px" ImageWidth="80px" ResizeMode="Fit" DataAlternateTextField="Name"
                                    DataAlternateTextFormatString="Image of {0}">
                                </telerik:GridBinaryImageColumn>--%>
                            </Columns>
                        </MasterTableView>
                    </telerik:RadGrid>
                </telerik:RadPageView>
                <telerik:RadPageView ID="pageClearance" runat="server">
                    <asp:SubstationClearanceViewer ID="cfV" runat="server" />
                </telerik:RadPageView>
                <telerik:RadPageView ID="pageWorkTimes" runat="server">
                    <telerik:RadGrid ID="gridWorkTimes" runat="server" GridLines="None" OnNeedDataSource="gridWorkTimes_NeedDataSource"
                        OnInsertCommand="gridWorkTimes_InsertCommand">
                        <MasterTableView AutoGenerateColumns="False" DataKeyNames="Id,ActivityGuid,EmployeeId"
                            CommandItemDisplay="Top" EditMode="PopUp">
                            <Columns>
                                <%--<telerik:GridEditCommandColumn  UniqueName="EditCommandColumn" EditText="<%$ ErpLanguage:Edit %>" />--%>
                                <telerik:GridBoundColumn UniqueName="Number" HeaderText="Employee Number" DataField="Number"
                                    ReadOnly="true" />
                                <telerik:GridBoundColumn UniqueName="FirstName" HeaderText="First Name" DataField="FirstName"
                                    ReadOnly="true" />
                                <telerik:GridBoundColumn UniqueName="LastName" HeaderText="Last Name" DataField="LastName"
                                    ReadOnly="true" />
                                <telerik:GridBoundColumn UniqueName="DateTime" HeaderText="Date Time" DataField="DateTime"
                                    ReadOnly="true" />
                                <telerik:GridBoundColumn UniqueName="TimeSpent" HeaderText="Time Spent" DataField="TimeSpent"
                                    ReadOnly="true" />
                            </Columns>
                            <EditFormSettings UserControlName="~/_common/controls/ActivityWorkTimes/InsertEdit.ascx"
                                EditFormType="WebUserControl">
                                <PopUpSettings Modal="true" Width="400px" />
                                <EditColumn UniqueName="EditCommandColumn" />
                            </EditFormSettings>
                        </MasterTableView>
                    </telerik:RadGrid>
                </telerik:RadPageView>
                <telerik:RadPageView ID="pageNotes" runat="server">
                    <telerik:RadGrid ID="gridNotes" runat="server" GridLines="None" OnNeedDataSource="gridNotes_NeedDataSource">
                        <MasterTableView AutoGenerateColumns="False" DataKeyNames="Id">
                            <Columns>
                                <telerik:GridBoundColumn UniqueName="Note" HeaderText="<%$ ErpLanguage:Notes %>" DataField="Note"
                                    ReadOnly="true" DataType="System.String" />
                                <telerik:GridBoundColumn UniqueName="IsPrivate" HeaderText="Is Private" DataField="IsPrivate"
                                    ReadOnly="true" DataType="System.Boolean" />
                            </Columns>
                        </MasterTableView>
                    </telerik:RadGrid>
                </telerik:RadPageView>
            </telerik:RadMultiPage>
        </telerik:RadPane>
    </telerik:RadSplitter>
    <telerik:RadToolTipManager ID="RadToolTipManager1" OffsetY="-1" HideEvent="ManualClose"
        Width="380" Height="400" runat="server" OnAjaxUpdate="MediaAjaxUpdate" RelativeTo="Element"
        Position="MiddleRight">
    </telerik:RadToolTipManager>
    <telerik:RadToolTipManager ID="RadToolTipManager2" runat="server"
        Width="300"
        OnAjaxUpdate="LocationAjaxUpdate" RelativeTo="Element"
        HideEvent="LeaveTargetAndToolTip" Position="MiddleLeft">
    </telerik:RadToolTipManager>
</asp:Content>