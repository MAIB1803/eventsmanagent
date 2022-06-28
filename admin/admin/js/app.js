let nav = () => {
    let grid = document.querySelector('.grid-15-85');
    let sidebody = document.querySelector('.sidebody');
    grid.classList.toggle("grid-15-85-change");
    sidebody.classList.toggle("sidebody-change");
}
CKEDITOR.replace('desc');


// CKEDITOR.instances.desc.setData("hh")
// let desc = CKEDITOR.instances.desc.getData();
// console.log(desc);