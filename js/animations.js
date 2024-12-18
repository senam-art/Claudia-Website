// Initial Reveal of Claudia Logo and Tagline
gsap.timeline()
  .to(".logo-main", { opacity: 1, y: -20, duration: 1 })
  .to("#tagline", { opacity: 1, y: -20, duration: 1 }, "<"); // Animate tagline alongside logo

// Scroll-triggered animation for Claudia logo moving up
gsap.to(".logo-main", {
  scrollTrigger: {
    trigger: ".pictures-section", // Start animation when pictures section comes into view
    start: "top center",
    end: "bottom top",
    scrub: true // Smooth animation on scroll
  },
  y: -200, // Move up by 200px
  opacity: 0.5 // Fade slightly as it moves up
});

// Pictures Animation on Scroll
gsap.from(".picture-frame", {
  scrollTrigger: {
    trigger: ".pictures-section",
    start: "top 80%", // Start animating when 80% of the section is visible
    toggleActions: "play none none none", // Play the animation once
  },
  scale: 0, // Start from scale 0
  opacity: 0,
  duration: 1,
  stagger: 0.2 // Delay between each frame appearing
});
