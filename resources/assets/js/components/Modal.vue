<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div class="modal-content">
            <slot></slot>
        </div>
        <button class="modal-close is-large" aria-label="close" @click="onClose" v-if="close"></button>
    </div>
</template>

<script>
    export default {
        name: 'Modal',
        props: {
            close: { default: true }
        },
        methods: {
            /**
             * Close event
             * @param event
             */
            onClose (event = null) {
                this.$emit('close', event)
            }
        }
    }
</script>