function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) {
		if ((obj=MM_findObj("s"+args[i]))!=null) {
			v=args[i+2];
			if (obj.style) {
				obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; 
			}
			obj.visibility=v; 
		}
	}
}
function shownmp() { 
	if (document.getElementById('Dnumpax'))
	{
		document.getElementById("Dnumpax").style.left = findPosX(document.getElementById("linkreservation")) - 450 + 'px';
		document.getElementById("Dnumpax").style.top = findPosY(document.getElementById("linkreservation")) + 15 + 'px';		
		
		if(document.getElementById('Dnumpax').style.display =="")
		{
			document.getElementById('Dnumpax').style.display ="none";
			document.getElementById('num_pax').value="";			
		}
		else
		{
			document.getElementById('Dnumpax').style.display ="";
		}
	}	
	return false;
}
function MM_showHide(){
  var i,p,v,obj,args=MM_showHide.arguments;
  for (i=0; i<(args.length-1); i+=2) {
		if ((obj=MM_findObj(args[i]))!=null) {
			v=args[i+1];
			if (obj.style) {
				obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; 
			}
			obj.visibility=v; 
		}
	}
}

// locate objects
function findPosX(obj) {
    var curleft = 0;
    if (obj.offsetParent) {
        while (1) {
            curleft+=obj.offsetLeft;
            if (!obj.offsetParent) {
                break;
            }
            obj=obj.offsetParent;
        }
    } else if (obj.x) {
        curleft+=obj.x;
    }
    return curleft;
}
function findPosY(obj) {
    var curtop = 0;
    if (obj.offsetParent) {
        while (1) {
            curtop+=obj.offsetTop;
            if (!obj.offsetParent) {
                break;
            }
            obj=obj.offsetParent;
        }
    } else if (obj.y) {
        curtop+=obj.y;
    }
    return curtop;
}

function xWidth(e,w){
	if(!(e=xGetElementById(e)))
		return 0;
	if (xNum(w)) {
		if (w<0)
			w = 0;
		else
			w=Math.round(w);
	} else 
		w=-1;
		var css=xDef(e.style);
	
	if (e == document || e.tagName.toLowerCase() == 'html' || e.tagName.toLowerCase() == 'body') {
		w = xClientWidth();
	}else if(css && xDef(e.offsetWidth) && xStr(e.style.width)) {
		if(w>=0) {
			var pl=0,pr=0,bl=0,br=0;
			if (document.compatMode=='CSS1Compat') {
				var gcs = xGetComputedStyle;pl=gcs(e,'padding-left',1);
				if (pl !== null) {
					pr=gcs(e,'padding-right',1);
					bl=gcs(e,'border-left-width',1);
					br=gcs(e,'border-right-width',1);
				}else if(xDef(e.offsetWidth,e.style.width)){
					e.style.width=w+'px';pl=e.offsetWidth-w;
				}
			}
			w-=(pl+pr+bl+br);
			if(isNaN(w)||w<0) 
				return;
			else 
				e.style.width=w+'px';
		}
		w=e.offsetWidth;
	}
	else if(css && xDef(e.style.pixelWidth)) {
		if(w>=0) 
			e.style.pixelWidth=w;w=e.style.pixelWidth;
	}
	return w;
}

