function sendAbsenceForm() {
    var name = $("#titleDocument").val();
    var file = $("#inputFile").val();
    if(name != '' && file != ''){
        $("#formDocument").submit();
    }else{
        let errorBox = document.getElementById('ErrorMessaging');
        errorBox.innerHTML = "<div class='card-body'>Tiêu đề và file không được để trống!</div>";        
    }
}
function readUrl(input) { 
  if (input.files && input.files[0]) { 
    let reader = new FileReader(); 
    reader.onload = e => { 
      let imgData = e.target.result; 
      let imgName = input.files[0].name; 
      console.log(imgName);
      input.setAttribute("data-title", imgName); 
      console.log(e.target.result); 
    }; 
    reader.readAsDataURL(input.files[0]); 
  }
} 