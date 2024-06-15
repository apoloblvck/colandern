<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>colander</title>
    <meta name="description" content="ultra.">
    <meta name="keywords" content="exif">
    <meta name="author" content="apoloblvck">
    <meta name="robots" content="index,follow">
    <meta name="theme-color" content="#000">

    <link rel="icon" href="icon/1.png" type="image/x-icon">
    <link rel="shortcut icon" href="icon/1.png" type="image/x-icon">
    <link rel="stylesheet" href="colander.css">

</head>
<body>

    <form action="" method="post" enctype="multipart/form-data">

        <label for="fileInput" class="button">
            <input type="file" id="fileInput" value="" name="image" accept="image/*" />
            Choose a file
        </label>
        <div id="select-text">No file selected.</div>
        <div id="buttons">
            <button class="button" name="b1" type="submit">View EXIF Data</button>
            <button class="button" name="b2" type="submit">Upgrade version</button>    
        </div>
    </form>

    <pre id="pre">
              _                      _            
   __   ____ | | _____    ____     _| | ____  ___. 
 /  __\/  _ \| | \__  \  /    \  / _  |/ __ \|  _ \
(  (__(  (_) ) |__/ __ \|   |  \/ (_)     ___) | )/
 \____ > ___/|___(______) __|_ /\_____/\____ >_|   

                              made by @apoloblvck
    </pre>    
    <pre id='hand'>
 _______.-.     
(_______( / \----
   (___()\)  ) 
    (__()      
     (_()___/----
    </pre>

<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

        if(isset($_POST["b1"])){
            $image = $_FILES["image"]["tmp_name"];
            $output = shell_exec("exiftool $image");
            echo "<div id='data'>";
            echo "<h2>EXIF Data:</h2><br>";
            echo "<pre>$output</pre>";
            echo "</div>";    
        }elseif(isset($_POST["b2"])){
            echo "<div id='version'>
                <pre>
.     .     .
|`-._/ \_.-`|
|  _______  |
| |__/-\[]| |
| |  (_)  | |
\ |_______| /
 \         / 
   '.___.'   
                </pre>           
                <a id='downloadLink' style='display: none;'>Download Image</a>
            </div>";
        }
    }
?>

    <script>

        if (window.history && window.history.replaceState) {
          window.history.replaceState({}, document.title, window.location.href.split('?')[0]);
        }

        const fileInput = document.getElementById('fileInput');
        const select_text = document.getElementById('select-text');
        const pre = document.getElementById('pre');
        
        if(document.getElementById('data') || document.getElementById('version')){
            document.getElementById('hand').classList.add('active');
            select_text.innerText = "No file selected.";
            pre.classList.add('active');
            if(performance.navigation.type == 1){
                select_text.innerText = "No file selected.";
                pre.classList.remove('active');
                if(document.getElementById('data')){
                    document.getElementById('data').remove();
                }else{
                    document.getElementById('version').remove();
                }
            }

        }

        fileInput.addEventListener('change', function(event) {

            if (event.target.files && event.target.files[0]) {
                const selectedFile = event.target.files[0];
                select_text.innerText = selectedFile.name;
                pre.classList.remove('active');
                document.getElementById('hand').classList.add('active');
                document.querySelector(".button[name='b2']").addEventListener('click',()=>{
                    
                    const file = fileInput.files[0];
        
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const image = new Image();
                        image.src = event.target.result;
                        image.onload = function() {
                            const canvas = document.createElement('canvas');
                            const ctx = canvas.getContext('2d');
                            canvas.width = image.width;
                            canvas.height = image.height;
                            ctx.drawImage(image, 0, 0);
        
                            const url = canvas.toDataURL('image/jpeg');
                            const fileName = (file.name).split('.').slice(0, -1).join('.') + '(colander_version)' + '.' + (file.name).split('.').pop();
        
                            const a = document.getElementById('downloadLink');
                            a.href = url;
                            a.setAttribute('download', fileName);
                            a.style.display = 'inline';
                        }
                    };
                    reader.readAsDataURL(file);

                });
            }else{
                select_text.innerText = "No file selected.";
                pre.classList.remove('active');
                document.getElementById('hand').classList.remove('active');
            }

        });


        /*//////////////////////new version////////////////////////*/


    </script>


</body>
</html>

