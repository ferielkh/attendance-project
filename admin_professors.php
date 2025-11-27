<?php
session_start();
include "admin_navbar.php"; // keeps the navbar
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Manage Professors</title>
<link rel="stylesheet" href="style.css">
<style>
.cart { 
    background:#f7f7f7; 
    padding:20px; 
    border-radius:10px; 
    margin:20px auto; 
    width:80%; 
    box-shadow:0 2px 6px rgba(0,0,0,0.1);
}
table { 
    border-collapse: collapse; 
    width: 100%; 
}
th, td { 
    border:1px solid #ccc; 
    padding:8px; 
    text-align:center; 
}
th { 
    background:#2b6a4a; 
    color:white; 
}
button { 
    padding:5px 10px; 
    border:none; 
    border-radius:5px; 
    background:#2b6a4a; 
    color:white; 
    cursor:pointer; 
}
button:hover { 
    background:#1f4d3a; 
}
form.inline { display:inline; }
input { padding:5px; margin-right:5px; }
</style>
</head>
<body>

<div class="cart">
<h2>Professors Management</h2>

<form id="addProfessorForm">
<input type="text" id="fullname" placeholder="Full Name" required>
<input type="email" id="email" placeholder="Email" required>
<button type="submit">Add Professor</button>
</form>

<br>

<table id="profTable">
<tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr>
</table>
</div>

<script>
let professors = [
    {id:1, fullname:"Hemili Mohamed", email:"HemiliMohamed@gmail.com"},
    {id:2, fullname:"Hessas Yacine", email:"HessasYacine@gmail.com"},
    {id:3, fullname:"Ben Alia Hayet", email:"BenAliaHayet@gmail.com"},
    {id:4, fullname:"Saichi Karim", email:"SaichiKarim@gmail.com"},
    {id:5, fullname:"Bensalama Ayoub", email:"BensalamaAyoub@gmail.com"}
];

let idCounter = professors.length + 1;

const table = document.getElementById('profTable');
const form = document.getElementById('addProfessorForm');

function renderTable(){
    table.innerHTML = "<tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr>";
    professors.forEach(prof => addRow(prof));
}

function addRow(prof){
    const row = table.insertRow();
    row.setAttribute('data-id', prof.id);

    const cell1 = row.insertCell(0);
    cell1.innerText = prof.id;

    const cell2 = row.insertCell(1);
    cell2.innerText = prof.fullname;

    const cell3 = row.insertCell(2);
    cell3.innerText = prof.email;

    const cell4 = row.insertCell(3);
    const btn = document.createElement('button');
    btn.innerText = "Delete";
    btn.addEventListener('click', function(){
        deleteProfessor(prof.id);
    });
    cell4.appendChild(btn);
}

function deleteProfessor(id){
    professors = professors.filter(p => p.id !== id);
    renderTable();
}

form.addEventListener('submit', function(e){
    e.preventDefault();
    const name = document.getElementById('fullname').value.trim();
    const email = document.getElementById('email').value.trim();
    if(name === "" || email === "") return;

    const prof = {id: idCounter++, fullname: name, email: email};
    professors.push(prof);
    renderTable();
    form.reset();
});

// Initial render
renderTable();
</script>

</body>
</html>
