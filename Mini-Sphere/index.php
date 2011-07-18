<?

$js=<<<X
/* DHTML Color Sphere : v1.0.2 : 2008/04/17 */
/* http://www.colorjack.com/software/dhtml+color+sphere.html */

function _GLB(v, o) {
	return ((typeof(o) == 'object' ? o : document).getElementById(v));
}

function _GLBS(o) {
	o = _GLB(o);
	if (o) return (o.style);
}

function abPos(o) {
	var o = (typeof(o) == 'object' ? o : _GLB(o)),
		z = {
			X: 0,
			Y: 0
		};
	while (o != null) {
		z.X += o.offsetLeft;
		z.Y += o.offsetTop;
		o = o.offsetParent;
	};
	return (z);
}

function agent(v) {
	return (Math.max(navigator.userAgent.toLowerCase().indexOf(v), 0));
}

function isset(v) {
	return ((typeof(v) == 'undefined' || v.length == 0) ? false : true);
}

function toggle(i, t, xy) {
	var v = _GLBS(i);
	v.display = t ? t : (v.display == 'none' ? 'block' : 'none');
	if (xy) {
		v.left = xy[0];
		v.top = xy[1];
	}
}

function XY(e, v) {
	var o = agent('msie') ? {
		'X': event.clientX + document.documentElement.scrollLeft,
		'Y': event.clientY + document.documentElement.scrollTop
	} : {
		'X': e.pageX,
		'Y': e.pageY
	};
	return (v ? o[v] : o);
}

function zero(n) {
	return (!isNaN(n = parseFloat(n)) ? n : 0);
}

function zindex(d) {
	d.style.zIndex = zINDEX++;
} /* COLOR PICKER */
Picker = {};
Picker.stop = 1;
Picker.core = function (o, e, xy, z, fu) {
	function point(a, b, e) {
		eZ = XY(e);
		commit([eZ.X + a, eZ.Y + b]);
	}

	function M(v, a, z) {
		return (Math.max(!isNaN(z) ? z : 0, !isNaN(a) ? Math.min(a, v) : v));
	}

	function commit(v) {
		if (fu) fu(v);
		if (o == 'mCur') {
			var W = parseInt(_GLBS('mSpec').width),
				W2 = W / 2,
				W3 = W2 / 2;
			var x = v[0] - W2 - 3,
				y = W - v[1] - W2 + 21,
				SV = Math.sqrt(Math.pow(x, 2) + Math.pow(y, 2)),
				hue = Math.atan2(x, y) / (Math.PI * 2);
			hsv = {
				'H': hue > 0 ? (hue * 360) : ((hue * 360) + 360),
				'S': SV < W3 ? (SV / W3) * 100 : 100,
				'V': SV >= W3 ? Math.max(0, 1 - ((SV - W3) / (W2 - W3))) * 100 : 100
			};
			_GLB('mHEX').innerHTML = color.HSV_HEX(hsv);_GLBS('plugID').background = '#' + _GLB('mHEX').innerHTML;
			color.cords(W);
		} else if (o == 'mSize') {
			var b = Math.max(Math.max(v[0], v[1]) + oH, 75);
			color.cords(b);_GLBS('mini').height = (b + 28) + 'px';_GLBS('mini').width = (b + 20) + 'px';_GLBS('mSpec').height = b + 'px';_GLBS('mSpec').width = b + 'px';
		} else {
			if (xy) v = [M(v[0], xy[0], xy[2]), M(v[1], xy[1], xy[3])]; // XY LIMIT
			if (!xy || xy[0]) d.left = v[0] + 'px';
			if (!xy || xy[1]) d.top = v[1] + 'px';
		}
	};
	if (Picker.stop) {
		Picker.stop = '';
		var d = _GLBS(o),
			eZ = XY(e);
		if (!z) zindex(_GLB(o));
		if (o == 'mCur') {
			var ab = abPos(_GLB(o).parentNode);
			point(-(ab.X - 5), -(ab.Y - 28), e);
		}
		if (o == 'mSize') {
			var oH = parseInt(_GLBS('mSpec').height),
				oX = -XY(e).X,
				oY = -XY(e).Y;
		} else {
			var oX = zero(d.left) - eZ.X,
				oY = zero(d.top) - eZ.Y;
		}
		document.onmousemove = function (e) {
			if (!Picker.stop) point(oX, oY, e);
		};
		document.onmouseup = function () {
			Picker.stop = 1;
			document.onmousemove = '';
			document.onmouseup = '';
		};
	}
};
Picker.hsv = {
	H: 0,
	S: 0,
	V: 100
};
zINDEX = 2; /* COLOR LIBRARY */
color = {};
color.cords = function (W) {
	var W2 = W / 2,
		rad = (hsv.H / 360) * (Math.PI * 2),
		hyp = (hsv.S + (100 - hsv.V)) / 100 * (W2 / 2);_GLBS('mCur').left = Math.round(Math.abs(Math.round(Math.sin(rad) * hyp) + W2 + 3)) + 'px';_GLBS('mCur').top = Math.round(Math.abs(Math.round(Math.cos(rad) * hyp) - W2 - 21)) + 'px';
};
color.HEX = function (o) {
	o = Math.round(Math.min(Math.max(0, o), 255));
	return ("0123456789ABCDEF".charAt((o - o % 16) / 16) + "0123456789ABCDEF".charAt(o % 16));
};
color.RGB_HEX = function (o) {
	var fu = color.HEX;
	return (fu(o.R) + fu(o.G) + fu(o.B));
};
color.HSV_RGB = function (o) {
	var R, G, A, B, C, S = o.S / 100,
		V = o.V / 100,
		H = o.H / 360;
	if (S > 0) {
		if (H >= 1) H = 0;
		H = 6 * H;
		F = H - Math.floor(H);
		A = Math.round(255 * V * (1 - S));
		B = Math.round(255 * V * (1 - (S * F)));
		C = Math.round(255 * V * (1 - (S * (1 - F))));
		V = Math.round(255 * V);
		switch (Math.floor(H)) {
		case 0:
			R = V;
			G = C;
			B = A;
			break;
		case 1:
			R = B;
			G = V;
			B = A;
			break;
		case 2:
			R = A;
			G = V;
			B = C;
			break;
		case 3:
			R = A;
			G = B;
			B = V;
			break;
		case 4:
			R = C;
			G = A;
			B = V;
			break;
		case 5:
			R = V;
			G = A;
			B = B;
			break;
		}
		return ({
			'R': R ? R : 0,
			'G': G ? G : 0,
			'B': B ? B : 0,
			'A': 1
		});
	} else
	return ({
		'R': (V = Math.round(V * 255)),
		'G': V,
		'B': V,
		'A': 1
	});
};
color.HSV_HEX = function (o) {
	return (color.RGB_HEX(color.HSV_RGB(o)));
};
X;

