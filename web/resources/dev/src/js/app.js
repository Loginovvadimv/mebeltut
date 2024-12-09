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


  const reviewDescs = document.querySelectorAll('.reviews__descr');

  reviewDescs.forEach(desc => {
    if (desc.offsetHeight > 184) {
      // Создаем кнопку "Читать целиком"
      const readMoreButton = document.createElement('button');
      readMoreButton.textContent = 'Читать целиком';
      readMoreButton.classList.add('Control_M');
      readMoreButton.classList.add('text-caption');
      readMoreButton.setAttribute('data-modal', 'client');
      desc.parentNode.insertBefore(readMoreButton, desc.nextSibling);

      readMoreButton.addEventListener('click', function() {
        // Открываем модальное окно с содержимым текущего описания
        const modal = document.querySelector('.modal[data-modal-type="client"]');
        modal.hidden = false;
      });
    }
  });



//seo

  const seoWrapper = document.querySelector('.seo__wrapper');
  const button = document.querySelector('.seo__button');

  if (seoWrapper) {


    // Установите желаемую высоту для скрытия текста
    const maxHeight = 208; // Задайте значение высоты в пикселях

    const checkContentHeight = () => {
      if (seoWrapper.scrollHeight > maxHeight) {
        seoWrapper.style.overflow = 'hidden';
        seoWrapper.style.maxHeight = maxHeight + 'px';
        button.style.display = 'block';
      } else {
        button.style.display = 'none';
      }
    };

    button.addEventListener('click', () => {
      const expanded = button.getAttribute('data-expanded') === 'true';
      if (expanded) {
        seoWrapper.style.overflow = 'hidden';
        seoWrapper.style.maxHeight = maxHeight + 'px';
        button.setAttribute('data-expanded', 'false');
        button.textContent = 'Показать полностью';
      } else {
        seoWrapper.style.overflow = 'visible';
        seoWrapper.style.maxHeight = 'none';
        button.setAttribute('data-expanded', 'true');
        button.textContent = 'Скрыть';
      }
    });
    // Проверяем высоту контента при загрузке страницы
    checkContentHeight();

  }
  //endSeo




});
