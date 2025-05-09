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

  // Counter animation for stats
  function animateCounters() {
    const stats = document.querySelectorAll(".stat-number")

    stats.forEach((stat) => {
      const target = Number.parseInt(stat.textContent)
      const duration = 2000 // 2 seconds
      const startTime = Date.now()
      const startValue = 0

      function updateCounter() {
        const currentTime = Date.now()
        const elapsedTime = currentTime - startTime

        if (elapsedTime < duration) {
          const value = Math.floor(startValue + (target - startValue) * (elapsedTime / duration))
          stat.textContent = value + (stat.textContent.includes("+") ? "+" : "")
          requestAnimationFrame(updateCounter)
        } else {
          stat.textContent = target + (stat.textContent.includes("+") ? "+" : "")
        }
      }

      updateCounter()
    })
  }

  // Create animated background for About Us section
  function createAnimatedBackground() {
    const aboutUs = document.querySelector(".about-us")
    if (!aboutUs) return

    // Create animated background container if it doesn't exist
    if (!document.querySelector(".about-us .animated-background")) {
      const animatedBg = document.createElement("div")
      animatedBg.className = "animated-background"

      // Add educational symbols
      const symbols = [
        { class: "floating-symbol symbol-plus", content: "+" },
        { class: "floating-symbol symbol-minus", content: "−" },
        { class: "floating-symbol symbol-minus", content: "−" },
        { class: "floating-symbol symbol-equals", content: "=" },
        { class: "floating-symbol symbol-multiply", content: "×" },
        { class: "floating-symbol symbol-divide", content: "÷" },
        { class: "floating-symbol symbol-divide", content: "÷" },
        { class: "floating-symbol symbol-pi", content: "π" },
        { class: "floating-symbol symbol-pi", content: "π" },
        { class: "floating-symbol symbol-sigma", content: "∑" },
        { class: "floating-symbol symbol-sqrt", content: "√" },
        { class: "floating-symbol symbol-book", content: '<i class="fa fa-book"></i>' },
        { class: "floating-symbol symbol-book", content: '<i class="fa fa-book"></i>' },
        { class: "floating-symbol symbol-graduation", content: '<i class="fa fa-graduation-cap"></i>' },
        { class: "floating-symbol symbol-graduation", content: '<i class="fa fa-graduation-cap"></i>' },
        { class: "floating-symbol symbol-pencil", content: '<i class="fa fa-pencil"></i>' },
        { class: "floating-symbol symbol-pencil", content: '<i class="fa fa-pencil"></i>' },
        { class: "floating-symbol symbol-atom", content: '<i class="fa fa-atom"></i>' },
      ]

      symbols.forEach((symbol) => {
        const el = document.createElement("div")
        el.className = symbol.class
        el.innerHTML = symbol.content
        animatedBg.appendChild(el)
      })

      aboutUs.insertBefore(animatedBg, aboutUs.firstChild)
    }
  }

  // Create animated background
  createAnimatedBackground()

  // Section title animations
  const sectionTitles = document.querySelectorAll("h2")
  sectionTitles.forEach((title) => {
    if (!title.classList.contains("section-title")) {
      title.classList.add("section-title")
    }
  })

  // Intersection Observer for animations
  const observerOptions = {
    threshold: 0.2,
    rootMargin: "0px 0px -100px 0px",
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        if (entry.target.classList.contains("about-image")) {
          entry.target.style.opacity = "1"
          entry.target.style.transform = "translateX(0)"
        } else if (entry.target.classList.contains("about-text")) {
          entry.target.style.opacity = "1"
          entry.target.style.transform = "translateX(0)"
        } else if (entry.target.classList.contains("about-stats")) {
          animateCounters()
        } else if (entry.target.classList.contains("step")) {
          entry.target.classList.add("animated")
        } else if (entry.target.classList.contains("section-title")) {
          entry.target.classList.add("animated")
        }
      }
    })
  }, observerOptions)

  // Observe elements
  if (aboutImage) observer.observe(aboutImage)
  if (aboutText) observer.observe(aboutText)

  const aboutStats = document.querySelector(".about-stats")
  if (aboutStats) observer.observe(aboutStats)

  const steps = document.querySelectorAll(".step")
  steps.forEach((step) => observer.observe(step))

  // Observe section titles
  const titles = document.querySelectorAll(".section-title")
  titles.forEach((title) => observer.observe(title))
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


