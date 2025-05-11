document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const loginTab = document.getElementById("login-tab")
    const registerTab = document.getElementById("register-tab")
    const loginForm = document.getElementById("login-form")
    const registerForm = document.getElementById("register-form")
    const userTypeContainer = document.getElementById("user-type-container")
    const loginContainer = document.querySelector(".login-container")
    const imageContainer = document.querySelector(".image-container")
    const profileUpload = document.getElementById("profile-upload")
    const profilePreview = document.getElementById("profile-preview")
    const profilePreviewLarge = document.getElementById("profile-preview-large")
    const profilePlaceholder = document.querySelector(".profile-placeholder")
    const profilePlaceholderLarge = document.querySelector(".image-placeholder .profile-placeholder")
    const imageEditorControls = document.querySelector(".image-editor-controls")
    const zoomSlider = document.getElementById("zoom-slider")
    const zoomValue = document.getElementById("zoom-value")
    const rotateSlider = document.getElementById("rotate-slider")
    const rotateValue = document.getElementById("rotate-value")
    const decreaseExpBtn = document.getElementById("decrease-exp")
    const increaseExpBtn = document.getElementById("increase-exp")
    const expValue = document.getElementById("exp-value")
    const specialtyInput = document.getElementById("specialty-input")
    const addSpecialtyBtn = document.getElementById("add-specialty-btn")
    const specialtyTags = document.querySelector(".specialty-tags")
    const tabSlider = document.querySelector(".tab-slider")
    const closeBtn = document.getElementById("close-btn")
  
    // By default, show register form first
    registerTab.classList.add("active")
    loginTab.classList.remove("active")
    loginContainer.classList.remove("login-mode")
    loginContainer.classList.add("register-mode")
    tabSlider.classList.add("register")
    registerForm.style.display = "block"
    loginForm.style.display = "none"
  
    // Animate form elements on load
    animateFormElements()
  
    // Close button functionality
    if (closeBtn) {
      closeBtn.addEventListener("click", () => {
        // Redirect to home page or close the form
        window.location.href = "index.html" // Change this to your home page URL
        // Alternatively, if this is in a modal, you can close the modal
        // modalElement.style.display = "none";
      })
    }
  
    // Toggle password visibility for both forms
    document.querySelectorAll(".toggle-password").forEach((toggle) => {
      toggle.addEventListener("click", function () {
        const passwordInput = this.previousElementSibling
        if (passwordInput.type === "password") {
          passwordInput.type = "text"
          this.textContent = "👁️‍🗨️"
        } else {
          passwordInput.type = "password"
          this.textContent = "👁️"
        }
      })
    })
  
    // Tab switching and form toggling
    if (loginTab && registerTab) {
      loginTab.addEventListener("click", () => {
        // Switch to login mode
        loginTab.classList.add("active")
        registerTab.classList.remove("active")
        loginContainer.classList.add("login-mode")
        loginContainer.classList.remove("register-mode")
        tabSlider.classList.remove("register")
  
        // Show login form, hide registration form
        loginForm.style.display = "flex"
        registerForm.style.display = "none"
  
        // Hide user type selector for login
        if (userTypeContainer) {
          userTypeContainer.style.display = "none"
        }
  
        // Hide image container for login
        if (imageContainer) {
          imageContainer.classList.add("hidden")
        }
  
        // Re-animate form elements
        setTimeout(() => {
          animateFormElements()
        }, 100)
      })
  
      registerTab.addEventListener("click", () => {
        // Switch to register mode
        registerTab.classList.add("active")
        loginTab.classList.remove("active")
        loginContainer.classList.remove("login-mode")
        loginContainer.classList.add("register-mode")
        tabSlider.classList.add("register")
  
        // Show registration form, hide login form
        registerForm.style.display = "block"
        loginForm.style.display = "none"
  
        // Show user type selector for registration
        if (userTypeContainer) {
          userTypeContainer.style.display = "flex"
        }
  
        // Show image container for registration
        if (imageContainer) {
          imageContainer.classList.remove("hidden")
        }
  
        // Re-animate form elements
        setTimeout(() => {
          animateFormElements()
        }, 100)
      })
    }
  
    // User type selection
    const userTypeBtns = document.querySelectorAll(".user-type-btn")
    userTypeBtns.forEach((btn) => {
      btn.addEventListener("click", function () {
        userTypeBtns.forEach((b) => b.classList.remove("active"))
        this.classList.add("active")
      })
    })
  
    // Profile picture upload and preview
    if (profileUpload && profilePreview) {
      profileUpload.addEventListener("change", function () {
        if (this.files && this.files[0]) {
          const reader = new FileReader()
  
          reader.onload = (e) => {
            // Update both preview images (small in form and large in left panel)
            profilePreview.src = e.target.result
            profilePreview.style.display = "block"
            profilePlaceholder.style.display = "none"
  
            // Update the large preview in the left panel
            profilePreviewLarge.src = e.target.result
            profilePreviewLarge.style.display = "block"
            if (profilePlaceholderLarge) {
              profilePlaceholderLarge.style.display = "none"
            }
  
            // Show image editor controls with animation
            if (imageEditorControls) {
              imageEditorControls.classList.add("show")
            }
          }
  
          reader.readAsDataURL(this.files[0])
        }
      })
    }
  
    // Image editor controls
    if (zoomSlider && profilePreview && profilePreviewLarge) {
      zoomSlider.addEventListener("input", function () {
        const zoomLevel = this.value
        zoomValue.textContent = `${zoomLevel}%`
  
        // Apply transformations to both preview images
        const transform = `scale(${zoomLevel / 100}) rotate(${rotateSlider.value}deg)`
        profilePreview.style.transform = transform
        profilePreviewLarge.style.transform = transform
      })
    }
  
    if (rotateSlider && profilePreview && profilePreviewLarge) {
      rotateSlider.addEventListener("input", function () {
        const rotateAngle = this.value
        rotateValue.textContent = `${rotateAngle}°`
  
        // Apply transformations to both preview images
        const transform = `scale(${zoomSlider.value / 100}) rotate(${rotateAngle}deg)`
        profilePreview.style.transform = transform
        profilePreviewLarge.style.transform = transform
      })
    }
  
    // Experience counter
    if (decreaseExpBtn && increaseExpBtn && expValue) {
      let expYears = 0
  
      updateExpCounter()
  
      decreaseExpBtn.addEventListener("click", () => {
        if (expYears > 0) {
          expYears--
          updateExpCounter()
        }
      })
  
      increaseExpBtn.addEventListener("click", () => {
        if (expYears < 50) {
          expYears++
          updateExpCounter()
        }
      })
  
      function updateExpCounter() {
        expValue.textContent = expYears
        decreaseExpBtn.disabled = expYears === 0
        increaseExpBtn.disabled = expYears === 50
      }
    }
  
    // Specialty tags
    if (addSpecialtyBtn && specialtyInput && specialtyTags) {
      addSpecialtyBtn.addEventListener("click", () => {
        addSpecialty()
      })
  
      specialtyInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter") {
          e.preventDefault()
          addSpecialty()
        }
      })
  
    


      function addSpecialty() {
        const specialty = specialtyInput.value.trim();
        if (specialty) {
          // Create the tag container
          const tag = document.createElement("div");
          tag.className = "specialty-tag";
      
          // Create the visible text and remove button
          const span = document.createElement("span");
          span.className = "remove-tag";
          span.textContent = "×";
      
          // Create hidden input for form submission
          const hiddenInput = document.createElement("input");
          hiddenInput.type = "hidden";
          hiddenInput.name = "skills[]";
          hiddenInput.value = specialty;
      
          // Add specialty text
          tag.textContent = specialty;
      
          // Append hidden input and remove button
          tag.appendChild(hiddenInput);
          tag.appendChild(span);
          specialtyTags.appendChild(tag);
      
          // Clear input
          specialtyInput.value = "";
      
          // Add event listener to remove the tag and input
          span.addEventListener("click", () => {
            tag.remove();
          });
        }
      }
      
      
    }
  
  


    const registerFormElement = document.getElementById("register-form");
    if (registerFormElement) {
      registerFormElement.addEventListener("submit", (e) => {
        e.preventDefault();

        // Simple validation
        let isValid = true;
        const requiredFields = registerFormElement.querySelectorAll("[required]");

        requiredFields.forEach((field) => {
          const formGroup = field.closest(".form-group");
          if (!field.value.trim()) {
            formGroup.classList.add("error");
            isValid = false;
          } else {
            formGroup.classList.remove("error");
          }
        });

        if (isValid) {
          // Submit the form manually
          registerFormElement.submit();
        }
      });
    }



  
    // Login form validation
    const loginFormElement = document.getElementById("login-form")
    if (loginFormElement) {
      loginFormElement.addEventListener("submit", (e) => {
        e.preventDefault()
  
        // Simple validation
        let isValid = true
        const requiredFields = loginFormElement.querySelectorAll("[required]")
  
        requiredFields.forEach((field) => {
          const formGroup = field.closest(".form-group")
          if (!field.value.trim()) {
            formGroup.classList.add("error")
            isValid = false
          } else {
            formGroup.classList.remove("error")
          }
        })
  
        if (isValid) {
          // Show loading state
          const submitBtn = loginFormElement.querySelector(".btn-primary")
          submitBtn.classList.add("loading")
          submitBtn.disabled = true
  
          // Simulate login
          setTimeout(() => {
            submitBtn.classList.remove("loading")
            submitBtn.disabled = false
  
            // Redirect to dashboard or home page after successful login
            // window.location.href = "dashboard.html";
          }, 1500)
        }
      })
    }
  
    // Function to animate form elements
    function animateFormElements() {
      // Reset animations
      document.querySelectorAll(".form-group, .form-options, .btn-primary").forEach((el) => {
        el.classList.remove("animate")
      })
  
      // Animate form groups with delay
      const formGroups = document.querySelectorAll(".form-group")
      formGroups.forEach((group, index) => {
        setTimeout(() => {
          group.classList.add("animate")
        }, 100 * index)
      })
  
      // Animate form options
      setTimeout(() => {
        document.querySelectorAll(".form-options").forEach((el) => {
          el.classList.add("animate")
        })
      }, 100 * formGroups.length)
  
      // Animate submit button
      setTimeout(
        () => {
          document.querySelectorAll(".btn-primary").forEach((el) => {
            el.classList.add("animate")
          })
        },
        100 * (formGroups.length + 1),
      )
    }
  
    // the image placeholders are perfectly circular
    const fixCircularImages = () => {
      // Fix the large profile image in the blue panel
      const imageContainer = document.querySelector(".image-placeholder")
      if (imageContainer) {
        // Force the width and height to be equal
        const containerWidth = imageContainer.offsetWidth
        imageContainer.style.height = `${containerWidth}px`
        imageContainer.style.width = `${containerWidth}px`
      }
  
      // Fix the small profile image in the form
      const profilePreviewContainer = document.querySelector(".profile-picture-preview")
      if (profilePreviewContainer) {
        const previewWidth = profilePreviewContainer.offsetWidth
        profilePreviewContainer.style.height = `${previewWidth}px`
        profilePreviewContainer.style.width = `${previewWidth}px`
      }
    }
  
    // Run on page load
    fixCircularImages()
  
    // Run on window resize to maintain the circular shape
    window.addEventListener("resize", fixCircularImages)
  })
  
  

