// JavaScript Document
function cssmenuhover()
{
	if(!document.getElementById("menu"))
		return;
	var lis = document.getElementById("menu").getElementsByTagName("LI");
	for (var i=0;i<lis.length;i++)
	{
		lis[i].onmouseover=function(){this.className+=" iehover";}
		lis[i].onmouseout=function() {this.className=this.className.replace(new RegExp(" iehover\\b"), "");}
	}
}
if (window.attachEvent)
	window.attachEvent("onload", cssmenuhover);

function post(dom1,dom2,user){
document.location="mailto:"+user+"@"+dom2+"."+dom1;
}