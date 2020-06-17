document.getElementById('menu2').style.display='none';
document.getElementById('menu3').style.display='none';
document.getElementById('menu4').style.display='none';

function addInputMenu(param){
    switch (param) {
        case '2':
            document.getElementById('menu2').style.display='block';
            document.getElementById('menu3').style.display='none';
            document.getElementById('menu4').style.display='none';
            break;
        case '3':
            document.getElementById('menu2').style.display='block';
            document.getElementById('menu3').style.display='block';
            document.getElementById('menu4').style.display='none';
            break;
        case '4':
            document.getElementById('menu2').style.display='block';
            document.getElementById('menu3').style.display='block';
            document.getElementById('menu4').style.display='block';
            break;
        default:
            document.getElementById('menu2').style.display='none';
            document.getElementById('menu3').style.display='none';
            document.getElementById('menu4').style.display='none';
    }
}