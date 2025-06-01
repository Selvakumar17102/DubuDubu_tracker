setInterval(function() {
    let div = document.getElementById('list-group');
    if (div) {
        div.innerHTML = div.innerHTML;
    }
}, 500);