const REMOVE_TWO_STAR = /([\*])\1+/;
const HEADS = ['086', '089', '088', '092', '099', '087', '055', '096', '090', '091',
    '056', '059', '097', '093', '094', '058', '098', '070', '083', '032', '079', '084', '033',
    '077', '085', '034', '076', '081', '035', '078', '082', '036', '037', '038', '039','052'];

function handleSearchSubmit(event) {
    event.preventDefault(); // Prevent the default form submission
    var keyword = event.target.elements.q.value.trim()
    if (keyword!=="*") {
        var regex = /^\d{10,11}$/;
        var isValidPhoneNumber = regex.test(keyword);
        if (isValidPhoneNumber) {
            var baseUrl = window.location.protocol + "//" + window.location.host;
            if (HEADS.includes(keyword.substring(0, 3))) {
                window.location.replace(`${baseUrl}/${keyword}`);
            } else {
                window.location.replace(`${baseUrl}/tim-sim/${keyword}.html`);
            }
            return false;
        }
        var now = new Date();
        var time = now.getTime();
        time += 3600 * 1000;
        now.setTime(time);
        document.cookie = `${getUrlByKeyWord(keyword)}=${keyword}; expires=${now.toUTCString()}; path=/`;
        value = `/${getUrlByKeyWord(keyword)}`;
        window.location.replace(value);
    }
    return false;
}

function handleSearchChange(e) {
    let valueConvert = e.target.value;
    e.target.value = valueConvert.replace(/[^0-9*]/g, "").replace(/\*+/g, '*');
    return e.target.value = e.target.value.match(/^([^e+-]{0,11})/)[0];
}

function getUrlByKeyWord(keyword) {
    var arr = keyword.replace(REMOVE_TWO_STAR, '*').split('*')
    //console.log("arr", arr);
    // loai phan tu dau va cuoi neu empty
    let url = ``
    if (arr[0]==="") {
        arr.splice(0,1)
    }
    //console.log("arr1111", arr);
    // kiem tra sau khi xoa phan tu empty dau, neu do dai =3 thi chuyen sang tim-sim 098*12*
    if (arr.length >= 3) {
        arr = arr.slice(0,3);
        url= `tim-sim/${keyword}.html`
        //console.log("arr2", url);
        return url;
    }
    // sau do xoa phan tu cuoi di de check tiep, con *7777*
    if (arr[arr.length-1]==="") {
        arr.splice(arr.length-1,1)
    }
    if (arr.length === 1 && arr[0].length > 0) {
        url = searchSingle(arr[0], keyword)
        console.log("arr3", url);

    } else if (arr.length === 2) {
        url= `tim-sim/${arr.join("*")}.html`
        console.log("arr4", url);

    }
    return url
}

function searchSingle(subkey, keyword) {
    var url = null;
    if (keyword[0] === "*" && keyword[keyword.length - 1] === "*") {
        url = getSearchTailNicePath(subkey, true);
    }
    else {
        url= getSearchTailNicePath(keyword, false);
    }
    if (url) {
        return url;
    }
    // neu search dang *3224 thi bo * đi
    if (keyword[0] === "*" && keyword[keyword.length - 1] !== "*") {
        keyword = keyword.slice(1);
    }
    return `tim-sim/${subkey}.html`
}

