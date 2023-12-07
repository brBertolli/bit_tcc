const desktopMenu = document.getElementById("desktopMenu");
const menuTitle = document.getElementById("desktopMenuTitle");
const menuIcon = document.getElementById("desktopMenuIcon");
const iconCentralBar = document.getElementById("desktopMenuBar");
const menuItems = document.getElementById("desktopMenuItems");

let isMenuExpanded = false;
let isMenuHovered = false;
let ignoreHover = false;

// Verifica se o item 'isMenuExpanded' existe no localStorage
window.addEventListener('load', () => {
    isMenuExpanded = localStorage.getItem('isMenuExpanded') === 'true';
    updateMenuState(); // Atualiza o estado do menu na carga da página
    if (isMenuExpanded) {
        loadStorageData();
    }
});

function loadStorageData() {
    toggleClass(desktopMenu, true);
    isMenuHovered = true;
    desktopMenu.classList.add("active");
    ignoreHover = true;
}

menuIcon.addEventListener("click", () => {
    isMenuExpanded = !isMenuExpanded;
    localStorage.setItem('isMenuExpanded', isMenuExpanded);
    setTimeout(() => { updateMenuState(); }, 100);
    toggleClass(desktopMenu, isMenuExpanded);
    ignoreHover = isMenuExpanded;
    if (!isMenuExpanded) {
        isMenuHovered = false;
        updateMenuState();
    }
});

desktopMenu.addEventListener("mouseenter", () => {
    if (!ignoreHover && !isMenuExpanded) {
        isMenuHovered = true;
        desktopMenu.classList.add("active");
        updateMenuState();
    }
});

desktopMenu.addEventListener("mouseleave", () => {
    if (!ignoreHover) {
        isMenuHovered = false;
        if (!isMenuExpanded) {
            desktopMenu.classList.remove("active");
            setTimeout(() => { updateMenuState(); }, 275);
        }
    }
});

function toggleClass(element, condition) {
    element.classList.toggle("active", condition);
}

function updateMenuState() {
    if (isMenuExpanded || isMenuHovered) {
        setTimeout(() => {
            toggleClass(menuTitle, true);
            toggleClass(menuItems, true);
        }, 250); // Certifique-se de que este tempo corresponda à duração da transição CSS
    } else {
        toggleClass(menuTitle, false);
        toggleClass(menuItems, false);
    }

    toggleClass(menuIcon, isMenuExpanded);
    toggleClass(iconCentralBar, isMenuExpanded);


}

