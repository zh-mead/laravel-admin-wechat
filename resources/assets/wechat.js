require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// 传递事件
const $bus = new Vue
Vue.prototype.$bus = $bus
Vue.$bus = $bus

// 全局数据
const $global = new Vue({
    data() {
        return {
            currentMenu: {
                id: 0,
                pid: 0,
                name: '',
                type: 'click',
                data: '',
                url: '',
                kid: 0
            },
            currentMenuId: 0,
            currentMenuIndex: null,
            events:[],

            news: {
                items: [],
                page: 1,
                pages: [],
                bottom: false,
                total: 0,
            },

            // 素材的每页数，最大为20，先默认为 20，之后根据接口返回的设置
            materialPerPage: 20,

            image: {
                items: [],
                page: 1,
                pages: [],
                // 由于微信图片素材列表中，返回的总数没有参考意义，所以不能使用 total 来生成分页
                // 只能每次点击下一页，生成前面的页数选择，最后如果返回的集合为空，则标记为到底了
                bottom: false,
            },

            voice: {
                items: [],
                page: 1,
                pages: [],
                bottom: false,
                total: 0,
            },

            video: {
                items: [],
                page: 1,
                pages: [],
                bottom: false,
                total: 0,
            },
        }
    },
})
Vue.prototype.$global = $global
Vue.$global = $global

import iView from 'iview';
import 'iview/dist/styles/iview.css';
Vue.use(iView);

Vue.component('wechat-menus', require('./wechat/WechatMenus.vue'));

const app = new Vue({
    el: '#vue'
});