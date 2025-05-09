document.addEventListener("DOMContentLoaded", () => {
    // Form validation
    const contactForm = document.getElementById("contactForm")
    const successMessage = document.getElementById("successMessage")
    const sendAnotherBtn = document.getElementById("sendAnotherBtn")
  
    if (contactForm) {
      contactForm.addEventListener("submit", function (e) {
        e.preventDefault()
  
        if (validateForm()) {
          // Show loading state
          const submitBtn = this.querySelector(".submit-btn")
          submitBtn.classList.add("loading")
  
          // Simulate form submission (replace with actual form submission)
          setTimeout(() => {
            submitBtn.classList.remove("loading")
  
            // Show success message
            successMessage.classList.add("show")
  
            // Reset form
            contactForm.reset()
          }, 1500)
        }
      })
    }
  
    // Send another message button
    if (sendAnotherBtn) {
      sendAnotherBtn.addEventListener("click", () => {
        successMessage.classList.remove("show")
      })
    }
  
    // FAQ accordion
    const faqItems = document.querySelectorAll(".faq-item")
  
    faqItems.forEach((item) => {
      const question = item.querySelector(".faq-question")
  
      question.addEventListener("click", () => {
        // Close all other items
        faqItems.forEach((otherItem) => {
          if (otherItem !== item && otherItem.classList.contains("active")) {
            otherItem.classList.remove("active")
            const icon = otherItem.querySelector(".toggle-icon i")
            icon.className = "fa fa-plus"
          }
        })
  
        // Toggle current item
        item.classList.toggle("active")
        const icon = item.querySelector(".toggle-icon i")
  
        if (item.classList.contains("active")) {
          icon.className = "fa fa-minus"
        } else {
          icon.className = "fa fa-plus"
        }
      })
    })
  
    // Form validation function
    function validateForm() {
      let isValid = true
      const requiredFields = contactForm.querySelectorAll("[required]")
  
      // Reset all errors
      contactForm.querySelectorAll(".form-group").forEach((group) => {
        group.classList.remove("error")
      })
  
      // Check each required field
      requiredFields.forEach((field) => {
        const formGroup = field.closest(".form-group")
  
        // Check if empty
        if (!field.value.trim()) {
          formGroup.classList.add("error")
          isValid = false
        }
  
        // Email validation
        if (field.type === "email" && !validateEmail(field.value)) {
          formGroup.classList.add("error")
          isValid = false
        }
  
        // Checkbox validation
        if (field.type === "checkbox" && !field.checked) {
          formGroup.classList.add("error")
          isValid = false
        }
      })
  
      // If form is invalid, add shake animation
      if (!isValid) {
        contactForm.classList.add("shake")
        setTimeout(() => {
          contactForm.classList.remove("shake")
        }, 500)
  
        // Focus on first invalid field
        const firstInvalidField = contactForm.querySelector(".form-group.error input, .form-group.error textarea")
        if (firstInvalidField) {
          firstInvalidField.focus()
        }
      }
  
      return isValid
    }
  
    // Email validation helper
    function validateEmail(email) {
      const re =
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      return re.test(String(email).toLowerCase())
    }
  
    // Animate elements when they come into view
    const animateOnScroll = () => {
      const elements = document.querySelectorAll(".info-card, .faq-item")
  
      elements.forEach((element) => {
        const elementPosition = element.getBoundingClientRect().top
        const windowHeight = window.innerHeight
  
        if (elementPosition < windowHeight - 50) {
          element.style.opacity = "1"
          element.style.transform = "translateY(0)"
        }
      })
    }
  
    // Run once on page load
    setTimeout(animateOnScroll, 100)
  
    // Run on scroll
    window.addEventListener("scroll", animateOnScroll)
  
    // Add hover effect to form inputs
    const formInputs = document.querySelectorAll(".input-container input, .input-container textarea")
  
    formInputs.forEach((input) => {
      input.addEventListener("focus", function () {
        this.parentElement.classList.add("focused")
      })
  
      input.addEventListener("blur", function () {
        this.parentElement.classList.remove("focused")
      })
    })
  })
  