let ChangelogWidget = (function(){
    let defaults = {
        protocol : 'http:',
        container : 'body',
        triggerElement : null,
        translations : {
            placeholderLabel : 'Release Notes',
            headerLabel : 'Latest News'
        },
        position : {
            alignment : 'left',
            drop : 'down',
            offsetTop : 0,
            offsetBottom : 0,
            offsetRight : 0,
            offsetLeft : 0,
        },
        useIframe : !1
    };

    function ChangelogWidget(options)
    {
        this.options = { ...defaults, ...options }
        this.container = document.querySelector(this.options.container);
        this.iframeContainer = null;
        this.iframe = null;
        this.isVisible = !1;
        this.mounted = 0;
        this.humanized = !0;
        this.init();
        console.log('Changelog widget initialized...');
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

        this.elements.placeholderContainer.addEventListener("click", this.toggleWidgetDisplay.bind(_this), !1);
        window.addEventListener('resize', function(){
            _this.setWidgetPosition(_this.elements.placeholderContainer);
        });
    }

    if (typeof this.elements.trigger !== 'undefined' && this.elements.trigger) {
        this.toggleTriggerDisplay();
        _this.elements.trigger.addEventListener("mousedown", this.toggleWidgetDisplay.bind(_this), !1);
        window.addEventListener('resize', function(){
            _this.setWidgetPosition(_this.elements.trigger);
        });
    }

    if (this.options.useIframe) {
        t = document.createElement("style");
        t.id = "cl-styles-container";
        t.textContent = ".cl-widget-container { \n pointer-events: none; \n border-radius: 4px; \n box-shadow: 0 0 1px rgba(99, 114, 130, 0.32), 0 8px 16px rgba(27, 39, 51, 0.08); \n background: #fff; \n border: none; \n position: fixed; \n top: -900em; \n z-index: 2147483647; \n width: 340px; \n height: 455px; \n opacity: 0; \n will-change: height, margin-top, opacity; \n margin-top: -10px; \n transition: margin-top 0.15s ease-out, opacity 0.1s ease-out; \n overflow: hidden; \n } \n .cl-widget-container.cl-widget-visible { \n opacity : 1; \n pointer-events : auto; \n margin-top : 0; \n height: 455px; \n top: 490px; } \n .widget-placeholder { \n cursor : pointer \n} \n iframe.cl-frame { \n width: 100%; \n position: relative; \n overflow: hidden; \n height: 100%; \n border: 1px solid rgba(0, 0, 0, 0.1) \n } \n .placeholder-container \n { display: inline-flex; \n } \n.widget-badge \n{ border-radius: 20px; \n background: #CD4B5B; \n height: 16px; \n width: 16px; \n color: #ffffff; \n text-align: center; \n line-height: 16px; \n font-size: 11px; \n cursor: pointer; \n opacity: 1; \n will-change: scale; \n transition: all 0.3s; \n margin-top: 4px; \n margin-right: 5px;}";
        document.body.appendChild(t);
        this.createIFrame();
        this.toggleTriggerDisplay();
    } else {
        let  fileRef = document.createElement("link");
        fileRef.setAttribute("rel", "stylesheet");
        fileRef.setAttribute("type", "text/css");
        fileRef.setAttribute("href", this.getHost() + 'css/widget.css');
        document.getElementsByTagName("head")[0].appendChild(fileRef)
        this.getChangelogs();
    }

    document.addEventListener('mousedown', function(e){
        if (_this.iframeContainer && !_this.iframeContainer.contains(e.target) && e.button === 0) {
            _this.hideWidget();
        }
        e.stopImmediatePropagation();
    });
}

ChangelogWidget.prototype.getChangelogs = function(){
    let widgetScript = document.getElementById('cl-script');
    let host = widgetScript ? widgetScript.src.replace(/(\/\/.*?\/).*/g, '$1') : 'https://logz.app/';
    let _this = this;
    fetch(host + 'api/' + this.options.uuid + '/published/changelogs?displayType=widget').then(response => response.json()).then(data => _this.renderChangelogs(data));
}

ChangelogWidget.prototype.renderChangelogs = function(changelogs){
    if (changelogs.length > 0) {
        let container = document.createElement("div");
        container.classList.add("cl-widget-container");
        this.getIFrameTarget().appendChild(container);
        let headerLabel = (this.options.translations && this.options.translations.headerLabel) ? this.options.translations.headerLabel : 'Latest Changes';
        let r = '';

        for (let i = 0; i < changelogs.length; i++) {

            let hLine = ((changelogs.length - 1) === i) ? '' : '<h2 class="hr-line-text"><span></span></h2>';
            r += '<div>' +
                    '<div  class="changelog-callout">' +
                        '<div  class="callout-header">' +
                            '<div class="callout-subheader mb-2">' +
                                '<div>' +
                                    '<h4  class="mb-0 changelog-title">'+ changelogs[i].title +'</h4>' +
                                    '<small  class="text-muted date-container">' +
                                        '<span class="changelog-date-label" data-date="'+ changelogs[i].created_at +'"> '+ this.getFormattedTime(changelogs[i].created_at) +'</span>' +
                                    '</small>' +
                                '</div>' +
                                '<span  class="badge " style="background-color: '+ changelogs[i].category.bg_color +'; color: '+ changelogs[i].category.text_color +';">'+ changelogs[i].category.label +'</span> ' +
                            '</div>' +
                        '</div>' +
                        '<div class="changelog-body">' + changelogs[i].body + '</div>' +
                    '</div>'+ hLine +
                '</div>';
        }

        container.innerHTML =
            '<div class="cl-widget-wrapper">' +
            '<h6 class="text-center header-label" style="text-align: center !important;">'+ headerLabel +'</h6>' +
            '<div class="changelogs-container changelog-scrollable">' +
            r +
            '</div>' +
            ' <div class="changelog-widget-footer">' +
            '   <h6 class="text-center" style="font-size: 0.75rem;">' +
            '<span class="text-muted read-more" style="cursor: pointer;">Read more...</span></h6>' +
            '</div>' +
            '</div>';
        let _this = this;
        let readMoreLink = document.querySelector('.read-more');
        readMoreLink.addEventListener('click', function(e){
            window.open(_this.getHost() + _this.options.uuid + '/changelogs/redirect');
            e.preventDefault();
        });

        this.toggleTriggerDisplay();

        setInterval(this.updateTime.bind(this), 60000)

        this.iframeContainer = container;
    }
}

ChangelogWidget.prototype.createIFrame = function(){
    let f = document.createElement("iframe");
    let d = document.createElement("div");
    d.classList.add("cl-widget-container");
    f.classList.add("cl-frame");
    this.getIFrameTarget().appendChild(d);
    f.referrerPolicy = "strict-origin",
    f.sandbox = "allow-same-origin allow-scripts allow-top-navigation allow-popups allow-forms allow-popups-to-escape-sandbox",
    f.src = this.getIFrameUrl();
    d.appendChild(f);
    this.iframeContainer = d;
    this.iframe = f;
}

ChangelogWidget.prototype.getHost = function(){
    let widgetScript = document.getElementById('cl-script');
    return widgetScript ? widgetScript.src.replace(/(\/\/.*?\/).*/g, '$1') : 'https://logz.app/';
}

ChangelogWidget.prototype.getIFrameUrl = function(){
    let headerLabel = (this.options.translations && this.options.translations.headerLabel) ? this.options.translations.headerLabel : 'Latest Changes';
    let params = '?headerLabel=' + headerLabel;
    return this.getHost() + this.options.uuid + '/widgets' + params;
}

ChangelogWidget.prototype.getIFrameTarget = function(){
    return document.body;
}

ChangelogWidget.prototype.onFrameLoad = function(e){
     let headerElement = this.iframe.contentWindow.document.querySelector('.header-label');
     headerElement.innerHTML = (this.options.translations && this.options.translations.headerLabel) ? this.options.translations.headerLabel : 'Latest Changes';
}

ChangelogWidget.prototype.toggleWidgetDisplay = function(e){
    if (e.button !== 0) {
        return
    }

    if (this.isVisible) {
        this.hideWidget()
    } else {
        if (e.target.closest('.nav-item')) {
            e.target.closest('.nav-item').click();
        }
        this.showWidget(e)
    }

    e.stopImmediatePropagation();
}

ChangelogWidget.prototype.hideWidget = function(){
    if (this.iframeContainer) {
        this.iframeContainer.classList.remove("cl-widget-visible");
    }
    this.isVisible = false;
}

ChangelogWidget.prototype.showWidget = function(ownerElement){
    this.setWidgetPosition(ownerElement);
    if (this.iframeContainer) {
        this.iframeContainer.classList.add("cl-widget-visible");
    }
    this.isVisible = true;
}

ChangelogWidget.prototype.setWidgetPosition = function(ownerElement){
    let top;
    let clientRects = (ownerElement.target) ? ownerElement.target.getBoundingClientRect() : ownerElement.getBoundingClientRect();
    let containerOffsetHeight = 0;
    let containerOffsetWidth = 0;

    if (this.iframeContainer) {
        containerOffsetHeight = this.iframeContainer.offsetHeight;
        containerOffsetWidth = this.iframeContainer.offsetWidth;
    }
    //set alignment
    switch (this.options.position.alignment) {
        case 'right':
            let offsetRight = this.options.position.offsetRight ? parseInt(this.options.position.offsetRight) : 0;
            let pos = ((clientRects.left - containerOffsetWidth) + clientRects.width) + offsetRight;
            if (this.iframeContainer) {
                this.iframeContainer.style.left = pos + 'px';
            }

            break;
        case 'left':
        default:
            let offsetLeft = this.options.position.offsetLeft ? parseInt(this.options.position.offsetLeft) : 0;
            if (this.iframeContainer) {
                this.iframeContainer.style.left = ((clientRects.left + 2) + offsetLeft) + 'px';
            }
    }

    //set drop
    switch (this.options.position.drop) {
        case 'up':
            top = clientRects.top - containerOffsetHeight;
            break;
        case 'down':
        default:
            top = clientRects.top + clientRects.height + 5;

    }
    let offsetTop = this.options.position.offsetTop ? parseInt(this.options.position.offsetTop) : 0;
    if (this.iframeContainer) {
        this.iframeContainer.style.top = (top + offsetTop) + 'px';
    }
}

ChangelogWidget.prototype.getFormattedTime = function(time) {
    if (typeof moment === 'undefined') {
        let fileRef = document.createElement('script')
        fileRef.setAttribute("type","text/javascript")
        fileRef.setAttribute("src", this.getHost() + '/js/moment.min.js');
        document.getElementsByTagName("head")[0].appendChild(fileRef)

        let tzFileRef = document.createElement('script')
        tzFileRef.setAttribute("type","text/javascript")
        tzFileRef.setAttribute("src", this.getHost() + '/js/moment-timezone.js');
        document.getElementsByTagName("head")[0].appendChild(tzFileRef)
    }

    return this.humanized ? this.fixDurationHumanize(time) + ' ago' : this.fixDurationUTCRelative(time);
}

ChangelogWidget.prototype.updateTime = function(){
    let dateLabels = document.querySelectorAll('.changelog-date-label');

    for (let dateLabel of dateLabels) {
        dateLabel.innerHTML = ' ' + this.getFormattedTime(dateLabel.getAttribute('data-date'))
    }
}

ChangelogWidget.prototype.toggleTriggerDisplay = function() {
    if (this.elements.trigger) {
        this.elements.trigger.style.display = (this.elements.trigger.style.display === 'none') ? '' : 'none';
    }
}

ChangelogWidget.prototype.fixDurationHumanize = function(dt){
    if (dt === undefined) {
        return '-'
    }

    let now = window.timezone ? moment.utc(new Date()).tz(window.timezone) : moment.utc(new Date())
    let end = window.timezone ? moment.utc(dt).tz(window.timezone) : moment.utc(dt)
    let duration = moment.duration(now.diff(end))
    let as_seconds = duration.asSeconds()

    return moment.duration(as_seconds, "seconds").humanize()
}

ChangelogWidget.prototype.fixDurationUTCRelative = function(dt){
    if (dt) {
        let now = moment.utc()
        let datetime = moment.utc(dt)
        let duration = now.diff(datetime, 'seconds')

        if (moment.duration(duration, 'seconds').hours() >= 1) {
            return moment.duration(duration, 'seconds').format('HH:mm:ss', {
                trim: false
            })
        } else {
            return moment.duration(duration, 'seconds').format('mm:ss', {
                trim: false
            })
        }
    } else {
        return ''
    }
}

window.addEventListener('load', function(){
    setTimeout(function(){
        new ChangelogWidget(typeof changelog_config !== 'undefined' ? changelog_config : {});
    }, 1000)
});
