/*!
 * JavaScript Cookie v2.2.0
 * https://github.com/js-cookie/js-cookie
 *
 * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
 * Released under the MIT license
 */
;(function (factory) {
    var registeredInModuleLoader = false;
    if (typeof define === 'function' && define.amd) {
        define(factory);
        registeredInModuleLoader = true;
    }
    if (typeof exports === 'object') {
        module.exports = factory();
        registeredInModuleLoader = true;
    }
    if (!registeredInModuleLoader) {
        var OldCookies = window.Cookies;
        var api = window.Cookies = factory();
        api.noConflict = function () {
            window.Cookies = OldCookies;
            return api;
        };
    }
}(function () {
    function extend () {
        var i = 0;
        var result = {};
        for (; i < arguments.length; i++) {
            var attributes = arguments[ i ];
            for (var key in attributes) {
                result[key] = attributes[key];
            }
        }
        return result;
    }

    function init (converter) {
        function api (key, value, attributes) {
            var result;
            if (typeof document === 'undefined') {
                return;
            }

            // Write

            if (arguments.length > 1) {
                attributes = extend({
                    path: '/'
                }, api.defaults, attributes);

                if (typeof attributes.expires === 'number') {
                    var expires = new Date();
                    expires.setMilliseconds(expires.getMilliseconds() + attributes.expires * 864e+5);
                    attributes.expires = expires;
                }

                // We're using "expires" because "max-age" is not supported by IE
                attributes.expires = attributes.expires ? attributes.expires.toUTCString() : '';

                try {
                    result = JSON.stringify(value);
                    if (/^[\{\[]/.test(result)) {
                        value = result;
                    }
                } catch (e) {}

                if (!converter.write) {
                    value = encodeURIComponent(String(value))
                        .replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent);
                } else {
                    value = converter.write(value, key);
                }

                key = encodeURIComponent(String(key));
                key = key.replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent);
                key = key.replace(/[\(\)]/g, escape);

                var stringifiedAttributes = '';

                for (var attributeName in attributes) {
                    if (!attributes[attributeName]) {
                        continue;
                    }
                    stringifiedAttributes += '; ' + attributeName;
                    if (attributes[attributeName] === true) {
                        continue;
                    }
                    stringifiedAttributes += '=' + attributes[attributeName];
                }
                return (document.cookie = key + '=' + value + stringifiedAttributes);
            }

            // Read

            if (!key) {
                result = {};
            }

            // To prevent the for loop in the first place assign an empty array
            // in case there are no cookies at all. Also prevents odd result when
            // calling "get()"
            var cookies = document.cookie ? document.cookie.split('; ') : [];
            var rdecode = /(%[0-9A-Z]{2})+/g;
            var i = 0;

            for (; i < cookies.length; i++) {
                var parts = cookies[i].split('=');
                var cookie = parts.slice(1).join('=');

                if (!this.json && cookie.charAt(0) === '"') {
                    cookie = cookie.slice(1, -1);
                }

                try {
                    var name = parts[0].replace(rdecode, decodeURIComponent);
                    cookie = converter.read ?
                        converter.read(cookie, name) : converter(cookie, name) ||
                        cookie.replace(rdecode, decodeURIComponent);

                    if (this.json) {
                        try {
                            cookie = JSON.parse(cookie);
                        } catch (e) {}
                    }

                    if (key === name) {
                        result = cookie;
                        break;
                    }

                    if (!key) {
                        result[name] = cookie;
                    }
                } catch (e) {}
            }

            return result;
        }

        api.set = api;
        api.get = function (key) {
            return api.call(api, key);
        };
        api.getJSON = function () {
            return api.apply({
                json: true
            }, [].slice.call(arguments));
        };
        api.defaults = {};

        api.remove = function (key, attributes) {
            api(key, '', extend(attributes, {
                expires: -1
            }));
        };

        api.withConverter = init;

        return api;
    }

    return init(function () {});
}));

//HEAD
window["gdpr-cookie-notice-templates"] = {};

