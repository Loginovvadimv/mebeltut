import './classes/Modal.js'
import './classes/Select.js'
import './classes/Fancybox.js'
import './classes/Mask.js'
import './classes/Slider.js'
import './classes/Alert.js'
import './classes/Tabs.js'
import './classes/SetSizes.js'
import './classes/CookieAccept.js'
import './classes/ToTop.js'
import './classes/Rating.js'
import './classes/ReviewForm.js'
import './classes/Form.js'

import './classes/Hover3D.js'
import './classes/Inputer.js'

import Alpine from 'alpinejs'

Alpine.data('page', () => ({
    isDevice: '',
    isBackdrop: false,
    screenSize: window.innerWidth,
    breakpoints: {
        xs: 640,
        mobile: 768,
        tablet: 1024,
        desktop: 5000,
    },

    getDevice() {
        for (let key in this.breakpoints) {
            if (this.screenSize < this.breakpoints[key]) {
                this.isDevice = key;
                break;
            }
        }
    },

    init() {
        this.getDevice();
        window.addEventListener('resize', (e) => {
            this.screenSize = window.innerWidth;
            this.getDevice();
        })


    }
}))

Alpine.start();

document.addEventListener('DOMContentLoaded', function() {

})
