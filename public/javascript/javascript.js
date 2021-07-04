window.onload = function() {
    var elems = document.getElementsByClassName('confirmDelete');

    var confirmIt = function(e) {
        if (!confirm('Are you sure you want to delete the selected item?')) e.preventDefault();
    };

    for (var i = 0, l = elems.length; i < l; i++) {
        elems[i].addEventListener('click', confirmIt, false);
    }
}