/**
 * 时间选择器
 */
define(function(require, exports, module){
    window.jQuery = window.$ = require("jquery");
    require('datepicker');
    module.exports = {
    		date:function(){
    				var date = new Date();
    				//初始化日期控件
    			    var opt = {
    			        preset: 'date', //日期
    			        theme: 'android-ics light', //皮肤样式
    			        display: 'modal', //显示方式 
    			        mode: 'scroller', //日期选择模式
    			        dateFormat: 'yy-mm-dd', // 日期格式
    			        setText: '确定', //确认按钮名称
    			        cancelText: '取消',//取消按钮名籍我
    			        dateOrder: 'yymmdd', //面板中日期排列格式
    			        dayText: '日', monthText: '月', yearText: '年', //面板中年月日文字
    			        startYear: date.getFullYear(),
    			        endYear:date.getFullYear()+20 //结束年份
    			    };
    			    $('.Wdate').mobiscroll(opt);
    		}
    }
    
});