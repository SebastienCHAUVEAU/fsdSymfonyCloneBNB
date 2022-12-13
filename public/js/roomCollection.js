let container = document.getElementById("divForm");
const template = container.dataset.template;
const popButton = document.getElementById("buttonPop");
const divAppend = document.getElementById("appendDiv");
const removeButtons=document.querySelectorAll(".removeBed");

function onClickRemove(){
    this.parentElement.remove();
};

popButton.addEventListener("click",function(e){
    const newDiv = document.createElement("div");
    const buttonDivDelete = document.createElement("button");
    buttonDivDelete.innerText = "SUPPRIMER";
    buttonDivDelete.classList.add("removeBed");
    newDiv.innerHTML += template.replace(
        /__name__/g,
        container.dataset.index
    );
    newDiv.append(buttonDivDelete);
    divAppend.append(newDiv);
    divAppend.querySelector(".removeBed").addEventListener("click", onClickRemove);
    container.dataset.index++;
});

for(let removeButton of removeButtons){
    removeButton.addEventListener("click", onClickRemove);
};
