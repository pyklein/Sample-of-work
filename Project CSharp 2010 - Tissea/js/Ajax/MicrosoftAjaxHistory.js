﻿(function(){var a=null;function b(){var c=true,e="undefined",d="navigate",b=false;Type._registerScript("MicrosoftAjaxHistory.js",["MicrosoftAjaxComponentModel.js","MicrosoftAjaxSerialization.js"]);var f=AjaxSys._isBrowser;AjaxSys.HistoryEventArgs=function(a){AjaxSys.HistoryEventArgs.initializeBase(this);this._state=a};AjaxSys.HistoryEventArgs.prototype={get_state:function(){return this._state}};AjaxSys.HistoryEventArgs.registerClass("AjaxSys.HistoryEventArgs",AjaxSys.EventArgs);AjaxSys.Application._appLoadHandler=a;AjaxSys.Application._beginRequestHandler=a;AjaxSys.Application._clientId=a;AjaxSys.Application._currentEntry="";AjaxSys.Application._endRequestHandler=a;AjaxSys.Application._history=a;AjaxSys.Application._enableHistory=b;AjaxSys.Application._historyFrame=a;AjaxSys.Application._historyInitialized=b;AjaxSys.Application._historyPointIsNew=b;AjaxSys.Application._ignoreTimer=b;AjaxSys.Application._initialState=a;AjaxSys.Application._state={};AjaxSys.Application._timerCookie=0;AjaxSys.Application._timerHandler=a;AjaxSys.Application._uniqueId=a;AjaxSys._Application.prototype.get_stateString=function(){var b=a;if(f("Firefox")){var d=window.location.href,c=d.indexOf("#");if(c!==-1)b=d.substring(c+1);else b="";return b}else b=window.location.hash;if(b.length>0&&b.charAt(0)==="#")b=b.substring(1);return b};AjaxSys._Application.prototype.get_enableHistory=function(){return this._enableHistory};AjaxSys._Application.prototype.set_enableHistory=function(a){this._enableHistory=a};AjaxSys._Application.prototype.add_navigate=function(a){this._addHandler(d,a)};AjaxSys._Application.prototype.remove_navigate=function(a){this._removeHandler(d,a)};AjaxSys._Application.prototype.addHistoryPoint=function(g,j){var b=this;b._ensureHistory();var d=b._state;for(var f in g){var h=g[f];if(h===a){if(typeof d[f]!==e)delete d[f]}else d[f]=h}var i=b._serializeState(d);b._historyPointIsNew=c;b._setState(i,j);b._raiseNavigate()};AjaxSys._Application.prototype.setServerId=function(a,b){this._clientId=a;this._uniqueId=b};AjaxSys._Application.prototype.setServerState=function(a){this._ensureHistory();this._state.__s=a;this._updateHiddenField(a)};AjaxSys._Application.prototype._deserializeState=function(a){var e={};a=a||"";var b=a.indexOf("&&");if(b!==-1&&b+2<a.length){e.__s=a.substr(b+2);a=a.substr(0,b)}var g=a.split("&");for(var f=0,j=g.length;f<j;f++){var d=g[f],c=d.indexOf("=");if(c!==-1&&c+1<d.length){var i=d.substr(0,c),h=d.substr(c+1);e[i]=decodeURIComponent(h)}}return e};AjaxSys._Application.prototype._enableHistoryInScriptManager=function(){this._enableHistory=c};AjaxSys._Application.prototype._ensureHistory=function(){var a=this;if(!a._historyInitialized&&a._enableHistory){if(f("InternetExplorer")&&AjaxSys.Browser.documentMode<8){a._historyFrame=AjaxSys.get("#__historyFrame");a._ignoreIFrame=c}a._timerHandler=Function.createDelegate(a,a._onIdle);a._timerCookie=window.setTimeout(a._timerHandler,100);try{a._initialState=a._deserializeState(a.get_stateString())}catch(b){}a._historyInitialized=c}};AjaxSys._Application.prototype._navigate=function(d){var a=this;a._ensureHistory();var c=a._deserializeState(d);if(a._uniqueId){var e=a._state.__s||"",b=c.__s||"";if(b!==e){a._updateHiddenField(b);__doPostBack(a._uniqueId,b);a._state=c;return}}a._setState(d);a._state=c;a._raiseNavigate()};AjaxSys._Application.prototype._onIdle=function(){var a=this;delete a._timerCookie;var c=a.get_stateString();if(c!==a._currentEntry){if(!a._ignoreTimer){a._historyPointIsNew=b;a._navigate(c)}}else a._ignoreTimer=b;a._timerCookie=window.setTimeout(a._timerHandler,100)};AjaxSys._Application.prototype._onIFrameLoad=function(c){var a=this;a._ensureHistory();if(!a._ignoreIFrame){a._historyPointIsNew=b;a._navigate(c)}a._ignoreIFrame=b};AjaxSys._Application.prototype._onPageRequestManagerBeginRequest=function(){this._ignoreTimer=c};AjaxSys._Application.prototype._onPageRequestManagerEndRequest=function(i,h){var a=this,f=h.get_dataItems()[a._clientId],d=AjaxSys.get("#__EVENTTARGET");if(d&&d.value===a._uniqueId)d.value="";if(typeof f!==e){a.setServerState(f);a._historyPointIsNew=c}else a._ignoreTimer=b;var g=a._serializeState(a._state);if(g!==a._currentEntry){a._ignoreTimer=c;a._setState(g);a._raiseNavigate()}};AjaxSys._Application.prototype._raiseNavigate=function(){var b={};for(var a in this._state)if(a!=="__s")b[a]=this._state[a];var c=new AjaxSys.HistoryEventArgs(b);AjaxSys.Observer.raiseEvent(this,d,c);var e;try{if(f("Firefox")&&window.location.hash&&(!window.frameElement||window.top.location.hash))window.history.go(0)}catch(e){}};AjaxSys._Application.prototype._serializeState=function(d){var a=[];for(var b in d){var e=d[b];if(b==="__s")var c=e;else a[a.length]=b+"="+encodeURIComponent(e)}return a.join("&")+(c?"&&"+c:"")};AjaxSys._Application.prototype._setState=function(f,g){var d=this;if(d._enableHistory){f=f||"";if(f!==d._currentEntry){if(window.theForm){var i=window.theForm.action,j=i.indexOf("#");window.theForm.action=(j!==-1?i.substring(0,j):i)+"#"+f}if(d._historyFrame&&d._historyPointIsNew){d._ignoreIFrame=c;var h=d._historyFrame.contentWindow.document;h.open("javascript:'<html></html>'");h.write("<html><head><title>"+(g||document.title)+'</title><script type="text/javascript">parent.AjaxSys.Application._onIFrameLoad('+AjaxSys.Serialization.JavaScriptSerializer.serialize(f)+");</script></head><body></body></html>");h.close()}d._ignoreTimer=b;d._currentEntry=f;if(d._historyFrame||d._historyPointIsNew){var k=d.get_stateString();if(f!==k){window.location.hash=f;d._currentEntry=d.get_stateString();if(typeof g!==e&&g!==a)document.title=g}}d._historyPointIsNew=b}}};AjaxSys._Application.prototype._updateHiddenField=function(b){if(this._clientId){var a=document.getElementById(this._clientId);if(a)a.value=b}}}if(window.AjaxSys&&AjaxSys.loader)AjaxSys.loader.registerScript("History",a,b);else b()})();