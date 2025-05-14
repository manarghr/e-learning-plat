function checkLoginStatus() {
  // This function uses a fetch request to check session status
  fetch("check-login.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.logged_in) {
        updateUIForLoggedInUser(data.user_name, data.user_type)
      } else {
        updateUIForLoggedOutUser()
      }
    })
    .catch((error) => {
      console.error("Error checking login status:", error)
    })
}


function updateUIForLoggedInUser(userName, userType) {
  const signInContainer = document.querySelector(".sign-in")
  if (!signInContainer) return

  
  signInContainer.innerHTML = ""

  
  const welcomeSpan = document.createElement("span")
  welcomeSpan.className = "user-welcome"
  welcomeSpan.textContent = "Welcome, " + userName

  
  const logoutBtn = document.createElement("a")
  logoutBtn.href = "logout.php"
  logoutBtn.className = "btn btn-primary"
  logoutBtn.textContent = "Logout"

  
  signInContainer.appendChild(welcomeSpan)
  signInContainer.appendChild(logoutBtn)

  
  if (userType === "student") {
    document.body.classList.add("student-logged-in")
  } else if (userType === "mentor") {
    document.body.classList.add("mentor-logged-in")
  }
}


function updateUIForLoggedOutUser() {
  const signInContainer = document.querySelector(".sign-in")
  if (!signInContainer) return

  
  signInContainer.innerHTML = '<a href="signup.html" class="btn btn-primary">Sign In</a>'

  
  document.body.classList.remove("student-logged-in", "mentor-logged-in")
}

// Handle logout action
function handleLogout(event) {
  
  event.preventDefault()

  fetch("logout.php", {
    method: "POST",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status === "success") {
        
        updateUIForLoggedOutUser()
        
        window.location.href = "index.php"
      }
    })
    .catch((error) => {
      console.error("Error during logout:", error)
    })
}

// Initialize common functionality
document.addEventListener("DOMContentLoaded", () => {
  
  checkLoginStatus()

  
  document.addEventListener("click", (event) => {
    if (event.target.matches(".sign-in .btn-primary") && event.target.textContent === "Logout") {
      handleLogout(event)
    }
  })
})
