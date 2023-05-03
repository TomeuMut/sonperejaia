export default function() {
    const tabLi = document.querySelectorAll(".js-tabMenu .js-tabLi");
    const tabs = document.querySelectorAll(".js-tabMenu .js-tabLi span");
    const tabContent = document.querySelectorAll(".js-tabContent");
    tabs.forEach(tab => {

        tab.addEventListener('click', function(event) {

           // not active tabs at the moment
            tabLi.forEach(t => {
                t.classList.remove('is-active');
            })


            tabContent.forEach(element => {

                let className = (element) ? element.className.split(" ") : null;
                if(tab.className == className[2]) {
                    element.style.display = "block"
                    tab.parentElement.classList.add('is-active')
                } else {
                    element.style.display = "none";
                }
            });
        })

    });

    const tabActive = document.querySelector(".js-tabMenu .js-tabLi.is-active span");
    tabContent.forEach(element => {
        let className = (element) ? element.className.split(" ") : null;
        if(tabActive.className == className[2]) {
            element.style.display = "block"
        }
    });
}
