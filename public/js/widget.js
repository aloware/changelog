let ChangelogWidget = (function(){
    let defaults = {
        protocol : 'http:',
        container : null,
        translations : {
            position : 'cl_bottom', // cl_top, cl_left, cl_right
        }
    };

    function ChangelogWidget(options)
    {
        this.options = { ...defaults, ...options }
        this.container = document.querySelector(this.options.container);
        this.iframeContainer = null;
        this.isVisible = !1;
        this.init();
    }

    return ChangelogWidget;
})();

ChangelogWidget.prototype.init = function(){
    this.createElements();
}

ChangelogWidget.prototype.createElements = function(){
    let t, _this = this;

    this.elements = {
        widgetPlaceholder : document.createElement('p'),
        badge : document.createElement('span'),
        animate : document.createElement('link'),
        trigger : this.findAllSelectors(this.options.trigger)
    }

    this.elements.widgetPlaceholder.classList.add("widget-placeholder");
    this.elements.widgetPlaceholder.innerHTML = (this.options.translations && this.options.translations.placeholderLabel) ? this.options.translations.placeholderLabel : 'Release Notes';
    this.container.appendChild(this.elements.widgetPlaceholder);

    this.elements.widgetPlaceholder.addEventListener("click", this.toggle.bind(_this), !1);
    t = document.createElement("style");
    t.id = "cl-styles-container";
    t.textContent = ".cl-iframe-container { \n pointer-events: none; \n border-radius: 4px; \n box-shadow: 0 0 1px rgba(99, 114, 130, 0.32), 0 8px 16px rgba(27, 39, 51, 0.08); \n background: #fff; \n border: none; \n position: fixed; \n top: -900em; \n z-index: 2147483647; \n width: 22vw; \n height: 60vh; \n opacity: 0; \n will-change: height, margin-top, opacity; \n margin-top: -10px; \n transition: margin-top 0.15s ease-out, opacity 0.1s ease-out; \n overflow: hidden; \n } \n .cl-iframe-container.cl-iframe-visible { \n opacity : 1; \n pointer-events : auto; \n margin-top : 0; \n height: 60vh; \n top: 490px; } \n .widget-placeholder { \n cursor : pointer \n} \n iframe.cl-frame { \n width: 100%; \n position: relative; \n overflow: hidden; \n height: 100%; \n }";
    document.body.appendChild(t);
    this.createIFrame();
}

ChangelogWidget.prototype.findAllSelectors = function(t){
    return document.querySelectorAll(t);
}

ChangelogWidget.prototype.createIFrame = function(){
    let f = document.createElement("iframe");
    let d = document.createElement("div");
    d.classList.add("cl-iframe-container");
    f.classList.add("cl-frame");
    this.getIFrameTarget().appendChild(d);
    f.referrerPolicy = "strict-origin",
    f.sandbox = "allow-same-origin allow-scripts allow-top-navigation allow-popups allow-forms allow-popups-to-escape-sandbox",
    f.src = this.getIFrameUrl();
    f.addEventListener("load", this.onFrameLoad)
    d.appendChild(f);
    this.iframeContainer = d;
}

ChangelogWidget.prototype.getIFrameUrl = function(){
    return this.options.protocol + '//localhost/' + this.options.uuid + '/widgets';
}

ChangelogWidget.prototype.getIFrameTarget = function(){
    return document.body;
}

ChangelogWidget.prototype.onFrameLoad = function(){

}

ChangelogWidget.prototype.setWidgetPosition = function(){
    let top, left = 0;
    switch (this.options.translations.position) {
        case 'cl_top' :
            console.log(this.elements.widgetPlaceholder.offsetTop, this.iframeContainer.offsetHeight)
            top = this.elements.widgetPlaceholder.offsetTop - this.iframeContainer.offsetHeight;
            left = this.elements.widgetPlaceholder.offsetLeft + 2;
            break;
        // case 'cl_left':
        //     break;
        // case'cl_right':
        //     break;
        // case 'cl_center':
        //     break;
        case 'cl_bottom':
        default:
            top = this.elements.widgetPlaceholder.offsetTop + this.elements.widgetPlaceholder.offsetHeight;
            left = this.elements.widgetPlaceholder.offsetLeft + 2;
    }

    this.iframeContainer.style.left = left + 'px';
    this.iframeContainer.style.top = top + 'px';
}

ChangelogWidget.prototype.toggle = function(){
    return this.isVisible ? this.hideIframe() : this.showIframe();
}

ChangelogWidget.prototype.showIframe = function(){
    this.setWidgetPosition();
    this.iframeContainer.classList.add("cl-iframe-visible");
    return this.isVisible = !0;
}

ChangelogWidget.prototype.hideIframe = function(){
    this.iframeContainer.classList.remove("cl-iframe-visible");
    return this.isVisible = !1;
}

document.addEventListener('DOMContentLoaded', function(){
    new ChangelogWidget(typeof changelog_config !== 'undefined' ? changelog_config : {})
});