// Make the floating symbols more dynamic
document.addEventListener("DOMContentLoaded", () => {
  const floatingSymbols = document.querySelectorAll(".floating-symbol")

  // Randomize initial positions slightly
  floatingSymbols.forEach((symbol) => {
    const randomX = Math.random() * 10 - 5 // -5 to 5
    const randomY = Math.random() * 10 - 5 // -5 to 5
    const randomRotate = Math.random() * 10 - 5 // -5 to 5

    symbol.style.transform = `translate(${randomX}px, ${randomY}px) rotate(${randomRotate}deg)`

    // Add subtle hover effect when cursor is near symbols
    document.addEventListener("mousemove", (e) => {
      const mouseX = e.clientX
      const mouseY = e.clientY
      const rect = symbol.getBoundingClientRect()
      const symbolX = rect.left + rect.width / 2
      const symbolY = rect.top + rect.height / 2

      const distance = Math.sqrt(Math.pow(mouseX - symbolX, 2) + Math.pow(mouseY - symbolY, 2))

      // If mouse is within 150px of the symbol
      if (distance < 150) {
        const moveX = (mouseX - symbolX) / 20
        const moveY = (mouseY - symbolY) / 20
        symbol.style.transform = `translate(${moveX}px, ${moveY}px) scale(1.1)`
      }
    })
  })
})




const expValueDiv = document.getElementById("exp-value");
const expInput = document.getElementById("experience-input");
const increaseBtn = document.getElementById("increase-exp");
const decreaseBtn = document.getElementById("decrease-exp");

let currentValue = 0;

increaseBtn.addEventListener("click", () => {
    currentValue++;
    updateExperience();
});

decreaseBtn.addEventListener("click", () => {
    if (currentValue > 0) {
        currentValue--;
        updateExperience();
    }
});

function updateExperience() {
    expValueDiv.textContent = currentValue;
    expInput.value = currentValue;
    decreaseBtn.disabled = currentValue === 0;
}