$html=<<<X
<div id="mini" onmousedown="Picker.core('mini',event)">
 <div class="north"><span id="mHEX">FFFFFF</span><div onmousedown="_GLBS('mini').display='none';">X</div></div>
 <div class="south" id="mSpec" style="HEIGHT: 128px; WIDTH: 128px;" onmousedown="Picker.core('mCur',event); return false;" onselectstart="return false;">
  <div id="mCur" style="TOP: 86px; LEFT: 68px;"></div>
  <img src="/opensource/Color-Picker/Mini-Sphere/media/circle.png" onmousedown="return false;" ondrag="return false;" onselectstart="return false;">
  <img src="/opensource/Color-Picker/Mini-Sphere/media/resize.gif" id="mSize" onmousedown="Picker.core('mSize',event); return false;" ondrag="return false;" onselectstart="return false;">
 </div>
</div>
X;

$css=<<<X
#mini { COLOR: #999; CURSOR: move; line-height: 1em; FONT-FAMILY: arial, helvetica, san-serif; FONT-SIZE: 11px; POSITION: absolute; background: #000; padding-bottom: 8px; border: 1px solid #111; WIDTH: 148px; HEIGHT: 155px; Z-INDEX: 100; }
#mini div { margin: 0; padding: 0; }
#mini .north { background: #111; border-bottom: 1px solid #171717; }
#mini .north div { color: #999; float: right; padding: 5px 7px; CURSOR: pointer; -moz-user-select: none; -khtml-user-select: none; user-select: none; }
#mini .north div:hover { COLOR: #DE83AD; }
#mini .south { margin: 32px 10px 0 10px; cursor: crosshair; -moz-user-select: none; -khtml-user-select: none; user-select: none; }
#mini .south div { background: url('/opensource/Color-Picker/Mini-Sphere/media/miniCurr.gif') no-repeat; position: absolute; height: 9px; width: 9px; z-index: 101; }
#mini .south img { height: 100%; WIDTH: 100%; position: relative; TOP: -8px; LEFT: -1px; }
#mini #mHEX { padding: 5px 0 4px 7px; cursor: text; float: left; }
#mini #mHEX:hover { color: #DE83AD }
#mini #mSize { float: right; top: -14px; left: 7px; position: relative; height: 14px; width: 14px; cursor: se-resize }
X;

$zDESC=<<<X
This plugin originally was developed for <a href="http://www.typemill.com/">Typemill.com</a> &mdash; feel free to <a href="{$URL}projects/DHTML_Color_Sphere.zip">download the .zip</a><br><br>
Want another color picker? <a href="{$URL}DHTML_Color_Picker/">Color Picker v1.0</a> or <a href="{$URL}DHTML_Color_Picker_2/">Color Picker v2.0</a><br><br>
<div style="height: 175px; padding: 10px 0 0 10px; background: #fff; margin: 10px 0 5px;" id="plugID">{$html}</div>
X;

$zHEAD=<<<X
<style type="text/css">{$css}</style>
<script type="text/javascript">{$js}</script>
X;

$zFOOT=<<<X
<script type="text/javascript">
_GLBS('mini').left=($('plugID').offsetLeft+10)+'px';
_GLBS('mini').top=($('plugID').offsetTop+10)+'px';
_GLBS('mini').display='block';
</script>
X;

?>