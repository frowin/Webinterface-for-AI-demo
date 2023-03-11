$(document).ready(function (e) {

    $(".simulateSpan").hide();

    $("#uploadForm").on('submit',(function(e) {
        e.preventDefault();
        $.ajax({
            url: "upload.php",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend : function()
            {
                //$("#preview").fadeOut();
                $("#err").fadeOut();
            },
            success: function(data)
            {
                var answer = jQuery.parseJSON(data);
                console.log(answer);
            },
            error: function(e) 
            {
                alert(e);
            }          
        });
    }));

    function everyTime() {
        var jqxhr = $.getJSON( "check_for_processed_file.php?uid="+$("#uid").val(), function() {
        })
        .done(function(data) {

            //console.log(data);

            if(data.status == "noupload"){
                $("#status").html("Please pick an image to be processed!");
                $("#status").css("color", "red");
            }
            if(data.status == "waiting"){
                $("#submitBtn").attr("disabled", true);
                $("#fileToUpload").attr("disabled", true);
                $("#status").html("Please wait, your image will be processed now ...");
                $("#status").css("color", "gray");
                $("#original_container img").attr("src", data.original_filename);
                $(".simulateSpan").show();
            }
            if(data.status == "processed"){
                $("#submitBtn").attr("disabled", true);
                $("#fileToUpload").attr("disabled", true);
                $("#status").html("Your image was processed successfully! Please press Start over to process another one");
                $("#status").css("color", "green");
                $("#original_container img").attr("src", data.original_filename);
                $("#processed_container img").attr("src", data.processed_filename);
            }
            
        })
        .fail(function() {

        })
        .always(function() {

        });
    }

    var checkForProcessedImageInterval = setInterval(everyTime, 1000); // clearInterval(checkForProcessedImageInterval);

    
});