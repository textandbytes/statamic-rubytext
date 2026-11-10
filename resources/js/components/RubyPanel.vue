<template>
    <div class="bard-link-toolbar">
        <div class="p-4">
            <Input
                ref="textInput"
                v-model="text"
                type="text"
                size="sm"
                :placeholder="__('Enter ruby text…')"
                @keydown.enter.prevent="commit"
            />
        </div>

        <footer class="flex items-center justify-end gap-2 border-t p-2">
            <Button size="sm" @click="$emit('canceled')">
                {{ __('Cancel') }}
            </Button>
            <Button size="sm" @click="remove">
                {{ __('Remove') }}
            </Button>
            <Button size="sm" variant="primary" @click="commit">
                {{ __('Apply') }}
            </Button>
        </footer>
    </div>
</template>

<script>
import { Button, Input } from '@statamic/cms/ui';

export default {

    components: { Button, Input },

    props: {
        bard: {},
        markAttrs: Object,
    },

    data() {
        return {
            text: null,
            rubySelectedHandler: null,
            rubyDeselectedHandler: null,
        }
    },

    created() {
        this.applyAttrs(this.markAttrs);
        this.rubySelectedHandler = attrs => this.applyAttrs(attrs);
        this.rubyDeselectedHandler = () => this.$emit('deselected');
        this.bard.events.on('ruby-selected', this.rubySelectedHandler);
        this.bard.events.on('ruby-deselected', this.rubyDeselectedHandler);
    },

    mounted() {
        this.$nextTick(() => {
            setTimeout(() => {
                this.$refs.textInput?.focus();
            }, 50);
        });
    },

    beforeUnmount() {
        this.bard.events.off('ruby-selected', this.rubySelectedHandler);
        this.bard.events.off('ruby-deselected', this.rubyDeselectedHandler);
    },

    methods: {

        applyAttrs(markAttrs) {
            this.text = markAttrs?.text ?? null;
        },

        remove() {
            this.$emit('updated', {
                text: null,
            });
        },

        commit() {
            this.$emit('updated', {
                text: this.text,
            });
        },

    }
}
</script>