window["gdpr-cookie-notice-templates"]["bar.html"] = "<div class=\"gdpr-cookie-notice\">\n" +
    "  <p class=\"gdpr-cookie-notice-description\">{description}&nbsp;<a href=\"{readmorelink}\" target=\"_blank\" class=\"gdpr-cookie-notice-read-more\">{readmore}</a></p>\n" +
    "  <nav class=\"gdpr-cookie-notice-nav\">\n" +
    "    <a href=\"#\" class=\"gdpr-cookie-notice-nav-item gdpr-cookie-notice-nav-item-settings\">{settings}</a>\n" +
    "    <a href=\"#\" class=\"gdpr-cookie-notice-nav-item gdpr-cookie-notice-nav-item-accept gdpr-cookie-notice-nav-item-btn\">{accept}</a>\n" +
    "    <a href=\"#\" class=\"gdpr-cookie-notice-nav-item gdpr-cookie-notice-nav-item-reject gdpr-cookie-notice-nav-item-btn\">{reject}</a>\n" +
    "  </nav>\n" +
    "</div>\n" +
    "";

window["gdpr-cookie-notice-templates"]["category.html"] = "<li class=\"gdpr-cookie-notice-modal-cookie\">\n" +
    "  <div class=\"gdpr-cookie-notice-modal-cookie-row\">\n" +
    "    <h3 class=\"gdpr-cookie-notice-modal-cookie-title\">{title}</h3>\n" +
    "    <input type=\"checkbox\" name=\"gdpr-cookie-notice-{prefix}\"  id=\"gdpr-cookie-notice-{prefix}\" class=\"gdpr-cookie-notice-modal-cookie-input\">\n" +
    "    <label class=\"gdpr-cookie-notice-modal-cookie-input-switch\" for=\"gdpr-cookie-notice-{prefix}\"></label>\n" +
    "  </div>\n" +
    "  <p class=\"gdpr-cookie-notice-modal-cookie-info\">{desc}</p>\n" +
    "</li>\n" +
    "";

window["gdpr-cookie-notice-templates"]["modal.html"] = "<div class=\"gdpr-cookie-notice-modal\">\n" +
    "  <div class=\"gdpr-cookie-notice-modal-content\">\n" +
    "    <div class=\"gdpr-cookie-notice-modal-header\">\n" +
    "      <h2 class=\"gdpr-cookie-notice-modal-title\">{settings}</h2>\n" +
    "      <button type=\"button\" class=\"gdpr-cookie-notice-modal-close\"></button>\n" +
    "    </div>\n" +
    "    <ul class=\"gdpr-cookie-notice-modal-cookies\"></ul>\n" +
    "    <div class=\"gdpr-cookie-notice-modal-footer\">\n" +
    "      <a href=\"{readmorelink}\" target=\"_blank\" class=\"gdpr-cookie-notice-modal-footer-item gdpr-cookie-notice-modal-footer-item-statement\">{statement}</a>\n" +
    "      <a href=\"#\" class=\"gdpr-cookie-notice-modal-footer-item gdpr-cookie-notice-modal-footer-item-save gdpr-cookie-notice-modal-footer-item-btn\"><span>{save}</span></a>\n" +
    "    </div>\n" +
    "  </div>\n" +
    "</div>\n" +
    "";
// END
// Load locales
const gdprCookieNoticeLocales = {};


/**
 * GDPR Cookie Notice
 * @param {object} config Config
 */
