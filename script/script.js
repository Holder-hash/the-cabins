document.querySelector('.footer__input-box__inp').addEventListener('focus', () => {
    document.querySelector('.footer__input-box__legend').style = `transform: translateY(0px);`;
})
document.querySelector('.footer__input-box__inp').addEventListener('blur', () => {
    if (!document.querySelector('.footer__input-box__inp').value) {
        document.querySelector('.footer__input-box__legend').style = `transform: translateY(30px);`;
    }
})
const cabins = document.getElementById('cabins');
document.addEventListener('scroll', () => {
    if (window.scrollY >= 100) {
        main.style = `margin-top: 100px`;
        header.style = `position: fixed; top: 0px`;
    } else {
        main.style = `margin-top: 0px`;
        header.style = `position: relative;`;
    }
    if (window.scrollY >= 800) {
        header.style.zIndex = `100`;
        upBtn.style.transform = 'translateY(0)'
    } else {
        upBtn.style.transform = 'translateY(200px)'
    }

    if (window.scrollY >= cabins.getBoundingClientRect().y - 500) {
        cabins.style.opacity = '1';
    }
    if (window.scrollY >= cards.getBoundingClientRect().y - 100) {
        cards.style.opacity = '1';
    }
    if (window.scrollY >= map.getBoundingClientRect().y) {
        map.style.transform = 'translateX(0)';
    }
    if (window.scrollY >= forest.getBoundingClientRect().y + 1000) {
        forest.style.transform = 'translateX(0)';
    }
    if (window.scrollY >= more.getBoundingClientRect().y + 1500) {
        moreLeft.style.transform = 'translateX(0)';
        moreRight.style.transform = 'translateX(0)';
    }
})

upBtn.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        left: 0,
        behavior: 'smooth'
    });
})