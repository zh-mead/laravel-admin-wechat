<template>
    <div class="menus-editor">
        <div class="edit-area">
            <div class="preview">
                <div class="header">
                    <span class="text">公众号</span>
                </div>
                <menus :menus.sync="menus" :menu-auto-id.sync="menuAutoId"></menus>
            </div>
            <div class="col-md-9" style="min-width: 500px;">
                <edit-menu :menus.sync="menus" :types="types" :news="news"></edit-menu>
            </div>

        </div>

        <div class="footer-toolbar">
            <button class="btn btn-primary" @click="sync">同步微信
            </button>
        </div>


    </div>
</template>

<script>
    import Menus from './Menus'
    import EditMenu from './EditMenu'

    export default {
        name: 'MenusEditor',
        props: ['menus', 'events', 'types','news'],
        components: {
            Menus,
            EditMenu
        },
        data() {
            return {
                menuAutoId: 100,
                canSave: false,
                emptyMenus: '报销',
            }
        },
        computed: {},
        created() {
            this.$global.events = this.events
        },
        destroyed() {
            // 该组件销毁后，清除全局数据中的，关于当前激活菜单的值
        },
        methods: {
            sync() {
                location.href = '/admin/wechat/menus/sync'
            }
        },
    }
</script>

<style scoped lang="scss">
    $main-color: #44b549;
    $hint-color: #8d8d8d;
    $grey: #e7e7eb;
    $grey-1: #8d8d8d;
    $grey-border: 1px solid $grey;
    $danger-color: #f86161;
    $page-width: 1200px;

    $preview-width: 300px;
    $margin-right: 20px;
    $form-width: $page-width - $margin-right - $preview-width;
    .edit-area {
        height: 500px;
        display: flex;
    }

    .preview {
        min-width: $preview-width;
        width: 100%;
        max-width: 350px;
        margin-right: $margin-right;
        border: $grey-border;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background-color: #fff;
        .header {
            height: 50px;
            background: #3a3a3e;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    }

    .form {
        padding: 0 20px;
        border: $grey-border;
        width: $form-width;
        background-color: #f4f5f9;
        .header {
            height: 40px;
            line-height: 40px;
            border-bottom: $grey-border;
            border-width: 2px;
            margin-bottom: 20px;
        }
        .content-wrapper {
            border: $grey-border;
            background-color: #fff;
            padding: 20px;
            margin-top: 20px;
        }
    }

    .choose-hint {
        width: $form-width;
        text-align: center;
        line-height: 600px;
        color: $hint-color;
    }

    .name-item {
        margin-top: 30px;
    }

    .footer-toolbar {
        border: none !important;
    }
</style>