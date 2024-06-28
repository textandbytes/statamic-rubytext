<template>

    <div class="bard-link-toolbar">

        <div class="px-4 py-4 border-b dark:border-dark-900">
            <div class="h-8 p-2 bg-gray-100 dark:bg-dark-600 text-gray-800 dark:text-dark-150 w-full border dark:border-dark-200 rounded shadow-inner placeholder:text-gray-600 dark:placeholder:dark-text-dark-175 flex items-center">
                <input
                    v-model="text"
                    type="text"
                    ref="textInput"
                    class="input h-auto text-sm"
                    :placeholder="__('Enter ruby text…')"
                    @keydown.enter.prevent="commit"
                />
            </div>
        </div>

        <footer class="bg-gray-100 dark:bg-dark-575 rounded-b-md flex items-center justify-end space-x-3 font-normal p-2">
            <button @click="$emit('canceled')" class="text-xs text-gray-600 dark:text-dark-175 hover:text-gray-800 dark:hover-text-dark-100">
                {{ __('Cancel') }}
            </button>
            <button @click="remove" class="btn btn-sm">
                {{ __('Remove') }}
            </button>
            <button @click="commit" class="btn btn-sm">
                {{ __('Apply') }}
            </button>
        </footer>

    </div>

</template>

<script>
export default {

    props: {
        bard: {},
        markAttrs: Object,
    },

    data() {
        return {
            text: null,
        }
    },

    created() {
        this.applyAttrs(this.markAttrs);
        this.bard.$on('ruby-selected', this.applyAttrs);
        this.bard.$on('ruby-deselected', () => this.$emit('deselected'));
    },

    mounted() {
        this.$nextTick(() => {
            setTimeout(() => {
                this.$refs.textInput.focus();
            }, 50);
        });
    },

    beforeDestroy() {
        this.bard.$off('ruby-selected');
        this.bard.$off('ruby-deselected');
    },

    methods: {

        applyAttrs(markAttrs) {
            this.text = markAttrs.text;
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
