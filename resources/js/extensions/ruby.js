const { Mark, getMarkRange, getAttributes } = Statamic.$bard.tiptap.core;
const { Plugin, PluginKey, TextSelection } = Statamic.$bard.tiptap.pm.state;

const Ruby = Mark.create({

    name: 'ruby',

    parseHTML() {
        return [
            {
                tag: 'ruby',
                contentElement: 'span',
                getAttrs: element => ({
                    text: element.querySelector('rt').textContent,
                }),
            },
        ]
    },

    renderHTML({ mark }) {
        return [
            'ruby',
            {},
            ['span', {}, 0],
            ['rt', { contenteditable: false }, mark.attrs.text],
        ];
    },

    addAttributes() {
        return {
            text: {
                default: null,
            },
        }
    },

    addCommands() {
        return {
            toggleRuby: attributes => ({ commands }) => {
                if (attributes.text) {
                    return commands.setMark(this.name, attributes);
                } else {
                    return commands.unsetMark(this.name, { extendEmptyMarkRange: true });
                }
            },
        }
    },

    addProseMirrorPlugins() {
        const bard = this.options.bard;
        return [
            new Plugin({
                key: new PluginKey('eventHandler'),
                props: {
                    handleClick(view, pos) {
                        const { schema, doc, tr } = view.state;
                        const range = getMarkRange(doc.resolve(pos), schema.marks.ruby);

                        if (range) {
                            if (range.to === pos) return;

                            const $start = doc.resolve(range.from);
                            const $end = doc.resolve(range.to);
                            const selection = new TextSelection($start, $end);
                            const transaction = tr.setSelection(selection);
                            const attrs = getAttributes(view.state, schema.marks.ruby);

                            view.dispatch(transaction);
                            bard.$emit('ruby-selected', attrs);
                        } else {
                            bard.$emit('ruby-deselected');
                        }
                    },
                },
            }),
        ]
    },

});
export default Ruby;