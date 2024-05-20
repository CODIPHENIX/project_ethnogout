export const viewmenuicon = () => {
    const navmenubutton = document.querySelector(".icon_menu");
    const navicon = document.querySelector(".icon_menu i");
    const navmenu = document.querySelector('.nav_menu');

    const closeMenu = () => {
        if (navmenu && navicon) {
            navmenu.classList.remove('open');
            navicon.className = 'fa-solid fa-bars';
        }
    };

    navmenubutton.addEventListener('click', (e) => {
        e.stopPropagation();
        closeUserMenu();
        if (navmenu && navicon) {
            navmenu.classList.toggle('open');
            const isOpen = navmenu.classList.contains('open');
            navicon.className = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
        }
    });

    document.addEventListener('click', (e) => {
        const isClickedInsideMenu = navmenu && navmenu.contains(e.target);
        if (!isClickedInsideMenu) {
            closeMenu();
        }
    });

    const closeUserMenu = () => {
        const usermenu = document.querySelector('.content');
        const usericon = document.querySelector(".p_usericon i");
        if (usermenu && usericon && usermenu.classList.contains('open')) {
            usermenu.classList.remove('open');
            usericon.className = 'fa-regular fa-user';
        }
    };
};

export const viewusericon = () => {
    const usermenubutton = document.querySelector(".p_usericon");
    const usericon = document.querySelector(".p_usericon i");
    const usermenu = document.querySelector('.content');

    const closeuser = () => {
        if (usermenu && usericon) {
            usermenu.classList.remove('open');
            usericon.className = 'fa-regular fa-user';
        }
    };

    usermenubutton.addEventListener('click', (e) => {
        e.stopPropagation();
        closeMenu();
        if (usermenu && usericon) {
            usermenu.classList.toggle('open');
            const isOpen = usermenu.classList.contains('open');
            usericon.className = isOpen ? 'fa-solid fa-xmark' : 'fa-regular fa-user';
        }
    });

    document.addEventListener('click', (e) => {
        const isClickedInsideMenu = usermenu && usermenu.contains(e.target);
        if (!isClickedInsideMenu) {
            closeuser();
        }
    });

    const closeMenu = () => {
        const navmenu = document.querySelector('.nav_menu');
        const navicon = document.querySelector(".icon_menu i");
        if (navmenu && navicon && navmenu.classList.contains('open')) {
            navmenu.classList.remove('open');
            navicon.className = 'fa-solid fa-bars';
        }
    };
};

export const viewsearch = () => {
    const searchbutton = document.querySelector(".search-icon");
    const searchicon = document.querySelector(".search-icon i");
    const searchsection = document.querySelector('.searchs_section');

    const toggleSearchSection = () => {
        if (searchsection && searchicon) {
            searchsection.classList.toggle('show');
            const isShow = searchsection.classList.contains('show');
            searchicon.className = isShow ? 'fa-solid fa-xmark' : 'fa-solid fa-magnifying-glass';
        }
    };

    searchbutton.onclick = toggleSearchSection;


    const handleResize = () => {
        const screenWidth = window.innerWidth;
        if (screenWidth > 1024 && searchsection.classList.contains('show')) {
            searchsection.classList.remove('show');
            searchicon.className = 'fa-solid fa-magnifying-glass';
        }
    };


    window.addEventListener('resize', handleResize);


    handleResize();
};

