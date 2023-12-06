const userBoard = document.querySelectorAll('.clickable_USER')
const cpuBoard = document.querySelectorAll('.clickable_CPU')
const id = document.querySelector('#id');
const player = document.querySelector('#player');
const tryShot = document.querySelector('#form')

const shot = (e) => {
    id.value=e.target.id;
    tryShot.submit();
}
if(player.value=='user'){
    userBoard.forEach(table => {
    table.addEventListener('click',shot);
    })
}else {
    cpuBoard.forEach(table => {
    table.addEventListener('click',shot);
    });
}
