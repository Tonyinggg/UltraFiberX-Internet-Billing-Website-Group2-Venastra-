document.addEventListener("DOMContentLoaded", () => {
  // Philippine mobile number validation
  function validatePhilippineMobile(phone) {
    const cleaned = phone.replace(/[\s\-+]/g, "")
    return /^(09|639)\d{9}$/.test(cleaned)
  }

  // Email validation
  function validateEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)
  }

  // Add real-time validation to forms
  const forms = document.querySelectorAll("form")

  forms.forEach((form) => {
    const inputs = form.querySelectorAll("input[required], textarea[required], select[required]")

    inputs.forEach((input) => {
      // Create error message element
      const errorDiv = document.createElement("div")
      errorDiv.className = "field-error"
      errorDiv.style.color = "#dc3545"
      errorDiv.style.fontSize = "0.875rem"
      errorDiv.style.marginTop = "0.25rem"
      errorDiv.style.display = "none"
      input.parentNode.appendChild(errorDiv)

      // Validation on blur
      input.addEventListener("blur", () => {
        validateField(input, errorDiv)
      })

      // Clear error on focus
      input.addEventListener("focus", () => {
        errorDiv.style.display = "none"
        input.style.borderColor = "#ddd"
      })
    })

    // Form submission validation
    form.addEventListener("submit", (e) => {
      let isValid = true

      inputs.forEach((input) => {
        const errorDiv = input.parentNode.querySelector(".field-error")
        if (!validateField(input, errorDiv)) {
          isValid = false
        }
      })

      if (!isValid) {
        e.preventDefault()
        // Scroll to first error
        const firstError = form.querySelector('.field-error[style*="block"]')
        if (firstError) {
          firstError.scrollIntoView({ behavior: "smooth", block: "center" })
        }
      }
    })
  })

  function validateField(input, errorDiv) {
    const value = input.value.trim()
    let errorMessage = ""

    // Required field check
    if (input.hasAttribute("required") && !value) {
      errorMessage = `${getFieldLabel(input)} is required.`
    }
    // Email validation
    else if (input.type === "email" && value && !validateEmail(value)) {
      errorMessage = "Please enter a valid email address."
    }
    // Phone validation
    else if (input.name === "phone" && value && !validatePhilippineMobile(value)) {
      errorMessage = "Please enter a valid Philippine mobile number (09XXXXXXXXX)."
    }
    // Message length validation
    else if (input.name === "message" && value && value.length < 10) {
      errorMessage = "Message must be at least 10 characters long."
    }

    if (errorMessage) {
      errorDiv.textContent = errorMessage
      errorDiv.style.display = "block"
      input.style.borderColor = "#dc3545"
      return false
    } else {
      errorDiv.style.display = "none"
      input.style.borderColor = "#28a745"
      return true
    }
  }

  function getFieldLabel(input) {
    const label = input.parentNode.querySelector("label")
    if (label) {
      return label.textContent.replace(":", "").replace("*", "")
    }
    return input.name.charAt(0).toUpperCase() + input.name.slice(1)
  }

  // Phone number formatting
  const phoneInputs = document.querySelectorAll('input[name="phone"], input[name="alternatePhone"]')
  phoneInputs.forEach((input) => {
    input.addEventListener("input", function () {
      let value = this.value.replace(/\D/g, "")
      if (value.startsWith("63")) {
        value = "0" + value.substring(2)
      }
      if (value.length > 11) {
        value = value.substring(0, 11)
      }
      this.value = value
    })
  })
})
