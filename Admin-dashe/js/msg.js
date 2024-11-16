// juste pour selectionner tous les 'checkboxes' :
var selectAll = document.getElementById('checkAl');
var checkboxes = document.querySelectorAll('.custom-control-input');
selectAll.addEventListener('click', function () {
    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].checked = this.checked; //si je met juste true il va etre #tjrs# checked !! 
    }
});