function getSearchTailNicePath(subkey, is_middle) {
    var subkey_clone = subkey.slice(0).replace("*", '')
    const sameDigit = checkSameDigits(subkey_clone);
    var url = "";
    if (sameDigit && `${subkey_clone}`.length >= 2) {
        const numLength = subkey_clone.length;
        if (numLength === 3) {
            url= `sim-tam-hoa-${subkey_clone}`
        } else if (numLength === 4) {
            url= `sim-tu-quy-${subkey_clone}`
        } else if (numLength === 5) {
            url= `sim-ngu-quy-${subkey_clone}`
        } else if (numLength === 6) {
            url= `sim-luc-quy-${subkey_clone}`
        }
        if (is_middle) {
            return `${url}-giua`;
        } else {
            return url;
        }
    }
    const current_year = new Date().getFullYear();
    if (subkey_clone >= 1950 && subkey_clone <= current_year + 1) {
        return `sim-nam-sinh-${subkey.replaceAll("*", "")}.html`
    }
    // neu khong phai search giua thi moi tim dau so
    if(!is_middle) {
        const itemTel = HEADS.find((item) => {
            if (item.startsWith(subkey.substring(0,2)) || subkey.startsWith(item) || subkey.startsWith(item.substring(0,3))) {
                return true;
            }
        })
        // neu la đầu số và keyword dai 2,3,4 ký tự, neu lon hon 5 kt thi chuyen sang tim-sim/keyword.html
        // console.log(itemTel, subkey)
        if (itemTel && [2,3,4].includes(subkey.slice().replaceAll("*", "").length)) {
            return `sim-dau-so-${subkey.replaceAll("*", "")}.html`
        } else if (subkey[subkey.length - 1] === "*") {
            return `tim-sim/${subkey}.html`
        }
        return null;
    } else {
        return `tim-sim/*${subkey_clone}*.html`
    }
}
function checkSameDigits(number) {
    var numberStr = number.toString();
    var firstDigit = numberStr[0];
    for (var i = 1; i < numberStr.length; i++) {
        if (numberStr[i] !== firstDigit) {
            return false;
        }
    }
    return true;
}
function resetFilters(keepQuery='') {
    // Get the current URL
    var url = window.location.href;
    // Remove query string parameters
    var updatedUrl = url.split('?')[0];
    // Update the URL without query string parameters
    if(keepQuery)  {
        return window.location.href = updatedUrl+'?'+keepQuery;
    }
    window.location.href = updatedUrl;
}
function toggleFilter(key, value, type=1) {
    // Get the current URL
    var url = window.location.href;
    // Extract the query string from the URL
    var baseUrl = url.split('?')[0];
    var queryString = url.split('?')[1];
    // Parse the query string into key-value pairs
    var params = new URLSearchParams(queryString);
    const paramArray = {};
    for (const [key, value] of params.entries()) {
        if (key!=="p") {
            paramArray[key] = value;
        }
    }
    if (type===-1) {
        param_values = paramArray[key].split(",");
        param_values = param_values.filter(function(item) {
            return item !== value;
        });
        if (param_values.length===0) {
            delete paramArray[key];
        } else {
            paramArray[key] = param_values.join(",");
        }
    } else { // them
        paramArray[key] = value;
    }
    queryString = Object.entries(paramArray)
        .map(([key, value]) => `${encodeURIComponent(key)}=${encodeURIComponent(value)}`)
        .join('&');
    var updatedUrl = baseUrl;
    if(queryString){
        updatedUrl = baseUrl + '?' + queryString;
    }
    window.location.href = updatedUrl;
}
function toggleFilterWithLink(key, value,link, type=1) {
    // Get the current URL
    var url = window.location.href;
    // Extract the query string from the URL
    var baseUrl = url.split('?')[0];
    var queryString = url.split('?')[1];
    // Parse the query string into key-value pairs
    var params = new URLSearchParams(queryString);
    const paramArray = {};
    for (const [key, value] of params.entries()) {
        // loai bo param ko can thiet de check xem url co param empty ko
        if (key!=="p") {
            paramArray[key] = value;
        }
    }
    // neu url
    const currentPath = window.location.pathname;
    if (currentPath==="/") {
        window.location.href= link;
    } else {
        // Convert the key-value pairs to an array
        if (type===-1) {
            param_values = paramArray[key].split(",");
            param_values = param_values.filter(function(item) {
                return item !== value;
            });
            if (param_values.length===0) {
                delete paramArray[key];
            } else {
                paramArray[key] = param_values.join(",");
            }
        } else { // them
            paramArray[key] = value;
        }
        queryString = Object.entries(paramArray).map(([key, value]) => `${key}=${value}`).join('&');
        window.location.href = baseUrl + '?' + queryString;
    }
}

