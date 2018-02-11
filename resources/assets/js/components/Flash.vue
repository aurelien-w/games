<template>
    <div class="notification is-size-7-touch" :class="classes" v-show="show">
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
             * Handles notification classes combinaison
             */
            classes () {
                let classes = ''

                if (this.type !== null) classes += ` ${this.type}`

                if (this.fixed.top || this.fixed.right || this.fixed.bottom || this.fixed.left) {
                    classes  += ` is-fixed`

                    if (this.fixed.top) classes    += ` is-top`
                    if (this.fixed.right) classes  += ` is-right`
                    if (this.fixed.bottom) classes += ` is-bottom`
                    if (this.fixed.left) classes   += ` is-left`
                }

                return classes
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