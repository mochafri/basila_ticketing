const toggleButton = document.querySelector(".sidebar-toggle");
const sidebar = document.querySelector(".sidebar");

let isSidebarCollapsed = false;

toggleButton.addEventListener("click", () => {
  isSidebarCollapsed = !isSidebarCollapsed;

  if (isSidebarCollapsed) {
    sidebar.classList.add("collapsed");
  } else {
    sidebar.classList.remove("collapsed");
  }
});

const menuItems = document.querySelectorAll(".menu-item");

menuItems.forEach((item) => {
  item.addEventListener("click", function () {
    const targetId = this.getAttribute("data-bs-target");
    const targetCollapse = document.querySelector(targetId);

    // Tutup semua collapse lain
    document.querySelectorAll(".collapse").forEach((collapse) => {
      if (collapse !== targetCollapse) {
        collapse.classList.remove("show");
      }
    });
  });
});

// =========================
// ACTIVE PARENT MENU
// =========================
document.querySelectorAll(".menu-item").forEach((item) => {
  item.addEventListener("click", function () {
    document.querySelectorAll(".menu-item").forEach((el) => {
      el.classList.remove("active");
    });

    this.classList.add("active");
  });
});

// =========================
// ACTIVE SUBMENU
// =========================
document.querySelectorAll(".submenu-item").forEach((item) => {
  item.addEventListener("click", function (e) {
    e.stopPropagation();

    document.querySelectorAll(".submenu-item").forEach((el) => {
      el.classList.remove("active");
    });

    document.querySelectorAll(".menu-item").forEach((el) => {
      el.classList.remove("active");
    });

    this.classList.add("active");

    const parentMenu = this.closest("ul").previousElementSibling;
    if (parentMenu) {
      parentMenu.classList.add("active");
    }
  });
});

const toggleIcon = document.getElementById("sidebarToggleIcon");

toggleIcon.addEventListener("click", function () {
  const currentIcon = this.getAttribute("icon");

  if (currentIcon === "material-symbols:arrow-back-rounded") {
    this.setAttribute("icon", "material-symbols:close-rounded");
  } else {
    this.setAttribute("icon", "material-symbols:arrow-back-rounded");
  }
});

// Hover expand sementara
sidebar.addEventListener("mouseenter", () => {
  if (isSidebarCollapsed) {
    sidebar.classList.remove("collapsed");
    this.setAttribute("icon", "material-symbols:arrow-back-rounded");
  }
});

sidebar.addEventListener("mouseleave", () => {
  if (isSidebarCollapsed) {
    sidebar.classList.add("collapsed");
  }
});

// Rotasi ikon panah saat collapse/expand
document.querySelectorAll(".collapse").forEach((collapseEl) => {
  collapseEl.addEventListener("show.bs.collapse", function () {
    const arrow = this.previousElementSibling.querySelector(".arrow-icon");
    arrow.classList.add("rotate");
  });

  collapseEl.addEventListener("hide.bs.collapse", function () {
    const arrow = this.previousElementSibling.querySelector(".arrow-icon");
    arrow.classList.remove("rotate");
  });
});
