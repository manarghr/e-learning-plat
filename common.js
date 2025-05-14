/**
 * Common JavaScript functions for E-Taalim platform
 */

// Check if user is logged in (can be called from any page)
function checkLoginStatus() {
  // This function uses a fetch request to check session status
  fetch("check-login.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.logged_in) {
        // User is logged in, update UI
        updateUIForLoggedInUser(data.user_name, data.user_type)
      } else {
        // User is not logged in, ensure UI is in default state
        updateUIForLoggedOutUser()
      }
    })
    .catch((error) => {
      console.error("Error checking login status:", error)
    })
}

// Update UI elements when user is logged in
function updateUIForLoggedInUser(userName, userType) {
  const signInContainer = document.querySelector(".sign-in")
  if (!signInContainer) return

  // Clear existing content
  signInContainer.innerHTML = ""

  // Create welcome message
  const welcomeSpan = document.createElement("span")
  welcomeSpan.className = "user-welcome"
  welcomeSpan.textContent = "Welcome, " + userName

  // Create logout button
  const logoutBtn = document.createElement("a")
  logoutBtn.href = "logout.php"
  logoutBtn.className = "btn btn-primary"
  logoutBtn.textContent = "Logout"

  // Add elements to container
  signInContainer.appendChild(welcomeSpan)
  signInContainer.appendChild(logoutBtn)

  // Add user type specific UI changes if needed
  if (userType === "student") {
    // Add student-specific UI elements
    document.body.classList.add("student-logged-in")
  } else if (userType === "mentor") {
    // Add mentor-specific UI elements
    document.body.classList.add("mentor-logged-in")
  }
}

// Reset UI elements when user is logged out
function updateUIForLoggedOutUser() {
  const signInContainer = document.querySelector(".sign-in")
  if (!signInContainer) return

  // Reset to default state
  signInContainer.innerHTML = '<a href="signup.html" class="btn btn-primary">Sign In</a>'

  // Remove any user type specific classes
  document.body.classList.remove("student-logged-in", "mentor-logged-in")
}

// Handle logout action
function handleLogout(event) {
  // This can be used for a client-side logout without page refresh
  event.preventDefault()

  fetch("logout.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        // Update UI for logged out state
        updateUIForLoggedOutUser()
        // Redirect to home page
        window.location.href = "index.php"
      }
    })
    .catch((error) => {
      console.error("Error during logout:", error)
    })
}

// Initialize common functionality
document.addEventListener("DOMContentLoaded", () => {
  // Check login status when page loads
  checkLoginStatus()

  // Add event listener for logout buttons
  document.addEventListener("click", (event) => {
    if (event.target.matches(".sign-in .btn-primary") && event.target.textContent === "Logout") {
      handleLogout(event)
    }
  })
})
