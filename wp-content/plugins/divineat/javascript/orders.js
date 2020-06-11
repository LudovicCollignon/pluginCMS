

function orders() {

    var addMenuBtn = document.getElementById('add_menu_btn');

    var addMenuArea = document.getElementById('add_menu_area');
    var removeBtn = document.getElementById('remove_menu_btn');
    
    if (addMenuBtn != null) {
        addMenuBtn.addEventListener('click', function(e) {
            var pSelect = addMenuArea.lastChild;
            var pSelectClone = pSelect.cloneNode(true);
            var select = pSelect.lastChild;
            var menuIndex = 1 + (+ select.name.substr(10));
            
            pSelectClone.firstChild.setAttribute('for', 'order_menu' + menuIndex);
            pSelectClone.firstChild.innerHTML = 'Menu ' + menuIndex + ' : ';
            
            pSelectClone.lastChild.name = 'order_menu' + menuIndex;
            pSelectClone.lastChild.id = 'order_menu' + menuIndex;       
            
            addMenuArea.appendChild(pSelectClone);
            
            removeBtn.style.display = 'inline-block';
        });
    }

    if (removeBtn != null) {  
        removeBtn.addEventListener('click', function(e) {
            var pSelect = addMenuArea.lastChild;
            pSelect.parentNode.removeChild(pSelect);
            pSelect = addMenuArea.lastChild;
            if (pSelect.lastChild.name.substr(10) == 1)
                this.style.display = 'none';
        });
    }
}