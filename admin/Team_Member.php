<?php
include 'Person.php';
class Team_Member extends Person{
    protected $employee_number;
    protected $role;
    protected $description;

    public function __construct($name, $emp_num, $role, $description){
        $this->name = $name;
        $this->employee_number = $emp_num;
        $this->role = $role;
        $this->description = $description;
    }
    public function getEmployeeNumber(){
        return $this->employee_number;
    }
    public function setEmployeeNumber($employee_number){
        $this->employee_number = $employee_number;
    }

    public function getRole(){
        return $this->role;
    }
    public function setRole($role){
        $this->role = $role;
    }

    public function getDescription(){
        return $this->description;
    }
    public function setDescription($description){
        $this->description = $description;
    }

    //function displays team members on index page
    public static function displayTeamIndex($file_path){
        //iterator for team member images
        $i = 1;
        //open file
        $file = fopen($file_path,'r');
        //loop runs as long as there is data to read from file
        if(file_exists($file_path)){
            while(($section = fgetcsv($file)) !== false) {
                
                //write html to page
                '<br>';
                echo "<div class=\"col-lg-3 col-sm-6\">
                        <div class=\"team-box mt-4 position-relative overflow-hidden rounded text-center shadow\">
                            <div class=\"position-relative overflow-hidden\">
                                <img src=\"images/team/img_$i.jpg\" alt=\"\" class=\"img-fluid d-block mx-auto\" />
                                <ul class=\"list-inline p-3 mb-0 team-social-item\">
                                <p style=\"color: white\">$section[3]</p>
                                </ul>
                            </div>
                            <div class=\"p-4\">
                                <h5 class=\"font-size-19 mb-1\">$section[1]</h5>
                                <p class=\"text-muted text-uppercase font-size-14 mb-0\">$section[2]</p>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->";
                 $i++;   
            }
        }
        else{
            echo 'File not found.';
        }
        //close file
        fclose($file);
    }

    //function displays team memebrs on the admin page
    public static function displayTeamAdmin($file_path){
        $file = fopen($file_path,'r');
        //loop runs as long as there is data to read from file
        if(file_exists($file_path)){
            while(($section = fgetcsv($file)) !== false) {
                echo "<tr>
                        <td class=\"align-middle\">$section[0]</td>
                        <td class=\"align-middle\"><a href=detail.php?emp_num=$section[0]>$section[1]</a></td>
                        <td class=\"align-middle\">$section[2]</td>
                        <td class=\"align-middle\">$section[3]</td>
                        </tr>";
            }
        }
    }

    //funciton displays a specific member on the admin detail page
    public static function readTeamAdminDetail($file_path,$emp_num){
        $file = fopen($file_path,'r');
        //loop runs as long as there is data to read from file
        if(file_exists($file_path)){
            while(($section = fgetcsv($file)) !== false) {
                //check if the employee number in the file matches the employee number in the URL
                if($section[0] == $emp_num){
                    echo"<h3>Name: $section[1]</h3>
                        <p>Employee Number: $section[0]</p>
                        <p>Description: $section[3]</p>";
                        
                }
            }
        }
    }

    //function creates a team member
    public static function createTeamMember($file_path, $emp_num, $emp_name, $emp_position, $emp_desc){
        $file = fopen($file_path,'a');
        //create array to hold employee info
        $data = [$emp_num, $emp_name, $emp_position, $emp_desc];
        //open file for reading to check employee numebrs
        $file_read = fopen($file_path, 'r');
        //variable to act as a flag if a matching employee number is found
        $found = false;
        if(file_exists($file_path)){
            while(($section = fgetcsv($file_read)) !== false) {
                //check if the employee number in the file matches the employee number in the URL
                if($section[0] == $emp_num){
                        $found = true;
                }
            }
            fclose($file_read);
            //write data if no employee number match is not found
            if($found==false){
                fputcsv($file, $data);
                //redirect to edit.php
                header("Location: edit.php?emp_num=$emp_num");
                exit; // Stop script execution
            }
            else{
                echo"<div class=\"text-center alert alert-light\" role=\"alert\" style=\"font-weight: bold;\">
                    You cannot create employees with matching employee numbers.
                    </div>
                    ";
            }
        }
    }

    //function deletes a team member
    public static function deleteTeamMember($file_path, $emp_num){
        $file = fopen($file_path, 'r');
        $lines = [];
        if(file_exists($file_path)){
            while (($section = fgetcsv($file)) !== false) {
                // Check if the emp number matches the emp number in the URL
                if ($section[0] == $emp_num) {
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

    //function creates edit form for admin edit page
    public static function createEditForm($file_path, $emp_num){
        //open file for reading
        $file = fopen($file_path, 'r');
        if(file_exists($file_path)){
            while (($section = fgetcsv($file)) !== false) {
                // Check if the emp number matches the emp number in the URL
                if ($section[0] == $emp_num) {
                    echo "<form method=\"post\" action=\"\">
                    <div class=\"mb-3\">
                        <label for=\"num\" class=\"form-label\">Employee Number</label>
                        <input type=\"text\" class=\"form-control w-25\" id=\"num\" name=\"num\" value=\"$section[0]\" disabled>
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"name\" class=\"form-label\">Employee Name</label>
                        <input type=\"text\" class=\"form-control w-25\" id=\"name\"  name=\"name\" value=\"$section[1]\" style=\"border-color: black\">
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"position\" class=\"form-label\">Employee Position</label>
                        <input type=\"text\" class=\"form-control w-25\" id=\"position\"  name=\"position\" value=\"$section[2]\" style=\"border-color: black\">
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"desc\" class=\"form-label\">Bio</label>
                        <input type=\"text\" class=\"form-control\" id=\"desc\" rows=\"3\" name=\"desc\" value=\"$section[3]\" style=\"border-color: black\">
                    </div>
                    <button type=\"submit\" class=\"btn btn-primary\">Save Changes</button>
                </form>";
                }
            }
        }
    }

    //function edits team member info
    public static function editTeamMemberInfo($file_path, $emp_num, $emp_name, $emp_position, $emp_desc){
        //open file for reading to find employee entry
        $file_read = fopen($file_path, 'r');
        //create array to hold employee info
        $data = [$emp_num, $emp_name, $emp_position, $emp_desc];
        
        if(file_exists($file_path)){
            while(($section = fgetcsv($file_read)) !== false) {
                //check if the employee number in the file matches the employee number in the URL
                
                // Check if the emp number matches the emp number in the URL
                if ($section[0] == $emp_num) {
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