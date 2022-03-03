"use strict;"
const form=document.querySelector("form");
const title=document.querySelector("input[type='text']");
const ul=document.querySelector("ul");
const checkbox=document.querySelectorAll("input[type='checkbox'");

title.focus();
form.addEventListener("submit",e =>{
  e.preventDefault();
  if(title.value === ""){
    alert("入力してください");
    return;
  }
  fetch("?action=add",{
    method:"POST",
    body:new URLSearchParams({
      title:title.value,
    })
  })
  .then(response =>{
    return response.json();
  })
  .then(json =>{
    console.log(json);
    addTodo(json , title.value);
    title.value="";
  })
})
function addTodo(id , title){
  const li=document.createElement("li");
  li.dataset.id=id;
  const label=document.createElement("label");
  const titleSpan=document.createElement("span");
  titleSpan.textContent=title;
  const deleteSpan=document.createElement("span");
  deleteSpan.textContent="x";
  deleteSpan.classList.add("delete");
  const checkbox=document.createElement("input");
  checkbox.type="checkbox";
  label.appendChild(checkbox);
  label.appendChild(titleSpan);
  li.appendChild(label);
  li.appendChild(deleteSpan);
  ul.insertBefore(li,ul.firstChild);
}
ul.addEventListener("click",e =>{
  if(e.target.classList.contains("delete")){
    fetch("?action=delete",{
      method:"POST",
      body:new URLSearchParams({
        id:e.target.parentNode.dataset.id,
      })
    })
    e.target.parentNode.remove();
  }
  if(e.target.type === "checkbox"){
    fetch("?action=toggle",{
      method:"POST",
      body:new URLSearchParams({
        id:e.target.parentNode.parentNode.dataset.id,
      })
    })
  }
})
document.getElementById("purge").addEventListener("click",()=>{
  fetch("?action=purge",{
    method:"POST",
  })
  checkbox.forEach(check =>{
    if(check.checked){
      check.parentNode.parentNode.remove();
      console.log(check);
    }
  })
})