// eslint-disable-next-line no-unused-vars,require-jsdoc,max-statements
function gdprCookieNotice(config) {
    const namespace = 'gdprcookienotice';
    const pluginPrefix = 'gdpr-cookie-notice';
    const templates = window[`${pluginPrefix}-templates`];
    // eslint-disable-next-line no-undef
    const gdprCookies = Cookies.noConflict();
    let modalLoaded = false;
    let noticeLoaded = false;
    let cookiesAccepted = false;
    const categories = [
        'performance',
        'analytics',
        'marketing'
    ];

    const currentCookieSelection = getCookie();

    const cookieEvent = new CustomEvent("cookieChanged", {
        bubbles: true,
        detail: {
            cookieValue: document.cookie,
            checkChange: () => {
                if (cookieEvent.detail.cookieValue !== document.cookie) {
                    cookieEvent.detail.cookieValue = document.cookie;
                    // eslint-disable-next-line no-magic-numbers
                    return 1;
                }
                // eslint-disable-next-line no-magic-numbers
                return 0;

            },
            listenCheckChange: () => {
                setInterval(() => {
                    // eslint-disable-next-line no-magic-numbers
                    if (cookieEvent.detail.checkChange() === 1) {
                        cookieEvent.detail.changed = true;
                        cookieEvent.target.dispatchEvent(cookieEvent);

                    } else {
                        cookieEvent.detail.changed = false;
                    }
                    // eslint-disable-next-line no-magic-numbers
                }, 1000);
            },
            changed: false
        }
    });

    let cookiesAcceptedEvent = new CustomEvent('gdprCookiesEnabled', {detail: currentCookieSelection});


    // Default config options
    if (!config.locale) {
        config.locale = 'es';
    }

    if (!config.timeout) {
        config.timeout = 500;
    }

    if (!config.domain) {
        config.domain = null;
    }

    if (!config.expiration) {
        config.expiration = 30;
    }



    // Use 'es' locale if current locale doesn't exist
    if (typeof gdprCookieNoticeLocales[config.locale] === 'undefined') {
        config.locale = 'es';
    }

    if (typeof config.localeStrings !== 'undefined') {
        gdprCookieNoticeLocales[config.locale] = {...gdprCookieNoticeLocales[config.locale], ...config.localeStrings}
    }

    // Show cookie bar if needed
    // eslint-disable-next-line no-negated-condition
    if (!currentCookieSelection) {
        showNotice();
        document.dispatchEvent(cookieEvent);

    } else {
        cookiesAcceptedEvent = new CustomEvent('gdprCookiesEnabled', {
            detail: {
                analytics: currentCookieSelection.analytics,
                marketing: currentCookieSelection.marketing,
                performance: currentCookieSelection.performance
            }
        });

        document.dispatchEvent(cookiesAcceptedEvent);

        document.dispatchEvent(cookieEvent);
    }

    document.addEventListener('gdprCookiesEnabled', function (e) {
        if(e.detail.marketing) {

            // console.log('Marketing');

        }

        if(e.detail.performance) {

            // console.log('Perfonrmance');
        }

        if(e.detail.analytics) {

            // console.log('Analitycs');
        }

    });

    document.addEventListener("DOMContentLoaded", (event) => {
        event.target.dispatchEvent(cookieEvent);
    });



    document.addEventListener("cookieChanged", (event) => {
        event.detail.listenCheckChange();
        if (event.detail.changed === true) {
            deleteCookies(currentCookieSelection);
        }
    });

    /**
     * Get gdpr cookie notice stored value
     * @return {undefined|{}} Cookie
     */
    function getCookie() {
        return gdprCookies.getJSON(namespace);
    }

    /**
     * Delete cookies if needed
     * @param {any} savedCookies ¿?¿?
     * @return {void|null} ¿?¿?
     */
    function deleteCookies(savedCookies) {
        // Cuando aún no hay nada configurado en el gestor de cookies
        // if (savedCookies === undefined) {
        if (typeof savedCookies === 'undefined') {
            // eslint-disable-next-line id-length
            for (let i = 0; i < categories.length; i++) {
                if (config[categories[i]]) {
                    // eslint-disable-next-line id-length
                    for (let j = 0; j < config[categories[i]].length; j++) {
                        document.cookie = `${config[categories[i]][j]}=; Path=/; Domain=${config.domain}; Expires=Thu, 01 Jan 1970 00:00:01 GMT;`;
                    }
                }
            }
            return;
        }
        // eslint-disable-next-line id-length
        for (let i = 0; i < categories.length; i++) {
            if (config[categories[i]] && !savedCookies[categories[i]]) {
                // eslint-disable-next-line id-length
                for (let j = 0; j < config[categories[i]].length; j++) {
                    document.cookie = `${config[categories[i]][j]}=; Path=/; Domain=${config.domain}; Expires=Thu, 01 Jan 1970 00:00:01 GMT;`;
                }
            }
        }
    }

    /**
     * Hide cookie notice bar
     * @returns {void}
     */
    function hideNotice() {
        document.documentElement.classList.remove(`${pluginPrefix}-loaded`);
    }

    /**
     * Write gdpr cookie notice's cookies when user accepts cookies
     * @param {boolean} save Save?
     * @return {void}
     */
    function acceptCookies(save) {
        const value = {
            date: new Date(),
            necessary: true,
            performance: true,
            analytics: true,
            marketing: true
        };

        // buildModal() // temp
        // If request was coming from the modal, check for the settings
        if (save) {
            // eslint-disable-next-line id-length
            for (let i = 0; i < categories.length; i++) {
                const input = document.getElementById(`${pluginPrefix}-cookie_${categories[i]}`);
                // eslint-disable-next-line multiline-ternary,no-ternary
                value[categories[i]] = input ? input.checked : true;
            }
        }

        gdprCookies.set(namespace, value, {
            expires: config.expiration,
            domain: config.domain
        });

        deleteCookies(value);

        // Load marketing scripts that only works when cookies are accepted
        cookiesAcceptedEvent = new CustomEvent('gdprCookiesEnabled', {detail: value});
        document.dispatchEvent(cookiesAcceptedEvent);
        hideNotice();

        window.location.reload();
    }

    /**
     * Write gdpr cookie notice's cookies when user accepts cookies
     * @param {boolean} save Save?
     * @return {void}
     */
    function rejectCookies(save) {
        const value = {
            date: new Date(),
            necessary: true,
            performance: false,
            analytics: false,
            marketing: false
        };

        gdprCookies.set(namespace, value, {
            expires: config.expiration,
            domain: config.domain
        });

        deleteCookies(value);

        // Load marketing scripts that only works when cookies are accepted
        cookiesResolvedEvent = new CustomEvent('gdprCookiesEnabled', {detail: value});
        document.dispatchEvent(cookiesResolvedEvent);
        hideNotice();

        window.location.reload();
    }

    /**
     * Show the cookie bar
     * @return {boolean} Notice loaded?
     */
    function buildNotice() {
        if (noticeLoaded) {
            return false;
        }

        const noticeHtml = localizeTemplate('bar.html');
        document.body.insertAdjacentHTML('beforeend', noticeHtml);

        // Load click functions
        setNoticeEventListeners();

        // Make sure its only loaded once
        noticeLoaded = true;

        return true;
    }

    /**
     * Show the cookie notice
     * @return {void}
     */
    function showNotice() {
        buildNotice();

        // Show the notice with a little timeout
        setTimeout(() => {
            document.documentElement.classList.add(`${pluginPrefix}-loaded`);
        }, config.timeout);
    }

    /**
     * Localize templates
     * @param {string} template Template name
     * @param {string} prefix Prefix?
     * @return {string|boolean} ¿?¿?
     */
    function localizeTemplate(template, prefix) {
        const str = templates[template];
        const data = gdprCookieNoticeLocales[config.locale];
        if (prefix) {
            // eslint-disable-next-line no-param-reassign
            prefix += '_';
        } else {
            // eslint-disable-next-line no-param-reassign
            prefix = '';
        }

        data.readmorelink = config.statement;

        if (typeof str === 'string' && data instanceof Object) {
            // for (var key in data) { // este for no sé porque estaba no hace nada
            // eslint-disable-next-line id-length
            return str.replace(/({([^}]+)})/g, (i) => {
                const key = i.replace(/{/, '').replace(/}/, '');
                if (key === 'prefix') {
                    // eslint-disable-next-line no-magic-numbers
                    return prefix.slice(0, -1);
                }

                if (data[key]) {
                    return data[key];
                } else if (data[prefix + key]) {
                    return data[prefix + key];
                }

                return i;
            });
            // }
        }

        return false;
    }

    /**
     * Build modal window
     * @return {boolean} Modal loaded?
     */
    function buildModal() {
        if (modalLoaded) {
            return false;
        }

        // Load modal template
        const modalHtml = localizeTemplate('modal.html');

        // Append modal into body
        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Get empty category list
        const categoryList = document.querySelector(`.${pluginPrefix}-modal-cookies`);

        // Load essential cookies
        categoryList.innerHTML += localizeTemplate('category.html', 'cookie_essential');
        const input = document.querySelector(`.${pluginPrefix}-modal-cookie-input`);
        const label = document.querySelector(`.${pluginPrefix}-modal-cookie-input-switch`);
        label.innerHTML = gdprCookieNoticeLocales[config.locale].always_on;
        label.classList.add(`${pluginPrefix}-modal-cookie-state`);
        label.classList.remove(`${pluginPrefix}-modal-cookie-input-switch`);
        input.remove();

        // Load other categories if needed
        if (config.performance) {
            categoryList.innerHTML += localizeTemplate('category.html', 'cookie_performance');
        }
        if (config.analytics) {
            categoryList.innerHTML += localizeTemplate('category.html', 'cookie_analytics');
        }
        if (config.marketing) {
            categoryList.innerHTML += localizeTemplate('category.html', 'cookie_marketing');
        }

        // Load click functions
        setModalEventListeners();

        // Update checkboxes based on stored info(if any)
        if (currentCookieSelection) {
            document.getElementById(`${pluginPrefix}-cookie_performance`).checked = currentCookieSelection.performance;
            document.getElementById(`${pluginPrefix}-cookie_analytics`).checked = currentCookieSelection.analytics;
            document.getElementById(`${pluginPrefix}-cookie_marketing`).checked = currentCookieSelection.marketing;
        }

        // Make sure modal is only loaded once
        modalLoaded = true;

        return true;
    }

    /**
     * Show modal window
     * @return {void}
     */
    function showModal() {
        buildModal();
        document.documentElement.classList.add(`${pluginPrefix}-show-modal`);
    }

    /**
     * Hide modal window
     * @return {void}
     */
    function hideModal() {
        document.documentElement.classList.remove(`${pluginPrefix}-show-modal`);
    }

    /**
     * Click functions in the notice
     * @return {void}
     */
    function setNoticeEventListeners() {
        // eslint-disable-next-line no-magic-numbers
        const settingsButton = document.querySelectorAll(`.${pluginPrefix}-nav-item-settings`)[0];
        // eslint-disable-next-line no-magic-numbers
        const acceptButton = document.querySelectorAll(`.${pluginPrefix}-nav-item-accept`)[0];

        const rejectButton = document.querySelectorAll(`.${pluginPrefix}-nav-item-reject`)[0];

        settingsButton.addEventListener('click', (event) => {
            event.preventDefault();
            showModal();
        });

        acceptButton.addEventListener('click', (event) => {
            event.preventDefault();
            acceptCookies(true);
        });

        rejectButton.addEventListener('click', (event) => {
            event.preventDefault();
            rejectCookies(true);
        });
    }

    /**
     * Click functions in the modal
     * @return {void}
     */
    function setModalEventListeners() {
        // eslint-disable-next-line no-magic-numbers
        const closeButton = document.querySelectorAll(`.${pluginPrefix}-modal-close`)[0];
        const categoryTitles = document.querySelectorAll(`.${pluginPrefix}-modal-cookie-title`);
        // eslint-disable-next-line no-magic-numbers
        const saveButton = document.querySelectorAll(`.${pluginPrefix}-modal-footer-item-save`)[0];

        closeButton.addEventListener('click', () => {
            hideModal();
            return false;
        });

        // eslint-disable-next-line id-length
        for (let i = 0; i < categoryTitles.length; i++) {
            // eslint-disable-next-line func-names
            categoryTitles[i].addEventListener('click', function () {
                this.parentNode.parentNode.classList.toggle('open');
                return false;
            });
        }

        saveButton.addEventListener('click', (event) => {
            event.preventDefault();
            saveButton.classList.add('saved');
            setTimeout(() => {
                saveButton.classList.remove('saved');
                hideModal();

                // eslint-disable-next-line no-magic-numbers
            }, 1000);
            // acceptCookies(true);
        });
    }

    // Settings button on the page somewhere
    const globalSettingsButton = document.querySelectorAll(`.${pluginPrefix}-settings-button`);
    if (globalSettingsButton) {
        // eslint-disable-next-line id-length
        for (let i = 0; i < globalSettingsButton.length; i++) {
            globalSettingsButton[i].addEventListener('click', (event) => {
                event.preventDefault();
                showModal();
            });
        }
    }

    /**
     * Get document height
     * @return {number} Document height
     */
    // function getDocHeight() {
    //     const DOCUMENT = document;
    //     return Math.max(
    //         DOCUMENT.body.scrollHeight, DOCUMENT.documentElement.scrollHeight,
    //         DOCUMENT.body.offsetHeight, DOCUMENT.documentElement.offsetHeight,
    //         DOCUMENT.body.clientHeight, DOCUMENT.documentElement.clientHeight
    //     );
    // }

    /**
     * Check if at least page is 25% scrolled down
     * @return {boolean} 25% scrolled down?
     */
    // function amountScrolled() {
    //     const winheight = window.innerHeight || (document.documentElement || document.body).clientHeight;
    //     const docheight = getDocHeight();
    //     const scrollTop = window.pageYOffset || (document.documentElement || document.body.parentNode || document.body).scrollTop;
    //     const trackLength = docheight - winheight;
    //     // gets percentage scrolled (ie: 80 or NaN if tracklength == 0)
    //     // eslint-disable-next-line no-magic-numbers
    //     const pctScrolled = Math.floor(scrollTop / trackLength * 100);
    //     // eslint-disable-next-line no-magic-numbers
    //     if (pctScrolled > 25 && !cookiesAccepted) {
    //         cookiesAccepted = true;
    //         return true;
    //     }
    //     return false;
    // }

    /**
     * Accept cookies on scroll
     * @return {void}
     */
    // function acceptOnScroll() {
    //     window.addEventListener('scroll', function _listener() {
    //         if (amountScrolled()) {
    //             acceptCookies(true);
    //             window.removeEventListener('click', _listener);
    //         }
    //     });
    // }

    // eslint-disable-next-line func-names
    // gdprCookieNotice.removeCookies = function () {
    //     deleteCookies(currentCookieSelection);
    // };
}

