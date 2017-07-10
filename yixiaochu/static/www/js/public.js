// JavaScript Document
$(function() {     
     //input placeholder
    $("input").placeholder();

    //头部下拉框选择
    $(".list ul li").click(function(){
        $(".cur-sel").html($(this).text());
        $(".cur-sel").attr('data-val', $(this).attr('data-val'));
    });

    //点击头部搜索按钮
    $('.top-search a').click(function(){
        if ($("input[name='keywords']").val() != '') {
            if ($(".cur-sel").attr('data-val') == '1') {    //楼盘搜索
                window.location.href = loupanUrl + '/loupan?keywords=' + $("input[name='keywords']").val();
            }
            if ($(".cur-sel").attr('data-val') == '3') {    //资讯搜索
                window.location.href = newsUrl + '/search/' + $("input[name='keywords']").val();
            }
        }
    });
    //回车搜索
    $('body').keydown(function(event){
    	switch(event.keyCode){
    	case 13:
    		$('.top-search a').trigger('click');
    		break;
    	}
    })
  
    //列表页搜索nav
    $(".nav-main a").click(function() {
        $(this).parents("dl").children("dd").each(function() {
            $("a", this).removeClass("seled")
        });
        $(this).attr("class", "seled");
    });
  
    //底部合作单位展开和收起
    $('.footer .hot').click(function() {
        $('.company-con').toggleClass('act'); 
    });
  
    //返回头部
    $(".right-nav").css("right",(document.body.clientWidth-1180)/2-60);
    var backtotop = $('#backtotop');
    function backTotop() {
        t = $(document).scrollTop();
        if (t > 100 || $(window).width > 480) {
        	backtotop.addClass('showme');
        } else {
        	backtotop.removeClass('showme');
        }
    }
    backTotop();
    $(window).scroll(function () {
      backTotop();
    });
    backtotop.click(function () {
      $('body,html').animate({scrollTop:0},600);
       return false;
    }); 
    
  //右侧菜单栏 用户反馈事件绑定
   $(".right-nav > .file").click(function(){
    	window.open(baseUrl + '/userfeedback');
    });
 
  
});

//input placeholder
$(function(i, k, f) {
    var b = Object.prototype.toString.call(i.operamini) == "[object OperaMini]";
    var a = "placeholder" in k.createElement("input") && !b;
    var g = "placeholder" in k.createElement("textarea") && !b;
    var l = f.fn;
    var e = f.valHooks;
    var c = f.propHooks;
    var n;
    var m;
    if (a && g) {
        m = l.placeholder = function() {
            return this
        };
        m.input = m.textarea = true
    } else {
        m = l.placeholder = function() {
            var p = this;
            p.filter((a ? "textarea": ":input") + "[placeholder]").not(".placeholder").bind({
                "focus.placeholder": d,
                "blur.placeholder": h
            }).data("placeholder-enabled", true).trigger("blur.placeholder");
            return p
        };
        m.input = a;
        m.textarea = g;
        n = {
            get: function(q) {
                var p = f(q);
                var r = p.data("placeholder-password");
                if (r) {
                    return r[0].value
                }
                return p.data("placeholder-enabled") && p.hasClass("placeholder") ? "": q.value
            },
            set: function(q, s) {
                var p = f(q);
                var r = p.data("placeholder-password");
                if (r) {
                    return r[0].value = s
                }
                if (!p.data("placeholder-enabled")) {
                    return q.value = s
                }
                if (s == "") {
                    q.value = s;
                    if (q != o()) {
                        h.call(q)
                    }
                } else {
                    if (p.hasClass("placeholder")) {
                        d.call(q, true, s) || (q.value = s)
                    } else {
                        q.value = s
                    }
                }
                return p
            }
        };
        if (!a) {
            e.input = n;
            c.value = n
        }
        if (!g) {
            e.textarea = n;
            c.value = n
        }
        f(function() {
            f(k).delegate("form", "submit.placeholder", 
            function() {
                var p = f(".placeholder", this).each(d);
                setTimeout(function() {
                    p.each(h)
                },
                10)
            })
        });
        f(i).bind("beforeunload.placeholder", 
        function() {
            f(".placeholder").each(function() {
                this.value = ""
            })
        })
    }
    function j(q) {
        var p = {};
        var r = /^jQuery\d+$/;
        f.each(q.attributes, 
        function(t, s) {
            if (s.specified && !r.test(s.name)) {
                p[s.name] = s.value
            }
        });
        return p
    }
    function d(q, r) {
        var p = this;
        var s = f(p);
        if (p.value == s.attr("placeholder") && s.hasClass("placeholder")) {
            if (s.data("placeholder-password")) {
                s = s.hide().next().show().attr("id", s.removeAttr("id").data("placeholder-id"));
                if (q === true) {
                    return s[0].value = r
                }
                s.focus()
            } else {
                p.value = "";
                s.removeClass("placeholder");
                p == o() && p.select()
            }
        }
    }
    function h() {
        var t;
        var p = this;
        var s = f(p);
        var r = this.id;
        if (p.value == "") {
            if (p.type == "password") {
                if (!s.data("placeholder-textinput")) {
                    try {
                        t = s.clone().attr({
                            type: "text"
                        })
                    } catch(q) {
                        t = f("<input>").attr(f.extend(j(this), {
                            type: "text"
                        }))
                    }
                    t.removeAttr("name").data({
                        "placeholder-password": s,
                        "placeholder-id": r
                    }).bind("focus.placeholder", d);
                    s.data({
                        "placeholder-textinput": t,
                        "placeholder-id": r
                    }).before(t)
                }
                s = s.removeAttr("id").hide().prev().attr("id", r).show()
            }
            s.addClass("placeholder");
            s[0].value = s.attr("placeholder")
        } else {
            s.removeClass("placeholder")
        }
    }
    function o() {
        try {
            return k.activeElement
        } catch(p) {}
    }
} (this, document, jQuery));


/**
 * 绝对定位的提示信息
 * 
 * @param id
 * @param msg
 * @param position
 */
function show_tips(id, msg, position)
{
	 var position = arguments[2] ? arguments[2] : 'right';
	 var d = dialog({
         align: position,
         content: msg,
         quickClose: true
     });
     d.show(document.getElementById(id));

}
