﻿(function(){function a(){Type._registerScript("MicrosoftAjaxSerialization.js",["MicrosoftAjaxCore.js"]);var a=AjaxSys._isBrowser,b=AjaxSys._merge;Type.registerNamespace("AjaxSys.Serialization");AjaxSys.Serialization.JavaScriptSerializer=function(){};AjaxSys.Serialization.JavaScriptSerializer.registerClass("AjaxSys.Serialization.JavaScriptSerializer");b(AjaxSys.Serialization.JavaScriptSerializer,{_esc:{charsRegExs:{'"':/\"/g,"\\":/\\/g},chars:["\\",'"'],dateRegEx:/(^|[^\\])\"\\\/Date\((-?[0-9]+)(?:[a-zA-Z]|(?:\+|-)[0-9]{4})?\)\\\/\"/g,escapeChars:{"\\":"\\\\",'"':'\\"',"\b":"\\b","\t":"\\t","\n":"\\n","\f":"\\f","\r":"\\r"},escapeRegExG:/[\"\\\x00-\x1F]/g,escapeRegEx:/[\"\\\x00-\x1F]/i,jsonRegEx:/[^,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t]/g,jsonStringRegEx:/\"(\\.|[^\"\\])*\"/g},_init:function(){var c=this._esc,f=c.chars,e=c.charsRegExs,d=c.escapeChars;for(var b=0;b<32;b++){var a=String.fromCharCode(b);f[b+2]=a;e[a]=new RegExp(a,"g");d[a]=d[a]||"\\u"+("000"+b.toString(16)).slice(-4)}this._load=true},_serializeNumberWithBuilder:function(a,b){if(!isFinite(a))throw Error.invalidOperation(AjaxSys.Res.cannotSerializeNonFiniteNumbers);b.append(String(a))},_serializeStringWithBuilder:function(b,f){f.append('"');var c=this._esc;if(c.escapeRegEx.test(b)){if(!this._load)this._init();if(b.length<128)b=b.replace(c.escapeRegExG,function(a){return c.escapeChars[a]});else for(var e=0;e<34;e++){var d=c.chars[e];if(b.indexOf(d)!==-1){var g=c.escapeChars[d];b=a("Opera")||a("Firefox")?b.split(d).join(g):b.replace(c.charsRegExs[d],g)}}}f.append(b).append('"')},_serializeWithBuilder:function(b,a,i,h){var d=this,c;switch(typeof b){case "object":if(b)if(Number.isInstanceOfType(b))d._serializeNumberWithBuilder(b,a);else if(Boolean.isInstanceOfType(b))a.append(b);else if(String.isInstanceOfType(b))d._serializeStringWithBuilder(b,a);else if(b instanceof Array){a.append("[");for(c=0;c<b.length;++c){if(c)a.append(",");d._serializeWithBuilder(b[c],a,false,h)}a.append("]")}else{if(Date.isInstanceOfType(b)){a.append('"\\/Date(').append(b.getTime()).append(')\\/"');break}var e=[],f=0;for(var g in b)if(g.charAt(0)!=="$")if(g==="__type"&&f){e[f++]=e[0];e[0]=g}else e[f++]=g;if(i)e.sort();a.append("{");for(c=0;c<f;c++){var k=e[c],j=b[k],l=typeof j;if(l!=="undefined"&&l!=="function"){if(c)a.append(",");d._serializeWithBuilder(k,a,i,h);a.append(":");d._serializeWithBuilder(j,a,i,h)}}a.append("}")}else a.append("null");break;case "number":d._serializeNumberWithBuilder(b,a);break;case "string":d._serializeStringWithBuilder(b,a);break;case "boolean":a.append(b);break;default:a.append("null")}}});AjaxSys.Serialization.JavaScriptSerializer.serialize=function(b){var a=new AjaxSys.StringBuilder;AjaxSys.Serialization.JavaScriptSerializer._serializeWithBuilder(b,a,false);return a.toString()};AjaxSys.Serialization.JavaScriptSerializer.deserialize=function(b,d){if(!b.length)throw Error.argument("data",AjaxSys.Res.cannotDeserializeEmptyString);var e,a=AjaxSys.Serialization.JavaScriptSerializer._esc;try{var c=b.replace(a.dateRegEx,"$1new Date($2)");if(d&&a.jsonRegEx.test(c.replace(a.jsonStringRegEx,"")))throw null;return window.eval("("+c+")")}catch(e){throw Error.argument("data",AjaxSys.Res.cannotDeserializeInvalidJson)}}}if(window.AjaxSys&&AjaxSys.loader)AjaxSys.loader.registerScript("Serialization",null,a);else a()})();
