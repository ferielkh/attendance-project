// Navbar
$('.navbar a').click(function(e){
  e.preventDefault();
  let target=$(this).attr('href');
  $('section').removeClass('active');
  $(target).addClass('active');
});

// Input validation
$("#studentID").on("input", function(){ this.value = this.value.replace(/[^0-9]/g, ""); });
$("#lastName, #firstName").on("input", function(){ this.value = this.value.replace(/[^A-Za-z]/g, ""); });

// Update Attendance
function updateAttendance(){
  $("#attendance-table tbody tr").each(function(){
    const p=$(this).find(".p"), pa=$(this).find(".pa");
    let abs=0, part=0;
    for(let i=0;i<p.length;i++){
      if(!p.eq(i).is(":checked")) abs++;
      if(pa.eq(i).is(":checked")) part++;
    }
    $(this).find(".absences").text(abs);
    $(this).find(".participations").text(part);

if (abs < 3) {
  $(this).css("background-color", "#c8f7c5"); 
} else if (abs <= 4) {
  $(this).css("background-color", "#fff7b2"); 
} else {
  $(this).css("background-color", "#ffb5b5"); 
}

    if(abs===0) $(this).find(".message").text("Perfect attendance! 🎉");
    else if(abs<=2) $(this).find(".message").text("Good attendance.");
    else if(abs<=4) $(this).find(".message").text("Warning: Attendance low.");
    else $(this).find(".message").text("Excluded: Too many absences.");
  });
}
$("#checkBtn").click(updateAttendance);

// Hover highlight & click info
$("#attendance-table tbody tr").hover(
  function(){ $(this).css("background-color","#f1f8e9"); },
  function(){ updateAttendance(); }
);
$("#attendance-table tbody").on("click","tr", function(e){
  if($(e.target).is("input")) return;
  const lastName=$(this).find("td:eq(1)").text();
  const firstName=$(this).find("td:eq(2)").text();
  const absences=$(this).find(".absences").text();
  alert(`Student: ${firstName} ${lastName}\nAbsences: ${absences}`);
});

// Highlight / Reset
$("#highlightBtn").click(function(){
  $("#attendance-table tbody tr").each(function(){
    const abs=parseInt($(this).find(".absences").text());
    $(this).removeClass("highlight");
    if(abs<3) $(this).addClass("highlight");
  });
});
$("#resetBtn").click(function(){
  $("#attendance-table tbody tr").removeClass("highlight");
});

// Add Student
$("#addStudentForm").submit(function(e){
  e.preventDefault();
  const id=$("#studentID").val().trim(), last=$("#lastName").val().trim(), first=$("#firstName").val().trim(), email=$("#email").val().trim();
  $("#error-id,#error-last,#error-first,#error-email").text(""); $("#success-msg,#tableMsg").hide();
  let valid=true;
  if(!/^[0-9]+$/.test(id)){ $("#error-id").text("Numbers only"); valid=false; }
  if(!/^[A-Za-z]+$/.test(last)){ $("#error-last").text("Letters only"); valid=false; }
  if(!/^[A-Za-z]+$/.test(first)){ $("#error-first").text("Letters only"); valid=false; }
  if(!/^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(email)){ $("#error-email").text("Valid email required"); valid=false; }
  if(!valid) return;
  let row=`<tr><td>${id}</td><td>${last}</td><td>${first}</td><td>PAW</td>`;
  for(let i=1;i<=6;i++) row+=`<td><input type='checkbox' class='p'></td><td><input type='checkbox' class='pa'></td>`;
  row+=`<td class="absences">0</td><td class="participations">0</td><td class="message"></td></tr>`;
  $("#attendance-table tbody").append(row);
  this.reset(); $("#success-msg").text("✅ Student added successfully!").show(); $("#tableMsg").text(`✅ ${first} ${last} added!`).show();
  setTimeout(()=>{$("#success-msg,#tableMsg").hide();},3000);
});

// Report
$("#reportBtn").click(function(){
  const rows=$("#attendance-table tbody tr");
  let labels=["S1","S2","S3","S4","S5","S6"];
  let pData=[], paData=[];
  for(let i=0;i<6;i++){
    let pCount=0, paCount=0;
    rows.each(function(){
      if($(this).find(".p").eq(i).is(":checked")) pCount++;
      if($(this).find(".pa").eq(i).is(":checked")) paCount++;
    });
    pData.push(pCount); paData.push(paCount);
  }
  let perfect=0;
  rows.each(function(){
    if($(this).find(".p").length && $(this).find(".p:checked").length==6) perfect++;
  });
  $("#perfectAttendance").text(`🏆 ${perfect} student${perfect!==1?'s':''} attended all sessions!`).fadeIn(400);

  const ctx=$("#reportChart")[0].getContext("2d");
  if(window.myChart) window.myChart.destroy();
  window.myChart=new Chart(ctx,{
    type:"bar",
    data:{ labels:labels, datasets:[
      { label:"Present", data:pData, backgroundColor:"rgba(46,125,50,0.7)" },
      { label:"Participated", data:paData, backgroundColor:"rgba(76,175,80,0.5)" }
    ]},
    options:{ responsive:true, plugins:{ legend:{ position:"top" } }, scales:{ y:{ beginAtZero:true } } }
  });
});

// Search
$("#searchName").on("keyup",function(){
  const val=$(this).val().toLowerCase();
  $("#attendance-table tbody tr").filter(function(){
    $(this).toggle($(this).find("td:eq(1)").text().toLowerCase().indexOf(val)>-1 || $(this).find("td:eq(2)").text().toLowerCase().indexOf(val)>-1);
  });
});

// Sort
$("#sortAbs").click(function(){
  let tbody=$("#attendance-table tbody");
  tbody.find("tr").sort(function(a,b){ return parseInt($(a).find(".absences").text())-parseInt($(b).find(".absences").text()); }).appendTo(tbody);
  $("#sortMsg").text("Sorted by Absences Ascending").fadeIn().delay(1500).fadeOut();
});
$("#sortPa").click(function(){
  let tbody=$("#attendance-table tbody");
  tbody.find("tr").sort(function(a,b){ return parseInt($(b).find(".participations").text())-parseInt($(a).find(".participations").text()); }).appendTo(tbody);
  $("#sortMsg").text("Sorted by Participation Descending").fadeIn().delay(1500).fadeOut();
});