// Add strings
/* eslint-disable camelcase */
// eslint-disable-next-line no-undef
gdprCookieNoticeLocales.en = {
    description: 'We use cookies to offer you a better browsing experience, personalise content and ads, to provide social media features and to analyse our traffic. Read about how we use cookies and how you can control them by clicking on Cookie Settings.',
    readmore: 'Read more',
    settings: 'Cookie settings',
    accept: 'Accept cookies',
    reject: 'Reject',
    statement: 'Our cookie statement',
    save: 'Save settings',
    always_on: 'Always on',
    cookie_essential_title: 'Necessary website cookies',
    cookie_essential_desc: 'Necessary cookies help make a website usable by enabling basic functions like page navigation and access to secure areas of the website. The website cannot function properly without these cookies.',
    cookie_performance_title: 'Performance cookies',
    cookie_performance_desc: 'These cookies are used to enhance the performance and functionality of our websites but are non-essential to their use. For example they store your preferred language or the region that you are in.',
    cookie_analytics_title: 'Analytics cookies',
    cookie_analytics_desc: 'We use analytics cookies to help us measure how users interact with website content, which helps us customize our websites and applications for you in order to enhance your experience.',
    cookie_marketing_title: 'Marketing cookies',
    cookie_marketing_desc: 'These cookies are used to make advertising messages more relevant to you and your interests. The intention is to display ads that are relevant and engaging for the individual user and thereby more valuable for publishers and third party advertisers.'
};

