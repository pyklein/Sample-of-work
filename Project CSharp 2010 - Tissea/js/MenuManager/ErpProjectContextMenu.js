function onClientContextMenuItemClicking(sender, args) {
    var treeNode = args.get_node();
    var name = treeNode._textElement.outerText;
    var type = treeNode.get_value().toString();
    type = type.substr(0, 4);
    if (type == "proj") {
        loading("visible");
        getProjectFromName(name);
    }
    else if (type == "acti") {
        document.getElementById("logAlert").style.borderColor = "blue";
        document.getElementById("logAlert").innerHTML = "<table><tr><td><img src=\"Resources/icons/logInfoMessage.jpg\" alt=\"info\" width=\"30%\"/></td><td VALIGN='middle' style='color:blue;'><b color:blue>&nbsp; You can't change an activity</b></td></tr>";
        $("#logAlert").stop(true, true).delay(5).slideDown(250);
        closelogalert();

    }
} //