function handlePricesForm(form) {
    const min_price = form.elements.price_min.value;
    const max_price = form.elements.price_max.value;
    var pricef = min_price.replaceAll('.', '');
    var pricee = max_price.replaceAll('.', '');
    if(Number.parseInt(pricef) < Number.parseInt(pricee)){
        // if(pricef%1000000===0){
        //   pricef = (pricef/1000000)+"-trieu";
        // }
        // else{
        //   pricef = (pricef/1000)+"-nghin";
        // }
        // if(pricee%1000000===0){
        //   pricee = (pricee/1000000)+"-trieu";
        // }else {
        //   pricee = (pricee/1000)+"-nghin";
        // }
        //window.location.href='/sim-'+pricef+'-den-'+pricee;
        window.location.href = `/sim-theo-gia?pr=${pricef}-${pricee}`;
    } else {
        alert("Khoảng giá không phù hợp, xin hãy chọn lại.");
    }
    return false;
}
function handleFilterAdvForm(e, form, phong_thuy_query='') {
    e.preventDefault();
    const t = [];
    const h = [];
    const notIn = [];
    const check_tel_checkbox = form.querySelectorAll('input[type="checkbox"][name="check_tel"]');
    check_tel_checkbox.forEach(function(checkbox) {
        if (checkbox.checked) {
            t.push(checkbox.value);
        }
    });

    const check_head_checkbox = form.querySelectorAll('input[type="checkbox"][name="check_head"]');
    check_head_checkbox.forEach(function(checkbox) {
        if (checkbox.checked) {
            h.push(checkbox.value);
        }
    });
    const notIn_checkbox = form.querySelectorAll('input[type="checkbox"][name="notIn"]');
    notIn_checkbox.forEach(function(checkbox) {
        if (checkbox.checked) {
            notIn.push(checkbox.value);
        }
    });
    const price_range = form.elements.pr.value;
    const d = form.elements.d.value;
    // const max_price = form.elements.max_price.value;
    const c = form.elements.cate.value;

    paramArray = {};
    if (t.length>0) {
        paramArray['t'] = t.join(",");
    }
    if (h.length>0) {
        paramArray['h'] = h.join(",");
    }
    if (notIn.length>0) {
        paramArray['notIn'] = notIn.join(",");
    }
    if (c) {
        paramArray['c'] = c;
    }
    if (price_range) {
        paramArray['pr'] = price_range;
    }
    if (d) {
        paramArray['d'] = d;
    }
    var url = window.location.href;
    // Extract the query string from the URL
    var baseUrl = url.split('?')[0];
    queryString = Object.entries(paramArray).map(([key, value]) => `${key}=${value}`).join('&');
    if(phong_thuy_query){
        if(queryString){
            queryString = `${queryString}&${phong_thuy_query}`;
        }else{
            queryString = phong_thuy_query;
        }
    }
    if (queryString) {
        queryString = "?"+queryString;
    }
    window.location.href = baseUrl + queryString;
    return false;
}
function resetAdvForm(e, formId) {
    e.preventDefault();
    var form = document.getElementById(formId);
    var checkboxes = form.querySelectorAll('input[type="checkbox"]');
    var radios = form.querySelectorAll('input[type="radio"]');
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = false;
    }
    for (var i = 0; i < radios.length; i++) {
        radios[i].checked = false;
    }
    var selectElement = document.getElementById("filter_pr");
    selectElement.selectedIndex = 0;

    selectElement = document.getElementById("filter_cate");
    selectElement.selectedIndex = 0;
}
// Fixed ios click btn done -> go search
function keyboardEnter(input)
{
    // if keyword length >=2
    if(iOSDevice() && input.value.length >= 2){
        document.getElementById('search-submit').click();
    }
}

function iOSDevice() {
    return /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
}

function activeSelect(e, cls)
{
    const els = document.querySelectorAll(`.${cls}`);
    if(els && els.length){
        if(e.value){
            els.forEach((select)=>{
               select.classList.remove("active");
               select.classList.add("active");
            });
        }else{
            els.forEach((select)=>{
                select.classList.remove("active");
            });
        }
    }
}
