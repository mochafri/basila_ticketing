// ===============================
// SIDEBAR RESPONSIVE CONTROLLER
// ===============================

const sidebar = document.querySelector(".sidebar");
const sidebarOverlay = document.getElementById("sidebarOverlay");
const hamburgerBtn = document.getElementById("sidebarHamburger");
const toggleIcon = document.getElementById("sidebarToggleIcon");
const desktopToggleButtons = document.querySelectorAll(".sidebar-toggle");

let isSidebarCollapsed = false;
const MOBILE_BREAKPOINT = 1024;

// ===========================
// MOBILE/TABLET SIDEBAR TOGGLE
// ===========================
function openMobileSidebar() {
  sidebar.classList.add("sidebar-open");
  if (sidebarOverlay) {
    sidebarOverlay.classList.add("active");
  }
  document.body.style.overflow = "hidden";
}

function closeMobileSidebar() {
  sidebar.classList.remove("sidebar-open");
  if (sidebarOverlay) {
    sidebarOverlay.classList.remove("active");
  }
  document.body.style.overflow = "";
}

function isMobileView() {
  return window.innerWidth <= MOBILE_BREAKPOINT;
}

// Hamburger button click
if (hamburgerBtn) {
  hamburgerBtn.addEventListener("click", () => {
    if (sidebar.classList.contains("sidebar-open")) {
      closeMobileSidebar();
    } else {
      openMobileSidebar();
    }
  });
}

// Overlay click closes sidebar
if (sidebarOverlay) {
  sidebarOverlay.addEventListener("click", () => {
    closeMobileSidebar();
  });
}

// ===========================
// DESKTOP SIDEBAR COLLAPSE
// ===========================
desktopToggleButtons.forEach((btn) => {
  btn.addEventListener("click", () => {
    if (isMobileView()) {
      // On mobile/tablet, toggle mobile sidebar
      if (sidebar.classList.contains("sidebar-open")) {
        closeMobileSidebar();
      } else {
        openMobileSidebar();
      }
    } else {
      // Desktop collapse/expand
      isSidebarCollapsed = !isSidebarCollapsed;
      if (isSidebarCollapsed) {
        sidebar.classList.add("collapsed");
      } else {
        sidebar.classList.remove("collapsed");
      }
    }
  });
});

// Toggle icon change on desktop
if (toggleIcon) {
  toggleIcon.addEventListener("click", function () {
    if (!isMobileView()) {
      const currentIcon = this.getAttribute("icon");
      if (currentIcon === "material-symbols:arrow-back-rounded") {
        this.setAttribute("icon", "material-symbols:close-rounded");
      } else {
        this.setAttribute("icon", "material-symbols:arrow-back-rounded");
      }
    }
  });
}

// ===========================
// AUTO-CLOSE ON RESIZE
// ===========================
window.addEventListener("resize", () => {
  if (!isMobileView()) {
    // Switching to desktop — close mobile sidebar
    closeMobileSidebar();
    document.body.style.overflow = "";
  } else {
    // Switching to mobile — remove collapsed state
    sidebar.classList.remove("collapsed");
    isSidebarCollapsed = false;
  }
});

// ===========================
// MENU ITEM INTERACTIONS
// ===========================
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

// ===========================
// ACTIVE PARENT MENU
// ===========================
document.querySelectorAll(".menu-item").forEach((item) => {
  item.addEventListener("click", function () {
    document.querySelectorAll(".menu-item").forEach((el) => {
      el.classList.remove("active");
    });

    this.classList.add("active");
  });
});

// ===========================
// ACTIVE SUBMENU
// ===========================
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

    // Close sidebar on mobile after selecting a menu item
    if (isMobileView()) {
      setTimeout(() => {
        closeMobileSidebar();
      }, 200);
    }
  });
});

// Hover expand sementara (Desktop only)
if (sidebar) {
  sidebar.addEventListener("mouseenter", () => {
    if (isSidebarCollapsed && !isMobileView()) {
      sidebar.classList.remove("collapsed");
    }
  });

  sidebar.addEventListener("mouseleave", () => {
    if (isSidebarCollapsed && !isMobileView()) {
      sidebar.classList.add("collapsed");
    }
  });
}

// Rotasi ikon panah saat collapse/expand
document.querySelectorAll(".collapse").forEach((collapseEl) => {
  collapseEl.addEventListener("show.bs.collapse", function () {
    const arrow = this.previousElementSibling.querySelector(".arrow-icon");
    if (arrow) arrow.classList.add("rotate");
  });

  collapseEl.addEventListener("hide.bs.collapse", function () {
    const arrow = this.previousElementSibling.querySelector(".arrow-icon");
    if (arrow) arrow.classList.remove("rotate");
  });
});
