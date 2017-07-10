;
!
function(u, $, v) {
	var x = (function() {
		function x(a, b) {
			this.dom = a;
			this.setOptions(b);
			this.render()
		}
		x.prototype.options = {
			mapName: 'china',
			mapWidth: 500,
			mapHeight: 400,
			stateColorList: ['2770B5', '429DD4', '5AABDA', '1C8DFF', '70B3DD', 'C6E1F4', 'EDF2F6'],
			stateDataAttr: ['stateInitColor', 'stateHoverColor', 'stateSelectedColor', 'baifenbi'],
			stateDataType: 'json',
			stateSettingsXmlPath: '',
			stateData: {},
			strokeWidth: 1,
			strokeColor: 'F9FCFE',
			strokeHoverColor: 'd9d9d9',
			stateInitColor: '',
			stateHoverColor: '00a0e9',
			stateSelectedColor: 'E32F02',
			stateDisabledColor: 'eeeeee',
			showTip: true,
			tipWidth: 220,
			tipHeight: 110,
			tipOuterH: 30,
			tipOuterW: 30,
			stateTipHtml: function(a, b) {
				return b.name
			},
			hoverCallback: function(a, b) {},
			clickCallback: function(a, b) {},
			external: false
		};
		x.prototype.setOptions = function(a) {
			if (a == null) {
				a = null
			}
			this.options = $.extend({}, this.options, a);
			return this
		};
		x.prototype.scaleRaphael = function(n, o, p) {
			var q = document.getElementById(n);
			if (!q.style.position) q.style.position = "relative";
			q.style.width = o + "px";
			q.style.height = p + "px";
			q.style.overflow = "hidden";
			var r;
			if (Raphael.type == "VML") {
				q.innerHTML = "<rvml:group style='position : absolute; width: 1000px; height: 1000px; top: 0px; left: 0px' coordsize='1000,1000' class='rvml' id='vmlgroup_" + n + "'><\/rvml:group>";
				r = document.getElementById("vmlgroup_" + n)
			} else {
				q.innerHTML = '<div class="svggroup"></div>';
				r = q.getElementsByClassName("svggroup")[0]
			}
			var s = new Raphael(r, o, p);
			var t;
			if (Raphael.type == "SVG") {
				s.canvas.setAttribute("viewBox", "0 0 " + o + " " + p)
			} else {
				t = q.getElementsByTagName("div")[0]
			}
			s.changeSize = function(w, h, a, b) {
				b = !b;
				var c = w / o;
				var d = h / p;
				var e = c < d ? c : d;
				var f = parseInt(p * e);
				var g = parseInt(o * e);
				if (Raphael.type == "VML") {
					var j = document.getElementsByTagName("textpath");
					for (var i in j) {
						var k = j[i];
						if (k.style) {
							if (!k._fontSize) {
								var l = k.style.font.split("px");
								k._fontSize = parseInt(l[0]);
								k._font = l[1]
							}
							k.style.font = k._fontSize * e + "px" + k._font
						}
					}
					var m;
					if (g < f) {
						m = g * 1000 / o
					} else {
						m = f * 1000 / p
					}
					m = parseInt(m);
					r.style.width = m + "px";
					r.style.height = m + "px";
					if (b) {
						r.style.left = parseInt((w - g) / 2) + "px";
						r.style.top = parseInt((h - f) / 2) + "px"
					}
					t.style.overflow = "visible"
				}
				if (b) {
					g = w;
					f = h
				}
				q.style.width = g + "px";
				q.style.height = f + "px";
				s.setSize(g, f);
				if (a) {
					q.style.position = "absolute";
					q.style.left = parseInt((w - g) / 2) + "px";
					q.style.top = parseInt((h - f) / 2) + "px"
				}
			};
			s.scaleAll = function(a) {
				s.changeSize(o * a, p * a)
			};
			s.changeSize(o, p);
			s.w = o;
			s.h = p;
			return s
		};
		x.prototype.render = function() {
			var j = this.options,
				_self = this.dom,
				mapName = j.mapName,
				mapConfig = eval(mapName + 'MapConfig');
			var k = {};
			if (j.stateDataType == 'xml') {
				var l = j.stateSettingsXmlPath;
				$.ajax({
					type: 'GET',
					url: l,
					async: false,
					dataType: $.browser.msie ? 'text' : 'xml',
					success: function(b) {
						var c;
						if ($.browser.msie) {
							c = new ActiveXObject('Microsoft.XMLDOM');
							c.async = false;
							c.loadXML(b)
						} else {
							c = b
						}
						var d = $(c);
						d.find('stateData').each(function(i) {
							var a = $(this),
								stateName = a.attr('stateName');
							k[stateName] = {};
							for (var i = 0, len = j.stateDataAttr.length; i < len; i++) {
								k[stateName][j.stateDataAttr[i]] = a.attr(j.stateDataAttr[i])
							}
						})
					}
				})
			} else {
				k = j.stateData
			}
			var m = function(a) {
					var b = $(a.node).offset().left + $(a.node).outerWidth() / 2,
						mouseY = $(a.node).offset().top + $(a.node).outerHeight() / 2;
					var c = j.tipWidth,
						tipHeight = j.tipHeight;
					var d = a.direction;
					var e = j.tipOuterH,
						tipOuterW = j.tipOuterW;
					var f = 0,
						tipTextTop = 0;
					var g = [],
						dian01 = [],
						dian02 = [],
						dian03 = [],
						dian04 = [],
						tipBox = [],
						tipConW = c,
						tipConH = tipHeight;
					if (d == 'left' || d == 'right') {
						tipConW = c + tipOuterW;
						tipConH = tipHeight;
						mouseY = mouseY - tipConH / 2;
						if (d == 'left') {
							b = b - tipConW;
							g = [tipConW, tipConH / 2];
							dian01 = [0, 0];
							dian02 = [c, 0];
							dian03 = [0, tipConH];
							dian04 = [c, tipConH]
						} else {
							f = tipOuterW;
							g = [0, tipConH / 2];
							dian01 = [tipConW, 0];
							dian02 = [tipOuterW, 0];
							dian03 = [tipConW, tipConH];
							dian04 = [tipOuterW, tipConH]
						}
					} else {
						tipConW = c;
						tipConH = tipHeight + e;
						if (d == 'top') {
							b = b - tipConW / 2;
							mouseY = mouseY - tipConH;
							g = [tipConW / 2, tipConH];
							dian01 = [0, 0];
							dian02 = [0, tipHeight];
							dian03 = [tipConW, 0];
							dian04 = [tipConW, tipHeight]
						} else {
							tipTextTop = e;
							b = b - tipConW / 2;
							g = [tipConW / 2, 0];
							dian01 = [0, tipConH];
							dian02 = [0, e];
							dian03 = [tipConW, tipConH];
							dian04 = [tipConW, e]
						}
					}
					var h = Raphael('stateTip', tipConW, tipConH);					
					return [b, mouseY, f, tipTextTop]
				};
			var r = this.scaleRaphael(_self.attr('id'), mapConfig.width, mapConfig.height),
				attributes = {
					cursor: 'pointer',
					stroke: '#' + j.strokeColor,
					'stroke-width': j.strokeWidth,
					'stroke-linejoin': 'round'
				};
			var n = {},
				objHover;
			for (var o in mapConfig.shapes) {
				var p = k[o],
					initColor = '#' + (p && j.stateColorList[p.stateInitColor] || j.stateInitColor || mapConfig['names'][o]['color']),
					hoverColor = '#' + (p && p.stateHoverColor || j.stateHoverColor),
					selectedColor = '#' + (p && p.stateSelectedColor || j.stateSelectedColor),
					disabledColor = '#' + (p && p.stateDisabledColor || j.stateDisabledColor);
				n[o] = {};
				n[o].initColor = initColor;
				n[o].hoverColor = hoverColor;
				n[o].selectedColor = selectedColor;
				var q = r.path(mapConfig['shapes'][o]);
				q.id = o;
				q.name = mapConfig['names'][o]['name'];
				q.attr(attributes);
				q.attr({
					fill: initColor
				});
				var s = q.getBBox().x + mapConfig['names'][o]['x'],
					offsetY = q.getBBox().y + mapConfig['names'][o]['y'];
				var t = r.text(s, offsetY, q.name).attr({
					cursor: 'pointer',
					'metadata': {
						mapId: 1
					},
					'font-size': mapConfig['names'][o]['font-size'],
					'font-family': mapConfig['names'][o]['font-family'],
					'fill': mapConfig['names'][o]['font-color']
				});
				q.font = t;

				t.obj = q;
				t.direction = mapConfig['names'][o]['direction'];
				t.mapId = q.mapId = mapConfig['names'][o]['id'];
				if (j.external) {
					j.external[q.id] = q
				}
				if (k[o] && k[o].diabled) {
					q.attr({
						fill: disabledColor,
						cursor: 'default'
					})
				} else {
					q.attr({
						fill: initColor
					});
					objHover = q;
					q.mousemove(function() {
						objHover.attr({
							fill: n[objHover.id].initColor,
							stroke: '#' + j.strokeColor
						});
						objHover = this;
						this.attr({
							fill: n[this.id].hoverColor,
							stroke: '#' + j.strokeHoverColor
						});
						if (j.showTip && ($('.mapTipText.mapTipText' + this.mapId).length)) {
							$('#stateTip').empty();
							var a = new m(this.font);
							$('#stateTip').stop(false, true).animate({
								left: a[0],
								top: a[1],
								display: 'inline'
							}, 100).show().append('<div id="mapTipContainer"></div>');
							console.log();
							$("#mapTipContainer").css({
								position: "absolute",
								left: a[2],
								top: a[3]
							});
							$('.mapTipText.mapTipText' + this.mapId).clone().appendTo('#mapTipContainer')
						} else {
							$('#stateTip').empty()
						}
					});
					t.mousemove(function() {
						objHover.attr({
							fill: n[objHover.id].initColor,
							stroke: '#' + j.strokeColor
						});
						objHover = this.obj;
						this.obj.attr({
							fill: n[this.obj.id].hoverColor,
							stroke: '#' + j.strokeHoverColor
						});
						if (j.showTip && ($('.mapTipText.mapTipText' + this.mapId).length)) {
							$('#stateTip').empty();
							var a = new m(this);
							$('#stateTip').stop(false, true).animate({
								left: a[0],
								top: a[1],
								display: 'inline'
							}, 100).show().append('<div id="mapTipContainer"></div>');
							console.log();
							$("#mapTipContainer").css({
								position: "absolute",
								left: a[2],
								top: a[3]
							});
							$('.mapTipText.mapTipText' + this.mapId).clone().appendTo('#mapTipContainer')
						} else {
							$('#stateTip').empty()
						}
					})
				}
				r.changeSize(j.mapWidth, j.mapHeight, false, false)
			}
			$("body").mousemove(function(e) {
				var a = _self;
				if (e.pageX < a.offset().left || e.pageX > (a.offset().left + a.innerWidth()) || e.pageY < a.offset().top || e.pageY > (a.offset().top + a.innerHeight())) {
					objHover.attr({
						fill: n[objHover.id].initColor,
						stroke: '#' + j.strokeColor
					});
					$('#stateTip').empty()
				}
			})
		};
		return x
	})();
	$.fn.SVGMap = function(a) {
		var b = $(this),
			data = b.data();
		if (data.SVGMap) {
			delete data.SVGMap
		}
		if (a !== false) {
			data.SVGMap = new x(b, a)
		}
		return data.SVGMap
	}
}(window, jQuery);