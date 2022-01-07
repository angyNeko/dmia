<?php

	include('config/db_conn.php');
	include('config/functions.php');

	$email = $hname = $landline = '';
	$errors = array('email' => '', 'hname' => '', 'landline' => '', 'hosE' => '');

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

		// check hospital name
		if(empty($_POST['hname'])){
			$errors['hname'] = 'A Hospital name is required';
		} else{
			$title = $_POST['hname'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
				$errors['hname'] = 'Hospital Name must be letters and spaces only';
			}
		}

        // check if hospital exist in db

        if(hosExs($conn, htmlspecialchars($_POST['hname']))){
            header("Location: adddoc.php?error=hospitalalreadyindatabase");
            $errors['hosE'] = 'Hospital is already in the database';
        }


		// check landline
		if(empty($_POST['landline'])){
			$errors['landline'] = 'At least one ingredient is required';
            header('Location: www.google.com');
		} else{
			$landline = $_POST['landline'];
			if(!filter_var($landline, FILTER_VALIDATE_FLOAT)){
				$errors['landline'] = 'Ingredients must be a comma separated list';
			}
		}

		if(array_filter($errors)){
			
		} else {

            // upload file
            move_uploaded_file($filenTmpName, $fileDest);

			// escape sql chars
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$hname = mysqli_real_escape_string($conn, $_POST['hname']);
			$landline = mysqli_real_escape_string($conn, $_POST['landline']);
            $curdate = date("Y/m/d");

			// create sql
			$sql = "INSERT INTO hospitals(hosname,email,landline,regdate, imgpath) 
            VALUES('$hname','$email','$landline','$curdate', '$fileDest')";


			// save to db and check
			if(mysqli_query($conn, $sql)){
				// success
				header('Location: hospitals.php');
			} else {
				header('Location: addhos.php');
			}

			
		}

	} // end POST check

?>

<!DOCTYPE html>
<html>
    <head>
        <title>
            D-MIA Registered Doctors
        </title>

        <link rel="stylesheet" type="text/css" href="css/main.css" />

    </head>

    <body>

        <?php require("nodeModules/navbarMod.php") ?>
        <div class="inpp">
        <section class="inp">

            <form action="addhos.php" method="POST" 
            enctype="multipart/form-data" class="iin">

                <label for="" class="inlab">Hospital Name</label> <br>
                <input type="text" class="inin" name="hname"
                value="<?php echo htmlspecialchars($hname) ?>"><br>

                <label for="" class="inlab">Landline</label> <br>
                <input type="number" class="inin" name="landline"
                value="<?php echo htmlspecialchars($landline) ?>"><br>

                <label for="" class="inlab">Email</label> <br>
                <input type="text" class="inin" name="email"
                value="<?php echo htmlspecialchars($email) ?>"><br>

                
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