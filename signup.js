document.addEventListener("DOMContentLoaded", () => {
    // DOM Elements
    const loginTab = document.getElementById("login-tab")
    const registerTab = document.getElementById("register-tab")
    const loginForm = document.getElementById("login-form")
    const registerForm = document.getElementById("register-form")
    const userTypeContainer = document.getElementById("user-type-container")
    const loginContainer = document.querySelector(".login-container")
    const tabSlider = document.querySelector(".tab-slider")
    const closeBtn = document.getElementById("close-btn")
    const btnPrimary = document.querySelectorAll(".btn-primary")
    const userTypeBtn = document.querySelector(".user-type-btn")
  
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
        window.location.href = "index.php" // Change this to your home page URL
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
  
        // Re-animate form elements
        setTimeout(() => {
          animateFormElements()
        }, 100)
      })
    }
  
    // Color switching for buttons
    btnPrimary.forEach((btn) => {
      btn.addEventListener("mouseenter", function () {
        if (
          this.style.backgroundColor === "var(--secondary-color)" ||
          getComputedStyle(this).backgroundColor === "rgb(255, 166, 77)"
        ) {
          this.style.backgroundColor = "var(--primary-color)"
          this.style.boxShadow = "0 6px 15px rgba(30, 58, 95, 0.3)"
        } else {
          this.style.backgroundColor = "var(--secondary-color)"
          this.style.boxShadow = "0 6px 15px rgba(255, 166, 77, 0.3)"
        }
      })
    })
  
    // Color switching for user type button
    userTypeBtn.addEventListener("click", function () {
      if (
        this.style.backgroundColor === "var(--primary-color)" ||
        getComputedStyle(this).backgroundColor === "rgb(30, 58, 95)"
      ) {
        this.style.backgroundColor = "var(--secondary-color)"
      } else {
        this.style.backgroundColor = "var(--primary-color)"
      }
    })
  
  
  // Form validation
  if (registerFormElement) {
    registerFormElement.addEventListener("submit", (e) => {
      e.preventDefault() // 
      // Validation
      let isValid = true
      const requiredFields = registerFormElement.querySelectorAll("[required]")
  
      requiredFields.forEach((field) => {
        const formGroup = field.closest(".form-group")
        if (!field.value.trim()) {
          formGroup.classList.add("error")
          isValid = false
        } else {
          formGroup.classList.remove("error")
        }
      })
  
      const password = document.getElementById("reg-password")
      const confirmPassword = document.getElementById("reg-confirm-password")
      if (password && confirmPassword && password.value !== confirmPassword.value) {
        confirmPassword.closest(".form-group").classList.add("error")
        isValid = false
      }
  
      
      if (!isValid) {
        e.preventDefault()
        return
      }
  
      
    })
  }



  
    // Login form validation
    const loginFormElement = document.getElementById("login-form");
    if (loginFormElement) {
      loginFormElement.addEventListener("submit", function(e) {
        e.preventDefault(); // Prevent default form submission
        
        // Simple validation
        let isValid = true;
        const requiredFields = loginFormElement.querySelectorAll("[required]");
        
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
          // Show loading state
          const submitBtn = loginFormElement.querySelector(".btn-primary");
          submitBtn.classList.add("loading");
          submitBtn.disabled = true;
          
          // Get form data
          const email = document.getElementById("login-email").value;
          const password = document.getElementById("login-password").value;
          
          // Create form data object
          const formData = new FormData();
          formData.append("email", email);
          formData.append("password", password);
          
          // Send AJAX request
          fetch("login.php", {
            method: "POST",
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            submitBtn.classList.remove("loading");
            submitBtn.disabled = false;
            
            if (data.status === "success") {
              // Show success message
              alert("Login successful! Welcome, " + data.user_name);
              
              // Redirect to home page
              window.location.href = "index.html";
            } else {
              // Show error message
              alert(data.message || "Invalid email or password");
            }
          })
          .catch(error => {
            submitBtn.classList.remove("loading");
            submitBtn.disabled = false;
            alert("An error occurred. Please try again.");
            console.error("Error:", error);
          });
        }
      });
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
  
    // Add input focus effects
    const inputs = document.querySelectorAll(".input-with-icon input, .input-with-icon select")
    inputs.forEach((input) => {
      input.addEventListener("focus", function () {
        if (this.parentElement.querySelector("i")) {
          this.parentElement.querySelector("i").style.color = "var(--primary-color)"
        }
      })
  
      input.addEventListener("blur", function () {
        if (this.parentElement.querySelector("i") && !this.value) {
          this.parentElement.querySelector("i").style.color = "var(--light-text)"
        }
      })
    })
  })
  