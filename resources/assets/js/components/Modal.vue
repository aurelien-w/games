<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div class="modal-content">
            <slot></slot>
        </div>
        <button class="modal-close is-large" aria-label="close" @click="close"></button>
    </div>
</template>

<script>
    export default {
        name: 'Modal',
        methods: {
            /**
             * Close event
             * @param event
             */
            close (event = null) {
                this.$emit('close', event)
            }
        }
    }
</script>