<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="DashletMyActivities.ascx.cs"
    Inherits="Connors.Erp.Web._common.controls.Dashlets.DashletMyActivities" %>
<telerik:RadGrid ID="gridActivities" runat="server" AutoGenerateColumns="False" GridLines="None"
    OnNeedDataSource="gridActivities_NeedDataSource"
    OnItemDataBound="gridActivities_ItemDataBound"
    AllowPaging="true" PageSize="10">
    <MasterTableView>
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
            <telerik:GridBoundColumn DataField="ActivityId" DataType="System.Int32" HeaderText="ActivityId"
                ReadOnly="True" SortExpression="ActivityId" UniqueName="ActivityId">
            </telerik:GridBoundColumn>
            <telerik:GridBoundColumn DataField="WorkflowState" HeaderText="WorkflowState" ReadOnly="True"
                SortExpression="WorkflowState" UniqueName="WorkflowState">
            </telerik:GridBoundColumn>
            <telerik:GridBoundColumn DataField="Name" HeaderText="Name" ReadOnly="True" SortExpression="Name"
                UniqueName="Name">
            </telerik:GridBoundColumn>
            <telerik:GridBoundColumn DataField="LocationName" HeaderText="LocationName" ReadOnly="True"
                SortExpression="LocationName" UniqueName="LocationName" DataFormatString="<nobr>{0}</nobr>">
            </telerik:GridBoundColumn>
        </Columns>
    </MasterTableView>
</telerik:RadGrid>
