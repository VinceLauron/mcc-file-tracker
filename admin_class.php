<?php
session_start();
include 'db_connect.php';

function generateUniqueFileNumber($conn) {
    $file_number = sprintf("%'012d", mt_rand(0, 999999999999));
    $chk = $conn->query("SELECT * FROM files WHERE file_number = '$file_number'");
    
    while ($chk->num_rows > 0) {
        $file_number = sprintf("%'012d", mt_rand(0, 999999999999));
        $chk = $conn->query("SELECT * FROM files WHERE file_number = '$file_number'");
    }

    return $file_number;
}

class Action {
    private $db;

    public function __construct() {
        ob_start();
        include 'db_connect.php';
        $this->db = $conn;
    }

    function __destruct() {
        $this->db->close();
        ob_end_flush();
    }

    function login() {
        extract($_POST);
        $password = md5($password); // Hash the password using MD5
        
        // Query to check username and hashed password
        $qry = $this->db->query("SELECT * FROM users WHERE username = '".$username."' AND password = '".$password."'");
        
        if ($qry->num_rows > 0) {
            // Set session variables excluding the password
            foreach ($qry->fetch_array() as $key => $value) {
                if ($key != 'password' && !is_numeric($key))
                    $_SESSION['login_'.$key] = $value;
            }
            return 1; // Login successful
        } else {
            return 2; // Login failed
        }
    }
    function logout() {
        session_destroy();
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        header("location:login.php");
    }

    function save_folder() {
        extract($_POST);
        $data = " name ='".$name."' ";
        $data .= ", parent_id ='".$parent_id."' ";
        if (empty($id)) {
            $data .= ", user_id ='".$_SESSION['login_id']."' ";

            $check = $this->db->query("SELECT * FROM folders where user_id ='".$_SESSION['login_id']."' and name  ='".$name."'")->num_rows;
            if ($check > 0) {
                return json_encode(array('status'=>2,'msg'=> 'Folder name already exist'));
            } else {
                $save = $this->db->query("INSERT INTO folders set ".$data);
                if ($save)
                    return json_encode(array('status'=>1));
            }
        } else {
            $check = $this->db->query("SELECT * FROM folders where user_id ='".$_SESSION['login_id']."' and name  ='".$name."' and id !=".$id)->num_rows;
            if ($check > 0) {
                return json_encode(array('status'=>2,'msg'=> 'Folder name already exist'));
            } else {
                $save = $this->db->query("UPDATE folders set ".$data." where id =".$id);
                if ($save)
                    return json_encode(array('status'=>1));
            }
        }
    }

    function delete_folder() {
        extract($_POST);
        $delete = $this->db->query("DELETE FROM folders where id =".$id);
        if ($delete)
            echo 1;
    }

    function delete_file() {
        extract($_POST);
        $path = $this->db->query("SELECT file_path from files where id=".$id)->fetch_array()['file_path'];
        $delete = $this->db->query("DELETE FROM files where id =".$id);
        if ($delete) {
            unlink('assets/uploads/'.$path);
            return 1;
        }
    }