// Add strings
/* eslint-disable camelcase */
// eslint-disable-next-line no-undef
gdprCookieNoticeLocales.de = {
    description: 'Wir verwenden Cookies, um Ihnen ein besseres Surf-Erlebnis zu gewährleisten, Inhalte und Werbung anzupassen, Funktionen für soziale Medien anzubieten und unseren Datenverkehr zu analysieren. Sie können mehr darüber lesen, wie wir diese Cookies verwenden und wie Sie die Cookies kontrollieren können, indem Sie auf Cookie-Einstellungen klicken.',
    readmore: 'Mehr lesen',
    settings: 'Cookie-Einstellungen',
    accept: 'Cookies akzeptieren',
    reject: 'Reject',
    statement: 'Unsere Cookie-Erklärung',
    save: 'Einstellungen speichern',
    always_on: 'Immer aktiv',
    cookie_essential_title: 'Notwendige Cookies',
    cookie_essential_desc: 'Diese Cookies sind für das ordnungsgemäße Funktionieren der Website erforderlich.',
    cookie_performance_title: 'Performance Cookies',
    cookie_performance_desc: 'Diese Cookies werden verwendet, um die Leistung der Website zu verbessern, sind aber nicht unbedingt erforderlich. Zum Beispiel die Standardsprache des Benutzers.',
    cookie_analytics_title: 'Analytische Cookies',
    cookie_analytics_desc: 'Diese Cookies helfen uns zu messen, wie Benutzer mit Webinhalten interagieren, was uns hilft, Webseiten und Anwendungen zu personalisieren, um die Benutzererfahrung zu verbessern.',
    cookie_marketing_title: 'Marketing Cookies',
    cookie_marketing_desc: 'Diese Cookies werden verwendet, um Werbung für Sie und Ihre Interessen relevanter zu machen. Ziel ist es, Anzeigen zu zeigen, die für den einzelnen Nutzer relevant und ansprechend sind und daher für Web-Publisher und externe Werbetreibende wertvoller sind.'
};

