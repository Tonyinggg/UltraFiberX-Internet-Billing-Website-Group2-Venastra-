class HeroCarousel {
  constructor() {
    this.currentSlide = 0
    this.slides = document.querySelectorAll(".carousel-slide")
    this.indicators = document.querySelectorAll(".indicator")
    this.prevBtn = document.querySelector(".carousel-prev")
    this.nextBtn = document.querySelector(".carousel-next")
    this.autoPlayInterval = null
    this.isTransitioning = false
    this.autoPlayDelay = 6000 // 6 seconds for better advertisement viewing

    this.init()
  }

  init() {
    if (!this.slides.length) return

    // Event listeners
    this.prevBtn?.addEventListener("click", () => this.prevSlide())
    this.nextBtn?.addEventListener("click", () => this.nextSlide())

    this.indicators.forEach((indicator, index) => {
      indicator.addEventListener("click", () => this.goToSlide(index))
    })

    // Touch/swipe support for mobile
    this.addTouchSupport()

    // Keyboard navigation
    document.addEventListener("keydown", (e) => {
      if (e.key === "ArrowLeft") this.prevSlide()
      if (e.key === "ArrowRight") this.nextSlide()
    })

    // Auto-play controls
    this.startAutoPlay()

    const carousel = document.querySelector(".hero-carousel")
    carousel?.addEventListener("mouseenter", () => this.stopAutoPlay())
    carousel?.addEventListener("mouseleave", () => this.startAutoPlay())

    // Pause on focus for accessibility
    carousel?.addEventListener("focusin", () => this.stopAutoPlay())
    carousel?.addEventListener("focusout", () => this.startAutoPlay())

    // Intersection Observer for performance
    this.setupIntersectionObserver()
  }

  addTouchSupport() {
    const carousel = document.querySelector(".carousel-container")
    let startX = 0
    let endX = 0

    carousel?.addEventListener(
      "touchstart",
      (e) => {
        startX = e.touches[0].clientX
      },
      { passive: true },
    )

    carousel?.addEventListener(
      "touchend",
      (e) => {
        endX = e.changedTouches[0].clientX
        const diff = startX - endX

        if (Math.abs(diff) > 50) {
          // Minimum swipe distance
          if (diff > 0) {
            this.nextSlide()
          } else {
            this.prevSlide()
          }
        }
      },
      { passive: true },
    )
  }

  setupIntersectionObserver() {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            this.startAutoPlay()
          } else {
            this.stopAutoPlay()
          }
        })
      },
      { threshold: 0.5 },
    )

    const carousel = document.querySelector(".hero-carousel")
    if (carousel) observer.observe(carousel)
  }

  goToSlide(slideIndex) {
    if (this.isTransitioning || slideIndex === this.currentSlide) return

    this.isTransitioning = true

    // Update classes
    this.slides[this.currentSlide].classList.remove("active")
    this.indicators[this.currentSlide].classList.remove("active")

    this.currentSlide = slideIndex

    this.slides[this.currentSlide].classList.add("active")
    this.indicators[this.currentSlide].classList.add("active")

    // Reset transition lock
    setTimeout(() => {
      this.isTransitioning = false
    }, 800)
  }

  nextSlide() {
    const nextIndex = (this.currentSlide + 1) % this.slides.length
    this.goToSlide(nextIndex)
  }

  prevSlide() {
    const prevIndex = (this.currentSlide - 1 + this.slides.length) % this.slides.length
    this.goToSlide(prevIndex)
  }

  startAutoPlay() {
    this.stopAutoPlay() // Clear any existing interval
    this.autoPlayInterval = setInterval(() => {
      this.nextSlide()
    }, this.autoPlayDelay)
  }

  stopAutoPlay() {
    if (this.autoPlayInterval) {
      clearInterval(this.autoPlayInterval)
      this.autoPlayInterval = null
    }
  }

  // Public method to destroy carousel
  destroy() {
    this.stopAutoPlay()
    // Remove event listeners if needed
  }
}

// Initialize carousel when DOM is ready
document.addEventListener("DOMContentLoaded", () => {
  new HeroCarousel()
})

// Export for potential module use
if (typeof module !== "undefined" && module.exports) {
  module.exports = HeroCarousel
}
