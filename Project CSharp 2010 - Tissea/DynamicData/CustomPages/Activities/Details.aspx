<%@ Page Language="C#" MasterPageFile="~/App_Master/Site1.Master" AutoEventWireup="true"
    CodeBehind="Details.aspx.cs" Inherits="Connors.Erp.Web.DynamicData.CustomPages.Activities.Details" %>

<%@ Register Src="../../../_common/controls/ActivityNotes/List_Insert.ascx" TagName="Notes"
    TagPrefix="asp" %>
<%@ Register Src="../../../_common/controls/ActivityWorkTimes/List_Insert.ascx" TagName="WorkTimes"
    TagPrefix="asp" %>
<%@ Register Src="../../../_common/controls/Tasks/List_Insert.ascx" TagName="Tasks"
    TagPrefix="asp" %>
<asp:Content ContentPlaceHolderID="COMPONENTS" runat="server" ID="Main">
    <telerik:RadSplitter ID="RadSplitter1" runat="server">
        <telerik:RadPane ID="RadPane1" runat="server" Scrolling="Y">
            <asp:DynamicDataManager ID="DynamicDataManager1" runat="server" AutoLoadForeignKeys="true" />
            <asp:ScriptManagerProxy runat="server" ID="ScriptManagerProxy1" />
            <asp:UpdatePanel ID="UpdatePanel1" runat="server">
                <ContentTemplate>
                    <asp:DynamicValidator runat="server" ID="DetailsViewValidator" ControlToValidate="DetailsView2"
                        Display="None" />
                    <asp:DetailsView ID="DetailsView2" runat="server" DataSourceID="DetailsDataSource"
                        AutoGenerateRows="false" DefaultMode="ReadOnly" CssClass="detailstable" FieldHeaderStyle-CssClass="bold">
                        <Fields>
                            <asp:DynamicField DataField="Id" Visible="false"></asp:DynamicField>
                            <asp:DynamicField DataField="ActivityId"></asp:DynamicField>
                            <asp:DynamicField DataField="ActivityModule"></asp:DynamicField>
                            <asp:DynamicField DataField="ActivityProgramme"></asp:DynamicField>
                            <asp:DynamicField DataField="ActivityCategory"></asp:DynamicField>
                            <asp:DynamicField DataField="Name"></asp:DynamicField>
                            <asp:DynamicField DataField="Location"></asp:DynamicField>
                            <asp:DynamicField DataField="ActivityPriority"></asp:DynamicField>
                            <asp:DynamicField DataField="WorkflowState"></asp:DynamicField>
                            <asp:DynamicField DataField="Owner"></asp:DynamicField>
                            <asp:DynamicField DataField="CreatedDateTime" UIHint="DateTime"></asp:DynamicField>
                            <asp:DynamicField DataField="Description"></asp:DynamicField>
                            <asp:TemplateField>
                                <ItemTemplate>
                                    <asp:HyperLink ID="EditHyperLink" runat="server" NavigateUrl='<%# table.GetActionPath(PageAction.Edit, GetDataItem()) %>'
                                        Text="Edit" />
                                </ItemTemplate>
                            </asp:TemplateField>
                        </Fields>
                    </asp:DetailsView>
                    <asp:LinqDataSource ID="DetailsDataSource" runat="server" EnableDelete="true">
                        <WhereParameters>
                            <asp:DynamicQueryStringParameter />
                        </WhereParameters>
                    </asp:LinqDataSource>
                </ContentTemplate>
            </asp:UpdatePanel>
            <div>
                <asp:HyperLink ID="ListHyperLink" runat="server">Show all items</asp:HyperLink>
            </div>
            <br />
            <asp:Tasks ID="Tasks1" runat="server" />
            <asp:Notes ID="Notes1" runat="server" />
            <asp:WorkTimes ID="WorkTimes1" runat="server" />
            <asp:ValidationSummary ID="ValidationSummary1" runat="server" EnableClientScript="true"
                HeaderText="List of validation errors" />
        </telerik:RadPane>
    </telerik:RadSplitter>
</asp:Content>
