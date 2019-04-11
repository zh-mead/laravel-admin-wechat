<template>
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">编辑</h3>
            <div class="box-tools">
                <div class="btn-group pull-right" style="margin-right: 5px">
                    <a href="javascript:void(0);" @click="del" class="btn btn-sm btn-danger" title="删除">
                        <i class="fa fa-trash"></i>
                        <span class="hidden-xs">删除</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- {{$global.currentMenu}} -->
         <Form ref="menu" action="/admin/wechat/menus"  method="post" :model="menu"  :rules="ruleValidate" :label-width="100" >
            <div class="box-body" >
                <div class="fields-group">
                    <input type="hidden" name='id' :value="menu.kid"/>
                    <input type="hidden" name='pid' :value="menu.pid"/>

                     <FormItem label="菜单名称" prop="name">
                        <Input v-model="$global.currentMenu.name" name='name' placeholder="请填写菜单名称"/>
                     </FormItem>
                    <FormItem label="菜单类型" prop="type">
                        <Select v-model="$global.currentMenu.type" name="type">
                            <Option v-for="(name, index) in menuTypes" :value="index" :key="index">{{name}}</Option>
                        </Select>
                    </FormItem>
                    <FormItem  v-if="menu.type === 'view'" label="菜单内容" prop="url">
                         <Input name="data" v-model="$global.currentMenu.url" type="textarea" placeholder="请填写url"/>
                    </FormItem>
                    <FormItem   label="菜单内容" prop="data"  v-else>
                        <Select v-model="menu.data" name="key">
                           <Option v-for="(name, index) in $global.events" :value="index" :key="index">{{name}}</Option>
                        </Select>
                    </FormItem>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <div class="col-md-2"></div>
                <div class="col-md-8" style="text-align: center;">
                    <div class="btn-group">
                        <button type="button" @click="save('menu')" class="btn btn-primary">提交</button>
                    </div>
                </div>
            </div>
         </Form>
            <!-- /.box-footer -->
    
    </div>
</template>
<script>
    import {MENU_TYPES} from "../common/constants";
    
    export default {
        name: "EditMenu",
        methods: {
            del(){
                let that = this
                if(!this.menu.kid){
                    this.$Notice.config({
                        top: 100,
                    })
                    this.$Notice.warning({
                       title: '请先选择要删除的菜单'
                    })
                    return false
                }
                this.$Modal.confirm({
                    title: '删除提醒',
                    content: '您确认要删除菜单【'+this.menu.name+'】吗？',
                    onOk: () => {
                        location.href = '/admin/wechat/menus/'+that.menu.kid
                    }
                })
            },
            save(name){
                // console.log(this.$global.currentMenu)
                // return false
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        $('form').submit()
                    } else {
                        this.$Message.error('Fail!');
                    }
                })
            }
        },
        components: {},
        data() {
            const validateData = (rule, value, callback) => {
                if(value == '') return callback(new Error("菜单内容不能为空"))
                if(this.menu.type === 'view') {
                    let ru = /^((ht|f)tps?):\/\/([\w\-]+(\.[\w\-]+)*\/)*[\w\-]+(\.[\w\-]+)*\/?(\?([\w\-\.,@?^=%&:\/~\+#]*)+)?/
                    let f = ru.test(value)
                    if(f)return callback()
                    return callback(new Error("菜单内容URL格式不对"))
                } else {
                    if(value) return callback()
                    return callback(new Error("请选择事件"))
                }
            }
            return {
                initMenu: {
                    id: 0,
                    pid: 0,
                    name: '',
                    type: 'click',
                    data: ''
                },
                ruleValidate: {
                    name: [
                        { required: true, message: 'The name cannot be empty', trigger: 'blur' }
                    ],
                    type: [
                        { required: true, message: 'The name cannot be empty', trigger: 'change' }
                    ],
                    url: [
                        { validator: validateData, trigger: 'change' }
                    ],
                    data: [
                        { validator: validateData, trigger: 'change' }
                    ]
                }
            };
        },
        props: {
            menus: {
                type: Array,
                default: () => []
            },
            menuAutoId: Number
        },
        mounted() {
        },
        computed: {
            menuTypes() {
                return MENU_TYPES;
            },
            menu(){
                let c_data
                if(!this.$global.currentMenuIndex) {
                    c_data = this.initMenu
                }else{
                    let arr = this.$global.currentMenuIndex.split('-')
                    if(arr.length === 1){
                        c_data = this.menus[arr[0]]
                    }else if(arr.length === 2){
                        c_data = this.menus[arr[0]]['sub_button'][arr[1]]
                    }
                    if(c_data.type === 'view'){
                        c_data.url = c_data.data
                    }
                }
                this.cMenu = c_data
                return c_data
            }
        }
    };
</script>
<style lang="scss">
    .btn {
        font-size: 12px !important;
        & * {
            font-size: 12px !important;
        }
    }
</style>
