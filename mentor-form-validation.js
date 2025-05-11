//Validation of the registration and login forms
document.addEventListener("DOMContentLoaded", () => {
    // Wait for the main script to load first
    setTimeout(() => {
      // Enhanced validation for the registration form
    const registerForm = document.getElementById("register-form")
    if (registerForm) {
        // Add visual indicators for required fields
        const requiredFields = registerForm.querySelectorAll("[required]")
        requiredFields.forEach((field) => {
          // Add a red asterisk to the label
        const formGroup = field.closest(".form-group")
        if (formGroup) {
            const label = formGroup.querySelector("label")
            if (label && !label.innerHTML.includes("*")) {
            label.innerHTML += ' <span style="color: #ff4d4d;">*</span>'
            }
        }

          // Add validation
        field.addEventListener("blur", function () {
            validateField(this)
        })

          // Add input event for real-time feedback
        field.addEventListener("input", function () {
            if (this.classList.contains("error") || this.closest(".form-group").classList.contains("error")) {
            validateField(this)
            }
        })
        })

        // Override the submit event with more comprehensive validation
        registerForm.addEventListener(
        "submit",
        (e) => {
            e.preventDefault()

            let isValid = true
            let firstInvalidField = null

            // Validate all required fields
            requiredFields.forEach((field) => {
            if (!validateField(field) && !firstInvalidField) {
                firstInvalidField = field
                isValid = false
            }
            })

            // Check password match
            const password = document.getElementById("reg-password")
            const confirmPassword = document.getElementById("reg-confirm-password")
            if (password && confirmPassword && password.value !== confirmPassword.value) {
            const formGroup = confirmPassword.closest(".form-group")
            formGroup.classList.add("error")
            const errorMessage = formGroup.querySelector(".error-message")
            if (errorMessage) {
                errorMessage.textContent = "Passwords do not match"
                errorMessage.style.display = "block"
            }
            isValid = false
            if (!firstInvalidField) firstInvalidField = confirmPassword
            }

            // Check if at least one specialty is added
            const specialtyTags = document.querySelector(".specialty-tags")
            if (specialtyTags && specialtyTags.children.length === 0) {
            const specialtyInput = document.getElementById("specialty-input")
            if (specialtyInput) {
                const formGroup = specialtyInput.closest(".form-group")
                formGroup.classList.add("error")

                // Create error message if it doesn't exist
                let errorMessage = formGroup.querySelector(".error-message")
                if (!errorMessage) {
                errorMessage = document.createElement("div")
                errorMessage.className = "error-message"
                formGroup.appendChild(errorMessage)
                }

                errorMessage.textContent = "Please add at least one specialty"
                errorMessage.style.display = "block"
                isValid = false
                if (!firstInvalidField) firstInvalidField = specialtyInput
            }
            }

            // Check if profile picture is uploaded
            const profileUpload = document.getElementById("profile-upload")
            if (profileUpload && !profileUpload.files.length) {
            const formGroup = profileUpload.closest(".form-group")
            formGroup.classList.add("error")

              // Create error message if it doesn't exist
            let errorMessage = formGroup.querySelector(".error-message")
            if (!errorMessage) {
                errorMessage = document.createElement("div")
                errorMessage.className = "error-message"
                formGroup.appendChild(errorMessage)
            }

            errorMessage.textContent = "Please upload a profile picture"
            errorMessage.style.display = "block"
            isValid = false
            if (!firstInvalidField) firstInvalidField = profileUpload
            }

            // Scroll to the first invalid field
            if (firstInvalidField) {
            firstInvalidField.focus()
            firstInvalidField.scrollIntoView({ behavior: "smooth", block: "center" })
            }

            // If valid, let the original event handler take over
            if (isValid) {
              registerForm.submit(); // this manually submits the form
            }
            
        },
        true,
        ) 
    }

      // validation for the login form
    const loginForm = document.getElementById("login-form")
    if (loginForm) {
        // Add visual indicators for required fields
        const requiredFields = loginForm.querySelectorAll("[required]")
        requiredFields.forEach((field) => {
          // Add a red asterisk to the label
        const formGroup = field.closest(".form-group")
        if (formGroup) {
            const label = formGroup.querySelector("label")
            if (label && !label.innerHTML.includes("*")) {
            label.innerHTML += ' <span style="color: #ff4d4d;">*</span>'
            }
        }

          // Add real-time validation
        field.addEventListener("blur", function () {
            validateField(this)
        })

          // Add input event for real-time feedback
        field.addEventListener("input", function () {
            if (this.classList.contains("error") || this.closest(".form-group").classList.contains("error")) {
            validateField(this)
            }
        })
        })

        // Override the submit event with more comprehensive validation
        loginForm.addEventListener(
        "submit",
        (e) => {
            e.preventDefault()

            let isValid = true
            let firstInvalidField = null

            // Validate all required fields
            requiredFields.forEach((field) => {
            if (!validateField(field) && !firstInvalidField) {
                firstInvalidField = field
                isValid = false
            }
            })

            // Scroll to the first invalid field
            if (firstInvalidField) {
            firstInvalidField.focus()
            firstInvalidField.scrollIntoView({ behavior: "smooth", block: "center" })
            }

            // If valid, let the original event handler take over
            if (isValid) {
              loginForm.submit();
            }
        },
        true,
        ) // Use capturing to run before the original handler
    }

      // Helper function to validate a field
    function validateField(field) {
        const formGroup = field.closest(".form-group")
        let isValid = true
        let errorMessage = ""

        // Check if empty
        if (!field.value.trim()) {
        isValid = false
        errorMessage = "This field is required"
        }
        // Email validation
        else if (field.type === "email" && !isValidEmail(field.value)) {
        isValid = false
        errorMessage = "Please enter a valid email address"
        }
        // Password validation
        else if (field.type === "password" && field.id === "reg-password" && field.value.length < 8) {
        isValid = false
        errorMessage = "Password must be at least 8 characters"
        }
        // Phone validation
        else if (field.id === "reg-phone" && !isValidPhone(field.value)) {
        isValid = false
        errorMessage = "Please enter a valid phone number"
        }

        // Update UI based on validation
        if (!isValid) {
        formGroup.classList.add("error")
        const errorElement = formGroup.querySelector(".error-message")
        if (errorElement) {
            errorElement.textContent = errorMessage
            errorElement.style.display = "block"
        }
        } else {
        formGroup.classList.remove("error")
        const errorElement = formGroup.querySelector(".error-message")
        if (errorElement) {
            errorElement.style.display = "none"
        }
        }

        return isValid
    }

      // Helper function to validate email
    function isValidEmail(email) {
        const re =
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
        return re.test(String(email).toLowerCase())
    }

      // Helper function to validate phone
    function isValidPhone(phone) {
        // This is a simple validation - adjust based on your requirements
        const re = /^[+]?[(]?[0-9]{3}[)]?[-\s.]?[0-9]{3}[-\s.]?[0-9]{4,6}$/
        return re.test(String(phone))
    }

      // Add a visual indicator that fields are required
    const formContainer = document.querySelector(".form-container")
    if (formContainer) {
        const requiredNote = document.createElement("div")
        requiredNote.className = "required-fields-note"
        requiredNote.innerHTML = '<span style="color: #ff4d4d;">*</span> Required fields'
        requiredNote.style.fontSize = "12px"
        requiredNote.style.color = "#666"
        requiredNote.style.marginBottom = "15px"
        requiredNote.style.textAlign = "right"

        // Insert after the tabs
        const authTabs = formContainer.querySelector(".auth-tabs")
        if (authTabs) {
        authTabs.parentNode.insertBefore(requiredNote, authTabs.nextSibling)
        }
    }

      // Add shake animation for invalid form submissions
    const style = document.createElement("style")
    style.textContent = `
        @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .shake {
        animation: shake 0.6s ease-in-out;
        }
        .form-group.error input {
        border-color: #ff4d4d;
        background-color: #fff8f8;
        }
        .error-message {
        color: #ff4d4d;
        font-size: 12px;
        margin-top: 5px;
        display: none;
        }
        .form-group.error .error-message {
        display: block;
        }
        `;
    
    document.head.appendChild(style)

      // Add shake animation when form is submitted with errors
    const forms = document.querySelectorAll("form")
    forms.forEach((form) => {
        form.addEventListener("submit", function () {
        if (this.querySelectorAll(".form-group.error").length > 0) {
            this.classList.add("shake")
            setTimeout(() => {
            this.classList.remove("shake")
            }, 600)
        }
        })
    })
    }, 500) // Wait for the main script to initialize
})
