/* Settings
------------------------------------------------------------------------*/

// jQueryObjects
var $doc = document,
    $w = window,
    $html = document.querySelector('html'),
    $body,
    $page,
    $changeImg;

// commonSettings
var abi = {
    bp_tab: 1024,
    bp_sp: 767,
    pc: '',
    tab: '',
    sp: '',
    pcView: '',
    tabView: '',
    spView: '',
    finish: '',
    deviceWidth: '',
    deviceHeight: '',
    sT: '',
    ie9: ($html.classList.contains('ie9')) ? true : false,
    ie8: ($html.classList.contains('ie8')) ? true : false,
    ua_mouse: ($html.classList.contains('mouse')) ? true : false,
    ua_touch: ($html.classList.contains('touch')) ? true : false,
    ua_phone: ($html.classList.contains('phone')) ? true : false
}


/* Functions & Plugins
------------------------------------------------------------------------*/

// rwdFunctions
var rwdFunctions = {
    // checkValue
    checkValue: function () {
        abi.deviceWidth = (abi.ie8) ? $w.innerWidth : window.innerWidth;
        abi.deviceHeight = $w.innerHeight;
        abi.pc = (abi.ie8 || abi.deviceWidth > abi.bp_tab) ? true : false;
        abi.tab = (!abi.ie8 && abi.deviceWidth <= abi.bp_tab && abi.deviceWidth > abi.bp_sp) ? true : false;
        abi.sp = (!abi.ie8 && abi.deviceWidth <= abi.bp_sp) ? true : false;
    },
    // fooLoad
    fooLoad: function ($o) {
        $o.forEach(function (element) {
            element.setAttribute('src', element.getAttribute('data-img'));
        });
    },
    // loadImg
    loadImg: function () {
        abi.finish = (abi.pcView && abi.tabView && abi.spView) ? true : false;
        if (!abi.ie8 && !abi.finish) {
            if (abi.pc || abi.tab) {
                if (!abi.pcView || !abi.tabView) {
                    rwdFunctions.fooLoad(document.querySelectorAll('img.load_pc-tab'));
                }
                if (abi.pc && !abi.pcView) {
                    rwdFunctions.fooLoad(document.querySelectorAll('img.load_pc'));
                    abi.pcView = true;
                }
                if (abi.tab && !abi.tabView) {
                    rwdFunctions.fooLoad(document.querySelectorAll('img.load_tab-sp'));
                    abi.tabView = true;
                }
            } else if (!abi.spView) {
                rwdFunctions.fooLoad(document.querySelectorAll('img.load_sp,img.load_tab-sp'));
                abi.spView = true;
            }
        } else if (!abi.pcView) {
            abi.pcView = true;
        }
    },
    // changeImg
    changeImg: function () {
        if (!abi.ie8) {
            for (var i = 0; i <= $changeImg.length - 1; i++) {
                if ($changeImg[i].classList.contains('custom')) {

                    if (abi.deviceWidth > $changeImg[i].getAttribute('data-custom')) $changeImg[i].setAttribute('src', $changeImg[i].getAttribute('data-img'));
                    else $changeImg[i].setAttribute('src', $changeImg[i].getAttribute('data-img').replace('-before', '-after'));

                } else if (!$changeImg[i].classList.contains('tab') && !$changeImg[i].classList.contains('all')) {

                    if (!abi.sp) $changeImg[i].setAttribute('src', $changeImg[i].getAttribute('data-img'));
                    else $changeImg[i].setAttribute('src', $changeImg[i].getAttribute('data-img').replace('-pc', '-sp'));

                } else if ($changeImg[i].classList.contains('tab')) {

                    if (abi.pc) $changeImg[i].setAttribute('src', $changeImg[i].getAttribute('data-img'));
                    else $changeImg[i].setAttribute('src', $changeImg[i].getAttribute('data-img').replace('-pc', '-tab'));

                } else if ($changeImg[i].classList.contains('all')) {

                    if (abi.pc) $changeImg[i].setAttribute('src', $changeImg[i].getAttribute('data-img'));
                    else if (abi.tab) $changeImg[i].setAttribute('src', $changeImg[i].getAttribute('data-img').replace('-pc', '-tab'));
                    else if (abi.sp) $changeImg[i].setAttribute('src', $changeImg[i].getAttribute('data-img').replace('-pc', '-sp'));

                }
            }
        }
    },
    // adjustFsz
    adjustFsz: function () {
        if (abi.sp) {
            if (abi.deviceHeight > abi.deviceWidth) {
                var p = abi.deviceWidth / 3.2;
                $page.style.fontSize = p + '%';
            } else {
                $page.style.fontSize = '';
            }
        }
    },
    // settingRwd
    settingRwd: function () {
        rwdFunctions.checkValue();
        rwdFunctions.changeImg();
        rwdFunctions.loadImg();
        rwdFunctions.adjustFsz();
    }
}

// superResize
Element.prototype.superResize = function (options) {
    var defaults = {
        loadAction: true,
        resizeAfter: function () { }
    };
    var setting = Object.assign({}, defaults, options);

    if (setting.loadAction)
        this.onload = function () {
            setting.resizeAfter();
        };

    var timer = false,
        w = abi.deviceWidth;

    this.onresize = function () {
        if (timer !== false) clearTimeout(timer);
        timer = setTimeout(function () {
            if (w != abi.deviceWidth) {
                setting.resizeAfter();
                w = abi.deviceWidth;
            }
        }, 300);
    };

    return (this);
};

// firstLoad
Element.prototype.firstLoad = function (options) {
    var defaults = {
        pc: function () { },
        pc_tab: function () { },
        tab: function () { },
        tab_sp: function () { },
        sp: function () { }
    };
    var setting = Object.assign({}, defaults, options);

    var first = [];

    this.superResize({
        resizeAfter: function () {
            setTimeout(function () {
                if (first[0] != true && abi.pcView) {
                    setting.pc();
                    first[0] = true;
                }
                if (first[1] != true && (abi.pcView || abi.tabView)) {
                    setting.pc_tab();
                    first[1] = true;
                }
                if (first[2] != true && abi.tabView) {
                    setting.tab();
                    first[2] = true;
                }
                if (first[3] != true && (abi.tabView || abi.spView)) {
                    setting.tab_sp();
                    first[3] = true;
                }
                if (first[4] != true && abi.spView) {
                    setting.sp();
                    first[4] = true;
                }
            }, 200);
        }
    });

    return (this);
};

// hasAttr
Element.prototype.hasAttr = function (name) {
    return this.hasAttribute(name);
}
