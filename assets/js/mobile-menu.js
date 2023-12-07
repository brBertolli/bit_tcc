const mobileMenuTitle = document.getElementById("mobileMenuTitle");
const mobileMenu = document.getElementById("mobileMenuIcon");
const mobileMenuItems = document.getElementById("mobileMenuItems");
const mobileMenuItem = document.getElementsByClassName("menu-item");
const mobileMenuIcon = document.getElementById("mobileMenuIcon");
const mobileIconCentralBar = document.getElementById("mobileMenuBar");
const mobileRefIcon = document.getElementById("refIcon");

let isMobileMenuExpanded = false;

mobileMenu.addEventListener('click', () => {
    isMobileMenuExpanded = !isMobileMenuExpanded;
    toggleClass(mobileMenuIcon, isMobileMenuExpanded);
    toggleClass(mobileIconCentralBar, isMobileMenuExpanded);
    toggleClass(mobileRefIcon, isMobileMenuExpanded)
    if (isMobileMenuExpanded) {
        mobileMenuItems.classList.remove('collapsing');
        mobileMenuItems.classList.add('active');
        mobileMenuTitle.classList.add('active');
    } else {
        mobileMenuItems.classList.add('collapsing');
        setTimeout(() => {
            mobileMenuTitle.classList.remove('active');
            mobileMenuItems.classList.remove('active');
        }, 250)
    }
})

mobileMenuItems.addEventListener('click', () => {
    if (isMobileMenuExpanded) {
        isMobileMenuExpanded = !isMobileMenuExpanded;
        toggleClass(mobileMenuIcon, isMobileMenuExpanded);
        toggleClass(mobileIconCentralBar, isMobileMenuExpanded);
        toggleClass(mobileRefIcon, isMobileMenuExpanded)
        mobileMenuItems.classList.add('collapsing');
        setTimeout(() => {
            mobileMenuItems.classList.remove('active');
        }, 250)
    }
})


function toggleClass(element, condition) {
    element.classList.toggle("active", condition);
}
