<?php

    include('config/db_conn.php');
    include('config/functions.php');

    $email = $lname = $fname = $cont = $bdate = '';
	$errors = array('email' => '', 'fname' => '', 'bdate' => '', 'lname' => '', 'cont' => '',
    'docE' => '');

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
    
                    $fileDest = "images/ppic/" . $filenameNew;
    
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
                    $errors['fname'] = 'Name must be letters and spaces only';
                }
            }

            // check if doc exist in db

            if(docExs($conn, htmlspecialchars($_POST['fname']))){
                header("Location: adddoc.php?error=doctoralreadyindatabase");
                $errors['docE'] = 'Doctor is already in the database';
            }

            // check last name
            if(empty($_POST['lname'])){
                $errors['lname'] = 'A Hospital name is required';
            } else{
                $title = $_POST['lname'];
                if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
                    $errors['lname'] = 'Last Name must be letters and spaces only';
                    echo htmlspecialchars($_POST['lname'] . '\'');
                }
            }

            // check contact number
            if(empty($_POST['cont'])){
                
                $errors['cont'] = 'Must not be empty';

                header('Location: fb.com');
                //echo htmlspecialchars($_POST['cont']);

            } else{
                $cont = $_POST['cont'];
                if(!filter_var($cont, FILTER_VALIDATE_FLOAT)){
                    $errors['cont'] = 'Ingredients must be a comma separated list';
                }
            }
            
            // check birth date
            $pattern = "^[0-9]{4}-(((0[13578]|(10|12))-(0[1-9]|[1-2][0-9]|3[0-1]))|(02-(0[1-9]|[1-2][0-9]))|((0[469]|11)-(0[1-9]|[1-2][0-9]|30)))$";
            $bdate = date('Y-m-d', strtotime($_POST['bdate']));
            
            if(empty($bdate)){
                $errors['bdate'] = 'At least one ingredient is required';
            } else{
                $bdate = $_POST['bdate'];
            }

            if(array_filter($errors) == true){
                print_r($errors);
            } else {
    
                // upload file
                move_uploaded_file($filenTmpName, $fileDest);
    
                // escape sql chars
                $fname = mysqli_real_escape_string($conn, $_POST['fname']);
                $lname = mysqli_real_escape_string($conn, $_POST['lname']);
                $email = mysqli_real_escape_string($conn, $_POST['email']);
                $cont = mysqli_real_escape_string($conn, $_POST['cont']);
    
                // create sql
                $sql = "INSERT INTO doctors(firstname, lastname,
                email, cont, birthdate, profpth)
                VALUES('$fname', '$lname','$email','$cont','$bdate', '$fileDest')";
    
    
                // save to db and check
                if(mysqli_query($conn, $sql)){
                    // success
                    header('Location: hospitals.php');
                } else {
                    echo 'lasterror';
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
                <input type="date" class="inin" name="bdate"
                value="<?php echo date('Y-m-d') ?>"><br>

                <label for="" class="inlab">Email</label> <br>
                <input type="text" class="inin" name="email"
                value="<?php echo htmlspecialchars($email) ?>"><br>

                <label for="" class="inlab">Contact Number</label> <br>
                <input type="text" class="inin" name="cont"
                value="<?php echo $cont ?>" maxlength="11" minlength="11"><br>

                
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