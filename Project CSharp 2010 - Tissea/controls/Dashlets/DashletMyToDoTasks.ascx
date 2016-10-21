<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="DashletMyToDoTasks.ascx.cs"
    Inherits="Connors.Erp.Web._common.controls.Dashlets.DashletMyToDoTasks" %>
<telerik:RadGrid ID="gridMyToDoTasks" runat="server" OnNeedDataSource="gridMyToDoTasks_NeedDataSource"
    OnItemDataBound="gridMyToDoTasks_ItemDataBound" AutoGenerateColumns="False" GridLines="None"
    AllowPaging="true" PageSize="10">
    <MasterTableView>
        <Columns>
            <telerik:GridTemplateColumn HeaderText="" UniqueName="StatusImage">
                <ItemStyle HorizontalAlign="Center" />
                <ItemTemplate>
                    <asp:Image ID="imgStatus" runat="server" />
                </ItemTemplate>
                <HeaderStyle Width="10px" />
            </telerik:GridTemplateColumn>
            <telerik:GridTemplateColumn HeaderText="" UniqueName="ImportanceImage">
                <ItemStyle HorizontalAlign="Center" />
                <ItemTemplate>
                    <asp:Image ID="imgImportance" runat="server" />
                </ItemTemplate>
                <HeaderStyle Width="10px" />
            </telerik:GridTemplateColumn>
            <telerik:GridBoundColumn DataField="Subject" HeaderText="Subject" ReadOnly="True"
                SortExpression="Subject" UniqueName="Subject" DataFormatString="<nobr>{0}</nobr>">
            </telerik:GridBoundColumn>
            <telerik:GridBoundColumn DataField="StartDateTime" DataType="System.DateTime" HeaderText="StartDateTime"
                ReadOnly="True" SortExpression="StartDateTime" UniqueName="StartDateTime" DataFormatString="{0:D}">
            </telerik:GridBoundColumn>
            <telerik:GridBoundColumn DataField="DueDateTime" DataType="System.DateTime" HeaderText="DueDateTime"
                ReadOnly="True" SortExpression="DueDateTime" UniqueName="DueDateTime" DataFormatString="{0:D}">
            </telerik:GridBoundColumn>
            <telerik:GridBoundColumn DataField="PercentCompleted" DataType="System.Int32" HeaderText="%"
                ReadOnly="True" SortExpression="PercentCompleted" UniqueName="PercentCompleted">
                <ItemStyle HorizontalAlign="Center" />
            </telerik:GridBoundColumn>
        </Columns>
    </MasterTableView>
</telerik:RadGrid>
