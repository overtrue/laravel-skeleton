<template>
    <transition name="modal">
        <div class="modal modal-mask" style="display: block" @click="close">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" v-if="$slots.header">
                        <slot name="header"></slot>
                    </div>

                    <div class="modal-body">
                        <slot></slot>
                    </div>

                    <div class="modal-footer" v-if="$slots.footer">
                        <slot name="footer"></slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
  import { mixin as clickaway } from 'vue-clickaway'

  export default {
    mixins: [clickaway],
    methods: {
      close () {
        this.$emit('close')
      },
    },
  }
</script>

<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }
</style>