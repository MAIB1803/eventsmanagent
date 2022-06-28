<?php
require "db_manage.php";
require "helperFunction.php";
class POST_DATA
{
    private $conn;
    function __construct($conn)
    {
        $this->conn = $conn;
    }
    function insert_PostData($data, $file)
    {
        $arr['id'] = "NULL";
        foreach ($data as $x => $val) {
            if ($x != "myfile" && $x != "request_Type") {
                if ($x != "description") {
                    $arr[$x] = strtolower(sanitize($val));
                } else {
                    $arr[$x] = strtolower($val);
                }
            }
        }

        if (isset($file['myfile']['name'][0])) {
            $filename = check_img($file['myfile']['name'][0]);
            $arr['img'] = $filename;
        }

        $db_DATA_obj = new db_DATA($this->conn);
        $res = $db_DATA_obj->insert_Data($arr);
        if ($res) {
            if (isset($filename)) {
                move_uploaded_file($file['myfile']['tmp_name'][0], '../uploaded/' . $filename);
            }
            $output['result'] = "1";
            $last_Insert_ID = mysqli_insert_id($this->conn);
            $output['last_Insert_ID'] = $last_Insert_ID;
        } else {
            $output['result'] = "0";
        }

        return $output;
    }
    function findEvent($data)
    {
        $result = '
        <tr>
            <th class="align-left p-10">
                <h6>Title</h6>
            </th>
            <th class="align-left p-10">
                <h6>Location</h6>
            </th>
            <th class="align-left p-10">
                <h6>City</h6>
            </th>
            <th class="align-left p-10">
                <h6>Dates</h6>
            </th>
            <th class="align-left p-10">
                <h6>Image</h6>
            </th>
            <th class="align-left p-10">
                <h6>Description</h6>
            </th>
            <th class="align-left p-10">
                <h6>Edit</h6>
            </th>
        </tr>';
        $sql = "SELECT * FROM `event` WHERE ";
        $condition = "";
        $c = 0;
        foreach ($data as $x => $val) {
            if ($x != 'request_Type') {
                $condition .= '`' . $x . '` = "' . $val . '"';
            }
            $c++;
            if (strlen($condition) > 0 && count($data) != $c) {
                $condition .= " OR ";
            }
        }
        $sql = $sql . $condition;
        $obj = new db_DATA($this->conn);

        $res = $obj->sql_QUERY($sql);

        if (mysqli_num_rows($res) > 0) {
            while ($f = mysqli_fetch_assoc($res)) {
                $result .= '<tr>
                <td class="p-10">
                <h6 class="fw-500">' . $f['name'] . '</h6>
                </td>
                <td class="p-10 ">
                    <h6 class="fw-500">' . $f['location'] . '</h6>
                </td>
                <td class="p-10 ">
                    <h6 class="fw-500">' . $f['city'] . '</h6>
                </td>
                <td class="p-10 ">
                    <h6 class="fw-500">' . $f['start_date'] . ' <- To -> ' . $f['end_date'] . ' </h6>
                </td>
                <td class="p-10">
                    <figure class="timg"><img src="uploaded/' . $f['img'] . '" alt=""></figure>
                </td>
                <td class="p-10 ">
                    <h6 class="fw-500">' . $f['description'] . '</h6>
                </td>

                <td class="p-10 tdroprow">
                    <h6><i class="fas fa-ellipsis-h"></i></h6>
                    <div class="tdrop-down">
                        <h6 class="fw-500 tdrop-down-row" onclick = "showFrom(' . $f['id'] . ')">Update</h6>
                        <h6 class="fw-500 tdrop-down-row" onclick = "delEvent(' . $f['id'] . ')">Delete</h6>
                    </div>
                </td>
                </tr>';
            }
        } else {
            $result .= '     <tr>
            <td class="p-10 ">
                <h6 class="fw-500">No Data Found</h6>
            </td>
            <td class="p-10 ">
                <h6 class="fw-500">No Data Found</h6>
            </td>
            <td class="p-10 ">
                <h6 class="fw-500">No Data Found</h6>
            </td>
            <td class="p-10 ">
                <h6 class="fw-500">No Data Found</h6>
            </td>
            <td class="p-10 ">
                <h6 class="fw-500">No Data Found</h6>
            </td>
            <td class="p-10 ">
                <h6 class="fw-500">No Data Found</h6>
            </td>

            <td class="p-10 tdroprow">
                <h6><i class="fas fa-ellipsis-h"></i></h6>
                <div class="tdrop-down">
                    <h6 class="fw-500 tdrop-down-row">Invalid</h6>
                    <h6 class="fw-500 tdrop-down-row">Invalid</h6>
                </div>
            </td>
            </tr>';
        }
        return $result;
    }
    function getAllData()
    {
        $result = '
        <tr>
            <th class="align-left p-10">
                <h6>Title</h6>
            </th>
            <th class="align-left p-10">
                <h6>Location</h6>
            </th>
            <th class="align-left p-10">
                <h6>City</h6>
            </th>
            <th class="align-left p-10">
                <h6>Dates</h6>
            </th>
            <th class="align-left p-10">
                <h6>Image</h6>
            </th>
            <th class="align-left p-10">
                <h6>Description</h6>
            </th>
            <th class="align-left p-10">
                <h6>Edit</h6>
            </th>
        </tr>';
        $db_DATA_obj = new db_DATA($this->conn);
        $data['table'] = "event";
        $sql = $db_DATA_obj->make_SQL($data, "FETCH");
        $res = $db_DATA_obj->sql_QUERY($sql);
        if (mysqli_num_rows($res) > 0) {
            while ($f = mysqli_fetch_assoc($res)) {
                $result .= '<tr>
                <td class="p-10">
                <h6 class="fw-500">' . $f['name'] . '</h6>
                </td>
                <td class="p-10 ">
                    <h6 class="fw-500">' . $f['location'] . '</h6>
                </td>
                <td class="p-10 ">
                    <h6 class="fw-500">' . $f['city'] . '</h6>
                </td>
                <td class="p-10 ">
                    <h6 class="fw-500">' . $f['start_date'] . ' <- To -> ' . $f['end_date'] . ' </h6>
                </td>
                <td class="p-10">
                    <figure class="timg"><img src="uploaded/' . $f['img'] . '" alt=""></figure>
                </td>
                <td class="p-10 ">
                    <h6 class="fw-500">' . $f['description'] . '</h6>
                </td>

                <td class="p-10 tdroprow">
                    <h6><i class="fas fa-ellipsis-h"></i></h6>
                    <div class="tdrop-down">
                        <h6 class="fw-500 tdrop-down-row" onclick = "showFrom(' . $f['id'] . ')">Update</h6>
                        <h6 class="fw-500 tdrop-down-row" onclick = "delEvent(' . $f['id'] . ')">Delete</h6>
                    </div>
                </td>
                </tr>';
            }
        } else {
            $result .= '     <tr>
            <td class="p-10 ">
                <h6 class="fw-500">No Data Found</h6>
            </td>
            <td class="p-10 ">
                <h6 class="fw-500">No Data Found</h6>
            </td>
            <td class="p-10 ">
                <h6 class="fw-500">No Data Found</h6>
            </td>
            <td class="p-10 ">
                <h6 class="fw-500">No Data Found</h6>
            </td>
            <td class="p-10 ">
                <h6 class="fw-500">No Data Found</h6>
            </td>
            <td class="p-10 ">
                <h6 class="fw-500">No Data Found</h6>
            </td>

            <td class="p-10 tdroprow">
                <h6><i class="fas fa-ellipsis-h"></i></h6>
                <div class="tdrop-down">
                    <h6 class="fw-500 tdrop-down-row">Invalid</h6>
                    <h6 class="fw-500 tdrop-down-row">Invalid</h6>
                </div>
            </td>
            </tr>';
        }
        return $result;
    }
    function showForm($data)
    {
        $result = '<h5> Add Event</h5>

        <input type="text" id="title" placeholder="Event Title" class="input mt-20">
        <input type="text" id="location" placeholder="Location" class="input mt-20">
        <input type="text" id="city" placeholder="City" class="input mt-20">
        <h6 class="mt-20">Add Description </h6>
        <br>
        <input type="text" id="desc" name="desc" placeholder="Event Description" class="input ">
        <h6 class="mt-10">Select Image </h6>
        <input type="file" id="fileCompanylogo" class="input mt-10">
        <h6 class="mt-10">Start Date</h6>
        <input type="date" id="start_date" placeholder="Start date" class="input mt-10">
        <h6 class="mt-10">End Date</h6>
        <input type="date" id="end_date" placeholder="End date" class="input mt-10">
        <input type="hidden" id="request_Type" value="ADD">
        <h6 class="mt-20" id="result"></h6>

        <button type="submit" name="submit" class="btn-submit mt-20 color-w ">
            <h6 class="fw-400 ls-1" onclick="takePostData(this)">SUBMIT</h6>
        </button>';
        if ($data['id'] == 0) {
            return $result;
        }
        $obj = new db_DATA($this->conn);
        $res = $obj->fetch_Data("event", $data['id'], 'id');
        if (mysqli_num_rows($res) > 0) {
            $f = mysqli_fetch_assoc($res);
            $result = '
            <h5> Update Event</h5>

        <input type="text" id="title" placeholder="Event Title" class="input mt-20" value = ' . $f['name'] . '>
        <input type="text" id="location" placeholder="Location" class="input mt-20" value = ' . $f['location'] . '>
        <input type="text" id="city" placeholder="City" class="input mt-20" value = ' . $f['city'] . '>
        <h6 class="mt-20">Add Description </h6>
        <br>
        <input type="text" id="desc" name="desc" placeholder="Event Description" class="input " value = ' . strip_tags($f['description']) . '>
        <h6 class="mt-10">Select Image </h6>
        <input type="file" id="fileCompanylogo" class="input mt-10">
        <h6 class="mt-10">Start Date</h6>
        <input type="date" id="start_date" placeholder="Start date" class="input mt-10" value = ' . $f['start_date'] . '>
        <h6 class="mt-10">End Date</h6>
        <input type="date" id="end_date" placeholder="End date" class="input mt-10"  value = ' . $f['end_date'] . '>
        <input type="hidden" id="request_Type" value="UPDATE">
        <input type="hidden" id="id" value="' . $f['id'] . '">
        <h6 class="mt-20" id="result"></h6>

        <button type="submit" name="submit" class="btn-submit mt-20 color-w ">
            <h6 class="fw-400 ls-1" onclick="takePostData(this)">SUBMIT</h6>
        </button>';
        }
        return $result;
    }
    function update_PostData($data, $file)
    {

        foreach ($data as $x => $val) {
            if ($x != "myfile" && $x != "request_Type") {
                if ($x != "description") {
                    $arr[$x] = strtolower(sanitize($val));
                } else {
                    $arr[$x] = strtolower($val);
                }
            }
        }
        if (isset($file['myfile']['name'][0])) {
            $filename = check_img($file['myfile']['name'][0]);
            $arr['company_logo'] = $filename;
        }

        $db_DATA_obj = new db_DATA($this->conn);
        $res = $db_DATA_obj->update_Data($arr);
        if ($res) {
            if (isset($filename)) {
                move_uploaded_file($file['myfile']['tmp_name'][0], '../uploaded/' . $filename);
            }
        }
        $output = "Updated Successfully";
        return $output;
    }

