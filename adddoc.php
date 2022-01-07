<?php

    include('config/db_conn.php');
    include('config/functions.php');

    $email = $lname = $fname = $cont = $bdate = '';
	$errors = array('email' => '', 'fname' => '', 
    'landline' => '', 'bdate' => '', 'lname' => '',);

    


    //end of file upload globals
	if(isset($_POST['submit'])){
    
            $filename = $_FILES["fileToUpload"]["name"];
            $filenTmpName = $_FILES["fileToUpload"]["tmp_name"];
            $fileSize = $_FILES["fileToUpload"]["size"];
            $fileError = $_FILES["fileToUpload"]["error"];
            $fileType = $_FILES["fileToUpload"]["type"];

            // file uploads
            $file = $_FILES['fileToUpload'];
    
            $fileExt = explode('.', $filename);
            $fileActualExt = strtolower(end($fileExt));
    
            $allowed = array('jpg', 'jpeg', 'jfif', 'png');
    
            if(!in_array($fileActualExt, $allowed)) {
                echo "cant upload file (filelype not supported)";
            } else {
                if($fileError == 0) {
                    $filenameNew = uniqid('', true).".".$fileActualExt;
    
                    $fileDest = "images/logo/" . $filenameNew;
    
                } else {
                    echo "cant upload file";
                }
            }
		
            // check email
            if(empty($_POST['email'])){
                $errors['email'] = 'An email is required';
            } else{
                $email = $_POST['email'];
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $errors['email'] = 'Email must be a valid email address';
                }
            }

            // check first name
            if(empty($_POST['fname'])){
                $errors['fname'] = 'A Hospital name is required';
            } else{
                $title = $_POST['fname'];
                if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
                    $errors['fname'] = 'Hospital Name must be letters and spaces only';
                }
            }

            // check last name
            if(empty($_POST['lname'])){
                $errors['lname'] = 'A Hospital name is required';
            } else{
                $title = $_POST['lname'];
                if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
                    $errors['lname'] = 'Hospital Name must be letters and spaces only';
                }
            }

            // check contact number
            if(empty($_POST['cont'])){
                $errors['cont'] = 'At least one ingredient is required';
                header('Location: www.google.com');
            } else{
                $cont = $_POST['cont'];
                if(!filter_var($landline, FILTER_VALIDATE_FLOAT)){
                    $errors['cont'] = 'Ingredients must be a comma separated list';
                }
            }
            
            // check birth date
            if(empty($_POST['bdate'])){
                $errors['bdate'] = 'At least one ingredient is required';
                header('Location: www.google.com');
            } else{
                $bdate = $_POST['bdate'];
            }

            if(array_filter($errors)){
                
            } else {
    
                // upload file
                move_uploaded_file($filenTmpName, $fileDest);
    
                // escape sql chars
                $fname = mysqli_real_escape_string($conn, $_POST['fname']);
                $lname = mysqli_real_escape_string($conn, $_POST['lname']);
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $cont = mysqli_real_escape_string($conn, $_POST['cont']);
                $bdate = mysqli_real_escape_string($conn, $_POST['bdate']);
                $curdate = date("Y/m/d");
    
                // create sql
                $sql = "INSERT INTO hospitals(firstname, lastname,
                email,landline,regdate, imgpath) 
                VALUES('$fname','$email','$landline','$curdate', '$fileDest')";
    
    
                // save to db and check
                if(mysqli_query($conn, $sql)){
                    // success
                    header('Location: hospitals.php');
                } else {
                    header('Location: addhos.php');
                }
    
                
            }
           
    }

?>


        <?php require("nodeModules/navbarMod.php") ?>

    <div class="inpp">
        
        <section class="inp">

            <form action="adddoc.php" method="POST" 
            enctype="multipart/form-data" class="iin">

                <label for="" class="inlab">First Name</label> <br>
                <input type="text" class="inin" name="fname"
                value="<?php echo htmlspecialchars($fname) ?>"><br>

                <label for="" class="inlab">Last Name</label> <br>
                <input type="text" class="inin" name="lname"
                value="<?php echo htmlspecialchars($lname) ?>"><br>

                <label for="" class="inlab">Birth Date</label> <br>
                <input type="date" class="inin" name="lname"
                value="<?php echo htmlspecialchars($bdate) ?>"><br>

                <label for="" class="inlab">Email</label> <br>
                <input type="text" class="inin" name="email"
                value="<?php echo htmlspecialchars($email) ?>"><br>

                <label for="" class="inlab">Contact Number</label> <br>
                <input type="text" class="inin" name="cont"
                value="<?php echo htmlspecialchars($cont) ?>"><br>

                
                Select image to upload:
                <input type="file" name="fileToUpload" id="fileToUpload"><br><br><br>

                <div class="cent">
                    <input type="submit" name="submit" value="Submit" class="subm brand 
                    z-depth-0">
                </div>

            </form>

        </section>
    </div>
            
    </body>
</html>