/* X Library, Copyright 2001-2005 Michael Foster (Cross-Browser.com). Distributed under the terms of the GNU LGPL */
/* floater_xlib.js compiled with XC v0.22b, see floater_xlib.txt for contributor copyrights, license info and documentation */
var xVersion='4.0',xOp7Up,xOp6Dn,xIE4Up,xIE4,xIE5,xNN4,xUA=navigator.userAgent.toLowerCase();if(window.opera){var i=xUA.indexOf('opera');if(i!=-1){var v=parseInt(xUA.charAt(i+6));xOp7Up=v>=7;xOp6Dn=v<7;}}else if(navigator.vendor!='KDE' && document.all && xUA.indexOf('msie')!=-1){xIE4Up=parseFloat(navigator.appVersion)>=4;xIE4=xUA.indexOf('msie 4')!=-1;xIE5=xUA.indexOf('msie 5')!=-1;}else if(document.layers){xNN4=true;}xMac=xUA.indexOf('mac')!=-1;
function xDef(){for(var i=0; i<arguments.length; ++i){if(typeof(arguments[i])=='undefined') return false;}return true;}
function xGetComputedStyle(oEle, sProp, bInt){var s, p = 'undefined';var dv = document.defaultView;if(dv && dv.getComputedStyle){s = dv.getComputedStyle(oEle,'');if (s) p = s.getPropertyValue(sProp);}else if(oEle.currentStyle) {var a = sProp.split('-');sProp = a[0];for (var i=1; i<a.length; ++i) {c = a[i].charAt(0);sProp += a[i].replace(c, c.toUpperCase());}   p = oEle.currentStyle[sProp];}else return null;return bInt ? (parseInt(p) || 0) : p;}
function xGetElementById(e){if(typeof(e)!='string') return e;if(document.getElementById) e=document.getElementById(e);else if(document.all) e=document.all[e];else e=null;return e;}
function xNum(){for(var i=0; i<arguments.length; ++i){if(isNaN(arguments[i]) || typeof(arguments[i])!='number') return false;}return true;}
function _xSlideTo(e){if (!(e=xGetElementById(e))) return;var now, s, t, newY, newX;now = new Date();t = now.getTime() - e.C;if (e.stop) { e.moving = false; }else if (t < e.slideTime) {setTimeout("_xSlideTo('"+e.id+"')", e.timeout);if (e.slideLinear) s = e.B * t;else s = Math.sin(e.B * t);newX = Math.round(e.xA * s + e.xD);newY = Math.round(e.yA * s + e.yD);xMoveTo(e, newX, newY);e.moving = true;}  else {xMoveTo(e, e.xTarget, e.yTarget);e.moving = false;}  }
function xStr(s){for(var i=0; i<arguments.length; ++i){if(typeof(arguments[i])!='string') return false;}return true;}
function xHeight(e,h){if(!(e=xGetElementById(e)))return 0;if(xNum(h)){if(h<0)h=0;else h=Math.round(h);}else h=-1;var css=xDef(e.style);if(e==document||e.tagName.toLowerCase()=='html'||e.tagName.toLowerCase()=='body'){h=xClientHeight();}else if(css&&xDef(e.offsetHeight)&&xStr(e.style.height)){if(h>=0){var pt=0,pb=0,bt=0,bb=0;if(document.compatMode=='CSS1Compat'){var gcs=xGetComputedStyle;pt=gcs(e,'padding-top',1);if(pt!==null){pb=gcs(e,'padding-bottom',1);bt=gcs(e,'border-top-width',1);bb=gcs(e,'border-bottom-width',1);}else if(xDef(e.offsetHeight,e.style.height)){e.style.height=h+'px';pt=e.offsetHeight-h;}}h-=(pt+pb+bt+bb);if(isNaN(h)||h<0)return;else e.style.height=h+'px';}h=e.offsetHeight;}else if(css&&xDef(e.style.pixelHeight)){if(h>=0)e.style.pixelHeight=h;h=e.style.pixelHeight;}return h;}
function xTop(e,iY){if(!(e=xGetElementById(e)))return 0;var css=xDef(e.style);if(css&&xStr(e.style.top)){if(xNum(iY))e.style.top=iY+'px';else{iY=parseInt(e.style.top);if(isNaN(iY))iY=xGetComputedStyle(e,'top',1);if(isNaN(iY))iY=0;}}else if(css&&xDef(e.style.pixelTop)){if(xNum(iY))e.style.pixelTop=iY;else iY=e.style.pixelTop;}return iY;}
function xLeft(e,iX){if(!(e=xGetElementById(e)))return 0;var css=xDef(e.style);if(css&&xStr(e.style.left)){if(xNum(iX))e.style.left=iX+'px';else{iX=parseInt(e.style.left);if(isNaN(iX))iX=xGetComputedStyle(e,'left',1);if(isNaN(iX))iX=0;}}else if(css&&xDef(e.style.pixelLeft)){if(xNum(iX))e.style.pixelLeft=iX;else iX=e.style.pixelLeft;}return iX;}