    function show_PostFormData($table, $ID)
    {
        $output = '';
        $db_DATA_obj = new db_DATA($this->conn);
        $res = $db_DATA_obj->fetch_Data($table, $ID, "id");
        if (mysqli_num_rows($res) > 0) {
            $f = mysqli_fetch_assoc($res);
            if (strtolower($f['post_type']) == "privatejobpost" || $f['post_type'] == "campushiring") {
                $output .= '
                    <h5 class="mt-10"> Manage Private Job Post</h5>
                    <h6 class="mt-20 colo-b0 frw-600 "> Title</h6>
                    <input value="' . $f['title'] . '" type="text" id="title" placeholder="Post Title" class="input mt-10" autofocus>
                    <h6 class="mt-10 color-b0 fw-600 "> Company name</h6>
                    <input value="' . $f['name'] . '" type="text" id="companyName" placeholder="Company Name" class="input mt-10">
                    
                    <!-- Job Location -->
                    <h6 class="mt-10 color-b0 fw-600 "> Location</h6>
                   
                    <select id="location" class="input mt-10" >
                        <option value="' . $f['location'] . '">' . $f['location'] . '</option>
                        <option value="Remote">Remote</option>
                        <option value="Delhi / NCR">Delhi / NCR</option>
                        <option value="Bangalore/Bengaluru">Bangalore/Bengaluru</option>
                        <option value="Mumbai (All Areas)">Mumbai (All Areas)</option>
                        <option value="Lucknow">Lucknow</option>
                        <option value="Uttrakhand">Uttrakhand</option>
                    </select>


                    <!-- Expericence Required -->
                    <h6 class="mt-10 color-b0 fw-600 "> Experience</h6>
                   
                    <select id="experience" class="input mt-10" >
                        <option value="' . $f['experience'] . '">' . $f['experience'] . '</option>
                        <option value="0 - 1 Year Exp">0 - 1 Year Exp</option>
                        <option value="1 - 5 Year Exp">1 - 5 Year Exp</option>
                        <option value="5 - 10 Year Exp">5 - 10 Year Exp</option>
                        <option value="10 - 12 Year Exp">10 - 12 Year Exp</option>
                        <option value="12 - Above">12 - Above</option>
                    </select>
                    

                    
                    <!-- salary -->
                    <h6 class="mt-10 color-b0 fw-600 "> Salary</h6>
                  
                    <select id="salary" class="input mt-10" >
                        <option value="' . $f['salary'] . '">' . $f['salary'] . '</option>
                        <option value="0-3 Lakhs">0-3 Lakhs</option>
                        <option value="3-6 Lakhs">3-6 Lakhs</option>
                        <option value="6-10 Lakhs">6-10 Lakhs</option>
                        <option value="10-15 Lakhs">10-15 Lakhs</option>
                    </select>
                    
                    
                    <h6 class="mt-10 color-b0 fw-600 "> Vacancy</h6>
                    <input value="' . $f['vacancy'] . '" type="text" id="vacancy" placeholder="Vacancy" class="input mt-10">
                    <h6 class="mt-10 color-b0 fw-600 "> Description</h6>
                    <textarea id="desc" placeholder="Job Description" class="input mt-10" cols="10" rows="10">' . $f['description'] . '</textarea>
                    
                   
                    <input value="' . $f['tag'] . '" type="hidden" id="tag" placeholder="Post Tag" class="input mt-10">
                    <h6 class="mt-10 color-b0 fw-600 ">Job Apply Link</h6>
                    <input value="' . $f['link'] . '" type="text" id="link" placeholder="Website Link" class="input mt-10">
                    <input value="' . $f['link_title'] . '" type="hidden" id="link_title" placeholder="Website Link" class="input mt-10">
                    
                    <!-- qualification -->
                    <!-- qualification 1 -->
                    <h6 class="mt-10 color-b0 fw-600 "> Qualification 1</h6>
                    <select id="qualification" class="input mt-10" >
                        <option value="' . $f['qualification'] . '">' . $f['qualification'] . '</option>
                        <option value="MBA">MBA</option>
                        <option value="MCA">MCA</option>
                        <option value="MTech">MTech</option>
                        <option value="BTech">BTech</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Post Graduate">Post Graduate</option>
                        <option value="Graduate">Graduate</option>
                        <option value="12th Pass">12th Pass</option>
                        <option value="10th Pass">10th Pass</option>
                    </select>

                    <h6 class="mt-10 color-b0 fw-600 "> Qualification 2</h6>
                    <select id="qualification2" class="input mt-10" >
                        <option value="' . $f['qualification2'] . '">' . $f['qualification2'] . '</option>
                        <option value="MBA">MBA</option>
                        <option value="MCA">MCA</option>
                        <option value="MTech">MTech</option>
                        <option value="BTech">BTech</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Post Graduate">Post Graduate</option>
                        <option value="Graduate">Graduate</option>
                        <option value="12th Pass">12th Pass</option>
                        <option value="10th Pass">10th Pass</option>
                    </select>

                    <h6 class="mt-10 color-b0 fw-600 "> Qualification 3</h6>
                    <select id="qualification3" class="input mt-10" >
                        <option value="' . $f['qualification3'] . '">' . $f['qualification3'] . '</option>
                        <option value="MBA">MBA</option>
                        <option value="MCA">MCA</option>
                        <option value="MTech">MTech</option>
                        <option value="BTech">BTech</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Post Graduate">Post Graduate</option>
                        <option value="Graduate">Graduate</option>
                        <option value="12th Pass">12th Pass</option>
                        <option value="10th Pass">10th Pass</option>
                    </select>

                    <h6 class="mt-10 color-b0 fw-600 "> Qualification 4</h6>
                    <select id="qualification4" class="input mt-10" >
                        <option value="' . $f['qualification4'] . '">' . $f['qualification4'] . '</option>
                        <option value="MBA">MBA</option>
                        <option value="MCA">MCA</option>
                        <option value="MTech">MTech</option>
                        <option value="BTech">BTech</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Post Graduate">Post Graduate</option>
                        <option value="Graduate">Graduate</option>
                        <option value="12th Pass">12th Pass</option>
                        <option value="10th Pass">10th Pass</option>
                    </select>



                    <!-- Job type -->
                    <h6 class="mt-10 color-b0 fw-600 "> Job type</h6>
                    <select id="job_type" class="input mt-10" >
                        <option value="' . $f['job_type'] . '">' . $f['job_type'] . '</option>
                        <option value="Premium MBA">Premium MBA</option>
                        <option value="Premium Engg">Premium Engg</option>
                        <option value="Walk-in">Walk-in</option>
                        <option value="International">International</option>
                    </select>
                    <h6 class="mt-10 color-b0 fw-600 "> Company Logo</h6>
                    <input type="file" id="fileCompanylogo" placeholder="Comapny Logo" class="input mt-10">
                    <button onclick="updatePostData(' . $f['id'] . ')" id="submitBtn" class="btn-submit mt-20 color-w  "><h6 class="fw-400 ls-1">UPDATE</h6></button>
                    <h6 class="mt-10 fw-600 " id="result"></h6>
                    ';
            } else if ($f['post_type'] == "govjobpost" || $f['post_type'] == "govresultpost" || $f['post_type'] == "govanswerpost" || $f['post_type'] == "govadmitpost") {
                $output .= '
                    <h5 class="mt-10"> Manage Post</h5>
                    <h6 class="mt-20 color-b0 fw-600 "> Post Title</h6>
                    <input value="' . $f['title'] . '" type="text" id="title" placeholder="Post Title" class="input mt-10" autofocus>
                    <h6 class="mt-10 color-b0 fw-600 "> Company Name</h6>
                    <input value="' . $f['name'] . '" type="text" id="companyName" placeholder="Company Name" class="input mt-10">
                    <h6 class="mt-10 color-b0 fw-600 "> Description</h6>

                    <textarea id="desc" placeholder="Job Description" class="input mt-10" cols="10" rows="10">' . $f['description'] . '</textarea>
                    <h6 class="mt-10 color-b0 fw-600 "> Tag</h6>
                    <input value="' . $f['tag'] . '" type="text" id="tag" placeholder="Post Tag" class="input mt-10">
                    
                    <h6 class="mt-10 color-b0 fw-600 "> Link</h6>
                    <input value="' . $f['link'] . '" type="text" id="link" placeholder="Website Link" class="input mt-10">
                    
                    <h6 class="mt-10 color-b0 fw-600 "> Link Title</h6>
                    <input value="' . $f['link_title'] . '" type="text" id="link_title" placeholder="Website Link Title" class="input mt-10">
                    
                    <!-- Job type -->
                    <h6 class="mt-10 color-b0 fw-600 "> Job Type</h6>
                   <select id="job_type" class="input mt-10">
                        <option value="' . $f['job_type'] . '">' . $f['job_type'] . '</option>
                        <option value="State Govt Jobs">State Govt Jobs</option>
                        <option value="Bank Jobs">Bank Jobs</option>
                        <option value="Teaching Jobs">Teaching Jobs</option>
                        <option value="Engineering Jobs">Engineering Jobs</option>
                        <option value="Railway Jobs">Railway Jobs</option>
                        <option value="Police/Defence Jobs">Police/Defence Jobs</option>
                    </select>
                     <!-- qualification -->

                     <!-- qualification 1 -->
                    <h6 class="mt-10 color-b0 fw-600 "> Qualification 1 </h6>
                    <select id="qualification" class="input mt-10">
                        <option value="' . $f['qualification'] . '">' . $f['qualification'] . '</option>
                        <option value="MBA">MBA</option>
                        <option value="MCA">MCA</option>
                        <option value="MTech">MTech</option>
                        <option value="BTech">BTech</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Post Graduate">Post Graduate</option>
                        <option value="Graduate">Graduate</option>
                        <option value="12th Pass">12th Pass</option>
                        <option value="10th Pass">10th Pass</option>
                    </select>

                    <h6 class="mt-10 color-b0 fw-600 "> Qualification 2 </h6>
                    <select id="qualification2" class="input mt-10">
                        <option value="' . $f['qualification2'] . '">' . $f['qualification2'] . '</option>
                        <option value="MBA">MBA</option>
                        <option value="MCA">MCA</option>
                        <option value="MTech">MTech</option>
                        <option value="BTech">BTech</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Post Graduate">Post Graduate</option>
                        <option value="Graduate">Graduate</option>
                        <option value="12th Pass">12th Pass</option>
                        <option value="10th Pass">10th Pass</option>
                    </select>

                    <h6 class="mt-10 color-b0 fw-600 "> Qualification 3 </h6>
                    <select id="qualification3" class="input mt-10">
                        <option value="' . $f['qualification3'] . '">' . $f['qualification3'] . '</option>
                        <option value="MBA">MBA</option>
                        <option value="MCA">MCA</option>
                        <option value="MTech">MTech</option>
                        <option value="BTech">BTech</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Post Graduate">Post Graduate</option>
                        <option value="Graduate">Graduate</option>
                        <option value="12th Pass">12th Pass</option>
                        <option value="10th Pass">10th Pass</option>
                    </select>

                    <h6 class="mt-10 color-b0 fw-600 "> Qualification 1 </h6>
                    <select id="qualification4" class="input mt-10">
                        <option value="' . $f['qualification4'] . '">' . $f['qualification4'] . '</option>
                        <option value="MBA">MBA</option>
                        <option value="MCA">MCA</option>
                        <option value="MTech">MTech</option>
                        <option value="BTech">BTech</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Post Graduate">Post Graduate</option>
                        <option value="Graduate">Graduate</option>
                        <option value="12th Pass">12th Pass</option>
                        <option value="10th Pass">10th Pass</option>
                    </select>




                    <!-- location -->
                    <h6 class="mt-10 color-b0 fw-600 "> Location</h6>
                    <select id="location" placeholder="Job Location" class="input mt-10">
                            <option value="' . $f['location'] . '">' . $f['location'] . '</option>
                            <option value="AP Government Jobs">AP Government Jobs</option>
                            <option value="UP Government Jobs">UP Government Jobs</option>
                            <option value="MP Government Jobs">MP Government Jobs</option>
                            <option value="HP Government Jobs">HP Government Jobs</option>
                            <option value="HR Government Jobs">HR Government Jobs</option>
                            <option value="RJ Government Jobs">RJ Government Jobs</option>
                            <option value="JR Government Jobs">JR Government Jobs</option>
                            <option value="KA Government Jobs">KA Government Jobs</option>
                    </select>
                    <h6 class="mt-10 color-b0 fw-600 "> Company Logo</h6>
                    <input type="file" id="fileCompanylogo" placeholder="Comapny Logo" class="input mt-10">
                    <button onclick="updatePostData(' . $f['id'] . ')" id="submitBtn" class="btn-submit mt-20 color-w  "><h6 class="fw-400 ls-1">UPDATE</h6></button>
                   
                   
                    <input  type="hidden" id="experience" placeholder="Expericence Required" class="input mt-10" value="null">
                    <input  type="hidden" id="salary" placeholder="Salary" class="input mt-10" value="null">
                    <input  type="hidden" id="vacancy" placeholder="Vacancy" class="input mt-10" value="null">
                  

                    <h6 class="mt-10 fw-600 " id="result"></h6>
                    ';
            }
        }
        return $output;
    }

    function del_Post($table, $key, $val)
    {
        $output = '';
        $db_DATA_obj = new db_DATA($this->conn);
        $res = $db_DATA_obj->del_Data($table, $key, $val);
        if ($res) {
            $output = "Data Successfully Removed ";
        } else {
            $output = "Failed To Remove";
        }
        return $output;
    }
}
