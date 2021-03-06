<template>
    <div v-if="add" class="menu add" :style="{ width: `${menuWidth}%` }">
        <span class="name">+</span>
    </div>

    <div v-else class="menu" :style="{ width: `${menuWidth}%` }">
        <span class="name" :class="{ active }" @click="onActive">{{ menu.name }}</span>
        <div v-if="isParent" v-show="showSub" class="sub-menus" :style="subMenusStyles">
            <draggable v-model="subMenus" :options="{ group: `${menu.id}-subMenus` }">
                <menu-item v-for="(subMenu, subIndex) of subMenus" :index="subIndex" :menu="subMenu" :key="subMenu.id"
                           :deep-index="`${deepIndex}-${subIndex}`"></menu-item>
                <menu-item v-if="!subIsMaximum" add @click.native="onAddSubMenu(index)"></menu-item>
            </draggable>
            <div class="arrow-down"></div>
        </div>
    </div>
</template>

<script>
    import {MAX_SUB_COUNT, MENU_HEIGHT, SUB_MENUS_OFFSET} from './common/constants'
    import Draggable from 'vuedraggable'

    export default {
        name: 'MenuItem',
        components: {
            Draggable,
        },
        data() {
            return {
                active: false,
            }
        },
        props: {
            add: Boolean,
            menu: Object,
            menuWidth: Number,
            index: Number,
            isParent: Boolean,
            deepIndex: String,
        },
        computed: {
            subMenus() {
                // if (!this.menu.hasOwnProperty('sub_button')) return []
                return this.menu.sub_button
            },
            subIsMaximum() {
                return this.subMenus.length == MAX_SUB_COUNT
            },
            subsCount() {
                const count = this.subMenus.length
                if (this.subIsMaximum || (count == (MAX_SUB_COUNT - 1))) {
                    return MAX_SUB_COUNT
                } else {
                    return count + 1
                }
            },
            subMenusStyles() {
                const top = -(this.subsCount * MENU_HEIGHT + SUB_MENUS_OFFSET) + 'px'
                return {
                    top,
                }
            },
            showSub() {
                return this.active || this.anySubActive
            },
            anySubActive() {
                return this.subMenus.indexOf(this.$global.currentMenu) !== -1
            },
        },
        mounted() {
            !this.add && this.$bus.$on('menuActive', this.onOtherActivated)
        },
        beforeDestroy() {
            this.$bus.$off('menuActive', this.onOtherActivated)
        },
        methods: {
            onActive() {
                console.log(this.menu,3)
                this.$bus.$emit('menuActive', this.menu)
            },
            onAddSubMenu(parentIndex) {
               this.$bus.$emit('addSubMenu', parentIndex)
            },
            onOtherActivated(menu) {
                if (this.menu === menu) {
                    this.active = true
                    this.$global.currentMenu = this.menu
                    this.$global.currentMenuIndex = this.deepIndex
                    this.$global.currentMenuId = this.menu.id
                } else {
                    this.active = false
                }
            },
        },
    }
</script>

<style scoped lang="scss">
    .menu {
        flex-grow: 1;
        text-align: center;
        color: #969696;
        border-left: 1px solid #e7e7eb;
        position: relative;
        height: 50px;
        &:first-child {
            border-left: none;
        }
        &.add .name {
            font-size: 35px !important;
            font-weight: 100;
            cursor: pointer;
        }
    }

    .sub-menus {
        top: 60px;
        position: absolute;
        width: 100%;
        .menu {
            border: 1px solid #e7e7eb;
            border-top: none;
            &:first-child {
                border-top: 1px solid #e7e7eb;
            }
        }
    }

    .name {
        display: block;
        word-break: keep-all;
        overflow: hidden;
        height: 50px;
        line-height: 48px;
        cursor: move;
        &:hover {
            color: #000;
        }
        &.active {
            border: 2px solid #44b549;
            line-height: 44px;
            color: #44b549;
        }
    }

    .arrow-down {
        position: absolute;
        bottom: -6px;
        left: 45%;
        display: inline-block;
        width: 0;
        height: 0;
        border-width: 6px;
        border-style: dashed;
        border-color: transparent;
        border-bottom-width: 0;
        border-top-color: #d0d0d0;
        border-top-style: solid;
    }

    .sortable-ghost > .name {
        transform: scale(1.2);
        background: #efefef;
    }
</style>