function validarEmail(str_email) {
	var s = str_email;
	//var filter=/^[A-Za-z]([A-Za-z_])*(\.([A-Za-z0-9_])+)*@([A-Za-z0-9])+(\.([A-Za-z0-9_])+)+([A-Za-z])$/;
	var filter=/^[A-Za-z]([A-Za-z_])*(\.([A-Za-z0-9_])+)*@([A-Za-z0-9])+(-([A-Za-z0-9])+)?(\.([A-Za-z0-9_-])+)+([A-Za-z])$/;
	if (s.length == 0 ) return false;
	if (filter.test(s)) {
		return (true);
	} else {
		return (false);
	}
}

function getScrollXY(obj) {
  var scrOfX = 0, scrOfY = 0;
  if(obj.scrollTop || obj.scrollLeft){
    //DOM compliant
    scrOfY = obj.scrollTop;
    scrOfX = obj.scrollLeft;
  }
  return [ scrOfX, scrOfY ];
}


/*This is the code for the calendar/*/
var oldLink = null;
// code to change the active stylesheet
function setActiveStyleSheet(link, title) {
  var i, a, main;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
  if (oldLink) oldLink.style.fontWeight = 'normal';
  oldLink = link;
  link.style.fontWeight = 'bold';
  return false;
}

// This function gets called when the end-user clicks on some date.
function selected(cal, date) {
  cal.sel.value = date; // just update the date in the input field.

  if (cal.dateClicked )
    // if we add this call we close the calendar on single-click.
    // just to exemplify both cases, we are using this only for the 1st
    // and the 3rd field, while 2nd and 4th will still require double-click.
    cal.callCloseHandler();
}

// And this gets called when the end-user clicks on the _selected_ date,
// or clicks on the "Close" button.  It just hides the calendar without
// destroying it.
function closeHandler(cal) {
  cal.hide();                        // hide the calendar
//  cal.destroy();
  _dynarch_popupCalendar = null;
}

// This function shows the calendar under the element having the given id.
// It takes care of catching "mousedown" signals on document and hiding the
// calendar if the click was outside.
function showCalendar(id, format, showsTime, showsOtherMonths) {
  var el = document.getElementById(id);
  if (_dynarch_popupCalendar != null) {
    // we already have some calendar created
    _dynarch_popupCalendar.hide();                 // so we hide it first.
  } else {
    // first-time call, create the calendar.
    var cal = new Calendar(1, null, selected, closeHandler);
    // uncomment the following line to hide the week numbers
    // cal.weekNumbers = false;
    if (typeof showsTime == "string") {
      cal.showsTime = true;
      cal.time24 = (showsTime == "24");
    }
    if (showsOtherMonths) {
      cal.showsOtherMonths = true;
    }
    _dynarch_popupCalendar = cal;                  // remember it in the global var
    cal.setRange(1900, 2070);        // min/max year allowed.
    cal.create();
  }
  _dynarch_popupCalendar.setDateFormat(format);    // set the specified date format
  _dynarch_popupCalendar.parseDate(el.value);      // try to parse the text in field
  _dynarch_popupCalendar.sel = el;                 // inform it what input field we use

  // the reference element that we pass to showAtElement is the button that
  // triggers the calendar.  In this example we align the calendar bottom-right
  // to the button.
  _dynarch_popupCalendar.showAtElement(el.nextSibling, "Br");        // show the calendar

  return false;
}

var MINUTE = 60 * 1000;
var HOUR = 60 * MINUTE;
var DAY = 24 * HOUR;
var WEEK = 7 * DAY;

// If this handler returns true then the "date" given as
// parameter will be disabled.  In this example we enable
// only days within a range of 10 days from the current
// date.
// You can use the functions date.getFullYear() -- returns the year
// as 4 digit number, date.getMonth() -- returns the month as 0..11,
// and date.getDate() -- returns the date of the month as 1..31, to
// make heavy calculations here.  However, beware that this function
// should be very fast, as it is called for each day in a month when
// the calendar is (re)constructed.
function isDisabled(date) {
  var today = new Date();
  return (Math.abs(date.getTime() - today.getTime()) / DAY) > 10;
}

function flatSelected(cal, date) {
  var el = document.getElementById("preview");
  el.innerHTML = date;
}