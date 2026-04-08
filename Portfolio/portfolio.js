// ================= MENU TOGGLE =================
const menuIcon = document.getElementById("menu-icon");
const navbar = document.querySelector(".navbar");

menuIcon.onclick = () => {
  menuIcon.classList.toggle("bx-x");
  navbar.classList.toggle("active");
};

// ================= EDUCATION DATA =================
const EDUCATION = [
  {
    year: "2023 – Present",
    icon: "🎓",
    title: "Bachelor of Science in Computer Science",
    sub: "American International University-Bangladesh (AIUB)",
    desc: "Studying core CS fundamentals including AI/ML"
  },
  {
    year: "2022",
    icon: "📘",
    title: "Higher Secondary Certificate (HSC)",
    sub: "Monipur High School & College, Mirpur",
    desc: "Completed HSC in Science group GPA: 5.00/5.00"
  },
  {
    year: "2020",
    icon: "📗",
    title: "Secondary School Certificate (SSC)",
    sub: "Meherpur Govt. High School, Meherpur",
    desc: "Completed SSC in Science group GPA: 5.00/5.00"
  }
];

// ================= SCROLL ANIMATION OBSERVER =================
const observer = new IntersectionObserver(entries => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.style.opacity = "1";
      entry.target.style.transform = "translateY(0)";
    }
  });
}, { threshold: 0.1 });

// ================= RENDER EDUCATION =================
const container = document.getElementById("timeline-container");

if (container) {
  EDUCATION.forEach(item => {
    const div = document.createElement("div");
    div.classList.add("timeline-item");

    // initial hidden state
    div.style.opacity = "0";
    div.style.transform = "translateY(40px)";
    div.style.transition = "0.5s ease";

    div.innerHTML = `
      <div class="timeline-dot">${item.icon}</div>
      <div class="timeline-content">
        <div class="tl-year">${item.year}</div>
        <div class="tl-title">${item.title}</div>
        <div class="tl-sub">${item.sub}</div>
        <div class="tl-desc">${item.desc}</div>
      </div>
    `;

    container.appendChild(div);

    // observe after adding
    observer.observe(div);
  });
}

// ================= ACTIVE NAV + CLOSE MENU ON SCROLL =================
const sections = document.querySelectorAll("section");
const navLinks = document.querySelectorAll("header nav a");

window.onscroll = () => {
  // close mobile menu
  menuIcon.classList.remove("bx-x");
  navbar.classList.remove("active");

  // active link highlight
  let top = window.scrollY;

  sections.forEach(sec => {
    let offset = sec.offsetTop - 150;
    let height = sec.offsetHeight;
    let id = sec.getAttribute("id");

    if (top >= offset && top < offset + height) {
      navLinks.forEach(link => {
        link.classList.remove("active");

        const target = document.querySelector(`header nav a[href*="${id}"]`);
        if (target) target.classList.add("active");
      });
    }
  });
};

const themeToggle = document.getElementById("theme-toggle");

// load saved theme
if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark-mode");
    themeToggle.classList.replace("bx-moon", "bx-sun");
}

// toggle theme
themeToggle.onclick = () => {
    document.body.classList.toggle("dark-mode");

    if (document.body.classList.contains("dark-mode")) {
        themeToggle.classList.replace("bx-moon", "bx-sun");
        localStorage.setItem("theme", "dark");
    } else {
        themeToggle.classList.replace("bx-sun", "bx-moon");
        localStorage.setItem("theme", "light");
    }
};