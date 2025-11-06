document.addEventListener("DOMContentLoaded", () => {
  const mobileToggle = document.querySelector(".mobile-menu-toggle")
  const navMenu = document.querySelector(".nav-menu")

  if (mobileToggle && navMenu) {
    mobileToggle.addEventListener("click", () => {
      navMenu.classList.toggle("active")

      // Update aria-expanded for accessibility
      const isExpanded = navMenu.classList.contains("active")
      mobileToggle.setAttribute("aria-expanded", isExpanded)

      // Change icon
      mobileToggle.textContent = isExpanded ? "✕" : "☰"
    })

    // Close menu when clicking outside
    document.addEventListener("click", (e) => {
      if (!mobileToggle.contains(e.target) && !navMenu.contains(e.target)) {
        navMenu.classList.remove("active")
        mobileToggle.setAttribute("aria-expanded", "false")
        mobileToggle.textContent = "☰"
      }
    })

    // Close menu when window is resized to desktop
    window.addEventListener("resize", () => {
      if (window.innerWidth > 768) {
        navMenu.classList.remove("active")
        mobileToggle.setAttribute("aria-expanded", "false")
        mobileToggle.textContent = "☰"
      }
    })
  }
})
