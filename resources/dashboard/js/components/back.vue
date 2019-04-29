<template>
    <div @click="$router.go(steps * -1)" class="d-inline-block">
        <slot>
            <el-button plain><o-icon name="arrow-left" /> 返回</el-button>
        </slot>
    </div>
</template>

<script>
    export default {
        props: {
            steps: {
                type: Number,
                default: 1
            }
        }
    }
</script>
