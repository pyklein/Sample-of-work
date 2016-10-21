<%@ Control Language="C#" AutoEventWireup="true" CodeBehind="List_Insert.ascx.cs" Inherits="Connors.Erp.Web._common.controls.ActivityWorkTimes.List_Insert" %>
<%@ Register Src="~/DynamicData/Content/GridViewPager.ascx" TagName="GridViewPager" TagPrefix="asp" %>
<%@ Register Src="~/DynamicData/Content/FilterUserControl.ascx" TagName="DynamicFilter" TagPrefix="asp" %>



<asp:DynamicDataManager ID="DynamicDataManager1" runat="server" />
<asp:ScriptManagerProxy ID="ScriptManagerProxy1" runat="server" />

<asp:UpdatePanel ID="UpdatePanel1" runat="server">
    <ContentTemplate>
        <asp:DynamicValidator runat="server" ID="GridViewValidator" ControlToValidate="GridView1"
            Display="None" />
        <asp:LinqDataSource ID="GridDataSource" runat="server" ContextTypeName="Connors.Framework.Model.MainDataContext"
            TableName="ActivityWorkTimes" OnSelecting="GridDataSource_Selecting" />
        <asp:LinqDataSource ID="DetailsDataSource" runat="server" ContextTypeName="Connors.Framework.Model.MainDataContext"
            TableName="ActivityWorkTimes" EnableInsert="true" />
        <asp:Label ID="lblHeader" runat="server" Text="Work Times" />
        <div style="clear: both">
            <asp:GridView ID="GridView1" runat="server" DataSourceID="GridDataSource" AllowPaging="True"
                AllowSorting="True" AutoGenerateColumns="False" Width="100%" 
                DataKeyNames="Id">
                <Columns>
                    <asp:DynamicField DataField="Employee" HeaderText="Employee" UIHint="ForeignKey" />
                    <asp:DynamicField DataField="DateTime" HeaderText="Date Time" />
                    <asp:DynamicField DataField="TimeSpent" HeaderText="Time Spent" />
                    <asp:DynamicField DataField="IsPrivate" HeaderText="Is Private" />
                    <asp:DynamicField DataField="CreatedDateTime" HeaderText="Created On" />
                </Columns>
                <PagerTemplate>
                    <asp:GridViewPager ID="GridViewPager1" runat="server" />
                </PagerTemplate>
                <EmptyDataTemplate>
                    There are currently no items in this table.
                </EmptyDataTemplate>
            </asp:GridView>
        </div>
        <div>
            <asp:LinkButton runat="server" ID="AddWorkTime" OnClick="AddWorkTime_Click" CausesValidation="false" Text="<%$ ErpLanguage:Add %>" />
        </div>
        <asp:FormView ID="DetailsView1" runat="server" DataSourceID="DetailsDataSource" DefaultMode="Insert"
            Width="100%" Visible="false" 
            OnItemInserted="DetailsView1_ItemInserted"
            OnItemCommand="DetailsView1_ItemCommand">
            <InsertItemTemplate>
                <asp:DynamicControl ID="DynamicControl2" runat="server" DataField="ActivityGuid" Mode="Insert"
                    UIHint="ActivityGuid" Visible="false" />
                <table width="100%">
                    <tr>
                        <td>
                            Employee:
                        </td>
                        <td>
                            <asp:DynamicControl ID="DynamicControl3" runat="server" DataField="Employee" Mode="Insert">
                            </asp:DynamicControl>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Date of Work Time:
                        </td>
                        <td>
                            <asp:DynamicControl ID="DynamicControl4" runat="server" DataField="DateTime" Mode="Insert">
                            </asp:DynamicControl>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Time Spent:
                        </td>
                        <td>
                            <asp:DynamicControl ID="DynamicControl5" runat="server" DataField="TimeSpent" Mode="Insert">
                            </asp:DynamicControl>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Is Private:
                        </td>
                        <td>
                            <asp:DynamicControl ID="DynamicControl1" runat="server" DataField="IsPrivate" Mode="Insert">
                            </asp:DynamicControl>
                        </td>
                    </tr>
                </table>
                <asp:LinkButton ID="InsertButton" runat="server" CausesValidation="True" CommandName="Insert"
                    Text="Insert" />
                &nbsp;<asp:LinkButton ID="InsertCancelButton" runat="server" CausesValidation="False"
                    CommandName="Cancel" Text="Cancel" />
            </InsertItemTemplate>
        </asp:FormView>
        <br />
        <asp:ValidationSummary ID="ValidationSummary1" runat="server" EnableClientScript="true"
            HeaderText="List of validation errors" />
    </ContentTemplate>
</asp:UpdatePanel>