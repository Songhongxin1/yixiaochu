(function($,window) {
    var $scrollElem = $('html, body'),
        $win = $(window),
        isIE6 = !-[1,] && !window.XMLHttpRequest,
        isMac = window.navigator.platform.toLowerCase().indexOf('mac') > -1;
    

    var PageCtrl = function(options) {
        this.init.call(this, options);
    };

    PageCtrl.prototype = {
        init: function(options) {
            this.curIndex = 0;
            this.wrapper = options.wrapper;
            this.pages = this.wrapper.children('section');
            this.pageCount = this.pages.length;
            this.scrollTop = 0;
            this.isScroll = false;
            this.time = null;
            this._bindEvent();
        },

        _bindEvent: function() {
            var self = this;
            if (window.addEventListener) {
                window.addEventListener('DOMMouseScroll', function(event) {self.scroll.call(self, event)}, false);
                window.addEventListener('mousewheel', function(event) {
                    self.scroll.call(self, event);
                }, false);
                window.addEventListener('MozMousePixelScroll', function(event) {
                    event.preventDefault();
                }, false);
            } else {
                document.onmousewheel = function() {
                    self.scroll.call(self);
                };
            }

            // change.page事件
            var topDelta = isIE6 ? 0 : 0,
                animateName = isMac ? 'mac' : 'pc';

            var animateFn = {
                mac: function(scrollTop) {
                    $scrollElem.animate({
                        scrollTop: scrollTop
                    }, 1000, function() {
                        setTimeout(function() {
                            self.isScroll = false;
                        }, 500);
                    });
                },
                pc: function(scrollTop) {
                    $scrollElem.animate({
                        scrollTop: scrollTop
                    }, function() {
                        self.isScroll = false;
                    });
                }
            };
            this.wrapper.on('changepage', function(event, data) {
                var $nextPage = self.pages.eq(data.nextIndex);
                self.pages.eq(data.prevIndex).trigger('exit');
                $nextPage.trigger('enter');
                self.scrollTop = data.nextIndex === 0 ? 0 : $nextPage.offset().top;
                self.scrollTop -= topDelta;
                animateFn[animateName](self.scrollTop);
            });

            // pages 进入/退出事件
            self.pages.on('enter', function() {
                var $this = $(this);
                self.onEnter($this);
            });
            self.pages.on('exit', function() {
                var $this = $(this);
                self.onExit($this);
            });
        },
        scroll: function(event) {
            var oEvent = event || window.event;
            if (oEvent.preventDefault) {
                oEvent.preventDefault();
            } else {
                oEvent.returnValue = false;
            }
            if (this.isScroll) {
                return;
            }
            this.isScroll = true;
            var self = this,
                delta = oEvent.wheelDelta ? oEvent.wheelDelta : -oEvent.detail;
            var curIndex = 0;
            if (delta < 0) {
                curIndex = Math.min((self.curIndex + 1), self.pageCount - 1);
            } else {
                curIndex = Math.max((self.curIndex - 1), 0);
            }
            self.setIndex(curIndex);
        },
        onEnter: function($dom) {
            $dom.addClass('animate-enter').removeClass('animate-exit');
        },
        onExit: function($dom) {
        },

        setIndex: function(index) {
            var prevIndex = this.curIndex;
            this.curIndex = index;
            this.wrapper.trigger('changepage', {
                prevIndex: prevIndex,
                nextIndex: index
            });
        }
    };

    var pageCtrl = new PageCtrl({
        wrapper: $('.main-body')
    });

})(jQuery, window);