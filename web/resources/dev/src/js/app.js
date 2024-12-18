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

  // Отзывы

    const reviewDescs = document.querySelectorAll('.reviews__descr');

    reviewDescs.forEach((desc, i) => {
      if (desc.offsetHeight > 184) {
        desc.style.height = '184px';
        desc.style.overflow = 'hidden';
        const readMoreButton = document.createElement('button');
        readMoreButton.textContent = 'Читать целиком';
        readMoreButton.classList.add('Control_M');
        readMoreButton.classList.add('text-caption');
        readMoreButton.classList.add('reviews__show');
        readMoreButton.setAttribute('data-modal', 'client');
        desc.parentNode.insertBefore(readMoreButton, desc.nextSibling);

        readMoreButton.addEventListener('click', () => {
          const modal = document.querySelector('.modal[data-modal-type="client"]');
          const modalContent = modal.querySelector('.modal__wrapper');
          modalContent.innerHTML = desc.innerHTML + `<button class="modal__close modal__close--fixed" type="button">
    </button>`;
          modal.hidden = false;
        });
      }
    });


// Конец отзывы

//seo

  const seoWrapper = document.querySelector('.seo__wrapper');
  const button = document.querySelector('.seo__button');
  const pic = document.querySelector('.seo__buttonUp');

  if (seoWrapper) {


    // Установите желаемую высоту для скрытия текста
    const maxHeight = 208; // Задайте значение высоты в пикселях

    const checkContentHeight = () => {
      if (seoWrapper.scrollHeight > maxHeight) {
        seoWrapper.style.overflow = 'hidden';
        seoWrapper.style.maxHeight = maxHeight + 'px';
        button.style.display = 'flex';
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
        button.innerHTML = `Показать еще<svg class="buttonUp" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M20 7.5L21 9L11.9999 18L3 9L4 7.5L12 15.5L20 7.5Z" fill="#0C0C0C"/>
        </svg>`;
      } else {
        seoWrapper.style.overflow = 'visible';
        seoWrapper.style.maxHeight = 'none';
        button.setAttribute('data-expanded', 'true');
        button.innerHTML = `Скрыть<svg class="seo__buttonUp rotate" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M20 7.5L21 9L11.9999 18L3 9L4 7.5L12 15.5L20 7.5Z" fill="#0C0C0C"/>
        </svg>`;
      }
    });
    // Проверяем высоту контента при загрузке страницы
    checkContentHeight();

  }
  //endSeo

    //LoaderStart

    const bannerLoader = document.getElementById('bannerLoader');
  if (bannerLoader) {
    bannerLoader.style.opacity = 0;
    setTimeout(function () {
      bannerLoader.remove();
    }, 300);
  }



    const bannerLoader2 = document.getElementById('bannerLoader2');
  if(bannerLoader2){
    bannerLoader2.style.opacity = 0;
    setTimeout(function () {
      bannerLoader2.remove();
    }, 300);
  }


    //end




    // фильтр
    const customSelect = document.querySelector(".custom-select");
    const selectBtn = document.querySelectorAll(".select-button");

    const selectedValue = document.querySelector(".selected-value");
    const optionsList = document.querySelectorAll(".select-dropdown li");

// add click event to select button
    selectBtn.forEach(item=> {
      item.addEventListener("click", () => {
        // add/remove active class on the container element
        customSelect.classList.toggle("active");
        // update the aria-expanded attribute based on the current state
        selectBtn.setAttribute(
          "aria-expanded",
          selectBtn.getAttribute("aria-expanded") === "true" ? "false" : "true"
        );
      });
    })

    optionsList.forEach((option) => {
      function handler(e) {
        // Click Events
        if (e.type === "click" && e.clientX !== 0 && e.clientY !== 0) {
          selectedValue.textContent = this.children[1].textContent;
          customSelect.classList.remove("active");
        }
        // Key Events
        if (e.key === "Enter") {
          selectedValue.textContent = this.textContent;
          customSelect.classList.remove("active");
        }
      }

      option.addEventListener("keyup", handler);
      option.addEventListener("click", handler);
    });

    // конец




  });
