import Swiper, {
    Navigation, Pagination, Thumbs, EffectFade, Autoplay, FreeMode
} from 'swiper';

Swiper.use([Navigation, Pagination, Thumbs, EffectFade, Autoplay, FreeMode]);

let sliders = []
export {sliders}

export default class Slider {
    static reInit()
    {
        if (sliders) {
            sliders.forEach(slider => slider.destroy())
        }

        Slider.init()
    }

    static init()
    {
      // Added class for splide slides
        if (document.querySelectorAll('.swiper-wrapper')) {
            document.querySelectorAll('.swiper-wrapper > *').forEach(slide => slide.classList.add('swiper-slide'))
        }

      // Главный экран
      const banner = document.querySelector('.banner__wrapper')
      if (banner) {
        this.createSlider(banner, {
          slidesPerView: 1,
          spaceBetween: 0,
          allowTouchMove: false,
          loop: true,
          autoHeight: false,
          calculateHeight: false,
          speed: 1000,
          effect: 'fade',
          fadeEffect: {
            crossFade: false,
          },
          autoplay: {
            delay: 4000,
            disableOnInteraction: true,
            pauseOnMouseEnter: false
          },
          on: {
            init: () => {
              banner.classList.add('loaded')
            }
          }
        })
      }


// наши проекты с реальными фото
      const projects = document.querySelector('.projects__wrapper')
      if (projects) {
        this.createSlider(projects, {
          slidesPerView: 1,
          spaceBetween: 16,
          allowTouchMove: true,
          centeredSlides: false,
          loop: false,
          breakpoints: {
            360: {
              slidesPerView: 1.15,
              spaceBetween: 8,
            },
            450: {
              slidesPerView: 1.6,
              spaceBetween: 8,
            },
            767: {
              slidesPerView: 2,
              spaceBetween: 12,
            },
            900: {
              slidesPerView: 2.5,
              spaceBetween: 12,
            },
            1023: {
              slidesPerView: 3,
              spaceBetween: 12,
            },
            1200: {
              slidesPerView: 3,
              spaceBetween: 16,
            },
            1400: {
              slidesPerView: 4,
              spaceBetween: 16,
            }
          }
        })
      }


      // Популярные проекты
      const populars = document.querySelector('.populars__wrapper')
      if (populars) {
        this.createSlider(populars, {
          slidesPerView: 1,
          spaceBetween: 16,
          allowTouchMove: true,
          centeredSlides: false,
          loop: false,
          breakpoints: {
            320: {
              slidesPerView: 1.2,
              spaceBetween: 8,
            },
            500: {
              slidesPerView: 1.5,
              spaceBetween: 8,
            },
            600: {
              slidesPerView: 2,
              spaceBetween: 12,
            },
            1023: {
              slidesPerView: 3,
              spaceBetween: 12,
            },
            1200: {
              slidesPerView: 3,
              spaceBetween: 16,
            }
          }
        })
      }


      //как заказать
      const howToOrder = document.querySelector('.howToOrder');
      if (howToOrder) {
        this.createSlider(howToOrder, {
          slidesPerView: 1,
          spaceBetween: 16,
          allowTouchMove: true,
          loop: true,
          effect: 'fade',
          fadeEffect: {
            crossFade: false,
          },
          pagination: {
            el: ".swiper-pagination",
            clickable: true,
            renderBullet: function (index, className) {
              const bulletNumber = "0" + (index + 1);
              return '<div class="' + className + '"><div class="howToOrder__bulletNumber">' + bulletNumber + '</div>' + (index < this.slides.length - 1 ? "<span>-</span>" : "") + '</div>';
            },
          },
          autoplay: {
            delay: 3000,
          },
        });
      }


      //ПРОИЗВОДСТВО МЕБЕЛИ
      const furnitureManufacturing = document.querySelector('.furnitureManufacturing')
      if (furnitureManufacturing) {
        this.createSlider(furnitureManufacturing, {
          slidesPerView: 1,
          spaceBetween: 16,
          allowTouchMove: true,
          loop: true,
          effect: 'fade',
          fadeEffect: {
            crossFade: true,
          },
          pagination: {
            el: ".swiper-pagination2",
            clickable: true,
            renderBullet: function (index, className) {
              const bulletNumber2 = "0" + (index + 1);
              return '<div class="' + className + '"><div class="howToOrder__bulletNumber">' + bulletNumber2 + '</div>' + (index < this.slides.length - 1 ? "<span>-</span>" : "") + '</div>';
              // + "<span class='pagination__span'>-</span>";
            },
          },
          autoplay: {
            disableOnInteraction: true,
            pauseOnMouseEnter: false
          },
        })
      }


      //Отзывы
      const reviews = document.querySelector('.reviews__wrapper')
      if (reviews) {
        this.createSlider(reviews, {
          slidesPerView: 1,
          spaceBetween: 16,
          allowTouchMove: true,
          centeredSlides: false,
          loop: false,
          breakpoints: {
            320: {
              slidesPerView: 1.1,
              spaceBetween: 8,
            },
            424: {
              slidesPerView: 1.5,
              spaceBetween: 8,
            },
            600: {
              slidesPerView: 2,
              spaceBetween: 8,
            },
            767: {
              slidesPerView: 2.5,
              spaceBetween: 12,
            },
            1023: {
              slidesPerView: 3,
              spaceBetween: 16,
            },
            1300: {
              slidesPerView: 4,
              spaceBetween: 16,
            }
          }
        })
      }


      //ОСОБЕННОСТИ
      const features = document.querySelector('.features__container')
      if (features) {
        this.createSlider(features, {
          slidesPerView: 1,
          spaceBetween: 16,
          allowTouchMove: true,
          centeredSlides: false,
          loop: false,
          breakpoints: {
            320: {
              slidesPerView: 1.2,
              spaceBetween: 8,
            },
            425: {
              slidesPerView: 1.5,
              spaceBetween: 8,
            },
            550: {
              slidesPerView: 1.8,
              spaceBetween: 8,
            },
            767: {
              slidesPerView: 2.3,
              spaceBetween: 12,
            },
            1023: {
              slidesPerView: 3,
              spaceBetween: 16,
            },
            1200: {
              slidesPerView: 4,
              spaceBetween: 16,
            }
          }
        })
      }


      //Продукция похожие товары
      const relatedProducts = document.querySelector('.relatedProducts')
      if (relatedProducts) {
        this.createSlider(relatedProducts, {
          slidesPerView: 1,
          spaceBetween: 16,
          allowTouchMove: true,
          centeredSlides: false,
          loop: false,
          breakpoints: {
            320: {
              slidesPerView: 1.2,
              spaceBetween: 8,
            },
            425: {
              slidesPerView: 1.5,
              spaceBetween: 8,
            },
            550: {
              slidesPerView: 1.8,
              spaceBetween: 8,
            },
            767: {
              slidesPerView: 2.3,
              spaceBetween: 12,
            },
            1023: {
              slidesPerView: 3,
              spaceBetween: 16,
            },
            1200: {
              slidesPerView: 4,
              spaceBetween: 16,
            }
          }
        })
      }


      //Фотографии в интерьере
      const interior = document.querySelector('.interior__container')
      if (interior) {
        this.createSlider(interior, {
          slidesPerView: 1,
          spaceBetween: 16,
          allowTouchMove: true,
          centeredSlides: false,
          loop: false,
          breakpoints: {
            320: {
              slidesPerView: 1.2,
              spaceBetween: 8,
            },
            425: {
              slidesPerView: 1.5,
              spaceBetween: 8,
            },
            550: {
              slidesPerView: 1.8,
              spaceBetween: 8,
            },
            767: {
              slidesPerView: 2.3,
              spaceBetween: 12,
            },
            1023: {
              slidesPerView: 3,
              spaceBetween: 16,
            },
            1200: {
              slidesPerView: 3,
              spaceBetween: 16,
            }
          }
        })
      }


      //Слайдер продукция сингл
      const singleProduct = document.querySelector('.product__infoSlider')
      if (singleProduct) {
        this.createSlider(singleProduct, {
          slidesPerView: 1,
          spaceBetween: 0,
          allowTouchMove: true,
          centeredSlides: false,
          loop: false,
          pagination: {
            el: ".pagination__num",
            type: "fraction",
          },
        })
      }

      //Слайдер проекты все (Цикл слайдеров)
      const projectPopupSliders = document.querySelectorAll('.modal__wrapperProject')
      if (projectPopupSliders.length) {
        projectPopupSliders.forEach(projectPopupSlider => {
          this.createSlider(projectPopupSlider, {
            slidesPerView: 1,
            spaceBetween: 0,
            allowTouchMove: true,
            centeredSlides: false,
            loop: false,
            // pagination: {
            //   el: ".pagination__photos",
            //   type: "fraction",
            // },
          })
        })
      }


      const wrapperProjectMini = document.querySelectorAll('.modal__wrapperProject-mini')
      if (wrapperProjectMini.length) {
        wrapperProjectMini.forEach(slider => {
          this.createSlider(slider, {
            slidesPerView: 5,
            spaceBetween: 12,
            allowTouchMove: true,
            loop: false,
            autoHeight: false,
            calculateHeight: false,
          })
        })
      }



      //Рассчет стоимости
      const calcform = document.querySelector('.calc-form')
      if (calcform) {
        const calc = this.createSlider(calcform, {
          slidesPerView: 1,
          spaceBetween: 24,
          allowTouchMove: false,
          centeredSlides: false,
          loop: false,
          scrollbar: {
            el: '.swiper-scrollbar',
            draggable: true,
          },
        })

        calc.on('slideChange', function (_swiper) {
          if (_swiper.isEnd) {
            document.querySelector('[data-calc-next]').hidden = true
            document.querySelector('[data-calc-submit]').hidden = false
          } else {
            document.querySelector('[data-calc-next]').hidden = false
            document.querySelector('[data-calc-submit]').hidden = true
          }
        })
      }




    }

