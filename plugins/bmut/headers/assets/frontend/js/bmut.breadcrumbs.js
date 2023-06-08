const items = document.querySelectorAll('.js-breadcrumb-link');
items.forEach(item => setBreadCrumbTitle(item));

function setBreadCrumbTitle(lastItem) {
    if (!lastItem) {
        return;
    }
    try {
        const domItem = lastItem.dataset.rwDomElement;
        const breadTitle = document.getElementById(domItem);
        if (breadTitle) {
            lastItem.innerText = breadTitle.innerText;
        }
    } catch (error) {
        console.error(error);
    }
}

var ldJsonScript = document.createElement('script');
ldJsonScript.type = 'application/ld+json';

try {
    $.request('onGetRichSnippet', {
        success: function (data) {
            ldJsonScript.text = data.result;
            document.querySelector('head').appendChild(ldJsonScript);
        }
    });
} catch (error) {
    console.error(error);
}
