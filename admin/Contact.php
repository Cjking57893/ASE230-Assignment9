<?php
include 'Person.php';
class Contact extends Person{
   protected $phoneNumber;
   protected $email;

    public function __construct($name, $phoneNumber, $email) {
        $this->name = $name;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
    }
   public function getPhoneNumber(){
        return $this->phoneNumber;
    }
    public function setPhoneNumber($phoneNumber){
        $this->phoneNumber = $phoneNumber;
    }

    public function getEmail(){
        return $this->email;
    }
    public function setEmail($email){
        $this->email = $email;
    }

    //function displays contacts on the admin index page
    public static function readContactsAdminIndex($file_path){
        $file = fopen($file_path,'r');
        //loop runs as long as there is data to read from file
        if(file_exists($file_path)){
            while(($section = fgetcsv($file)) !== false) {
                echo "<tr>
                        <td class=\"align-middle\"><a href=detail.php?contact_phone=$section[1]>$section[0]</td>
                        <td class=\"align-middle\">$section[1]</a></td>
                        <td class=\"align-middle\">$section[2]</td>
                        </tr>";
            }
        }
    }

    //function reads specific contact for admin detail page
    public static function readContactAdminDetail($file_path,$contact_phone){
        $file = fopen($file_path,'r');
        //loop runs as long as there is data to read from file
        if(file_exists($file_path)){
            while(($section = fgetcsv($file)) !== false) {
                //check if the contact phone number in the file matches the contact phone number in the URL
                if($section[1] == $contact_phone){
                    echo"<h3>Name: $section[0]</h3>
                        <p>Phone: $section[1]</p>
                        <p>Email: $section[2]</p>";
                        
                }
            }
        }
    }

    //function creates contact
    public static function createContact($file_path, $contact_name, $contact_phone, $contact_email){
        $file = fopen($file_path,'a');
        //create array to hold contact info
        $data = [$contact_name, $contact_phone, $contact_email];
        //open file for reading to check contact phone numebrs
        $file_read = fopen($file_path, 'r');
        //variable to act as a flag if a matching contact phone number is found
        $found = false;
        if(file_exists($file_path)){
            while(($section = fgetcsv($file_read)) !== false) {
                //check if the contact phone number in the file matches the contact phone number in the URL
                if($section[1] == $contact_phone){
                        $found = true;
                }
            }
            fclose($file_read);
            //write data if no contact phone number match is not found
            if($found==false){
                fputcsv($file, $data);
                //redirect to edit.php
                header("Location: edit.php?contact_phone=$contact_phone");
                exit; // Stop script execution
            }
            else{
                echo"<div class=\"text-center alert alert-light\" role=\"alert\" style=\"font-weight: bold;\">
                    You cannot create contacts with matching phone numbers.
                    </div>
                    ";
            }
        }
    }

    //function deletes contact
    public static function deleteContact($file_path, $contact_phone){
        $file = fopen($file_path, 'r');
        $lines = [];
        if(file_exists($file_path)){
            while (($section = fgetcsv($file)) !== false) {
                // Check if the contact phone number matches the contact phone number in the URL
                if ($section[1] == $contact_phone) {
                    continue;
                }
                $lines[] = $section; 
            }
        }
        
        fclose($file);


        // Write the modified array back to the CSV file
        $file = fopen($file_path, 'w');
        foreach ($lines as $line) {
            fputcsv($file, $line);
        }
        fclose($file);
    }

    //function creates edit from for admin page
    public static function createEditForm($file_path, $contact_phone){
        // Check if the file exists before opening
        if (file_exists($file_path)) {
            // Open file for reading
            $file = fopen($file_path, 'r');
            
            // Loop through CSV file
            while (($section = fgetcsv($file)) !== false) {
                // Check if the contact phone matches the one in the URL
                if ($section[1] == $contact_phone) {
                    echo "<form method=\"post\" action=\"\">
                        <div class=\"mb-3\">
                            <label for=\"name\" class=\"form-label\">Contact Name</label>
                            <input type=\"text\" class=\"form-control w-25\" id=\"name\" name=\"name\" value=\"{$section[0]}\" style=\"border-color: black\">
                        </div>
                        <div class=\"mb-3\">
                            <label for=\"phone\" class=\"form-label\">Phone Number</label>
                            <input type=\"tel\" class=\"form-control w-25\" id=\"phone\" name=\"phone\" value=\"{$section[1]}\" style=\"border-color: black\" pattern=\"\\d{3}-\\d{3}-\\d{4}\" placeholder=\"123-456-7890\">
                        </div>
                        <div class=\"mb-3\">
                            <label for=\"email\" class=\"form-label\">Email Address</label>
                            <input type=\"email\" class=\"form-control w-25\" id=\"email\" name=\"email\" value=\"{$section[2]}\" style=\"border-color: black\" placeholder=\"example@example.com\">
                        </div>
                        <button type=\"submit\" class=\"btn btn-primary\">Save Changes</button>
                    </form>";
                }
            }
            // Close the file after reading
            fclose($file);
        } else {
            echo 'File not found.';
        }
    }

    //function edits contact info
    public static function editContactInfo($file_path, $contact_name, $contact_phone, $contact_email, $old_phone){
        //open file for reading to find contact entry
        $file_read = fopen($file_path, 'r');
        //create array to hold contact info
        $data = [$contact_name, $contact_phone, $contact_email];
        
        if(file_exists($file_path)){
            while(($section = fgetcsv($file_read)) !== false) {
                // Check if the contact phone number matches the contact phone number in the URL
                if ($section[1] == $old_phone) {
                    continue; //skip over existing entry
                }
                $lines[] = $section;  
                
            }
            $lines[] = $data;
            $file = fopen($file_path, 'w');
            foreach ($lines as $line) {
                fputcsv($file, $line);
            }
            fclose($file);
        }
    }
}