// Add strings
/* eslint-disable camelcase */
// eslint-disable-next-line no-undef
gdprCookieNoticeLocales.ca = {
    description: 'Fem servir cookies per oferir una millor experiència de navegació, personalitzar el contingut i els anuncis, proporcionar funcions de xarxes socials i analitzar el nostre trànsit. Pots llegir més sobre com fem servir les cookies i com pots controlar-les fent clic a Configuració de cookies.',
    readmore: 'Llegir més',
    settings: 'Configuració de cookies',
    accept: 'Acceptar cookies',
    reject: 'Rebutjar',
    statement: 'Nostre avís de cookies',
    save: 'Guardar configuració',
    always_on: 'Sempre actives',
    cookie_essential_title: 'Cookies necessàries',
    cookie_essential_desc: 'Aquestes cookies són necessàries perquè la pàgina web funcioni correctament.',
    cookie_performance_title: 'Cookies de rendiment',
    cookie_performance_desc: 'Aquestes cookies s’utilitzen per millorar el rendiment de la pàgina web però no són essencials. Per exemple l\'idioma per defecte de l\'usuari.',
    cookie_analytics_title: 'Cookies d\'analítica',
    cookie_analytics_desc: 'Aquestes cookies ens ajuden a mesurar com els usuaris interactuen amb el contingut de la web, fet que ens ajuda a personalitzar les pàgines web i aplicacions amb el propòsit de millorar l\'experiència d\'usuari.',
    cookie_marketing_title: 'Cookies de marketing',
    cookie_marketing_desc: 'Aquestes cookies s\'utilitzen per fer que els missatges publicitaris siguin més rellevants per a tu i els teus interessos. La intenció és mostrar anuncis que siguin rellevants i atractius per a l\'usuari individual i, per tant, més valuosos per als publicadors del web i anunciants externs.'
};

