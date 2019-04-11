<template>
    <div class="form-item" :class="classes">
        <span v-show="label" class="wechat-label">{{ label }}</span>
        <div class="wechat-content">
            <slot/>
            <span v-show="errorText" class="error-text">{{ errorText }}</span>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'FormItem',
        props: {
            inline: Boolean,
            label: [String, Number],
            errorText: String,
            hasError: Boolean,
            errorInside: Boolean,
        },
        created() {
            console.log(this.label)
        },
        computed: {
            classes() {
                return {
                    inline: this.inline,
                    'has-error': this.hasError,
                    'error-inside': this.errorInside,
                }
            },
        },
    }
</script>

<style scoped>
    #wechat-menu .form-item.inline .wechat-content {
        display: inline-block;
        vertical-align: middle;
        width: 350px;
        position: relative;
    }
</style>