    static createSlider(parent, options)
    {
        const box = parent
        const swiper = box.querySelector('.swiper')

        if (swiper) {
          // Arrows
            const prev_arrow = box.querySelector('.slider__arrow--prev')
            const next_arrow = box.querySelector('.slider__arrow--next')

            if (prev_arrow || next_arrow) {
                options.navigation = {
                    prevEl: prev_arrow ? prev_arrow : null,
                    nextEl: next_arrow ? next_arrow : null,
                }
            }

          // Dotted
            const dotted = box.querySelector('.dotted')

            if (dotted) {
                options.pagination = {
                    el: dotted,
                    type: 'bullets',
                    clickable: true
                }
            }

          // Индикаторы
            const indicator = box.querySelector('.slider-indicator')

            if (indicator) {
                options.pagination = {
                    el: indicator,
                    type: 'fraction',
                }
            }

            let slider = new Swiper(swiper, options)

          // Переключатели
            const slider_toggle = swiper.closest('[data-slide-toggle]')

            if (slider_toggle) {
                const slider_togglers = slider_toggle.querySelectorAll('[data-slide-target]')

                if (slider_togglers) {
                    slider_togglers.forEach(slide => {
                                slide.addEventListener('click', (e) => {
                                    slider_togglers.forEach(slide_ => slide_.classList.remove('active'))
                                    slide.classList.add('active')

                                    const target = parseInt(slide.dataset.slideTarget)
                                    slider.slideTo(target)
                                                })
                    })
                }
            }

            sliders.push(slider)

            return slider
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    Slider.init()
})
