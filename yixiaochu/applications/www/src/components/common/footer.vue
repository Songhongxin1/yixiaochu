<template>
<div :class="css_public.footer">
        <div :class="css_public.foot_nav">
            <ul>
                <li><a href="javascript:;">关于我们</a></li>
                <li><a href="javascript:;">联系我们</a></li>
            </ul>
            <p>Copyright © 2016 易小厨、易小厨餐饮公司</p>
        </div>        
    </div>
</template>
<script>
import css_public from '../../../static/css/public.css';
    export default{
        components:{
            css_public
        },
        data(){
            return {
                css_public:{}
            }
        },
        ready(){
            this.css_public = css_public;
        }
    }
</script>
