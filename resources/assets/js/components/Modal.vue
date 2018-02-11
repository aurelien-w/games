<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div class="modal-content">
            <slot></slot>
        </div>
        <button class="modal-close is-large" aria-label="close" @click="close" v-if="dismissable"></button>
    </div>
</template>

<script>
    export default {
        name: 'Modal',
        props: {
            dismissable: { default: true }
        },
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