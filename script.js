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


 // About-us page animation. 

document.addEventListener("DOMContentLoaded", () => {
  console.log("Animation script loaded")

  // Function to check if an element is in viewport
  function isInViewport(element) {
  const rect = element.getBoundingClientRect()
    return rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.85 && rect.bottom >= 0
  }

  // Function to handle animations when elements come into view
  function handleScrollAnimations() {
  console.log("Checking for elements to animate")

    // Animate headings
  document.querySelectorAll(".about-content h1").forEach((heading) => {
      if (isInViewport(heading) && !heading.classList.contains("animate-fade-in")) {
      console.log("Animating heading:", heading.textContent)
      heading.classList.add("animate-fade-in")
      }
  })

    // Animate paragraphs
  document.querySelectorAll(".about-content p:not(.final-cta p)").forEach((paragraph) => {
      if (isInViewport(paragraph) && !paragraph.classList.contains("animate-fade-in")) {
      paragraph.classList.add("animate-fade-in")
      }
  })

    // Animate quotes
  document.querySelectorAll(".quote").forEach((quote) => {
      if (isInViewport(quote) && !quote.classList.contains("animate-slide-left")) {
      quote.classList.add("animate-slide-left")
      }
  })

    // Animate final CTA
  const finalCta = document.querySelector(".final-cta")
  if (finalCta && isInViewport(finalCta) && !finalCta.classList.contains("animate-fade-in")) {
      finalCta.classList.add("animate-fade-in")
  }
  }

  // Run once on load with a delay to ensure DOM is fully loaded
  setTimeout(() => {
  console.log("Initial animation check")
  handleScrollAnimations()
  }, 300)

  // Run on scroll
  window.addEventListener("scroll", handleScrollAnimations)

  // Add hover effect to section headings
  document.querySelectorAll(".about-content h1").forEach((heading) => {
  heading.addEventListener("mouseenter", function () {
      this.style.color = "#ffa64d"
      this.style.transition = "color 0.5s ease"
  })

  heading.addEventListener("mouseleave", function () {
      this.style.color = "#1e3a5f"
  })
  })
})
