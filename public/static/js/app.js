$(function() {
    // to enable tooltips with the default configuration
    $('[data-bs-toggle="tooltip"]').tooltip();
    $('form').submit(function(){
        $(this).find('[type=submit]').prop('disabled', true);
    });
});
function copyToClipboard(text, element) {
    navigator.clipboard.writeText(text);
    const tooltip = bootstrap.Tooltip.getInstance(element);
    if(typeof tooltip !== 'undefined'){
        tooltip.setContent({ '.tooltip-inner': 'Copied!' });
    }
}
