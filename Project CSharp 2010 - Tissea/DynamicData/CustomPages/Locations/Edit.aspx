<%@ Page Language="C#" MasterPageFile="~/App_Master/Site1.Master" AutoEventWireup="true"
    CodeBehind="Edit.aspx.cs" Inherits="Connors.Erp.Web.DynamicData.CustomPages.Locations.Edit" %>



<asp:Content ContentPlaceHolderID="COMPONENTS" runat="server" ID="Main">
    <asp:DynamicDataManager ID="DynamicDataManager1" runat="server" />
    <asp:ScriptManagerProxy ID="ScriptManagerProxy1" runat="server" />
    <asp:UpdatePanel ID="UpdatePanel1" runat="server">
        <ContentTemplate>
            <asp:ValidationSummary ID="ValidationSummary1" runat="server" EnableClientScript="true"
                HeaderText="List of validation errors" />
            <asp:DynamicValidator runat="server" ID="DetailsViewValidator" ControlToValidate="DetailsView1"
                Display="None" />
            <br />
            <asp:FormView ID="DetailsView1" runat="server" DataSourceID="EditDataSource" OnItemCommand="DetailsView1_ItemCommand"
                OnItemUpdated="DetailsView1_ItemUpdated" DefaultMode="Edit" Width="100%" DataKeyNames="Id">
                <EditItemTemplate>
                    <table width="100%">
                        <tr>
                            <td>
                                <asp:Literal runat="server" ID="Literal1" Text="<%$ ErpLanguage:Name %>" />
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl3" runat="server" DataField="Name" Mode="Edit">
                                </asp:DynamicControl>
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
                                    Mode="Edit"></asp:DynamicControl>
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
                                    Mode="Edit"></asp:DynamicControl>
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
                                <asp:DynamicControl ID="DynamicControl8" runat="server" DataField="Comment1" Mode="Edit">
                                </asp:DynamicControl>
                            </td>
                            <td>
                                Comment 2
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl9" runat="server" DataField="Comment2" Mode="Edit">
                                </asp:DynamicControl>
                            </td>
                            <td>
                                Comment 3
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl2" runat="server" DataField="Comment3" Mode="Edit">
                                </asp:DynamicControl>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Latitude
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl23" runat="server" DataField="Latitude" Mode="Edit">
                                </asp:DynamicControl>
                            </td>
                            <td>
                                Longitude
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl24" runat="server" DataField="Longitude" Mode="Edit">
                                </asp:DynamicControl>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                OS Grid X
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl26" runat="server" DataField="OSGridX" Mode="Edit">
                                </asp:DynamicControl>
                            </td>
                            <td>
                                OS Grid Y
                            </td>
                            <td>
                                <asp:DynamicControl ID="DynamicControl27" runat="server" DataField="OSGridY" Mode="Edit">
                                </asp:DynamicControl>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Line 1
                            </td>
                            <td colspan="4">
                                <asp:DynamicControl ID="DynamicControl29" runat="server" DataField="Line1" Mode="Edit">
                                </asp:DynamicControl>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Line 2
                            </td>
                            <td colspan="4">
                                <asp:DynamicControl ID="DynamicControl30" runat="server" DataField="Line2" Mode="Edit">
                                </asp:DynamicControl>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Line 3
                            </td>
                            <td colspan="4">
                                <asp:DynamicControl ID="DynamicControl31" runat="server" DataField="Line3" Mode="Edit">
                                </asp:DynamicControl>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Line 4
                            </td>
                            <td colspan="4">
                                <asp:DynamicControl ID="DynamicControl32" runat="server" DataField="Line4" Mode="Edit">
                                </asp:DynamicControl>
                            </td>
                        </tr>
                    </table>
                    <br />
                    <asp:LinkButton ID="InsertButton" runat="server" CausesValidation="True" CommandName="Update"
                        Text="Update" />
                    &nbsp;
                    <asp:LinkButton ID="InsertCancelButton" runat="server" CausesValidation="False" CommandName="Cancel"
                        Text="Cancel" />
                </EditItemTemplate>
            </asp:FormView>
            <asp:LinqDataSource ID="EditDataSource" runat="server" ContextTypeName="Connors.Framework.Model.MainDataContext"
                TableName="Locations" EnableUpdate="True">
                <WhereParameters>
                    <asp:DynamicQueryStringParameter />
                </WhereParameters>
            </asp:LinqDataSource>
        </ContentTemplate>
    </asp:UpdatePanel>
</asp:Content>
