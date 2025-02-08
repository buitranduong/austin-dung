if(window.hasOwnProperty('localStorage')){
    //const currentUrl = window.location.href;
    const currentUrl = (window.location.pathname + window.location.search);
    let historyBrowser = window.localStorage.getItem('historyBrowser');
    const $fieldHistoryBrowser = document.getElementById('historyBrowser');
    if($fieldHistoryBrowser !== null){
        $fieldHistoryBrowser.value = historyBrowser;
    }
    if(historyBrowser){
        historyBrowser = JSON.parse(historyBrowser);
        if (historyBrowser.length >= 30){
            historyBrowser.pop();
        }
        historyBrowser.unshift(currentUrl);
    }else{
        historyBrowser = [];
        historyBrowser.unshift(currentUrl);
    }
    window.localStorage.setItem('historyBrowser', JSON.stringify(historyBrowser));
}
