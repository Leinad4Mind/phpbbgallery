"use strict";

document.getElementById("bbfrontclick").addEventListener("click", function(e) {
  e.preventDefault();
  const val = this.getAttribute("data-options");
  fetch(val, {
    method: "POST",
    headers: {
      'content-type' : 'application/json'
    }
  }).then(res=>res.json())
  .then((data) => {
  //   console.log("status response:", data)
     document.getElementById("bbfronticon").setAttribute("class", data.status);
     document.getElementById("bbfrontclick").setAttribute("title", data.title);
  })
});