// Add strings
/* eslint-disable camelcase */
// eslint-disable-next-line no-undef
gdprCookieNoticeLocales.es = {
    description: 'Usamos cookies para ofrecer una mejor experiencia de navegación, personalizar el contenido y los anuncios, proporcionar funciones de redes sociales y analizar nuestro tráfico. Puedes leer más sobre cómo usamos las cookies y cómo puedes controlarlas haciendo clic en Configuración de cookies.',
    readmore: 'Leer más',
    settings: 'Configuración de cookies',
    accept: 'Aceptar cookies',
    reject: 'Rechazar',
    statement: 'Nuestro aviso de cookies',
    save: 'Guardar configuración',
    always_on: 'Siempre activas',
    cookie_essential_title: 'Cookies necesarias',
    cookie_essential_desc: 'Estas cookies son necesarias para que la página web funcione correctamente.',
    cookie_performance_title: 'Cookies de rendimiento',
    cookie_performance_desc: 'Estas cookies son usadas para mejorar el rendimiento de la página web pero no son esenciales. Por ejemplo el idioma predefinido del usuario.',
    cookie_analytics_title: 'Cookies de analítica',
    cookie_analytics_desc: 'Estas cookies nos ayudan a medir cómo los usuarios interactúan con el contenido de la web, lo que nos ayuda a personalizar las páginas web y aplicaciones con el proposito de mejorar la experiencia de usuario.',
    cookie_marketing_title: 'Cookies de marketing',
    cookie_marketing_desc: 'Estas cookies se utilizan para hacer que los mensajes publicitarios sean más relevantes para ti y tus intereses. La intención es mostrar anuncios que sean relevantes y atractivos para el usuario individual y, por lo tanto, más valiosos para los publicadores de la web y anunciantes externos.'
};

//# sourceMappingURL=gdpr-rw-cookie-notice.js.map
