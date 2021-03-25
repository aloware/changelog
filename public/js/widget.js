let ChangelogWidget = (function(){
    let defaults = {
        protocol : 'http:',
        container : 'body',
        triggerElement : null,
        translations : {
            placeholderLabel : '',
            headerLabel : 'Latest News'
        },
        position : {
            alignment : 'left',
            drop : 'down',
            offsetTop : 0,
            offsetBottom : 0,
            offsetRight : 0,
            offsetLeft : 0,
        }
    };

    function ChangelogWidget(options)
    {
        this.options = { ...defaults, ...options }
        this.container = document.querySelector(this.options.container);
        this.iframeContainer = null;
        this.iframe = null;
        this.isVisible = !1;
        this.mounted = 0;
        this.init();
    }

    return ChangelogWidget;
})();

ChangelogWidget.prototype.init = function(){
    window.addEventListener('message', this.onReceivePostMessage.bind(this), false);
    this.initializeElements();
}

ChangelogWidget.prototype.onReceivePostMessage = function(event){
    this.initializeElements();
}

ChangelogWidget.prototype.initializeElements = function(){
    if (this.mounted === 0) {
        this.createElements();
    }

    this.mounted++;
}

ChangelogWidget.prototype.createElements = function(){
    let t, _this = this;

    this.elements = {
        trigger : document.querySelector(this.options.triggerElement)
    }

    if (!this.options.triggerElement) {
        this.elements.placeholderContainer = document.createElement('div');
        this.elements.widgetPlaceholder = document.createElement('span');
        this.elements.badge = document.createElement('span');
        this.elements.animate = document.createElement('link');
    }


    if (!this.elements.trigger) {
        this.elements.widgetPlaceholder.classList.add("widget-placeholder");
        this.elements.widgetPlaceholder.innerHTML = (this.options.translations && this.options.translations.placeholderLabel) ? this.options.translations.placeholderLabel : '';

        this.elements.badge.classList.add('widget-badge');
        this.elements.placeholderContainer.classList.add('placeholder-container');

        this.elements.placeholderContainer.append(this.elements.badge);

        if (!this.options.translations.placeholderLabel || this.options.translations.placeholderLabel.length > 0) {
            this.elements.placeholderContainer.append(this.elements.widgetPlaceholder);
        }

        if (this.container.tagName === 'BODY') {
            this.container.prepend(this.elements.placeholderContainer);
        } else {
            this.container.appendChild(this.elements.placeholderContainer);
        }

        this.elements.placeholderContainer.addEventListener("click", this.toggle.bind(_this), !1);
    }

    if (this.elements.trigger) {
        if (typeof this.elements.trigger !== 'undefined') {
            _this.elements.trigger.addEventListener("click", this.toggle.bind(_this), !1);
        }
    }

    document.addEventListener('click', function(e){
        if (!_this.iframeContainer.contains(e.target)) {
            _this.hideIframe();
        }
    });

    t = document.createElement("style");
    t.id = "cl-styles-container";
    t.textContent = ".cl-iframe-container { \n pointer-events: none; \n border-radius: 4px; \n box-shadow: 0 0 1px rgba(99, 114, 130, 0.32), 0 8px 16px rgba(27, 39, 51, 0.08); \n background: #fff; \n border: none; \n position: fixed; \n top: -900em; \n z-index: 2147483647; \n width: 340px; \n height: 455px; \n opacity: 0; \n will-change: height, margin-top, opacity; \n margin-top: -10px; \n transition: margin-top 0.15s ease-out, opacity 0.1s ease-out; \n overflow: hidden; \n } \n .cl-iframe-container.cl-iframe-visible { \n opacity : 1; \n pointer-events : auto; \n margin-top : 0; \n height: 455px; \n top: 490px; } \n .widget-placeholder { \n cursor : pointer \n} \n iframe.cl-frame { \n width: 100%; \n position: relative; \n overflow: hidden; \n height: 100%; \n border: 1px solid rgba(0, 0, 0, 0.1) \n } \n .placeholder-container \n { display: inline-flex; \n } \n.widget-badge \n{ border-radius: 20px; \n background: #CD4B5B; \n height: 16px; \n width: 16px; \n color: #ffffff; \n text-align: center; \n line-height: 16px; \n font-size: 11px; \n cursor: pointer; \n opacity: 1; \n will-change: scale; \n transition: all 0.3s; \n margin-top: 4px; \n margin-right: 5px;}";
    document.body.appendChild(t);
    this.createIFrame();
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
    f.addEventListener("load", this.onFrameLoad.bind(this))
    d.appendChild(f);
    this.iframeContainer = d;
    this.iframe = f;
}

ChangelogWidget.prototype.getIFrameUrl = function(){

    let widgetScript = document.getElementById('cl-script');
    let host = widgetScript ? widgetScript.src.replace(/(\/\/.*?\/).*/g, '$1') : 'https://logz.app/';
    return host + this.options.uuid + '/widgets';
}

ChangelogWidget.prototype.getIFrameTarget = function(){
    return document.body;
}

ChangelogWidget.prototype.onFrameLoad = function(e){
    let innerDoc = e.target.contentDocument || e.target.contentWindow.document;
    let headerElement =  innerDoc.querySelector('.header-label');
    headerElement.innerHTML = (this.options.translations && this.options.translations.headerLabel) ? this.options.translations.headerLabel : 'Latest Changes';
}

ChangelogWidget.prototype.toggle = function(e){
    this.isVisible ? this.hideIframe() : this.showIframe(e);
}

ChangelogWidget.prototype.hideIframe = function(){
    this.iframeContainer.classList.remove("cl-iframe-visible");
    this.isVisible = false;
}

ChangelogWidget.prototype.showIframe = function(ownerElement){
    this.setWidgetPosition(ownerElement);
    this.iframeContainer.classList.add("cl-iframe-visible");
    this.isVisible = true;
}

ChangelogWidget.prototype.setWidgetPosition = function(ownerElement){
    let top;
    let clientRects = ownerElement.target.getBoundingClientRect();
    //set alignment
    switch (this.options.position.alignment) {
        case 'right':
            let offsetRight = this.options.position.offsetRight ? parseInt(this.options.position.offsetRight) : 0;
            let pos = ((clientRects.left - this.iframeContainer.offsetWidth) + clientRects.width) + offsetRight;
            this.iframeContainer.style.left = pos + 'px';
            break;
        case 'left':
        default:
            let offsetLeft = this.options.position.offsetLeft ? parseInt(this.options.position.offsetLeft) : 0;
            this.iframeContainer.style.left = ((clientRects.left + 2) + offsetLeft) + 'px';
    }

    //set drop
    switch (this.options.position.drop) {
        case 'up':
            top = clientRects.top - this.iframeContainer.offsetHeight;
            break;
        case 'down':
        default:
            top = clientRects.top + clientRects.height + 5;

    }
    let offsetTop = this.options.position.offsetTop ? parseInt(this.options.position.offsetTop) : 0;
    this.iframeContainer.style.top = (top + offsetTop) + 'px';
}

document.addEventListener('DOMContentLoaded', function(){
    setTimeout(function(){
        new ChangelogWidget(typeof changelog_config !== 'undefined' ? changelog_config : {});
    }, 1000)
});
