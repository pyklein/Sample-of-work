<%@ Page Language="C#" AutoEventWireup="true" MasterPageFile="~/App_Master/Site1.Master"
    CodeBehind="Details.aspx.cs" Inherits="Connors.Erp.Web.DynamicData.CustomPages.Locations.Details" %>



<asp:Content ContentPlaceHolderID="COMPONENTS" runat="server" ID="Main">
    <asp:DynamicDataManager ID="DynamicDataManager1" runat="server" />
    <asp:ScriptManagerProxy ID="ScriptManagerProxy1" runat="server" />
    <asp:UpdatePanel ID="UpdatePanel1" runat="server">
        <ContentTemplate>
            <asp:DynamicValidator runat="server" ID="DetailsViewValidator" ControlToValidate="DetailsView1"
                Display="None" />
            <asp:FormView ID="DetailsView1" runat="server" DataSourceID="DetailsDataSource" 
                Width="100%" DataKeyNames="Id">
                <ItemTemplate>
                    <table width="100%">
                        <tr>
                            <td>
                                <asp:Literal runat="server" ID="Literal1" Text="<%$ ErpLanguage:Name %>" />
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl3" runat="server" DataField="Name"
                                    Mode="ReadOnly"></asp:DynamicControl>
                            </td>
                            <td>
                                Area Number
                            </td>
                            <td>
                            </td>
                            <td>
                                In Clearance
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl10" runat="server" DataField="InClearance"
                                    Mode="ReadOnly"></asp:DynamicControl>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Suboffice
                            </td>
                            <td>
                            </td>
                            <td>
                                Location Type
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl15" runat="server" DataField="LocationType"
                                    Mode="ReadOnly"></asp:DynamicControl>
                            </td>
                            <td>
                                Substation Type
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Comment 1
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl8" runat="server" DataField="Comment1"
                                    Mode="ReadOnly"></asp:DynamicControl>
                            </td>
                            <td>
                                Comment 2
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl9" runat="server" DataField="Comment2" Mode="ReadOnly">
                                </asp:DynamicControl>
                            </td>
                            <td>
                                Comment 3
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl2" runat="server" DataField="Comment3" Mode="ReadOnly">
                                </asp:DynamicControl>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                Latitude
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl23" runat="server" DataField="Latitude"
                                    Mode="ReadOnly"></asp:DynamicControl>
                            </td>
                            <td>
                                Longitude
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl24" runat="server" DataField="Longitude"
                                    Mode="ReadOnly"></asp:DynamicControl>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                OS Grid X
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl26" runat="server" DataField="OSGridX"
                                    Mode="ReadOnly"></asp:DynamicControl>
                            </td>
                            <td>
                                OS Grid Y
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl27" runat="server" DataField="OSGridY" Mode="ReadOnly">
                                </asp:DynamicControl>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                Line 1
                            </td>
                            <td colspan="4">
                                <asp:DynamicControl ID="DynamicControl29" runat="server" DataField="Line1" Mode="ReadOnly">
                                </asp:DynamicControl>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Line 2
                            </td>
                            <td colspan="4">
                                <asp:DynamicControl ID="DynamicControl30" runat="server" DataField="Line2" Mode="ReadOnly">
                                </asp:DynamicControl>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Line 3
                            </td>
                            <td colspan="4">
                                <asp:DynamicControl ID="DynamicControl31" runat="server" DataField="Line3" Mode="ReadOnly">
                                </asp:DynamicControl>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Line 4
                            </td>
                            <td colspan="4">
                                <asp:DynamicControl ID="DynamicControl32" runat="server" DataField="Line4" Mode="ReadOnly">
                                </asp:DynamicControl>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <asp:HyperLink ID="EditHyperLink" runat="server" NavigateUrl='<%# table.GetActionPath(PageAction.Edit, GetDataItem()) %>'
                        Text="Edit" />
                    <br />
                </ItemTemplate>
            </asp:FormView>
            <asp:LinqDataSource ID="DetailsDataSource" runat="server" ContextTypeName="Connors.Framework.Model.MainDataContext"
                TableName="Locations" EnableUpdate="True">
                <WhereParameters>
                    <asp:DynamicQueryStringParameter />
                </WhereParameters>
            </asp:LinqDataSource>
            <br />
            <div class="bottomhyperlink">
                <asp:HyperLink ID="ListHyperLink" runat="server">Show all items</asp:HyperLink>
            </div>
            <br />
            <asp:ValidationSummary ID="ValidationSummary1" runat="server" EnableClientScript="true"
                HeaderText="List of validation errors" />
        </ContentTemplate>
    </asp:UpdatePanel>
</asp:Content>
