﻿<%@ Control Language="C#" CodeBehind="Children.ascx.cs" Inherits="Connors.Erp.Web.ChildrenField" %>

<asp:HyperLink ID="HyperLink1" runat="server" NavigateUrl="<%# GetChildrenPath() %>" /><br />
<asp:HyperLink ID="InsertHyperLink" runat="server"
NavigateUrl="<%# ChildrenColumn.GetChildrenPath(PageAction.Insert, Row) %>" />