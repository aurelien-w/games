<template>
    <div class="notification is-size-7-touch" :class="[type, classes]" v-show="show">
        <button class="delete" @click="close" v-if="dismissable"></button>
        <slot>
            <div class="columns is-center-aligned is-mobile">
                <div class="column is-narrow">
                <span class="icon is-size-4-desktop is-size-6-touch" v-if="icon !== null">
                    <i :class="icon"></i>
                </span>
                </div>
                <div class="column">
                    <p>{{ message }}</p>
                </div>
            </div>
        </slot>
    </div>
</template>

<script>
    export default {
        name: 'Flash',
        props: {
            channel: { required: true },
            dismissable: { default: true },
            top: { },
            right: { },
            bottom: { },
            left: { },
            duration: { default: 3000 }
        },
        data () {
            return {
                message: '',
                show: false,
                type: null,
                icon: null,
                fixed: {
                    top: this.top !== undefined,
                    right: this.right !== undefined,
                    bottom: this.bottom !== undefined,
                    left: this.left !== undefined
                },
                timeout: this.duration
            }
        },
        computed: {
            /**
             * Determines if the notification should be fixed
             */
            isFixed () {
                return this.fixed.top || this.fixed.right || this.fixed.bottom || this.fixed.left
            },
            /**
             * Handles notification classes combinaison
             */
            classes () {
                return { 
                    'is-fixed': this.isFixed, 
                    'is-top': this.fixed.top, 
                    'is-right': this.fixed.right,
                    'is-bottom': this.fixed.bottom,
                    'is-left': this.fixed.left,
                }
            }
        },
        methods: {
            /**
             * Flashes the message
             */
            flash (payload) {
                for (let data in payload) {
                    this[data] = payload[data]
                }

                this.show = true

                if (this.timeout !== null) {
                    this.hide()
                }
            },
            /**
             * Hides the flash message
             */
            hide () {
                setTimeout(() => {
                    this.show = false
                }, this.timeout)
            },
            /**
             * Emits a close event
             * @param event
             */
            close (event = null) {
                this.$emit('close', event)
                this.show = false
            }
        },
        created () {
            window.Event.$on(this.channel, this.flash)
        }
    }
</script>