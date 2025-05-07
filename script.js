document.addEventListener("DOMContentLoaded", () => {
    // Animated squares for the logo
    const logoSquares = document.querySelector(".logo-squares")
    if (logoSquares) {
      // Additional animation can be added here if needed
    }
  
    // FAQ accordion functionality
    const faqItems = document.querySelectorAll(".faq-item")
  
    faqItems.forEach((item) => {
      const question = item.querySelector(".faq-question")
  
      question.addEventListener("click", () => {
        // Close all other items
        faqItems.forEach((otherItem) => {
          if (otherItem !== item && otherItem.classList.contains("active")) {
            otherItem.classList.remove("active")
          }
        })
  
        // Toggle current item
        item.classList.toggle("active")
      })
    })
  
    // Animation for feature boxes
    const features = document.querySelectorAll(".feature")
  
    // Apply different animation delays to create a wave effect
    features.forEach((feature, index) => {
      feature.style.animationDelay = `${index * 0.2}s`
    })
  
    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
      anchor.addEventListener("click", function (e) {
        e.preventDefault()
  
        const targetId = this.getAttribute("href")
        if (targetId === "#") return
  
        const targetElement = document.querySelector(targetId)
        if (targetElement) {
          window.scrollTo({
            top: targetElement.offsetTop - 80, // Offset for header
            behavior: "smooth",
          })
        }
      })
    })
  
    // Add animation on scroll for about section
    const aboutSection = document.querySelector(".about-us")
    const aboutImage = document.querySelector(".about-image")
    const aboutText = document.querySelector(".about-text")
  
    window.addEventListener("scroll", () => {
      const scrollPosition = window.scrollY
      const aboutPosition = aboutSection.offsetTop
  
      if (scrollPosition > aboutPosition - window.innerHeight / 1.5) {
        aboutImage.style.opacity = "1"
        aboutImage.style.transform = "translateX(0)"
        aboutText.style.opacity = "1"
        aboutText.style.transform = "translateX(0)"
      }
    })
  })
  