    function get_file_history() {
        extract($_POST);
        $data = array();
        
        // Query to get file details based on file number
        $files = $this->db->query("SELECT * FROM files WHERE file_number = '$file_no'");
        
        if ($files->num_rows <= 0) {
            // Return status 2 if no file found with the given file number
            return json_encode(array('user_id' => 2));
        } else {
            $files = $files->fetch_array();
            $data[] = array(
                'file_number' => $files['file_number'],
                'fullname' => $files['fullname'],
                'description' => $files['description'],
                'date_created' => date("M d, Y h:i A", strtotime($files['date_created']))
            );
            
            // Query to get file tracking history
            $history = $this->db->query("SELECT * FROM file_tracks WHERE file_id = {$files['id']}");
            
            while ($row = $history->fetch_assoc()) {
                $row['date_created'] = date("M d, Y h:i A", strtotime($row['date_created']));
                $data[] = $row;
            }
            
            // Return the file details and history as JSON
            return json_encode($data);
        }
    }
    function save_files() {
        extract($_POST);
        if (empty($id)) {
            if ($_FILES['upload']['tmp_name'] != '') {
                $fname = strtotime(date('Y-m-d H:i')).'_'.$_FILES['upload']['name'];
                $move = move_uploaded_file($_FILES['upload']['tmp_name'],'assets/uploads/'.$fname);

                if ($move) {
                    $file = $_FILES['upload']['name'];
                    $file = explode('.', $file);
                    $chk = $this->db->query("SELECT * FROM files where SUBSTRING_INDEX(name,' ||',1) = '".$file[0]."' and folder_id = '".$folder_id."' and file_type='".$file[1]."'");
                    if ($chk->num_rows > 0) {
                        $file[0] = $file[0] .' ||'.($chk->num_rows);
                    }

                    $file_number = $this->generateUniqueFileNumber();

                    $data = " name = '".$file[0]."' ";
                    $data .= ", file_number = '".$file_number."' ";
                    $data .= ", fullname = '".$fullname."' ";
                    $data .= ", folder_id = '".$folder_id."' ";
                    $data .= ", description = '".$description."' ";
                    $data .= ", user_id = '".$_SESSION['login_id']."' ";
                    $data .= ", file_type = '".$file[1]."' ";
                    $data .= ", file_path = '".$fname."' ";
                    if (isset($is_public) && $is_public == 'on')
                        $data .= ", is_public = 1 ";
                    else
                        $data .= ", is_public = 0 ";

                    $save = $this->db->query("INSERT INTO files set ".$data);
                    if ($save)
                        return json_encode(array('status'=>1));
                }
            }
        } else {
            $data = " description = '".$description."' ";
            if (isset($is_public) && $is_public == 'on')
                $data .= ", is_public = 1 ";
            else
                $data .= ", is_public = 0 ";
            $save = $this->db->query("UPDATE files set ".$data." where id=".$id);
            if ($save)
                return json_encode(array('status'=>1));
        }
        return json_encode(array('status' => 0, 'msg' => 'Failed to save file.'));
    }

    private function generateUniqueFileNumber() {
        $file_number = sprintf("%'012d", mt_rand(0, 999999999999));
        $chk = $this->db->query("SELECT * FROM files WHERE file_number = '$file_number'");

        while ($chk->num_rows > 0) {
            $file_number = sprintf("%'012d", mt_rand(0, 999999999999));
            $chk = $this->db->query("SELECT * FROM files WHERE file_number = '$file_number'");
        }

        return $file_number;
    }

    function file_rename() {
        extract($_POST);
        $file[0] = $name;
        $file[1] = $type;
        $chk = $this->db->query("SELECT * FROM files where SUBSTRING_INDEX(name,' ||',1) = '".$file[0]."' and folder_id = '".$folder_id."' and file_type='".$file[1]."' and id != ".$id);
        if ($chk->num_rows > 0) {
            $file[0] = $file[0] .' ||'.($chk->num_rows);
        }
        $save = $this->db->query("UPDATE files set name = '".$name."' where id=".$id);
        if ($save) {
            return json_encode(array('status'=>1,'new_name'=>$file[0].'.'.$file[1]));
        }
    }

    function save_user() {
        extract($_POST);
    
        // Hash the password using MD5
        $password = md5($password);
    
        // Prepare the data to be inserted or updated
        $data = " name = '$name' ";
        $data .= ", username = '$username' ";
        $data .= ", password = '$password' ";
        $data .= ", type = '$type' ";
        $data .= ", is_verified = 'Verified' "; // Automatically set to Verified
    
        // Check if it's a new user or an update
        if (empty($id)) {
            $save = $this->db->query("INSERT INTO users SET ".$data);
        } else {
            $save = $this->db->query("UPDATE users SET ".$data." WHERE id = ".$id);
        }
    
        // Check if the query was successful
        if ($save) {
            return 1;
        } else {
            // Log the error message
            echo "Error: " . $this->db->error;
            return 0;
        }
    }
    
}
?>
