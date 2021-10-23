<?
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>AlienSms</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE = edge">
  <meta name="viewport" content="width = device-width, initial-scale = 1">
      <link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.6/cosmo/bootstrap.min.css" rel="stylesheet">
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>


</head>

<body>
    <script>
        var running = false;
        var request;
    </script>

  <script>
    Array.prototype.randomElement = function () {
  return this[Math.floor(Math.random() * this.length)]
 }

 function stopSending()
 {


    running = false;

    if (request) {
        request.abort();
      }

    $("#btnStart").attr("disabled", false);
    $("#btnStop").attr("disabled", true);
 }

 function handleSendingResponse(recipient, response, processedCount, totalEmailCount) {
  $("#progress").append('<div style="left: 0%" class="col-lg-1"><span class="label label-success">'+response+'</span></div>');
  $("#progress").append('<div class="col-lg-1" style="left: 10%;"><span style="width:100%" class="label label-default">' + recipient + '</span></div>');
    $("#progress").append('<div class="col-lg-1" style="left: 60%;"><span style="width:100%" class="label label-default">' + processedCount + '</span></div>');
  $("#progress").append('<br>');
 }

 function startSending() {
validateForm();
  var eMailTextArea = document.getElementById("emailList");
  var eMailTextAreaLines = eMailTextArea.value.split("\n");
  var sender = document.getElementById("SENDER").value;
  var letter = document.getElementById("messageLetter").value;
  var api = document.getElementById("API").value;
 
   var form_data = new FormData();
   form_data.append("sender", sender);     
   form_data.append("letter", letter);
   form_data.append("api", api);



  $("#progress").empty();
  var processedCount = 0;
  $(function () {
    var i = 0;
    running = true;

    $("#btnStart").attr("disabled", true);
    $("#btnStop").attr("disabled", false);


    function nextCall() {
      if (i == eMailTextAreaLines.length){

         $("#btnStart").attr("disabled", false);
         $("#btnStop").attr("disabled", true);
         return; //last call was last item in the array
      }

      // Abort any pending request
      if (request) {
        request.abort();
      }
       if(!running)
      {
        return;
      }

      var recipient = eMailTextAreaLines[i++]
      form_data.append("nums", recipient);
      request = $.ajax({
        type: "post",
        data: form_data,
        url : "processForm.php",
        contentType: false,
        processData: false,
      });
      // Callback handler that will be called on success
      request.done(function (response, textStatus, jqXHR) {
        processedCount += 1;
        handleSendingResponse(recipient, response, processedCount, eMailTextAreaLines.length);
        nextCall();
      });
    }
    nextCall();
  });
 }
</script>
  <div class="container col-lg-6">
    <h3>👽<small>Alien SMS</small></h3>
    <script type="text/javascript">
  function validateForm() {
    var a = document.forms["Form"]["SENDER"].value;
    var b = document.forms["Form"]["API"].value;
    var c = document.forms["Form"]["messageLetter"].value;
    var d = document.forms["Form"]["emailList"].value;
    

    if (a == null || a == ""){
            alert("Sender is empty!");
                    request.abort();

      return false;
    } 
    if (b == null || b == "") {
            alert("Api is empty!");
                    request.abort();

      return false;
    }

     if  (c == null || c == ""){
            alert("Letter is empty!");
                    request.abort();

      return false;
     } 
     if (d == null || d == "") {
      alert("Numbers list is empty!");
              request.abort();

      return false;
    }

  }
    </script>
    <form action="" name="Form"  >
    <div class="row">
      <div class="form-group col-lg-6 ">
        <label for="senderEmail">Sender</label>
        <input type="text" class="form-control  input-sm" id="SENDER" name="SENDER">
      </div>
            <div class="form-group col-lg-6 ">
        <label for="API">API</label>
        <input type="text" class="form-control  input-sm" id="API" name="API">
      </div>
    </div>
    
    
    <div class="row">
      <div class="form-group col-lg-6">
        <label for="messageLetter">Message Letter</label>
        <textarea placeholder="Message Letter" name="messageLetter" id="messageLetter" class="form-control" rows="10" id="textArea"></textarea>
      </div>
      <div class="row">
      <div class="form-group col-lg-6 ">
        <label for="emailList">Numbers List</label>
        <textarea name="emailList" id="emailList" class="form-control" rows="10" id="textArea"></textarea>
      </div>
    </div>
    </div>


<button type="button" id="btnStart" class="btn btn-default btn-sm" onclick="startSending();">Start</button>
<button type="button"id="btnStop" class="btn btn-default btn-sm" onclick="stopSending();">Stop</button>

</div>
</form>
</div>
<br><br>
 <div class="col-lg-6"><br><br>
        <div id="progress" class="well well" style="overflow-y: auto; height: 307px; width: 350px">
        </div>
        </div>

 
<script>
 $("#btnStart").attr("disabled", false);
 $("#btnStop").attr("disabled", true);
</script>
</body>
<footer style="text-align: center;">
      <h3><small></small></h3>

</footer>

</html>