import '../css/addon.css';

import Ruby from './extensions/ruby.js';
import RubyButton from './components/RubyButton.vue';

Statamic.booting(() => {
    
    Statamic.$components.register('ruby-button', RubyButton);

    Statamic.$bard.addExtension(({ bard }) => Ruby.configure({ bard }));
    
    Statamic.$bard.buttons((buttons, button) => {
        return button({
            name: 'ruby',
            text: 'Ruby Text',
            html: '<svg viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xml:space="preserve" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2"><path d="M3.542 9.978h5.464v1.987H3.542V9.978Zm6.976 0h5.422v1.987h-5.422V9.978Zm5.422-1.231h-5.422V6.76h5.422v1.987Zm-6.934 0H3.542V6.76h5.464v1.987ZM.367 1.965v1.469h8.639V5.4H2.03v7.948h5.486c-1.339 1.706-3.844 3.239-7.516 4.6l.864 1.382c3.931-1.663 6.587-3.65 7.97-5.982h.172V20h1.512v-6.652h.152c1.598 2.419 4.341 4.384 8.228 5.874l.67-1.425c-3.412-1.08-5.939-2.549-7.538-4.449h5.421V5.4h-6.933V3.434h8.64V1.965h-8.64V0H9.006v1.965H.367Z" fill="currentColor" /></svg>',
            activeName: 'ruby',
            component: 'ruby-button'
        });
    });

});
